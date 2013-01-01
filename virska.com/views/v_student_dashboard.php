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
			<div id="sClassNameLabel">
				<i>Class</i>
			</div>
			<div id="sDescLabel">
				<i>Description</i>
			</div>
			<div id="sSubmissionLabel">
				<i>Submission</i>
			</div>
			<div id="sAttachmentLabel">
				<i>Attachment</i>
			</div>
			<div style="clear:both;"></div>
		</div>
		<div id="dueToday" class="visible">
			<?foreach($todays_events as $todays_event):?>
				<div class="listItem">
					<div id="sClassName">
						<?=$todays_event['class_name']?> - <?=$todays_event['section_name']?>
					</div>
					<div id="sDesc">
						<?=$todays_event['description']?>
					</div>
					<div id="sSubmission">
						<?=$todays_event['submissions']?>
					</div>
					<?if($todays_event['doc']):?>
						<div id="sAttachment">
							<a href="/docs/<?=$todays_event['doc']?>"><img src="/images/attachment.png" width="20"></a>
						</div>
					<?endif;?>
					<div style="clear:both;"></div>
				</div>
			<?endforeach;?>
		</div>
		<div id="dueWeek" class="invisible">
			due Week
			<?foreach($weeks_events as $weeks_event):?>
				<div class="listItem">
					<div id="sClassName">
						<?=$weeks_event['class_name']?> - <?=$weeks_event['section_name']?>
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
		<div id="searchDay" class="invisible">
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
		<div id="statusGraphic" class="invisible">
			<img src="/images/ajaxLoader.gif">
		</div>
	</div>
</div>