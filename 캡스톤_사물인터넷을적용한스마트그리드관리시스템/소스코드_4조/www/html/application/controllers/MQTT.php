<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Mosquitto\Client;
class MQTT extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	private function getMsg($topic){
		exec('mosquitto_sub -t '.$topic.'-C 1');
	
	}
	
	public function test(){
		$this->getMsg('abc');
	}
}
