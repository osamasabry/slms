<?php

class Application_Model_DbTable_Course extends Zend_Db_Table_Abstract
{
	protected $_name = 'courses';

	function listCourses($id){
		return $this->fetchAll($this->select()->where('id_cato='.$id))->toArray();
	}
	
	function addCourse($data,$user_id){
	if ($data['id_cours'] != "" )
		{
			$course = $this->fetchRow($this->select()->where('id_cours='.$data['id_cours']));
			$cat_id = $course->id_cato;
			$course->id_cato = $cat_id;
		}
		else{
			$course = $this->createRow();
			$course->num_view = 0;
			$course->id_cato = $data['category_id'];
		}

		$course->course = $data['course'];

		if($data['cours_image'] == "")
		{
			$img = $course['cours_image'];
			$course->cours_image = $img;
		}else{
			$course->cours_image = $data['cours_image'];
		}
		
		$course->cours_desc = $data['cours_desc'];
		$course->id_user = $user_id;
		

		return $course->save();
	}

	function getCourseById($id){
		return $this->find($id)->toArray();
	}
	
	function deleteCourse($id){
		return $this->delete('id_cours='.$id);
	}

	function addViewsCourse($id){
		$course = $this->fetchRow($this->select()->where('id_cours='.$id));
		// var_dump($course[0]); die;
		$course->num_view += 1;
		// echo $course[0]['num_view']; die;
		return $course->save();
	}

	function numViewsCourse($id){
		$course = $this->fetchRow($this->select()->where('id_cours='.$id));
		return $course->num_view;
	}

}
