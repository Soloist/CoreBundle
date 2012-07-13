<?php

namespace Soloist\Bundle\CoreBundle\Form\Handler;

use Doctrine\ORM\EntityManager,
    Doctrine\Common\Util\Inflector;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\Form\FormFactory,
    Symfony\Component\Form\Form,
    FPN\TagBundle\Entity\TagManager,
    DoctrineExtensions\Taggable\Taggable;

use Soloist\Bundle\CoreBundle\Node\Factory as NodeFactory,
    Soloist\Bundle\CoreBundle\Entity\Node as NodeEntity,
    Soloist\Bundle\CoreBundle\Form\Type\PageType,
    Soloist\Bundle\CoreBundle\Entity\Page;

class Node
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \Symfony\Component\Form\FormFactory
     */
    protected $factory;

    /**
     * @var \Soloist\Bundle\CoreBundle\Node\Factory
     */
    protected $nodeFactory;

    /**
     * @var FPN\TagBundle\Entity\TagManager
     */
    protected $tagManager;

    public function __construct(NodeFactory $nodeFactory, EntityManager $em, FormFactory $factory, TagManager $tagManager)
    {
        $this->em          = $em;
        $this->factory     = $factory;
        $this->nodeFactory = $nodeFactory;
        $this->tagManager  = $tagManager;
    }

    public function create(Form $form, Request $request)
    {
        $form->bindRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();

            if ($data instanceof Taggable) {

                $tags = $this->tagManager->splitTagNames($data->tagsAsText);

                $tags = $this->tagManager->loadOrCreateTags($tags);
                $this->tagManager->addTags($tags, $data);
            }

            $this->em->persist($data);
            $this->em->flush();

            $tagManager->saveTagging($data);

            return true;
        }

        return false;
    }

    public function update(Form $form, Request $request)
    {
        $data = $form->getData();
        $oldTags = null;
        if ($data instanceof Taggable) {
            $oldTags = $this->tagManager->splitTagNames($data->tagsAsText);
        }

        $form->bindRequest($request);
        if ($form->isValid()) {

            // if entity is taggable, we should remove old tags
            // and add new
            if ($data instanceof Taggable) {

                $tags = $this->tagManager->splitTagNames($data->tagsAsText);

                foreach ($tags as $key => $tag) {
                    if (!in_array($tag, $oldTags)) {
                        $currentTag = $this->tagManager->loadOrCreateTag($tag);
                        $this->tagManager->addTag($currentTag, $data);

                    } else {
                        if ($key = array_search($tag, $oldTags)) {
                            unset($oldTags[$key]);
                        }

                    }
                }

                foreach ($oldTags as $tag) {
                    $currentTag = $this->tagManager->loadOrCreateTag($tag);
                    $this->tagManager->removeTag($currentTag, $data);
                }
            }

            $this->em->flush();

            $tagManager->saveTagging($data);

            return true;
        }

        return false;
    }

    public function getCreateForm($type, $pageType = null)
    {
        $node = $this->nodeFactory->getNode($type, $pageType);

        if ($node instanceof Taggable) {
            $this->tagManager->loadTagging($node);
            $text = '';
            foreach($node->getTags() as $tag) {
                if($text !== '') {
                    $text .= ', ';
                }
                $text .= $tag->getSlug();
            }
            $node->tagsAsText = $text;
        }

        $form = $this->nodeFactory->getFormType($type);

        return $this->factory->create($form, $node);
    }

    public function getUpdateForm(NodeEntity $node)
    {
        $form = $this->nodeFactory->getFormType($node->getType(), $node);

        return $this->factory->create($form, $node);
    }
}
