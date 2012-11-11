This is the edit section page for <?=$user->first_name?> <?=$user->last_name?>.
<br><br>
Section name: <strong><?=$section['section_name']?></strong>
<br><br><hr>
<div id="add-assignment">
	Want to add an assignment to this section?
	<form action="/professor/add_assignment" method="post">
		<input type="hidden" name="section_id" value="<?=$section['section_id']?>">
		<input type="submit" value="Add Assignment">
	</form>
</div>
<div style="clear:both;"></div>
<hr>
<?if(isset($assignments)):?>
	<?foreach($assignments as $assignment):?>
		<?=$assignment['name']?> is due on <?=$assignment['date']?>.<br><br>
	<?endforeach;?>
<?endif;?>