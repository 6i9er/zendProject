<?php

class SiteController extends Zend_Controller_Action
{
	private $modelSubCat = null;
    private $modelThread = null;
    private $modelCategory = null;
    private $modelStatus = null;

    public function init()
    {
        $is_admin = 0;
       $this->modelSubCat = new Application_Model_DbTable_Subcats;
       $this->modelThread = new Application_Model_DbTable_Threads;
       $this->modelCategory = new Application_Model_DbTable_Categories;

       
        
    }

    public function indexAction()
    {
    	
    }


}

