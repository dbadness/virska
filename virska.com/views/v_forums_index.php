<?if(isset($sections)):?>
	<?if($user->role == 'student'):?>
		<div class="listHeader">
			<strong>Sections I'm Following</strong>
		</div>
	<?elseif($user->role == "professor"):?>
		<div class="listHeader">
			<strong>Sections I Own</strong>
		</div>
	<?endif;?>
	<?foreach($sections as $section):?>
		<?
		# since we're in a foreach loop, let's put the php here to gather our counts
		$q = "SELECT COUNT(thread_id)
		FROM threads 
		WHERE section_id = ".$section['section_id'];
		
		$thread_count = DB::instance(DB_NAME)->select_field($q);
		
		$q = "SELECT COUNT(comment_id)
		FROM comments 
		WHERE section_id = ".$section['section_id'];
		
		$comment_count = DB::instance(DB_NAME)->select_field($q);
		
		$q = "SELECT COUNT(comment_id)
		FROM comments 
		WHERE section_id = '".$section['section_id']."'
		AND user_id = ".$user->user_id;
		
		$my_comment_count = DB::instance(DB_NAME)->select_field($q);
		?>
		
		<div id="section">
			<div id="sectionInfo">
			The <?=$section['class_name']?> (Section <?=$section['section_name']?>) forum has <?=$thread_count?> threads and <?=$comment_count?> comments.<br>You have <?=$my_comment_count?> comments in this section's threads.
			</div>
			<div id="forumLinks">
				<div id="add" class="button">
					<a href="/forums/add/<?=$section['section_id']?>">Add a Thread to This Section</a>
				</div>
				<div id="view" class="button">
					<a href="/forums/view_section/<?=$section['section_id']?>">View the Threads of This Section</a>
				</div>
				<div style="clear:both;"></div>
			</div>
		</div>
		<div class="spacer"></div>
	<?endforeach;?>
<?endif;?>