<?php

class Application_Form_msgs extends Zend_Form
{

    public function init()
    {
      
	$id = new Zend_Form_Element_Hidden("id");

	$text = new Zend_Form_Element_Text("text");
	$text->setRequired();
	$text->setlabel("Message:");
	$text->setAttrib("class","form-control");
	$text->setAttrib("placeholder","Enter your text");


	$email = new Zend_Form_Element_Text("email");
	$email->setRequired();
	$email->addValidator(new Zend_Validate_EmailAddress());
	$email->setlabel("Email:");
	$email->setAttrib("class","form-control");
	$email->setAttrib("placeholder","Enter your Email");




	$submit = new Zend_Form_Element_Submit('submit');

	$this->addElements(array($id,$email, $text, $submit ));
 

    }


}

