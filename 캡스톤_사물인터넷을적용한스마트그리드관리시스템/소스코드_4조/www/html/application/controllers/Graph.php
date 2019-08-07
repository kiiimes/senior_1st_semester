<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Graph extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('auth_model');
	}

	private function head(){
		$this->load->view('header');
	}
	private function foot(){
		$this->load->view('footer');
	}

	public function navbar(){
		$this->load->view('navbar');
	}

	private function zipData($data){
		$start = $data[0];
		$end = $data[count($data) - 1];
		print_r($start);
		print_r($end);
	
		$i = 0;
		$newJson = array();
		
		for($cur = $start; $cur < $end; $cur = $strtotime($cur." +1 minutes")){
			$tmp = 0;
	
			while(true){
				if ($data[$i]['date'] > $cur) break;
				$tmp += $data[$i]['cons'];
			}
			$newJson[] = array('date' => $cur, 'cons' => $tmp);
		} 

		return $newJson;
	}	
	public function jsonExternalBattery(){
		$userID = $this->session->userdata('userID');
		
		$path = '/var/www/data/sensor/'.$userID.'/consumption';

		$json = array();
		$handle = fopen($path, "r");
		while($data = fgetcsv($handle, 1000, ',')){
			$date = $data[0];
			$w = abs($data[1]) + abs($data[2]) + abs($data[3]);	
			$js = array('date' => $date, 'cons' => $w);
			$json[] = $js;
		}
	//	$json = $this->zipData($json);
		echo json_encode($json);
	} 
	
	public function jsonSolarProfit(){
		$userID = $this->session->userdata('userID');
		
		$path = '/var/www/data/sensor/'.$userID.'/solarGen';

		$json = array();
		$handle = fopen($path, "r");
		while($data = fgetcsv($handle, 1000, ',')){
			$date = $data[0];
			$current = abs($data[1]);
			$volt = abs($data[2]);
			
			$w = $volt * $current;
			$js = array('date'=>$date, 'cons' => $w);
			$json[] = $js;
		
		}
		
		echo json_encode($json);
		
	}

}
