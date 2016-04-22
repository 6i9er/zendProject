<?php

class Application_Model_DbTable_Threads extends Zend_Db_Table_Abstract
{

    protected $_name = 'threads';


    public function listSelectedThreads($id)
    {

        return $this->fetchAll('cat_id=' . $id)->toArray();

    }

    // Start Tisting
//====================Add Thread====================================

    public function addThread($data , $u_id , $cat_id)
    {

//title,topic,is_fixed,downloads,is_closed,video,time,id

        $row = $this->createRow();
        $row->date = date("d - m - Y");
        $row->title = $data['title'];
        $row->cat_id = $cat_id;
        $row->u_id = $u_id;
        $row->topic = $data['topic'];
        $row->is_fixed = 0;
        //$row->downloads = $data['downloads'];
        $row->is_closed = 0;
        $row->video = $data['video'];
        $row->time = date('h:i:sa');
        $row->picture = $data['picture'];

        return $row->save();

    }

//====================List All Threads==============================

    public function listAllThreads()
    {

        return $this->fetchAll()->toArray();

    }

//====================List Single Thread============================

    public function getThreadById($id)
    {

        return $this->find($id)->toArray();

    }

//====================Delete Thread=================================

    public function deleteThread($id)
    {

        return $this->delete('id=' . $id);

    }

//====================Edit Thread===================================

    public function editThread($id, $data)
    {

        $mydata = array(
            'title' => $data['title'],
            'topic' => $data['topic'],
            'video' => $data['video'],
            'picture'=>$data['picture']

        );

        $where = "id = " . $id;
        return $this->update($mydata, $where);

    }

}