<?php

class Application_Form_Posts extends Zend_Form
{

    public function init()
    {
      
	$id = new Zend_Form_Element_Hidden("id");

	$title = new Zend_Form_Element_Text("title");
	$title->setRequired();
	$title->setlabel("Title:");
	$title->setAttrib("class","form-control");
	$title->setAttrib("placeholder","Enter yourTopic Title");

	$topic = new Zend_Form_Element_Textarea("topic");
	$topic->setRequired();
	$topic->setlabel("Title:");
	$topic->setAttrib("class","form-control");
	$topic->setAttrib("placeholder","Enter your Topic");

	$submit = new Zend_Form_Element_Submit('submit');

	$this->addElements(array($id,$title, $topic, $submit));


    }


}

