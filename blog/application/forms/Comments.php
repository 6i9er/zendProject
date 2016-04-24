<?php

class Application_Form_Comments extends Zend_Form
{

    public function init()
    {
      
	//$id = new Zend_Form_Element_Hidden("id");

	$comment = new Zend_Form_Element_Text("comment");
	$comment->setRequired();
	$comment->setlabel("Add Your Comment :");
	$comment->setAttrib("class","form-control");
	$comment->setAttrib("placeholder","Enter your  Comment Here");



	$submit = new Zend_Form_Element_Submit('submit');

	$this->addElements(array(/*$id,*/$comment, $submit ));
 

    }


}

