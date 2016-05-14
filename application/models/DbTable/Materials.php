<?php

class Application_Model_DbTable_Materials extends Zend_Db_Table_Abstract
{

    protected $_name = 'materials';
	

	function listMaterials(){
		return $this->fetchAll()->toArray();
	}
	
	
	function getMaterialById($id_mat){
		return $this->find($id_mat)->toArray();
	}
        
        function imageMaterialById($id_cours,$id_type){
            $select=$this-> select()->from("materials",'*')-> where(' id_cours='.$id_cours)-> where('id_type='.$id_type);
            return $this->fetchAll($select);
	}
        
        function videoMaterialById($id_type,$id_cours){
            $select=$this-> select()->from("materials",'*')-> where('id_type='.$id_type) -> where('id_cours='.$id_cours);
            return $this->fetchAll($select);
	}
        
        function PDFMaterialById($id_type,$id_cours){
            $select=$this-> select()->from("materials",'*')-> where('id_type='.$id_type)-> where('id_cours='.$id_cours);
            return $this->fetchAll($select);
	}
        
        function PPTMaterialById($id_type,$id_cours){
            $select=$this-> select()->from("materials",'*')-> where('id_type='.$id_type)-> where('id_cours='.$id_cours);
            return $this->fetchAll($select);
	}
        
        function wordMaterialById($id_type,$id_cours){
            $select=$this-> select()->from("materials",'*')-> where('id_type='.$id_type)-> where('id_cours='.$id_cours);
            return $this->fetchAll($select);
	}

	function updateMaterial($matInfo,$id_mat){
            return $this->update($matInfo,'id_mat='.$id_mat);
	}

	
	function deleteMaterial($id_mat){
		return $this->delete('id_mat='.$id_mat);
	}


	function addMaterial($matInfo){
		$row = $this->createRow();
		$row->mat_pdf=$matInfo['mat_pdf'];
		$row->mat_word=$matInfo['mat_word'];
		$row->mat_ppt=$matInfo['mat_ppt'];
		$row->mat_video=$matInfo['mat_video'];
		$row->mat_image=$matInfo['mat_image'];
        $row->desc_pdf=$matInfo['desc_pdf'];
		$row->desc_word=$matInfo['desc_word'];
		$row->desc_ppt=$matInfo['desc_ppt'];
		$row->desc_video=$matInfo['desc_video'];
		$row->desc_image=$matInfo['desc_image'];		
        $row->id_cours=$matInfo['id_cours'];
		$row->id_type = $matInfo['id_type']; 
		$row->id_cato = $matInfo['id_cato'];        
		$row->id_user=$matInfo[2];
        $row->lock=$matInfo[0];
		$row->state=$matInfo[1];
        $row->no_users=$matInfo[3];
//		$row->id_cato=$matInfo['id_cato'];

		return $row->save();
	}


}

