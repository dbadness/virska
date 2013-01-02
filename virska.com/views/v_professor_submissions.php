Submissions
<br>
<br>
<?foreach($submissions as $submission):?>
	<?=$submission['student_fname']?> <?=$submission['student_lname']?> submitted <a href="/docs/<?=$submission['doc']?>">their assignment</a> on <?=Time::display($submission['modified'])?>
	<br>
<?endforeach;?>