<?php

class Application_Form_Course extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */

		$course = new Zend_Form_Element_Text('course');
		$course->setLabel('Name');
		$course->setRequired();
		$course->setAttrib('style','margin-left:170px; margin-top:15px; margin-bottom:10px;');
		

		$cours_image = new Zend_Form_Element_File('cours_image');
		$cours_image->setLabel('Image');
		$cours_image->setDestination(APPLICATION_PATH.'/../public/images/courses/');
		$cours_image->setRequired();
		$cours_image->setAttrib('style','margin-left:170px; margin-top:15px; margin-bottom:10px;');

		$category = new Application_Model_DbTable_Cateogry();

		$selectCategory = new Zend_Form_Element_Select('category_id');
		$selectCategory->setLabel('Category');
		$selectCategory->addMultiOption(0,'Plz Select Category');
		foreach ($category->fetchAll() as $cat) {
			$selectCategory->addMultiOption($cat['id_cato'],$cat['category']);
		}
		$selectCategory->setAttrib('style','margin-left:170px; margin-top:15px; margin-bottom:10px;');


		$cours_desc= new Zend_Form_Element_Textarea('cours_desc');
		$cours_desc->setLabel('Description');
		$cours_desc->setRequired();		
		$cours_desc->setAttrib('style','margin-left:170px; margin-top:15px;margin-bottom:10px; width:400px; height:200px;');


		$id_cato = new Zend_Form_Element_Hidden('id_cato');
		// $id_user = new Zend_Form_Element_Hidden('id_user');

		$submit = new Zend_Form_Element_Submit('Save');
		$submit->setAttrib('class', 'col-md-7 col-md-push-4 btn btn-primary');


		$this->addElements(array($course,$selectCategory,$cours_image,$cours_desc,$id_cato,$submit ));
    }


}

