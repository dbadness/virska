<div id="mySectionsHeader">
	<strong>My Sections</strong>
</div>
<div id="editClasses">
	<a href="/professor/classes">Add Classes and Sections</a>
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
			<div id="editSection" class="sectionList">
				<a href="/professor/section/<?=$section['section_id']?>">View</a>
			</div>
			<div style="clear:both;"></div>
		</div>
	<?endforeach;?>
</div>
<div class="spacer"></div>
