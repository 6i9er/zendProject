<?php

class Application_Form_User extends Zend_Form
{

    public function init()
    {
      
	$id = new Zend_Form_Element_Hidden("id");

	$name = new Zend_Form_Element_Text("name");
	$name->setRequired();
	$name->setlabel("Name:");
	$name->setAttrib("class","form-control");
	$name->setAttrib("placeholder","Enter your name");

	$email = new Zend_Form_Element_Text("mail");
	$email->setRequired();
	$email->addValidator(new Zend_Validate_EmailAddress());
	$email->setlabel("Email:");
	$email->setAttrib("class","form-control");
	$email->setAttrib("placeholder","Enter your Email");
	
	$password = new Zend_Form_Element_Password("password");
	$password->setRequired();
	$password->setlabel("Password:");
	$password->addValidator(new Zend_Validate_StringLength(array('min' => 5, 'max' => 10)));
	$password->setAttrib("class","form-control");

	$submit = new Zend_Form_Element_Submit('submit');

	$this->addElements(array($id,$name, $email, $password, $submit));


    }


}

