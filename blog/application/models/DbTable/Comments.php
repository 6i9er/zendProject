<?php

class Application_Model_DbTable_Comments extends Zend_Db_Table_Abstract
{

    protected $_name = 'comments';

     public function listAllComments(){

        return $this -> fetchAll() -> toArray();

    }

     public function listSelectedComments($id){

        return $this -> fetchAll( 'cat_id='.$id ) -> toArray();

    }


}

