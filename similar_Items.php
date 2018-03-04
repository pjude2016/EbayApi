<?php
session_start();
$_SESSION['message'] = '';
$connectionInfo = array("UID" => "auctora@auctora-server", "pwd" => "arotcua1!", "Database" => "auctoraDB");
$serverName = "tcp:auctora-server.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);
$my_array=array();



//$endpoint = 'http://svcs.ebay.com/services/search/FindingService/v1';  // URL to call
$responseEncoding = 'XML';   // Format of the response
$ebayItemId = $_POST['ebayID'];

  // Construct the getSimilarItems call
  $apicall = "http://svcs.ebay.com/MerchandisingService?OPERATION-NAME=getSimilarItems&SERVICE-NAME=MerchandisingService&SERVICE-VERSION=1.1.0&CONSUMER-ID=PiusJude-Ragnarok-PRD-c5d80d3bd-40178424&RESPONSE-DATA-FORMAT=XML"
   . "&REST-PAYLOAD"
   . "&itemId=$ebayItemId"
 //. "&itemId=202239352926"
   . "&maxResults=5"
   . "&listingType=Chinese";
    $rest = simplexml_load_file($apicall) or die("Error: Please select the required filters");
       echo "
       <br><br><br><br><br>
       <h3 align='center'> Similar Items on Auction</h3>
       <br><br>
       <h5 align='center'>Items Currently not supported in our Database</h5>
       <p align='center' style=\"color:red;\">*Please view the product on eBay for more details</p>
       <table border='1' align='center'>
       <tr>
       <th>Image</th>
       <th>Title</th>
       <th>Price</th>
       <th>Service Cost</th>
       <th>ebayID</th>
       <th></th>
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


            $query = "SELECT * FROM auction.product_searches WHERE ebayID = '$id'";
            $getMatches= sqlsrv_query($conn, $query);

            $row = sqlsrv_fetch_array($getMatches, SQLSRV_FETCH_ASSOC);
            $viewcount =1;
            //check for duplication
            //$status_on_ebay = 'active';
            if(!$row){
              //echo "Needs to be added";
              $count=0;
              echo "<tr>";
              echo "<td>" . "<a href=\"$link\"><img src=\"$picURL\"></a>" . "</td>";
              echo "<td>" . "<a href=\"$link\">$title</a>" . " <span class=\"note\" style=\"color:red;\"> * </span>" . "</td>";
              echo "<td>" . $price . "</td>";
              echo "<td>" . $servicecost . "</td>";
              echo "<td>" . $id . "</td>";
              echo "<td>";
              echo "<form action=\"$link\"> <button type=\"submit\" class=\"btn btn-success\" name=\"ebayID\" value=\"ebayidval\" >Go to eBay</button></form>";
              echo "</td>";
              echo "</tr>";
            }


            else{
                //echo "Already added";
                $count=1;
                //update view count.

                array_push($my_array,$id);
            }


        }
        echo "</table>";
        echo "<br><br>";
        $arrlength = count($my_array);
        if($arrlength>0){
            echo "<h5 align='center'>View, Bid and Review other related Items on Auction</h5>
            <table border='1' align='center'>
            <tr>
            <th>Image</th>
            <th>Title</th>
            <th>Details</th>
            <th>Price</th>
            <th>ebayID</th>
            <th>Review/ Place Bid</th>
            <th>Similar Items on Auction</th>
            <th></th>
            </tr>";
            for($x = 0; $x < $arrlength; $x++) {
                //echo $my_array[$x];
                //implement bidding, review and watchlist.
                $temp=$my_array[$x];
                $query = "SELECT * FROM auction.product_searches WHERE ebayID ='$temp'";
                $getMatches= sqlsrv_query($conn, $query);

                $row = sqlsrv_fetch_array($getMatches, SQLSRV_FETCH_ASSOC);
                //$count = $row['view_count'];
                //$prod_id = $row['ID'];
                $product_link=$row['product_link'];
                $img_src=$row['image'];
                $title=$row['title'];
                $ebayId=$row['ebayID'];
                $gender=$row['gender'];
                $condition=$row['condition'];
                $display=$row['display'];
                $brand=$row['brand'];

                //echo "<br><br>";
                echo "<tr>";

                echo "<td>" . "<a href=\"$product_link\"><img src=\"$img_src\"></a>" . "</td>";
                echo "<td>" . "<a href=\"$product_link\" target=\"_blank\">$title</a>" . "</td>";
                echo "<td align='center'>";
                echo "Gender: " . $gender;
                echo "</br>";
                echo "Condition: " . $condition;
                echo "</br>";
                echo "Display: " . $display;
                echo "</br>";
                echo "Brand: " . $brand;
                echo "</td>";
                echo "<td align='center'>" . $row['price'] . "</td>";

                echo "<td align='center'>" . $ebayId. "</td>";
                echo "<td>" ;
              //  echo " <form method=\"POST\" action=\"review.php\" >  <button type=\"submit\" class=\"btn btn-primary\" name=\"ebayID\" value=\"$ebayidval\" >Add Your Review</button></form>";
              //  echo "<form method=\"POST\" action=\"review_show.php\">  <button type=\"submit\" class=\"btn btn-warning\" name=\"ebayIDShow\" value=\"$ebayidval\" >Show all Reviews</button></form>";
              //  echo " <form method=\"POST\" action=\"bid.php\">  <button type=\"submit\" class=\"btn btn-success\" name=\"ebayID\" value=\"$ebayidval\" >Place bid</button></form>";

                echo "</td>";
                echo "<td>";
              //  echo "<form method=\"POST\" action=\"similar_Items.php\" >  <button type=\"submit\" class=\"btn btn-primary\" name=\"ebayID\" value=\"$ebayidval\" >View Similar Items on Auction</button></form>";
                echo "</td>";;
                echo "</tr>";
              }
              echo "</table>";
        }
        echo "<br><br><br>";
?>





<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Scrolling Nav - Start Bootstrap Template</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/scrolling-nav.css" rel="stylesheet">

  </head>

  <body id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">A U C T O R A</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="ml.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="my_watches.php">My Watches</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="watchlist.php">My Watchlist</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="products.php">Products</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="logout.php">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

<!-- <section>
Welcome HERREE <span class="user"><?= $_SESSION['firstname'] ?></span>
</section> -->



    <!-- Footer -->


    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom JavaScript for this theme -->
    <script src="js/scrolling-nav.js"></script>

  </body>

</html>
