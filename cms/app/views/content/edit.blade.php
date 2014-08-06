{{ Form::open(array('route' => array('content.update', $content['id']), 'method' => 'put', 'data-article_id' => $content['article_id'] ) ) }}
<div class="content-wrapper">
	<div class="page-settings">
		<svg viewBox="0 0 512 512" class="icon-settings">
		  <use xlink:href="#icon-settings"></use>
		</svg>
	</div>
	<div class="options">
		{{ Form::button('Save', array('class'=>'button blue save'))}}
	</div>
		<div class="page-content">
		@if( is_array($content['data']) )
			@foreach ( $content['data'] as $section )
				<section class="block-content content-section grid" data-class="{{{ app::make('Utilities')->variable($section['title']) }}}">
					<div class="settings">
						<svg viewBox="0 0 512 512" class="icon-settings">
						  <use xlink:href="#icon-settings"></use>
						</svg>
					</div>
					<div class="section-drag-handle"></div>
					@if( isset($section['children']) )
						@foreach ( $section['children'] as $block )

							<div class="block resizable column-{{{$block['column']}}}of12" data-column="{{{ $block['column'] }}}" data-type="{{{ $block['type'] }}}" data-class="{{{ app::make('Utilities')->variable($block['class']) }}}">
								<div class="settings">
									<svg viewBox="0 0 512 512" class="icon-settings">
									  <use xlink:href="#icon-settings"></use>
									</svg>
								</div>
								<div class="drag-handle"></div>
							@if ($block['type'] === 'text')
								<textarea class="mark block-content" name="text">{{ app::make('Utilities')->variable($block['content']) }}</textarea>
							@elseif ($block['type'] === 'image')
								<img src="{{{ app::make('Utilities')->variable($block['content']['src']) }}}" alt="{{{ app::make('Utilities')->variable($block['content']['description']) }}}" class="image block-content"
									 data-class="{{{ app::make('Utilities')->variable($block['class']) }}}" data-type="{{{ $block['type'] }}}" />
							@endif
								<div class="handle"></div>
							</div>

						@endforeach
					@endif
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
