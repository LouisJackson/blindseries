<?php

require 'inc/config.php';

	echo '<H2>Action</H2>';
	$action = api_get('discover/tv',array('page'=>'1','with_genres'=>'28'));

	foreach ($action->results as $_result) {
		echo $_result->original_name.' ( ID='.$_result->id.')';
		echo '<br>';
	}

	echo '<H2>Adventure</H2>';
	$action = api_get('discover/tv',array('page'=>'1','with_genres'=>'12'));

	foreach ($action->results as $_result) {
		echo $_result->original_name.' ( ID='.$_result->id.')';
		echo '<br>';
	}

	echo '<H2>Comedy</H2>';
	$action = api_get('discover/tv',array('page'=>'1','with_genres'=>'35'));

	foreach ($action->results as $_result) {
		echo $_result->original_name.' ( ID='.$_result->id.')';
		echo '<br>';
	}

	echo '<H2>Fantasy</H2>';
	$action = api_get('discover/tv',array('page'=>'1','with_genres'=>'10765'));

	foreach ($action->results as $_result) {
		echo $_result->original_name.' ( ID='.$_result->id.')';
		echo '<br>';
	}

	echo '<H2>History</H2>';
	$action = api_get('discover/tv',array('page'=>'1','with_genres'=>'36'));

	foreach ($action->results as $_result) {
		echo $_result->original_name.' ( ID='.$_result->id.')';
		echo '<br>';
	}

	echo '<H2>Crime</H2>';
	$action = api_get('discover/tv',array('page'=>'1','with_genres'=>'80'));

	foreach ($action->results as $_result) {
		echo $_result->original_name.' ( ID='.$_result->id.')';
		echo '<br>';
	}

	echo '<H2>Drama</H2>';
	$action = api_get('discover/tv',array('page'=>'1','with_genres'=>'18'));

	foreach ($action->results as $_result) {
		echo $_result->original_name.' ( ID='.$_result->id.')';
		echo '<br>';
	}