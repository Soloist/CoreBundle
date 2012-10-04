<?php

namespace Soloist\Bundle\CoreBundle\Cache;

/**
 * Base cache interface
 *
 * @author Yohan Giarelli <yohan@frequence-web.fr>
 */
interface CacheInterface
{
    /**
     * @return mixed
     */
    public function get();

    /**
     * @param  mixed $value
     * @return mixed
     */
    public function set($value);

    /**
     * @return boolean
     */
    public function has();

    /**
     * @return boolean
     */
    public function remove();
}
