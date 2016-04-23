<?php
    class CommentsController extends Zend_Controller_Action
{

    private $model = null;

    public function init()
    {
       $this->model = new Application_Model_DbTable_Comments;
    }

    public function indexAction()
    {

        //$this -> view -> data  = $this -> model -> listAllUsers();

        
    }

    public function editAction()
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
            $form = new Application_Form_Comments();
            
                //$this -> view -> data  = $this -> model -> listAllUsers();    
                // Get User Id
                $id = $this->getRequest()->getParam('id');
                $thread_id = $this->getRequest()->getParam('thread_id');
                if($comment = $this->model ->getCommentById($id)){
                    // Found user
                    $form->populate($comment[0]);
                }
                else
                {
                    $this->redirect('thread/view/id/'.$thread_id);
                }


                if($this->getRequest()->isPost()){
                    $data = $this->getRequest()->getParams();
                    
                    //var_dump($info);

                    if($form->isValid($data)){
                        if ($this->model->editComment($id, $data))
                        {
                             $this->redirect('threads/index/id/'.$thread_id);
                        }
                        
                    }
                } 
                $this->view->form = $form;
            
         }
    }


    public function deleteAction()
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
            
                //$this -> view -> data  = $this -> model -> listAllUsers();    
                // Get User Id
                $id = $this->getRequest()->getParam('id');
                $thread_id = $this->getRequest()->getParam('thread_id');
                if($comment = $this->model ->getCommentById($id)){
                    if ($this->model->deleteComment($id))
                        {
                             $this->redirect('threads/index/id/'.$thread_id);
                        }
                }
                else
                {
                    $this->redirect('thread/view/id/'.$thread_id);
                }


            
         }
    }


}
?>

