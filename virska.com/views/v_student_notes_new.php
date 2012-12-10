<div id="newNote">
	<a href="/student/notes"><button id="cancel">Cancel</button></a><button id="addNote">Save Note</button><a href="/student/notes"><button id="cancel">Back to All Notes</button></a>
	<div id="savingInfo">
		<div id="lastUpdated"></div>
		<div id="statusImage"></div>
		<div id="statusText"></div>
		<div style="clear:both;"></div>
	</div>
	Section:
	<select name="section_id" id="section">
		<?foreach($sections as $section):?>
			<option value="<?=$section['section_id']?>">
				<?=$section['class_name']?> <?=$section['section_name']?>
			</option>
		<?endforeach;?>
	</select>
	<br>
	<br>
	Title:
	<br>
	<input size="40" id="title">
	<br>
	<br>
	Note:
	<br>
	<div id="myNicPanel"></div>
	<div id="notePad" style="background-color:white;min-height:700px;"></div>
</div>
	