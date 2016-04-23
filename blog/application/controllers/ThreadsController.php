<?php

class ThreadsController extends Zend_Controller_Action
{

    private $model = null;
    private $modelComments = null;

    public function init()
    {
       $this-> model = new Application_Model_DbTable_Threads;

        $this-> modelComments = new Application_Model_DbTable_Comments;
       
        
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

}










