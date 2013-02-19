<div class="listHeader" id="viewerHeader">
	<strong>Discussions for <?=$section['class_code']?> - <?=$section['section_name']?>.</strong>
</div>
<div class="spacer"></div>
<div id="threadWrapper">
	<?if($threads):?>
		<?foreach($threads as $thread):?>
			<div class="listItem">
				<div id="title">
					<a href="/forums/view_thread/<?=$thread['thread_id']?>"><?=$thread['title']?></a>
				</div>
				<?
			
				$q = "SELECT COUNT(comment_id)
				FROM comments
				WHERE thread_id = ".$thread['thread_id'];
			
				$comment_count = DB::instance(DB_NAME)->select_field($q);
			
				?>
			
				<div id="commentCount">
					Number of Comments: <?=$comment_count?>
				</div>
				<div id="topicCreated">
					Started on <?=Time::display($thread['created'])?>
				</div>
				<div style="clear:both;"></div>
			</div>
		<?endforeach;?>
	<?else:?>
		<div id="noThreads">
			This section doesn't have any threads yet. Want to add one? Click <a href="/forums/add/<?=$section['section_id']?>">here</a>.
		</div>
	<?endif;?>
</div>