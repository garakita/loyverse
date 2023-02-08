<?php


//-- จัดเรียงสินค้า
$sort_product_shop2 = array_orderby($product_shop2, 'id', SORT_ASC, 'quantity', SORT_DESC);

//-- เพิ่มเงื่อนไขรวมสินค้าที่ซ้ำกันซ้ำกัน
$cursor_2 = "__";
$i2 = 0;
foreach ($sort_product_shop2 as $key2 => $item) {
    if ($item["id"] != $cursor_2) {
        $products_shop22[$key2]["id"] =  $item['id'];
        $products_shop22[$key2]["product"] = $item['product'];
        $products_shop22[$key2]["price"] =  $item['price'];
        $products_shop22[$key2]["quantity"] =  $item['quantity'];
        $products_shop22[$key2]["discount"] = $item['discount'];
        $products_shop22[$key2]["vat"] = "0%";
        $products_shop22[$key2]["before"] = $item['before'];
        $products_shop22[$key2]["amount"] = $item['amount'];
        $products_shop22[$key2]["cost"] = "";
        $cursor_2 = $item["id"];
        $i2 = 0;
    } else {
        $i2++;
        $products_shop22[$key2 - $i2]["quantity"] += $item["quantity"];
        $products_shop22[$key2 - $i2]["discount"] += $item['discount'];
        $products_shop22[$key2 - $i2]["before"] += $item['before'];
        $products_shop22[$key2 - $i2]["amount"] += $item['amount'];
    }
}



$data_shop2 = array(
    "issue_date" => date('Y-m-03'),
    "due_date" => date('Y-m-d', strtotime("+30 days", strtotime(date('Y-m-d')))),
    "payment_term" => "",
    "company_format" => $company_format_shop2, //-- ช่องหัวเอกสาร 'IV'
    "type" => "API Loyverse [IV]",
    "document_number" => "",
    "reference" =>  date('dmY'),
    //"invoice_no" =>  $invoice_number_shop2, //-- ช่องเลขที่เอกสาร '2201001'
    "invoice_no" =>  1230201002,
    "invoice_note" => "",
    "discount" => "",
    "tax" => 0,
    "total" => $total_money_shop2,
    "grand_total" => $total_money_shop2,
    "tax_option" => "in",
    "url" => "",
    "status" => "Debtor",
    "payment" => "",
    "wht" => 0,
    "tax_date" => date('Y-m-d'),
    "salesman" => $salesman_shop2,
    "department" => $department_shop2,
    "warehouse" => $warehouse_shop2,
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
    "customer" => $customer_shop2,
    "product" => $products_shop22,
    "c1" => $c1_shop2,
    "c2" => $c2_shop2,
    "c3" => $c3_shop2,
    "c4" => $c4_shop2,
    "c5" => $c5_shop2,
    "c6" => $c6_shop2,
    "c7" => $c7_shop2,
    "c8" => $c8_shop2,
    "c9" => $c9_shop2,
    "dropbox" => [
        "https://www.dropbox.com/s/gqfqmwc3k5e4lsv/14761.png",
        "https://www.dropbox.com/s/gqfqmwc3k5e4lsv/14761.png"
    ]
);





$time                  = time();
$hash                 = md5(ENCRYPT . "t" . $time);
$data_shop2["company_id"] = COMPANY_ID;
$data_shop2["passkey"]     = PASSKEY;
$data_shop2["securekey"]     = $hash;
$data_shop2["timestamp"]     = $time;
$json_shop2                 = json_encode($data_shop2, JSON_UNESCAPED_UNICODE);
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
    CURLOPT_POSTFIELDS => "json={$json_shop2}",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/x-www-form-urlencoded",
        "Origin: {$origin}"
    ),
));

$response_shop2 = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response_shop2;
    $option = json_decode($response_shop2, true);
    line_notify($option);
}
