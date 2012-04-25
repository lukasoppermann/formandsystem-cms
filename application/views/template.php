<?php			
	if( $this->config->compression('compression','html') == TRUE && ENVIRONMENT != 'development')
	{
		ob_start("ob_gzhandler");
		header("cache-control: must-revalidate");
		header("expires: ".gmdate('D, d M Y H:i:s', time() + $this->config->compression('expire','html'))." GMT");
	}
	else
	{
		header("cache-control: must-revalidate");
	}
?>
<?=nl2br($this->load->view('header')); ?>

<?=$page; ?>
<?=nl2br($this->load->view('footer')); ?>
<?
	echo fs_benchmark();
?>