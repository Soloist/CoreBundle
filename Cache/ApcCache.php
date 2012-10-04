<?php

namespace Soloist\Bundle\CoreBundle\Cache;

/**
 * APC implementation of cache
 *
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class ApcCache implements CacheInterface
{
    /**
     * @var string
     */
    protected $key;

    /**
     * @var int
     */
    protected $ttl;

    /**
     * @param string $namespace
     * @param string $key
     * @param int    $ttl
     */
    public function __construct($namespace, $key, $ttl = 3600)
    {
        $this->key = $namespace.$key;
        $this->ttl = $ttl;
    }

    /**
     * @{inheritDoc}
     */
    public function get()
    {
        return apc_fetch($this->key);
    }

    /**
     * @{inheritDoc}
     */
    public function set($value)
    {
        apc_store($this->key, $value, $this->ttl);
    }

    /**
     * @return boolean
     */
    public function has()
    {
        return apc_exists($this->key);
    }

    /**
     * @return boolean
     */
    public function remove()
    {
        return apc_delete($this->key);
    }
}
