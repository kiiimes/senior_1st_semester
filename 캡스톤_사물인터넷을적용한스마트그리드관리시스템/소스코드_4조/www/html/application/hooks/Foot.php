<?php

class Foot{

	public function add(){
    //  $CI =& get_instance();
    //  $CI->load->view('footer');
        readfile('../views/footer.php');
    }
}
