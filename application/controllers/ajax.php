<?php if (! defined('BASEPATH')) exit('No direct script access');

class Ajax extends CI_Controller {

	//php 5 constructor
	function __construct() 
 	{
		parent::__construct();
		// get config from db
		$this->config->set_config_from_db();
		// set charset
		Header("Content-type: text/html;charset=UTF-8");
		// set header for browser to not cache stuff
		Header("Last-Modified: ". gmdate( "D, j M Y H:i:s" ) ." GMT"); 
		Header("Expires: ". gmdate( "D, j M Y H:i:s", time() ). " GMT"); 
		Header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1 
		Header("Cache-Control: post-check=0, pre-check=0", FALSE); 
		Header("Pragma: no-cache" ); // HTTP/1.0
	}
	// --------------------------------------------------------------------
	/**
	 * user
	 *
	 * @description	ajax request for user
	 * 
	 */
	function user( $method = null, $key = null )
	{
		// --------------------------------------------------------------------
		// retrieve password & user data
		if( $method = 'retrieve' )
		{
			// ----------------------------------------------------------------
			// retrieve password
			if( $key = 'password' )
			{
				// get user data
				$user_data = db_select(config('db_user'), array( array('user' => $this->input->post('user'), 
				'email' => $this->input->post('user')) ), array('limit' => 1, 'single' => TRUE));
				// set log data
				$log = array('message' => lang('password_recovery_request'), 'username' => $user_data['user'] );
				// log recover
				$this->fs_log->raw_log(array('type' => 3, 'user_id' => $user_data['id'], 'data' => $log)); 
				// email data
				$email['subject'] = 'Recover your password';
				$email['title']	  = 'Recover your password';
				$email['content'] = 'To retrieve your password <a href="'.current_url().'/{key}">follow this link</a>.';
			}
			// ----------------------------------------------------------------
			// retrieve user data
			elseif( $key = 'userdata' )
			{
				
			}
			// ----------------------------------------------------------------
			// activate blocked user
			elseif( $key = 'blocked_user' )
			{
				// get user data
				$user_data = db_select(config('db_user'), array( array('user' => $this->input->post('user'), 
				'email' => $this->input->post('user')) ), array('limit' => 1, 'single' => TRUE));
				// set log data
				$log = array('message' => lang('user_unblock_request'), 'username' => $user_data['user'] );
				// log recover
				$this->fs_log->raw_log(array('type' => 3, 'user_id' => $user_data['id'], 'data' => $log));
				// email data
				$email['subject'] = 'Reactivate your profile';
				$email['title']	  = 'Reactivate your profile';
				$email['content'] = 'To reactivate your profile <a href="'.current_url().'/{key}">follow this link</a>.';				
			}
			// ----------------------------------------------------------------
			// create retrieval key
			$retrieval_key = random_string('alnum', mt_rand(75, 100));
			$email['content'] = str_replace('{key}', $retrieval_key, $email['content']);
			// ----------------------------------------------------------------
			// add retrival key & timestamp to db
			db_update(config('db_user'), array('id' => $user_data['id']), array('data/retrieval_key' => $retrieval_key, 
					'data/retrieval_time' => (time()+config('retrieval_time')) ), TRUE, 'data' );
			// ----------------------------------------------------------------
			// send retrieval email
			//
			// load email library
			$this->load->library('email');
			// set email data
			$this->email->from(config('email_support/'.config('lang_id')), config('page_name/'.config('lang_id')).' - Form&System CMS');
			$this->email->to($user_data['email']); 
			// // add subject
			$this->email->subject($email['subject']);
			// // add message
			$this->email->message($this->load->view('emails/email_template', $email, TRUE));	
			// // send email
			if( /* !$this->email->send()*/ 1 != 1 )
			{
			  show_error($this->email->print_debugger());
			}
			else
			{
				json_encode(array('message' => lang('email_sent_to_user'), 'success' => TRUE, 'error' => FALSE));
			}
		}
		
	}
}