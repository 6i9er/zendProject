<?php

class Application_Model_DbTable_Msgs extends Zend_Db_Table_Abstract
{

    protected $_name = 'msgs';

    public function getMsgById($id){
        return $this -> find($id) -> toArray();
    }

    
    // ------- ListAll function --------- //
    function ListAll($mail){
        return $this -> fetchAll(' mailto = "'.$mail.'"') -> toArray();
    }

    
    // ------- Insert function --------- //
    function insertMsg($data,$from){
        $row = $this->createRow();
        $row-> mailfrom = $from;
        $row-> mailto = $data['email'];
        $row-> msgbody = $data['text'];
        $row-> date = date("Y-m-d h:i:sa");
        return $row->save();
    }

    public function deleteMsg($id)
    {

        return $this->delete('id=' . $id);

    }


}
   