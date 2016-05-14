<?php

class Application_Form_Update extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $email=new Zend_Form_Element_Text('email');
        $email->setRequired();
        $email->setLabel('Email:');
        $email->addValidator(new Zend_Validate_EmailAddress);
	    
  
	    $password = new Zend_Form_Element_Password('password');
	    $password->setLabel('password:');
	    $password->addValidator(new Zend_Validate_StringLength(array('min'=>5,'max'=>20)));

      $options = array(
            "male" => "male",
            "female" => "female");
            
        
       $gender = new Zend_Form_Element_Radio('gender');
       $gender->setLabel("Gender:")
              ->setMultiOptions($options)
              ->setValue("male");
       $image = new Zend_Form_Element_File('image');
       $image->setLabel('Upload your image:');
       $image->setDestination(APPLICATION_PATH.'/../public/images/profile');
            

       $country=new Zend_Form_Element_Select('country',array(
        "label" => "Select Your Country:",
        "required" => true,
        ));
       $country->addMultiOptions(array(
        'us'=>'US',
        'uk'=>'UK',
        'egy'=>'Egypt'
        ));
       $sign=new Zend_Form_Element_Text('signature');
       $sign->setLabel('Signature:');
	     $submit = new Zend_Form_Element_Submit('Update');
	     $this->addElements(array($email,$password,$gender,$image,array($country),$sign,$submit));

    }


}


