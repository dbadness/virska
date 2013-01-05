<div class="listHeader">
	<strong>Submissions for <?=$section['class_code']?> - <?=$section['section_name']?>.</strong>
</div>
<div id="gradesWrapper">
	<?if(!$submissions):?>
		<div class="spacer"></div>
		<div id="noGrades">
			<i>No grades have been posted yet.</i>
		</div>
	<?else:?>
		<?foreach($submissions as $submission):?>
			<div class="submissionList">
				<div id="lastModified">
					 <?=$submission['event_desc']?> submitted on <?=Time::display($submission['modified'])?>
				</div>
				<div id="comments">
					<div ="grade">
						<i>Grade: </i><?=$submission['grade']?>
					</div>
					<br>
					<div id="commentsLabel">
						<i>Comments</i>
					</div>
					<div id="commentsContent">
						<?=$submission['comments']?>
					</div>
				</div>
				<div style="clear:both;"></div>
			</div>
		<?endforeach;?>
	<?endif;?>
</div>