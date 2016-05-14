<?php

class Application_Form_Requests extends Zend_Form
{
     
    public function init()
    {
       $title = new Zend_Form_Element_Text('title');
       $title->setLabel('Title');
       $title->setRequired();
       $title->addValidator('regex', false, array('/^[a-z]/i'));
       $title->setAttrib('style','margin-left:200px; margin-top:15px; margin-bottom:10px;');
        
       $message = new Zend_Form_Element_Textarea('message');
       $message->setLabel('Message');
       $message->setRequired();
       $message->setAttrib('style','margin-left:200px; margin-top:15px;margin-bottom:10px; width:400px; height:200px;');
       
       $this->addElements(array($title,$message ));
       $this->addElement('radio', 'Type_course', array(
         'label' => 'What Type of request ? ',
         'multioptions' => array(
        0 => 'Cousre',
        1 => 'Material', ),
        ));

       
       $submit = new Zend_Form_Element_Submit('submit');
       $submit->setAttrib('class', 'col-md-4 col-md-push-2 btn btn-primary');
       $this->addElements(array($submit));
       
       
    }


}

