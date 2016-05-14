<?php

class Application_Form_editmaterial extends Zend_Form
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


        $mat_video = new Zend_Form_Element_File('mat_video');
		$mat_video->setLabel('Video Material :');
		$mat_video->setDestination(APPLICATION_PATH.'/../public/videos');
        $mat_video->addValidator('extension', true, array('mp4','avi','mkv','flv','MP3'));
        $desc_video = new Zend_Form_Element_Text('desc_video');
        $desc_video->setLabel('desc_video');
//                $desc_video->setRequired();
        $desc_video->setAttrib('class', 'form-control');
                                
		$mat_image = new Zend_Form_Element_File('mat_image');
		$mat_image->setLabel('Image Material :');
		$mat_image->setDestination(APPLICATION_PATH.'/../public/images/materials');
		//$mat_image->setRequired();
        $mat_image->addValidator('extension', true, array('gif','jpg','png','jpeg'));
        $desc_image = new Zend_Form_Element_Textarea('desc_image');
        $desc_image->setLabel('desc_image');
        $desc_image->setAttrib('class', 'form-control');
//                $desc_image->setRequired();
                
                
        $mat_word = new Zend_Form_Element_File('mat_word');
		$mat_word->setLabel('Word Material :');
        $mat_word->setDestination(APPLICATION_PATH.'/../public/Words');
        $mat_word->addValidator('extension', true, array('doc','docx'));        
        $desc_word = new Zend_Form_Element_Text('desc_word');
        $desc_word->setLabel('desc_word');
//                $desc_word->setRequired();
        $desc_word->setAttrib('class', 'form-control');
                
                
        $mat_pdf = new Zend_Form_Element_File('mat_pdf');
		$mat_pdf->setLabel('PDF Material :');
		$mat_pdf->setDestination(APPLICATION_PATH.'/../public/pdfs');
        $mat_pdf->addValidator('extension', true, array('pdf'));
        $desc_pdf = new Zend_Form_Element_Text('desc_pdf');
        $desc_pdf->setLabel('desc_pdf');
//                $desc_pdf->setRequired();
        $desc_pdf->setAttrib('class', 'form-control');
                
                
        $mat_ppt = new Zend_Form_Element_File('mat_ppt');
		$mat_ppt->setLabel('PPT Material :');
		$mat_ppt->setDestination(APPLICATION_PATH.'/../public/ppts');
        $mat_ppt->addValidator('extension', true, array('ppt','pptx'));
        $desc_ppt = new Zend_Form_Element_Text('desc_ppt');
        $desc_ppt->setLabel('desc_ppt');
//                $desc_ppt->setRequired();
        $desc_ppt->setAttrib('class', 'form-control');
                
		$id_mat = new Zend_Form_Element_Hidden('id_mat');

		$mat_download = new Zend_Form_Element_Submit('Download Materials');
		$mat_download->setAttrib('class','btn btn-info');


		$this->addElements(array($id_mat,$selectCourse,$selecttype,$mat_image,$desc_image,$mat_video,$desc_video,$mat_word,$desc_word,$mat_pdf,$desc_pdf,$mat_ppt,$desc_ppt,$mat_download ));
    }


}

