//When the document is ready...
$(document).ready(function () { //Do the following function...
    $('.edit').hide(); //Hide all the edit features.
});

//This is called when a user clicks the edit button for a question.
function editQuestion(index) {
    $('.view').show(); //Show all the view features.
    $('.edit').hide(); //Hide all the edit features.

    //The previous code was to disallow editing of multiple items at a time by resetting all of them back to "view" mode.

    //Hide the view-question features of the selected question.
    $('#question-content-' + index).hide();
    $('#edit-question-button-' + index).hide();

    //Show the edit-question features of the selected question.
    $('#edit-content-' + index).show();
    $('#save-question-changes-button-' + index).show();
    $('#category-select-' + index).show();

    autoGrowTextArea(document.getElementById('edit-content-' + index)); //Fix the size of the edit-question textarea.
}

//This is called when a user clicks the edit button for a category.
function editCategory(index) {
    $('.view').show(); //Show all the view features.
    $('.edit').hide(); //Hide all the edit features.

    //The previous code was to disallow editing of multiple items at a time by resetting all of them back to "view" mode.

    //Hide the view-category features of the selected category.
    $('#edit-category-button-' + index).hide();
    $('#category-name-' + index).hide();

    //Show the edit-category features of the selected category.
    $('#save-category-button-' + index).show();
    $('#edit-category-content-' + index).show();

    autoGrowTextArea(document.getElementById('edit-category-content-' + index)); //Fix the size of the edit-category textarea.
}

// This is called anytime the user adds text to a textarea.
function autoGrowTextArea(element) {
    element.style.height = 0; //Set the textarea's height to 0 to reset it.
    element.style.height = (element.scrollHeight) + "px"; //Set the textarea's height to its current scrollHeight. This allows the size of the textarea to dynamically adjust as you add more content.
}