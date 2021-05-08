<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('LINE_ACCESS_TOKEN', 'ohhp4uxeBaqqjAQ/EtlE2vGzSlosPf7AYQtTce8SYAjYvpW9CEOodqSjN3KftXiumKatZU1g3C5eszVUmIf4H/iCjpxeSreCdGM8tuwWl7cC6WMx+lwasPIDhmn2kMmaBKIZwqUQQHNDmlxWBCGbwAdB04t89/1O/w1cDnyilFU=');

class Users extends CI_Controller {
  function __construct()
  {
    parent::__construct();
    $this->load->model('users_model');
  }

	public function index()
	{
		$this->load->view('welcome_message');
	}

  public function verify($uid){
    // echo $uid;
    $query = $this->users_model->get_user_from_uid($uid);
    // print_r($query->num_rows());
    if($query->num_rows() > 0){
      $result = $query->result();
      $response = array(
        'status' => 'success',
        'data' => array(
          'users_id' => $result[0]->users_id,
          'fullname' => $result[0]->fullname,
          'email' => $result[0]->email,
          'mobile' => $result[0]->mobile,
          'uid' => $result[0]->uid
        )
      );
    }else{
      $response = array(
        'status' => 'fail',
        'message' => 'no data'
      );
    }

    header('Content-Type: application/json');
    echo json_encode( $response );
  }

  public function register(){
    $content = file_get_contents('php://input');
    $data = json_decode($content, true);
    if(!is_null($data)){
      if(isset($data['name']) && isset($data['email']) && isset($data['mobile']) && isset($data['uid'])){
        $query = $this->users_model->add_user($data['name'], $data['email'], $data['mobile'], $data['uid']);
        if($query){
          $response = array(
            'status' => 'success',
            'message' => 'Add data success'
          );
          $this->change_richmenu($data['uid']);
        }else{
          $response = array(
            'status' => 'fail',
            'message' => 'Invalid data'
          );
        }
      }else{
        $response = array(
          'status' => 'fail',
          'message' => 'Invalid data'
        );
      }
    }else{
      $response = array(
        'status' => 'fail',
        'message' => 'Invalid data'
      );
    }
    // echo $body['name'];
    //add the header here
    header('Content-Type: application/json');
    echo json_encode( $response );
  }

  private function change_richmenu($uid){
    $richMenuId = "richmenu-cd2458b729eb21c25566140ba2cc0c71";
    $url = 'https://api.line.me/v2/bot/user/'.$uid.'/richmenu/'.$richMenuId;

    $headers = [
      'Content-Type: application/json',
      'Authorization: Bearer ' . LINE_ACCESS_TOKEN
    ];

    $body = [];
    
    $options = [
      CURLOPT_URL => $url,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HTTPHEADER => $headers,
      CURLOPT_POSTFIELDS => $body
    ];

    $curl = curl_init();
    curl_setopt_array($curl, $options);
    $res = curl_exec($curl);
    curl_close($curl);

    // header('Content-Type: application/json');
    // print_r($res);
  }

  public function unlink_richmenu($uid) {
    $url = 'https://api.line.me/v2/bot/user/'.$uid.'/richmenu/';

    $headers = [
      'Content-Type: application/json',
      'Authorization: Bearer ' . LINE_ACCESS_TOKEN
    ];

    $body = [];
    
    $options = [
      CURLOPT_URL => $url,
      CURLOPT_CUSTOMREQUEST => 'DELETE',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HTTPHEADER => $headers,
      CURLOPT_POSTFIELDS => $body
    ];

    $curl = curl_init();
    curl_setopt_array($curl, $options);
    $res = curl_exec($curl);
    curl_close($curl);

    // header('Content-Type: application/json');
    // print_r($res);
  }
}
