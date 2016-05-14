<?php

class UsersController extends Zend_Controller_Action
{

	private $model;

    public function init(){
        /* Initialize action controller here */
		$this->model = new Application_Model_DbTable_Users();
    }

    public function indexAction()
    {
    #osama will redirect here
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            $identity = $auth->getIdentity();
            $user_id = $identity->id_user; 
            $this->view->user_id = $user_id;
            $username = $identity->username;
            $this->view->username =$username;
            $type = $identity->type;
            $this->view->type = $type;

            if($type == 1){
                $layout = $this->_helper->layout();
                $layout->setLayout('admin-layout');
                $this->view->users = $this->model->listUsers();
            }else{
                $this->_redirect('cateogry/index');
            }
        }else{
            $this->_redirect('users/login');
        }

    }

    public function profileAction()
    {
    $auth = Zend_Auth::getInstance();
    if($auth->hasIdentity()){
        $identity = $auth->getIdentity(); 
        $id = $identity->id_user;
    $this->view->users  = $this->model->getUserById($id);
        }
    else
    {
        $this->_redirect('users/login');
    }
    }
    function editAction(){
    
     $auth = Zend_Auth::getInstance();
    if($auth->hasIdentity()){
        $identity = $auth->getIdentity(); 
        $id = $identity->id_user;
    $user = $this->model->getUserById($id);
    $form = new Application_Form_Update();
    $form->populate($user[0]);
    if($this->getRequest()->isPost()){
        if($form->isValid($this->getRequest()->getParams())){
        $data = $form->getValues();
        $this->model->updateuser($data,$id);
        $this->redirect("users/profile");
        }
    }
    $this->view->form = $form;
    }
    else
    {
        $this->_redirect('users/login');
    }

}
    public function addAction()
    {
    	$form = new Application_Form_Register();
        if($this->getRequest()->isPost()){
            if($form->isValid($this->getRequest()->getParams())){
                $data = $form->getValues();
                if($data['password'] != $data['confirmPassword'])
                {
                  $this->view->errorMessage = "Password and confirm password don’t match.";
                return;
               }
              unset($data['confirmPassword']);
                if (!$form->image->receive())
                 {
                    print "Upload error";
                }
           
                if ($this->model->addUser($data))
                    $this->redirect('users/login');
                }}
                 $this->view->form = $form;
            }
    public function loginAction()
    {
        
        $db = $this->_getParam('db');
        $form=new Application_Form_Login();
        if ($form->isValid($_POST)) 
        {
            $adapter = new Zend_Auth_Adapter_DbTable($db,'users','username', 'password');
 
            $adapter->setIdentity($form->getValue('username'));
            $adapter->setCredential(md5($form->getValue('password')));
 
            $auth   = Zend_Auth::getInstance();
            $result = $auth->authenticate($adapter);
                
            if ($result->isValid())
            {
                // check if user account activate ---> by shrouk
                $username = $form->getValue('username');
                $user = $this->model->getUserByUsername($username);
                // var_dump($user['ban_user']);die;
                if($user['ban_user'] == 1){
                    $auth = Zend_Auth::getInstance();
                    $storage = $auth->getStorage();

                    $storage->write($adapter->getResultRowObject(array('username',
                        'id_user','type','ban_user')));
                    $this->_redirect('cateogry/index');    
                }else{
                    $this->_redirect('users/deactive');   
                }
                // end of check if user account activate ---> by shrouk
            }
            
            else {

            $this->_redirect('users/login');
            }
        }
       
         $this->view->form = $form;
    }
    function logoutAction(){
        $authorization =Zend_Auth::getInstance();
        if($authorization->hasIdentity()) {
            Zend_Session::destroy();  
            $this->_redirect('users/login');
        
        } 
        
    }


    // ban and activate user from log in system and ---> by shrouk
    // 3 actions (banAction ,activateAction ,deactiveAction) ---> by shrouk
    function banAction(){
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            $identity = $auth->getIdentity(); 
            $user_id = $identity->id_user;
            $type = $identity->type;

            $ban_user = $this->getRequest()->getParam('id');
            if($type == 1){
                $user = $this->model->banUser($ban_user);
                $this->redirect('users/index');
            }
            else{
                $this->_redirect('cateogry/index');
            }
        }
        else{
            $this->_redirect('users/login');
        }
    }

    function activateAction(){
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            $identity = $auth->getIdentity(); 
            $user_id = $identity->id_user;
            $type = $identity->type;

            $ban_user = $this->getRequest()->getParam('id');
            if($type == 1){
                $user = $this->model->activateUser($ban_user);
                $this->redirect('users/index');
            }
            else{
                $this->_redirect('cateogry/index');
            }
        }
        else{
            $this->_redirect('users/login');
        }  
    }

    function deactiveAction(){

    }

    // make user as admin of system or remove this admin and list all system admins ---> by shrouk
    // 3 actions (makeadminAction ,rmadminAction , ) ---> by shrouk
    function makeadminAction(){
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            $identity = $auth->getIdentity(); 
            $user_id = $identity->id_user;
            $type = $identity->type;

            $admin_user = $this->getRequest()->getParam('id');
            if($type == 1){
                $user = $this->model->makeAdminUser($admin_user);
                $this->redirect('users/index');
            }
            else{
                $this->_redirect('cateogry/index');
            }
        }
        else{
            $this->_redirect('users/login');
        }  
    }

    function rmadminAction(){
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            $identity = $auth->getIdentity(); 
            $user_id = $identity->id_user;
            $type = $identity->type;

            $admin_user = $this->getRequest()->getParam('id');
            if($type == 1){
                $user = $this->model->removeAdminUser($admin_user);
                $this->redirect('users/alladmins');
            }
            else{
                $this->_redirect('cateogry/index');
            }
        }
        else{
            $this->_redirect('users/login');
        }  
    }

    function alladminsAction(){
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            $identity = $auth->getIdentity(); 
            $user_id = $identity->id_user;
            $type = $identity->type;
            $username = $identity->username;

            if($type == 1 ){
                $layout = $this->_helper->layout();
                $layout->setLayout('admin-layout');
                $this->view->users = $this->model->allAdminUsers();
                $this->render('index');
            }else{
                $this->_redirect('users/index');
            }
        }else{
            $this->_redirect('users/login');
        }
    }


}
