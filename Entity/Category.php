<?php

namespace Soloist\Bundle\CoreBundle\Entity;

class Category extends Node
{
    public function getType()
    {
        return 'category';
    }
}
