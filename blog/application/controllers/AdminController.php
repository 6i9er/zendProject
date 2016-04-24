<?php

class AdminController extends Zend_Controller_Action
{

   	private $model = null;
    private $modelSubCat = null;
    private $modelThread = null;
    private $modelCat = null;
    private $modelStatus = null;
    private $modelComments = null;

    public function init()
    {
       $this->model = new Application_Model_DbTable_Users;
       $this->modelSubCat = new Application_Model_DbTable_Subcats;
       $this->modelThread = new Application_Model_DbTable_Threads;
       $this->modelComments = new Application_Model_DbTable_Comments;
       $this->modelCat = new Application_Model_DbTable_Categories;
       $this->modelStatus = new Application_Model_DbTable_Site;
       
        
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
                    $countThread = $this->modelThread->listSelectedThreads($id); 
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
                if($subcat = $this-> modelCat->getCatById($id)){
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
 






 /***********************************************************************************************
************************************************************************************************
************************ cat Block ***********************************************************
************************************************************************************************
***********************************************************************************************/

    //Select All  Categories
    public function catsAction()
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
                $this -> view -> data  = $this -> modelCat -> listAll();    
            }
            else{
                $this->redirect('/');       
            }
         }
    }

    // Edit  Category

    public function editcatAction()
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
            $form = new Application_Form_Cat();
            if($userObj->type == '1'){
                //$this -> view -> data  = $this -> model -> listAllUsers();    
                // Get User Id
                $id = $this->getRequest()->getParam('id');
                if($cat = $this->modelCat->getCatById($id)){
                    // Found user
                    $form->populate($cat[0]);
                }
                else
                {
                    $this->redirect('/');
                }


                if($this->getRequest()->isPost()){
                    $data = $this->getRequest()->getParams();
                    
                    //var_dump($info);

                    if($form->isValid($data)){
                        if ($this->modelCat->editCat($id, $data))
                        {
                             $this->redirect('admin/cats');
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

    



    // Visible  Cat
     public function visiblecatAction()
    {
        //On every init() of controlleryou have to check is authenticated or not
        $authorization = Zend_Auth::getInstance();
        if(!$authorization -> hasIdentity()) {
            $this->redirect('/users/login');
        }
        else
        {
                $Threads = $this -> modelThread -> listAllThreads($id);
                $comments= $this -> modelComments -> listAllComments(); 
            // Check if user is Admin
            $userObj = $authorization->getIdentity();
            if($userObj->type == '1'){
                //$this -> view -> data  = $this -> model -> listAllUsers();    
                // Get User Id
                $id = $this->getRequest()->getParam('id');
                if($cat = $this-> modelCat->getCatById($id)){
                    // Found user
                    $this->modelCat->makeVisible($id);
                    $this->redirect('/admin/cats');
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


    // Visible  Cat
     public function unvisiblecatAction()
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
                if($cat = $this-> modelCat->getCatById($id)){
                    // Found user
                    $this->modelCat->makeInvisible($id);
                    $this->redirect('/admin/cats');
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


    public function viewcatAction()
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
                if($cat = $this->modelCat->getCatById($id)){
                    // Found user
                    $countSubCat = $this->modelSubCat->listAllSubCatById($id); 
                    $this->view-> cat = $cat;
                    $this->view-> subCat = $countSubCat;
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


    // Insert New  Cat
     public function addcatAction()
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
                    $form = new Application_Form_Cat();
                    
                    if($this->getRequest()->isPost()){                
                        if($form->isValid($data))
                        {
                            
                            if ($this->modelCat->addCat($data))
                            {
                                    $this->redirect('admin/cats');
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



    //====================== Admin Site===========================/

    public function siteAction()
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
            $form = new Application_Form_Site();
            if($userObj->type == '1'){
                //$this -> view -> data  = $this -> model -> listAllUsers();    
                // Get User Id
                $id = 1;
                if($status = $this->model->getUserById($id)){
                    // Found user
                    $form->populate($status[0]);
                }
                else
                {
                    $this->redirect('/');
                }
                    $this->view-> cats = $this -> modelCat -> listAll();
                    $this->view-> subCats = $this -> modelSubCat -> listAllSubCats();
                    
                    $this->view-> users = $this -> model -> listAllUsers();
                    $this->view-> threads = $this -> modelThread -> listAllThreads();
                    $this->view-> comments= $this -> modelComments -> listAllComments();

                    $this->view-> status= $this -> modelStatus -> getStatusById(1); 

                if($this->getRequest()->isPost()){
                    $data = $this->getRequest()->getParams();
                    
                    //var_dump($info);

                    if($form->isValid($data)){
                        if ($this-> modelStatus->setStatus($id, $data))
                        {
                             $this->redirect('admin/site');
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




}

