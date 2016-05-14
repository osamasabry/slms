<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{

    protected $_name = 'users';
	

	function listUsers(){
		return $this->fetchAll($this->select()->where('type=0'))->toArray();
	}
	
	function getUserById($id_user){
		return $this->find($id_user)->toArray();
	}

	function updateUser($userInfo,$id_user){
		$userInfo['password']=md5($userInfo['password']);
		$user = $this->getUserById($id_user);

		if($userInfo['password'] == md5("")){
			$userInfo['password'] = $user[0]['password'];
		}
		if($userInfo['image'] == ""){
			$userInfo['image'] = $user[0]['image'];
		}
		return $this->update($userInfo,'id_user='.$id_user);
	}

	
	function deleteUser($id_user){
		return $this->delete('id_user='.$id_user);
	}


	function addUser($userInfo){
		$row = $this->createRow();

		$row->email = $userInfo['email'];
		// md5 this way for hash password in database
		$row->password = md5($userInfo['password']);
		$row->ban_user=1;
		$row->type=0;
		$row->image=$userInfo['image'];
		$row->gender=$userInfo['gender'];
		$row->country=$userInfo['country'];
		$row->signature=$userInfo['signature'];
		$row->username=$userInfo['username'];


		return $row->save();
	}

	// Count website users by osama ...
	function countUsers(){
		$result =  $this->fetchAll($this->select()->where('type=0'))->toArray();
		return count($result);
	}
        
        function countAdmins(){
		$result =  $this->fetchAll($this->select()->where('type=1 and username!="admin" and id_user!=1'))->toArray();
		return count($result);
	}


	// ban and activate user from log in system and ---> by shrouk
	// 3 functions (banUser ,activateUser ,getUserByUsername) ---> by shrouk
	function banUser($id){
		$user = $this->find($id);
		// var_dump($user[0]['ban_user']);die;
		$user[0]['ban_user'] = 0;
		return $user[0]->save();
	}	

	function activateUser($id){
		$user = $this->find($id);
		$user[0]['ban_user'] = 1;
		return $user[0]->save();
	}

	function getUserByUsername($username){
		$user = $this->fetchRow($this->select()->where('username="'.$username.'"'));
		// var_dump($user[0]['ban_user']);die;
		return $user->toArray();
	}

	// make user as admin of system or remove this admin and list all system admins ---> by shrouk
	// 3 functions (makeAdminUser ,removeAdminUser ,allAdminUsers ) ---> by shrouk
	function makeAdminUser($id){
		$user = $this->find($id);
		$user[0]['type'] = 1;
		return $user[0]->save();
	}	

	function removeAdminUser($id){
		$user = $this->find($id);
		$user[0]['type'] = 0;
		return $user[0]->save();
	}

	function allAdminUsers(){
		return $this->fetchAll($this->select()->where('type=1 and username!="admin" and id_user!=1'))->toArray();
	}

}

