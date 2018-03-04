<?php
//$endpoint = 'http://svcs.ebay.com/services/search/FindingService/v1';  // URL to call
$responseEncoding = 'XML';   // Format of the response


  // Construct the FindItems call
  $apicall = "http://open.api.ebay.com/shopping?callname=GetSingleItem&responseencoding=XML&appid=PiusJude-Ragnarok-PRD-c5d80d3bd-40178424&version=967&ItemId=391989027483";


       $rest = simplexml_load_file($apicall) or die("Error: Please select the required filters");
       echo "hello";
       echo $rest->Item->ItemID;
       echo "</br>";
       echo "FeedbackScore ";
       $fb=sprintf("%01.2f", $rest->Item->Seller->FeedbackScore);
       echo $fb;
       echo "</br>";
       echo "Postive FeedbackScore percent ";
       $fbs=sprintf("%01.2f", $rest->Item->Seller->PositiveFeedbackPercent);

       echo $fbs;
?>
