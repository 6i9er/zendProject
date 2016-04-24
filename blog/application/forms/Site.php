<?php

class Application_Form_Site extends Zend_Form
{

    public function init()
    {
      
	$id = new Zend_Form_Element_Hidden("id");

    $status = new Zend_Form_Element_Select("status");
	$status->setRequired();
	$status->setlabel("Country :");
	$status->setAttrib("class","form-control");
	$status->addMultiOptions(array(
        "0" => "OffLine",
        "1" => "Online"
    ));





	$submit = new Zend_Form_Element_Submit('submit');

	$this->addElements(array($id,$status , $submit ));
 

    }


}

