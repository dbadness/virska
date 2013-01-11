<div class="listHeader">
	<strong>Sent Messages</strong>
</div>
<div id="messagesWrapper">
	<?if(!$messages):?>
		<div class="ifNoVariables">
			No Sent Messages
		</div>
	<?else:?>
		<?foreach($messages as $message):?>
			<div class="messageContainer">
				<div class="messageHeader">
					<div class="from">
						<i>For <?=$message['class_code']?> - <?=$message['section_name']?>:</i>
					</div>
					<form method="post" action="/professor/p_delete_message">
						<div class="deleteMessage">
							<input id="prof_id" name="prof_id" type="hidden" value="<?=$message['prof_id']?>">
							<input id="message" name="message" type="hidden" value="<?=$message['message']?>">
							<input class="delete" type="submit" value="Delete Message">
						</div>
					</form>
					<div style="clear:both;"></div>
				</div>
				<div class="messageContent">
					<?=$message['message']?>
				</div>
			</div>
		<?endforeach;?>
	<?endif;?>
</div>