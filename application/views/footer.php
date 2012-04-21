	</div>
	<div id="footer">
		
	</div>	
</div><?=!empty($dialog) ? $dialog : ''; ?>	
<? 
echo js('default', FALSE); // somehow there is a compression problem
echo fs_debug_print_js();
// echo copyright();
?>
</body>
</html>
