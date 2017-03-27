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

$newCategoryName = null;
if (isset($_GET['newCategoryName'])) {
    $newCategoryName = $_GET['newCategoryName'];
}

$query = "INSERT INTO  `category` (`name`) VALUE('$newCategoryName');";

$result = mysql_query($query);

mysql_close($connection);

header('Location: index.php');
//?>