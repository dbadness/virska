Add a new note: <a href="/student/notes_new">Add a note</a>
<br>
<br>
My Notes:
<?foreach($notes as $note):?>
	<li><a href="/student/notes_edit/<?=$note['note_id']?>"><?=$note['title']?></a> - <a id="delete" href="/student/p_delete_note/<?=$note['note_id']?>">Delete</a></li>
<?endforeach;?>