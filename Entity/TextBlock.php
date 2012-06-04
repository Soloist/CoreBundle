<?php

namespace Soloist\Bundle\CoreBundle\Entity;

class TextBlock extends Block
{
    /**
     * @var string
     */
    protected $value;

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
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
