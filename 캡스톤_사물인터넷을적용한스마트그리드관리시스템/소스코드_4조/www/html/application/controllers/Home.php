<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	
	public function __construct(){
		parent::__construct();
		$this->load->model('device_model');
	}
	private function head(){
		$this->load->view('header');
	}
	private function navbar(){
		$this->load->view('navbar');
	}
	private function foot()
	{
		$this->load->view('footer');
	}	
	public function index()
	{
		$this->head();
		$this->navbar();
		$charges = $this->load->view('flip', array('url' => '/index.php/system/jsonGetCurrentCharge', 'unit' => '₩'), true);
		$this->load->view('main_page', array('charges' => $charges));
		$this->foot();
	}

	public function charges(){
		$this->head();
		$this->navbar();	
		$this->load->view('charges');	
		$this->load->view('flip', array('url' => '/index.php/system/jsonGetCurrentCharge', 'unit' => '₩'));
		$this->load->view('state');
		$this->load->view('gauge');
		$this->foot();
	}

	public function switches(){
		$this->head();
		$this->navbar();

		$device_list = $this->device_model->getDeviceList($this->session->userdata('userID'));
		$this->load->view('switches', array('list' => $device_list));
		$this->foot();
		
	}

	public function solarGen(){
		$this->head();
		$this->navbar();
		$url = '/index.php/graph/jsonSolarProfit';
		$arg = array('url'=> $url, 'title' => 'Solar Generated Electricity', 'ko_title' => '태양광 발전량');
		$this->load->view('graph', $arg);
		$this->load->view('flip', array( 'url'=>'/index.php/system/jsongetsolarkwh', 'unit' => '㎾'));
		$this->foot();
	}
	public function external(){
		$this->head();
		$this->navbar();
		$this->load->view('external_graph');
		$this->load->view('flip', array('url' => '/index.php/system/jsonGetKWh', 'unit' => '㎾'));
		$this->foot();
	}
	public function kwh(){
		$this->head();
		$this->navbar();
		$this->load->view('flip', array('url' => '/index.php/system/jsonGetKWh', 'unit' => '㎾'));
		$this->foot();
	}
}
