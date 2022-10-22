<?php

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$CurPageURL = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];


define('API_KEY', "LDdbGj481V7a9mcGSuo3");
define('SECRET_KEY', "YABN6DcyHGosqrETRt8-m4d9pejIjWVc65M4fbQkJM7RGJKLcBrIdA==");
define('REDIRECT_URL', "https://loyverse.herokuapp.com/redirect.php");

// define('COMPANY_ID', '11');
// define('ENCRYPT', 'bceb69');
// define('PASSKEY', '16f97988bceb69c1efd74a64ba65b160');

//-- auth ที่มาจากการจำลอง server เข้าสู่ TRCLOUD
define('COMPANY_ID', '11');
define('ENCRYPT', 'c38068');
define('PASSKEY', '4ae37d8ec380686f31ba9891c34bda6e');


define('POSTNG_URL', 'https://parat.trcloud.co/application/api-connector/end-point/engine-revenue/invoice.php');
define('AUTH_URL', 'https://api.loyverse.com/oauth/authorize?client_id=' . API_KEY . '&scope=CUSTOMERS_READ CUSTOMERS_WRITE EMPLOYEES_READ ITEMS_READ INVENTORY_READ INVENTORY_WRITE ITEMS_WRITE MERCHANT_READ PAYMENT_TYPES_READ POS_DEVICES_READ POS_DEVICES_WRITE RECEIPTS_READ RECEIPTS_WRITE SHIFTS_READ STORES_READ SUPPLIERS_READ SUPPLIERS_WRITE TAXES_READ TAXES_WRITE&response_type=code&redirect_uri='.REDIRECT_URL);

function initCurl($url)
{
    $request = null;

    if (($request = @curl_init($url)) == false) {
        header("HTTP/1.1 500", true, 500);
        die("Cannot initialize cUrl session. Is cUrl enabled for PHP?");
    }

    curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($request, CURLOPT_ENCODING, 1);

    return $request;
}



function setAccessToken($code)
{
    $request = initCurl("https://api.loyverse.com/oauth/token");

    // Assemble POST parameters for the request.
    $post_fields = "grant_type=authorization_code&code=" . $code .
        "&client_id=" . API_KEY .
        "&client_secret=" . SECRET_KEY .
        "&redirect_uri=" . REDIRECT_URL;

    // Obtain and return the access token from the response
    curl_setopt($request, CURLOPT_POST, true);
    curl_setopt($request, CURLOPT_POSTFIELDS, $post_fields);
    curl_setopt($request, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($request);
    if ($response == false) {
        die("curl_exec() failed. Error: " . curl_error($request));
    }

    // Return JSON token
    return  $response;
}

//This function is used to retrive an accesstoken from refresh token. Obtain and return the access token from the response
//response

function refreshToken($refresh)
{
    $request = initCurl("https://api.loyverse.com/oauth/token");

    // Assemble POST parameters for the request.
    $post_fields = "grant_type=refresh_token&refresh_token=" . $refresh .
        "&client_id=" . API_KEY .
        "&client_secret=" . SECRET_KEY .
        "&redirect_uri=" . REDIRECT_URL;

    // Obtain and return the access token from the response
    curl_setopt($request, CURLOPT_POST, true);
    curl_setopt($request, CURLOPT_POSTFIELDS, $post_fields);

    $response = curl_exec($request);
    if ($response == false) {
        die("curl_exec() failed. Error: " . curl_error($request));
    }

    // Return JSON token
    $ajson = json_decode($response,true);
    return $ajson['access_token'];
}

//-- function สำหรับจัดเรียงสินค้า
function array_orderby()
{
    $args = func_get_args();
    $data = array_shift($args);
    foreach ($args as $n => $field) {
        if (is_string($field)) {
            $tmp = array();
            foreach ($data as $key => $row)
                $tmp[$key] = $row[$field];
            $args[$n] = $tmp;
            }
    }
    $args[] = &$data;
    call_user_func_array('array_multisort', $args);
    return array_pop($args);
}
