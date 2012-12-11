<div id="newNote">
	<a href="/student/notes"><button id="cancel">Cancel and Go Back</button></a><button id="addNote">Save and Go Back</button>
	<div id="savingInfo">
		<div id="lastUpdated"></div>
		<div id="statusImage"></div>
		<div id="statusText"></div>
		<div class="errorBox" id="noNoteError" style="display:none;">You need to enter note content first!</div>
		<div style="clear:left;"></div>
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
	<div id="notePad"></div>
</div>
	