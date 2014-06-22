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
		<div id="headline">
			<input class="headline" type="text" name="title" placeholder="Type your title" value="{{$content->title}}" />
		</div>
		<div class="page-content">
		@if( is_array($content->data) )
			@foreach ( $content['data'] as $section )
				<section class="block-content content-section grid" data-class="{{{ variable($section->class) }}}">
					<div class="settings">
						<svg viewBox="0 0 512 512" class="icon-settings">
						  <use xlink:href="#icon-settings"></use>
						</svg>
					</div>
					<div class="section-drag-handle"></div>
					@foreach ( $section->children as $block )

						<div class="block column-{{{$block->column}}}of12">
							<div class="settings">
								<svg viewBox="0 0 512 512" class="icon-settings">
								  <use xlink:href="#icon-settings"></use>
								</svg>
							</div>
							<div class="drag-handle"></div>
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
			@endforeach
		@endif	
		<section class="content-section" id="add_section">
			<div class="add-content">
				<span class="text add-block" data-type="text">+</span>
			</div>
		</section>
	</div>
	
</div>

{{ Form::close() }}