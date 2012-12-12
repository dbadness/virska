<div id="newNote">
	<a href="/student/notes"><button id="cancel">Cancel and Go Back</button></a><button id="addNote">Save Note</button>
	<div id="savingInfo">
		<div id="lastUpdated"></div>
		<div id="statusImage"></div>
		<div id="statusText"></div>
		<div class="errorBox" id="noNoteError" style="display:none;">You need to enter note content first!</div>
		<div style="clear:left;"></div>
	</div>
	<?if($sections):?>
		Section:
		<select name="section_id" id="section">
			<?foreach($sections as $section):?>
				<option value="<?=$section['section_id']?>">
					<?=$section['class_name']?> <?=$section['section_name']?>
				</option>
			<?endforeach;?>
		</select>
	<?else:?>
		There are no followed sections to associate this note with but for future notes, you can follow sections <a href="/student/dashboard">here</a>.
	<?endif;?>	
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
	