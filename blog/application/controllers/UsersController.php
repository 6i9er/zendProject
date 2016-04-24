w<?php

class UsersController extends Zend_Controller_Action
{

    private $model = null;
    private $modelStatus = null;

    public function init()
    {
       $this->model = new Application_Model_DbTable_Users;
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
                        $data['prof_pic'] = "";
                        if($form->getElement('prof_pic')->receive())
                        {
                            $data['prof_pic'] = $form->getElement('prof_pic')->getValue();
                            
                        }
                        if(!$this->model->checkMail($data['mail'])){
                            if ($this->model->addUser($data))
                            {
                                    $this->redirect('users/index');        
                            }    
                        }
                        else
                        {
                            ?>
                                <div class="alert alert-danger text-center">Sorry This Email Exist</div>
                            <?php
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
            $form -> removeElement('mail');
            if($user = $this->model->getUserById($userObj-> id))
            {
                $form->populate($user[0]);  
            
                
                if($this->getRequest()->isPost()){
                    $data = $this->getRequest()->getParams();
                    



                    //var_dump($info);

                    if($form->isValid($data)){
                       
                           $data['prof_pic'] = $user[0]['prof_pic'];
                            if($form->getElement('prof_pic')->receive())
                            {
                                $data['prof_pic'] = $form->getElement('prof_pic')->getValue();
                                
                            }
                            if ($this->model->editUser($userObj-> id , $data))
                            {
                                 $this->redirect('users/edit');
                            }

                        
                    }
                } 
                    $this->view->form = $form; 
            }
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
                    //$this->redirect('/');
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
                             //var_dump($result);
                            $mail = $this->model->checkMail($username);
                            if($mail[0]['is_blocked'] == 0){
                                      
                                $auth = Zend_Auth::getInstance();
                                $storage = $auth->getStorage();
                                //de btrg3 al row kaml  w a5tar ana aly howa 3azio
                                $storage->write($authAdapter->getResultRowObject(array('id' , 'prof_pic' ,'type' , 'mail' , 'name')));
                                $this->model->updateLogin($mail[0]['id']);
                                $this->redirect('/');
                            }
                            else{
                            ?><div class="alert alert-danger text-center">Sorry This User Is Blocked</div><?php
                            }
                        }else{
                            ?><div class="alert alert-danger text-center">Wrong Data</div><?php
                        }

                        /*if ($this->model->addUser($data))
                        $this->redirect('users/index');*/
                    }
                }

                $this->view->form = $form; 
    }

    public function logoutAction()
    {
        //On every init() of controlleryou have to check is authenticated or not
        $authorization = Zend_Auth::getInstance();
        if(!$authorization -> hasIdentity()) {
            $this->redirect('/users/login');
        }
        else
        {
            // Check if user is Admin
            $authorization->clearIdentity();
                $this->redirect('/');       
            
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







