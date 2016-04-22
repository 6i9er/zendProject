<?php

class Application_Model_DbTable_Subcats extends Zend_Db_Table_Abstract
{

    protected $_name = 'subcat';

    public function addSubCat($data , $id){


    	$row = $this -> createRow();
    	$row -> cat_id = $id ;
        $row -> reg_date = date("d - m - Y");
        $row -> name = $data['name'];
        $row -> is_visible = 0;
        $row -> is_locked = 0;
    	return $row -> save();

    }


    public function listAllSubCats(){

    	return $this -> fetchAll() -> toArray();

    }

    public function getSubCatById($data){
    	return $this -> find($data) -> toArray();
    }

    public function deleteUser($data){

    	return $this -> delete('id='.$data);

    }


    public function editSubCat($id , $data){
		
		$mydata =array (
    			'name' => $data['name'] 
    			

    	);
    	$where = "id = " .$id ;


    	return $this -> update( $mydata , $where);

    }



    
    public function lock($id ){
        
        $mydata =array (
                'is_locked' => 1 
        );
        $where = "id = " .$id ;


        return $this -> update( $mydata , $where);

    }
    public function unlock($id ){
        
        $mydata =array (
                'is_locked' => 0 
        );
        $where = "id = " .$id ;


        return $this -> update( $mydata , $where);

    }

    public function visible($id ){
        
        $mydata =array (
                'is_visible' => 1 
        );
        $where = "id = " .$id ;


        return $this -> update( $mydata , $where);

    }

    public function unvisible($id ){
        
        $mydata =array (
                'is_visible' => 0 
        );
        $where = "id = " .$id ;


        return $this -> update( $mydata , $where);

    }

   




}

