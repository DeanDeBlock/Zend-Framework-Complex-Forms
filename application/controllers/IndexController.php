<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */

    }

    function indexAction() {

            $this->_helper->redirector->gotoRoute(array(
                'controller' => 'registration', 'action' => 'index'
            ));
     
    }
}
