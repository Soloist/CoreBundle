<?php

namespace Soloist\Bundle\CoreBundle\Block\Video;

/**
 * Manage video providers
 *
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class ProviderManager
{
    /**
     * @var array<ProviderInterface>
     */
    protected $providers;

    /**
     * @param array<ProviderInterface> $providers
     */
    public function __construct(array $providers)
    {
        foreach ($providers as $provider) {
            $this->addProvider($provider);
        }
    }

    /**
     * @param  ProviderInterface|string $provider
     *
     * @return ProviderManager
     */
    public function addProvider($provider)
    {
        if (!$provider instanceof ProviderInterface) {
            $provider = new $provider;
        }

        $this->providers[$provider->getName()] = $provider;

        return $this;
    }

    /**
     * @param  string        $url
     *
     * @return array<string>
     */
    public function compute($url)
    {
        $provider = $this->findProvider($url);

        return array(
            'provider' => $provider->getName(),
            'ref'      => $provider->compute($url)
        );
    }

    /**
     * @param  string $provider
     * @param  string $ref
     *
     * @return string
     */
    public function reverseCompute($provider, $ref)
    {
        return $this->providers[$provider]->reverseCompute($ref);
    }

    /**
     * @param  string            $url
     *
     * @return ProviderInterface
     *
     * @throws \InvalidArgumentException
     */
    public function findProvider($url)
    {
        foreach ($this->providers as $provider) {
            if ($provider->supports($url)) {
                return $provider;
            }
        }

        throw new \InvalidArgumentException(sprintf('No provider for URL "%s"', $url));
    }

    /**
     * @return VideoModelTransformer
     */
    public function getModelTransformer()
    {
        return new VideoModelTransformer($this);
    }

    /**
     * @return array<ProviderInterface>
     */
    public function getProviders()
    {
        return $this->providers;
    }
}
