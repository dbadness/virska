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
					<a href="/professor/dashboard">
						<div class="navButton" id="professorDashboard">
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
					<a href="/forums">
						<div class="navButton" id="forums">
							Forums
						</div>
					</a>
					<a href="/professor/settings">
						<div class="navButton" id="settings">
							Settings
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
					<a href="/forums">
						<div class="navButton" id="forums">
							Forums
						</div>
					</a>
					<a href="/student/settings">
						<div class="navButton" id="settings">
							Settings
						</div>
					</a>
				<?endif;?>
				<div id="userInfo">
					<?if($user->role == 'professor'):?>
					<a href="/professor/help">
						<div id="help">
							Help
						</div>
					</a>
					<?endif;?>
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
				<div style="clear:both;"></div>
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
						<img src="/images/logo.png" width="60">
					</div>
				</a>
				<div id="virska">
					Virska
				</div>
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
			<div class="spacer"></div>
			<div style="text-align:center;">
				<a href="/">Home</a> | <a href="/index/contact">Contact</a> | <a href="/index/about">About</a>
			</div>
			<br>
			<div id="footerWrapper">
				<div>
				<div id="copyright">
					&#174;2013 Edella, Inc
				</div>
				<div id="twitter">
					<a href="https://twitter.com/Virska" class="twitter-follow-button" data-show-count="false">Follow @virska</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				</div>
				<div style="clear:both;">
			</div>
			<div class="spacer"></div>
		</div>
	</div>
</body>
</html>