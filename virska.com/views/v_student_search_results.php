This is the search results page for all the professors from this student's school.
<br>
<br>
<?if($professors):?>
	<?foreach($professors as $professor):?>
		<li><?=$professor['first_name']?> <?=$professor['last_name']?></li>
	<?endforeach;?>
<?else:?>
	Hmmm... Couldn't find anyone with that name. Are you sure you spelled it right? <a href="/student/search">Try again.</a>
<?endif;?>