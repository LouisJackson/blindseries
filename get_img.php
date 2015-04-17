<?php

require 'inc/config.php';

$id = $_POST['id'];
$showInfos = api_get('tv/'.$id.'/images');

echo json_encode($showInfos);