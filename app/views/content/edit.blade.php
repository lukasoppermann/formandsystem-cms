{{ Form::open(array('route' => array('content.update', $content->id), 'method' => 'put' ) ) }}

<div class="content-wrapper">
	<div class="page-settings">
		<div class="settings-wrap"><span class="icon icon-settings"></span></div>
	</div>
	<div class="options">
		{{ Form::submit('Save', array('class'=>'button blue save'))}}
	</div>
	<input class="headline" type="text" name="title" placeholder="Type your title" value="{{$content->title}}" />
	@foreach ( $content->data as $section )
	
		@foreach ( $section->content as $block )

			<div class="block span {{ variable($block->class) }}">
			@if ($block->type === 'text')
				<textarea class="mark" name="text">{{ variable($block->content) }}</textarea>
			@endif
				<div class="handle"></div>
				<div class="move"></div>
			</div>
			
		@endforeach
		
	@endforeach

</div>

{{ Form::close() }}