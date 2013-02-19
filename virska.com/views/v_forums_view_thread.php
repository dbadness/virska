<div class="listHeader">
	<div id="threadTitle">
		<strong><?=$thread['title']?></strong>
	</div>
</div>
<div id="commentsWrapper">
	<?foreach($comments as $comment):?>
		<div class="comment">
			<div id="commentHeader">
				<div id="commentBy">
					Written by: <?=$comment['first_name']?> <?=$comment['last_name']?>
				</div>
				<div id="createdOn">
					<?=Time::display($comment['created'])?>
				</div>
				<div style="clear:both;"></div>
			</div>
			<div id="commentField">
				<i><?=$comment['comment']?></i>
			</div>
			<?if($comment['user_id'] == $user->user_id):?>
				<div id="deleteComment">
					<a href="/forums/p_delete_comment/<?=$comment['comment_id']?>/<?=$comment['thread_id']?>">Delete?</a>
				</div>
			<?endif;?>
		</div>
	<?endforeach;?>
	<div class="comment">
		<div id="commentHeader">
			<div id="commentBy">
				Written by: <?=$user->first_name?> <?=$user->last_name?>
			</div>
			<div id="createdOn">
				<?=Time::display(Time::now())?>
			</div>
			<div style="clear:both;"></div>
		</div>
		<form method="post" action="/forums/p_add_comment">
			<input type="hidden" name="thread_id" value="<?=$thread['thread_id']?>">
			<input type="hidden" name="user_id" value="<?=$user->user_id?>">
			<div>
				<textarea name="comment" id="newCommentField"></textarea>
			</div>
			<input type="submit" value="Post Comment">
		</form>
	</div>
</div>