<?php

class UsersController extends Zend_Controller_Action
{

    private $model = null;

    public function init()
    {
       $this->model = new Application_Model_DbTable_Users;
    }

    public function indexAction()
    {

        $this -> view -> data  = $this -> model -> listAllUsers();


    }

    public function addAction()
    {
        $data = $this->getRequest()->getParams();
        $form = new Application_Form_User();
        if($this->getRequest()->isPost()){
                if($form->isValid($data)){
                if ($this->model->addUser($data))
                $this->redirect('/');
            }   
        }

        $this-> view -> flag = 1;
        $this-> view -> form = $form;
 //       print_r($this->view->form);
        $this->render('form');   
    }

    public function deleteAction()
    {
        $id = $this->getRequest()->getParam("id");
        if($id){
            if($this-> model -> deleteUser($id)){
                $this -> redirect('/users/index/');       
            }
            else
            {
                echo "SomeThing Wrong";
            }
        }
        else
        {
            $this -> redirect('/users/index/');
        }
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $form = new Application_Form_User();
        $form -> removeElement('password');
        if($user = $this->model->getUserById($id))
        {
            $form->populate($user[0]);
            
            
           
             
        }
        else
        {
            echo "No Users Found With This Data";
        }
        if($this->getRequest()->isPost()){
                $info = $this->getRequest()->getParams();
                
                //var_dump($info);

                if($form->isValid($info)){
                    if ($this->model->editUser($id , $info))
                    {
                         $this->redirect('users/index');
                    }
                }
            } 
            $this->view->form = $form; 
        $this->render('form'); 
        
    }


}







