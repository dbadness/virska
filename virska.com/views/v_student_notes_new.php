<div id="newNote">
	<a href="/student/notes"><button id="cancel">Cancel</button></a><button id="addNote">Add Note</button>
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
	<div id="newNotePad" style="background-color:white;min-height:700px;"></div>
</div>
	