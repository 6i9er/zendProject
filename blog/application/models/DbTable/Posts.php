<?php

class Application_Model_DbTable_Posts extends Zend_Db_Table_Abstract
{

    protected $_name = 'posts';

	public function listAllPosts(){

    	//return $this -> fetchAll() -> toArray();

    		$_name ->select()
                         ->from(array('posts' => 'posts'),
                                array('title , topic , u_id , id '))->join(array('users' => 'users'),
                                    'posts.u_id = users.id',
                                    array('u_id' => 'users.name'));

                             return $$_name -> fetchAll() -> toArray();   

    }

}

