{{ Form::open() }}

<div class="content-wrapper">
	<div class="page-settings">
		<div class="settings-wrap"><span class="icon icon-settings"></span></div>
	</div>
	<div class="options">
		{{ Form::submit('Create', array('class'=>'button blue save'))}}
	</div>
	<input class="headline" type="text" name="title" placeholder="Type your title" value="" />

	<div class="block span {{ variable($block['class']) }}">
		<textarea class="mark" placeholder="Add your content"></textarea>
		<div class="handle"></div>
		<div class="move"></div>
	</div>

</div>

{{ Form::close() }}