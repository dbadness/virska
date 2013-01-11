<div class="listHeader">
	<strong>Read Messages</strong>
</div>
<div id="messagesWrapper">
	<?if(!$read_messages):?>
		<div class="ifNoVariables">
			No Read Messages
		</div>
	<?else:?>
		<?foreach($read_messages as $read_message):?>
			<div class="messageContainer">
				<div class="messageHeader">
					<div class="from">
						<i>From <?=$read_message['first_name']?> <?=$read_message['last_name']?>:</i>
					</div>
					<form method="post" action="/student/p_delete_message">
						<div class="deleteMessage">
							<input id="message" name="message_id" type="hidden" value="<?=$read_message['message_id']?>">
							<input class="delete" type="submit" value="Delete Message">
						</div>
					</form>
					<form method="post" action="/student/p_unread">
						<div class="markRead">
							<input id="message" name="message_id" type="hidden" value="<?=$read_message['message_id']?>">
							<input type="submit" value="Mark as Unread">
						</div>
					</form>
					<div style="clear:both;"></div>
				</div>
				<div class="messageContent">
					<?=$read_message['message']?>
				</div>
			</div>
		<?endforeach;?>
	<?endif;?>
</div>