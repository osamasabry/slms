<?php

class Application_Model_DbTable_Requests extends Zend_Db_Table_Abstract
{

      protected $_name = 'requests';
	

	function listRequest(){
		return $this->fetchAll()->toArray();
	}
        
        
        function addRequest($data){
	
        $row = $this->createRow();   
        $row->title = $data['title'];
        $row->message = $data['message'];
        $row->Type_course = $data['Type_course'];
        return $row->save();
	}
        
        
        function countRequest(){
		
            $request = $this->fetchAll($this->select('Type_course'));           
            return $request;
            
            
	}

}

