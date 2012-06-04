<?php

namespace Soloist\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Soloist\Bundle\CoreBundle\Event\RequestAction,
    Soloist\Bundle\CoreBundle\Form\Type\PageType,
    Soloist\Bundle\CoreBundle\Entity\Node,
    Soloist\Bundle\CoreBundle\Events;

class AdminController extends Controller
{
    /**
     * @Template
     */
    public function indexAction()
    {
        $this->addBaseBreadcrumb(false);

        return array('nodes' => $this->getNodeRepository()->findAllOrderedByLeft());
    }

    /**
     * @Template
     */
    public function newAction($type)
    {
        $this->addBaseBreadcrumb()->add('Nouveau noeud');
        $form = $this->getFormHandler()->getCreateForm($type);

        return array('form' => $form->createView(), 'type' => $type, 'node' => $form->getData());
    }

    /**
     * @Template
     */
    public function editAction(Node $node)
    {
        $this->addBaseBreadcrumb()->add('Editer le noeud : '.$node->getTitle());

        return array('form' => $this->getFormHandler()->getUpdateForm($node)->createView(), 'node' => $node);
    }

    /**
     * @Template("SoloistCoreBundle:Admin:new.html.twig")
     */
    public function createAction(Request $request, $type)
    {
        $this->addBaseBreadcrumb()->add('Nouveau noeud');

        $handler = $this->getFormHandler();
        $form    = null;

        if ('page' == $type) {
            $data = $request->request->get('soloist_page');
            $form = $this->getFormHandler()->getCreateForm('page', $data['pageType']);
        } else {
            $form = $handler->getCreateForm($type);
        }

        if ($handler->create($form, $request)) {
            $this->get('session')->setFlash('success', 'Le noeud a été créé avec succès');

            return $this->redirectIndex();
        }

        return array('form' => $form->createView(), 'type' => $type, 'node' => $form->getData());
    }

    /**
     * @Template("SoloistCoreBundle:Admin:edit.html.twig")
     */
    public function updateAction(Node $node, Request $request)
    {
        $this->addBaseBreadcrumb()->add('Editer le noeud : '.$node->getTitle());

        $handler = $this->getFormHandler();
        $form    = $handler->getUpdateForm($node);

        if ($handler->update($form, $request)) {
            $this->get('session')->setFlash('success', 'Le noeud a été modifié avec succès');

            return $this->redirectIndex();
        }

        return array('form' => $form->createView(), 'node' => $node);
    }

    public function deleteAction(Node $node)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($node);
        $em->flush();
        $this->get('session')->setFlash('success', 'Le noeud a été supprimé avec succès');

        return $this->redirectIndex();
    }

    public function retrieveBlockFormAction(Request $request)
    {
        $data = $request->request->get('soloist_page');
        $form = $this->getFormHandler()->getCreateForm('page', $data['pageType']);
        $form->bindRequest($request);

        return $this->render(
            $this->get('soloist.block.factory')->getPageFormTemplate($data['pageType']),
            array('form' => $form->createView(), 'node' => $form->getData())
        );
    }

    public function retrieveActionsAction()
    {
        $event = new RequestAction;
        $this->get('event_dispatcher')->dispatch(Events::onRequestAction, $event);

        return new Response(
            json_encode(array('actions' => $event->getActions())),
            200,
            array(
                'Content-Type' => 'application/json'
            )
        );
    }

    /**
     * @return \FrequenceWeb\Bundle\DashboardBundle\Breadcrumbs\Manager
     */
    protected function addBaseBreadcrumb($linkList = true)
    {
        $params = array();
        if (true === $linkList) {
            $params  = array('route' => 'soloist_admin_node_index');
        }

        return $this->get('fw_breadcrumbs')
            ->add('Tableau de bord', array('route' => 'fw_dashboard_index'))
            ->add('Gestion du menu', $params);
    }

    protected function redirectIndex()
    {
        return $this->redirect($this->generateUrl('soloist_admin_node_index'));
    }

    /**
     * @return \Soloist\Bundle\CoreBundle\Form\Handler\Node
     */
    protected function getFormHandler()
    {
        return $this->get('soloist.node.form.handler');
    }

    /**
     * @return \Soloist\Bundle\CoreBundle\Entity\Repository\Node
     */
    protected function getNodeRepository()
    {
        return $this->getDoctrine()->getEntityManager()->getRepository('SoloistCoreBundle:Node');
    }
}
