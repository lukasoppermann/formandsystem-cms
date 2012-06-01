<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Form Validation config
|--------------------------------------------------------------------------
|
| Login Form
*/
$config['login'][] = array(
        'field' => 'fs_username',
        'label' => 'lang:username',
        'rules' => 'trim|xss_clean|required'
     );
$config['login'][] = array(
        'field' => 'fs_password',
        'label' => 'lang:password',
        'rules' => 'trim|xss_clean|required'
     );
/* End of file form_validation.php */
/* Location: ./application/config/form_validation.php */