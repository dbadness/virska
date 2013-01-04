<div class="listHeader">
	<strong>Submissions for <?=$event['description']?> which was due for <?=$event['date']?>.</strong>
</div>
<div id="submissionWrapperHeader">
	<div id="studentNameW" class="submissionItem">
		<i>Student Name</i>
	</div>
	<div id="lastModifiedW" class="submissionItem">
		 <i>Submission was Last Modified</i>
	</div>
	<div id="downloadW" class="submissionItem">
		<i>Click to Download Submission</i>
	</div>
	<div style="clear:both;"></div>
</div>
<div id="submissionWrapper">
	<?foreach($submissions as $submission):?>
		<div class="submissionList">
			<div id="studentNameW" class="submissionItem">
				<?=$submission['student_fname']?> <?=$submission['student_lname']?>
			</div>
			<div id="lastModifiedW" class="submissionItem">
				 <?=Time::display($submission['modified'])?>
			</div>
			<div id="downloadW" class="submissionItem">
				<div id="download">
					<a href="/docs/<?=$submission['doc']?>"><img src="/images/attachment.png" width="20"></a>
				</div>
			</div>
			<div style="clear:both;"></div>
			<hr>
			<div class="submissionItem">
				<div id="feedbackLabel">
					Notes/Grades/Feedback
				</div>
				<div id="charCountLabel">
					Characters Remaining:
				</div>
				<div id="charCount">
					300
				</div>
				<div id="feedback">
					<form method="post" action="/professor/p_grade">
						<input type="hidden" name="submission_id" value="<?=$submission['submission_id']?>">
						<input type="hidden" name="event_id" value="<?=$event['event_id']?>">
						<textarea id="feedbackField" name="comments" cols="120" rows="4" maxlength="300"><?=$submission['comments']?></textarea><br>
						<input type="submit" value="Publish to this Student">
					</form>
				</div>
			</div>
		</div>
	<?endforeach;?>
</div>