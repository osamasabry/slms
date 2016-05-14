<?php

class CourseController extends Zend_Controller_Action
{

	private $model ,$user;
    public function init()
    {
        /* Initialize action controller here */
        $this->model = new Application_Model_DbTable_Course();
        $this->user = new Application_Model_DbTable_Users();
    }

    public function indexAction()
    {   
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            $identity = $auth->getIdentity(); 
            $user_id = $identity->id_user;

            $cat_id = $this->getRequest()->getParam('id');
            $category = new Application_Model_DbTable_Cateogry();
            $this->view->cateogry = $category->getCategoriesById($cat_id);
            $num = $category->addviewCategories($cat_id);
            $this->view->viewcato = $category->showviewCategories($cat_id);
            // var_dump($this->cateogry);
            $this->view->courses = $this->model->listCourses($cat_id);
        }else{
            $this->redirect("users/login");
        }
    }

    public function addAction()
    {
    	$auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            $identity = $auth->getIdentity(); 
            $user_id = $identity->id_user;
            $type = $identity->type;
            $this->view->type = $type;
            // echo $user_id;
             $id = $this->getRequest()->getParam('id');

            $admin_user  = $this->user->getUserById($user_id);
            // var_dump($admin_user[0]['type']);die;
            if($type == 1){
        
    	   	$form= new Application_Form_Course();
            $form->setAttrib('class', 'col-md-9');
            
	        if($this->getRequest()->isPost()) {
	            if ($form->isValid($this->getRequest()->getParams())) {
                    $id = $this->getRequest()->getParam('category_id');
	                $course_data=$form->getValues();
	                if($this->model->addCourse($course_data,$user_id)){
	                    
	                    $this->redirect("course/index/id/".$id);
	                }
	            }
	        }

            $layout = $this->_helper->layout();
            $layout->setLayout('admin-layout');

	        $this->view->form = $form;
        }else{
            $this->redirect("cateogry/index");
        }
        }else{
            $this->redirect("users/login");
        }
    }

    public function singleAction()
    {
    	//Get a single Course//
        $id = $this->getRequest()->getParam('course_id');
        // $course = $this->model->numViewsCourse($id);
        $this->redirect('materials/single/course_id/'.$id.'/id_type/1');

    }

    public function deleteAction()
    {
        //Delete a single Course//
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            $identity = $auth->getIdentity(); 
            $user_id = $identity->id_user;
            $admin_user  = $this->user->getUserById($user_id);
            $this->view->admin_user = $admin_user;
            // var_dump($admin_user[0]['type']);die;
            if($admin_user[0]['type'] == '1'){
        

                $id = $this->getRequest()->getParam('id_cours');
                if($this->model->deleteCourse($id))
                    $this->redirect('/cateogry/index');
             }else{
                $this->redirect("/cateogry/index");
            }
        }else{
            $this->redirect("users/login");
        }
    }
    
    function editAction(){

        //Update a single Course//

        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            $identity = $auth->getIdentity(); 
            $user_id = $identity->id_user;
            $type = $identity->type;

            //check if logged in user is Admin 
            $admin_user  = $this->user->getUserById($user_id);
            if($type == 1){
                // var_dump($admin_user);die;
                $id = $this->getRequest()->getParam('id_cours');
                $course = $this->model->getCourseById($id);
                $form = new Application_Form_Course();
                $form->getElement('cours_image')->setRequired(false);
                $form->removeElement('category_id');
                $form->populate($course[0]);
                //$values = $this->getRequest()->getParams();
                if($this->getRequest()->isPost()){
                    if($form->isValid($this->getRequest()->getParams())){
                        $data = $form->getValues();
                        $data['id_cours'] = $id;
                        // var_dump($data);die;
                        $this->model->addCourse($data,$user_id);
                        $this->redirect('materials/single/course_id/'.$id.'/id_type/1'); 
                    }   
                }
                $layout = $this->_helper->layout();
                $layout->setLayout('admin-layout');

                $this->view->form = $form;
                $this->render('add');

            }else{
                $this->redirect('cateogry/index');
            }
        }else{
            $this->redirect("users/login");
        }
    }

    function listcourseAction(){

        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            $identity = $auth->getIdentity(); 
            $user_id = $identity->id_user;
            $type = $identity->type;
            // $this->view->type = $type;

            if($type == 1){
                $cat_id = $this->getRequest()->getParam('id');
                $category = new Application_Model_DbTable_Cateogry();
                $this->view->cateogry = $category->getCategoriesById($cat_id);
                // var_dump($this->cateogry);
                $this->view->courses = $this->model->listCourses($cat_id);
                
                $layout = $this->_helper->layout();
                $layout->setLayout('admin-layout');

            }else{
                $this->redirect('cateogry/index');
            }
        }
    }


    // function twitterAction(){

    //     //share Course on twitter //

        // $auth = Zend_Auth::getInstance();
        // if($auth->hasIdentity()){
        //     $identity = $auth->getIdentity(); 
        //     $user_id = $identity->id_user;

            // $config = array(
            //     'callbackUrl' => $this->baseUrl().'course/twitter',
            //     'siteUrl' => 'http://twitter.com/oauth',
            //     'consumerKey' => 'gg3DsFTW9OU9eWPnbuPzQ',
            //     'consumerSecret' => 'tFB0fyWLSMf74lkEu9FTyoHXcazOWpbrAjTCCK48A'
            // );
            // $consumer = new Zend_Oauth_Consumer($config);
             
            // // fetch a request token
            // $token = $consumer->getRequestToken();




        // }
    // }


    function mailAction(){

        $tr = new Zend_Mail_Transport_Smtp('smtp.gmail.com');
        // Zend_Mail::setDefaultTransport($tr);


        $protocol = new Zend_Mail_Protocol_Smtp('smtp.gmail.com');
        $protocol->connect();
        $protocol->helo('shrouk.passiony@gmail.com');

        $tr->setConnection($protocol);
        

        $mail = new Zend_Mail();
        $email->host = "smtp.gmail.com";
        $email->ssl = 'TLS';
        $email->smtp_auth = "true";
        $email->username = "shrouk.passiony@gmail.com";
        $email->password = "";
        $email->smtpport = "465";
        $email->secure = "SSL";
        $email->ack = "false";
        $mail->setBodyText('This is the text of the mail.');
        $mail->setFrom('shrouk.passiony@gmail.com');
        $mail->addTo('osamasabry14@gmail.com');
        $mail->setSubject('welcome to our website ');
        $mail->send();

        $protocol->quit();
        $protocol->disconnect();

    }

    public function viewsAction(){
        //Get a single Course//
        $id = $this->getRequest()->getParam('course_id');
        $num_views = $this->model->numViewsCourse($id);
        echo $num_views;die;
        $this->redirect('materials/single/course_id/'.$id.'/id_type/1');

    }

}
