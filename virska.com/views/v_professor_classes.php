<?if(isset($new)):?>
<div id="newClass">
	Welcome to Virska, <?=$user->first_name?>!<br><br>On this page, we're going to create a class name (like "Introduction to Management" or "American History") and class code (like "MGT 101" or "HIST 203") on the left.<br><br>After that, on the right, we're then going to give that class a individual section, like "A" for example. Also tell your students when that section meets, in what room and building, and on what days.<br><br> When we're all done, students can then search for your class and section to see the "events" that you'll create. Events can be anything from assignments to projects to pizza parties - whatever you decide!
</div>
<div class="spacer"></div>
<?endif;?>
<div id="myClasses">
	<?if($classes):?>
		<div id="myClassesHeader">
			<i>These are the classes and sections I've already created:</i>
		</div>
	<?endif;?>
	<div class="spacer"></div>
	<div id="myClassesContent">
		<?if(isset($classes)):?>
			<?foreach($classes as $class):?>
				<div class="listItem">
					<div class="classHeader">
						<div class="class">
							<strong><?=$class['class_code']?> - <?=$class['class_name']?></strong>
						</div>
						<div class="deleteClass" id="deleteClassButton">
							<a href="/professor/p_delete_class/<?=$class['class_id']?>"><img src="/images/delete.png" width="25"></a>
						</div>
						<div class="deleteClassCopy">
							Want to delete the class for good?
						</div>
						<div style="clear:both;"></div>
					</div>
					<?if(isset($sections)):?>
						<?foreach($sections as $section):?>
							<div class="classContent">
								<?if($section['class_id'] == $class['class_id']):?>
									<div class="sectionInfo">
										Section <?=$section['section_name']?> runs from <?=$section['time_start_hour']?>:<?=$section['time_start_min']?> <?=$section['am_pm_start']?> to <?=$section['time_end_hour']?>:<?=$section['time_end_min']?> <?=$section['am_pm_end']?>.
									</div>
									<div class="sectionView">
										<a href="/professor/section/<?=$section['section_id']?>">View/Edit</a>
									</div>
									<div style="clear:both;"></div>
								<?endif;?>
							</div>
						<?endforeach;?>
					<?endif;?>
				</div>
			<?endforeach;?>
		<?endif;?>
	</div>
</div>
<br>
<br>
<hr>
<div id="addClassWrapper">
	<div id="addClass">
		<form class="addClass" id="class" method="post" action="/professor/p_add_class" >
			<label for="class_name"><strong>Class Name</strong><br><i>(ie. Introduction to Management)</i></label>
			<input type="text" name="class_name" id="class_name" class="inputs">
			<br>
			<br>
			<label for="class_code"><strong>Class Code</strong><br><i>(ie. MGT 101)</i></label>
			<input type="text" name="class_code" id="class_code" class="inputs">
			<br>
			<br>
			<input type="submit" value="Add Class">
		</form>
	</div>
	<div id="addSection">
		<form class="addSection" id="section" method="post" action="/professor/p_add_section" >
			<label for="section_name">Section Name</label>
			<input type="text" name="section_name" id="section_name" class="inputs">
			<br>
			<br>
			<label for="class_id">For Class:</label>
			<select name="class_id" id="class_id">
				<?foreach($classes as $class):?>
					<option value="<?=$class['class_id']?>"><?=$class['class_code']?></option>
				<?endforeach;?>
			</select>			
			<br>
			<br>
			<label for="time_start">Start Time</label>
			<select name="time_start_hour" id="time_start_hour">
				<option>1</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
				<option>6</option>
				<option>7</option>
				<option>8</option>
				<option>9</option>
				<option>10</option>
				<option>11</option>
				<option>12</option>
			</select>
			<select name="time_start_min" id="time_start_min">
				<option>00</option>
				<option>05</option>
				<option>10</option>
				<option>15</option>
				<option>20</option>
				<option>25</option>
				<option>30</option>
				<option>35</option>
				<option>40</option>
				<option>45</option>
				<option>50</option>
				<option>55</option>
			</select>
			<select name="am_pm_start" id="am_pm_start">
				<option>AM</option>
				<option>PM</option>
			</select>
			<br>
			<label for="time_end">End Time</label>
			<select name="time_end_hour" id="time_end_hour">
				<option>1</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
				<option>6</option>
				<option>7</option>
				<option>8</option>
				<option>9</option>
				<option>10</option>
				<option>11</option>
				<option>12</option>
			</select>
			<select name="time_end_min" id="time_end_min">
				<option>00</option>
				<option>05</option>
				<option>10</option>
				<option>15</option>
				<option>20</option>
				<option>25</option>
				<option>30</option>
				<option>35</option>
				<option>40</option>
				<option>45</option>
				<option>50</option>
				<option>55</option>
			</select>
			<select name="am_pm_end" id="am_pm_end">
				<option>AM</option>
				<option>PM</option>
			</select>
			<br>
			<br>
			<label for="roomNumber">Room Number</label>
			<input id="roomNumber" name="room_number" class="inputs">
			<br>
			<label for="building">Building Name</label>
			<input id="building" name="building" class="inputs">
			<br>
			<label for="days">Days the section meets</label>
			<br>
			<input type="checkbox" class="day" name="mo" value="Monday">Monday</br>
			<input type="checkbox" class="day" name="tu" value="Tuesday">Tuesday</br>
			<input type="checkbox" class="day" name="we" value="Wednesday">Wednesday</br>
			<input type="checkbox" class="day" name="th" value="Thursday">Thursday</br>
			<input type="checkbox" class="day" name="fr" value="Friday">Friday</br>
			<input type="checkbox" class="day" name="sa" value="Saturday">Saturday</br>
			<input type="checkbox" class="day" name="su" value="Sunday">Sunday</br>
			<br>
			<input type="submit" value="Add Section">
		</form>
	</div>
	<div style="clear:both;"></div>
</div>