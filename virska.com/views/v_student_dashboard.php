<a href="/student/search">Search for Classes to Follow</a>
<br>
<br>
<div id="sectionsView">
	Sections I'm following:
	<br>
	<br>
	<?foreach($sections as $section):?>
		<?=$section['class_code']?> <?=$section['section_name']?> meets from (time) in room (add room column in section table) (also make it so you can unfollow this shit)<br>
	<?endforeach;?>
</div>