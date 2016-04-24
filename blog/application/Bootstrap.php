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
		//$view->headLink()->appendStylesheet($view->baseUrl().'http://netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css');
		$view->headLink()->appendStylesheet($view->baseUrl().'/css/templatemo_style.css');
		$view->headLink()->appendStylesheet($view->baseUrl().'/css/jssocials-theme-flat.css');
		$view->headLink()->appendStylesheet($view->baseUrl().'/css/jssocials.css');
		// Set the initial JS to load:
		$view->headScript()->prependFile($view->baseUrl().'/js/jquery-1.12.0.min.js');
		$view->headScript()->appendFile($view->baseUrl().'/js/bootstrap.min.js');
		$view->headScript()->appendFile($view->baseUrl().'/js/ckeditor.js');
		$view->headScript()->appendFile($view->baseUrl().'/js/jssocials.min.js');
		$view->headScript()->appendFile($view->baseUrl().'/js/share.js');

		

	}


	//To activate session
	protected function _initSession(){
		Zend_Session::start();
		$session = new Zend_Session_Namespace( 'Zend_Auth' );
		$session->setExpirationSeconds( 1800 );
		
	}

}




