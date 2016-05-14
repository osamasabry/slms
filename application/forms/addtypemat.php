<?php

class Application_Form_addtypemat extends Zend_Form
{

    public function init()
    {
	
        /* Form Elements & Other Definitions Here ... */

	$contain_type = new Zend_Form_Element_Text('contain_type');
	$contain_type->setRequired();
    $contain_type->setAttrib('class', 'form-control');
	$contain_type->setLabel('New Type Materials :');
	$contain_type->addValidator(new Zend_Validate_Db_NoRecordExists(
    array(
        'table' => 'typematerials',
        'field' => 'contain_type'
    )
	));
	
 	$id_type = new Zend_Form_Element_Hidden('id_type');
        
	$addtypemat = new Zend_Form_Element_Submit('submit');
	$addtypemat->setAttrib('class', 'btn btn-info');

	$this->addElements(array($id_type,$contain_type,$addtypemat));

    }

}

