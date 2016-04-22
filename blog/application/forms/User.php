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


	$signature = new Zend_Form_Element_Text("signature");
	$signature->setRequired();
	$signature->setlabel("signature:");
	$signature->setAttrib("class","form-control");
	$signature->setAttrib("placeholder","Enter your signature");

	$email = new Zend_Form_Element_Text("mail");
	$email->setRequired();
	$email->addValidator(new Zend_Validate_EmailAddress());
	$email->addValidator(new Zend_Validate_Db_NoRecordExists(
	    array(
		  'table' => 'users',
		  'field' => 'mail'
	    )
	));
	$email->setlabel("Email:");
	$email->setAttrib("class","form-control");
	$email->setAttrib("placeholder","Enter your Email");
	
	$password = new Zend_Form_Element_Password("password");
	$password->setRequired();
	$password->setlabel("Password:");
	$password->addValidator(new Zend_Validate_StringLength(array('min' => 5, 'max' => 10)));
	$password->setAttrib("class","form-control");

	$prof_pic = new Zend_Form_Element_File("prof_pic");
	$prof_pic->setRequired();
	$destination = APPLICATION_PATH.'/../public/uploads/users';
        #var_dump($destination); exit();
    $prof_pic->setLabel('Profile Picture :');
    $prof_pic->setDestination($destination);
	$prof_pic->setAttrib("class","form-control");
	$prof_pic->addValidator('Count', false, 1);                
	$prof_pic->addValidator('Size', false, 10240000);          
	$prof_pic->addValidator('Extension', false, 'jpg,jpeg,png,gif');



	$gender = new Zend_Form_Element_Select("gender");
	$gender->setRequired();
	$gender->setlabel("Gender :");
	$gender->setAttrib("class","form-control");
	$gender->addMultiOptions(array(
        "1" => "Male",
        "2" => "Female",
    ));

    $country = new Zend_Form_Element_Select("country");
	$country->setRequired();
	$country->setlabel("Country :");
	$country->setAttrib("class","form-control");
	$country->addMultiOptions(array(
        "egypt" => "EGYPT",
        "ksa" => "KSA",
        "usa" => "USA",
        "france" => "France",
        "germany" => "Germany",
    ));





	$submit = new Zend_Form_Element_Submit('submit');

	$this->addElements(array($id,$name, $email, $password, $gender , $country , $prof_pic , $signature , $submit ));
 

    }


}

