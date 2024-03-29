<div id="searchHeader">
	Using their last name, search for a professor.
</div>
<div class="searchBox" id="professorSearchBox">
	<form id="professorSearch" action="search_results" method="post">
		<input id="search_box" name="search" type="text"><input id="searchButton" type="submit" value="Search">
	</form>
</div>
<br>
<br>
<!-- the following code is also on the "professor list page" please update on both if changes are to be made -->
<?if($professors):?>
	<?foreach($professors as $professor):?>
		<div class="searchResult">
			<div id="picture">
			</div>	
			<div id="nameBlock">
				<?=$professor['first_name']?> <?=$professor['last_name']?>
			</div>
			<div id="sectionList">
				<?foreach($sections as $section):?>		
						<?if($section['user_id'] == $professor['user_id']):?>
							<?if(isset($connections[$section['section_id']])):?>
								<i>Following <?=$section['class_code']?> <?=$section['section_name']?></i><br>
							<?else:?>
								Click to Follow <a href="/student/p_follow/<?=$section['section_id']?>"><?=$section['class_code']?> <?=$section['section_name']?></a><br>
							<?endif;?>
						<?endif;?>
				<?endforeach;?>
			</div>
			<div style="clear:both;"></div>
		</div>
	<?endforeach;?>
<?else:?>
	<div class="errorBox" id="searchResultError">
		Hmmm... Couldn't find anyone with that name. Are you sure you spelled it right? If you'd like to see a full list of the professors in your school on Virska, click <a href="/student/professor_list">here</a>.
	</div>
<?endif;?>