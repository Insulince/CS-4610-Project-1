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

//Get all the problems in the problem table, order by most recent first.
$problemPidArray = array();
$problemContentArray = array();
$query = "SELECT `pid`, `content` FROM `problem` ORDER BY `pid` DESC;";
$result = mysql_query($query);
while ($row = mysql_fetch_assoc($result)) {
    $problemPidArray[] = $row['pid'];
    $problemContentArray[] = $row['content'];
}

//Get all the categories from the category table.
$categoryCidArray = array();
$categoryNameArray = array();
$query = "SELECT `cid`, `name` FROM `category`;";
$result = mysql_query($query);
while ($row = mysql_fetch_assoc($result)) {
    $categoryCidArray[] = $row['cid'];
    $categoryNameArray[] = $row['name'];
}

//Get all the problem-category-mappings from the prob_cat_mapping table.
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

//Display a different set of problems is the "selectedCategory" GET parameter was set.
$selectedCategory = "{NO CATEGORY}";
if (isset($_GET['selectedCategory'])) {
    $selectedCategoryId = "-1";
    $selectedCategory = $_GET['selectedCategory'];

    for ($i = 0; $i < count($categoryCidArray); $i++) { //For every category...
        if ($categoryNameArray[$i] == $_GET['selectedCategory']) { //If the current category matches the requested category...
            $selectedCategoryId = $categoryCidArray[$i]; //Record that.
        }
    }

    if ($selectedCategoryId != -1) { //If we found the category that the user searched for...
        $tmpProblemIdArray = array();
        $query = "SELECT `problem_id`, `category_id` FROM `prob_cat_mapping` WHERE category_id = '$selectedCategoryId'"; //Record all the IDs of problems which have the given category id, from the prob_cat_mapping table.
        $result = mysql_query($query);
        while ($row = mysql_fetch_assoc($result)) {
            $tmpProblemIdArray[] = $row['problem_id'];
        }

        //Re-create the problem arrays but only include those problems who share the category with the requested category.
        $problemPidArray = array();
        $problemContentArray = array();
        $query = "SELECT `pid`, `content` FROM `problem` WHERE `pid` IN(" . implode(',', $tmpProblemIdArray) . ") ORDER BY `pid` DESC;"; //Get all the problems from the problem table where the id of the problem is in the array of problems who share a category with the selected category, order by most recent first.
        $result = mysql_query($query);
        if ($result) { //If anything was returned...
            while ($row = mysql_fetch_assoc($result)) {
                $problemPidArray[] = $row['pid'];
                $problemContentArray[] = $row['content'];
            }
        }
    } else { //If we did not find the category that the user searched for...
        die('Unknown category "' . $_GET['selectedCategory'] . '"! Exiting.');
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
                <div class="col-lg-9">
                    <h1 id="title">Math Problems</h1>
                </div>
                <div class="ol-lg-3">
                    <div class="selected-category-wrapper">
                        <h4 class="selected-category">Selected Category:</h4>
                        <a href="?selectedCategory=<?php print $selectedCategory; ?>" class="btn btn-info category-button selected-category"><?php print $selectedCategory; ?></a>
                        <?php if ($selectedCategory != "{NO CATEGORY}") { //Show the remove button if the user has a category filter. ?>
                            <a href="index.php" class="btn btn-danger">Remove</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div id="question-and-category-row" class="row">
                <div id="content-table-wrapper" class="col-lg-9">
                    <form id="add-new-question-form" action="insertNewQuestion.php" method="get">
                        <div class="form-group">
                            <label for="newQuestionContent">Add a New Question</label>
                            <input id="new-question-content" class="form-control" type="text" name="newQuestionContent" placeholder="New Question Content"/>
                        </div>
                        <input id="new-question-submit-button" class="btn btn-primary" type="submit" value="Submit"/>
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
                        for ($i = 0; $i < count($problemPidArray); $i++) { //For every problem in the problem array... ?>
                            <tr>
                                <form class='save-changes-form' action="./updateQuestion.php" method="get">
                                    <input name="updatedQuestionPid" type="hidden" value="<?php print $problemPidArray[$i] ?>"/>
                                    <td>
                                        <p><?php print $problemPidArray[$i]; ?></p>
                                    </td>
                                    <td class="content-column">
                                        <div id="question-content-<?php print $problemPidArray[$i]; ?>" class="question-content view-question view"><?php print $problemContentArray[$i]; ?></div>
                                        <textarea id="edit-content-<?php print $problemPidArray[$i]; ?>" class="edit-content edit-question edit" name='updatedQuestionContent' onkeyup="autoGrowTextArea(this);"><?php print $problemContentArray[$i]; ?></textarea>
                                    </td>
                                    <td class="category-column">
                                        <?php
                                        $categoriesForThisProblem = array();
                                        for ($j = 0; $j < count($probcatmappingPcmidArray); $j++) { //For every item in the prob_cat_mapping table...
                                            if ($problemPidArray[$i] == $probcatmappingProblemIdArray[$j]) { //If the current problem's id matches the current problem id in prob_cat_mapping...
                                                $categoriesForThisProblem[] = $categoryNameArray[$probcatmappingCategoryIdArray[$j]]; //Add it to the array.
                                            }
                                        }

                                        if (count($categoriesForThisProblem) > 1) { //If more than "{NO CATEGORY}" is in the array...
                                            for ($j = 0; $j < count($categoriesForThisProblem); $j++) { //For every item in the array...
                                                if ($categoriesForThisProblem[$j] == "{NO CATEGORY}") { //If this item is "{NO CATEGORY}"
                                                    array_splice($categoriesForThisProblem, $j, 1); //Remove {NO CATEGORY} from the array. This only affects whats visible, the DB still contains it. Thus, when a user clicks the {NO CATEGORY} button, these problems still pop up, which seems counter intuitive, but {NO CATEGORY} is supposed to show all current problems, so think of it that way.
                                                }
                                            }
                                        }

                                        if (count($categoriesForThisProblem) == 0) { //If the array remained empty (this problem has NOT mapping in the prob_cat_mapping table)...
                                            $categoriesForThisProblem[] = "{NO CATEGORY}"; //Initialize to the default value.

                                            $query = "INSERT INTO `prob_cat_mapping` (`problem_id`, `category_id`) VALUES('$problemPidArray[$i]', '0')"; //Insert this (default) relationship into the prob_cat_mapping table.

                                            $result = mysql_query($query); //Execute the query.
                                        }

                                        for ($j = 0; $j < count($categoriesForThisProblem); $j++) { //For every category connected to this problem... ?>
                                            <a href="?selectedCategory=<?php print $categoriesForThisProblem[$j]; ?>" class="btn btn-info category-button"><?php print $categoriesForThisProblem[$j]; ?></a>
                                            <?php
                                        }
                                        ?>
                                        <select id="category-select-<?php print $problemPidArray[$i]; ?>" class="category-select edit-question edit" name="updatedCategoryName">
                                            <?php
                                            for ($j = 0; $j < count($categoryCidArray); $j++) { //For every category in the category array...
                                                if ($categoryCidArray[$j] != '0') { //If this is not the default category ("{NO CATEGORY}")...
                                                    ?>
                                                    <option><?php print $categoryNameArray[$j]; ?></option>
                                                    <?php
                                                } else { //Otherwise... ?>
                                                    <option selected="selected">Choose a category...</option>
                                                <?php }
                                            } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input id="edit-question-button-<?php print $problemPidArray[$i]; ?>" class='edit-question-button btn btn-primary view-question view' type='button' onClick='editQuestion(<?php print count($problemPidArray) - $i; ?>);' value='Edit'/>
                                        <input id="save-question-changes-button-<?php print $problemPidArray[$i]; ?>" class='save-question-changes-button btn btn-primary edit-question edit' type='submit' value='Save'/>
                                    </td>
                                </form>
                            </tr>
                            <?php
                        } ?>
                    </table>
                </div>
                <div id="category-table-wrapper-2" class="col-lg-offset-9">
                    <div id="category-table-wrapper" class=" col-lg-3">
                        <form action="insertNewCategory.php">
                            <div class="form-group">
                                <label for="newCategory">Add a New Category</label>
                                <input type="text" class="form-control" id="new-category" name="newCategoryName" placeholder="New Category Name">
                            </div>
                            <input id="new-category-submit-button" class="btn btn-primary" type="submit" value="Submit"/>
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
                            <?php for ($i = 0; $i < count($categoryCidArray); $i++) { //For every category in the category table... ?>
                                <form class="save-content-changes-form" action="./updateCategory.php" method="get">
                                    <tr>
                                        <input name="updatedCategoryCid" type="hidden" value="<?php print $categoryCidArray[$i]; ?>"/>
                                        <td class="category-id-column">
                                            <p><?php print $categoryCidArray[$i]; ?></p>
                                        </td>
                                        <td class="category-name-cell category-name-column">
                                            <a id="category-name-<?php print $categoryCidArray[$i]; ?>" href="?selectedCategory=<?php print $categoryNameArray[$i]; ?>" class="btn btn-info category-button category-name view-category view"><?php print $categoryNameArray[$i]; ?></a>
                                            <textarea id="edit-category-content-<?php print $categoryCidArray[$i]; ?>" class="edit-category-content edit-category edit" name="updatedCategoryName" onkeyup="autoGrowTextArea(this);"><?php print $categoryNameArray[$i]; ?></textarea>
                                        </td>
                                        <td class="category-edit-cell category-edit-column">
                                            <?php if ($categoryCidArray[$i] != 0) { //If this is the default category... ?>
                                                <input id="edit-category-button-<?php print $categoryCidArray[$i]; ?>" class='edit-category-button btn btn-primary view-category view' type='button' value='Edit' onclick="editCategory(<?php print $categoryCidArray[$i]; ?>);"/>
                                                <input id="save-category-button-<?php print $categoryCidArray[$i]; ?>" class="save-category-changes-button btn btn-primary edit-category edit" type="submit" value="Save"/>
                                            <?php } else { //Otherwise... ?>
                                                <p>Default</p>
                                            <?php } ?>
                                        </td>
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