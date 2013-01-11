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
	<?if(!$sections):?>
		<div class="ifNoVariables">
			<i>You're not following any sections yet. Click on 'Search for Classes for Follow' to find your professor's sections.</i>
		</div>
	<?else:?>
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
				<div id="unfollowButton" class="sectionList">
					<a href="/student/p_unfollow/<?=$section['section_id']?>"><img src="/images/delete.png" width="20" title="Unfollow Section"></a>
				</div>
				<div id="gradesButton" class="sectionList">
					<a href="/student/grades/<?=$section['section_id']?>"><img src="/images/grades.png" width="20" title="View Grades"></a>
				</div>
				<div style="clear:both;"></div>
			</div>
		<?endforeach;?>
	<?endif;?>
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
		<div id="dueToday">
			<?if(!$todays_events):?>
				<div class="ifNoVariables">
					Nothing is going on today. Time for video games. Or whatever girls do when there's no homework.
				</div>
			<?else:?>
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
						<br>
						<?if($todays_event['submissions'] == 1):?>
							<?if(isset($submissions[$todays_event['event_id']])):?>
								<div class="sSubmission">
									<form method="post" action="/student/p_resubmit/<?=$todays_event['event_id']?>" enctype="multipart/form-data">
										<div class="submissionLabel">
											Phew... Already submitted. Resubmit?
										</div>
										<div class="submissionInput">
											<input type="hidden" name="event_id" value="<?=$todays_event['event_id']?>">
											<input type="hidden" name="section_id" value="<?=$todays_event['section_id']?>">
											<input type="hidden" name="event_desc" value="<?=$todays_event['description']?>">
											<input type="hidden" name="student_fname" value="<?=$user->first_name?>">
											<input type="hidden" name="student_lname" value="<?=$user->last_name?>">
											<input type="file" id="file" name="submission" style="width:330px;">
										</div>
										<div class="sSubmitButton">
											<input type="submit" value="Submit">
										</div>
										<div style="clear:both;"></div>
									</form>
								</div>
							<?else:?>
								<div class="sSubmission">
									<form method="post" action="/student/p_submit/<?=$todays_event['event_id']?>/<?=$todays_event['description']?>" enctype="multipart/form-data">
										<div class="submissionLabel">
											This event requires a submission (what a drag):
										</div>
										<div class="submissionInput">
											<input type="hidden" name="event_id" value="<?=$todays_event['event_id']?>">
											<input type="hidden" name="section_id" value="<?=$todays_event['section_id']?>">
											<input type="hidden" name="event_desc" value="<?=$todays_event['description']?>">
											<input type="hidden" name="student_fname" value="<?=$user->first_name?>">
											<input type="hidden" name="student_lname" value="<?=$user->last_name?>">
											<input type="file" id="file" name="submission" style="width:330px;">
										</div>
										<div class="sSubmitButton">
											<input type="submit" value="Submit">
										</div>
										<div style="clear:both;"></div>
									</form>
								</div>
							<?endif;?>
						<?endif;?>
					</div>
				<?endforeach;?>
			<?endif;?>
		</div>
		<div id="dueWeek">
			<?if(!$weeks_events):?>
				<div class="ifNoVariables">
					Nothing is going on today. Time for video games. Or whatever girls do when there's no homework.
				</div>
			<?else:?>
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
						<br>
						<?if($weeks_event['submissions'] == 1):?>
							<?if(isset($submissions[$weeks_event['event_id']])):?>
								<div class="sSubmission">
									<form method="post" action="/student/p_resubmit/<?=$weeks_event['event_id']?>/<?=$weeks_event['description']?>" enctype="multipart/form-data">
										<div class="submissionLabel">
											Phew... Already submitted. Resubmit?
										</div>
										<div class="submissionInput">
											<input type="hidden" name="event_id" value="<?=$weeks_event['event_id']?>">
											<input type="hidden" name="section_id" value="<?=$weeks_event['section_id']?>">
											<input type="hidden" name="event_desc" value="<?=$weeks_event['description']?>">
											<input type="hidden" name="student_fname" value="<?=$user->first_name?>">
											<input type="hidden" name="student_lname" value="<?=$user->last_name?>">
											<input type="file" id="file" name="submission" style="width:330px;">
										</div>
										<div class="sSubmitButton">
											<input type="submit" value="Submit">
										</div>
										<div style="clear:both;"></div>
									</form>
								</div>
							<?else:?>
								<div class="sSubmission">
									<form method="post" action="/student/p_submit/<?=$weeks_event['event_id']?>/<?=$weeks_event['description']?>" enctype="multipart/form-data">
										<div class="submissionLabel">
											This event requires a submission (what a drag):
										</div>
										<div class="submissionInput">
											<input type="hidden" name="event_id" value="<?=$weeks_event['event_id']?>">
											<input type="hidden" name="section_id" value="<?=$weeks_event['section_id']?>">
											<input type="hidden" name="event_desc" value="<?=$weeks_event['description']?>">
											<input type="hidden" name="student_fname" value="<?=$user->first_name?>">
											<input type="hidden" name="student_lname" value="<?=$user->last_name?>">
											<input type="file" id="file" name="submission" style="width:330px;">
										</div>
										<div class="sSubmitButton">
											<input type="submit" value="Submit">
										</div>
										<div style="clear:both;"></div>
									</form>
								</div>
							<?endif;?>
						<?endif;?>
					</div>
				<?endforeach;?>
			<?endif;?>
		</div>
		<div id="searchDay">
			<div id="searchDateW">
				<div id="searchDate">
					<form method="post" action="/student/dashboard_results">
						<div id="searchDateInput">
							<input name="date" id="datepicker" class="inputs" size="10">
						</div>
						<div id="searchDateSubmit">
							<input type="submit" value="Search" id="searchDateButton">
						</div>
						<div style="clear:both;"></div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="spacer"></div>
<div class="listHeader" id="messageViewerHeader">
	<strong>Messages</strong>
</div>
<div class="listHeader" id="readReadMessages">
	<a href="/student/messages">View Read Messages</a>
</div>
<div style="clear:both;"></div>
<div id="messagesWrapper">
	<?if(!$unread_messages):?>
		<div class="ifNoVariables">
			No New Messages
		</div>
	<?else:?>
		<?foreach($unread_messages as $unread_message):?>
			<div class="messageContainer">
				<div class="messageHeader">
					<form method="post" action="/student/p_read">
						<div class="from">
							<i>From <?=$unread_message['first_name']?> <?=$unread_message['last_name']?>:</i>
						</div>
						<div class="markRead">
							<input id="message" name="message_id" type="hidden" value="<?=$unread_message['message_id']?>">
							<input type="submit" value="Mark as Read">
						</div>
						<div style="clear:both;"></div>
					</form>	
				</div>
				<div class="messageContent">
					<?=$unread_message['message']?>
				</div>
			</div>
		<?endforeach;?>
	<?endif;?>
</div>