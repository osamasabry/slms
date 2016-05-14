<?php

class MaterialsController extends Zend_Controller_Action
{
     private $model ,$user;

    public function init(){
        /* Initialize action controller here */
        $this->model = new Application_Model_DbTable_Materials();
        $this->user = new Application_Model_DbTable_Users();
    }
    

    public function indexAction(){
     	$this->view->materials = $this->model->listMaterials();

    }

    public function addmaterialAction(){
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            $identity = $auth->getIdentity(); 
            $user_id = $identity->id_user;
            $admin_user  = $this->user->getUserById($user_id);
            // var_dump($admin_user[0]['type']);die;
            if($admin_user[0]['type'] == '1'){
                $form = new Application_Form_Material();
                if($this->getRequest()->isPost()){
                    if($form->isValid($this->getRequest()->getParams())){
                    $data = $form->getValues();
                     $lock=0;
                     $state=1;
                     $no_user=0;     //will ask in it what make
                    array_push($data,$lock);
                    array_push($data,$state);
                    array_push($data,$user_id);
                    array_push($data,$no_user);
                    if($this->model->addMaterial($data))
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
    
        public function editmaterialAction(){
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
            //            $id_up=$ids['id_up'];
                    $id_mat=$ids['id_mat'];
                   
                    $tysing = $this->model->getMaterialById($id_mat);
                    $form = new Application_Form_editmaterial();
                    $form->populate($tysing[0]);
                    if($this->getRequest()->isPost()){
                        if($form->isValid($this->getRequest()->getParams())){
                            $data = $form->getValues();
                            // var_dump($data);
                            if($this->model->updateMaterial($data,$id_mat)){
                                $this->redirect('materials/showsingle/course_id/'.$course_id.'/id_type/'.$id_type.'/id_mat/'.$id_mat);
                            }
                        }
                    }
                    $layout = $this->_helper->layout();
                    $layout->setLayout('admin-layout');
                    $this->view->form = $form;
                    $this->render('addmaterial');
                }else{
                    $this->redirect("admin/index");
                }
            }else{
                    $this->redirect("users/login");
                }
    }

    
    public function singleAction(){
        //  add session check --- by shrouk
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            $identity = $auth->getIdentity(); 
            $user_id = $identity->id_user;
            $type = $identity->type;
            $this->view->type = $type;

        $ids = $this->getRequest()->getParams();
        $id_type=$ids['id_type'];
        $course_id=$ids['course_id'];
        $this->view->id_type=$id_type;
        $this->view->course_id=$course_id;
        
        $course=new Application_Model_DbTable_Course();
        $this->view->course = $course->getCourseById($course_id);
        $num = $course->addViewsCourse($course_id);
        $this->view->course_num_views = $course->numViewsCourse($course_id);
        
       $typematerialss= new Application_Model_DbTable_Typematerials();
       $this->view-> typematerials= $typematerialss->listTypematerials();
       
       $typeuploadss= new Application_Model_DbTable_Typeuploads();
       $this->view-> typeuploadss= $typeuploadss->filterrTypeuploadById($course_id,$id_type);
//        for obtain on number of download from database
       $numdown = $typeuploadss->download($id_type,$course_id);
       $fimg=0;
       $fvideo=0;
       $totaldownload=0;
        foreach ($numdown as $key => $value) {
            if($numdown[$key]['contain_upload']=='Image'){
                $fimg=1;
                $i=$key;
                break;
            }
        }
        foreach ($numdown as $key => $value) {
            if($numdown[$key]['contain_upload']=='Video'){
                $fvideo=1;
                $v=$key;
                break;
            }
        }
        if($fimg==1){
            $this->view-> numdownimage=$numdown[$i]['no_download'];
             $totaldownload+=$numdown[$i]['no_download'];

        }
        if($fvideo==1){
            $this->view-> numdownvideo=$numdown[$v]['no_download'];
            $totaldownload+=$numdown[$v]['no_download'];
        }
        }
//        var_dump($totaldownload);die();
        $this->view-> totaldownload=$totaldownload;

       $this->view-> typeimages= $this->model->imageMaterialById($course_id,$id_type);
       $this->view-> typevides= $this->model->videoMaterialById($id_type,$course_id);
       $this->view-> typePDFs= $this->model->PDFMaterialById($id_type,$course_id);
       $this->view-> typePPTs= $this->model->PPTMaterialById($id_type,$course_id);
       $this->view-> typewords= $this->model->wordMaterialById($id_type,$course_id);
    }
    
    
public function showsingleAction(){
       $ids = $this->getRequest()->getParams();
        $id_type=$ids['id_type'];
        $course_id=$ids['course_id'];
//            $id_up=$ids['id_up'];
        $id_mat=$ids['id_mat'];
        $this->view->id_type=$id_type;
        $this->view->course_id=$course_id;
        $this->view->id_mat=$id_mat;
        $this->view-> showmaterial= $this->model->getMaterialById($id_mat);

        // $obj=new Application_Model_DbTable_Comments();
        $form = new Application_Form_Addcomment();
        // $form->populate($user[0]);
        //     if($this->getRequest()->isPost()){
        //         if($form->isValid($this->getRequest()->getParams())){
        //         $data = $form->getValues();
        //         $this->model->updateuser($data,$id);
        //         $this->redirect("users/profile");
        //         }
        //         $this->redirect('materials/single/course_id/'.$course_id.'/id_type/'.$id_type.'/id_mat/'.$id_mat);
        // }
        $this->view->form = $form;
    }


public function showvideoAction(){
       $ids = $this->getRequest()->getParams();
        $id_type=$ids['id_type'];
        $course_id=$ids['course_id'];
//            $id_up=$ids['id_up'];
        $id_mat=$ids['id_mat'];
        $this->view->id_type=$id_type;
        $this->view->course_id=$course_id;
        $this->view->id_mat=$id_mat;
        $this->view-> showmaterial= $this->model->getMaterialById($id_mat);

        $form = new Application_Form_Addcomment();
    
        $this->view->form = $form;
    }
    
    public function downloadimageAction()
    {   $ids = $this->getRequest()->getParams();
        $id_type=$ids['id_type'];
       $course_id=$ids['course_id'];
        $id_mat=$ids['id_mat'];
       
//        for number download of images
        $downloadimg=new Application_Model_DbTable_Typeuploads();
        // $img='Image';
        $row_img= $downloadimg->download($id_type,$course_id);
        foreach ($row_img as $key => $value) {
            if($row_img[$key]['contain_upload']=='Image'){
                break;
            }
        }
       // var_dump($row_img[$key]['contain_upload']);die();
        $num_downimg['no_download']=$row_img[$key]['no_download']+1;
//        var_dump($num_downimg['no_download']);die();
        $downloadimg->updatedown($num_downimg,$row_img[$key]['id_up']);
            
        $material = $this->model->getMaterialById($id_mat);
//        var_dump($material[0]['mat_image']);die();
        $file_ex= explode(".",$material[0]['mat_image']);
        header('Content-type: application/'.$file_ex[1]);
        header("Content-Disposition: attachment; filename='".$material[0]['mat_image']."'"); 
        readfile(APPLICATION_PATH.'/../public/images/materials/'.$material[0]['mat_image']);
//        for make download in same page
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
//        $this->redirect('materials/showsingle/course_id/'.$course_id.'/id_type/'.$id_type.'/id_mat/'.$id_mat);

    }
    
    public function downloadvideoAction()
    {   $ids = $this->getRequest()->getParams();
        $id_type=$ids['id_type'];
       $course_id=$ids['course_id'];
        $id_mat=$ids['id_mat'];
       
//        for number download of images
        $downloadvideo=new Application_Model_DbTable_Typeuploads();
        // $video='Video';
        $row_video= $downloadvideo->download($id_type,$course_id);
        foreach ($row_video as $key => $value) {
            if($row_video[$key]['contain_upload']=='Video'){
                break;
            }
        }
       // var_dump($row_video[$key]['contain_upload']);die();
        $num_downvideo['no_download']=$row_video[$key]['no_download']+1;
//        var_dump($num_downvideo['no_download']);die();
        $downloadvideo->updatedown($num_downvideo,$row_video[$key]['id_up']);
            
        $material = $this->model->getMaterialById($id_mat);
//        var_dump($material[0]['mat_video']);die();
        $file_ex= explode(".",$material[0]['mat_video']);
        header('Content-type: application/'.$file_ex[1]);
        header("Content-Disposition: attachment; filename='".$material[0]['mat_video']."'"); 
        readfile(APPLICATION_PATH.'/../public/videos/'.$material[0]['mat_video']);
//        for make download in same page
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
//        $this->redirect('materials/showsingle/course_id/'.$course_id.'/id_type/'.$id_type.'/id_mat/'.$id_mat);

    }



    public function deleteAction() {
        $ids = $this->getRequest()->getParams();
        $id_type=$ids['id_type'];
        $course_id=$ids['course_id'];
//        $id_up=$ids['id_up'];
        $id_mat=$ids['id_mat'];
        if($this->model->deleteMaterial($id_mat))
        $this->redirect('materials/single/course_id/'.$course_id.'/id_type/'.$id_type);
    }

}
