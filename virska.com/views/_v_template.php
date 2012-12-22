<!DOCTYPE html>
<html>
<head>
	<title><?=@$title; ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
	
	<!-- JS -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
	<script src="/js/nav.js"></script>
	<script src="/js/main.js"></script>
		
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
					<a href="/professor/classes">
						<div class="navButton" id="myClasses">
							My Classes
						</div>
					</a>
					<a href="/notes">
						<div class="navButton" id="notes">
							Notes
						</div>
					</a>
					<a href="/documents">
						<div class="navButton" id="documents">
							Documents
						</div>
					</a>
				<?elseif($user->role == 'student'):?>
					<a href="/student/dashboard">
						<div class="navButton" id="dashboard">
							Dashboard
						</div>
					</a>
					<a href="/notes">
						<div class="navButton" id="notes">
							Notes
						</div>
					</a>
					<a href="/documents">
						<div class="navButton" id="documents">
							Documents
						</div>
					</a>
					<div class="navButton" id="settings">
						Settings
					</div>
				<?endif;?>
					<div id="userInfo">
						<a href="/users/logout">
							<div id="logout">
								Log Out
							</div>
						</a>
						<div id="userIdentifier">
							Welcome, <?=$user->first_name?>.
						</div>
						<div style="clear:both;"></div>
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
				<a href="/">
					<div id="logo">
						<img src="/images/logo.png">
					</div>
				</a>
				<div style="clear:both;"></div>
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