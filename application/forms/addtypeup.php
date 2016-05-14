<?php

class Application_Form_addtypeup extends Zend_Form
{

    public function init()
    {
	
        /* Form Elements & Other Definitions Here ... */
    $course = new Application_Model_DbTable_Course();
    $selectCourse = new Zend_Form_Element_Select('id_cours');
    $selectCourse->addMultiOption(0,'Plz Select Course');
    foreach ($course->fetchAll() as $cou) {
        $selectCourse->addMultiOption($cou['id_cours'],$cou['course']);
    }


    $typematerial = new Application_Model_DbTable_Typematerials();
    $selecttype = new Zend_Form_Element_Select('id_type');
    $selecttype->addMultiOption(0,'Plz Select Type Material');
    foreach ($typematerial->fetchAll() as $typ) {
        $selecttype->addMultiOption($typ['id_type'],$typ['contain_type']);
    }    
    
	$contain_upload = new Zend_Form_Element_Text('contain_upload');
	$contain_upload->setRequired();
    $contain_upload->setAttrib('class', 'form-control');
	$contain_upload->setLabel('New Upload Materials :');
	// $contain_upload->addValidator(new Zend_Validate_Db_NoRecordExists(
    // array(
//         'table' => 'typeuploads',
//         'field' => 'contain_upload'
//     )
// ));
	
 	$id_up = new Zend_Form_Element_Hidden('id_up');
        
	$addtypeup = new Zend_Form_Element_Submit('submit');
	$addtypeup->setAttrib('class', 'btn btn-info');

	$this->addElements(array($id_up,$selectCourse,$selecttype,$contain_upload,$addtypeup));

    }

}

