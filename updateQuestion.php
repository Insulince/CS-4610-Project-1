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

$updatedQuestionContent = null;
if (isset($_GET['updatedQuestionContent'])) {
    $updatedQuestionContent = $_GET['updatedQuestionContent'];
} else {
    die('Error: The "updatedQuestionContent" value was not sent, so I could not update the question in the database!');
}

$updatedQuestionPid = null;
if (isset($_GET['updatedQuestionPid'])) {
    $updatedQuestionPid = $_GET['updatedQuestionPid'];
} else {
    die('Error: The "updatedQuestionPid" value was not sent, so I could not update the question in the database!');
}

$updatedCategoryName = null;
if (isset($_GET['updatedCategoryName'])) {
    $updatedCategoryName = $_GET['updatedCategoryName'];
} else {
    die('Error: The "updatedCategoryName" was not sent, so I could not update the question in the database!');
}

$query = "UPDATE `problem` SET `content` = '$updatedQuestionContent' WHERE `pid` = '$updatedQuestionPid';";
$result = mysql_query($query);

$categoryCidArray = array();
$categoryNameArray = array();

$query = "SELECT `cid`, `name` FROM `category`;";

$result = mysql_query($query);

while ($row = mysql_fetch_assoc($result)) {
    $categoryCidArray[] = $row['cid'];
    $categoryNameArray[] = $row['name'];
}

$categoryId = -1;
for ($i = 0; $i < count($categoryNameArray); $i++) {
    if ($updatedCategoryName == $categoryNameArray[$i]) {
        $categoryId = $categoryCidArray[$i];
    }
}

$probcatmappingPcmidArray = array();
$probcatmappingProblemIdArray = array();
$probcatmappingCategoryIdArray = array();

$query = "SELECT `pcmid`, `problem_id`, `category_id` FROM `prob_cat_mapping`;";

$result = mysql_query($query);

while ($row = mysql_fetch_assoc($result)) {
    $probcatmappingPcmidArray[] = $row['pcmid'];
    $probcatmappingProblemIdArray[] = $row['problem_id'];
    $probcatmappingCategoryIdArray[] = $row['category_id'];
}

$notAlreadyInProbCatMapping = true;
for ($i = 0; $i < count($probcatmappingPcmidArray); $i++) {
    if ($probcatmappingProblemIdArray[$i] == $updatedQuestionPid && $probcatmappingCategoryIdArray[$i] == $categoryId) {
        $notAlreadyInProbCatMapping = false;
    }
}
if ($notAlreadyInProbCatMapping) {
    $query = "INSERT INTO `prob_cat_mapping` (`problem_id`, `category_id`) VALUES('$updatedQuestionPid', '$categoryId');";

    $result = mysql_query($query);

    mysql_close($connection);
}

header('Location: index.php');
?>