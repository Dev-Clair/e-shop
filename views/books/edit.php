<?php
// views/books/edit.php

declare(strict_types=1);

use app\Utils\Form;

// Instantiate Form Class
$newForm = new Form();

$newForm->createForm(formID: "editBook", formName: "editBook", formMethod: "post", formAction: $formAction, enctype: "multipart/form-data");

/** Form File Upload: Book Cover Image */
$newForm->formDiv(divID: "book_cover_image", divClass: "form-group mb-3");
$newForm->formLabel(labelID: "book_cover_image", labelClass: "form-label", labelTitle: "Click to Upload an Image:");
$newForm->formFileUploadInput(fileInputID: "book_cover_image", fileInputName: "book_cover_image", acceptFileType: "image/png", fileInputClass: "form-control", multiple: null, disabled: "disabled", fileInputValue: null);
if (isset($_SESSION['errors']['book_cover_image'])) {
    $alertMsg = sprintf("%s", $_SESSION['errors']['book_cover_image']);
    $newForm->fieldAlert(alertClass: "text-danger", alertMsg: $alertMsg);
}

/** Form Field: Book ID */
$newForm->formFieldInput(inputID: "book_id", inputName: "book_id", inputType: "hidden", value: $book['book_id']);

/** Form Field: Book Title */
$newForm->formDiv(divID: "book_title", divClass: "form-group mb-3");
$newForm->formLabel(labelID: "book_title", labelClass: "form-label", labelTitle: "Book Title:");
$newForm->formFieldInput(inputID: "book_title", inputName: "book_title", inputType: "text", inputClass: "form-control", inputPlaceholder: "Enter book title", value: $book['book_title']);
if (isset($_SESSION['errors']['book_title'])) {
    $alertMsg = sprintf("%s", $_SESSION['errors']['book_title']);
    $newForm->fieldAlert(alertClass: "text-danger", alertMsg: $alertMsg);
}

unset($_SESSION['errors']);

/** Form Submit Button */
$newForm->formDiv(divID: "submitButton", divClass: "form-group mb-3");
$newForm->formButton(buttonID: "submitButton", buttonName: "submiteditBook", buttonType: "submit", buttonClass: "btn btn-sm btn-primary", buttonTitle: "Update Book");

// Render Form
echo $newForm->render();
