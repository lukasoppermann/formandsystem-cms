<?=doctype('html5')."\n"; ?>
<html lang="<?=config('lang_abbr')?>">
<head>
<?
echo favicon('favicon');
echo meta();
echo css('default', FALSE);
echo fs_debug_print_css();
echo title('All variables for title are missing | Form&amp;System');
?>
</head>
<body<?=variable($body_id).variable($body_class); ?>>
<div id="page_wrapper">
	<div id="header">
		<?=logo(array('file' => media('formandsystem_logo.png', 'layout'), 'alt' => 'Form and System', 'url' => active_url(TRUE).'dashboard'))."\n"; ?>
		<?=variable($menu['main'])?>
		<?=variable($menu['meta'])?>
	</div>
	<div id="sub_menu_bar">
		<?=variable($menu['system_menu'])?>
		<?=variable($menu['submenu'])?>
	</div>
	<!-- <div id="content" style="height:<?=get_cookie('content_height')?>px;"> -->
		<div id="content">	
        <!-- DEBUG CONSOLE -->
		    <?=fs_show_log();?>
        <!-- END DEBUG CONSOLE -->		    
		<? if(isset($sidebar))
		{ 
		echo '<div id="sidebar">
				<form name="sidebar" action="#">';
			foreach($sidebar['element'] as $element)
			{
				echo "<div class='sidebar-element-container ".variable($element['class'])."'>";
				if(isset($element['title']))
				{
					echo '<h4 class="sidebar-headline">'.$element['title'].'</h4>';
				}
				if(isset($element['content']))
				{
					echo '<div class="sidebar-element">'.$element['content'].'</div>';
				}
				echo "</div>";
			}
		echo '</form></div>';
		} ?>