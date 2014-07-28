{{ Form::open() }}

<div class="content-wrapper">
	<div class="page-settings">
		<a href="#settings" class="settings">
			<svg viewBox="0 0 512 512" class="icon-settings">
			  <use xlink:href="#icon-settings"></use>
			</svg>
		</a>
	</div>
	<div class="options">
		{{ Form::submit('Create', array('class'=>'button blue save'))}}
	</div>
	<input class="headline" type="text" name="title" placeholder="Type your title" value="" />

	<div class="block span {{ app::make('Utilities')->variable($block['class']) }}">
		<textarea class="mark" placeholder="Add your content"></textarea>
		<div class="handle"></div>
		<div class="move"></div>
	</div>

</div>

{{ Form::close() }}