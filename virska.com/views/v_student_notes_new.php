This is the page where the user can add a new note to their notes.
<br>
<br>
<form id="newNote" action="p_add_note" method="post" >
	Section:
	<select name="section_id">
		<?foreach($followed_sections as $followed_section):?>
			<option value="<?=$followed_section['section_id']?>">
				<?=$followed_section['class_name']?> <?=$followed_section['section_name']?>
			</option>
		<?endforeach;?>
	</select>
	<br>
	<br>
	Title:
	<br>
	<input type="text" name="title" id="title">
	<br>
	<br>
	Note:
	<br>
	<textarea name="content" id="content" rows="10" cols="40">
	</textarea>
	<br>
	<br>
	<input type="submit" value="Add Note">
</form>
	