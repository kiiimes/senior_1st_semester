<?php

class Auth_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
	}

	public function register($info)
	{
		$this->db->set('id', $info['id']);
		$this->db->set('pw', $info['pw']);
		$this->db->set('name', $info['name']);

		$this->db->insert('user');
		$result = $this->db->insert_id();
		
		return $result;
	}

	public function unregister($userID){
		$this->db->delete('user', array('id' => $userID)); 
	}

	public function getUserById($userID){
		$result = $this->db->get_where('user', array('id' => $userID))->row();
		
		return $result;
	}

	public function destroySession($userID, $ip){
		$this->db->like('data', $this->db->escape_like_str($userID));
		$this->db->delete('ci_sessions');
	}

	public function checkPushToken($userID){
		$result = $this->db->get_where('user', array('id' => $userID))->row();

		return $result;
	}

	public function registerToken($userID, $token){
		$sql = "select * from push where userID = '".$userID."'";
		$query = $this->db->query($sql);
		if($query->num_rows()==0){
			$this->db->set('userID', $userID);
			$this->db->set('pushToken', $token);
			$this->db->insert('push');
			$result = $this->db->insert_id();
		} else{
			$data = array(
				'pushToken'=> $token
			);
			$this->db->where('userID', $userID);
			$this->db->update('push', $data);
			$result = $this->db->insert_id();
		}

		return $result;
	}
}
