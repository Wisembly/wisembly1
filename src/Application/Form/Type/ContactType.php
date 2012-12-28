<?php

namespace Application\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactType extends AbstractType
{
    private $translator;
    private $expanded;

    public function __construct($app, $expanded = false)
    {
        $this->translator = $app['translator'];
        $this->expanded = $expanded;
    }

    public function getName()
    {
        return 'getName';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ( $this->expanded ) {
            $builder->add('fullname', 'text', array(
                'required'  => true,
                'label'     => $this->translator->trans('abo_fullname'),
                'attr'      => array(
                    'placeholder' => $this->translator->trans('abo_fullname'),
                )
            ));
            $builder->add('company', 'text', array(
                'required'  => true,
                'label'     => $this->translator->trans('abo_company'),
                'attr'      => array(
                    'placeholder' => $this->translator->trans('abo_company'),
                )
            ));
        }

        $builder->add('email', 'email', array(
            'required'  => true,
            'label'     => $this->translator->trans('email'),
            'attr'      => array(
                'placeholder' => $this->translator->trans('contact_email'),
            )
        ));

        if ( $this->expanded ) {
            $builder->add('type', 'choice', array(
                'choices'   => array(
                    ''  => $this->translator->trans('type_of_meeting'),
                    'formations'  => $this->translator->trans('training'),
                    'séminaires'  => $this->translator->trans('seminar'),
                    'réunions'    => $this->translator->trans('meeting'),
                    'conférences' => $this->translator->trans('conference')
                ),
                'label'     => ' ',
                'required'  => true,
            ));
        }

        $builder->add('content', 'textarea', array(
            'required'  => !$this->expanded,
            'label'     => $this->expanded ? $this->translator->trans( 'abo_message') : $this->translator->trans('contact_message'),
            'attr'      => array(
                'placeholder' => $this->expanded ? $this->translator->trans( 'abo_message') : '',
            )
        ));
    }
}
