{{ Form::open(array('route' => array('content.update', $content->id), 'method' => 'put' ) ) }}

<div class="content-wrapper">
	<div class="page-settings">
		<svg viewBox="0 0 512 512" class="icon-settings">
		  <use xlink:href="#icon-settings"></use>
		</svg>
	</div>
	<div class="options">
		{{ Form::button('Save', array('class'=>'button blue save'))}}
	</div>
		<input class="headline" type="text" name="title" placeholder="Type your title" value="{{$content->title}}" />
		
		<div class="page-content">
		@foreach ( $content->data as $section )
		<section class="block-content" data-class="{{{ variable($section->class) }}}">
		<section class="block-content" data-class="{{{ variable($section->class) }}}">
			@foreach ( $section->content as $block )

				<div class="block">
				@if ($block->type === 'text')
					<textarea data-column="{{{ $block->column }}}" class="mark block-content" data-type="{{{ $block->type }}}" data-class="{{{ variable($block->class) }}}" name="text">{{ variable($block->content) }}</textarea>
				@elseif ($block->type === 'image')
					<img src="{{{ variable($block->content->src) }}}" alt="{{{ variable($block->content->description) }}}" class="image block-content"
						 data-class="{{{ variable($block->class) }}}" data-type="{{{ $block->type }}}" />
				@endif
					<div class="handle"></div>
					<div class="move"></div>
				</div>
			
			@endforeach
		</section>
				</section>
		@endforeach
	</div>
	
</div>

{{ Form::close() }}