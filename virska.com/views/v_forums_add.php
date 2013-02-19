<div id="newThreadheader">
	Add a new thread to the <?=$section['class_name']?> (Section <?=$section['section_name']?>) forum.
</div>
<form class="newThread" method="post" action="/forums/p_add_thread">
	<input type="hidden" name="section_id" value="<?=$section['section_id']?>">
	<div class="spacer"></div>
	<div id="mewThreadTitleCopy">
		Title:
	</div>
	<input name="title" maxlength="50" id="newThreadTitle">
	<div id="newThreadTextCopy">
		Comment:
	</div>
	<textarea name="comment" id="newThreadText"></textarea>
	<div id="postButton">
		<input type="submit" value="Post Thread">
	</div>
</form>