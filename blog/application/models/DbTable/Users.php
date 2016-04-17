<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{

    protected $_name = 'users';

    public function addUser($data){

    	$row = $this -> createRow();
    	$row -> name = $data['name'];
    	$row -> password = md5($data['password']);
    	$row -> mail = $data['mail'];

    	return $row -> save();

    }


    public function listAllUsers(){

    	return $this -> fetchAll() -> toArray();

    }

    public function getUserById($data){
    	return $this -> find($data) -> toArray();
    }

    public function deleteUser($data){

    	return $this -> delete('id='.$data);

    }


    public function editUser($id , $data){
		
		$mydata =array (
    			'name' => $data['name'] ,
    			'mail' => $data['mail'] 
    	);

    	$where = "id = " .$id ;


    	return $this -> update( $mydata , $where);

    }




}

