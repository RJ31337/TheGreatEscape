<?php

include 'coins.php';
$highAlt = "ZEC";
$highPrice = 0;
$currentPos = count($coins);
$endCurrency = "gbp";
if (count($argv) == 0)
{
    echo "Invalid Arguments. Defaulting to GBP";
    $endCurrency = "gbp";
} else {
    $endCurrency = $argv[1];
}
$Markets = fopen('markets/'.$endCurrency.'-markets.txt', "w") or die("Unable to open file!");
foreach($coins as $coin) {
    $currentPos--;
    $price = file_get_contents('https://api.cryptonator.com/api/ticker/' . $coin . '-' . $endCurrency);
    $priceData = json_decode($price);
    if ($priceData->error != "") {
        usleep(20);
        continue;
    }
    echo $coin . " ";
    echo $currentPos . " Coins left to process" . PHP_EOL;
    flush();
    $txt =  '"'.$coin .'",\n';
    fwrite($Markets, $txt);
    
    $currentPrice = $priceData->ticker->price;
    if ($currentPrice > $highPrice)
    {
        $highAlt = $coin;
        $highPrice = $currentPrice;
    }
    usleep(20);
}

fclose($Markets);

echo "The Best Coin to " .$endCurrency . " is " . $highAlt . " and would earn " . $highPrice . $endCurrency  . " Per " . $highAlt;
$conversion = fopen('conversion.txt', "a") or die("Unable to open Conversion File!");
$nextStage = '"'.$highAlt.'"' . PHP_EOL;
fwrite($conversion, $nextStage);
fclose($conversion);
?>
