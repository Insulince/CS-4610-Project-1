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

$updatedQuestionContent = null;
if (isset($_GET['updatedQuestionContent'])) {
    $updatedQuestionContent = $_GET['updatedQuestionContent'];
}

$updatedQuestionPid = null;
if (isset($_GET['updatedQuestionContent'])) {
    $updatedQuestionPid = $_GET['updatedQuestionPid'];
}

$updatedCategory = null;
if (isset($_GET['updatedCategory'])) {
    $updatedCategory = $_GET['updatedCategory'];
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
    if ($updatedCategory == $categoryNameArray[$i]) {
        $categoryId = $categoryCidArray[$i];
    }
}

print "Updated Category: " . $updatedCategory . "\n";
print "Current question PID: " . $updatedQuestionPid . "\n";
print "Current question Content: " . $updatedQuestionContent . "\n";
print "ID of category to update to: " . $categoryId . "\n";

//$query = "UPDATE `prob_cat_mapping` SET `category_id` = '$categoryId' WHERE `problem_id` = '$updatedQuestionPid';";
//$query = "INSERT INTO `prob_cat_mapping` (`problem_id`, `category_id`) VALUES('$updatedQuestionPid', '$categoryId')";

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

$dontSet = false;

for ($i = 0; $i < count($probcatmappingPcmidArray); $i++) {
    if ($probcatmappingProblemIdArray[$i] == $updatedQuestionPid && $probcatmappingCategoryIdArray[$i] == $categoryId) {
        $dontSet = true;
        print "dontSet = true";
    }
}

if ($dontSet == false) {
    $query = "INSERT INTO `prob_cat_mapping` (`problem_id`, `category_id`) VALUES('$updatedQuestionPid', '$categoryId');";//" IF NOT EXISTS(SELECT `problem_id`, `category_id` FROM `prob_cat_mapping` WHERE `problem_id` = '$updatedQuestionPid' AND `category_id` = '$categoryId');";

    $result = mysql_query($query);

    mysql_close($connection);
}

header('Location: index.php');
?>