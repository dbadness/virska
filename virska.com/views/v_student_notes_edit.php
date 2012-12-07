<div class="note">
	<input type="hidden" id="noteID" value="<?=$note['note_id']?>" />
	<h3><?=$section['class_name']?> - <?=$section['class_code']?> <?=$section['section_name']?></h3>
	<a href="/student/notes"><button>Back to Notes</button></a>
	<a href="/student/p_save_note"><button id="saveNote">Save Note</button></a>
	<div id="noteTitleDiv"><input id="noteTitle" value="<?=$note['title']?>" size="60"></div>
	Last save: <div id="lastUpdated"></div><div id="status"></div>
	<div class="spacer"></div>
	<div id="myNicPanel"></div>
	<div id="myInstance1" style="background-color:white;min-height:700px;"><?=$note['content']?></div>
</div>
	