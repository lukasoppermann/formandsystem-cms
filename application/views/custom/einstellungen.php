<div id="sidebar"> 
	<h4 class="sidebar-headline active">Sprachen</h4>
	<div class="sidebar-element">
		<span id="new_language">
			<span class="drag-item icon draggable">
				Neue Sprache
			</span>
		</span>
	</div>
</div>
<div id="stage"> 
	<ul id="language_list" class="sortable">
		<li class="sprach-container">
			<div class="form-element inline-label">
				<label for="input_box">Sprachbezeichnung</label>
				<input name="input_box" id="input_box" type="text" value="" class="input" />
			</div>
			<div class="form-element inline-label">
				<label for="input_box">Sprachbezeichnung (Dt.)</label>
				<input name="input_box" id="input_box" type="text" value="" class="input" />
			</div>
			<div class="form-element left-label">
				<label for="abbr">Abkürzung</label>
				<input name="abbr" id="abbr" type="text" value="" class="input" />
			</div>
			<div class="form-element left-label">
				<label for="input_box">Aktivieren</label>
				<input name="input_box" id="input_box" type="checkbox" value="active" class="toggle" />
			</div>
			<div class="form-element left-label">
				<label for="input_box">Flagge</label>
				<div class="flag"><div class="bubble"></div></div>
			</div>
		</li>
		<li class="sprach-container">
			<div class="form-element inline-label">
				<label for="input_box">Sprachbezeichnung</label>
				<input name="input_box" id="input_box" type="text" value="English" class="input" />
			</div>
			<div class="form-element inline-label">
				<label for="input_box">Sprachbezeichnung (Dt.)</label>
				<input name="input_box" id="input_box" type="text" value="" class="input" />
			</div>
			<div class="form-element left-label">
				<label for="input_box">Abkürzung</label>
				<input name="input_box" id="input_box" type="text" value="" class="input" />
			</div>
			<div class="form-element left-label">
				<label for="activate">Aktivieren</label>
				<input name="activate" id="activate" type="checkbox" value="active" class="toggle" checked="checked" />
			</div>
			<div class="form-element left-label">
				<label for="input_box">Flagge</label>
				<input name="input_box" id="input_box" type="text" value="" class="input" />			
			</div>
		</li>
		<li class="sprach-container">
			<div class="form-element inline-label">
				<label for="input_box">Sprachbezeichnung</label>
				<input name="input_box" id="input_box" type="text" value="French" class="input" />
			</div>
			<div class="form-element inline-label">
				<label for="input_box">Sprachbezeichnung (Dt.)</label>
				<input name="input_box" id="input_box" type="text" value="" class="input" />
			</div>
			<div class="form-element left-label">
				<label for="input_box">Abkürzung</label>
				<input name="input_box" id="input_box" type="text" value="" class="input" />
			</div>
			<div class="form-element left-label">
				<label for="input_box">Aktivieren</label>
				<input name="input_box" id="input_box" type="checkbox" value="active" class="toggle" />
			</div>
			<div class="form-element left-label">
				<label for="input_box">Flagge</label>
				<input name="input_box" id="input_box" type="text" value="" class="input" />			
			</div>
		</li>
	</ul>
</div>
<?
js_add_lines('default',
'var new_language = \'<li class="sprach-container"><div class="form-element inline-label"><label for="input_box"></label><input name="input_box" id="input_box" type="text" value="" class="input" /></div><div class="form-element inline-label"><label for="input_box">Sprachbezeichnung (Dt.)</label><input name="input_box" id="input_box" type="text" value="" class="input" /></div><div class="form-element left-label"><label for="input_box">Abkürzung</label><input name="input_box" id="input_box" type="text" value="" class="input" /></div><div class="form-element left-label"><label for="input_box">Aktivieren</label><input name="input_box" id="input_box" type="text" value="" class="input" /></div><div class="form-element left-label"><label for="input_box">Flagge</label><input name="input_box" id="input_box" type="text" value="" class="input" /></div></li>\';
var insert_id = null;

$(".sortable").sortable({
	tolerance: \'pointer\',
	containment: \'parent\',
	items : \'li\',
	revert: true,
	distance: 10,
	receive: function(event, ui) { 
		var clone = ui.item.clone();
		insert_id = $(\'#language_list li\').length + 1;
		var add_item = $(new_language).filter(".sprach-container").attr("id",insert_id);
		$(\'#language_list .drag-item\').replaceWith(add_item);
		clone.appendTo(\'#new_language\');	
	},
	update: function(event, ui) {
		$(\'#language_list #\'+insert_id).children("div").children("input:first").focus();
		$("#content").css("height","auto");
		$("#content").height($(document).height()-82);
	}
});


$("#new_language").sortable({
	connectWith: \'.sortable\',
	placeholder: \'placeholder-language\',
	forcePlaceholderSize: true,
	tolerance: \'pointer\'
});



$(".drag-item").live(\'mouseup\', function(){
	var pos = $("#new_language").offset();	
	var cur_pos = $(this).offset();
	if(Math.abs(pos.top-cur_pos.top) < 10 || Math.abs(pos.left-cur_pos.left) < 10)
	{
		$(\'#language_list\').append(new_language);
		$(\'#language_list li:nth-child(\'+$(\'#language_list li\').length+\')\').children("div").children("input:first").focus();
		$("#content").css("height","auto");
		$("#content").height($(document).height()-82);
	}
});
	$("#sidebar_menu").accordion({header: \'.sidebar-item\'});
	$("#sidebar_menu li").click(function(){
		$("#sidebar_menu .active").removeClass(\'active\');
		$(this).addClass(\'active\');
	});');