<form action="<?=current_url()?>" method="post" accept-charset="utf-8" class="form">
	<input type="hidden" name="id" value="<?=$id?>">
	<div class="form-field">
		<label for="title">Title</label>
		<input type="text" name="title" value="<?=variable($title)?>" />
	</div>
	<div class="form-field">
		<label for="meta_title">SEO Title</label>
		<input type="text" name="meta_title" value="<?=variable($meta_title)?>" />
	</div>
	<div class='form-field'>
		<label for="excerpt">Excerpt</label>
		<textarea name="excerpt" rows="5" cols="100"><?=variable($excerpt)?></textarea>
	</div>
	<div class="form-field">
		<label for="text">Content</label>
		<textarea name="text" rows="20" cols="200"><?=variable($text)?></textarea>
	</div>
	<div class="form-field half">
		<label for="permalink">Permalink</label>
		<input type="text" name="permalink" value="<?=variable($permalink)?>" />
	</div>
	<div class="form-field half">
		<label for="tags">Tags</label>
		<input type="text" name="tags" value="<?=variable($tags)?>" />
	</div>
	<div class="form-field half">
		<div>
			<label for="draft">Draft</label>
			<input type="radio" name="status" value="2" id="draft"<?=($status == '2' ? ' checked="checked"' : '')?>/>
		</div>
		<div>	
			<label for="published">Published</label>
			<input type="radio" name="status" value="1" id="published" <?=($status == '1' ? ' checked="checked"' : '')?> />
		</div>
	</div>
	<div class="form-field half">
		<input type="submit" value="save changs" />
	</div>
</form>