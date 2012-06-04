<?php

namespace Soloist\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;

use Doctrine\ORM\EntityManager;

use Soloist\Bundle\CoreBundle\Block\Factory;

/**
 * The PageType Class do some things...
 *
 * @author Yohan Giarelli <yohan@giarelli.org>
 */

class PageType extends NodeType
{
    /**
     * @var \Soloist\Bundle\CoreBundle\Block\Factory
     */
    protected $factory;

    public function __construct(EntityManager $em, Factory $factory)
    {
        parent::__construct($em);
        $this->factory = $factory;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('pageType', 'choice', array(
                'choice_list' => new SimpleChoiceList($this->factory->getPageTypes())
            ))
            ->add('blocks', new BlockCollectionType, array('block_factory' => $this->factory))
        ;
    }

    public function getName()
    {
        return 'soloist_page';
    }
}
