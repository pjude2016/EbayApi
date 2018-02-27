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
?>
</html>
