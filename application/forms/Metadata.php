<?php

class Application_Form_Metadata extends Zend_Form_Subform {
    public function init() {
//        $key = $this->addElement('text', 'key', array(
//            'filters' => array('StringTrim'),
//            'required' => true,
//            'label' => 'Key:',
//        ));

        $email = $this->addElement('text', 'email', array(
            'filters' => array('StringTrim'),
            'required' => true,
            'label' => 'Email:',
        ));

    }
}