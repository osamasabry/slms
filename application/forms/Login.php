<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $id = new Zend_Form_Element_Hidden('id_user');
        $username=new Zend_Form_Element_Text('username');
        $username->setRequired();
        $username->setLabel('Username');
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('password');
        $password->addValidator(new Zend_Validate_StringLength(array('min'=>5, 'max'=>20)));

        $login = new Zend_Form_Element_Submit('submit');
        $login->setLabel('Login');

        $this->addElements(array($id, $username, $password, $login));


    }


}

