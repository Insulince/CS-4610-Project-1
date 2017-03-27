<?php
$databaseHost = "localhost";
$databaseUsername = "justin";
$databasePassword = "cC8XBEha48hjn="; //TODO: REMOVE THIS
$databaseName = "mathprobdb";

$connection = mysql_connect($databaseHost, $databaseUsername, $databasePassword);

if (!$connection) {
    die('Error: Could not connect for reason "' . mysql_error() . '"');
}

mysql_select_db($databaseName, $connection);

$updatedCategoryName = null;
if (isset($_GET['updatedCategoryName'])) {
    $updatedCategoryName = $_GET['updatedCategoryName'];
}

$updatedCategoryCid = null;
if (isset($_GET['updatedCategoryName'])) {
    $updatedCategoryCid = $_GET['updatedCategoryCid'];
}

$query = "UPDATE `category` SET `name` = '$updatedCategoryName' WHERE `cid` = '$updatedCategoryCid';";

$result = mysql_query($query);

mysql_close($connection);

header('Location: index.php');
?>