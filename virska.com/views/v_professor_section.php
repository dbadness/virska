<strong><?=$section['class_name']?>, Section <?=$section['section_name']?></strong>
<br><br><hr>
<div id="newAssignmentWrapper">
	<form id="newAssignmentForm" action="/professor/p_upload_assignment" method="post" enctype="multipart/form-data">
		<input type="hidden" name="section_id" value="<?=$section['section_id']?>">
		<div id="newEventLabel">
			Event Description
		</div>
		<div id="newEvent">
			<input placeholder="'Project One Due' or 'First Essay Draft Due'" size="50" name="description">
		</div>
		<div id"attachmentCheck">
			<input type="checkbox" id="attachmentCheckbox">Attachment?	
		</div>
		<div style="clear:both;"></div>
		<div id="newEventDateLabel">
			Event Date
		</div>
		<div id="newEventDate">
			<input name="date" id="datepicker" size="10">
		</div>
		<div id="ifAttachment">
			<div id="newAttachmentLabel">
				Attachment:
			</div>
			<div id="newAttachment">
				<input style="width:300px;" type="file" name="doc">
			</div>
		</div>
		<div style="clear:both;"></div>
		<div id="assignmentButton">
			<input type="submit" value="Add Event">
		</div>
		<div style="clear:both;"></div>
	</form>
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
			<a href="/docs/<?=$assignment['doc']?>.pdf"><?=$assignment['doc_name']?></a>
		</div>
		<div style="clear:both;"></div>
	</div>
<?endforeach;?>
