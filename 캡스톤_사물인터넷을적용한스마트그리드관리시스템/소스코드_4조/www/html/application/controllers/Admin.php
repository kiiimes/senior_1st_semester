<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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
	public function register()
	{
		$this->head();
		$this->navbar();
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('id', 'ID', 'required|min_length[1]|max_length[20]|is_unique[user.id]');
		$this->form_validation->set_rules('pw', 'Password', 'required|min_length[1]|max_length[30]|matches[re_pw]');
		$this->form_validation->set_rules('re_pw', 'Password Confirmation', 'required');
		$this->form_validation->set_rules('name', 'Name', 'required');
		
		if ($this->form_validation->run() == false){
			$this->load->view('register');
		} else {
			$hash = password_hash($this->input->post('pw'), PASSWORD_BCRYPT);
				
			$this->auth_model->register(array(
				'id' => $this->input->post('id'),
				'pw' => $hash,
				'name' => $this->input->post('name'),
			));
			$this->load->helper('url');

			echo 'Register Success <br>'.$hash;
		}
		$this->foot();
	}
}
