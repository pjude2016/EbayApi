<?php
//$endpoint = 'http://svcs.ebay.com/services/search/FindingService/v1';  // URL to call
$responseEncoding = 'XML';   // Format of the response


  // Construct the getSimilarItems call
  $apicall = "http://svcs.ebay.com/MerchandisingService?OPERATION-NAME=getSimilarItems&SERVICE-NAME=MerchandisingService&SERVICE-VERSION=1.1.0&CONSUMER-ID=PiusJude-Ragnarok-PRD-c5d80d3bd-40178424&RESPONSE-DATA-FORMAT=XML"
   . "&REST-PAYLOAD"
   . "&itemId=391989027483"
   . "&maxResults=3"
   . "&listingType=Chinese";


       $rest = simplexml_load_file($apicall) or die("Error: Please select the required filters");
       echo "hello";
          foreach($rest->itemRecommendations->item as $item) {
            $id=$item->itemId;
            echo "id ";
            echo $id;
            echo "</br>";
          }

?>
