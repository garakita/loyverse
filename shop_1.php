<?php



if (empty($value["cancelled_at"])) {


    $payments = $value['payments'];


    foreach ($payments as $pmtk => $pmtv) {



        if ($pmtv['name'] == 'Cash' || $pmtv['name'] == 'cash') {

            $c1 = ($value["receipt_type"] == "SALE") ? $c1 + $pmtv['money_amount'] : $c1 - $pmtv['money_amount'];
        }
        if ($pmtv['name'] == '1-โอนเงิน' || $pmtv['name'] == '1- โอนเงิน') {

            $c2 = ($value["receipt_type"] == "SALE") ? $c2 + $pmtv['money_amount'] : $c2 - $pmtv['money_amount'];
        }
        if ($pmtv['name'] == 'D-Line Man' || $pmtv['name'] == 'D- Line Man') {

            $c3 = ($value["receipt_type"] == "SALE") ? $c3 + $pmtv['money_amount'] : $c3 - $pmtv['money_amount'];
        }
        if ($pmtv['name'] == 'D-Grabfood' || $pmtv['name'] == 'D- Grabfood') {

            $c4 = ($value["receipt_type"] == "SALE") ? $c4 + $pmtv['money_amount'] : $c4 - $pmtv['money_amount'];
        }
        if ($pmtv['name'] == 'D-Robinhood' || $pmtv['name'] == 'D- Robinhood') {

            $c5 = ($value["receipt_type"] == "SALE") ? $c5 + $pmtv['money_amount'] : $c5 - $pmtv['money_amount'];
        }
        if ($pmtv['name'] == 'D-Shopeefood' || $pmtv['name'] == 'D- Shopeefood') {

            $c6 = ($value["receipt_type"] == "SALE") ? $c6 + $pmtv['money_amount'] : $c6 - $pmtv['money_amount'];
        }
        if ($pmtv['name'] == 'D-Food Panda' || $pmtv['name'] == 'D- Food Panda') {

            $c7 = ($value["receipt_type"] == "SALE") ? $c7 + $pmtv['money_amount'] : $c7 - $pmtv['money_amount'];
        }
        if ($pmtv['name'] == 'D-Truefood' || $pmtv['name'] == 'D- Truefood') {

            $c8 = ($value["receipt_type"] == "SALE") ? $c8 + $pmtv['money_amount'] : $c8 - $pmtv['money_amount'];
        }
        if ($pmtv['name'] == 'D-Airasia Food' || $pmtv['name'] == 'D- Airasia Food') {

            $c9 = ($value["receipt_type"] == "SALE") ? $c9 + $pmtv['money_amount'] : $c9 - $pmtv['money_amount'];
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
    } else {

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

        $gross_total_money = ($value["receipt_type"] == "SALE") ? $gross_total_money + $value1['gross_total_money'] : $gross_total_money - $value1['gross_total_money'];
        $total_money = ($value["receipt_type"] == "SALE") ? $total_money + $value1['total_money'] :  $total_money - $value1['total_money'];
        $total_discount = ($value["receipt_type"] == "SALE") ? $total_discount + $value1['total_discount'] : $total_discount;

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
