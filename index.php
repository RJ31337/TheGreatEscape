<!doctype html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        
        <!-- Bootstrap Core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- MetisMenu CSS -->
        <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
        
        <!-- Morris Charts CSS -->
        <link href="vendor/morrisjs/morris.css" rel="stylesheet">
        
        <!-- Custom CS -->
        <link href="css/style.css" rel="stylesheet">
        
        <!-- Custom Fonts -->
        <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        
        <title>TheGreatEscape Dashboard</title>
        <meta http-equiv="refresh" content="60">
        <style>
            .coinmarketcap-currency-widget {
                width: 100%;
                float: left;
            }
        </style>
    </head>
    <body>
        <script type="text/javascript" src="https://files.coinmarketcap.com/static/widget/currency.js"></script>
        <div class="wrapper">
            <div class="row">
                <div class="col-lg-4"><div class="coinmarketcap-currency-widget" data-currency="zcash" data-base="GBP" data-secondary="" data-ticker="true" data-rank="true" data-marketcap="true" data-volume="true" data-stats="GBP" data-statsticker="true"></div></div>
                <div class="col-lg-4"><div class="coinmarketcap-currency-widget" data-currency="zcash" data-base="BTC" data-secondary="" data-ticker="true" data-rank="true" data-marketcap="true" data-volume="true" data-stats="BTC" data-statsticker="true"></div></div>
                <div class="col-lg-4"><div class="coinmarketcap-currency-widget" data-currency="bitcoin" data-base="GBP" data-secondary="" data-ticker="true" data-rank="true" data-marketcap="true" data-volume="true" data-stats="GBP" data-statsticker="true"></div></div>
            </div>
            <div class="row">
                <div class="col-lg-4"></div>
                <div class="col-lg-4 shrink">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Price Chart
                        </div>
                        <!-- /.panel-heading -->
                        
                        <div class="panel-body">
                            <div class="price-chart">
                                <script type="text/javascript">
                                    baseUrl = "https://widgets.cryptocompare.com/";
                                    var scripts = document.getElementsByTagName("script");
                                    var embedder = scripts[ scripts.length - 1 ];
                                    (function (){
                                        var appName = encodeURIComponent(window.location.hostname);
                                        if(appName==""){appName="local";}
                                        var s = document.createElement("script");
                                        s.type = "text/javascript";
                                        s.async = true;
                                        var theUrl = baseUrl+'serve/v1/coin/header?fsym=ZEC&tsyms=GBP';
                                        s.src = theUrl + ( theUrl.indexOf("?") >= 0 ? "&" : "?") + "app=" + appName;
                                        embedder.parentNode.appendChild(s);
                                    })();
                                </script>
                                
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>
                <div class="col-lg-4"></div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-fw"></i> Worker Monitor
                        </div>
                        <!-- /.panel-heading -->
                        
                        <div class="panel-body">
                            <?php
                            
                            // Retrieve Values from Flypool
                            $json = file_get_contents('https://api-zcash.flypool.org/miner/t1TJuhtk9dcj5MBmygSJ58eYKcdjyxbTTEc/workers/monitor');
                            
                            // Parse the JSON
                            $data = json_decode($json, true); 
                            ?>
                            
                            <table style="width:100%">
                                <tr>
                                    <th>Worker</th>
                                    <th>Current Hashrate</th>
                                    <th>Valid Shares</th>
                                    <th>Invalid Shares</th>
                                </tr>
                                <?php
                                $totalHashes = (float) 0.0;
                                
                                foreach($data['data'] as $workers){
                                    echo '<tr>';
                                    echo '<td>'.$workers['worker'].'</td>';
                                    echo '<td>'.$workers['currentHashrate'].'</td>';
                                    $totalHashes = $totalHashes + (float) $workers['currentHashrate'];
                                    echo '<td>'.$workers['validShares'].'</td>';
                                    echo '<td>'.$workers['invalidShares'].'</td>';
                                    echo '</tr>';
                                }
                                echo '</table>';
                                echo 'Total Hashrate = ' .number_format((float)$totalHashes, 2, '.', '');
                                ?>
                        </div>    
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12"> <!-- start feedwind code --> <script type="text/javascript" src="https://feed.mikle.com/js/fw-loader.js" data-fw-param="61037/"></script> <!-- end feedwind code --> </div>    
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-fw"></i> Wallet Monitor
                        </div>
                        <!-- /.panel-heading -->
                        
                        <div class="panel-body">
                            <table style="width:100%">
                                <tr>
                                    <th>Cleared Balance</th>
                                    <th>Total Spent</th>
                                    <th>Total Received</th>
                                    <th>Hardware Budget</th>
                                    <th>Neil's Balance</th>
                                    <th>Jackie's Balance</th>
                                    <th>Dean's Balance</th>
                                    <th>Dave's Balance</th>
                                </tr>
                            <?php
                            
                            // Retrieve Values from ZChain
                            $json = file_get_contents('https://api.zcha.in/v2/mainnet/accounts/t1TJuhtk9dcj5MBmygSJ58eYKcdjyxbTTEc');
                            $json2 = file_get_contents('https://api.zcha.in/v2/mainnet/accounts/t1TJuhtk9dcj5MBmygSJ58eYKcdjyxbTTEc');    
                            $json3 = file_get_contents('https://api.zcha.in/v2/mainnet/accounts/t1TJuhtk9dcj5MBmygSJ58eYKcdjyxbTTEc');
                            $json4 = file_get_contents('https://api.zcha.in/v2/mainnet/accounts/t1TJuhtk9dcj5MBmygSJ58eYKcdjyxbTTEc');
                            $json5 = file_get_contents('https://api.zcha.in/v2/mainnet/accounts/t1TJuhtk9dcj5MBmygSJ58eYKcdjyxbTTEc');
                            $json6 = file_get_contents('https://api.zcha.in/v2/mainnet/accounts/t1TJuhtk9dcj5MBmygSJ58eYKcdjyxbTTEc');
                                
                            // And the exchange rate from Cryptonator
                            $price = file_get_contents('https://api.cryptonator.com/api/ticker/zec-gbp');
                            
                            // Parse the JSON
                            $data = json_decode($json);
                            $float = json_decode($json2);
                            $neil = json_decode($json3);
                            $jackie = json_decode($json4);
                            $dean = json_decode($json5);
                            $dave = json_decode($json6);
                            $priceData = json_decode($price);
                            
                            //Display the data
                            echo '<tr>';
                            echo '<td>' . $data->balance . '</td>';
                            $total = (float) $data->balance;
                            echo '<td>' . $data->totalSent . '</td>';
                            echo '<td>' . $data->totalRecv . '</td>';
                            echo '<td>' . $float->balance . '</td>';
                            //echo '<td>' . $neil->balance . '</td>';
                            echo '<td>0</td>';
                            //echo '<td>' . $jackie->balance . '</td>';
                            echo '<td>0</td>';
                            //echo '<td>' . $dean->balance . '</td>';
                            echo '<td>0</td>';
                            //echo '<td>' . $dave->balance . '</td>';
                            echo '<td>0</td>';
                            echo '</tr>';
                            echo '</table>';
                            $currentPrice = $priceData->ticker->price;
                            $calcTarget = 1 / $currentPrice;
                            $target = 52.07 * $calcTarget;
                            $pos1 = $total / $target;
                            $pos2 = $pos1 * 100;
                            $currentPos = number_format($pos2, 0);
                            echo '<h1 class="announce">We are currently at ' . $currentPos . '% of our monthly target</h1>'
                            ?>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
        <!-- jQuery -->
        <script src="vendor/jquery/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="dist/js/sb-admin-2.js"></script>
        
    </body>
</html>