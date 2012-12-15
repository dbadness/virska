<strong><?=$section['class_name']?>, Section <?=$section['section_name']?></strong>
<br><br><hr>
<div id="add-assignment">
	<div id="new-assignment">
		<form class="form" name="new_assignment" action="/professor/p_add_assignment" method="post">
			<input type="hidden" name="section_id" value="<?=$section['section_id']?>">
			<label for="name">Assignment Title:</label>
			<input type="text" size="50" name="name">
			<br>
			<br>
			<label for="date">Due Date:</label>
			<input type="text" name="date" id="datepicker" size="10">
			<br>
			<br>
			<input type="submit" value="Add Assignment">
		</form>
	</div>
	<div style="clear:both;"></div>
</div>
<div style="clear:both;"></div>
<hr>
<div id="assignmentWrapper">
	<div id="assignmentHeader">
		<div class="assignment-atr">
			<i><strong>Due Date</i></strong>
		</div>
		<div class="assignment-name">
			<i><strong>Description</i></strong>
		</div>
		<div class="assignment-attach">
			<i><strong>Attachment?</i></strong>
		</div>
	</div>
	<div style="clear;both:"></div>
	<?foreach($assignments as $assignment):?>
		<div class="assignment">
			<div class="assignment-atr">
				<?=$assignment['date']?>
			</div>
			<div class="assignment-name">
				<?=$assignment['name']?>
			</div>
			<div class="assignment-attach">
				Yes
			</div>
			<div style="clear;both:"></div>
		</div>
	<?endforeach;?>
</div>