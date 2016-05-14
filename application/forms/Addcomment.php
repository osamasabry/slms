<?php

class Application_Form_Addcomment extends Zend_Form
{

    public function init()
    {
        $id_comt = new Zend_Form_Element_Hidden('id_comt');
        $id_course = new Zend_Form_Element_Hidden('id_cours');
	 	
		$contain_comt = new Zend_Form_Element_Text('contain_comt');
		// $contain_comt->setLabel('');
		$contain_comt->setRequired();
		$contain_comt->setAttrib('class', 'form-control');

		$add_comt = new Zend_Form_Element_Submit('add comment');
		$add_comt->setAttrib('class', ' btn btn-primary');
		$this->addElements(array($id_comt,$contain_comt,$id_course, $add_comt));
    }


}

