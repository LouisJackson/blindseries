<?php

require 'inc/config.php';

$id = $_POST['id'];
$showInfos = api_get('tv/'.$id);

echo json_encode($showInfos);