<?php

namespace Application\Form;

use Zend\Form\Form;

class ClientForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('client');
        $this->setAttribute('method', 'post');
        $this->setAttribute('action', '/clients');

        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type'  => 'text',
                'placeholder' =>'John Doe',
                'class' => 'form-control'
            ),
        ));
        $this->add(array(
            'name' => 'event',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type'  => 'email',
                'class' => 'form-control'
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Submit',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary',
                'form' => 'client'
            ),
        ));
    }
}