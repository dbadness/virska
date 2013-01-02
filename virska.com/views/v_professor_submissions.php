<div class="listHeader">
	<strong>Submissions for <?=$description?> which was due for <?=$date?>.</strong>
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
		</div>
	<?endforeach;?>
</div>