<?php

class AdminController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            $identity = $auth->getIdentity(); 
            $user_id = $identity->id_user; 
            $type = $identity->type;
            if($type == 1){

                $user = new Application_Model_DbTable_Users();
                // $this->view->user = $user->getUserById($user_id);
                $this->view->num_users = $user->countUsers();
                $this->view->num_admins = $user->countAdmins();
                $layout = $this->_helper->layout();
                $layout->setLayout('admin-layout');

            }
            else{
                $this->redirect("cateogry/index");
            }
        }else{
            $this->redirect("users/login");
        }
    }
    
    public function countAction()
    {
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
        $identity = $auth->getIdentity(); 
        $user_id = $identity->id_user; 
        $type = $identity->type;
        if($type == 1){
            $model = new Application_Model_DbTable_Requests();
           $this->view->countrequest = $model->countRequest();
       $layout = $this->_helper->layout();
       $layout->setLayout('admin-layout');
            // $this->render('index');
        }else{
            $this->redirect("cateogry/index");
        }

        }else{
            
             $this->redirect("users/login");
        }
    }
    
    
     public function goodaddAction(){
        $auth = Zend_Auth::getInstance();
            if($auth->hasIdentity()){
            $identity = $auth->getIdentity(); 
            $user_id = $identity->id_user; 
            $type = $identity->type;
            if($type == 1){
                $layout = $this->_helper->layout();
                $layout->setLayout('admin-layout');
             } else{
                
                 $this->redirect("users/login");
            }
         }     
    }
    

}

