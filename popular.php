<?php 
	session_start();

	require 'inc/config.php';

	//if not connected go back to login page
	if (!isset($_SESSION['access_token'])) {
		header('Location:index.php');
	}

	if (isset($_SESSION['id'])) {

		$prepare = $pdo->prepare('SELECT * FROM bs_users WHERE facebook_id=:facebook_id LIMIT 1');
		$prepare->bindValue(':facebook_id',$_SESSION['id']);
		$prepare->execute();
		$id = $prepare->fetch()->id;
		$score = 0;
		$score_detail = array();
		$score_detail = serialize($score_detail); 

		$prepare = $pdo->prepare('INSERT INTO bs_games (user_id,score_detail,score) VALUES (:user_id,:score_detail,:score)');
	    $prepare->bindValue(':user_id',$id);
	    $prepare->bindValue(':score_detail',$score_detail);
	    $prepare->bindValue(':score',$score);
	    $prepare->execute();

	    $prepare = $pdo->prepare('SELECT LAST_INSERT_ID()');
	    $prepare->execute();
	    $_SESSION['game_id'] = $prepare->fetch();
	    $_SESSION['game_id'] =  (array) $_SESSION['game_id'];
	    $_SESSION['game_id'] = $_SESSION['game_id']['LAST_INSERT_ID()'];
	}


 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Blind Series | Game</title>
	<script src="http://code.jquery.com/jquery-1.11.2.js"></script>
	<link rel="stylesheet" type="text/css" href="src/css/reset.css"> 
	<link rel="stylesheet" type="text/css" href="src/css/style.css">
	<link rel="stylesheet" type="text/css" href="src/css/normalize.css" />
	<link rel="stylesheet" type="text/css" href="src/css/font-awesome-4.3.0/css/font-awesome.min.css">
	<script src="src/js/modernizr.custom.js"></script>
</head>
<body id="full-screen-background">
	<div class="black-layer">
	<header>
	
		<div id="logo">
		    <img src="src/img/logo.png" title="logo" alt="logo"/>
		 	<h1>BLIND SERIES</h1>
		</div>
		<div class="user-avatar" style="background-image: url('http://graph.facebook.com/<?php echo $_SESSION['id']; ?>/picture?type=large');" onclick="alert('yo')" >
		</div>
	</header>
	<section class="score-countdown">	
				<div class="current-score"><span>current score : </span><span class="color scoring-large">0</span></div>
		

				<div class="countdown">
				  <div class="timer">
				 	 <p><span id="time"></span>:<span id="timeSec"></span></p>
				  		<span class="remaining">seconds remaining</span>
				  </div>

				  <svg width="200px" height="200px" viewBox="-5 0 210 200" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
				        <path d="M200,100 C200,44.771525 155.228475,0 100,0 C44.771525,0 0,44.771525 0,100 C0,155.228475 44.771525,200 100,200 C155.228475,200 200,155.228475 200,100 Z" class="circle progress" style="-webkit-animation-duration: 45s; -webkit-animation-iteration-count: infinite"></path>
				  </svg>
				</div>
	 		</section>
			<section class="answer-input">
				<div class="round-alerts">
					<div class="subround-red hide"><div class= "error-answer"><i class="fa fa-times fa-3x"></i></div></div>
					<div class="subround-green hide"><div class= "valid-answer"><i class="fa fa-check fa-3x"></i></div></div>
					<div class="subround-orange"><div class= "need-answer"><i class="fa fa-question fa-3x"></i></div></div>
				</div>
				<form id="theForm" class="simform" autocomplete="off">
                                <input id="question" type="text"/>
                                <button class="submit" type="submit"><i class="fa fa-arrow-right"></i></button>
                </form>
			
					<div class="bad-answer-count">
						<p><span class="bad-counter1">0</span><span class="bad-counter2">/</span><span class="wrong-answer1">WRONG </span><span class="wrong-answer2">ANSWER</span></p>

					</div>
				
			</section>
	</div>
	<?php
$thePage = rand(1,10);
$popular = api_get('tv/popular',array('page'=>$thePage));

do {
	$theVideo = rand(0,count($popular->results)-1);
	$id = $popular->results[$theVideo]->id;
	$series = $popular->results[$theVideo]->original_name;
	$_SESSION['answer'] = addslashes(strtolower($series));
	$videos = api_get("tv/".$id."/videos");
} while ( count($videos->results) <= 0 );

$_SESSION['show'] = $id;
$_SESSION['numberQuestions'] = 1;
$_SESSION['goodAnswers'] = 0;
$_SESSION['score'] = 0;
$_SESSION['wrong_answer'] = 0;
$_SESSION['current_score'] = 0;


$numberVideos = count($videos->results);

if ($numberVideos > 0) {
	$theVideo = rand(0,$numberVideos-1);
	$data = $videos->results[$theVideo]->key;?>
	<div id='video'>
	<?php
	echo '<iframe width="1200" height="600" src="https://www.youtube.com/embed/'.$data.'?autoplay=1&controls=0&loop=1&playlist='.$data.'" frameborder="0" allowfullscreen></iframe>';
	?>
	</div>
	<?php
}

else {
	echo 'There\'s no video for this TV show';
}

?>
<script type="text/javascript" src="src/js/script.js"></script>
<script>

	function addslashes(ch) {
		ch = ch.replace(/\'/g,"\'");
		return ch;
	}

	function loadVideos(time) {
		data = 'time='+timer;
		$.post('new_vid.php', data, function(data) {
			data = JSON.parse(data);
  			$("#video").html(data.video);
  			$(".bad-counter1").html(data.wrong_answer);
  			$(".scoring-large").html(data.score);
  			$("#question").val('');
  			$('.subround-green').addClass('hide');
	        $('.subround-red').addClass('hide');
	       	$('.subround-orange').removeClass('hide');
  		});
	}
	function loadEnd() {
		$.post('end.php', function(data) {
  			$("#video").html(data);
  		});
	}

	function restartTimer() {	
	      	      
 		var el     = $('svg'),
 		newone = el.clone(true);
		el.before(newone);
		$("svg:last").remove();
		timer = 45;
		centiSec = 100;
		countdownMin = window.setInterval(function(){ countdown(); }, 1000);
		countdownSec = window.setInterval(function () { countdownBis(); }, 10);
	}

	var timer2 = setInterval(function () {loadVideos(timer)}, 45000);

	$("#theForm").on( "submit", function(event) {
		event.preventDefault();
		var userData = addslashes($('input').val());
		userData = 'userData='+ userData.toLowerCase()+"&time="+timer;
		$.ajax({
			url: 'check.php',
			method: 'POST',
			data: userData,
			dataType: 'html',
			success : function(data, statut){
           		if (data == 'true') {
	           		loadVideos(timer);
	           		clearInterval(timer2);
	           		clearInterval(countdownMin);
	           		clearInterval(countdownSec);
	           		timer2 = setInterval(function () {loadVideos(timer)}, 45000);
	           		restartTimer();
	           		$('.subround-green').removeClass('hide');
	           		$('.subround-orange').addClass('hide');
	           	}
           		else {
           			$('.bad-counter1').html	(data);
           			$('.subround-red').removeClass('hide').delay(1000).queue(function(){
    					$(this).addClass('hide');
    				});
	           		$('.subround-orange').addClass('hide').delay(1000).queue(function(){
    					$(this).removeClass('hide');
					});
					$("#question").val('');
           		}
	       	},
			error : function(resultat, statut, erreur){
				console.log(erreur);
	        }
		});
	});
</script>
	</body>
</html>