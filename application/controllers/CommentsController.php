<?php

class CommentsController extends Zend_Controller_Action
{
    private $model;

    public function init(){
        /* Initialize action controller here */
        $this->model = new Application_Model_DbTable_Comments();
    }

    public function indexAction()
    {
        // action body
    }
    public function addAction(){

        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            $identity = $auth->getIdentity(); 
            $user_id = $identity->id_user;
    	
            // $obj= new Application_Model_DbTable_Materials();
        	$ids= $this->getRequest()->getParams();
        	$id_type=$ids['id_type'];
            $course_id=$ids['course_id'];
            $id_mat=$ids['id_mat'];
    		
        	// $this->view->materials = $obj-> getMaterialById($id_mat);

        	// for show comments
        	 // $this->view->comments = $this->model->listComments();

    		$form = new Application_Form_Addcomment();
    		if($this->getRequest()->isPost()){
    			if($form->isValid($this->getRequest()->getParams())){
    			$data = $form->getValues();
    			array_push($data, $user_id);
                array_push($data, $id_mat);
    			if ($this->model->addComment($data))
    			$this->redirect('materials/single/course_id/'.$course_id.'/id_type/'.$id_type.'/id_mat/'.$id_mat);
    			
    			}

    		}
    	
    		$this->view->form = $form;
	   }else{
            $this->redirect("users/login");
       }
     }  
}
