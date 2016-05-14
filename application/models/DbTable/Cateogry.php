<?php

class Application_Model_DbTable_Cateogry extends Zend_Db_Table_Abstract
{

      protected $_name = 'categories';
	

	function listCategories(){
		return $this->fetchAll()->toArray();
	}
        
        function userCategories($id){
		$result = $this->select('*')->where('user_id='.$id);
		return $this->fetchAll($result)->toArray();	
	}

	function getCategoriesById($id){
		return $this->find($id)->toArray();
	}
	
	function deleteCategories($id){
		return $this->delete('id_cato='.$id);
	}
	function addCategories($data){
	
	if($data['id_cato'] !="")
        {
            
            $row = $this->fetchRow($this->select()->where('id_cato='.$data['id_cato']));
           
            
        }else{
            $row = $this->createRow();
	}
        
         if ($data['image']!="") {
                
            $row->image = $data['image'];
        }else{
            
            $oldimage=$row['image'];
            $row->image = $oldimage;
        }
        
        $row->category = $data['category'];        
        $row->desc = $data['desc'];
        return $row->save();
	}
        
        function showviewCategories($id){
            
            $view= $this->fetchRow($this->select()->where('id_cato='.$id));
            return $view->num_view;
            
        }
        
        function addviewCategories($id){
            
           $view= $this->fetchRow($this->select()->where('id_cato='.$id));
           
           $view->num_view +=1;
           
                   
           return $view->save(); 
            
        }
        

}

