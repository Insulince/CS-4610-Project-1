<?php

$mn = intval(filter_input(INPUT_GET, "mn"));

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

$optArr = array();
$optArr[] = "Student";
$optArr[] = "Course";
$optArr[] = "Section";
$optArr[] = "Grade Report";
$optArr[] = "Prerequisite";

$data2dArr = array();

$query = "SELECT * FROM  $table_name";
$result2 = mysql_query($query);

while ($line = mysql_fetch_array($result2, MYSQL_ASSOC)) {
    $i = 0;
    foreach ($line as $col_value) {
        $data2dArr[$i][] = $col_value;
        $i++;
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>University: Sample</title>
    </head>
    <body>
        <table>
            <tr>
                <?php
                for ($i = 0; $i < count($optArr); $i++) {
                    ?>
                    <td style="width: 7em">
                        <?php
                        if ($mn == $i) {
                            ?>
                            <b><?php print $optArr[$i]; ?></b>
                            <?php
                        } else {
                            ?>
                            <a href="uniview1.php?mn=<?php print $i; ?>">
                                <?php print $optArr[$i]; ?>
                            </a>
                            <?php
                        }
                        ?>
                    </td>
                    <?php
                }
                ?>
            </tr>
        </table>
        <hr />
        <table>
            <tr>
                <?php
                for ($i = 0; $i < count($fields); $i++) {
                    ?>
                    <th style="width: 8em"><?php print $fields[$i]; ?></th>
                        <?php
                    }
                    ?>
            </tr>
            <?php
            for ($j = 0; $j < count($data2dArr[0]); $j++) {
                ?>
                <tr>
                    <?php
                    for ($k = 0; $k < count($fields); $k++) {
                        ?>
                        <td><?php print $data2dArr[$k][$j]; ?></td>
                        <?php
                    }
                    ?>
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>
<?php
mysql_close($con);
?>