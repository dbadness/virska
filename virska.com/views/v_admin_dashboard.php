Admin Dashboard
<br><br>
<?foreach($professors as $professor):?>
	<li><?=$professor['first_name']?> <?=$professor['last_name']?> from <?=$professor['school']?> 
		<?if($professor['validated'] == 0):?>
			- <a href="/admin/p_validate/<?=$professor['user_id']?>">Validate?</a></li>
		<?else:?>
			- <i>Validated</i>
		<?endif;?>
<?endforeach;?>
<br><br>
Users: <?=$count?>