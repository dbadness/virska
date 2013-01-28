<?if($event == 0):?>
	<div id="noEvent">
		You have no events yet!<br><br>Now that you have sections for your students to follow and view, you need to create events for your students to interact with. An event is most typically an assignment (like "Project 1 Due" or "Read Chapters 3 and 4") but it can be anything you'd like your students to do on a date  (including submit assignments for you to grade!)
		<br><br>To the right of your new section below, click on "View" and you'll be able to add events to that section.
		<br><br>Once you've added your event, you can click on "Dashboard" on top of the screen to come back to this home page. If you ever have any questions, please reach out to us at <a href="mailto:feedback@virska.com">feedback@virska.com</a> and we'd be glad to help.
		<br><br>Enjoy!
	</div>
	<div class="spacer"></div>
<?endif;?>
<div id="mySectionsHeader">
	<strong>My Sections</strong>
</div>
<div id="editClasses">
	<a href="/professor/classes">Add or Delete Classes and Sections</a>
</div>
<div style="clear:both;"></div>
<div id="sectionsViewWrapper">
	<?if(!$sections):?>
		<div class="noVariables" id="noSections">
			Currently you don't have any sections for students to follow. Click on "Add or Delete Sections or Classes" above to create a section.
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
				<div id="deleteSection">
					<a href="/professor/p_delete_section/<?=$section['section_id']?>"><img src="/images/delete.png" width="20" title="Delete section"></a>
				</div>
				<div id="editSection" class="sectionList">
					<a href="/professor/section/<?=$section['section_id']?>">View</a>
				</div>
				<div style="clear:both;"></div>
			</div>
		<?endforeach;?>
	<?endif;?>
</div>
<div class="spacer"></div>
<div class="listHeader">
	<div id="messageHeaderCopy">
		<strong>Create a message to send to your students:<br>(for example: "Project 1 Grades are posted!" or "Today's class is cancelled...")</strong>
	</div>
	<div id="sentMessages">
		<a href="/professor/messages">View Sent Messages</a>
	</div>
	<div style="clear:both;"></div>
</div>
<div id="messagesWrapper">
	<div id="message">
		<form method="post" action="/professor/p_message">
			<div style="width:220px;">
				<div id="sectionSelectorLabel">
					Send to class:
				</div>
				<div id="sectionSelector">
					<select name="section_id">
						<?foreach($sections as $section):?>
							<option value="<?=$section['section_id']?>"><?=$section['class_code']."-".$section['section_name']?></option>
						<?endforeach;?>
					</select>
				</div>
				<div style="clear:both;"></div>
			</div>
			<div id="messageContent">
				<textarea name="message" maxlength="200" cols="76"></textarea>
			</div>
			<div id="messageSubmit">
				<input type="submit" value="Send Message" id="sendMessage">
			</div>
		</form>
	</div>
</div>