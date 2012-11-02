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
			<div id="user_indentifier">
				<?if($user):?>
					Welcome, <?=$user->first_name?>. &nbsp &nbsp &nbsp <a style="color: white;" href="/users/logout">Log Out</a>
				<?endif;?>
			</div>
		</div>
	</div>
	<div id="container">
		<div id="nav">
			<?if($user):?>
					<li><a href="/">Home</a></li>
					<li><a href="/users/profile">View Profile</a></li>
					<li><a href="/posts/index">View Posts</a></li>
					<li><a href="/posts/users">View Users to Follow</a></li>		
					<li><a href="/posts/add">Add a Post</a></li>
			<?else:?>
					<li><a href="/">Home</a></li>
					<li><a href="/users/signup">Sign Up</a></li>
					<li><a href="/users/login">Log In</a></li>
			<?endif;?>
		</div>
		<div id="content">
			<?=$content;?> 
		</div>
		<div id="footer">
		</div>
	</div>
</body>
</html>