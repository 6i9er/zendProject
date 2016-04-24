<?php

class MsgsController extends Zend_Controller_Action
{

    private $model = null;
    private $modelStatus = null;
    private $modelUser = null;

    public function init()
    {
       $this->model = new Application_Model_DbTable_Msgs;
       $this->modelUser = new Application_Model_DbTable_Users;
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
        //On every init() of controlleryou have to check is authenticated or not
        $authorization = Zend_Auth::getInstance();
        if(!$authorization -> hasIdentity()) {
            $this->redirect('/users/login');
        }
        else
        {
            // Check if user is Admin
            $userObj = $authorization->getIdentity();
            
                $this -> view -> data  = $this -> model -> listAll($userObj->mail);    
            
         }
        

        
    }

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
        //echo time();
            $data = $this->getRequest()->getParams();
            $form = new Application_Form_msgs();
            if($this->getRequest()->isPost()){                
                if($form->isValid($data))
                {
                        
                        if($this->modelUser->checkMail($data['email'])){
                            if ($this->model->insertMsg($data , $userObj-> mail))
                            {
                                    $this->redirect('msgs/');        
                            }    
                        }
                        else
                        {
                            ?>
                                <div class="alert alert-danger text-center">Sorry This Email Not Exist</div>
                            <?php
                        }
                }
            }

            $this->view->form = $form;
        }    
    }

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

            if($msgs = $this-> model->getMsgById($id)){

                if ($this->model->deleteMsg($id))
                {
                    $this->redirect('msgs/');
                }

            }
            else
            {
                $this->redirect('/');
            }

        }
    }
}



/*$auth = Zend_Auth::getInstance();
    if($auth -> hasIdentity()){
        $userObj = $auth->getIdentity();
    }

    $userObj ->id da al id ;
    $userObj ->type da al type w hakaza ;
    clearIdentity

*/







    