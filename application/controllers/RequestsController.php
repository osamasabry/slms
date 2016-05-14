<?php

class RequestsController extends Zend_Controller_Action
{

    private $request;

    public function init()
    {
        $this->request = new Application_Model_DbTable_Requests();
        
    }

    public function indexAction()
    {
       $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            $identity = $auth->getIdentity(); 
            $user_id = $identity->id_user;  
            $type = $identity->type;

            if($type == 1){
                 
              $this->view->request = $this->request->listRequest();
             $layout = $this->_helper->layout();
             $layout->setLayout('admin-layout'); 
            }else{
              $this->redirect("cateogry/index");
         }    
        }else{
            
             $this->redirect("users/login");
        }
    }
    
    
    public function addAction(){
        
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            $identity = $auth->getIdentity(); 
            $user_id = $identity->id_user; 
            $form= new Application_Form_Requests();

            if ($this->getRequest()->isPost()) {
                if ($form->isValid($this->getRequest()->getParams())) {
                $data = $form->getValues();

                if ($this->request->addRequest($data)) {
                   $this->redirect("cateogry/index");
               }
           }
       }
//
//       $layout = $this->_helper->layout();
//       $layout->setLayout('admin-layout'); 
       $this->view->form = $form;
                
        }else{
            
            $this->redirect("users/login");
        }

    }
}