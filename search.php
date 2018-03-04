<?php
$endpoint = 'http://svcs.ebay.com/services/search/FindingService/v1';  // URL to call
$responseEncoding = 'XML';   // Format of the response


  // Construct the FindItems call
  $apicall = "https://api.ebay.com/buy/browse/v1/"
    . "&callname=item_summary/search?q=phone"
    . "&appid=PiusJude-Ragnarok-PRD-c5d80d3bd-40178424" //replace with your app id
    . "&responseencoding=$responseEncoding"
    . "&version=1.0.0";



       $rest = simplexml_load_file($apicall) or die("Error: Please select the required filters");
       echo $rest->itemSummaries->price->value;
?>
