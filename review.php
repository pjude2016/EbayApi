<?php
session_start();
$_SESSION['message'] = '';
$connectionInfo = array("UID" => "auctora@auctora-server", "pwd" => "arotcua1!", "Database" => "auctoraDB");
$serverName = "tcp:auctora-server.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);
 echo "<br><br><br><br><br>";
echo "<h1 align='center'>eBay Watch Review</h1>";
echo "</br>";
//ebayItem id from product_searches page
$ebayItemId = $_POST['ebayID'];
$current_uid = $_SESSION['user_id'];
//user primary key
$currentId = $_SESSION['userID'];
echo "</br>";
echo "</br></br>";
$query = "SELECT * FROM auction.product_searches WHERE ebayID = '$ebayItemId'";
$getMatches= sqlsrv_query($conn, $query);
$row = sqlsrv_fetch_array($getMatches, SQLSRV_FETCH_ASSOC);
$count = $row['view_count'];
//obtain below product primary key id from database
$prod_id = $row['ID'];
$_SESSION['productID'] = $row['ID'];
echo "product1_id ";
echo $prod_id;
echo "
<table border='1' align='center'>
<tr>
<th>Image</th>
<th>Title</th>
<th>Price</th>
<th>Service Cost</th>
<th>ebayID</th>
</tr>";
$product_link = $row['product_link'];
$title = $row['title'];
$img_src = $row['image'];
echo "<tr>";
echo "<td>" . "<a href=\"$product_link\"><img src=\"$img_src\"></a>" . "</td>";
echo "<td>" . "<a href=\"$product_link\" target=\"_blank\">$title</a>" . "</td>";
echo "<td>" . $row['price'] . "</td>";
echo "<td>" . $row['serviceCost'] . "</td>";
echo "<td>" . $row['ebayID'] . "</td>";
echo "</tr>";
// $tsql2= "INSERT INTO auction.product_reviews (comment, rating, user_id, product_id ) VALUES (?,?,?,?);";
// $params2 = array($title,$rating,$currentId,$id);
// $getResults2= sqlsrv_query($conn, $tsql2, $params2);
// $rowsAffected2 = sqlsrv_rows_affected($getResults2);
// if ($getResults2 == FALSE or $rowsAffected2 == FALSE){
//   die(FormatErrors(sqlsrv_errors()));
// }
// $currentUserId = $_SESSION['userID'];
//
// $productid = $row['ID'];
// $comment = $_POST['reviewBody'];
// echo "product";
// echo $productid;
//
// $rating =5;
//
//
//
// $tsql2= "INSERT INTO auction.product_reviews (comment, rating, user_id, product_id ) VALUES (?,?,?,?);";
// $params2 = array($comment,$rating,$currentUserId,$productid);
// $getResults2= sqlsrv_query($conn, $tsql2, $params2);
// $rowsAffected2 = sqlsrv_rows_affected($getResults2);
// if ($getResults2 == FALSE or $rowsAffected2 == FALSE){
//   die(FormatErrors(sqlsrv_errors()));
// }
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

    <script src="ckeditor/ckeditor.js"></script>

    <style>
      body {
        overflow-x: hidden;
        margin-bottom: 15px;
      }
      textarea {
        resize: none;
      }
      .forum-full {
        background-color: rgba(0, 0, 0, 0.7);
        max-width: 100%;
        max-height: 100%;
        border: 1px solid;
        padding: 15px;
        margin: .4%;
      }
      .topic {
        margin-top: 5px;
        color: rgba(215, 169, 60, 0.8);
      }
      .body-full {
        color: white;
        margin-bottom: 1%;
      }
      .comment {
        position: absolute;
        right: 35px;
        bottom: 10px;
        font-size: 40px
      }
      .comment-box {
        width: 100%;
        row: 9;
      }
      .post-by {
        position: absolute;
        color: rgba(255, 255, 255, 0.4);
        bottom: 1px;
        right: 84%;
        font-size: 12px;
      }
      hr {
        border: 0;
        height: 0;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
        border-bottom: 1px solid rgba(255, 255, 255, 0.3);
      }
    </style>

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
              <a class="nav-link js-scroll-trigger" href="#">My Watchlist</a>
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

    <!-- <a href="#writereview">Write a review</a> -->

    <!-- Write review -->
    <div class="col-md-2"></div>
    <div class="col-md-8 container forum-full">
        <form action="" method="post" id="writereviews">
          <textarea placeholder="Write your review..." class="col-md-12 ckeditor" name="reviewBody" rows="8"></textarea>
          <input type="submit" value="Post" style="background:green;color:white;margin-top:10px;">
        </form>
    </div>
    <div class="col-md-2"></div>


  <?php
  $comment = $_POST['reviewBody'];
  $currentUserId = $_SESSION['userID'];
  echo $comment;
  echo "</br>";
  echo "product2: ";
  echo $prod_id;
  $rating =5;
  //push review to database
  $tsql2= "INSERT INTO auction.product_reviews (product_id, user_id, comment, rating) VALUES (?,?,?,?);";
  $params2 = array($prod_id,$currentUserId,$comment,$rating);
  $getResults2= sqlsrv_query($conn, $tsql2, $params2);
  $rowsAffected2 = sqlsrv_rows_affected($getResults2);
  if ($getResults2 == FALSE or $rowsAffected2 == FALSE){
    die(FormatErrors(sqlsrv_errors()));
  }
  ?>
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
