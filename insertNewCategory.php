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

$newCategoryName = null;
if (isset($_GET['newCategoryName'])) {
    $newCategoryName = $_GET['newCategoryName'];
} else {
    die('Error: The "newCategoryName" value was not sent, so I could not insert the new category to the database!');
}

$query = "INSERT INTO  `category` (`name`) VALUE('$newCategoryName');";

$result = mysql_query($query);

mysql_close($connection);

header('Location: index.php');
?>