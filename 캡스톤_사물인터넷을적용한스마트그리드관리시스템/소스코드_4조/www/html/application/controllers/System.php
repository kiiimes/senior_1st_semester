<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}
	
	private function head(){
		$this->load->view('header');
	}
	private function navbar(){
		$this->load->view('navbar');
	}	
	private function foot(){
		$this->load->view('footer');
	}

	private function publishMQTT($topic, $msg, $host = ''){
		$prompt = 'mosquitto_pub -d';
		if ($host != '') $prompt .= ' -h '.$host;
		if ($topic == '' || $msg == '') return;
		$topic = str_replace('-', '/', $topic);	
		$prompt .= ' -t '.$topic.' -m '.$msg;
		$result =shell_exec($prompt);

		/*
		echo '<pre>TOPIC : '.$topic.'<br>MSG: '.$msg.'<br><pre>';
		echo '<hr>Result:<br>';
		echo '<pre>'.$result.'</pre>';
		*/
		return $result;
	}

	public function pubChange($flag){

		$data = array();
		$data['topic']='house-battery-change-smarthome';
		$data['flag']= $flag;
		$data['result'] = $this->publishMQTT('house-battery-change-smarthome', $flag);
	
		echo json_encode($data);	
	}
	public function pubSwitchControl($id, $flag = 1){

		$this->publishMQTT('house-device-switch-'.$this->session->userdata('userID').'-'.$id, $flag);
		$r['topic'] = 'house-device-switch-'.$this->session->userdata('userID').'-'.$id;
		$r['flag'] = $flag;

		echo json_encode($r);
	}	
 	public function jsonStateOfHouse(){
        $userID = $this->session->userdata('userID');
        $pathS = '/var/www/data/sensor/'.$userID.'/solar';
        $pathE = '/var/www/data/sensor/'.$userID.'/external';

		$handleS = fopen($pathS, "r");
		$handleE = fopen($pathE, "r");
		fseek($handleS, -10, SEEK_END);
		while(($a = fgetc($handleS)) != PHP_EOL){
			fseek($handleS, -2, SEEK_CUR);
		}
		fseek($handleE, -10, SEEK_END);
		while(($a = fgetc($handleE)) != PHP_EOL){
			fseek($handleE, -2, SEEK_CUR);
		}
		$dataS = fgetcsv($handleS, 1000, ",");
		$dataE = fgetcsv($handleE, 1000, ",");
		
		$js = array('solar' => $dataS[3], 'external' => $dataE[3], 'blackout' => $dataE[4]);

		echo json_encode($js);	 
	}	
	public function jsonGetKWh(){
		$handle = fopen("/var/www/data/sensor/".$this->session->userdata('userID').'/consumption', "r");
		fseek($handle, -10, SEEK_END);
		while(($a = fgetc($handle)) != PHP_EOL){
			fseek($handle, -2, SEEK_CUR);
		}
		$data = fgetcsv($handle, 1000, ',');
		$w = $data[1] + $data[2] + $data[3];
		
		$js['measure'] = $w < 100 ? $w : $w/1000;
		$js['unit'] = 	$w < 100 ? 'W' : '㎾';
		$js['measure'] = round($js['measure'] , 2);
		echo json_encode($js);
	}
	public function jsonGetCurrentLevel(){
		$handle = fopen("/var/www/data/sensor/".$this->session->userdata('userID').'/solarGen', "r");
        fseek($handle, -10, SEEK_END);
        while(($a = fgetc($handle)) != PHP_EOL){
            fseek($handle, -2, SEEK_CUR);
        }
        $data = fgetcsv($handle, 1000, ',');
		$js['measure'] = $data[3]*100;
		$js['unit'] = '%';
		echo json_encode($js);
	}	
 	public function jsonGetSolarKWh(){
        $handle = fopen("/var/www/data/sensor/".$this->session->userdata('userID').'/solarGen', "r");
        fseek($handle, -10, SEEK_END);
        while(($a = fgetc($handle)) != PHP_EOL){
            fseek($handle, -2, SEEK_CUR);
        }
        $data = fgetcsv($handle, 1000, ',');
        $current = abs($data[1]);
        $volt = abs($data[2]);
        $w = $current * $volt;

        $js['measure'] = $w < 100 ? $w : $w/1000;
        $js['unit'] =   $w < 100 ? 'W' : '㎾';
        $js['measure'] = round($js['measure'] , 2);
        echo json_encode($js);
    }
	public function test(){
		$this->head();
		$this->navbar();
		$this->load->view('test');
		$this->foot();
	}

	public function readFee(){
		$fee = array();
		$handle = fopen("/var/www/data/fee.csv", "r");
		while($data = fgetcsv($handle, 1000, ',')) {
			$num = count($data);
			if ($num == 1) {
				$row = $data[0];
				$fee[$row] = array();
			}
			else {
				if (count(array_slice($data, 1)) == 1){
					$fee[$row][$data[0]] = array_slice($data, 1)[0];
				}
				else{
					$fee[$row][$data[0]] = array_slice($data, 1);
				}
			}
		}

		return $fee;
	}

	public function jsonChargeWithoutDiscount($kwh){
		$data = $this->readFee();
	/*	echo '<xmp>';
		var_dump($data);
		echo '</xmp>';*/
		$f = 0;
		$std = 1;
		foreach($data['std'] as $d){
			$f +=(($kwh > $d[1]) ? $d[1] : $kwh) * $data['kwh'][array_search($d, $data['std'])];
			$kwh -= (int)$d[1];
			if ($kwh < 0) {
				break;
			}
			$std++;
		}

		if ($std > 4) $std= 4;
		$f += (int)$data['base']['r'.$std];
		//echo $f;

		$js['measure'] = floor($f);
		$js['unit'] = '₩';
		echo json_encode($js);
		return $f;
		
	}
	
	public function jsonGetCurrentCharge(){
		$userID = $this->session->userdata('userID');
		
		$path = "/var/www/data/sensor/".$userID."/external";

		$kw = 0;
		$handle = fopen($path, "r");
		while($data = fgetcsv($handle, 1000, ",")){
			$num = count($data);
			if($data[3] == 0 || $data[4] == 1) continue;
			$current = $data[1];
			$volt = $data[2]; 
			if ($volt < 0) continue;	
			$kw += $current * $volt;
		}
		$kw /= 1000;	

		$this->jsonChargeWithoutDiscount($kw);
	}
	public function modifyFeePage(){
		$data = $this->readFee();
	
		$value = 0;	
		if ($this->input->post('kwh')){
			$value = $this->calcFeeWithoutDiscount($kwh);
		}	
		$this->load->view('modify_fee', array('data'=>$data, 'value'=>$value));
		
	}
}	
