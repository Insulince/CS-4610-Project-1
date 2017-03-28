<?php
$databaseHost = "localhost";
$databaseUsername = "root";
$databasePassword = "";
$databaseName = "mathprobdb";

$connection = mysql_connect($databaseHost, $databaseUsername, $databasePassword);

if (!$connection) {
    die('Error: Could not connect for reason "' . mysql_error() . '"!');
}

mysql_select_db($databaseName, $connection);

$updatedCategoryName = null;
if (isset($_GET['updatedCategoryName'])) {
    $updatedCategoryName = $_GET['updatedCategoryName'];
} else {
    die('Error: The "updatedCategoryName" va;ie was not sent, so I could not update the category in the database!');
}

$updatedCategoryCid = null;
if (isset($_GET['updatedCategoryCid'])) {
    $updatedCategoryCid = $_GET['updatedCategoryCid'];
} else {
    die('Error: The "updatedCategoryCid" value was not sent, so I could not update the category in the database!');
}

$query = "UPDATE `category` SET `name` = '$updatedCategoryName' WHERE `cid` = '$updatedCategoryCid';";

$result = mysql_query($query);

mysql_close($connection);

header('Location: index.php');
?>