<div class="listHeader">
	<strong>Validation Queue</strong>
</div>
<div id="validationQueue">
	<?if(!$professors):?>
		<div class="ifNoVariables" id="noProfessors">
			There are no professors in the validation queue. Let's hit up marketing!
		</div>
	<?else:?>
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
	<?endif;?>
</div>
<div class="spacer"></div>
<div class="listHeader">
	<strong>User Reports</strong>
</div>
<div id="userReports">
	<div id="dodGrowth">
	</div>
	<div id="wowGrowth">
	</div>
	<div id="momGrowth">
	</div>
</div>