<?php

class IndexController extends Zend_Controller_Action
{
	private $modelSubCat = null;
    private $modelThread = null;
    private $modelCategory = null;

    public function init()
    {
       $this->modelSubCat = new Application_Model_DbTable_Subcats;
       $this->modelThread = new Application_Model_DbTable_Threads;
       $this->modelCategory = new Application_Model_DbTable_Categories;
       
        
    }

    public function indexAction()
    {
    	// Check if there is Categories and Visible
        if($cat = $this->modelCategory->listVisibleCats()){
            // Found user
            $subcat = $this->modelSubCat->listVisibleSubCats();
            $threads = $this->modelThread->listAllThreads(); 
            $this->view-> category = $cat;
            $this->view-> thread = $threads;
            $this->view-> subCat = $subcat;
        }
        else
        {
            $this->redirect('/');
        }
    }


}

