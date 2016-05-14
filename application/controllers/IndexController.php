<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            $identity = $auth->getIdentity(); 
            $user_id = $identity->id_user;
            $type = $identity->type;
            $this->view->type = $type;

            $this->redirect("cateogry/index");

        }else{
			$this->redirect("users/login");
    
		}
    }


}

