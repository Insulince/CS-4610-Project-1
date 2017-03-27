<?php
$mn = intval(filter_input(INPUT_GET, "mn"));
$cn = intval(filter_input(INPUT_GET, "cn"));
$dir = intval(filter_input(INPUT_GET, "dir"));

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

if ($dir == 0) {
    $query = "SELECT * FROM  $table_name ORDER BY $fields[$cn]";
} else {
    $query = "SELECT * FROM  $table_name ORDER BY $fields[$cn] DESC";
}

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
        <script type="text/javascript" src="js/university.js"></script>
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
                            <a href="uniinput.php?mn=<?php print $i; ?>">
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
            <tr>
                <?php
                for ($i = 0; $i < count($fields); $i++) {
                    ?>
                    <td style="width: 8em">
                        <input type="image" src="images/up.png" onclick="sortCurrentField(<?php print $mn; ?>,<?php print $i; ?>, 0)"/>
                        <input type="image" src="images/down.png" onclick="sortCurrentField(<?php print $mn; ?>,<?php print $i; ?>, 1)"/>
                    </td>
                    <?php
                }
                ?>
            </tr>
        </table>
        <div id="newdatadiv" style="display: block">
            <table>
                <tr>
                    <?php
                    for ($i = 0; $i < count($fields); $i++) {
                        ?>
                        <td style="width: 8em"></td>
                        <?php
                    }
                    ?>
                    <td><input type="button" onclick="addNewRow()" value="New Row"/></td>
                </tr>
            </table>
        </div>
        <div id="datainputdiv" style="display: none">
            <form action="enterTableRow.php" method="post">
                <table>
                    <tr>
                        <?php
                        for ($i = 0; $i < count($fields); $i++) {
                            ?>
                            <td style="width: 8em"><input type="text" name="<?php print $fields[$i]; ?>" size="10" /></td>
                                <?php
                            }
                            ?>
                        <td><input type="submit" value="Enter"/></td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>
<?php
mysql_close($con);
?>