<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{

    protected $_name = 'users';

    public function addUser($data){


    	$row = $this -> createRow();
    	$row -> reg_date = date("d - m - Y");
        $row -> type = '2';
        $row -> name = $data['name'];
    	$row -> password = md5($data['password']);
    	$row -> mail = $data['mail'];
        $row -> gender = $data['gender'];
        $row -> signature = $data['signature'];
        $row -> country = $data['country'];
        $row -> is_blocked = 0;
        $row -> prof_pic = $data['prof_pic'];
    	return $row -> save();

    }
    
    public function checkMail($mail){

    return $this -> fetchAll('mail ="'.$mail.'"') -> toArray();
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

    public function updateLogin($id){
        
        $mydata =array (
                'last_login' => date("d - m - Y")

        );
        $where = "id = " .$id ;


        return $this -> update( $mydata , $where);  

    }


    public function editUser($id , $data){
		
		$mydata =array (
                'name' => $data['name'] ,
                'password' => md5($data['password']),
                'gender' => $data['gender'],
                'signature' => $data['signature'],
                'country' => $data['country']

        );
        $where = "id = " .$id ;


        return $this -> update( $mydata , $where);  

    }



    public function editAdminUser($id , $data){
        
        $mydata =array (
                'name' => $data['name'] ,
                'gender' => $data['gender'],
                'signature' => $data['signature'],
                'country' => $data['country']

        );
        $where = "id = " .$id ;


        return $this -> update( $mydata , $where);

    }

    public function blockUser($id ){
        
        $mydata =array (
                'is_blocked' => 1 
        );
        $where = "id = " .$id ;


        return $this -> update( $mydata , $where);

    }
    

    public function unblockUser($id ){
        
        $mydata =array (
                'is_blocked' => 0 
        );
        $where = "id = " .$id ;


        return $this -> update( $mydata , $where);

    }

    public function setUser($id ){
        
        $mydata =array (
                'type' => 2 
        );
        $where = "id = " .$id ;


        return $this -> update( $mydata , $where);

    }

    public function setAdmin($id ){
        
        $mydata =array (
                'type' => 1 
        );
        $where = "id = " .$id ;


        return $this -> update( $mydata , $where);

    }




}

