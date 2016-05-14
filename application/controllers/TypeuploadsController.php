<?php

class TypeuploadsController extends Zend_Controller_Action
{
    
    private $model ,$user;

    public function init(){
        /* Initialize action controller here */
    	$this->model = new Application_Model_DbTable_Typeuploads();
        $this->user = new Application_Model_DbTable_Users();
    }
    
    public function indexAction(){
     	$this->view->typeloads = $this->model->listTypeuploads();

    }
    
    public function addtypeupAction(){
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            $identity = $auth->getIdentity(); 
            $user_id = $identity->id_user;
            $admin_user  = $this->user->getUserById($user_id);
            // var_dump($admin_user[0]['type']);die;
            if($admin_user[0]['type'] == '1'){
                $form = new Application_Form_addtypeup();
                if($this->getRequest()->isPost()){
                    if($form->isValid($this->getRequest()->getParams())){
                    $data = $form->getValues();
                    if ($this->model->addTypeupload($data))
                            $this->redirect('admin/goodadd');
                    }
                }   
                $layout = $this->_helper->layout();
                $layout->setLayout('admin-layout');
                $this->view->form = $form;
            }else{
                $this->redirect("admin/index");
                // $this->redirect('materials/single/course_id/'.$course_id.'/id_type/'.$id_type);
            }
        }else{
                $this->redirect("users/login");
            }
    }
    
    public function deleteAction() {
        $ids = $this->getRequest()->getParams();
        $id_type=$ids['id_type'];
        $course_id=$ids['course_id'];
        $id_up=$ids['id_up'];
        if($this->model->deleteTypeupload($id_up))
        $this->redirect('materials/single/course_id/'.$course_id.'/id_type/'.$id_type);
    }


	function editAction(){
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            $identity = $auth->getIdentity(); 
            $user_id = $identity->id_user;
            $admin_user  = $this->user->getUserById($user_id);
            // var_dump($admin_user[0]['type']);die;
            if($admin_user[0]['type'] == '1'){
                $ids = $this->getRequest()->getParams();
                $id_type=$ids['id_type'];
                $course_id=$ids['course_id'];
                $id_up=$ids['id_up'];
                $tyups = $this->model->getTypeuploadById($id_up);
                $form = new Application_Form_addtypeup();
                $form->populate($tyups[0]);
                if($this->getRequest()->isPost()){
                    if($form->isValid($this->getRequest()->getParams())){
                    $data = $form->getValues();
                    // var_dump($datas);
                    if($this->model->updateTypeupload($data,$id_up))
                     $this->redirect('materials/single/course_id/'.$course_id.'/id_type/'.$id_type);
                    }
                }
                $layout = $this->_helper->layout();
                $layout->setLayout('admin-layout');
                $this->view->form = $form;
                $this->render('addtypeup');
            }else{
                $this->redirect("admin/index");
            }
        }else{
                $this->redirect("users/login");
            }
       }     
}

