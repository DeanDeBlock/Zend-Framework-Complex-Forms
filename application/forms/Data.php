<?php

class Application_Form_Data extends Zend_Form_SubForm {

    public function isValid($data) {
        Zend_Debug::dump($data);
        $subform = $this->getSubForm('new');
        // make sure new is array (won't be in $data if nothing submitted)
        if (!isset($data['data']['new'])) {
            $data['data']['new'] = array();
        }

        foreach ($data['data']['new'] as $idx => $values) {
            $metaform = new Application_Form_Metadata();
            $subform->addSubForm($metaform, (string) $idx);//->setElementsBelongTo('data[new]');
        }
        
        // call parent, which will populate newly created elements.
        return parent::isValid($data);
    }


    public function init() {

        $hiddenId = $this->addElement('hidden', 'id', array(
            'id' => 'counter',
            'value' => 1,
            'ignore' => true,
        ));

        $project = $this->addElement('text', 'firstName', array(
            'required' => true,
            'label' => 'First Name:',
        ));

        $project = $this->addElement('text', 'lastName', array(
            'required' => true,
            'label' => 'Last Name:',
        ));

        //remove all labels
        $project->getElement('firstName')->removeDecorator('label');
        $project->getElement('lastName')->removeDecorator('label');

        $this->setElementsBelongTo('data');

        $this->addSubForm(
            new Zend_Form_SubForm(),
            'metadata'
        );

        $this->addSubForm(
            new Zend_Form_SubForm(),
            'new'
        );

        //cloning the default one. rename via js to new...
        $default = new Zend_Form_SubForm();
        
        $this->addSubForm($default, 'default');
        $subform = new Application_Form_Metadata();
        $this->default->addSubForm($subform, "base");
        $this->default->base->email->setRequired(false);

        $default->setElementsBelongTo('data[default]');
        $this->getSubForm('new')->setElementsBelongTo('data[new]');
        $this->getSubForm('metadata')->setElementsBelongTo('data[metadata]');
        $this->getSubForm('default')->setElementsBelongTo('data[default]');
        
        $button = $this->addElement('button', 'button', array(
            'id' => 'omg',
            'required' => false,
            'ignore' => true,
            'label' => 'add email address',
        ));

    }
}