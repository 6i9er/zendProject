<?php

class ThreadsController extends Zend_Controller_Action
{

    private $model = null;
    private $modelSubCat = null;

    public function init()
    {
       $this->model = new Application_Model_DbTable_Threads;

        $this->modelSubCat = new Application_Model_DbTable_Subcats;
       
        
    }
//====================Index==================================

    public function indexAction()
    {
        // De Bta3t El View
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
                $this -> view -> data  = $this -> model -> listAllThreads();
            }
            else{
                $this->redirect('/');       
            }
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










