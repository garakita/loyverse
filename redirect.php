<?php

include('common.php');

if (isset($_GET["code"])) {
    $code = $_GET["code"];
    retriveAuthorization($code);
}


function retriveAuthorization($code)
{
    $response = setAccessToken($code);
    file_put_contents("auth.json", $response);
    header('Content-Type: application/json');
    $aresponse = ['success' => 'true', 'message' => 'You can make request now'];
    $return_response =  json_encode($aresponse);
    echo $return_response;
}
