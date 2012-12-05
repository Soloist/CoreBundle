<?php

namespace Soloist\Bundle\CoreBundle\Cache;

/**
 * BlackHole implementation of cache
 *
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
class NullCache implements CacheInterface
{
    /**
     * @{inheritDoc}
     */
    public function get()
    {
        return null;
    }

    /**
     * @{inheritDoc}
     */
    public function set($value)
    {
    }

    /**
     * @return boolean
     */
    public function has()
    {
        return false;
    }

    /**
     * @return boolean
     */
    public function remove()
    {
        return true;
    }
}
