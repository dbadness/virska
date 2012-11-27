<?if(isset($classes)):?>
		<?foreach($classes as $class):?>
			<strong><?=$class['class_code']?> - <?=$class['class_name']?></strong><br><br>
				<?if(isset($sections)):?>
					<?foreach($sections as $section):?>
						<?if($section['class_id'] == $class['class_id']):?>
							<div id="section-wrapper">
								Section <?=$section['section_name']?> runs from <?=$section['time_start_hour']?>:<?=$section['time_start_min']?> <?=$section['am_pm_start']?> to <?=$section['time_end_hour']?>:<?=$section['time_end_min']?> <?=$section['am_pm_end']?>.&nbsp&nbsp&nbsp&nbsp<a href="/professor/section/<?=$section['section_id']?>">View/Edit</a>
							</div>
						<?endif;?>
					<?endforeach;?>
				<?endif;?>
		<?endforeach;?>
	<?endif;?>
<br>
<br>
<hr>
<div id="wrapper">
	<br>
	<div id="add-class">
		<form class="form" id="class" method="post" action="/professor/p_add_class" >
			<label for="class_code">Class Code</label>
			<input type="text" name="class_code" id="class_code">
			<br>
			<br>
			<label for="class_name">Class Name</label>
			<input type="text" name="class_name" id="class_name">
			<br>
			<br>
			<input type="submit" value="Add Class">
		</form>
	</div>
	<div id="add-section">
		<form class="form" id="section" method="post" action="/professor/p_add_section" >
			<label for="section_name">Section Name</label>
			<input type="text" name="section_name" id="section_name">
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
			<select name="am_pm_start" id="am_pm_start">
				<option>AM</option>
				<option>PM</option>
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
			<br>
			<br>
			<label for="time_end">End Time</label>
			<select name="am_pm_end" id="am_pm_end">
				<option>AM</option>
				<option>PM</option>
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
			<br>
			<br>
			<input type="submit" value="Add Section">
		</form>
	</div>
	<div style="clear:both;"></div>
</div>