<div class="note">
	<input type="hidden" id="noteID" value="<?=$note['note_id']?>" />
	<h3><?=$section['class_name']?> - <?=$section['class_code']?> <?=$section['section_name']?></h3>
	<a href="/student/notes"><button>Back to Notes</button></a>
	<button id="saveNote">Save Note</button>
	<div id="noteTitleDiv"><input id="noteTitle" value="<?=$note['title']?>" size="60"></div> 
	<div id="savingInfo">
		<div id="lastUpdated"></div>
		<div id="statusImage"></div>
		<div id="statusText"></div>
		<div style="clear:both;"></div>
	</div>
	<div id="myNicPanel"></div>
	<div id="notePad" style="background-color:white;min-height:700px;"><?=$note['content']?></div>
</div>
	