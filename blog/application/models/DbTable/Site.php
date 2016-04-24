<?php

class Application_Model_DbTable_Site extends Zend_Db_Table_Abstract
{

    protected $_name = 'websettings';


    public function getStatusById($data){
    	return $this -> find($data) -> toArray();
    }

    


    public function setStatus($id,$data ){
        
        $mydata =array (
                'value' => $data['status']
        );
        $where = "id = " .$id ;


        return $this -> update( $mydata , $where);

    }




}

