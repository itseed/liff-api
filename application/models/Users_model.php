<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users_model extends CI_Model
{
  public function get_user_from_uid($uid)
  {
    $query = "SELECT * FROM users WHERE uid = '$uid' LIMIT 1";
    return $this->db->query($query);
  }

  public function add_user($fullname, $email, $mobile, $uid){
    $query = "INSERT INTO `users` (`users_id`, `fullname`, `email`, `mobile`, `uid`) VALUES (NULL, '$fullname', '$email', '$mobile', '$uid')";
    return $this->db->query($query);
  }
}
