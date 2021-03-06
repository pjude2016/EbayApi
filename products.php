<?php
session_start();
$_SESSION['message'] = '';
$connectionInfo = array("UID" => "auctora@auctora-server", "pwd" => "arotcua1!", "Database" => "auctoraDB");
$serverName = "tcp:auctora-server.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);
$value=1;
$_SESSION['reviewBool'] = $value;

// echo $_SESSION;

// echo '<pre>';
// var_dump($_SESSION);
// echo '</pre>';


//Establishes the connection



if ($_SERVER["REQUEST_METHOD"] == "POST") {

// $my_ebay_id = $_POST['add_to_watchlist'];
  // echo "THIS" . $_POST['add_to_watchlist'];
  if (isset($_POST['add_to_watchlist'])){
    // echo "WE ARE IN NOW";
    $my_ebay_id = $_POST['add_to_watchlist'];

    $query = "SELECT * FROM auction.product_searches WHERE ebayID = '$my_ebay_id'";
    $getMatches= sqlsrv_query($conn, $query);
    $row = sqlsrv_fetch_array($getMatches, SQLSRV_FETCH_ASSOC);
    $product_id = $row['ID'];


    $query = "SELECT * FROM auction.product_searches WHERE ebayID = '$my_ebay_id'";
    $getMatches= sqlsrv_query($conn, $query);
    $row = sqlsrv_fetch_array($getMatches, SQLSRV_FETCH_ASSOC);

    $current_uid = $_SESSION['userID'];
    $query_to_avoid_watchlist_duplication = "SELECT * FROM auction.watch_list WHERE ebayID = '$product_id' AND user_id = '$current_uid'";
    $getMatches2= sqlsrv_query($conn, $query_to_avoid_watchlist_duplication);
    $row_2 = sqlsrv_fetch_array($getMatches2, SQLSRV_FETCH_ASSOC);


    if($row and !$row_2){
      // $_SESSION['logged_in'] = true;
      // echo "WE ARE IN";

      $tsql= "INSERT INTO auction.watch_list (ebayID, user_id) VALUES (?,?);";
      $params = array($product_id, $_SESSION['userID']);
      $getResults= sqlsrv_query($conn, $tsql, $params);
      $rowsAffected = sqlsrv_rows_affected($getResults);
      if ($getResults == FALSE or $rowsAffected == FALSE)
          die(FormatErrors(sqlsrv_errors()));

      // exit;



    }




  }

}
?>

<!--
<html>
<nav class="navbar navbar-expand-sm bg-light navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item active">
      <a class="nav-link" href="#">Active</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Link</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Link</a>
    </li>
    <li class="nav-item">
      <a class="nav-link disabled" href="#">Disabled</a>
    </li>
  </ul>
</nav>

<div class="body content">
    <div class="welcome">
        <div class="alert alert-success"><?= $_SESSION['message'] ?></div>
        Welcome <span class="user"><?= $_SESSION['username'] ?></span>


    </div>
</div>

</html>
 -->


<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Filter Search for Watches</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/scrolling-nav.css" rel="stylesheet">



    <link href="../../twitter-bootstrap/twitter-bootstrap-v2/docs/assets/css/bootstrap.css" rel="stylesheet">
<script src="./js/jQuery.js"></script>
<script src="./js/jQueryUI/ui.tablesorter.js"></script>

<script>
  $(document).ready(function() {
    $("table").tablesorter({
      sortList:[[0,0]],    // upon screen load, sort by col 7, 4 ascending (0)
      debug: false,        // if true, useful to debug Tablesorter issues
      headers: {
        1: { sorter: false },  // col 0 = first = left most column - no sorting
        7: { sorter: false },
        9: { sorter: false }
      }
    });
  });

  var countDown = function(id , date){
  var countDownDate = new Date(date).getTime();
     // Update the count down every 1 second
  var x = setInterval(function() {

    // Get todays date and time
    var now = new Date().getTime();

    // Find the distance between now an the count down date
    var distance = countDownDate - now;

    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Display the result in the element with id="demo"
    document.getElementById(id).innerHTML = days + " days " + hours + " hours "
    + minutes + " minutes " + seconds + " seconds ";

    // If the count down is finished, write some text
    if (distance < 0) {
      clearInterval(x);
      document.getElementById(id).innerHTML = "EXPIRED";
    }
  }, 1000);
 };
</script>





  </head>

  <body id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#">A U C T O R A</a>
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



<link rel="stylesheet" href="./css/flora.all.css" type="text/css" media="screen" title="Flora (Default)">
<?php
$Query = $_POST["Query"];
//$GlobalID = $_POST["GlobalID"];
// $BuyingFormat = $_POST["BuyingFormat"];
$Display = $_POST["Display"];
$Condition = $_POST["Condition"];
$Gender = $_POST["Gender"];
//$Year_Manu = $_POST["Year_Manu"];
?>

<br>
<br>
<br>
<h1 align='center'>eBay Watch Search form</h1>
<p align='center'> Select filters below to search for watches available on Auction. The result will be split into low, mid and high range products according to the pricing preference you select. </p>
<h4 style="color:red;" align='center'><span class="note">*</span> All filter options must be selected.</h4>
<form action="products.php" method="post">

<table cellpadding="2" border="0" align="center">
  <tr>
    <th class="text-center" width="(100/6)%">Shop by Brand <span class="note" style="color:red;">*</span></th>
    <!-- <th>Country <span class="note" style="color:red;">*</span></th> -->
    <!-- <th>Buying Format <span class="note" style="color:red;">*</span></th> -->
    <th class="text-center" width="(100/6)%">Min Price <span class="note" style="color:red;">*</span></th>
    <th class="text-center" width="(100/6)%">Max Price <span class="note" style="color:red;">*</span></th>
    <th class="text-center" width="(100/6)%">Display <span class="note" style="color:red;">*</span></th>
    <th class="text-center" width="(100/6)%">Condition <span class="note" style="color:red;">*</span></th>
    <th class="text-center" width="(100/6)%">Gender <span class="note" style="color:red;">*</span></th>
  </tr>
  <tr>

    <td align="center" width="(100/6)%">
    <select name="Query">
      <option value="Casio" <?php if (isset($Query) && $Query=="Casio") echo "selected";?>>Casio</option>
      <option value="Rolex" <?php if (isset($Query) && $Query=="Rolex") echo "selected";?>>Rolex</option>
      <option value="Seiko" <?php if (isset($Query) && $Query=="Seiko") echo "selected";?>>Seiko</option>
      </select>
    </td>


    <td align="center" width="(100/6)%"><input type="text" name="MinPrice" value="<?php if (isset($_POST['MinPrice'])) echo $_POST['MinPrice']; ?>"></td>
    <td align="center" width="(100/6)%"><input type="text" name="MaxPrice" value="<?php if (isset($_POST['MaxPrice'])) echo $_POST['MaxPrice']; ?>"></td>
    <td align="center" width="(100/6)%"> <select name="Display">

          <option value="Analog" <?php if (isset($Display) && $Display=="Analog") echo "selected";?>>Analog</option>
          <option value="Digital" <?php if (isset($Display) && $Display=="Digital") echo "selected";?>>Digital</option>
          <option value="Analog & Digital" <?php if (isset($Display) && $Display=="Analog & Digital") echo "selected";?>>Analog & Digital</option>
    </select></td>
    <td align="center" width="(100/6)%"> <select name="Condition">
          <option value="New" <?php if (isset($Condition) && $Condition=="New") echo "selected";?>>New</option>
          <option value="Used" <?php if (isset($Condition) && $Condition=="Used") echo "selected";?>>Used</option>
    </select></td>
    <td align="center" width="(100/6)%"> <select name="Gender">
          <option value="Men's" <?php if (isset($Gender) && $Gender=="Men's") echo "selected";?>>Men's</option>
          <option value="Women's" <?php if (isset($Gender) && $Gender=="Women's") echo "selected";?>>Women's</option>
          <option value="Unisex" <?php if (isset($Gender) && $Gender=="Unisex") echo "selected";?>>Unisex </option>
          <option value="Children" <?php if (isset($Gender) && $Gender=="Children") echo "selected";?>>Children</option>
    </select></td>
  </tr>
  <tr>


  </tr>
</table>


    <p align="center"> <INPUT type="submit" name="submit" value="Search" ></p>

</form>


<?php

require_once('DisplayUtils.php');  // functions to aid with display of information
error_reporting(E_ALL);  // turn on all errors, warnings and notices for easier debugging

//$results = '';

//checking for non-empty and non-negative integer


if(isset($_POST['Query']))
{
  $endpoint = 'http://svcs.ebay.com/services/search/FindingService/v1';  // URL to call
  $responseEncoding = 'XML';   // Format of the response

  $safeQuery = urlencode (utf8_encode($_POST['Query']));
  $brand = $_POST['Query'];
  $brand1 = (string)$brand;

  //$site  = $_POST['GlobalID'];
  //$format  = $_POST['BuyingFormat'];
  $disp  = $_POST['Display'];
  $cond  = $_POST['Condition'];
  $gend  = $_POST['Gender'];
  //$year  = $_POST['Year_Manu'];
  $priceRangeMin = $_POST['MinPrice'];
  $priceRangeMax = $_POST['MaxPrice'];
  $min = $_POST['MinPrice'];
  $max = $_POST['MaxPrice'];
  $result_returned=0;
  if(!($max>0) || !($min>=0) ||!($max>$min) ) {
    $rest2 = die("Error: Please input valid price");
}
  /*$query2 = "SELECT * FROM auction.filters WHERE brand = '$brand' AND min_price = '$min' AND max_price = '$max' AND display ='$disp' AND condition = '$cond' AND gender = '$gend' AND year_manufacture = '$year' "

  $getMatchesB= sqlsrv_query($conn, $queryB);

  $rowB = sqlsrv_fetch_array($getMatchesB, SQLSRV_FETCH_ASSOC);
  if(!$rowB){*/





  $results .= 'Click <a href="#Low-Range">here</a> to see Low-Range.'. "<br />\n";
  $results .= 'Click <a href="#Mid-Range">here</a> to see Mid-Range.'. "<br />\n";
  $results .= 'Click <a href="#High-Range">here</a> to see High-Range.'. "<br />\n";



  $itemsPerRange = 100;
  $pageNumber=1; //0-100

  // $debug = (boolean) $_POST['Debug'];

  $rangeArr = array('Low-Range', 'Mid-Range', 'High-Range');

  $priceRange = ($priceRangeMax - $priceRangeMin) / 3;  // find price ranges for three tables
  $priceRangeMin =  sprintf("%01.2f",$priceRangeMin );
  $priceRangeMax = $priceRangeMin;  // needed for initial setup
  $ident = 1;
  foreach ($rangeArr as $range)
  {
    $priceRangeMax = sprintf("%01.2f", ($priceRangeMin + $priceRange));
    if($range =='Low-Range'){
        $results .='<a name="Low-Range"></a> '. "<br />\n";
      }
    else if($range =='Mid-Range'){
        $results .='<a name="Mid-Range"></a> '. "<br />\n";
  }
  else if ($range =='High-Range'){
    $results .='<a name="High-Range"></a> '. "<br />\n";
    //$results .= '<a href="https://www.w3schools.com">Visit W3Schools</a>'. "<br />\n";
  }

    $results .=  "<h2>$range : $priceRangeMin ~ $priceRangeMax</h2>\n";
    // Construct the FindItems call
    $apicall = "$endpoint?OPERATION-NAME=findItemsAdvanced"
         . "&SERVICE-VERSION=1.0.0"
         . "&GLOBAL-ID=EBAY-GB"
         . "&SECURITY-APPNAME=PiusJude-Ragnarok-PRD-c5d80d3bd-40178424" //replace with your app id
         . "&keywords=$safeQuery"
         . "&paginationInput.entriesPerPage=$itemsPerRange"
         //. "&paginationInput.pageNumber=$pageNumber"
         . "&sortOrder=BestMatch"
         . "&itemFilter(0).name=ListingType"
         . "&itemFilter(0).value=Auction"
         // . "&itemFilter(0).value(1)=AuctionWithBIN"
         . "&itemFilter(1).name=MinPrice"
         . "&itemFilter(1).value=$priceRangeMin"
         . "&itemFilter(2).name=MaxPrice"
         . "&itemFilter(2).value=$priceRangeMax"
         . "&itemFilter(3).name=Condition"
         . "&itemFilter(3).value=$cond"


         . "&aspectFilter(0).aspectName=Display"
        // . "&aspectFilter(0).aspectValueName=Analog"
         . "&aspectFilter(0).aspectValueName=$disp"
         . "&aspectFilter(1).aspectName=Gender"
         . "&aspectFilter(1).aspectValueName=$gend"
         // . "&aspectFilter(2).aspectName=Year of Manufacture"
         // . "&aspectFilter(2).aspectValueName=$year"

        // . "&aspectFilter(1).aspectName=Brand"
        // . "&aspectFilter(1).aspectValueName=$company"
        // . "&aspectFilter(2).aspectName=Condition"
        // . "&aspectFilter(2).aspectValueName='New with tags'"

         . "&affiliate.networkId=9"  // fill in your information in next 3 lines
         . "&affiliate.trackingId=1234567890"
         . "&affiliate.customId=456"
         . "&RESPONSE-DATA-FORMAT=$responseEncoding";

         $rest = simplexml_load_file($apicall) or die("Error: Please select the required filters");
         //print_r($resp);
         // Check to see if the response was loaded, else print an error
         // Probably best to split into two different tests, but have as one for brevity




           //echo $rest->paginationOutput->totalEntries;
           echo "</br>";
           $pageCount=(int)($rest->paginationOutput->totalEntries /$itemsPerRange)+1;
           //echo $pageCount;
           //echo "</br>";
           $results .= 'Total items : ' . $rest->paginationOutput->totalEntries . "<br />\n";
           $results .= '<table id="example" class="tablesorter" border="0" width="100%" cellpadding="0" cellspacing="1">' . "\n";
           $results .= "<thead><tr><th>Count</th><th /><th>Product details</th><th>Seller Info </th><th>Price &nbsp; &nbsp; </th><th>Shipping &nbsp; &nbsp; </th><th>Total &nbsp; &nbsp; </th><th>Time Left</th><th>Number of views on this app</th><th></th></tr></thead>\n";
           $countItems=1;


    if ($rest && $rest->paginationOutput->totalEntries > 0) {
      if($result_returned==0){
        $result_returned=1;
      }
    for($pageNumber=1;$pageNumber<=$pageCount;$pageNumber++){
    $apicall = "$endpoint?OPERATION-NAME=findItemsAdvanced"
         . "&SERVICE-VERSION=1.0.0"
         . "&GLOBAL-ID=EBAY-GB"
         . "&SECURITY-APPNAME=PiusJude-Ragnarok-PRD-c5d80d3bd-40178424" //replace with your app id
         . "&keywords=$safeQuery"
         . "&paginationInput.entriesPerPage=$itemsPerRange"
         . "&paginationInput.pageNumber=$pageNumber"
         . "&sortOrder=BestMatch"
         . "&itemFilter(0).name=ListingType"
         . "&itemFilter(0).value=Auction"
         // . "&itemFilter(0).value(1)=AuctionWithBIN"
         . "&itemFilter(1).name=MinPrice"
         . "&itemFilter(1).value=$priceRangeMin"
         . "&itemFilter(2).name=MaxPrice"
         . "&itemFilter(2).value=$priceRangeMax"
         . "&itemFilter(3).name=Condition"
         . "&itemFilter(3).value=$cond"



         . "&aspectFilter(0).aspectName=Display"
        // . "&aspectFilter(0).aspectValueName=Analog"
         . "&aspectFilter(0).aspectValueName=$disp"
         . "&aspectFilter(1).aspectName=Gender"
         . "&aspectFilter(1).aspectValueName=$gend"
         // . "&aspectFilter(2).aspectName=Year of Manufacture"
         // . "&aspectFilter(2).aspectValueName=$year"
        // . "&aspectFilter(1).aspectName=Brand"
        // . "&aspectFilter(1).aspectValueName=$company"
        // . "&aspectFilter(2).aspectName=Condition"
        // . "&aspectFilter(2).aspectValueName='New with tags'"

         . "&affiliate.networkId=9"  // fill in your information in next 3 lines
         . "&affiliate.trackingId=1234567890"
         . "&affiliate.customId=456"
         . "&RESPONSE-DATA-FORMAT=$responseEncoding";

    // if ($debug) {
    //   print "GET call = $apicall <br>";  // see GET request generated
    // }
    // Load the call and capture the document returned by the Finding API
    $resp = simplexml_load_file($apicall) or die("Error: Please select the required filters");
    //print_r($resp);
    // Check to see if the response was loaded, else print an error
    // Probably best to split into two different tests, but have as one for brevity

    //if ($resp && $resp->paginationOutput->totalEntries > 0) {
      // $results .= 'Total items : ' . $resp->paginationOutput->totalEntries . "<br />\n";
      // $results .= '<table id="example" class="tablesorter" border="0" width="100%" cellpadding="0" cellspacing="1">' . "\n";
      // $results .= "<thead><tr><th /><th>Product details</th><th>Seller Info </th><th>Price &nbsp; &nbsp; </th><th>Shipping &nbsp; &nbsp; </th><th>Total &nbsp; &nbsp; </th><th><!--Currency--></th><th>Time Left</th><th>Start Time</th><th>End Time</th></tr></thead>\n";


      // If the response was loaded, parse it and build links

      foreach($resp->searchResult->item as $item) {
        if ($item->galleryURL) {
          $picURL = $item->galleryURL;
        } else {
          $picURL = "http://pics.ebaystatic.com/aw/pics/express/icons/iconPlaceholder_96x96.gif";
        }
        $image = (string) $picURL;

        $link  = $item->viewItemURL;
        $title = $item->title;
        $sellingState = sprintf("Selling Status: %s",(string) $item->sellingStatus->sellingState);
        $condition = sprintf("Condition: %s",(string) $item->condition->conditionDisplayName);
        if((string) $item->condition->conditionDisplayName == "New with tags"){
          $conditionInfo = sprintf("A brand-new, unused, unworn and undamaged item in the original packaging (such as the original box or bag) and/or with the original tags attached.");
        }
        else if((string) $item->condition->conditionDisplayName == "New without tags"){
            $conditionInfo = sprintf("A brand-new, unused and unworn item that is not in its original retail packaging or may be missing its original retail packaging materials (such as the original box or bag). The original tags may not be attached.");
        }
        else if((string) $item->condition->conditionDisplayName == "New with defects"){
            $conditionInfo = sprintf("A brand-new, unused and unworn item with some kind of defect.  Possible cosmetic imperfections range from natural colour variations to scuffs, cuts or nicks, and hanging threads or missing buttons that occasionally occur during the manufacturing or delivery process. Apparel may contain irregular or mismarked size tags.  Item may be missing its original retail packaging materials (such as original box or bag).  New factory seconds and/or new irregular items may fall into this category. The original tags may or may not be attached. See seller’s listing for full details and description of any imperfections.");
        }
        else if((string) $item->condition->conditionDisplayName == "Used"){
            $conditionInfo = sprintf("An item that has been previously worn. See the seller’s listing for full details and description of any imperfections.");
        }

        //subtitle is optional description given by sellers
        $subtitle = $item->subtitle;
        //number of bids made for product
        $bids = sprintf("Number of bids: %u",$item->sellingStatus->bidCount);
        //unique ebay Id for product
        $ebayItemId  = sprintf("Item Id: %s ",$item->itemId);

        //display type e.g. analog or digital.
        //This is though copying filer selection.
        $display  = sprintf("Display type: %s",$disp);

        //seller info:
        //$positiveFeedbackPercent= sprintf("Seller name: %s",(string)$item->sellerInfo->sellerUserName);
        //location of product
        $location  = sprintf("Location: %s ",$item->location);


        $price = sprintf("%01.2f", $item->sellingStatus->convertedCurrentPrice);
        $ship  = sprintf("%01.2f", $item->shippingInfo->shippingServiceCost);
        $total = sprintf("%01.2f", ((float)$item->sellingStatus->convertedCurrentPrice
                      + (float)$item->shippingInfo->shippingServiceCost));

        $sqlItemSellingStatus = (float)$item->sellingStatus->convertedCurrentPrice;
        $sqlItemShippingInfo = (float)$item->shippingInfo->shippingServiceCost;
        $sqlEbayItemID = (float)$item->itemId;
        $sqlItemTitle = (string)$item->title;
        $sqlLink = (string) $item->viewItemURL;
        // SQL connection
        // $host = "ragnasvr.database.windows.net,1433";
        //
        // $dbname = "ragnaDB";
        //
        // $dbuser = "ragnarok@ragnasvr";
        //
        // $dbpwd = "Korangar2";
        //
        // $driver = "{ODBC Driver 13 for SQL Server}";
        //
        //
        // // Build connection string
        //
        // $dsn="Driver=$driver;Server=$host;Database=$dbname;";
        //
        // if (!($conn = @odbc_connect($dsn, $dbuser, $dbpwd))) {
        //
        //   die("Connection error: " . odbc_errormsg());
        //
        // }
        // else
        // {
        //   //print("Connection succesful");
        // }

        // $serverName = "tcp:ragnasvr.database.windows.net, 1433";
        // $connectionOptions = array(
        //     "Database" => "ragnaDB",
        //     "Uid" => "ragnarok@ragnasvr",
        //     "PWD" => "Korangar2"
        // );
        // //Establishes the connection
        // $conn = sqlsrv_connect($serverName, $connectionOptions);

        // if (!($conn)) {

        //   die("Connection error: " . sqlsrv_connect_error());

        // }
        // else
        // {
        //   //print("Connection succesful ");

        // }

        $query = "SELECT * FROM auction.product_searches WHERE ebayID = '$sqlEbayItemID'";
        $getMatches= sqlsrv_query($conn, $query);

        $row = sqlsrv_fetch_array($getMatches, SQLSRV_FETCH_ASSOC);
        $viewcount =1;
        //check for duplication
        $status_on_ebay = 'active';
        if(!$row){
        $tsql= "INSERT INTO auction.product_searches (title, price, serviceCost, ebayID, product_link, image, view_count, status, brand, display, condition, gender) VALUES (?,?,?,?,?,?,?,?,?,?,?,?);";
        // $user_id = $_SESSION['user_id'];
        $params = array($sqlItemTitle,$sqlItemSellingStatus,$sqlItemShippingInfo,$sqlEbayItemID,$sqlLink,$image,$viewcount,$status_on_ebay,$brand,$disp,$cond,$gend);
        $getResults= sqlsrv_query($conn, $tsql, $params);
        $rowsAffected = sqlsrv_rows_affected($getResults);
        if ($getResults == FALSE or $rowsAffected == FALSE)
          {
            echo $countItems;
            die(FormatErrors(sqlsrv_errors()));
          }
          else{
            //echo "Succeeded ";
            //echo $count;
            //echo "</br>";
          }
          // echo ($rowsAffected. " row(s) inserted: " . PHP_EOL);
          //header("Location: FindItemsAdvanced.php");
          sqlsrv_free_stmt($getResults);
        }
        else{
          $count = $row['view_count'];
          $id = $row['ID'];
        //  echo "id ";
        //echo $id;
          $viewcount = $count + 1;
        //  echo $update_count;
        //  echo "</br>";
          $sql = "UPDATE auction.product_searches SET view_count=$viewcount WHERE id=$id";
          $getResultsD= sqlsrv_query($conn, $sql);
          $rowsAffectedD = sqlsrv_rows_affected($getResultsD);
          if ($getResultsD == FALSE or $rowsAffectedD == FALSE)
              die(FormatErrors(sqlsrv_errors()));

        }

        // Determine currency to display - so far only seen cases where priceCurr = shipCurr, but may be others
        $priceCurr = (string) $item->sellingStatus->convertedCurrentPrice['currencyId'];
        $shipCurr  = (string) $item->shippingInfo->shippingServiceCost['currencyId'];
        if ($priceCurr == $shipCurr) {
          $curr = $priceCurr;
        } else {
          $curr = "$priceCurr / $shipCurr";  // potential case where price/ship currencies differ
        }
        $timeLeft = getPrettyTimeFromEbayTime($item->sellingStatus->timeLeft);
        //$endTime = strtotime($item->listingInfo->endTime);   // returns Epoch seconds
        $endTime = $item->listingInfo->endTime;
        $startTime = $item->listingInfo->startTime;

        // $sql = "INSERT INTO dbo.Product_Searches (title, price, serviceCost)
        // VALUES ('$sqlItemTitle','$sqlItemSellingStatus','$sqlItemShippingInfo' )";
        // $res = odbc_exec($conn, $sql);
        //   if (!$res) {
        //     echo $count;
        //     print("Table creation failed with error:\n");
        //     print(odbc_error($conn).": ".odbc_errormsg($conn)."\n");
        //     echo '</br>';
        //   } else {
        //     print("Table fyi_links created.\n");
        //     echo '</br>';
        //   }

          // Free the connection

        //  @odbc_close($conn);
        $results .= "<tr><td>$countItems</td><td><a href=\"$link\"><img src=\"$picURL\"></a></td><td> <a href=\"$link\">$title</a></br> $subtitle </br></br> $sellingState </br></br> $bids</br></br> $condition</br></br>$conditionInfo</br></br> $ebayItemId</br></br> $display</br></br><td >$location</td>"
             .  "<td>£$price</td><td>£$ship</td><td>£$total</td><td><p id=\"$ident\"></p><script>countDown('".$ident."','".$endTime."')</script></td><td>$viewcount</td><td> <form method=\"POST\" action=\"bid.php\">  <button type=\"submit\" class=\"btn btn-success\" name=\"ebayID\" value=\"$sqlEbayItemID\" >Place bid</button></form> &nbsp;&nbsp;  <iframe name=\"votar\" style=\"display:none;\"></iframe>  <form id= \"add_to_watchlist\" target=\"votar\" method=\"post\">  <button type=\"submit\" class=\"btn btn-success\" name=\"add_to_watchlist\" onclick=\"return confirm('Want to add item?');\" value=\"$sqlEbayItemID\">Add to Watchlist</button></form> &nbsp;&nbsp;   <form method=\"POST\" action=\"review.php\">  <button type=\"submit\" class=\"btn btn-danger\" name=\"ebayID\" value=\"$sqlEbayItemID\" >Add a Review</button></form> &nbsp;&nbsp; <form method=\"POST\" action=\"review_show.php\">  <button type=\"submit\" class=\"btn btn-warning\" name=\"ebayIDShow\" value=\"$sqlEbayItemID\" >Show all Reviews</button></form>  &nbsp;&nbsp; </td></tr>";
            $countItems++;
            $ident++;
      }// each item


    //if resp more than 0
    // If there was no response, print an error


  }// for each page
}
  else {
    $results .= "<p> $range <i><b>No items found</b></i></p>". "<br />\n";

  }
    $results .= "</table>";
    $priceRangeMin = $priceRangeMax; // set up for next iteration

  } // foreach
      echo $results;
      $result_returnA = $result_returned;
      echo "</br>";
      // echo "result ";
      // echo $result_returnA;
      $current_uid = $_SESSION['userID'];
      $gend_for_filters = str_replace ("'s","",$gend);
      $query = "SELECT * FROM auction.filters
      WHERE brand = '$brand' AND min_price = '$min' AND max_price = '$max'
      AND display ='$disp' AND condition = '$cond' AND gender = '$gend_for_filters' AND user_id = '$current_uid' ";
      $getMatches= sqlsrv_query($conn, $query);

      $row = sqlsrv_fetch_array($getMatches, SQLSRV_FETCH_ASSOC);
      // echo "HERE -> " . $row;
      if(!$row){
        $filter_count=1;
        $tsql2= "INSERT INTO auction.filters (brand, min_price, max_price, display, condition, gender, user_id, results, filter_count) VALUES (?,?,?,?,?,?,?,?,?);";
        $params2 = array($brand,$min,$max,$disp,$cond,$gend_for_filters,$current_uid,$result_returnA,$filter_count);
        $getResults2= sqlsrv_query($conn, $tsql2, $params2);
        $rowsAffected2 = sqlsrv_rows_affected($getResults2);
        if ($getResults2 == FALSE or $rowsAffected2 == FALSE){
          die(FormatErrors(sqlsrv_errors()));
        }


      }
      else{
        $countings = $row['filter_count'];
        $id = $row['ID'];
      //  echo "id ";
        //echo $id;
        echo "</br>";
        $filterviewcount = $countings + 1;
        // echo $filterviewcount;
        //echo "</br>";
        $sql = "UPDATE auction.filters SET filter_count=$filterviewcount WHERE id=$id";
        $getResultsD= sqlsrv_query($conn, $sql);
        $rowsAffectedD = sqlsrv_rows_affected($getResultsD);
        if ($getResultsD == FALSE or $rowsAffectedD == FALSE)
            die(FormatErrors(sqlsrv_errors()));

      }

      exit;
} // if


?>








































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
