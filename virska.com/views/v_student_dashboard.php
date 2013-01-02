<?$day_count = 1;?>
<?$week_count = 1;?>
<div id="sectionsFollowingHeader">
	<strong>Sections I'm Following</strong>
</div>
<div id="searchLink">
	<a href="/student/search">Search for Classes to Follow</a>
</div>
<div id="searchPic">
	<img src="/images/magnifying-glass.png" width="40">
</div>
<div style="clear:both;"></div>
<div id="sectionsViewWrapper">
	<?foreach($sections as $section):?>
		<div class="sectionListWrapper">
			<div id="sectionName" class="sectionList">
				<?=$section['class_code']?>, <?=$section['class_name']?>, Section <?=$section['section_name']?>&nbsp
			</div>
			<div id="sectionTime" class="sectionList">
				meets from <?=$section['time_start_hour']?>:<?=$section['time_start_min']?><?=$section['am_pm_start']?> to <?=$section['time_end_hour']?>:<?=$section['time_end_min']?><?=$section['am_pm_end']?>&nbsp
			</div>
			<div id="sectionBuilding" class="sectionList">
				in <?=$section['building']?>,&nbsp
			</div>
			<div id="sectionRoom" class="sectionList">
				room <?=$section['room_number']?>,&nbsp
			</div>
			<div id="sectionDay" class="sectionList">
				on <?=$section['mo']?> <?=$section['tu']?> <?=$section['we']?> <?=$section['th']?> <?=$section['fr']?> <?=$section['sa']?> <?=$section['su']?>
			</div>
			<div id="unfollowButton">
				<a href="/student/p_unfollow/<?=$section['section_id']?>"><img src="/images/delete.png" width="20"></a>
			</div>
			<div style="clear:both;"></div>
		</div>
	<?endforeach;?>
</div>
<div class="spacer"></div>
<div id="assignmentViewerHeader">
	<strong>What's Happening with Your Sections	</strong>
</div>
<div id="assignmentViewer">
	<div id="dateHeader">
		<div id="dueTodayLabel" class="happening active">
			Happening Today
		</div>	
		<div id="dueWeekLabel" class="happening passive">
			Happening This Week
		</div>
		<div id="searchDayLabel" class="happening passive">
			Search by Day
		</div>
		<div style="clear:both;"></div>
	</div>
	<div id="canvas">
		<div class="listHeader">
			<div class="sDateLabel">
				<i>Due Date</i>
			</div>
			<div class="sClassLabel">
				<i>Class</i>
			</div>
			<div class="sDescLabel">
				<i>Description</i>
			</div>
			<div class="sAttachmentLabel">
				<i>Attachment</i>
			</div>
			<div style="clear:both;"></div>
		</div>
		<div id="dueToday">
			<?foreach($todays_events as $todays_event):?>
				<div class="listItem dayView">
					<div class="sClassName">
						<?=$day_count++?>. <?=$todays_event['class_code']?>
					</div>
					<div class="sDesc">
						<?=$todays_event['description']?>
					</div>
					<div class="sAttachment">
						<?if(isset($todays_event['doc'])):?>
							<a href="/docs/<?=$todays_event['doc']?>"><img src="/images/attachment.png" width="20"></a>
						<?endif;?>
					</div>
					<div style="clear:both;"></div>
					<?if($todays_event['submissions'] == 1):?>
						<div class="sSubmission">
							<div class="submissionLabel">
								This event requires a submission:
							</div>
							<div class="submissionInput">
								<form method="post" action="/student/p_submit/<?=$todays_event['event_id']?>" enctype="multipart/form-data">
									<input type="hidden" name="event_id" value="<?=$todays_event['event_id']?>">
									<input type="hidden" name="student_fname" value="<?=$fname?>">
									<input type="hidden" name="student_lname" value="<?=$lname?>">
									<input type="file" id="file" name="submission">
									<br>
									<input type="submit" value="Submit">
								</form>
							</div>
						</div>
					<?endif;?>
				</div>
			<?endforeach;?>
		</div>
		<div id="dueWeek">
			<?foreach($weeks_events as $weeks_event):?>
				<div class="listItem weekView">
					<div class="sDate">
						<?=$week_count++?>. <?=$weeks_event['date']?>
					</div>
					<div class="sClassName">
						<?=$weeks_event['class_code']?>
					</div>
					<div class="sDesc">
						<?=$weeks_event['description']?>
					</div>
					<?if($weeks_event['doc']):?>
						<div class="sAttachment">
							<a href="/docs/<?=$weeks_event['doc']?>"><img src="/images/attachment.png" width="20"></a>
						</div>
					<?endif;?>
					<div style="clear:both;"></div>
					<?if($weeks_event['submissions'] == 1):?>
						<div class="sSubmission">
							<div class="submissionLabel">
								This event requires a submission:
							</div>
							<div class="submissionInput">
								<form method="post" action="/student/p_submit/<?=$todays_event['event_id']?>" enctype="multipart/form-data">
									<input type="hidden" name="event_id" value="<?=$todays_event['event_id']?>">
									<input type="hidden" name="student_fname" value="<?=$fname?>">
									<input type="hidden" name="student_lname" value="<?=$lname?>">
									<input type="file" id="file" name="submission">
									<br>
									<input type="submit" value="Submit">
								</form>
							</div>
						</div>
					<?endif;?>
				</div>
			<?endforeach;?>
		</div>
		<div id="searchDay">
			search Day
			<?foreach($searched_events as $searched_event):?>
				<div class="listItem">
					<div id="sClassName">
						<?=$searched_event['class_name']?> - <?=$searched_event['section_name']?>
					</div>
					<div id="sDesc">
					</div>
					<div id="sSubmission">
					</div>
					<div id="sAttachment">
					</div>
					<div style="clear:both;"></div>
				</div>
			<?endforeach;?>
		</div>
	</div>
</div>