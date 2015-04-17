<?php 
	$userData = $_POST['userData'];
	$time = $_POST['time'];

session_start();
if ($userData == $_SESSION['answer']) {
	$_SESSION['goodAnswers'] = $_SESSION['goodAnswers'] + 1;

	$_SESSION['score'] = $_SESSION['score'] + $time*10;
	echo 'true';
}
else {
	$_SESSION['score'] = $_SESSION['score'] - 50;
	$_SESSION['wrong_answer'] = $_SESSION['wrong_answer'] + 1;
	echo $_SESSION['wrong_answer'];
}

?>