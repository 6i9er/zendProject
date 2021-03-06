<?php

class SubcatsController extends Zend_Controller_Action
{

    private $modelSubCat = null;
    private $modelThread = null;
    private $modelCategory = null;
    private $modelStatus = null;

    public function init()
    {
       $this->modelSubCat = new Application_Model_DbTable_Subcats;
       $this->modelThread = new Application_Model_DbTable_Threads;
       $this->modelComments = new Application_Model_DbTable_Comments; 

       $is_admin = 0;
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
        
        //$this -> view -> data  = $this -> modelThreads -> listAllThreads();

        
    }

    public function addAction()
    {
        // action body
    }

    public function editAction()
    {
        // action body
    }

    public function deleteAction()
    {
        // action body
    }

    public function viewAction()
    {
        $is_admin = 0;
        $is_loged = 0;
        $user_id = 0;
        $authorization = Zend_Auth::getInstance();
        if(!$authorization -> hasIdentity()) {
            //$this->redirect('/users/login');
        }
        else
        {
            // Check if user is Admin
            $userObj = $authorization-> getIdentity();
            if($userObj->type == '1'){
                $is_admin = 1;
            }
            $is_loged = 1;
            $user_id = $userObj-> id;
            
         }


                $this->view-> is_admin = $is_admin;
                $this->view-> is_loged = $is_loged;
                $this->view-> user_id = $user_id;


        $id = $this->getRequest()->getParam('id');
        if($subcat = $this-> modelSubCat->getSubCatById($id) ){
            if(($subcat[0]['is_visible'] == '1') or ($is_admin == '1') ){
                
                    $fixedThreads = $this -> modelThread -> listFixedSelectedThreads($id);
                    $unFixedThreads = $this -> modelThread -> listUnFixedSelectedThreads($id);
                    $comments= $this -> modelComments -> listAllComments();  
                    $this->view-> fixedThread = $fixedThreads;
                    $this->view-> unFixedThread = $unFixedThreads;
                    $this->view-> subCat = $subcat;
                    $this->view-> comments = $comments;
            }
            else
            {
                $this->redirect('/');   
            }
           
            /*else
            {
                $this->redirect('/');
            }*/
        }
        else
        {
            $this->redirect('/');
        }
    }


}















