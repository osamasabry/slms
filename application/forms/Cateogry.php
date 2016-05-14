<?php

class Application_Form_Cateogry extends Zend_Form
{
    

    public function init()
    {
       $category = new Zend_Form_Element_Text('category');
       $category->setLabel('Name');
//       $category->setlableAttrib('Category Name');
       
       $category->setRequired();
       $category->setAttrib('style','margin-left:170px; margin-top:15px; margin-bottom:10px;');

       $image = new Zend_Form_Element_File('image');
       $image->setLabel('Image');
       $image->setDestination(APPLICATION_PATH.'/../public/images/category');
       $image->setRequired();
       $image->setAttrib('style','margin-left:170px; margin-top:15px; margin-bottom:10px;');

       
       $desc= new Zend_Form_Element_Textarea('desc');
       $desc->setLabel('Descriptaion');
       $desc->setRequired();
       $desc->setAttrib('style','margin-left:170px; margin-top:15px;margin-bottom:10px; width:400px; height:200px;');

       
       $submit = new Zend_Form_Element_Submit('submit');
       $submit->setAttrib('class', 'col-md-7 col-md-push-4 btn btn-primary');

       
       $this->addElements(array($category,$image, $desc,$submit));
    }


}

