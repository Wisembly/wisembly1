<?php

namespace Guestbook\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EntryType extends AbstractType
{
    public function getName()
    {
        return 'entry';
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('content', 'textarea');
    }

    public function getDefaultOptions()
    {
        return array(
            'data_class' => 'Guestbook\\Entity\\Entry',
        );
    }
}
