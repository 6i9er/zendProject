<?php

class Application_Form_Cat extends Zend_Form
{

    public function init()
    {
      
	//$id = new Zend_Form_Element_Hidden("id");

	$name = new Zend_Form_Element_Text("name");
	$name->setRequired();
	$name->setlabel("Category Name :");
	$name->setAttrib("class","form-control");
	$name->setAttrib("placeholder","Enter your  Category Name");



	$submit = new Zend_Form_Element_Submit('submit');

	$this->addElements(array(/*$id,*/$name, $submit ));
 

    }


}

