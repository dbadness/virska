<input type="hidden" id="noteID" value="<?=$note['note_id']?>" />
<div id="noteTitleDiv"><input id="noteTitle" value="<?=$note['title']?>" size="60"></div> 
<div id="buttons">
	<a href="/notes"><button>Back to Notes</button></a>
	<button id="saveNote">Save Note</button>
</div>
<div style="clear:both;"></div>
<div id="savingInfo">
	<div id="lastUpdated"></div>
	<div id="statusImage"></div>
	<div id="statusText"></div>
	<div style="clear:both;"></div>
</div>
<div id="myNicPanel"></div>
<div id="notePad"><?=$note['content']?></div>
	