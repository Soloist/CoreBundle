<?php

namespace Soloist\Bundle\CoreBundle\Block\Video;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * The data transformer used for VideoBlockType
 *
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class VideoModelTransformer implements DataTransformerInterface
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
    public function transform($value)
    {
        if (null !== $value->getProvider()) {
            $value->setUrl($this->manager->reverseCompute($value->getProvider(), $value->getRef()));
        }

        return $value;
    }

    /**
     * @{inheritDoc}
     */
    public function reverseTransform($value)
    {
        if ('' !== $value->getUrl() && null !== $value->getUrl()) {
            $data = $this->manager->compute($value->getUrl());
            $value->setProvider($data['provider']);
            $value->setRef($data['ref']);
        }

        return $value;
    }
}
