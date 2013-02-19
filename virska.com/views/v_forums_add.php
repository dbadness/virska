Add a new thread to <?=$section['class_code']?> - <?=$section['section_name']?>.

<form class="newThread" method="post" action="/forums/p_add_thread">
	<input type="hidden" name="section_id" value="<?=$section['section_id']?>">
	<input name="title" maxlength="50">
	<textarea name="comment"></textarea>
	<input type="submit" value="Post Thread">
</form>