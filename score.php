<?php 
	session_start();

	require 'inc/config.php';

	//if not connected go back to login page
	if (!isset($_SESSION['access_token'])) {
		header('Location:index.php');
	}

	//if has launch a game during this session, get user's last score
	if (isset($_SESSION['game_id'])) {
		$prepare = $pdo->prepare('SELECT * FROM bs_games WHERE id = :id LIMIT 1');
		$prepare->bindValue(':id',$_SESSION['game_id']);
		$prepare->execute();
		$gameInfos = $prepare->fetch();

		$score = $gameInfos->score;
		$score_detail = $gameInfos->score_detail;
		$score_detail = unserialize($score_detail);
	}
	else {
		//else go back to category page
		header('Location:category.php');
	}

	//get best scores
	$prepare = $pdo->prepare('SELECT * FROM bs_games ORDER BY score DESC');
	$prepare->bindValue(':id',$_SESSION['game_id']);
	$prepare->execute();


 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Blind Series | Score</title>
	<link rel="stylesheet" type="text/css" href="src/css/font-awesome-4.3.0/css/font-awesome.min.css">
	<link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="src/css/reset.css">
	<link rel="stylesheet" type="text/css" href="src/css/style.css">
  	
</head>

<body class="full-screen-background">
<div class="popin_page_info hidden">

	
			
				<div class="selection">
					<div class="serie_content bar_select visible_inline"></div>
					<div class="serie_pictures bar_select hidden"></div>
				</div>

				<div class="title-pop-in">
                    <div class="rating-canvas">
                        <span id="loading_rating"></span>
                        <canvas id="myCanvas" width="100" height="100"></canvas>
                    </div>
                    <p class="big_text weight_black center spacing line_height_titles">GAME OF THRONES</p>
                    <p class="small_text white center line_height_titles">
                        <span>Released in <span class="release-year">2011</span></span> - 
                        <span class="green runtime">55 min</span> - 
                        <span class="number_season">5 seasons</span>
                    </p>
                </div>
				<div class="info">
					<div class="info_content visible">
                    <img class="poster" src="src/img/poster.jpg">
                
                    <div class="synopsis left">
                        <p class="small_text bold spacing">Creators :
                        <br>
                        <span class="creators text">David Benioff, D.B. Weiss</span>
                        </p>

                        <p class="small_text bold spacing between_spacing">Stars :
                        <br>
                        <span class="stars text">Peter Dinklage, Lena Headey, Kit Harington, Primi igitur omnium statuuntur Epigonus et Eusebius ob nominum gentilitatem oppressi. praediximus enim Montium sub ipso vivendi termino his vocabulis appellatos fabricarum culpasse tribunos ut adminicula futurae molitioni pollicitos.</span>
                        <span class="more_info green text info_star visible_inline"> - See full Cast Crew</span>
                        <span class="more_info green text info_star_2 hidden"> - See LESS Cast Crew</span>
                        </p>

                        <div class="line"></div>

                        <p class="medium_text bold spacing between_spacing">Synopsis :
                        <br>
                        <span class="synopsis_content text">Nine noble families fight for control of the mythical land of Westeros. Political and sexual intrigue is pervasive. Robert Baratheon, King of Westeros, asks his old friend Eddard, Lord Stark, to serve as Hand of the King, or highest official. Secretly warned that the previous Hand was assassinated, Eddard accepts in order to investigate further. Meanwhile the Queen's family, the Lannisters, may be hatching a plot to take power. Across the sea, the last members of the previous and deposed ruling family, the Targaryens, are also scheming to regain the throne. The friction between the houses Stark, Lannister, Baratheon and Targaryen and with the remaining great houses Greyjoy, Tully, Arryn,Tyrell and Martell leads to full-scale war. All while a very ancient evil awakens in the farthest north. Amidst the war and political confusion, a neglected military order of misfits, the Night's Watch, is all that stands between the realms of men and icy horrors beyond. </span>

                        <span class="more_info green text synopsis_info visible_inline"> - Read more</span>
                        <span class="more_info green text synopsis_info_2 hidden"> - Read less</span>
                        </p>
                    </div>
                </div>

					<div class="info_photos hidden">

						<div class="slider slider-2">
							<a href="#" class="arrow left"></a>
							<a href="#" class="arrow right"></a>
							<div class="wrapper">
								<div class="container">
								</div>
							</div>
						</div>
						
					</div>
				</div>
		</div>	

<header>
	
	<a href="category.php" class="returnmenu"><i class="fa fa-arrow-left"></i> CATEGORY</a>
	
	<div id="logo">
	    <img src="src/img/logo.png" title="logo" alt="logo"/>
	 	<h1>BLIND SERIES</h1>
	</div>

	<div class="user-avatar" style="background-image: url('http://graph.facebook.com/<?php echo $_SESSION['id']; ?>/picture?type=large');"  onclick="document.location = 'logout.php';">
	</div>
</header>

<div class="total-score">
			<p class="color">YOU HAVE SCORED :</p>
			<p class="scoring-large heavy"><?php echo $score; ?> <span>pts</span></p>
</div>

<div class="share-button" onclick="fb_share();" >
				<span>SHARE</span>
</div>
<div class="result-visual" >
<?php foreach ($score_detail as $_score_detail):?>
	<?php 
	//foreach show get the id of the show
	$currentTV = api_get('tv/'.$_score_detail->show);
	 ?>
	<div class="column1 show visble" onclick="loadSerie(<?php echo $_score_detail->show; ?>);"><span href="#"><span class="overlay" style="background-image: url('http://image.tmdb.org/t/p/w500<?php echo $currentTV->poster_path ?>'); height: <?php echo intval($_score_detail->score)*250/450 ?>px;"></span></span></div>
<?php endforeach ?>
		</div>

	<div class="scores-list">
			<div class="scores">
				<h1>Meilleurs scores:</h1>
				<ul>
				<?php 
				//get the 10 first best scores
				for ($i=0; $i < 5; $i++) { 
					?> 
					<li><?php echo $prepare->fetch()->score; ?> points</li>
					<?php
				} ?>
				</ul>
				
			</div>
				
				
				<hr><span>&</span><hr> 
				


			<div class="scores2">
				<ul>
				<?php for ($i=0; $i < 5; $i++) { 
					?> 
					<li><?php echo $prepare->fetch()->score; ?> points</li>
					<?php
				} ?>
				</ul>
			</div>
		</div>

	</div>

<div class="play-button" onclick="document.location = 'category.php';">
				<span>PLAY AGAIN</span>
</div>		



	<script src="http://code.jquery.com/jquery-1.11.2.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
	<script src="src/js/script_score.js"></script>
</body>
</html>