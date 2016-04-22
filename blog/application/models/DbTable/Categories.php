<?php

class Application_Model_DbTable_Categories extends Zend_Db_Table_Abstract
{

    protected $_name = 'categories';

    public function getCatById($data){
        return $this -> find($data) -> toArray();
    }
    
    public function listVisibleCats(){

        return $this -> fetchAll('is_visible =1') -> toArray();

    }

    // Start Testing 
    // ------- ListAll function --------- //
    function ListAll(){
        return $this->fetchAll()->toArray();
    }

    // ------- Make visible function --------- //
    function makeVisible($category_id){
        //$row   = $this->find($category_id); // find the category id
        $data  = array('is_visible'=>1); // updated value visible
        $where = "id = " .$category_id ;
        $this-> update($data,$where);
    }

    // ------- Make visible function --------- //
    function makeInvisible($category_id){
        //$row   = $this->find($category_id); // find the category id
        $data  = array('is_visible'=>0); // updated value visible
        $where = "id = " .$category_id ;
        $this-> update($data,$where);
    }

    // ------- Insert function --------- //
    function addCat($data){
        $row = $this->createRow();
        $row-> name = $data['name'];
        $row-> reg_date = date("Y-m-d h:i:sa");
        $row-> is_visible = 1;
        $row-> is_locked = 0;
        return $row->save();
    }


     public function editCat($id , $data){
        
        $mydata =array (
                'name' => $data['name'] 
                

        );
        $where = "id = " .$id ;


        return $this -> update( $mydata , $where);

    }


}
   