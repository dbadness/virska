<!DOCTYPE html>
<html>
<head>
	<title><?=@$title; ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
	
	<!-- JS -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
	
	<link rel="stylesheet" type="text/css" href="/css/main.css" />
				
	<!-- Controller Specific JS/CSS -->
	<?php echo @$client_files; ?>
	
</head>

<body>
	<div id="header-background">
		<div id="header-copy">
			<?if($user):?>
				<div id="user_indentifier">
					Welcome, <?=$user->first_name?>. &nbsp &nbsp &nbsp <a style="color: white;" href="/users/logout">Log Out</a>
				</div>
			<?else:?>
				<div id="signup">
					<a href="/users/login">Log In</a> or <a href="/users/signup">Sign up!</a>
				</div>
			<?endif;?>
		</div>
	</div>
	<div id="container">
		<div class="spacer">
		</div>
		<div id="contents">
			<?=$content;?> 
		</div>
		<div class="spacer">
		</div>
		<div id="footer">
		</div>
	</div>
</body>
</html>