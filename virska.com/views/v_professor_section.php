<div id="newEventWrapper">
	<form id="newEventForm" action="/professor/p_add_event" method="post" enctype="multipart/form-data">
		<input type="hidden" name="section_id" value="<?=$section['section_id']?>">
		<fieldset>
			<legend>Add a New Event to this Section</legend>
			<div class="spacer"></div>
			<div id="descriptionInput">
				<div id="newEventLabel">
					Event Description
				</div>
				<div id="newEvent">
					<input placeholder="'Project One Due' or 'First Essay Draft Due'" size="50" name="description">
				</div>
			</div>
			<div id="attachmentBox">
				<div id="addAttachment">
					Add an Attachment	
				</div>
				<div id="attachment">
					<input style="width:300px;" type="file" name="doc">
				</div>
			</div>
			<div style="clear:both;"></div>
			<div id="eventDate">
				<div id="newEventDateLabel">
					Event Date
				</div>
				<div id="newEventDate">
					<input name="date" id="datepicker" size="10">
				</div>
			</div>
			<div id="submissions">
				<div id="submissionsLabel">
					Allow Submissions?
				</div>
				<br>
				<div id="submissionsInput">
					<input type="checkbox" name="submissions" value="1">
				</div>
				<div id="submissionsDesc">
					Allowing submissions enables students<br>to submit their assignments for your review.
				</div>
				<div style="clear:both;"></div>
			</div>
			<div style="clear:both;"></div>
			<div id="assignmentButton">
				<input type="submit" value="Add Event">
			</div>
			<div style="clear:both;"></div>
		</fieldset>
	</form>
</div>
<div class="spacer"></div>
<div id="assignmentHeader" class="listHeader">
	<div id="dueDateLabel">
		<i>Date</i>
	</div>
	<div id="descriptionLabel">
		<i>Description</i>
	</div>
	<div id="attachmentLabel">
		<i>Attachment?</i>
	</div>
	<div id="submissionsEnabled">
		<i>Submissions?</i>
	</div>
	<div style="clear:both;"></div>
</div>
<?foreach($events as $event):?>	
	<div id="assignmentList" class="listItem">
		<div id="dueDate">
			<?=$event['date']?>
		</div>
		<div id="description">
			<?=$event['description']?>
		</div>
		<div id="deleteEvent">
			<a id="deleteButton" href="/professor/p_delete_event/<?=$event['event_id']?>/<?=$event['section_id']?>"><img src="/images/delete.png" width="20"></a>
		</div>
		<div id="submissionsEnabledContainer">
			<div id="submissionsEnabledIcon">
				<?if($event['submissions'] == 1):?>
				<img src="/images/upload.png" width="20">
				<?endif;?>
			</div>
		</div>
		<?if($event['doc']):?>
			<div id="attachmentIcon">
				<a href="/docs/<?=$event['doc']?>"><img src="/images/attachment.png" width="20"></a>
			</div>
		<?endif;?>
		<div style="clear:both;"></div>
	</div>
<?endforeach;?>
