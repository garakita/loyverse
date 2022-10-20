<?php

include_once('common.php');

$ajson = file_get_contents("auth.json");
$json = json_decode($ajson,true);
$refresh_token = $json['refresh_token']; 

echo $token = refreshToken($refresh_token);