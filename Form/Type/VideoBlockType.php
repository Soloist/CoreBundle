<?php

namespace Soloist\Bundle\CoreBundle\Form\Type;

use Soloist\Bundle\CoreBundle\Block\Video\ProviderManager;
use Symfony\Component\Form\FormBuilderInterface;

class VideoBlockType extends BlockType
{
    /**
     * @var ProviderManager
     */
    protected $manager;

    /**
     * @param ProviderManager $manager
     */
    public function __construct(ProviderManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @{inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('url', null, array('required' => false))
            ->addModelTransformer($this->manager->getModelTransformer())
        ;
    }

    /**
     * @{inheritDoc}
     */
    public function getDataClass()
    {
        return 'Soloist\Bundle\CoreBundle\Entity\VideoBlock';
    }

    /**
     * @{inheritDoc}
     */
    public function getName()
    {
        return 'soloist_block_video';
    }
}
