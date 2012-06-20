<?php

namespace Soloist\Bundle\CoreBundle\Entity;

use HtmlTools\Helpers;

class TextBlock extends Block
{
    /**
     * @var string
     */
    protected $value;

    /**
     * @param string $value
     */
    public function setValue($value, $raw = false)
    {
        $this->value = $raw ? $value : Helpers::addHeadingsId($value);
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    public function getType()
    {
        return 'text';
    }
}
