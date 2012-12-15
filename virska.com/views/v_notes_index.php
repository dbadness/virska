Add a new note: <a href="/notes/add">Add a note</a>
<br>
<br>
My Notes:
<?foreach($notes as $note):?>
	<li><a href="/notes/edit/<?=$note['note_id']?>"><?=$note['title']?></a> - <a id="delete" href="/notes/p_delete_note/<?=$note['note_id']?>">Delete</a></li>
<?endforeach;?>