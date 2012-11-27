<!DOCTYPE html>
<html>
<head>
	<title><?=@$title; ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
	
	<!-- JS -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
	<script src="/js/nav.js"></script>
		
	<link rel="stylesheet" type="text/css" href="/css/main.css" />
	<link rel="stylesheet" type="text/css" href="/css/nav.css" />
	
				
	<!-- Controller Specific JS/CSS -->
	<?php echo @$client_files; ?>
	
</head>

<body>
	<div id="navBar">
		<div id="headerContainer">
			<?if($user):?>
				<?if($user->role == 'professor'):?>
					<div class="navButton" id="classes">
						My Classes
					</div>
				<?elseif($user->role == 'student'):?>
					<!-- student nav goes here -->
				<?endif;?>
					<div id="userIndentifier">
						Welcome, <?=$user->first_name?>.<a style="color: white;" href="/users/logout">Log Out</a>
					</div>
					<div class="navButton" id="logout">
						Log Out
					</div>
			<?else:?>
				<a href="/users/login">
					<div class="navButton" id="login">
						Login
					</div>
				</a>
				<a href="/users/signup">
					<div class="navButton" id="signup">
						Sign Up
					</div>
				</a>
			<?endif;?>
		</div>
	</div>
	<div id="container">
		<div class="spacer">
		</div>
		<div id="content">
			<?=$content;?> 
		</div>
		<div class="spacer">
		</div>
		<div id="footer">
		</div>
	</div>
</body>
</html>