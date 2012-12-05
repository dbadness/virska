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
				<a href="/student/dashboard">
					<div class="navButton" id="dashboard">
						Dashboard
					</div>
				</a>
				<a href="/student/notes">
					<div class="navButton" id="notes">
						Notes
					</div>
				</a>
				<div class="navButton" id="documents">
					Documents
				</div>
				<div class="navButton" id="settings">
					Settings
				</div>
				<?endif;?>
					<a href="/users/logout">
						<div id="logout">
							Log Out
						</div>
					</a>
					<div id="userIdentifier">
						Welcome, <?=$user->first_name?>.
					</div>
					<div style="clear:both;">
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
				<div style="clear:both;">
				</div>
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