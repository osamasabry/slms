<?php

class Application_Form_Register extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $id = new Zend_Form_Element_Hidden('id_user');
        $email=new Zend_Form_Element_Text('email');
        $email->setRequired();
        $email->setLabel('Email:');
        $email->addValidator(new Zend_Validate_EmailAddress);
	    
      $username=new Zend_Form_Element_Text('username');
      $username->setRequired();
      $username->setLabel('Username:');
      $username->addValidator(new Zend_Validate_Db_NoRecordExists(
      array(
        'table' => 'users',
        'field' => 'username'
       )
     ));
	    $password = new Zend_Form_Element_Password('password');
	    $password->setLabel('password:');
	    $password->addValidator(new Zend_Validate_StringLength(array('min'=>5,'max'=>20)));
      $confirmPassword=new Zend_Form_Element_Password('confirmPassword');
      $confirmPassword->setLabel('confirm Password:');
      $confirmPassword->addValidator(new Zend_Validate_StringLength(array('min'=>5,'max'=>20)));
      $options = array(
            "male" => "male",
            "female" => "female");
            
        
       $gender = new Zend_Form_Element_Radio('gender');
       $gender->setLabel("Gender:")
              ->setMultiOptions($options)
              ->setValue("male");
       $image = new Zend_Form_Element_File('image');
       $image->setLabel('Upload your image:')
             ->setDestination(APPLICATION_PATH.'/../public/images/profile')
             ->setValueDisabled(true);
       $image->addValidator('ImageSize', false, array(
                    'minwidth' => 150,
                    'minheight' => 150
                    ));
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
	     $submit = new Zend_Form_Element_Submit('Register');
	     $this->addElements(array($id,$email,$username,$password,$confirmPassword,$gender,$image,array($country),$sign,$submit));

    }


}

