<div class="note">
	<h3><?=$section['class_name']?> - <?=$section['class_code']?> <?=$section['section_name']?></h3>
	<i>Last Modified: <?=Time::display($note['modified'])?></i>
		<form class="note" id="editNote" action="/student/p_edit_note" method="post" >
			<input type="hidden" name="note_id" value="<?=$note['note_id']?>">
			<br>
			<br>
			Title:
			<br>
			<input type="text" name="title" size="50" value="<?=$note['title']?>" id="title">
			<br>
			<br>
			Note:
			<br>
			<!-- We need to find a sweet jQuery/JS RTF editor to plop in here -->
			<textarea name="content" id="content" rows="10" cols="110"><?=$note['content']?></textarea>
			<br>
			<br>
			<!-- Can the button element house an action attribute so we don't have to href it? -->
			<a href="/student/notes"><button>Back to Notes</button></a><input type="submit" value="Save Note">
		</form>
</div>
	