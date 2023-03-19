
<?php



include('common.php');

//-- ดึงจาก 05 - 14 
$ajson = file_get_contents("auth.json");
$json = json_decode($ajson, true);
$refresh_token = $json['refresh_token'];

$token = refreshToken($refresh_token);
define('ACCESS_TOKEN', $token);


$start_date_time = date('Y-m-d 00:00:00');
$end_date_time = date('Y-m-d 23:59:59');

//$start_date_time = date('22-12-02 00:00:01');
//$end_date_time = date('22-12-02 23:59:59');

$start_date_time = date('Y-m-d\TH:i:s.sZ', strtotime($start_date_time));
$end_date_time = date('Y-m-d\TH:i:s.sZ', strtotime($end_date_time));
$curl = curl_init();


$url = 'https://api.loyverse.com/v1.0/receipts?created_at_min=' . $start_date_time . 'Z&created_at_max=' . $end_date_time . 'Z&limit=250';


curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer ' . ACCESS_TOKEN,
    ),
));
$response = curl_exec($curl);
if ($response == false) {
    exit("curl_exec() failed. Error: " . curl_error($curl));
} else {
    $response = json_decode($response, true);
    $val = 1;
    $val_shop2 = 2;
    if (!empty($response)) {
        $receipts = $response['receipts'];
        $invoice_number =  date('ymd') . '' . str_pad($val, 3, "0", STR_PAD_LEFT);
        $invoice_number_shop2 =  date('ymd') . '' . str_pad($val_shop2, 3, "0", STR_PAD_LEFT);
        // $invoice_number = time();

        // echo "<pre>";
        // print_r($receipts);
        // echo "</pre>";
        // return;
        $c1 = 0;
        $c2 = 0;
        $c3 = 0;
        $c4 = 0;
        $c5 = 0;
        $c6 = 0;
        $c7 = 0;
        $c8 = 0;
        $c9 = 0;
        $gross_total_money = 0;
        $total_discount = 0;
        $total_money = 0;
        $money_amount1 = 0;

        //For shop 2

        $c1_shop2 = 0;
        $c2_shop2 = 0;
        $c3_shop2 = 0;
        $c4_shop2 = 0;
        $c5_shop2 = 0;
        $c6_shop2 = 0;
        $c7_shop2 = 0;
        $c8_shop2 = 0;
        $c9_shop2 = 0;
        $gross_total_money_shop2 = 0;
        $total_discount_shop2 = 0;
        $total_money_shop2 = 0;
        $money_amount1_shop2 = 0;

        //-- ถ้ารายการ list of receipts type เป็น Refund ตัดออกได้เลย
        // $arr = array();
        $is_shop1 = false;
        $is_shop2 = 0;
        foreach ($receipts as $key => $value) {

            if ($value['store_id'] == 'ac7c9633-482b-4cd4-a622-b274d938119f') {
                require 'shop_1.php';
                $is_shop1 = true;
            } else {
                require 'shop_2.php';
                $is_shop2 = 1;
            }
        }
        if ($is_shop1) {
            require 'shop_1_response.php';
        }
        if ($is_shop2) {
            require 'shop_2_response.php';
        }
    }
}
curl_close($curl);

function getStoreDetails($store_id)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.loyverse.com/v1.0/stores/' . $store_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . ACCESS_TOKEN
        ),
    ));

    $response = curl_exec($curl);
    if ($response == false) {
        exit("curl_exec() failed. Error: " . curl_error($curl));
    }

    curl_close($curl);
    $response = json_decode($response, true);

    return $response;
}

//-- Line Notify
function line_notify($option)
{

    $data = json_decode($option["input"]["json"], true);

    //-- Line Notify Token :XGnsQNYg39M8EZ3r6ZN4sZYqtNmlN8eXmKpz391XzsJ -Mac Personal Line Notify
    $sToken = "v7acXZd2xKWwNSyxsW3YKsZZv15r6j38PlWEGxDfhos"; //-- นำ line notify token Bigwell group
    $sMessage = "มีรายการถูกนำเข้า....\n";
    $sMessage .= "แจ้งเตือน : " . $option["message"] . "\n";

    //-- ถ้ายิง api เข้าจะแสดงผล ดังนี้
    if ($option["success"] == 1) {
        $sMessage .= "Document : " . $data["company_format"] . $data["invoice_no"] . "\n";
        $sMessage .= "Date : " . $data["issue_date"] . "\n";
        $sMessage .= "Title : " . $data["customer"]["title"] . "\n";
        $sMessage .= "Name : " . $data["customer"]["name"] . "\n";
        $sMessage .= "Cash : " . $data["c1"] . "\n";
        $sMessage .= "โอนเงิน : " . $data["c2"] . "\n";
        $sMessage .= "D- Lineman : " . $data["c3"] . "\n";
        $sMessage .= "D- Grabfood : " . $data["c4"] . "\n";
        $sMessage .= "D- Robinhood : " . $data["c5"] . "\n";
        $sMessage .= "D- Shopeefood : " . $data["c6"] . "\n";
        $sMessage .= "D- Food Panda : " . $data["c7"] . "\n";
        $sMessage .= "D- Truefood : " . $data["c8"] . "\n";
        $sMessage .= "D- Airasia Food : " . $data["c9"] . "\n";
        $sMessage .= "ยอดรวมสุทธิ :	" . $data["grand_total"] . "\n";
    }

    $chOne = curl_init();
    curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
    curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($chOne, CURLOPT_POST, 1);
    curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $sMessage);
    $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $sToken . '',);
    curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($chOne);

    //-- Result error 
    if (curl_error($chOne)) {
        echo 'error:' . curl_error($chOne);
    } else {
        $result_ = json_decode($result, true);
        echo "status : " . $result_['status'];
        echo "message : " . $result_['message'];
        if (isset($response['success']) && $response['success'] == 0) {
            $to = 'ma99iimac@gmail.com';
            $subject = 'Invoice was not added: ' . date('Y-m-d');
            $from = 'ma99iimac@gmail.com';

            // To send HTML mail, the Content-type header must be set
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            // Create email headers
            $headers .= 'From: ' . $from . "\r\n" .
                'Reply-To: ' . $from . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            // Compose a simple HTML email message
            $message = '<html><body>';
            $message .= $response['message'];
            echo $message .= '</body></html>';

            if (mail($to, $subject, $message, $headers)) {
                echo 'Your mail has been sent successfully.';
            } else {
                echo 'Unable to send email. Please try again.';
            }
        }
    }
    curl_close($chOne);
}
