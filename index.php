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

$problemPidArray = array();
$problemContentArray = array();
$query = "SELECT `pid`, `content` FROM `problem` ORDER BY `pid` DESC;";
$result = mysql_query($query);
while ($row = mysql_fetch_assoc($result)) {
    $problemPidArray[] = $row['pid'];
    $problemContentArray[] = $row['content'];
}

$categoryCidArray = array();
$categoryNameArray = array();
$query = "SELECT `cid`, `name` FROM `category`;";
$result = mysql_query($query);
while ($row = mysql_fetch_assoc($result)) {
    $categoryCidArray[] = $row['cid'];
    $categoryNameArray[] = $row['name'];
}

$probcatmappingPcmidArray = array();
$probcatmappingProblemIdArray = array();
$probcatmappingCategoryIdArray = array();
$query = "SELECT `pcmid`, `problem_id`, `category_id` FROM `prob_cat_mapping`;";
$result = mysql_query($query);
while ($row = mysql_fetch_assoc($result)) {
    $probcatmappingPcmidArray[] = $row["pcmid"];
    $probcatmappingProblemIdArray[] = $row["problem_id"];
    $probcatmappingCategoryIdArray[] = $row["category_id"];
}

if (isset($_GET['selectedCategory'])) {

    $selectedCategoryId = "-1";

    for ($i = 0; $i < count($categoryNameArray); $i++) {
        if ($categoryNameArray[$i] == $_GET['selectedCategory']) {
            $selectedCategoryId = $categoryCidArray[$i];
        }
    }

    if ($selectedCategoryId != -1) {
        $tmpProblemIdArray = array();
        $query = "SELECT `problem_id`, `category_id` FROM `prob_cat_mapping` WHERE category_id = '$selectedCategoryId'";
        $result = mysql_query($query);
        while ($row = mysql_fetch_assoc($result)) {
            $tmpProblemIdArray[] = $row['problem_id'];
        }

        print count($tmpProblemIdArray);
        print implode($tmpProblemIdArray);

        $query = "SELECT `pid`, `content` FROM `problem` WHERE `pid` != ANY(".implode($tmpProblemIdArray).") ORDER BY `pid` DESC";
        $result - mysql_query($query);
        while ($row = mysql_fetch_assoc($result)) {
            $problemPidArray = $row['pid'];
            $problemContentArray = $row['content'];
        }
    } else {
        die('Unknown category "'.$_GET['selectedCategory'].'"! Exiting.');
    }
}

?>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Project 1</title>
        <script type="text/javascript">
            window.MathJax = {
                tex2jax: {
                    inlineMath: [["\\(", "\\)"]],
                    processEscapes: true
                }
            };
        </script>
        <script type="text/javascript" src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
        </script>

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script type="text/javascript" src="index.js"></script>
        <link rel="stylesheet" href="index.css"/>
    </head>
    <body>
    <div class="container-fluid">
        <div id="main-wrapper" class="col-lg-10 col-lg-offset-1">
            <div class="row">
                <h1 id="title">Math Problems</h1>
            </div>
            <div id="content-and-category-row" class="row">
                <div id="content-table-wrapper" class="col-lg-9">
                    <form id="addNewQuestionForm" action="./submitQuestion.php" method="get">
                        <div class="form-group">
                            <label for="newQuestionContent">Add a New Question</label>
                            <input id="newQuestionContent" class="form-control" type="text" name="newQuestionContent" placeholder="New Question Content"/>
                        </div>
                        <input id="new-question-submit-button" class="btn btn-default" type="submit" value="Submit"/>
                    </form>
                    <table id="table" class="table-bordered table-hover">
                        <tr>
                            <th colspan="4">
                                <p id="problems-table-title">Problems</p>
                            </th>
                        </tr>
                        <tr>
                            <th id="pid-column-header-cell" class="pid-column header-row">
                                <p id="problems-table-problem-id-header">Id</p>
                            </th>
                            <th id="content-column-header-cell" class="content-column header-row">
                                <p id="problems-table-problem-content-header">Problem Content</p>
                            </th>
                            <th id="category-column-header-cell">
                                <p>Categories</p>
                            </th>
                            <th id="edit-column-header-cell" class="edit-column header-row">
                                <p id="problems-table-edit-questions-header">Edit</p>
                            </th>
                        </tr>
                        <?php
                        for ($i = 0; $i < count($problemPidArray); $i++) { ?>
                            <tr>
                                <td id="pid-cell-<?php print $problemPidArray[$i] ?>" class="pid-column row-<?php print $problemPidArray[$i] ?>"><p id="pid-<?php print $problemPidArray[$i]; ?>"><?php print $problemPidArray[$i]; ?></p></td>
                                <form id='save-changes-form-<?php print count($problemPidArray) - $i; ?>' class='save-changes-form' action="./updateQuestion.php" method="get">
                                    <input name="updatedQuestionPid" type="text" style="display: none;" value="<?php print $problemPidArray[$i] ?>"/>
                                    <td id="content-cell-<?php print $problemPidArray[$i] ?>" class="content-column row-<?php print $problemPidArray[$i] ?>">
                                        <div id="question-content-<?php print $problemPidArray[$i]; ?>" class="question-content"><?php print $problemContentArray[$i]; ?></div>
                                        <textarea id="edit-content-<?php print $problemPidArray[$i]; ?>" class="edit-content" name='updatedQuestionContent' onkeyup="auto_grow(this;)"><?php print $problemContentArray[$i]; ?></textarea>
                                    </td>
                                    <td id="category-cell-<?php print $problemPidArray[$i]; ?>" class="category-column row-<?php print $problemPidArray[$i]; ?>">
                                        <?php
                                        $category = array();
                                        for ($j = 0; $j < count($probcatmappingPcmidArray); $j++) { //For every item in the prob_cat_mapping table...
                                            if ($problemPidArray[$i] == $probcatmappingProblemIdArray[$j]) { //If the current problem's id matches the current problem id in prob_cat_mapping...
                                                $category[] = $categoryNameArray[$probcatmappingCategoryIdArray[$j]]; //Category = Category + the category at the location found in the current prob_cat_mapping record.
                                            }
                                        }

                                        if (count($category) > 1) {
                                            for ($j = 0; $j < count($category); $j++) {
                                                if ($category[$j] = "{NO CATEGORY}") {
                                                    array_splice($category, $j, 1);
                                                }
                                            }
                                        }

                                        if (count($category) == 0) { //If category remained empty...
                                            $category[] = "{NO CATEGORY}"; //Initialize to the default value.

                                            $query = "INSERT INTO `prob_cat_mapping` (`problem_id`, `category_id`) VALUES('$problemPidArray[$i]', '0')"; //Insert this relationship into the prob_cat_mapping table.

                                            $result = mysql_query($query); //Execute the query/
                                        }

                                        for ($j = 0; $j < count($category); $j++) {
                                            if ($category[$j] != "{NO CATEGORY}") {
                                                ?>
                                                <div id="categories-<?php print $problemPidArray[$i]; ?>" class="categories"><a href="?selectedCategory=<?php print $category[$j]; ?>" class="btn btn-default"><?php print $category[$j]; ?></a></div>
                                                <?php
                                            } else {
                                                ?>
                                                <div id="categories-<?php print $problemPidArray[$i]; ?>" class="categories"><?php print $category[$j]; ?></div>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <select id="category-select-<?php print $problemPidArray[$i]; ?>" class="category-select" name="updatedCategory">
                                            <?php
                                            for ($j = 0; $j < count($categoryCidArray); $j++) {
                                                if ($categoryCidArray[$j] != '0') {
                                                    ?>
                                                    <option id="category-option-<?php print $problemPidArray[$i] . "-" . $j; ?>" class="category-option-<?php print $problemPidArray[$i]; ?>" <?php print $categoryNameArray[$j] == $category ? "selected='selected'" : ""; ?>><?php print $categoryNameArray[$j]; ?></option>
                                                    <?php
                                                } else { ?>
                                                    <option id="category-option-<?php print $problemPidArray[$i] . "-" . $j; ?>" class="category-option-<?php print $problemPidArray[$i]; ?>" <?php print $categoryNameArray[$j] == $category ? "selected='selected'" : ""; ?>>Choose a category...</option>
                                                <?php }
                                            } ?>
                                        </select>
                                    </td>
                                    <td id="edit-cell-<?php print $problemPidArray[$i] ?>" class="edit-column row-<?php print $problemPidArray[$i] ?>">
                                        <input id='edit-button-<?php print count($problemPidArray) - $i; ?>' class='edit-button btn btn-default' type='button' onClick='edit(<?php print count($problemPidArray) - $i; ?>);' value='Edit'/>
                                        <input id='save-changes-<?php print count($problemPidArray) - $i; ?>' class='save-changes btn btn-default' type='submit' onClick='save(<?php print count($problemPidArray) - $i; ?>);' value='Save'/>
                                    </td>
                                </form>
                            </tr>
                            <?php
                        } ?>
                    </table>
                </div>
                <div id="category-table-wrapper-2" class="col-lg-offset-9">
                    <div id="category-table-wrapper" class=" col-lg-3">
                        <form action="submitCategory.php">
                            <div class="form-group">
                                <label for="newCategory">Add a New Category</label>
                                <input type="text" class="form-control" id="newCategory" name="newCategoryName" placeholder="New Category Name">
                            </div>
                            <input id="new-category-submit-button" class="btn btn-default" type="submit" value="Submit"/>
                        </form>
                        <table id="category-table" class="table-bordered table-hover">
                            <thead id="category-table-thead">
                            <tr>
                                <th colspan="3">
                                    <p id="category-table-categories-title">Categories</p>
                                </th>
                            </tr>
                            <tr class="category-header-row">
                                <th class="category-id-column">
                                    <p id="category-table-category-cid-header" class="category-id-column">Id</p>
                                </th>
                                <th class="category-name-column">
                                    <p id="category-table-category-name-header" class="category-name-column">Category Name</p>
                                </th>
                                <th class="edit-column header-row category-edit-column">
                                    <p id="category-table-edit-category-header" class="category-edit-column">Edit</p>
                                </th>
                            </tr>
                            </thead>
                            <tbody id="category-table-tbody">
                            <?php for ($i = 0; $i < count($categoryCidArray); $i++) { ?>
                                <form id="save-content-changes-form-<?php print $categoryCidArray[$i]; ?>" class="save-content-changes-form" action="./updateCategory.php" method="get">
                                    <tr>
                                        <td id="cid-cell-<?php print $categoryCidArray[$i]; ?>" class="cid-column category-row-<?php print $categoryCidArray[$i]; ?> category-id-column"><p id="cid-<?php print $categoryCidArray[$i]; ?>"><?php print $categoryCidArray[$i]; ?></p></td>
                                        <input name="updatedCategoryCid" type="text" style="display: none;" value="<?php print $categoryCidArray[$i]; ?>"/>
                                        <td id="category-name-cell-<?php print $categoryCidArray[$i]; ?>" class="category-name-cell category-name-column">
                                            <p id="category-name-<?php print $categoryCidArray[$i]; ?>" class="category-name"><?php print $categoryNameArray[$i]; ?></p>
                                            <textarea id="edit-category-content-<?php print $categoryCidArray[$i]; ?>" class="edit-category-content" name="updatedCategoryName" onkeyup="auto_grow(this);"><?php print $categoryNameArray[$i]; ?></textarea>
                                        </td>
                                        <td id="category-edit-cell-<?php print $categoryCidArray[$i]; ?>" class="category-edit-cell category-edit-column">
                                            <?php if ($categoryCidArray[$i] != 0) { ?>
                                                <input id="edit-category-button-<?php print $categoryCidArray[$i]; ?>" class='edit-category-button btn btn-default' type='button' value='Edit' onclick="editCategory(<?php print $categoryCidArray[$i]; ?>);"/>
                                                <input id="save-category-button-<?php print $categoryCidArray[$i]; ?>" class="save-category-button btn btn-default" type="submit" value="Save"/>
                                            <?php } else { ?>
                                            <p>Default</p>
                                        </td>
                                        <?php } ?>
                                    </tr>
                                </form>
                                <?php
                            } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
    </html>
<?php
mysql_close($connection);
?>