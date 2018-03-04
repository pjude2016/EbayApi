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
       echo "
       <br><br><br><br><br>
       <h3 align='center'Similar Items on Auction</h3>

       <table border='1' align='center'>
       <tr>
       <th>Image</th>
       <th>Title</th>
       <th>Price</th>
       <th>Service Cost</th>
       <th>ebayID</th>
       </tr>";
       foreach($rest->itemRecommendations->item as $item) {
            $id=$item->itemId;
            $title=$item->title;
            $price=$item->currentPrice;

            if ($item->imageURL) {
              $picURL = $item->imageURL;
            } else {
              $picURL = "http://pics.ebaystatic.com/aw/pics/express/icons/iconPlaceholder_96x96.gif";
            }
            $image = (string) $picURL;
            $link  = $item->viewItemURL;
            $servicecost=$item->shippingCost;
            echo "<tr>";

            echo "<td>" . "<a href=\"$link\"><img src=\"$picURL\"></a>" . "</td>";
            echo "<td>" . "<a href=\"$link\">$title</a>" . "</td>";
            echo "<td>" . $price . "</td>";
            echo "<td>" . $servicecost . "</td>";
            echo "<td>" . $id . "</td>";
            echo "</tr>";
        }
        echo "</table>";
?>
