w<?php

class UsersController extends Zend_Controller_Action
{

    private $model = null;

    public function init()
    {
       $this->model = new Application_Model_DbTable_Users;
       
        
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
            if($userObj->type == '1'){
                $this -> view -> data  = $this -> model -> listAllUsers();    
            }
            else{
                $this->redirect('/');       
            }
         }
        

        
    }

    public function addAction()
    {
        //echo time();
            $data = $this->getRequest()->getParams();
            $form = new Application_Form_User();
            if($this->getRequest()->isPost()){                
                if($form->isValid($data))
                {
                    if($form->getElement('prof_pic')->receive())
                    {
                        $data['prof_pic'] = $form->getElement('prof_pic')->getValue();
                        if ($this->model->addUser($data))
                            $this->redirect('users/index');
                    }        
                }
            }

            $this->view->form = $form;
            
    }

    public function deleteAction()
    {
        
    }

    public function editAction()
    {
        $authorization = Zend_Auth::getInstance();
        if(!$authorization -> hasIdentity()) {
            $this->redirect('/users/login');
        }
        else
        {
            $userObj = $authorization->getIdentity();
            $form = new Application_Form_User();
            $form -> removeElement('prof_pic');
            $form -> removeElement('mail');
            if($user = $this->model->getUserById($userObj-> id))
            {
                $form->populate($user[0]);  
            }
            
            if($this->getRequest()->isPost()){
                    $data = $this->getRequest()->getParams();
                    
                    //var_dump($info);

                    if($form->isValid($data)){
                        if ($this->model->editUser($userObj-> id , $data))
                        {
                             $this->redirect('users/edit');
                        }
                        
                    }
                } 
                $this->view->form = $form; 
            //$this->render('form');    
        }     
    }

    public function viewAction()
    {
                
    }

    public function loginAction()
    {
                $authorization = Zend_Auth::getInstance();
                if($authorization -> hasIdentity()) {
                    $this->redirect('/');
                }
               $data = $this->getRequest()->getParams();
                $form = new Application_Form_User();
                $form -> removeElement('prof_pic');
                $form -> removeElement('gender');
                $form -> removeElement('country');
                $form -> removeElement('signature');
                $form -> removeElement('name');

                if($this->getRequest()->isPost()){
                    if($form->isValid($data)){
                        $username= $this->_request->getParam('mail');
                        $password= $this->_request->getParam('password');
                        // get the default db adapter
                        $db = Zend_Db_Table::getDefaultAdapter();
                        //create the auth adapter
                        $authAdapter = new Zend_Auth_Adapter_DbTable($db, 'users','mail', 'password');
                        //set the email and password
                        $authAdapter -> setIdentity($username);
                        $authAdapter->setCredential(md5($password));
                        //authenticate
                        $result = $authAdapter->authenticate();
                        if ($result->isValid()) {
                            //if the user is valid register his info in session
                            $auth = Zend_Auth::getInstance();
                            $storage = $auth->getStorage();
                            //de btrg3 al row kaml  w a5tar ana aly howa 3azio
                            $storage->write($authAdapter->getResultRowObject(array('id' , 'prof_pic' ,'type' , 'mail' , 'name')));
                            $this->redirect('/');
                        }else{
                            ?><div class="alert alert-danger text-center">Wrong Data</div><?php
                        }

                        /*if ($this->model->addUser($data))
                        $this->redirect('users/index');*/
                    }
                }

                $this->view->form = $form; 
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







