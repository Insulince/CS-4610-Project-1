<?php

$mn = intval(filter_input(INPUT_POST, "mn"));

$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "universitydb";

$con = mysql_connect($dbhost, $dbuser, $dbpassword);

if (!$con) {
    die('Could not connect: ' . mysql_error());
}

mysql_select_db($dbname, $con);

$tblArr = array();
$tblArr[] = "student";
$tblArr[] = "course";
$tblArr[] = "section";
$tblArr[] = "grade_report";
$tblArr[] = "prerequisite";

$table_name = $tblArr[$mn];

$sql = "SHOW COLUMNS FROM $table_name";
$result1 = mysql_query($sql);

while ($record = mysql_fetch_array($result1)) {
    $fields[] = $record['0'];
}

$allfields = "(";
$allvalues = "(";

for ($i = 0; $i < count($fields); $i++) {
    $val = filter_input(INPUT_POST, $fields[$i]);
    
    $allfields = $allfields . $fields[$i];
    $allvalues = $allvalues . "'" . $val . "'";
    
    if ($i < count($fields) - 1) {
        $allfields = $allfields . ",";
        $allvalues = $allvalues . ",";
    }
}

$allfields = $allfields . ")";
$allvalues = $allvalues . ")";

$query = "INSERT INTO $table_name $allfields VALUES $allvalues";

mysql_query($query);

mysql_close($con);

header('Location: uniinput.php?mn=' . $mn);
?>