Validation Queue
<br><br>
<div id="validationQueue">
	<?foreach($professors as $professor):?>
		<div class="listItem">
			<div id="professorName">
				<?=$professor['first_name']?> <?=$professor['last_name']?> from <?=$professor['school']?> 
			</div>
			<div id="validated">
					<?=Time::display($professor['created'])?>
				<?if($professor['validated'] == 0):?>
					&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href="/admin/p_validate/<?=$professor['user_id']?>">Validate?</a></li>
				<?else:?>
					&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<i>Validated</i>
				<?endif;?>
			</div>
			<div style="clear:both;"></div>
		</div>
	<?endforeach;?>
</div>
<br><br>
User Report
<br><br>
<div id="userReport">
	Total Users: <?=$count?>
</div>