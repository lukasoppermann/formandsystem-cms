@section('contentMenu')

<ul id="contentnav">
	@foreach ($nav as $item)
		@if ( isset($item['content']) )
			<li class="nav-list-item">
				<div class="nav-item">
					<a class="nav-link" href="#">
						<span class="icon icon-page"></span>
						{{ $item['content']['menu_label'] }}
					</a>
					<a href="#visible" class="edit-tool status"><span class="active icon icon-eye"></span></a>
			
					<div class="edit-tool page-link-container">
						<span class="icon icon-link"></span>
						<input class="page-link" type="text" value="" placeholder="/link-to-page" />
					</div>
			
					<div class="edit-tool delete"><a href="#delete">delete</a></div>
				</div>
				
			</li>
		@endif
	@endforeach
</ul>

@stop

<!-- <ul id="contentnav">
	
	<li class="nav-list-item">
		
		<div class="nav-item">
			
			<a class="nav-link" href="#"><span class="icon icon-page"></span>Home</a>
			
			<a href="#visible" class="edit-tool status"><span class="active icon icon-eye"></span></a>
			
			<div class="edit-tool page-link-container">
				<span class="icon icon-link"></span>
				<input class="page-link" type="text" value="" placeholder="/link-to-page" />
			</div>
			
			<div class="edit-tool delete"><a href="#delete">delete</a></div>
			
		</div>

-->