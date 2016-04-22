<?php

class AdminController extends Zend_Controller_Action
{

   	private $model = null;
    private $modelSubCat = null;
    private $modelThread = null;
    private $modelCategory = null;

    public function init()
    {
       $this->model = new Application_Model_DbTable_Users;
       $this->modelSubCat = new Application_Model_DbTable_Subcats;
       $this->modelThread = new Application_Model_DbTable_Threads;
       $this->modelCategory = new Application_Model_DbTable_Categories;
       
        
    }
/***********************************************************************************************
************************************************************************************************
************************ Users Block ***********************************************************
************************************************************************************************
***********************************************************************************************/

    //Select All Users
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


    // Add New User
    public function adduserAction()
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
                

            	$data = $this->getRequest()->getParams();
	            $form = new Application_Form_User();
	            if($this->getRequest()->isPost()){                
	                if($form->isValid($data))
	                {
	                    if($form->getElement('prof_pic')->receive())
	                    {
	                        $data['prof_pic'] = $form->getElement('prof_pic')->getValue();
	                        if ($this->model->addUser($data))
	                            $this->redirect('admin/');
	                    }        
	                }
	            }

	            $this->view->form = $form;


            }
            else{
                $this->redirect('/');       
            }
         }
    }

    public function viewuserAction()
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
            	if($user = $this->model->getUserById($id)){
            		// Found user
            		$this->view-> form = $user;
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

    public function edituserAction()
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
            // Create Form Object
            $form = new Application_Form_User();
            $form -> removeElement('prof_pic');
            $form -> removeElement('mail');
            $form -> removeElement('password');
            if($userObj->type == '1'){
                //$this -> view -> data  = $this -> model -> listAllUsers();    
                // Get User Id
                $id = $this->getRequest()->getParam('id');
                if($user = $this->model->getUserById($id)){
                    // Found user
                    $form->populate($user[0]);
                }
                else
                {
                    $this->redirect('/');
                }


                if($this->getRequest()->isPost()){
                    $data = $this->getRequest()->getParams();
                    
                    //var_dump($info);

                    if($form->isValid($data)){
                        if ($this->model->editAdminUser($id, $data))
                        {
                             $this->redirect('admin/');
                        }
                        
                    }
                } 
                $this->view->form = $form;
            }
            else{
                $this->redirect('/');       
            }
         }
    }


    public function blockuserAction()
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
                if($user = $this->model->getUserById($id)){
                    // Found user
                    $this->model->blockUser($id);
                    $this->redirect('/admin');
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

    public function unblockuserAction()
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
                if($user = $this->model->getUserById($id)){
                    // Found user
                    $this->model->unblockUser($id);
                    $this->redirect('/admin');
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


    public function setadminAction()
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
                if($user = $this->model->getUserById($id)){
                    // Found user
                    $this->model->setAdmin($id);
                    $this->redirect('/admin');
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

    public function setuserAction()
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
                if($user = $this->model->getUserById($id)){
                    // Found user
                    $this->model->setUser($id);
                    $this->redirect('/admin');
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



/***********************************************************************************************
************************************************************************************************
************************ Subcat Block ***********************************************************
************************************************************************************************
***********************************************************************************************/

    //Select All Sub Categories
    public function subcatsAction()
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
                $this -> view -> data  = $this -> modelSubCat -> listAllSubCats();    
            }
            else{
                $this->redirect('/');       
            }
         }
    }

    // Edit Sub Category

    public function editsubcatAction()
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
            // Create Form Object
            $form = new Application_Form_Subcat();
            if($userObj->type == '1'){
                //$this -> view -> data  = $this -> model -> listAllUsers();    
                // Get User Id
                $id = $this->getRequest()->getParam('id');
                if($subcat = $this->modelSubCat->getSubCatById($id)){
                    // Found user
                    $form->populate($subcat[0]);
                }
                else
                {
                    $this->redirect('/');
                }


                if($this->getRequest()->isPost()){
                    $data = $this->getRequest()->getParams();
                    
                    //var_dump($info);

                    if($form->isValid($data)){
                        if ($this->modelSubCat->editSubCat($id, $data))
                        {
                             $this->redirect('admin/subcats');
                        }
                        
                    }
                } 
                $this->view->form = $form;
            }
            else{
                $this->redirect('/');       
            }
         }
    }

    // Lock Sub Cat
     public function locksubcatAction()
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
                if($subcat = $this-> modelSubCat->getSubCatById($id)){
                    // Found user
                    $this->modelSubCat->lock($id);
                    $this->redirect('/admin/subcats');
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


    // UnLock Sub Cat
     public function unlocksubcatAction()
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
                if($subcat = $this-> modelSubCat->getSubCatById($id)){
                    // Found user
                    $this->modelSubCat->unlock($id);
                    $this->redirect('/admin/subcats');
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



    // Visible Sub Cat
     public function visiblesubcatAction()
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
                if($subcat = $this-> modelSubCat->getSubCatById($id)){
                    // Found user
                    $this->modelSubCat->visible($id);
                    $this->redirect('/admin/subcats');
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


    // Visible Sub Cat
     public function unvisiblesubcatAction()
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
                if($subcat = $this-> modelSubCat->getSubCatById($id)){
                    // Found user
                    $this->modelSubCat->unvisible($id);
                    $this->redirect('/admin/subcats');
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


    public function viewsubcatAction()
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
                if($subcat = $this->modelSubCat->getSubCatById($id)){
                    // Found user
                    $countThread = $this->modelThread->countThreads($id); 
                    $this->view-> form = $subcat;
                    $this->view-> getThreads = $countThread;
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


    // Insert New Sub Cat
     public function addsubcatAction()
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
                
                $id = $this->getRequest()->getParam('id');
                if($subcat = $this-> modelCategory->getCatById($id)){
                    // Found Category

                    $data = $this->getRequest()->getParams();
                    $form = new Application_Form_Subcat();
                    
                    if($this->getRequest()->isPost()){                
                        if($form->isValid($data))
                        {
                            
                            if ($this->modelSubCat->addSubCat($data , $id))
                                    $this->redirect('admin/subcats');
                                    
                        }
                    }

                    $this->view->form = $form; 
                    
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

