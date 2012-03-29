<?php

namespace Application\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ContactType extends AbstractType
{
    public function getName()
    {
        return 'getName';
    }
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('email');
        $builder->add('content');
    }
}
