<?php
// views/books/edit.php (Book Controller)

declare(strict_types=1);

use app\Utils\Form;

// Instantiate Form Class
$newForm = new Form();

$newForm->createForm(formID: "editBook", formName: "editBook", formMethod: "post", formAction: $editFormAction, enctype: "multipart/form-data");

/** Form Field: Book ID */
$newForm->formFieldInput(inputID: "book_id", inputName: "book_id", inputType: "hidden", value: $book['book_id']);

echo "<h4>Update Book: <strong>{$book['book_title']}</strong></h4>";

/** Form Field: Book Title */
$newForm->formDiv(divID: "title", divClass: "form-group mb-3");
$newForm->formLabel(labelID: "title", labelClass: "form-label", labelTitle: "Book Title:");
$newForm->formFieldInput(inputID: "title", inputName: "book_title", inputType: "text", inputClass: "form-control", inputPlaceholder: "Enter book title", value: $book['book_title']);
if (isset($_SESSION['errors']['book_title'])) {
    $alertMsg = sprintf("%s", $_SESSION['errors']['book_title']);
    $newForm->fieldAlert(alertClass: "text-danger", alertMsg: $alertMsg);
}

/** Form Field: Book Author */
$newForm->formDiv(divID: "author", divClass: "form-group mb-3");
$newForm->formLabel(labelID: "author", labelClass: "form-label", labelTitle: "Book Author:");
$newForm->formFieldInput(inputID: "author", inputName: "book_author", inputType: "text", inputClass: "form-control", inputPlaceholder: "Enter book author(s)", value: $book['book_author']);
if (isset($_SESSION['errors']['book_author'])) {
    $alertMsg = sprintf("%s", $_SESSION['errors']['book_author']);
    $newForm->fieldAlert(alertClass: "text-danger", alertMsg: $alertMsg);
}

/** Form Field: Book Edition */
$newForm->formDiv(divID: "edition", divClass: "form-group mb-3");
$newForm->formLabel(labelID: "edition", labelClass: "form-label", labelTitle: "Book Edition:");
$newForm->formFieldInput(inputID: "edition", inputName: "book_edition", inputType: "text", inputClass: "form-control", inputPlaceholder: "Enter book edition", value: $book['book_edition']);
if (isset($_SESSION['errors']['book_edition'])) {
    $alertMsg = sprintf("%s", $_SESSION['errors']['book_edition']);
    $newForm->fieldAlert(alertClass: "text-danger", alertMsg: $alertMsg);
}

/** Form Field: Book Price */
$newForm->formDiv(divID: "price", divClass: "form-group mb-3");
$newForm->formLabel(labelID: "price", labelClass: "form-label", labelTitle: "Book Price:");
$newForm->formFieldInput(inputID: "price", inputName: "book_price", inputType: "text", inputClass: "form-control", inputPlaceholder: "Enter book price", value: $book['book_price']);
if (isset($_SESSION['errors']['book_price'])) {
    $alertMsg = sprintf("%s", $_SESSION['errors']['book_price']);
    $newForm->fieldAlert(alertClass: "text-danger", alertMsg: $alertMsg);
}

/** Form Field: Book Quantity */
$newForm->formDiv(divID: "qty", divClass: "form-group mb-3");
$newForm->formLabel(labelID: "qty", labelClass: "form-label", labelTitle: "Book Quantity:");
$newForm->formFieldInput(inputID: "qty", inputName: "book_qty", inputType: "text", inputClass: "form-control", inputPlaceholder: "Enter book quantity", value: $book['book_qty']);
if (isset($_SESSION['errors']['book_qty'])) {
    $alertMsg = sprintf("%s", $_SESSION['errors']['book_qty']);
    $newForm->fieldAlert(alertClass: "text-danger", alertMsg: $alertMsg);
}

/** Form Field: Book Publication Date */
$newForm->formDiv(divID: "publication_date", divClass: "form-group mb-3");
$newForm->formLabel(labelID: "publication_date", labelClass: "form-label", labelTitle: "Book Publication Date:");
$newForm->formFieldInput(inputID: "publication_date", inputName: "book_publication_date", inputType: "date", inputClass: "form-control", inputPlaceholder: "Enter book publication date", value: $book['book_publication_date']);
if (isset($_SESSION['errors']['book_publication_date'])) {
    $alertMsg = sprintf("%s", $_SESSION['errors']['book_publication_date']);
    $newForm->fieldAlert(alertClass: "text-danger", alertMsg: $alertMsg);
}

unset($_SESSION['errors']);

/** Form Submit Button */
$newForm->formDiv(divID: "submitButton", divClass: "form-group mb-3");
$newForm->formButton(buttonID: "submitButton", buttonName: "submiteditBook", buttonType: "submit", buttonClass: "btn btn-sm btn-primary float-end", buttonTitle: "Update");

// Render Form
echo $newForm->render();
