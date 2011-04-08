<?php
class Application_Form_Registration extends Zend_Form {
    public function init() {
    // Create user sub form: username and password
        $user = new Zend_Form_SubForm();
        $user->addElements(array(
            new Zend_Form_Element_Text('username', array(
            'required'   => true,
            'label'      => 'Username:',
            'filters'    => array('StringTrim', 'StringToLower'),
            'validators' => array(
            'Alnum',
            array('Regex',
            false,
            array('/^[a-z][a-z0-9]{2,}$/'))
            )
            )),

            new Zend_Form_Element_Password('password', array(
            'required'   => true,
            'label'      => 'Password:',
            'filters'    => array('StringTrim'),
            'validators' => array(
            'NotEmpty',
            array('StringLength', false, array(6))
            )
            )),
        ));

        //remove all labels
        $user->getElement('username')->removeDecorator('label');
        $user->getElement('password')->removeDecorator('label');

    
        $data = new Application_Form_Data();
        

        // Create mailing lists sub form
        $listOptions = array(
            'none'        => 'No lists, please',
            'fw-general'  => 'Zend Framework General List',
            'fw-mvc'      => 'Zend Framework MVC List',
            'fw-auth'     => 'Zend Framwork Authentication and ACL List',
            'fw-services' => 'Zend Framework Web Services List',
        );
        $lists = new Zend_Form_SubForm();
        $lists->addElements(array(
            new Zend_Form_Element_MultiCheckbox('subscriptions', array(
            'label'        =>
            'Which lists would you like to subscribe to?',
            'multiOptions' => $listOptions,
            'required'     => true,
            'filters'      => array('StringTrim'),
            'validators'   => array(
            array('InArray',
            false,
            array(array_keys($listOptions)))
            )
            )),
        ));

        // Attach sub forms to main form
        $this->addSubForms(array(
            'user'  => $user,
            'data' => $data,
            'lists' => $lists
        ));
    }

    /**
     * Prepare a sub form for display
     *
     * @param  string|Zend_Form_SubForm $spec
     * @return Zend_Form_SubForm
     */
    public function prepareSubForm($spec) {
        if (is_string($spec)) {
            $subForm = $this->{$spec};
        } elseif ($spec instanceof Zend_Form_SubForm) {
            $subForm = $spec;
        } else {
            throw new Exception('Invalid argument passed to ' .
                __FUNCTION__ . '()');
        }
        $this->addSubmitButton($subForm)
            ->setSubFormDecorators($subForm)
            ->addSubFormActions($subForm);
        return $subForm;
    }

    /**
     * Add form decorators to an individual sub form
     *
     * @param  Zend_Form_SubForm $subForm
     * @return My_Form_Registration
     */
    public function setSubFormDecorators(Zend_Form_SubForm $subForm) {
        $subForm->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl',
            'class' => 'zend_form')),
            'Form',
        ));

        if ($subForm->getName() == 'data') {
        $subForm->setDecorators(array(
          array('ViewScript', array('viewScript' => 'data.phtml')),
        ));
        }
        
        if ($subForm->getName() == 'user') {
            $subForm->setDecorators(array(
              'PrepareElements',
              array('ViewScript', array('viewScript' => 'user.phtml')),
            ));

        }

        if ($subForm->getName() == 'lists') {
            $subForm->setDecorators(array(
              'PrepareElements',
              array('ViewScript', array('viewScript' => 'lists.phtml')),
            ));

        }

        return $this;
    }

    /**
     * Add a submit button to an individual sub form
     *
     * @param  Zend_Form_SubForm $subForm
     * @return My_Form_Registration
     */
    public function addSubmitButton(Zend_Form_SubForm $subForm) {
        $subForm->addElement(new Zend_Form_Element_Submit(
            'save',
            array(
            'label'    => 'Save and continue',
            'required' => false,
            'ignore'   => true,
            )
        ));
        return $this;
    }

    /**
     * Add action and method to sub form
     *
     * @param  Zend_Form_SubForm $subForm
     * @return My_Form_Registration
     */
    public function addSubFormActions(Zend_Form_SubForm $subForm) {
        $subForm->setAction('/registration/process')
            ->setMethod('post');
        return $this;
    }

}
?>