<?php
//$endpoint = 'http://svcs.ebay.com/services/search/FindingService/v1';  // URL to call
$responseEncoding = 'XML';   // Format of the response


  // Construct the FindItems call
  $apicall = "http://open.api.ebay.com/shopping?callname=GetSingleItem&responseencoding=JSON&appid=PiusJude-Ragnarok-PRD-c5d80d3bd-40178424&version=967&ItemId=273084369154";


       $rest = simplexml_load_file($apicall) or die("Error: Please select the required filters");
       echo "hello";
       echo $rest->Item->Seller->FeedbackScore;
       echo $rest->Item->Seller->PositiveFeedbackPercent;
?>
