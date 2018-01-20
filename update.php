<?php

include 'coins.php';
$badMarkets = fopen("nomarket.txt", "w") or die("Unable to open file!");
$highAlt = "ZEC";
$highPrice = 0;
$currentPos = 733;
$endCurrency = "gbp";
if (count($argv) == 0)
{
    echo "Invalid Arguments. Defaulting to GBP";
    $endCurrency = "gbp";
} else {
    $endCurrency = $argv[1];
}

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
    fwrite($badMarkets, $txt);
    
    $currentPrice = $priceData->ticker->price;
    if ($currentPrice > $highPrice)
    {
        $highAlt = $coin;
        $highPrice = $currentPrice;
    }
    usleep(20);
}

fclose($badMarkets);

echo "The Best Coin to GBP is " . $highAlt . "and would earn £" . $highPrice ." Per " . $highAlt;

?>