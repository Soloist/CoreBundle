<?php

namespace Soloist\Bundle\CoreBundle\Form\Type\BlockSettings;

use Soloist\Bundle\CoreBundle\Entity\Page;

use Symfony\Component\Form\DataTransformerInterface,
    Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface;

use Doctrine\ORM\EntityManager;

class PageShortcutType extends AbstractType implements DataTransformerInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->appendClientTransformer($this)
            ->add('page', 'entity', array(
                'class'  => 'SoloistCoreBundle:Page'
            ))
        ;
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
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

    public function getDefaultOptions()
    {
        return array(
            'em' => null
        );
    }


}
