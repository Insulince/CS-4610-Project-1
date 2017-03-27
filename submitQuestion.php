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

$newQuestionContent = null;
if (isset($_GET['newQuestionContent'])) {
    $newQuestionContent = $_GET['newQuestionContent'];
}

$query = "INSERT INTO  `problem` (`content`) VALUE('$newQuestionContent');";

$result = mysql_query($query);

mysql_close($connection);

header('Location: index.php');
?>