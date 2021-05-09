<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reward extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('reward_model');
  }

  public function index()
  {
    $this->load->view('welcome_message');
  }


  public function get_reward()
  {
    $query = $this->reward_model->get_reward();
    if ($query->num_rows() > 0) {
      $data = array();
      foreach ($query->result() as $row) {
        $data[] =  array(
          'reward_id' => $row->reward_id,
          'reward_name' => $row->reward_name,
          'reward_des' => $row->reward_des,
          'reward_point' => $row->reward_point
        );

        $response = array(
          'status' => 'success',
          'data' => $data
        );
      }
    } else {
      $response = array(
        'status' => 'fail',
        'message' => 'no data'
      );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
  }

  public function redeem_point($users_id, $point)
  {
    $query = $this->reward_model->redeem_point($users_id, $point);

    if ($query) {
      $response = array(
        'status' => 'success',
        'message' => 'Redeem Success'
      );
    } else {
      $response = array(
        'status' => 'fail',
        'message' => 'no data'
      );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
  }

  public function collect_point($users_id, $point, $code)
  {

    if ($code == "123") {
      $query = $this->reward_model->collect_point($users_id, $point);

      if ($query) {
        $response = array(
          'status' => 'success',
          'message' => 'Collect Success'
        );
      } else {
        $response = array(
          'status' => 'fail',
          'message' => 'no data'
        );
      }
    } else {
      $response = array(
        'status' => 'fail',
        'message' => 'Code is Wrong'
      );
    }


    header('Content-Type: application/json');
    echo json_encode($response);
  }

  public function history($users_id)
  {
    $query = $this->reward_model->get_history($users_id);
    if ($query->num_rows() > 0) {
      $data = array();
      foreach ($query->result() as $row) {
        $data[] =  array(
          'reward_history_id' => $row->reward_history_id,
          'reward_history_type' => $row->reward_history_type,
          'reward_history_date' => $row->reward_history_date,
          'reward_history_point' => $row->reward_history_point
        );

        $response = array(
          'status' => 'success',
          'data' => $data
        );
      }
    } else {
      $response = array(
        'status' => 'fail',
        'message' => 'no data'
      );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
  }
}
