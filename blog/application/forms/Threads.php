<?php

class Application_Form_Threads extends Zend_Form
{

    public function init()
    {
//title,topic,is_fixed,downloads,is_closed,video,time,id

        $id = new Zend_Form_Element_Hidden("id");

        $title = new Zend_Form_Element_Text("title");
        $title->setRequired();
        $title->setlabel("Title:");
        $title->setAttrib("class","form-control");
        $title->setAttrib("placeholder","Enter your title");


        $topic = new Zend_Form_Element_Textarea("topic");
        $topic->setlabel("Topic:");
        $topic->setAttrib("class","form-control");
        $topic->setAttrib("id","editor1");
        $topic->setAttrib("placeholder","Enter your topic");


        $video = new Zend_Form_Element_Text("video");
        $video->setlabel("Video:");
        $video->setAttrib("class","form-control");
        $video->setAttrib("placeholder","enter youtube link");

        $attach = new Zend_Form_Element_File("picture");
        //$attach->setRequired();
        $destination = APPLICATION_PATH.'/../public/uploads/threads';
        #var_dump($destination); exit();
        $attach->setLabel('Attachment :');
        $attach->setDestination($destination);
        $attach->setAttrib("class","form-control");
        $attach->addValidator('Count', false, 1);
        $attach->addValidator('Size', false, 10240000);
        $attach->addValidator('Extension', false, 'jpg,jpeg,png,gif,txt,docx,doc,pdf');


        $submit = new Zend_Form_Element_Submit('submit');

        $this->addElements(array($id,$title , $video , $attach , $topic ,  $submit ));


    }


}

