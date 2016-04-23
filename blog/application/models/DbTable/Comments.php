<?php

class Application_Model_DbTable_Comments extends Zend_Db_Table_Abstract
{

    protected $_name = 'comments';

     public function listAllComments(){

        return $this -> fetchAll() -> toArray();

    }

    // ------- Insert function --------- //
    function addComment($data , $thread_id , $user_id){
        $row = $this->createRow();
        $row-> comment = $data['comment'];
        $row->time = date('h:i:sa');
        $row->date = date("d - m - Y");
        $row->thread_id = $thread_id;
        $row->u_id = $user_id;
        return $row->save();
    }

    public function listSelectedComments($id){

        return $this -> fetchAll( 'thread_id='.$id ) -> toArray();

    }

    public function editComment($id , $data){
		
		$mydata =array (
    			'comment' => $data['comment'] 
    			

    	);
    	$where = "id = " .$id ;


    	return $this -> update( $mydata , $where);

    }


    public function getCommentById($data){
        return $this -> find($data) -> toArray();
    }

    public function deleteComment($id)
    {

        return $this->delete('id=' . $id);

    }


}

