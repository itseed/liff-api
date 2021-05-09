<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reward_model extends CI_Model
{
  public function get_reward()
  {
    $query = "SELECT * FROM reward";
    return $this->db->query($query);
  }

  public function collect_point($users_id, $point)
  {
    $query = "INSERT INTO `reward_history` (`reward_history_type`, `reward_history_point`, `reward_history_date`, `users_id`) VALUES ('collect', '$point', NOW(),'$users_id')";
    return $this->db->query($query);
  }

  public function redeem_point($users_id, $point)
  {
    $query = "INSERT INTO `reward_history` (`reward_history_type`, `reward_history_point`, `reward_history_date`, `users_id`) VALUES ('redeem', '$point', NOW(), '$users_id')";
    return $this->db->query($query);
  }

  public function get_history($users_id){
    $query = "SELECT * FROM reward_history WHERE `users_id` = '$users_id'";
    return $this->db->query($query);
  }
}
