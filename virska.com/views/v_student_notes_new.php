This is the page where the user can add a new note to their notes.
<br>
<br>
<form id="newNote" action="p_add_note" method="post" >
	Section:
	<select name="section_id">
		<?foreach($sections as $section):?>
			<option value="<?=$section['section_id']?>">
				<?=$section['class_name']?> <?=$section['section_name']?>
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
	<a href="/student/notes"><button>Cancel</button></a><input type="submit" value="Add Note">
</form>
	