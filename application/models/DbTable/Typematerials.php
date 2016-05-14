<?php

class Application_Model_DbTable_Typematerials extends Zend_Db_Table_Abstract
{

    protected $_name = 'typematerials';
	

	function listTypematerials(){
		return $this->fetchAll()->toArray();
	}
	
	function getTypematerialById($id_type){
		return $this->find($id_type)->toArray();
	}

	function updateTypematerial($typeInfo,$id_type){
		return $this->update($typeInfo,'id_type='.$id_type);
	}

	
	function deleteTypematerial($id_type){
		return $this->delete('id_type='.$id_type);
	}


	function addTypematerial($typeInfo){
		$row = $this->createRow();
		$row->contain_type = $typeInfo['contain_type'];


		return $row->save();
	}


}


