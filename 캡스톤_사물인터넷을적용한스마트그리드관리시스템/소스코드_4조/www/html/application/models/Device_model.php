<?php

class Device_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function getDeviceList($userID)
	{
		return $this->db->get_where('device', array('userID' => $userID))->result();
	}		

}

