<?php


//-- จัดเรียงสินค้า
$sort_product = array_orderby($product, 'id', SORT_ASC, 'quantity', SORT_DESC);

//-- เพิ่มเงื่อนไขรวมสินค้าที่ซ้ำกันซ้ำกัน
$cursor = "__";
$i = 0;
foreach ($sort_product as $key2 => $item) {
    if ($item["id"] != $cursor) {
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
    } else {
        $i++;
        $products[$key2 - $i]["quantity"] += $item["quantity"];
        $products[$key2 - $i]["discount"] += $item['discount'];
        $products[$key2 - $i]["before"] += $item['before'];
        $products[$key2 - $i]["amount"] += $item['amount'];
    }
}


$data = array(
    "issue_date" => date('Y-m-d'),
    "due_date" => date('Y-m-d', strtotime("+30 days", strtotime(date('Y-m-d')))),
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
