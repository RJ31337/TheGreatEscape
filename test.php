<?php

$price = file_get_contents('https://api.cryptonator.com/api/ticker/BTC-gbp');
    $priceData = json_decode($price);
    if ($priceData->error != "") {
        echo "error";
    } else {
        echo "No error found";
    }

?>