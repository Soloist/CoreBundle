<?php

namespace Soloist\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * The LinkType Class do some things...
 *
 * @author Yohan Giarelli <yohan@giarelli.org>
 */

class LinkType extends NodeType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('uri');
    }

    public function getName()
    {
        return 'soloist_link';
    }
}
