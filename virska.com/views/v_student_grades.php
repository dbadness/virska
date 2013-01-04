<div class="listHeader">
	<strong>Submissions for <?=$section['class_code']?> - <?=$section['section_name']?>.</strong>
</div>
<div id="gradesWrapper">
	<?foreach($submissions as $submission):?>
		<div class="submissionList">
			<div id="lastModified">
				 <?=$submission['event_desc']?> submitted on <?=Time::display($submission['modified'])?>
			</div>
			<div id="comments">
				<div id="commentsLabel">
					Comments and Grades
				</div>
				<div id="commentsContent">
					<?=$submission['comments']?>
				</div>
			</div>
			<div style="clear:both;"></div>
		</div>
	<?endforeach;?>
</div>