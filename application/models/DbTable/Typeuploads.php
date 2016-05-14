<?php

class Application_Model_DbTable_Typeuploads extends Zend_Db_Table_Abstract
{

    protected $_name = 'typeuploads';
	

	function listTypeuploads(){
		return $this->fetchAll()->toArray();
	}
	
	function getTypeuploadById($id_up){
		return $this->find($id_up)->toArray();
	}
        
        
        
        function filterrTypeuploadById($course_id,$id_type){
            $select=$this-> select()->from("typeuploads",'*')-> where('id_cours='.$course_id)-> where('id_type='.$id_type);
            return $this->fetchAll($select);
	}
        
        
        
        function download($id_type,$course_id){
            $select=$this-> select()->from("typeuploads",'*')-> where('id_cours='.$course_id)-> where('id_type='.$id_type);
            return $this->fetchAll($select);
	}
       

	function updateTypeupload($upInfo,$id_up){
		return $this->update($upInfo,'id_up='.$id_up);
	}
        
        function updatedown($upInfo,$id_up){
            return $this->update($upInfo,'id_up='.$id_up);
	}

	
	function deleteTypeupload($id_up){
		return $this->delete('id_up='.$id_up);
	}


	function addTypeupload($upInfo){
		$row = $this->createRow();
		$row->contain_upload = $upInfo['contain_upload'];
        $row->id_type = $upInfo['id_type'];
        $row->id_cours = $upInfo['id_cours'];
//      $row->no_download = $upInfo['no_download'];
        $row->no_download = 0;

		return $row->save();
	}


}




