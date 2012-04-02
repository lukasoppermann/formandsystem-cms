<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter MY_Controller Libraries
 *
 * @package		Form&System
 * @subpackage	Models
 * @author		Lukas Oppermann - veare.net
 * @link		http://doc.formandsystem.com/models/user
 */
Class User_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	// ---------------------------------------------------------------	
	function create()
	{
		$this->db->insert(config('db_user'), array('status' => '2')); 
		// return user id
		return $this->db->insert_id();
	}
	// ---------------------------------------------------------------
	function get($id = null, $single = false)
	{
		$this->db->select('id, email, status, user, group, data');
		$this->db->from($this->config->item('db_user'));
		//
		if($id != null)
		{
			foreach((array) $id as $_id)
			{
				$this->db->or_where('id', $_id);
			}
		}
		// fetch user
		$query = $this->db->get();
		// prepare user
		foreach ($query->result() as $row)
		{
			$user[$row->id] = array(
				'id' 		=> $row->id,
				'email' 	=> $row->email,
				'user' 		=> $row->user,
				'group' 	=> $row->group,
				'status' 	=> $row->status,
				'data' 		=> json_decode($row->data, TRUE)
			);
		}
		// return data
		// if just 1 user expected
		if($single == true)
		{
			reset($user);
			return $user[key($user)];
		}
		// of multiple users expected
		else
		{
			return $user;
		}
	}
	// ---------------------------------------------------------------
	function save($id = null)
	{
		$user['user'] 	= $this->input->post('username');
		$user['email'] 	= $this->input->post('email');
		$user['group'] 	= $this->input->post('group');
		$user['salt'] 	= random_string('alnum', mt_rand(16, 32));
		// prep password
		$new_password = $this->input->post('new_password');
		if($new_password != null && isset($new_password) && trim($new_password) === trim($this->input->post('repassword')))
		{
			$user['password'] = prep_password($this->input->post('new_password'), $user['salt']);
		}
		// data 
		$user['data']['keep_login'] = $this->input->post('keep_login');
		// prepare name
		$name = strtolower($this->input->post('name'));
		$name = explode(' ',$name);
		$user['data']['firstname'] = $name[0];
		$user['data']['lastname'] = $name[1];
		// prepare data
		$user['data'] = json_encode($user['data']);
		//
		$this->db->where('id', $id);
		$this->db->update($this->config->item('db_user'), $user);
	}
	// ---------------------------------------------------------------
	function delete($id = null)
	{
		if(_auth("/user/edit") && isset($id) && $id != null)
		{
			$this->db->where('id', $id);
			$this->db->delete($this->config->item('db_user'));
			return true;
		}
		
	}
}