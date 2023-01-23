<?php



include('common.php');

//-- ดึงจาก 05 - 14 
$ajson = file_get_contents("auth.json");
$json = json_decode($ajson, true);
$refresh_token = $json['refresh_token'];

$token = refreshToken($refresh_token);
define('ACCESS_TOKEN', $token);


$start_date_time = date('Y-m-d 00:00:01');
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
    if (!empty($response)) {
        $receipts = $response['receipts'];
        $invoice_number =  date('ymd') . '' . str_pad($val, 3, "0", STR_PAD_LEFT);
        // $invoice_number = time();
        $val++;
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

        //-- ถ้ารายการ list of receipts type เป็น Refund ตัดออกได้เลย
        // $arr = array();
        foreach ($receipts as $key => $value) {

            if( empty($value["cancelled_at"]) ){


            $payments = $value['payments'];
          
           
            foreach ($payments as $pmtk => $pmtv) {
                
               
                   
                    if($pmtv['name']=='Cash' || $pmtv['name']=='cash'){
                    
                        $c1 = ( $value["receipt_type"] == "SALE" ) ? $c1 + $pmtv['money_amount'] : $c1 - $pmtv['money_amount'];
                        
                    }
                    if($pmtv['name']=='1-โอนเงิน' || $pmtv['name']=='1- โอนเงิน'){
                    
                         $c2 = ( $value["receipt_type"] == "SALE" ) ? $c2 + $pmtv['money_amount'] : $c2 - $pmtv['money_amount'];
                    }
                    if($pmtv['name']=='D-Line Man' || $pmtv['name']=='D- Line Man'){
                    
                        $c3 = ( $value["receipt_type"] == "SALE" ) ? $c3 + $pmtv['money_amount'] : $c3 - $pmtv['money_amount'];
                        
                    }
                    if($pmtv['name']=='D-Grabfood' || $pmtv['name']=='D- Grabfood'){
                    
                        $c4 = ( $value["receipt_type"] == "SALE" ) ? $c4 + $pmtv['money_amount'] : $c4 - $pmtv['money_amount'];
                        
                    }
                    if($pmtv['name']=='D-Robinhood' || $pmtv['name']=='D- Robinhood'){
                    
                        $c5 = ( $value["receipt_type"] == "SALE" ) ? $c5 + $pmtv['money_amount'] : $c5 - $pmtv['money_amount'];
                         
                    }
                    if($pmtv['name']=='D-Shopeefood' || $pmtv['name']=='D- Shopeefood'){
                    
                        $c6 = ( $value["receipt_type"] == "SALE" ) ? $c6 + $pmtv['money_amount'] : $c6 - $pmtv['money_amount'];
                         
                    }
                    if($pmtv['name']=='D-Food Panda' || $pmtv['name']=='D- Food Panda'){
                    
                        $c7 = ( $value["receipt_type"] == "SALE" ) ? $c7 + $pmtv['money_amount'] : $c7 - $pmtv['money_amount'];
                        
                    }
                    if($pmtv['name']=='D-Truefood' || $pmtv['name']=='D- Truefood'){
                    
                        $c8 = ( $value["receipt_type"] == "SALE" ) ? $c8 + $pmtv['money_amount'] : $c8 - $pmtv['money_amount'];
                        
                    }
                    if($pmtv['name']=='D-Airasia Food' || $pmtv['name']=='D- Airasia Food'){
                    
                        $c9 = ( $value["receipt_type"] == "SALE" ) ? $c9 + $pmtv['money_amount'] : $c9 - $pmtv['money_amount'];
                        
                    }

               
           
          
            }
            // ac7c9633-482b-4cd4-a622-b274d938129f
            // ac7c9633-482b-4cd4-a622-b274d938119f
            if ($value['store_id'] == 'ac7c9633-482b-4cd4-a622-b274d938119f') {

                $salesman = 'SP1-SC_Plaza';
                
                $warehouse = 'S1-SC_Plaza';
                
                $department = 'B1-SC_Plaza';

                $company_format = "IV1";

                $customer = [
                    "title" => 'S0001',
                    "name" => 'หน้าร้าน สาขา sc plaza',
                    "organization" => "",
                    "branch" => "่",
                    "email" => "",
                    "telephone" => "",
                    "address" => "",
                    "tax_id" => "",
                    "add_contact" => false,
                    "update_contact" => true,
                    "contact_id" => 3460
                ];
				

            }else if ($value['store_id'] == 'e4db6398-022a-4b3e-b382-4b0e8b36e66e') {
				
				
				 $company_format = "IV2";

                $salesman = 'SP2-Sai4';
                $warehouse = 'S2-Sai4';
                $department = 'B2-Sai4';
                
				$customer = [
				"title" => 'S0002',
				"name" => 'หน้าร้าน สาขา สาย 4',
				"organization" => "",
				"branch" => "",
				"email" => "",
				"telephone" => "",
				"address" => "",
				"tax_id" => "",
				"add_contact" => false,
				"update_contact" => true,
				"contact_id" => 3462

				];

			}

            $lineItem = $value['line_items'];
           
            // if( $value["receipt_type"] == "SALE" ){
            foreach ($lineItem as $key1 => $value1) {

                $gross_total_money = ( $value["receipt_type"] == "SALE" ) ? $gross_total_money + $value1['gross_total_money'] : $gross_total_money - $value1['gross_total_money'];
                $total_money = ( $value["receipt_type"] == "SALE" ) ? $total_money + $value1['total_money'] :  $total_money - $value1['total_money'];
                $total_discount = ( $value["receipt_type"] == "SALE" ) ?$total_discount + $value1['total_discount'] : $total_discount;

                // $it["sku"] = $value1["sku"];
                // $it["price"] = $value1["price"];
                // $it["quantity"] = $value1["quantity"];
                // $it["discount"] = $value1["total_discount"];
                // $it["before"] = $value1["total_money"];
                // $it["amount"] = $value1["gross_total_money"];
                // $it["total_money"] = $total_money;
                // $it["gross_total_money"] = $gross_total_money;
                // array_push($arr,$it);

                $product[] = [
                    "id" =>  $value1['sku'],
                    "product" => $value1['item_name'] . ' ' . $value1['variant_name'],
                    "price" =>  $value1['price'],
                    "quantity" =>  ( $value["receipt_type"] == "SALE" ) ? $value1['quantity'] : $value1['quantity']*-1, 
                    "discount" => $value1['total_discount'],
                    "vat" => "0%",
                    "before" => ( $value["receipt_type"] == "SALE" ) ? $value1['total_money'] : $value1['total_money']*-1,
                    "amount" => ( $value["receipt_type"] == "SALE" ) ? $value1['gross_total_money'] : $value1['gross_total_money']*-1,
                    "cost" => ""
                ];

            }
            // }

            // array_push($arr,$value["store_id"]);

            }

        }
        
        // echo "<pre>";
        // print_r($arr);
        // echo "</pre>";
        // return;

        //-- จัดเรียงสินค้า
        $sort_product = array_orderby($product, 'id', SORT_ASC, 'quantity', SORT_DESC );

         //-- เพิ่มเงื่อนไขรวมสินค้าที่ซ้ำกันซ้ำกัน
        $cursor = "__"; $i = 0;
        foreach($sort_product as $key2 => $item){
	        if($item["id"] != $cursor){
                $products[$key2]["id"] =  $item['id'];
                $products[$key2]["product"] = $item['product'];
                $products[$key2]["price"] =  $item['price'];
                $products[$key2]["quantity"] =  $item['quantity']; 
                $products[$key2]["discount"] = $item['discount'];
                $products[$key2]["vat"] = "0%";
                $products[$key2]["before"] = $item['before'];
                $products[$key2]["amount"] = $item['amount'];
                $products[$key2]["cost"] = "";
	            $cursor = $item["id"];
                $i = 0;
            }else{
                $i++;
    	        $products[$key2-$i]["quantity"] += $item["quantity"];
                $products[$key2-$i]["discount"] += $item['discount'];
                $products[$key2-$i]["before"] += $item['before'];
                $products[$key2-$i]["amount"] += $item['amount'];
            }
        }

        $data = array(
            "issue_date" => date('Y-m-d'),
            "due_date" => date('Y-m-d' ,strtotime("+30 days",strtotime(date('Y-m-d')))),
            "payment_term" => "",
            "company_format" => $company_format, //-- ช่องหัวเอกสาร 'IV'
            "type" => "API Loyverse [IV]",
            "document_number" => "", 
            "reference" =>  date('dmY'),
            "invoice_no" =>  $invoice_number, //-- ช่องเลขที่เอกสาร '2201001'
            "invoice_note" => "",
            "discount" => "",
            "tax" => 0,
            "total" => $total_money,
            "grand_total" => $total_money,
            "tax_option" => "in",
            "url" => "",
            "status" => "Debtor",
            "payment" => "",
            "wht" => 0,
            "tax_date" => date('Y-m-d'),
            "salesman" => $salesman,
            "department" => $department,
            "warehouse" => $warehouse,
            "project" => "",
            "bill" => "",
            "document_type" => "",
            "deposit_amount" => "",
            "anchor" => "auto",
            "latitude" > "",
            "longitude" => "",
            "approve_id" => "1",
            "approve_status" => "",
            "add_product" => "NO",
            "customer" => $customer,
            "product" => $products,
            "c1" => $c1,
            "c2" => $c2,
            "c3" => $c3,
            "c4" => $c4,
            "c5" => $c5,
            "c6" => $c6,
            "c7" => $c7,
            "c8" => $c8,
            "c9" => $c9,
            "dropbox" => [
                "https://www.dropbox.com/s/gqfqmwc3k5e4lsv/14761.png",
                "https://www.dropbox.com/s/gqfqmwc3k5e4lsv/14761.png"
            ]
        );
        
        
      
        
        
        $time                  = time();
        $hash                 = md5(ENCRYPT . "t" . $time);
        $data["company_id"] = COMPANY_ID;
        $data["passkey"]     = PASSKEY;
        $data["securekey"]     = $hash;
        $data["timestamp"]     = $time;
        $json                 = json_encode($data, JSON_UNESCAPED_UNICODE);
        $origin                = "https://loyverse.herokuapp.com/";
        $curl = curl_init();
        
            curl_setopt_array($curl, array(
            CURLOPT_URL => POSTNG_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "json={$json}",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded",
                "Origin: {$origin}"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
            $option = json_decode($response, true);
            line_notify($option);
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

    $data = json_decode($option["input"]["json"],true);

    //-- Line Notify Token :XGnsQNYg39M8EZ3r6ZN4sZYqtNmlN8eXmKpz391XzsJ -Mac Personal Line Notify
    $sToken = "v7acXZd2xKWwNSyxsW3YKsZZv15r6j38PlWEGxDfhos"; //-- นำ line notify token Bigwell group
	$sMessage = "มีรายการถูกนำเข้า....\n";
    $sMessage .= "แจ้งเตือน : ".$option["message"]."\n";

    //-- ถ้ายิง api เข้าจะแสดงผล ดังนี้
    if($option["success"] == 1){
        $sMessage .= "Document : ".$data["company_format"].$data["invoice_no"]."\n";
        $sMessage .= "Date : ".$data["issue_date"]."\n";
        $sMessage .= "Title : ".$data["customer"]["title"]."\n";
        $sMessage .= "Name : ".$data["customer"]["name"]."\n";
        $sMessage .= "Cash : ".$data["c1"]."\n";
        $sMessage .= "โอนเงิน : ".$data["c2"]."\n";
        $sMessage .= "D- Lineman : ".$data["c3"]."\n";
        $sMessage .= "D- Grabfood : ".$data["c4"]."\n";
        $sMessage .= "D- Robinhood : ".$data["c5"]."\n";
        $sMessage .= "D- Shopeefood : ".$data["c6"]."\n";
        $sMessage .= "D- Food Panda : ".$data["c7"]."\n";
        $sMessage .= "D- Truefood : ".$data["c8"]."\n";
        $sMessage .= "D- Airasia Food : ".$data["c9"]."\n";
        $sMessage .= "ยอดรวมสุทธิ :	".$data["grand_total"]."\n";
    }

	$chOne = curl_init(); 
	curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
	curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
	curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
	curl_setopt( $chOne, CURLOPT_POST, 1); 
	curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
	$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
	curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
	curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
	$result = curl_exec( $chOne ); 

	//-- Result error 
	if(curl_error($chOne)) 
	{ 
		echo 'error:' . curl_error($chOne); 
	} 
	else { 
		$result_ = json_decode($result, true); 
		echo "status : ".$result_['status']; echo "message : ". $result_['message'];
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
	curl_close( $chOne );   

}