<?php 
	session_start();

	require 'inc/config.php';
	
	//if not connected go back to login page
	if (!isset($_SESSION['access_token'])) {
		header('Location:index.php');
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Blind Series | Categories</title>
	<link rel="stylesheet" type="text/css" href="src/css/font-awesome-4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="src/css/reset.css">
	<link rel="stylesheet" type="text/css" href="src/css/style.css">
  </head>

<body class="full-screen-background">

 
<header>
	
	
	<div id="logo">
	    <img src="src/img/logo.png" title="logo" alt="logo"/>
	 	<h1>BLIND SERIES</h1>
	</div>

	<div class="user-avatar" style="background-image: url('http://graph.facebook.com/<?php echo $_SESSION['id']; ?>/picture?type=large');" onclick="document.location = 'logout.php';" >
	</div>
</header>



		<div class="title">
		<h3>Please choose a</h3>
		<h4>category</h4>
		</div>

  <div class="category">
    <div class="row-category1">
	    <div><a href="popular.php" class="LinkButton">POPULAR<span>PLAY</span></a></div>
	    <div><a href="game.php?genre=28" class="LinkButton">ACTION<span>PLAY</span></a></div>
	    <div><a href="game.php?genre=18" class="LinkButton">DRAMA<span>PLAY</span></a></div>
	    <div><a href="game.php?genre=12" class="LinkButton">ADVENTURE<span>PLAY</span></a></div>
	    
   	</div>
	<div class="row-category2">
	    <div><a href="game.php?genre=80" class="LinkButton">CRIME<span>PLAY</span></a></div>
	    <div><a href="game.php?genre=36" class="LinkButton">HISTORY<span>PLAY</span></a></div>
	    <div><a href="game.php?genre=10765" class="LinkButton">FANTASY<span>PLAY</span></a></div>
	    <div><a href="game.php?genre=35" class="LinkButton">COMEDY<span>PLAY</span></a></div>
	</div>
  </div>


	<script src="js/jquery-2.1.1.min.js"></script>
	<script src="js/jquery-ui.min.js"></script>
</body>
</html>