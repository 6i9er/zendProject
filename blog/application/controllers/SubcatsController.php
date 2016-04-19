<?php

class SubcatsController extends Zend_Controller_Action
{

    private $model = null;

    public function init()
    {
       $this->model = new Application_Model_DbTable_Users;
    }

    public function indexAction()
    {

        //$this -> view -> data  = $this -> model -> listAllUsers();

        
    }

    public function addAction()
    {
        // action body
    }

    public function editAction()
    {
        // action body
    }

    public function deleteAction()
    {
        // action body
    }

    public function viewAction()
    {
        // action body
    }


}















