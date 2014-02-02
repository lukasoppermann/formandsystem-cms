<div class="content-wrapper">
	<div class="page-settings">
		<div class="settings-wrap"><span class="icon icon-settings"></span></div>
	</div>
	<div class="options">
		<div class="button blue save">Save</div>
	</div>
	<input class="headline" type="text" placeholder="Type your title" value="{{$content['title']}}" />
	
	@foreach ( $content['content'] as $section )
	
		@foreach ( $section['content'] as $block )
		<?
		// echo("<pre>");print_r($block);echo("</pre>");
		?> 
			<div class="block span {{ variable($block['class']) }}">
			@if ($block['type'] === 'text')
				<textarea class="mark">{{ variable($block['content']) }}</textarea>
			@endif
				<div class="handle"></div>
			</div>
		@endforeach
	@endforeach
	
	<?
	// echo("<pre>");print_r($content);echo("</pre>");
	?>
</div>
