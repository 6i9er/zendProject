<?php

class Application_Form_Subcat extends Zend_Form
{

    public function init()
    {
      
	//$id = new Zend_Form_Element_Hidden("id");

	$name = new Zend_Form_Element_Text("name");
	$name->setRequired();
	$name->setlabel("Sub Category Name :");
	$name->setAttrib("class","form-control");
	$name->setAttrib("placeholder","Enter your Sub Category Name");



	$submit = new Zend_Form_Element_Submit('submit');

	$this->addElements(array(/*$id,*/$name, $submit ));
 

    }


}

