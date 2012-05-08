	</div>
	<div id="footer">
		
	</div>	
</div><?=!empty($dialog) ? $dialog : ''; ?>	
<? 
echo js('jquery', FALSE); // somehow there is a compression problem
echo js('default', TRUE); // somehow there is a compression problem
echo fs_debug_print_js();
// echo copyright();
?>
</body>
</html>
