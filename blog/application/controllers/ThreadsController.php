<?php

class ThreadsController extends Zend_Controller_Action
{

    private $model = null;
    private $modelComments = null;
    private $modelStatus = null;

    public function init()
    {
       $this-> model = new Application_Model_DbTable_Threads;
       $this-> modelSubCat = new Application_Model_DbTable_Subcats;
        $this-> modelComments = new Application_Model_DbTable_Comments;

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
//====================Index==================================

    public function indexAction()
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



        $id = $this->getRequest()->getParam('id');
        if($thread = $this-> model->getThreadById($id) ){
            
         //echo();
                $data = $this->getRequest()->getParams();
                $form = new Application_Form_Comments();
                if($this->getRequest()->isPost()){                
                    if($form->isValid($data))
                    {
                        if ($this->modelComments->addComment($data , $id , $user_id ))
                            $this->redirect('threads/index/id/'.$id);        
                    }
                }
                 $comments= $this-> modelComments -> listSelectedComments($thread[0]['id']);  
                $this->view-> thread = $thread;
                $this->view-> comments = $comments;
                $this->view-> is_admin = $is_admin;
                $this->view-> is_loged = $is_loged;
                $this->view-> user_id = $user_id;
                $this->view-> form = $form;
            
        }
        else
        {
            $this->redirect('/');
        }
        
    }





//====================Add Thread==================================

    public function addAction()
    {



        $authorization = Zend_Auth::getInstance();
        if(!$authorization -> hasIdentity()) {
            $this->redirect('/users/login');
        }
        else
        {

            // Check if user is Admin
                $userObj = $authorization->getIdentity();
            $id = $this->getRequest()->getParam('id');
            if($subcat = $this-> modelSubCat->getSubCatById($id)){
                // 3ak3ak
                if(($subcat[0]['is_locked'] == '1') or ($userObj-> type == '1')){
                    $data = $this->getRequest()->getParams();
                    $form = new Application_Form_Threads();
                    if($this->getRequest()->isPost()){
                        if($form->isValid($data))
                        {
                            $data['picture'] = '';
                            if($form->getElement('picture')->receive())
                            {
                                $data['picture'] = $form->getElement('picture')->getValue();

                            }

                            if ($this->model->addThread($data , $userObj -> id , $id))
                                $this->redirect('threads/index');
                        }
                    }
                }
                else
                {
                    $this->redirect('/');
                }

                    $this->view->form = $form;

            }
            else
            {
                $this->redirect('/');
            }

        }


            
    }

//====================Delete Thread==================================

    public function deleteAction()
    {
        $authorization = Zend_Auth::getInstance();
        if(!$authorization -> hasIdentity()) {
            $this->redirect('/users/login');
        }
        else
        {
            // Check if user is Admin
            $userObj = $authorization->getIdentity();
            $id = $this->getRequest()->getParam('id');

            if($subcat = $this-> model->getThreadById($id)){

                if ($this->model->deleteThread($id))
                {
                    $this->redirect('threads/index');
                }

            }
            else
            {
                $this->redirect('/');
            }

        }
    }

//====================Edit Thread==================================

    public function editAction()
    {

        $authorization = Zend_Auth::getInstance();
        if(!$authorization -> hasIdentity()) {
            $this->redirect('/users/login');
        }
        else
        {
            // Check if user is Admin
            $userObj = $authorization->getIdentity();
            $id = $this->getRequest()->getParam('id');
            $form = new Application_Form_Threads();
            $form -> removeElement('attach');
            //$form -> removeElement('password');
            if($subcat = $this-> model->getThreadById($id)){

                $data = $this->getRequest()->getParams();

                $form->populate($subcat[0]);


                if($this->getRequest()->isPost()){
                    if($form->isValid($data))
                    {
                        $data['picture'] = $subcat[0]['attach'];
                        if($form->getElement('picture')->receive())
                        {
                            $data['picture'] = $form->getElement('picture')->getValue();

                        }
                        if ($this->model->editThread($userObj -> id , $data))
                        {
                            $this->redirect('threads/index');
                        }

                    }
                }

                $this->view->form = $form;

            }
            else
            {
                $this->redirect('/');
            }

        }

    }

    public function viewAction()
    {
                
    }


    public function closedAction()
    {
        //On every init() of controlleryou have to check is authenticated or not
        $authorization = Zend_Auth::getInstance();
        if(!$authorization -> hasIdentity()) {
            $this->redirect('/users/login');
        }
        else
        {
            // Check if user is Admin
            $userObj = $authorization->getIdentity();
            if($userObj->type == '1'){
                //$this -> view -> data  = $this -> model -> listAllUsers();    
                // Get User Id
                $id = $this->getRequest()->getParam('id');
                $subcat = $this->getRequest()->getParam('subcat');
                if($thread = $this->model->getThreadById($id)){
                    
                    $this->model->closeThread($id);
                    $this->redirect('/subcats/view/id/'.$subcat);
                }
                else
                {
                    $this->redirect('/');
                }
            }
            else{
                $this->redirect('/');       
            }
         }
    }


    public function uncloseAction()
    {
        //On every init() of controlleryou have to check is authenticated or not
        $authorization = Zend_Auth::getInstance();
        if(!$authorization -> hasIdentity()) {
            $this->redirect('/users/login');
        }
        else
        {
            // Check if user is Admin
            $userObj = $authorization->getIdentity();
            if($userObj->type == '1'){
                //$this -> view -> data  = $this -> model -> listAllUsers();    
                // Get User Id
                $id = $this->getRequest()->getParam('id');
                $subcat = $this->getRequest()->getParam('subcat');
                if($thread = $this->model->getThreadById($id)){
                    
                    $this->model->uncloseThread($id);
                    $this->redirect('/subcats/view/id/'.$subcat);
                }
                else
                {
                    $this->redirect('/');
                }
            }
            else{
                $this->redirect('/');       
            }
         }
    }

    public function fixedAction()
    {
        //On every init() of controlleryou have to check is authenticated or not
        $authorization = Zend_Auth::getInstance();
        if(!$authorization -> hasIdentity()) {
            $this->redirect('/users/login');
        }
        else
        {
            // Check if user is Admin
            $userObj = $authorization->getIdentity();
            if($userObj->type == '1'){
                //$this -> view -> data  = $this -> model -> listAllUsers();    
                // Get User Id
                $id = $this->getRequest()->getParam('id');
                $subcat = $this->getRequest()->getParam('subcat');
                if($thread = $this->model->getThreadById($id)){
                    
                    $this->model->fixedThread($id);
                    $this->redirect('/subcats/view/id/'.$subcat);
                }
                else
                {
                    $this->redirect('/');
                }
            }
            else{
                $this->redirect('/');       
            }
         }
    }


    public function unfixedAction()
    {
        //On every init() of controlleryou have to check is authenticated or not
        $authorization = Zend_Auth::getInstance();
        if(!$authorization -> hasIdentity()) {
            $this->redirect('/users/login');
        }
        else
        {
            // Check if user is Admin
            $userObj = $authorization->getIdentity();
            if($userObj->type == '1'){
                //$this -> view -> data  = $this -> model -> listAllUsers();    
                // Get User Id
                $id = $this->getRequest()->getParam('id');
                $subcat = $this->getRequest()->getParam('subcat');
                if($thread = $this->model->getThreadById($id)){
                    
                    $this->model->unfixedThread($id);
                    $this->redirect('/subcats/view/id/'.$subcat);
                }
                else
                {
                    $this->redirect('/');
                }
            }
            else{
                $this->redirect('/');       
            }
         }
    }

}










