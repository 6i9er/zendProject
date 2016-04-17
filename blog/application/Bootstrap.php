<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initSetupBaseUrl() {
	    $this->bootstrap('frontcontroller');
	    $controller = Zend_Controller_Front::getInstance();
	    $controller->setBaseUrl('/zendProject/blog/public/'); 
	}


	protected function _initPlaceholders()
	{
		$this->bootstrap('View');
		$view = $this->getResource('View');
		$view->doctype('XHTML1_STRICT');
		//Meta
		$view->headMeta()->appendName('keywords', 'framework, PHP')->appendHttpEquiv('Content-Type','text/html;charset=utf-8');
		// Set the initial title and separator:
		$view->headTitle('OS Site')->setSeparator(' | ');
		// Set the initial stylesheet:
		$view->headLink()->prependStylesheet($view->baseUrl().'/css/bootstrap.min.css');
		$view->headLink()->appendStylesheet($view->baseUrl().'/css/templatemo_style_fix_menu.css');
		$view->headLink()->appendStylesheet($view->baseUrl().'/css/bootstrap-responsive.min.css');
		$view->headLink()->appendStylesheet($view->baseUrl().'http://netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css');
		$view->headLink()->appendStylesheet($view->baseUrl().'/css/templatemo_style.css');
		// Set the initial JS to load:
		$view->headScript()->prependFile('http://code.jquery.com/jquery-latest.js');
		$view->headScript()->appendFile('js/bootstrap.min.js');
	}

}




