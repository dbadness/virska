This is the edit section page for <?=$user->first_name?> <?=$user->last_name?>.
<br><br>
Section name: <strong><?=$section['section_name']?></strong>
<br><br><hr>
<div id="new-assignment">
	<form class="form" name="new_assignment" action="/professor/p_add_assignment" method="post">
		<input type="hidden" name="section_id" value="<?=$section['section_id']?>">
		<label for="name">Assignment Title</label>
		<input type="text" size="50" name="name">
		<br>
		<br>
		<label for="date">Date to be posted:</label>
		<input type="text" name="date" id="datepicker" size="10">
		<br>
		<br>
		<input type="submit" value="Add Assignment">
	</form>
</div>
<div style="clear:both;"></div>
<hr>