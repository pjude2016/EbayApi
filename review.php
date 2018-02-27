<!DOCTYPE html>
<html lang="en">
<head></head>
<body>
</body>
<?php
session_start();
echo "hello";
$current_item = $_SESSION['reviewItem'];
echo $current_item;
?>
</html>
