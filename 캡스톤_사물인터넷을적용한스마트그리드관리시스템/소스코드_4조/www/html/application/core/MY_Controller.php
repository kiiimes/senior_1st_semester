<?php
defined('BASEPATH') OR exit('???????????');

class MY_Controller extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('fcm_model');
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



	public function push_notification($tokens, $data){
		$url = 'https://fcm.googleapis.com/fcm/send';
		//어떤 형태의 data/notification payload를 사용할것인지에 따라 폰에서 알림의 방식이 달라 질 수 있다.
		/*$msg = array(
			'title'	=> $data["title"],
			'body' 	=> $data["body"]
          );
*/


		$msg = array(
			'title'	=> "FCM TEST",
			'body' 	=> "SUCCESS!!!!"
          );
		//data payload로 보내서 앱이 백그라운드이든 포그라운드이든 무조건 알림이 떠도록 하자.
		$fields = array(
				'registration_ids'		=> $tokens,
				'data'	=> $msg
			);

		//구글키는 config.php에 저장되어 있다.
		$headers = array(
			'Authorization:key = AAAArC5CU4Q:APA91bGM_qDK5FsGAGocwmWKWXMvUkGfEiGgdymG0SDU30T9jRuKv7X_UP6S3ds_j-McQGxAGv9Xir2FvSNqMErjdyb4CHlV8Pda4vrS57nOo_qafmZTz6B12JisI820dgfrOHN3fFaQ',
			'Content-Type: application/json'
			);

	   $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);  
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
       $result = curl_exec($ch);           
       if ($result === FALSE) {
           die('Curl failed: ' . curl_error($ch));
       }
       curl_close($ch);
       return $result;
	}

	public function push(){
		$this->load->library('form_validation');
		$conn = mysqli_connect("203.250.148.23", "root", "ngn787178", "smartHome");
		//push테이블 다 긁어옴
		$query = $this->fcm_model->getTokenList();	
		if(count($query)>0){	
			$time = date("H:i").":00";
			foreach($query->result() as $row){
				if($row->pushToken == $time)
					$tokens[] = $row->pushToken;
			}
		}
		
		$this->form_validation->set_rules('title', 'title','required');
		$this->form_validation->set_rules('body', 'body', 'required');

		if($this->form_validation->run() == false){
			$this->load->view('pushnoti');
		} else{
			$data = array(
				'title' => $this->input->post('title'),
				'body' => $this->input->post('body')
			);
		
			$result = $this->push_notification($tokens, $data);
			echo $result;

			$this->load->view('pushnoti');	
			
		}
	}
	
}
