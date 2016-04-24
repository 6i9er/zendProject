<?php

class IndexController extends Zend_Controller_Action
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

       /*3a3ak */

       $this->modelStatus = new Application_Model_DbTable_Site;
        $auth = Zend_Auth::getInstance();
            if($auth -> hasIdentity()){
                $userObj = $auth->getIdentity();
                if($userObj->type == 1)
                {
                    $is_admin =1;
                }
            }

        $status = $this-> modelStatus->getStatusById(1);
               if($status[0]['value'] == 1 or $is_admin == 1){
               }
               else
               {
                 $this->redirect('site/');
               }
       
        
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

