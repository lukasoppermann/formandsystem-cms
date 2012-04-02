<?php
	// $CI = &get_instance();
	// $compression = $CI->config->item('compression');
	// 		
	// if( isset($compression['html']) && $compression['html'] == TRUE)
	// {
	// 	ob_start("ob_gzhandler");
	// 	header("cache-control: must-revalidate");
	// 	header("expires: ".gmdate('D, d M Y H:i:s', time() + $compression['expire'])." GMT");
	// }
?>
<?=nl2br($this->load->view('header')); ?>

<?=$page; ?>

<?=nl2br($this->load->view('footer')); ?>