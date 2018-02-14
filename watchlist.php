<?php
session_start();
$_SESSION['message'] = '';
$serverName = "tcp:ragnasvr.database.windows.net, 1433";
$connectionOptions = array(
    "Database" => "ragnaDB",
    "Uid" => "ragnarok@ragnasvr",
    "PWD" => "Korangar2"
);
// echo $_SESSION;

// echo '<pre>';
// var_dump($_SESSION);
// echo '</pre>';


//Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);


$current_user_id = $_SESSION['user_id'];

$tsql= "SELECT * FROM auction.watch_list WHERE user_id = '$current_user_id'";
$getResults= sqlsrv_query($conn, $tsql, array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
if ($getResults == FALSE)
    die(FormatErrors(sqlsrv_errors()));

// $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
$num_of_rows = sqlsrv_num_rows($getResults);
// echo "<br><br><br>num of rows: " . $num_of_rows;
if($num_of_rows > 0)
{



echo "
<br><br><br><br><br>
<table border='1' align='center'>
<tr>
<th>Title</th>
<th>Price</th>
<th>Service Cost</th>
<th>ebayID</th>
</tr>";

// $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);

// while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
//     echo ($row['title'] . " " . $row['price'] . " " . $row['serviceCost'] . " " . $row['ebayID'] . PHP_EOL); 
//   }


while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {

  echo "<tr>";
  echo "<td>" . $row['title'] . "</td>";
  echo "<td>" . $row['price'] . "</td>";
  echo "<td>" . $row['serviceCost'] . "</td>";
  echo "<td>" . $row['ebayID'] . "</td>";
  echo "</tr>";

  }

echo "</table>"; 
}

else{
  echo "<br><br><br><br><br>
  <p align='center'>Go to the products page to start adding items to your watchlist!</p>";
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
        <a class="navbar-brand js-scroll-trigger" href="#page-top">W A T C H</a>
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