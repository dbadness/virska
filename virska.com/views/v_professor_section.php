<strong><?=$section['class_name']?>, Section <?=$section['section_name']?></strong>
<br><br><hr>
<div id="newAssignmentWrapper">
	<div id="newAssignment">
		<form id="newAssignmentForm" action="/professor/p_upload_assignment" method="post" enctype="multipart/form-data">
			<input type="hidden" name="section_id" value="<?=$section['section_id']?>">
			<label for="description">Assignment Description:</label>
			<br>
			<input size="40" name="description">
			<br>
			<label for="date">Due Date:</label>
			<br>
			<input name="date" id="datepicker" size="10">
			<br>
			<label for="attachment">Attachment</label>
			<br>
			<input type="file" name="doc">
			<br>
			<input type="submit" value="Add Assignment">
		</form>
	</div>
	<div style="clear:both;"></div>
</div>
<hr>
<div id="assignmentHeader" class="listHeader">
	<div id="dueDateLabel">
		<i>Due Date</i>
	</div>
	<div id="descriptionLabel">
		<i>Description</i>
	</div>
	<div id="attachmentLabel">
		<i>Attachment</i>
	</div>
	<div style="clear:both;"></div>
</div>
<?foreach($assignments as $assignment):?>
	<div id="assignmentList" class="listItem">
		<div id="dueDate">
			<?=$assignment['date']?>
		</div>
		<div id="description">
			<?=$assignment['description']?>
		</div>
		<div id="attachment">
			<a href="/<?=$assignment['doc']?>">Download <?=$assignment['doc']?></a>
		</div>
		<div style="clear:both;"></div>
	</div>
<?endforeach;?>
