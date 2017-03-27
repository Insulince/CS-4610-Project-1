$(document).ready(function () {
    $('.edit-content').hide();
    $('.save-changes').hide();
    $('.category-select').hide();

    $('.edit-category-content').hide();
    $('.save-category-button').hide();
});

function edit(index) {
    $('.question-content').show();
    $('.edit-button').show();
    $('.categories').show();

    $('.edit-content').hide();
    $('.save-changes').hide();
    $('.category-select').hide();

    $('#question-content-' + index).hide();
    $('#edit-button-' + index).hide();
    $('#categories-' + index).hide();

    $('#edit-content-' + index).show();
    $('#save-changes-' + index).show();
    $('#category-select-' + index).show();

    auto_grow(document.getElementById('edit-content-' + index));
}

function save(index) {
    $('#question-content-' + index).show();
    $('#edit-button-' + index).show();

    $('#question-content-' + index).text($('#edit-content-' + index).val());

    $('#edit-content-' + index).hide();
    $('#save-changes-' + index).hide();
}

function auto_grow(element) {
    element.style.height = "5px";
    element.style.height = (element.scrollHeight) + "px";
}

function editCategory(index) {
    $('.edit-category-button').show();
    $('.category-name').show();
    
    $('.save-category-button').hide();
    $('.edit-category-content').hide();
    
    $('#edit-category-button-' + index).hide();
    $('#category-name-' + index).hide();
    
    $('#save-category-button-' + index).show();
    $('#edit-category-content-' + index).show();
}