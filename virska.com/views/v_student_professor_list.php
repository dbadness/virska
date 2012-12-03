<div id="searchHeader">
	Using their last name, search for a professor to follow. Then you'll be able to see their sections to view their assignments, their syllabus, and more.
</div>
<div class="searchBox" id="professorSearchBox">
	<form id="professorSearch" action="search_results" method="post">
		<input id="search_box" name="search" type="text"><input id="searchButton" type="submit" value="Search">
	</form>
</div>
<br>
<br>
<?foreach($professors as $professor):?>
	<div class="searchResult">
		<div id="picture">
		</div>	
		<div id="nameBlock">
			<?=$professor['first_name']?> <?=$professor['last_name']?>
		</div>
	</div>
<?endforeach;?>
