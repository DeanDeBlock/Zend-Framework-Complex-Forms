<?php
 
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
	protected function _initAutoload()
    {
    	/* 
    	 * If you don't register namespace
    	 * You will get error :
    	 * Fatal error: Class 'Example_Controller_Plugin_Param' not found in
    	 * ...\library\Zend\Application\Resource\Frontcontroller.php on line 92
    	 *
    	 */

    	$autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('My_');
        $autoloader->suppressNotFoundWarnings(true);

        /*
         * also you will get Exception :
         * No entry is registered for key 'Zend_Request_Example'
         * called in helper ParamHelper.php
         *
         */

    }

    protected function _initPlugins() {
        $loader = new Zend_Loader_Autoloader_Resource (array (
            'basePath' => APPLICATION_PATH,
            'namespace' => 'Application',
        ));

        $loader -> addResourceType ( 'model', 'models', 'Model');
        $loader -> addResourceType ( 'form', 'forms', 'Form');
        $loader -> addResourceType ( 'mapper', 'mappers', 'Mapper');
    }

    function _initViewHelpers() {
        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();

        ZendX_JQuery::enableView($view);
    }

}

