<?$count = 1;?>
<div id="myNotesHeader">
	<a href="/notes/add"><img src="/images/add.png" height="25" width="25" alt="Add a Note" style="margin-bottom:-7px;">Start a new note</a>
</div>
<div id="notesSearchBox">
	<form id="notesSearch" method="post" action="notes/results">
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
<div id="myNotes">
	<div class="listHeader">
		<div id="titleLabelIndex">
			<i>Note Title</i>
		</div>
		<div id="modifiedLabelIndex">
			<i>Last Modified</i>
		</div>
		<div style="clear:both;"></div>
	</div>
	<div style="clear:both;"></div>
	<?foreach($notes as $note):?>
		<div class="listItem">
			<div id="resultTitle">
				<?=$count++?>. <a href="/notes/edit/<?=$note['note_id']?>"><?=$note['title']?></a>
			</div>
			<div id="resultDelete">
				<a class="delete" href="/notes/p_delete_note/<?=$note['note_id']?>">Delete</a>
			</div>
			<div id="resultModified">
				<?=Time::display($note['modified'])?>
			</div>
			<div style="clear:both;"></div>
		</div>
	<?endforeach;?>
</div>