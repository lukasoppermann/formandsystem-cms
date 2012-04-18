<?php
	$CI = &get_instance();			
	if( $CI->config->compression('compression','html') == TRUE && ENVIRONMENT != 'development')
	{
		ob_start("ob_gzhandler");
		header("cache-control: must-revalidate");
		header("expires: ".gmdate('D, d M Y H:i:s', time() + $CI->config->compression('expire','html'))." GMT");
	}
	else
	{
		header("cache-control: must-revalidate");
	}
?>
<?=nl2br($this->load->view('header')); ?>

<?=$page; ?>

<?
if( ENVIRONMENT == 'development' )
{
	css_add('benchmark');
	echo nl2br($this->load->view('benchmark'));
}
?>
<?=nl2br($this->load->view('footer')); ?>