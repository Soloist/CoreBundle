<?php

namespace Soloist\Bundle\CoreBundle\Form\Type\BlockSettings;

use Doctrine\ORM\EntityManager;
use Soloist\Bundle\CoreBundle\Entity\Page;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageShortcutType extends AbstractType implements DataTransformerInterface
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @{inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('page', 'entity', array('class'  => 'SoloistCoreBundle:Page'))
            ->add('path_image')
            ->add('description', 'textarea')
            ->addViewTransformer($this)
        ;
    }

    /**
     * @{inheritDoc}
     */
    public function getName()
    {
        return 'soloist_core_shortcut_page_block_settings';
    }

    /**
     * @{inheritDoc}
     */
    public function transform($value)
    {
        if (isset($value['page']) && is_int($value['page'])) {
            $value['page'] = $this->em->find('SoloistCoreBundle:Page', $value['page']);
        }

        return $value;
    }

    /**
     * @{inheritDoc}
     */
    public function reverseTransform($value)
    {
        if (isset($value['page']) && $value['page'] instanceof Page) {
            $value['page'] = $value['page']->getId();
        }

        return $value;
    }

    /**
     * @{inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'em' => null,
            )
        );
    }
}
