<?php 

session_start();

require 'inc/config.php';
$prepare = $pdo->prepare('SELECT score_detail FROM bs_games WHERE id = :id LIMIT 1');
$prepare->bindValue(':id',$_SESSION['game_id']);
$prepare->execute();
$score = $prepare->fetch()->score_detail;
$score = unserialize($score);
$_SESSION['current_score'] = $_POST['time']*10;
$obj = new stdClass;
$obj->show = $_SESSION['show'];
$obj->score = $_SESSION['current_score'];

$score[] = $obj;
$score = serialize($score);
$prepare = $pdo->prepare('UPDATE bs_games SET score_detail = :score_detail WHERE id = :id');
$prepare->bindValue(':score_detail',$score);
$prepare->bindValue(':id',$_SESSION['game_id']);
$prepare->execute();

$_SESSION['numberQuestions'] = $_SESSION['numberQuestions'] + 1;

if ($_SESSION['score'] < 0) {
	$_SESSION['score'] = 0;
}

if ($_SESSION['numberQuestions'] > 10 ) {
	$prepare = $pdo->prepare('UPDATE bs_games SET score = :score WHERE id = :id');
	$prepare->bindValue(':score',$_SESSION['score']);
	$prepare->bindValue(':id',$_SESSION['game_id']);
	$prepare->execute();
	$returnedData = array('video' => '<script>window.location.href = "score.php";</script>', 'wrong_answer' => $_SESSION['wrong_answer'], 'score' => $_SESSION['score']);
	echo json_encode($returnedData);
}
else {
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
	$_SESSION['current_score'] = 0;
	$_SESSION['wrong_answer'] = 0;

	$numberVideos = count($videos->results);

	if ($numberVideos > 0) {
		$theVideo = rand(0,$numberVideos-1);
		$data = $videos->results[$theVideo]->key;
		$returnedData = array('video' => '<iframe width="1200" height="600" src="https://www.youtube.com/embed/'.$data.'?autoplay=1&controls=0&loop=1&playlist='.$data.'" frameborder="0" allowfullscreen></iframe>', 'wrong_answer' => $_SESSION['wrong_answer'], 'score' => $_SESSION['score']);
		echo json_encode($returnedData);
	}


	else {
		echo 'There\'s no video for this TV show';
	}
}