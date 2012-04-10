<?php
	$CI = &get_instance();			
	if( $CI->config->compression('compression','html') == TRUE)
	{
		ob_start("ob_gzhandler");
		header("cache-control: must-revalidate");
		header("expires: ".gmdate('D, d M Y H:i:s', time() + $CI->config->compression('expire','html'))." GMT");
	}
?>
<?=nl2br($this->load->view('header')); ?>

<?=$page; ?>

<?=nl2br($this->load->view('footer')); ?>