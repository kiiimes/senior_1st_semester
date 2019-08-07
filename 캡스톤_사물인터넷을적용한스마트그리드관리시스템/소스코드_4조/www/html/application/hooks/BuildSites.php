<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class BuildSites{

	public function load_header(){
		$CI =& get_instance();
		$CI->load->view('header');		
	}
	
	public function load_footer(){
	//	$CI =& get_instance();
	//	$CI->load->view('footer');
		readfile('../views/footer.php');
	}
}
