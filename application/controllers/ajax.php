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
		$this->load->library('form_validation');
		// --------------------------------------------------------------------
		// retrieve password & user data
		if( $method == 'login' )
		{
			// restore
			if( $this->input->post('retrieval_key') != null )
			{
				$user 			= $this->input->post('fs_username');
				$password 		= $this->input->post('fs_password');
				$retrieval_key  = $this->input->post('retrieval_key');
				$reset			= $this->input->post('retrieval_reset');
				//
				$this->fs_authentication->restore( $user, $password, $retrieval_key, $reset );
			}
			// try to log in
			if($this->fs_authentication->login() == TRUE)
			{
				// get user data
				$user_data = db_select(config('db_user'), array( array('user' => $this->input->post('fs_username'), 
				'email' => $this->input->post('fs_username')) ), array('select' => 'user, data', 'json' => 'data', 'limit' => 1, 'single' => TRUE));
				// get user images
				$db_images = db_select(config('db_files'), array( array('id' => variable($user_data['profile_image']), 
				'filename' => array('default-profile')), 'status' => 1 ), array('select' => 'id, filename, data', 
				'json' => 'data', 'single' => FALSE, 'index' => 'id'));
				// index images
				$images = index_array($db_images, 'filename');
				// get user image
				if( !isset($user_data['profile_image']) || $db_images[$user_data['profile_image']] == null )
				{
					$user_image = $images['default-profile'];
				}
				else
				{
					$user_image = $db_images[$user_data['profile_image']];
				}
				// set output
				$output = array('user_image' => media($user_image['filename'].'.'.$user_image['ext'], 'images'), 
				'username' => ucfirst($user_data['firstname']).' '.ucfirst($user_data['lastname']), 'user' => $user_data['user'], 
				'success' => TRUE, 'error' => FALSE);
			}
			else
			{
				// set succes False
				$output['success'] = 'FALSE';
				// get error message & field
				foreach($this->form_validation->get_errors() as $key => $message)
				{
					$output['error'] 			= $key;
					$output['message'] 			= $message;
					$output['user_blocked'] 	= $this->form_validation->form_data('user_blocked');				
				}
			}
			// return output to js fn as json
 			echo json_encode($output);
		}
		// --------------------------------------------------------------------
		// retrieve password & user data
		if( $method == 'retrieve' )
		{
			// ----------------------------------------------------------------
			// retrieve password
			if( $key == 'password' )
			{
				// get user data
				$user_data = db_select(config('db_user'), array( array('user' => $this->input->post('user'), 
				'email' => $this->input->post('user')) ), array('select' => 'id, user, email, data', 'limit' => 1, 'single' => TRUE, 'json' => 'data'));
				// set log data
				$log = array('message' => lang('password_recovery_request'), 'username' => $user_data['user'] );
				// log recover
				$this->fs_log->raw_log(array('type' => 3, 'user_id' => $user_data['id'], 'data' => $log)); 
				// email data
				$email['subject'] 	= 'Recover your password';
				$email['title']	  	= 'Recover your password';
				$email['teaser']	= 'If you can not read this email, copy the following link into your browser and hit return. '.base_url().'login/{key}';				
				$email['content']	= 'To retrieve your password <a href="'.base_url().'login/{key}">follow this link</a>.';
				// make user_data into array
				$user_data = array($user_data);
				// set reset TRUE
				$retrieval_reset = 'TRUE';
			}
			// ----------------------------------------------------------------
			// retrieve user data
			elseif( $key == 'userdata' )
			{
				// user full name
				$full_name = reduce_multiples(strtolower($this->input->post('user')), ' ', TRUE);
				// get user data
				$_user_data = db_select(config('db_user'), 'MATCH (data) AGAINST("'.$full_name.'")',
				array('select' => 'id, user, email, data', 'limit' => 1, 'single' => FALSE, 'json' => 'data')); 
				// loop through results
				foreach( (array) $_user_data as $user )
				{
					// check if full name is the same
					if( strtolower($user['firstname'].' '.$user['lastname']) == $full_name)
					{
						$user_data[] = $user;
						// set log data
						$log = array('message' => lang('user_unblock_request'), 'username' => $user['user'] );
						// log recover
						$this->fs_log->raw_log(array('type' => 3, 'user_id' => $user['id'], 'data' => $log));
					}
				}
				// email data
				$email['subject'] 	= 'Recover your password';
				$email['title']	  	= 'Recover your password';
				$email['teaser']	= 'If you can not read this email, copy the following link into your browser and hit return. '.base_url().'login/{key}';
				$email['content'] 	= 'To retrieve your password <a href="'.base_url().'login/{key}">follow this link</a>.';
				// set reset FALSE
				$retrieval_reset = 'FALSE';
			}
			// ----------------------------------------------------------------
			// activate blocked user
			elseif( $key == 'blocked_user' )
			{
				// get user data
				$user_data = db_select(config('db_user'), array( array('user' => $this->input->post('user'), 
				'email' => $this->input->post('user')) ), array('select' => 'id, user, email', 'json' => '', 'limit' => 1, 'single' => TRUE, 'json' => 'data'));
				// set log data
				$log = array('message' => lang('user_unblock_request'), 'username' => $user_data['user'] );
				// log recover
				$this->fs_log->raw_log(array('type' => 3, 'user_id' => $user_data['id'], 'data' => $log));
				// email data
				$email['subject'] 	= 'Reactivate your profile';
				$email['title']	  	= 'Reactivate your profile';
				$email['teaser']	= 'If you can not read this email, copy the following link into your browser and hit return. '.base_url().'/{key}';
				$email['content'] 	= 'To reactivate your profile <a href="'.base_url().'login/{key}">follow this link</a>.';		
				// make user_data into array
				$user_data = array($user_data);	
				// set reset FALSE
				$retrieval_reset = 'FALSE';	
			}
			// check if user exists
			if( isset($user_data) )
			{
				// loop through all users to recieve emails
				foreach( $user_data as $user )
				{
					// ----------------------------------------------------------------
					// create retrieval key
					$retrieval_key = random_string('alnum', mt_rand(75, 100));
					$message = str_replace('{key}', $user['user'].':'.$retrieval_key, $this->load->view('emails/email_template', $email, TRUE));
					// ----------------------------------------------------------------
					// add retrival key & timestamp to db
					db_update(config('db_user'), array('id' => $user['id']), array('data/retrieval_key' => $retrieval_key, 
							'data/retrieval_time' => (time()+config('retrieval_time')), 'data/retrieval_reset' => variable($retrieval_reset) ), TRUE, 'data' );		
					// ----------------------------------------------------------------
					// send retrieval email
					//
					// load email library
					$this->load->library('email');
					// set email data
					$this->email->from(config('email_support/'.config('lang_id')), config('page_name/'.config('lang_id')).' - Form&System CMS');
					$this->email->to($user['email']); 
					// add subject
					$this->email->subject($email['subject']);
					// add message
					$this->email->message($message);	
					// send email
					if( !$this->email->send() )
					{
						echo json_encode(array('message' => lang('email_not_sent_to_user'), 'success' => FALSE, 'error' => TRUE));
						// set log data
						$log = array('message' => lang('email_not_sent_to_user'), 'username' => $user['user'] );
						// log recover
						$this->fs_log->raw_log(array('type' => 4, 'user_id' => $user['id'], 'data' => $log));
					}
					// email not sent
					else
					{
						echo json_encode(array('message' => lang('email_sent_to_user'), 'success' => TRUE, 'error' => FALSE));
					}
				}
			}
			// wrong user fullname given
			else
			{
				echo json_encode(array('message' => lang('error_wrong_user'), 'success' => FALSE, 'error' => TRUE));
			}
		}
		// ----------------------------------------------------------------
		// get user data
		if( $method == 'get' )
		{
			// get user data
			$user_data = db_select(config('db_user'), array( array('user' => $this->input->post('user'), 
			'email' => $this->input->post('user')) ), array('select' => 'data', 'json' => 'data', 'limit' => 1, 'single' => TRUE));
			// create where condition
			if( isset($user_data['profile_image']) && $user_data['profile_image'] != null )
			{
				$where['id'] = $user_data['profile_image'];
			}
			$where['filename'] = array('default-profile');
			// get user image
			$db_images = db_select(config('db_files'), array( $where, 'status' => 1 ), array('select' => 'id, filename, data', 
			'json' => 'data', 'single' => FALSE, 'index' => 'id'));
			// index images
			$images = index_array($db_images, 'filename');
			// check if user exists
			if( $user_data == null )
			{
				// get random profile
				$this->lang->load('profiles');
				$profiles = array_values(lang('profiles'));
				$profiles = $profiles[rand(0, count($profiles)-1)];
				// return random name and profile picture
				echo json_encode( array('message' => lang('error_wrong_user'), 'class' => 'cms-profile', 
				'user_image' => media('profiles/'.$profiles['image'], 'layout'), 
				'username' => $profiles['name'], 'success' => FALSE, 'error' => TRUE) );
			}
			else
			{
				// get user image
				if( !isset($user_data['profile_image']) || $db_images[$user_data['profile_image']] == null )
				{
					$user_image = $images['default-profile'];
				}
				else
				{
					$user_image = $db_images[$user_data['profile_image']];
				}
				//
				echo json_encode(array('user_image' => media($user_image['filename'].'.'.$user_image['ext'], 'images'), 
				'username' => ucfirst($user_data['firstname']).' '.ucfirst($user_data['lastname']), 'success' => TRUE, 'error' => FALSE));
			}
		}
	}
	// --------------------------------------------------------------------
	/**
	 * user
	 *
	 * @description	ajax request for user
	 * 
	 */
	function template( )
	{
		echo $this->load->view( $this->input->post('template'), $this->input->post('data'), TRUE );
	}
	// end of class
}