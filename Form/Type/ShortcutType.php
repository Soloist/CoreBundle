<?php

namespace Soloist\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * The PageType Class do some things...
 *
 * @author Yohan Giarelli <yohan@giarelli.org>
 */

class ShortcutType extends NodeType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('node');
    }

    public function getName()
    {
        return 'soloist_shortcut';
    }
}
