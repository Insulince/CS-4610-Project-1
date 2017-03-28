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

$newQuestionContent = null;
if (isset($_GET['newQuestionContent'])) {
    $newQuestionContent = $_GET['newQuestionContent'];
} else {
    die('Error: The "newQuestionContent" value was not sent, so I could not insert the new question to the database!');
}

$query = "INSERT INTO  `problem` (`content`) VALUE('$newQuestionContent');";

$result = mysql_query($query);

mysql_close($connection);

header('Location: index.php');
?>