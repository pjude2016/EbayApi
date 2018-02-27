<!DOCTYPE html>
<html lang="en">
<head></head>
<body>
</body>
<?php
session_start();
$_SESSION['message'] = '';
$connectionInfo = array("UID" => "auctora@auctora-server", "pwd" => "arotcua1!", "Database" => "auctoraDB");
$serverName = "tcp:auctora-server.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);


echo "Review";
echo "</br>";
$ebayItemId = $_POST['ebayID'];
echo "Ebay Item ID: ";
echo $ebayItemId;


echo "</br></br>";
$query = "SELECT * FROM auction.product_searches WHERE ebayID = '$ebayItemID'";
$getMatches= sqlsrv_query($conn, $query);

$row = sqlsrv_fetch_array($getMatches, SQLSRV_FETCH_ASSOC);
$count = $row['view_count'];
$id = $row['ID'];


echo "
<br><br><br><br><br>
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
?>
</html>
