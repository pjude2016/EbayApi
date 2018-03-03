<?php
$endpoint = 'http://svcs.ebay.com/services/search/FindingService/v1';  // URL to call
$responseEncoding = 'XML';   // Format of the response


  // Construct the FindItems call
  $apicall = "https://api.ebay.com/buy/browse/v1/item_summary/search?q=phone";

  // . "&GLOBAL-ID=EBAY-GB"
  // . "&SECURITY-APPNAME=PiusJude-Ragnarok-PRD-c5d80d3bd-40178424" //replace with your app id
  // . "&RESPONSE-DATA-FORMAT=$responseEncoding";

       // . "&SERVICE-VERSION=1.0.0"

       //
       // . "&RESPONSE-DATA-FORMAT=$responseEncoding";

       $rest = simplexml_load_file($apicall) or die("Error: Please select the required filters");
       echo $rest->itemSummaries->price->value;
?>
