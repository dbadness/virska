<div id="searchResultsHeader">
	<h4>Search results for '<?=$_POST['search']?>'.</h4>
</div>
<div id="notesSearchBox">
	<form id="notesSearch" method="post" action="results">
		<div id="notesSearchBoxInput">
			<?if($_POST):?>
				<input name="search" value="<?=$_POST['search']?>" size="40">
			<?else:?>
				<input name="search" placeholder="Search Through Your Notes" size="40">
			<?endif;?>
		</div>
		<div id="notesSearchBoxButton">
			<input type="submit" value="Search" style="width:80px;">
		</div>
		<div style="clear:left;"></div>
	</form>
</div>
<div style="clear:right;"></div>
<div class="spacer" style="clear:both"></div>
<div id="searchResultsWrapper">
	<div class="listHeader">
		<div id="titleLabel">
			<i>Note Title</i>
		</div>
		<div id="modifiedLabel">
			<i>Last Modified</i>
		</div>
		<div style="clear:both;"></div>
	</div>
	<?foreach($results as $result):?>
		<div class="listItem">
			<div id="resultTitle"><a href="/notes/edit/<?=$result['note_id']?>"><?=$result['title']?></a></div><div id="resultModified"><?=Time::display($result['modified'])?></div>
		<div style="clear:both;"></div>
		</div>
	<?endforeach;?>
</div>