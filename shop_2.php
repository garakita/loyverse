<?php



if (empty($value["cancelled_at"])) {


    $payments = $value['payments'];


    foreach ($payments as $pmtk => $pmtv) {



        if ($pmtv['name'] == 'Cash' || $pmtv['name'] == 'cash') {

            $c1_shop2 = ($value["receipt_type"] == "SALE") ? $c1_shop2 + $pmtv['money_amount'] : $c1_shop2 - $pmtv['money_amount'];
        }
        if ($pmtv['name'] == '1-โอนเงิน' || $pmtv['name'] == '1- โอนเงิน') {

            $c2_shop2 = ($value["receipt_type"] == "SALE") ? $c2_shop2 + $pmtv['money_amount'] : $c2_shop2 - $pmtv['money_amount'];
        }
        if ($pmtv['name'] == 'D-Line Man' || $pmtv['name'] == 'D- Line Man') {

            $c3_shop2 = ($value["receipt_type"] == "SALE") ? $c3_shop2 + $pmtv['money_amount'] : $c3_shop2 - $pmtv['money_amount'];
        }
        if ($pmtv['name'] == 'D-Grabfood' || $pmtv['name'] == 'D- Grabfood') {

            $c4_shop2 = ($value["receipt_type"] == "SALE") ? $c4_shop2 + $pmtv['money_amount'] : $c4_shop2 - $pmtv['money_amount'];
        }
        if ($pmtv['name'] == 'D-Robinhood' || $pmtv['name'] == 'D- Robinhood') {

            $c5_shop2 = ($value["receipt_type"] == "SALE") ? $c5_shop2 + $pmtv['money_amount'] : $c5_shop2 - $pmtv['money_amount'];
        }
        if ($pmtv['name'] == 'D-Shopeefood' || $pmtv['name'] == 'D- Shopeefood') {

            $c6_shop2 = ($value["receipt_type"] == "SALE") ? $c6_shop2 + $pmtv['money_amount'] : $c6_shop2 - $pmtv['money_amount'];
        }
        if ($pmtv['name'] == 'D-Food Panda' || $pmtv['name'] == 'D- Food Panda') {

            $c7_shop2 = ($value["receipt_type"] == "SALE") ? $c7_shop2 + $pmtv['money_amount'] : $c7_shop2 - $pmtv['money_amount'];
        }
        if ($pmtv['name'] == 'D-Truefood' || $pmtv['name'] == 'D- Truefood') {

            $c8_shop2 = ($value["receipt_type"] == "SALE") ? $c8_shop2 + $pmtv['money_amount'] : $c8_shop2 - $pmtv['money_amount'];
        }
        if ($pmtv['name'] == 'D-Airasia Food' || $pmtv['name'] == 'D- Airasia Food') {

            $c9_shop2 = ($value["receipt_type"] == "SALE") ? $c9_shop2 + $pmtv['money_amount'] : $c9_shop2 - $pmtv['money_amount'];
        }
    }
   

        $company_format_shop2 = "IV2";

        $salesman_shop2 = 'SP2-Sai4';
        $warehouse_shop2 = 'S2-Sai4';
        $department_shop2 = 'B2-Sai4';

        $customer_shop2 = [
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
    

    $lineItem = $value['line_items'];

    // if( $value["receipt_type"] == "SALE" ){
    foreach ($lineItem as $key1 => $value1) {

        $gross_total_money_shop2 = ($value["receipt_type"] == "SALE") ? $gross_total_money_shop2 + $value1['gross_total_money'] : $gross_total_money_shop2 - $value1['gross_total_money'];
        $total_money_shop2 = ($value["receipt_type"] == "SALE") ? $total_money_shop2 + $value1['total_money'] :  $total_money_shop2 - $value1['total_money'];
        $total_discount_shop2 = ($value["receipt_type"] == "SALE") ? $total_discount_shop2 + $value1['total_discount'] : $total_discount_shop2;

      
        $product_shop2[] = [
            "id" =>  $value1['sku'],
            "product" => $value1['item_name'] . ' ' . $value1['variant_name'],
            "price" =>  $value1['price'],
            "quantity" => ($value["receipt_type"] == "SALE") ? $value1['quantity'] : $value1['quantity'] * -1,
            "discount" => $value1['total_discount'],
            "vat" => "0%",
            "before" => ($value["receipt_type"] == "SALE") ? $value1['total_money'] : $value1['total_money'] * -1,
            "amount" => ($value["receipt_type"] == "SALE") ? $value1['gross_total_money'] : $value1['gross_total_money'] * -1,
            "cost" => ""
        ];
    }
    // }

    // array_push($arr,$value["store_id"]);

}
