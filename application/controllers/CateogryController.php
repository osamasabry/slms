<?php

class CateogryController extends Zend_Controller_Action
{

    private $Category;

    public function init()
    {
        $this->Category = new Application_Model_DbTable_Cateogry();
    }

    public function indexAction()
    {
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            $identity = $auth->getIdentity(); 
            $user_id = $identity->id_user;
            $type = $identity->type;
            $this->view->type = $type;
            $form= new Application_Form_Cateogry();
            $this->view->cateogries = $this->Category->listCategories();
            // $layout = $this->_helper->layout();
            // $layout->setLayout('admin-layout');
            $this->view->form = $form;
            

        }else{
            
             $this->redirect("users/login");
        }
         
    }
    
    public function addAction() {
       $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            $identity = $auth->getIdentity(); 
            $user_id = $identity->id_user;  

            $form = new Application_Form_Cateogry();
            $form->setAttrib('class', 'col-md-9');
            if ($this->getRequest()->isPost()) {
                if ($form->isValid($this->getRequest()->getParams())) {
                    $data = $form->getValues();

                if ($this->Category->addCategories($data)) {
                    $this->redirect("cateogry/index");
                }
            }
            
        }
        
        $layout = $this->_helper->layout();
        $layout->setLayout('admin-layout');

        $this->view->form = $form;
        
    }else{
        
        $this->redirect("users/login");
        
    }
}
    
     public function singleAction() {
       
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            $identity = $auth->getIdentity(); 
            $user_id = $identity->id_user; 
//            $count=0;
           
            $id = $this->getRequest()->getParam('id');
//        $this->view->cateogries = $this->Category->viewCategories($id);
         $this->redirect('course/index/id/'.$id); 
//         $count++;
        }else{
            
            $this->redirect("users/login");
        }
     }
    
    public function deleteAction() {
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            $identity = $auth->getIdentity(); 
            $user_id = $identity->id_user; 
            $id = $this->getRequest()->getParam('id');
        if ($this->Category->deleteCategories($id))
            $this->redirect('cateogry/index');
    }else{
        
         $this->redirect("users/login");
    }
    
 }  
      function editAction() {
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            $identity = $auth->getIdentity(); 
            $user_id = $identity->id_user; 
          
            $id = $this->getRequest()->getParam('id');
            $post = $this->Category->getCategoriesById($id);
            $form = new Application_Form_Cateogry();
            $form->getElement('image')->setRequired(false);
            $form->populate($post[0]);
            //$values = $this->getRequest()->getParams();
            if ($this->getRequest()->isPost()) {
                if ($form->isValid($this->getRequest()->getParams())) {
                
//                var_dump($data);die;
                $data = $form->getValues();
                $data['id_cato']=$id;
                $this->Category->addCategories($data);
                $this->redirect('cateogry/index');
                }
            }
        //$form->removeElement('submit');

            $layout = $this->_helper->layout();
            $layout->setLayout('admin-layout');

            $this->view->form = $form;
            $this->render('add');
    }else{
        
         $this->redirect("users/login");
    }
  }

  function listcatAction(){

    $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            $identity = $auth->getIdentity(); 
            $user_id = $identity->id_user;
            $type = $identity->type;
            // $this->view->type = $type;

            if($type == 1){
                $this->view->cateogries = $this->Category->listCategories();
                $layout = $this->_helper->layout();
                $layout->setLayout('admin-layout');
            }
            else{
                $this->redirect('cateogry/index');
            }
        }

  }

}

