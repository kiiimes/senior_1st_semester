<?php

class Fcm_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function getTokenList()
	{
		$result =  $this->db->get('push');
		return $result;
	}		

}

