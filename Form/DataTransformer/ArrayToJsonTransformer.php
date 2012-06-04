<?php

namespace Soloist\Bundle\CoreBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class ArrayToJsonTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        return is_array($value) ? json_encode($value) : null;
    }


    public function reverseTransform($value)
    {
        return $value === '' ? null : json_decode($value, true);
    }
}
