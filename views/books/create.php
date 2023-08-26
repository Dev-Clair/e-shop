<?php
// views/books/create.php

declare(strict_types=1);

use app\Form;

// Instantiate Form Class
$newForm = new Form();

$newForm->createForm(formID: "createBook", formName: "createBook", formMethod: "post", formAction: $formAction, enctype: "multipart/form-data");
if (isset($_SESSION['errorAlertMsg'])) {
    $errorAlertMsg = sprintf("%s", $_SESSION['errorAlertMsg']);
    $newForm->statusAlert("danger", $errorAlertMsg);
}
unset($_SESSION['errorAlertMsg']);

if (isset($_SESSION['successAlertMsg'])) {
    $successAlertMsg = sprintf("%s", $_SESSION['successAlertMsg']);
    $newForm->statusAlert("success", $successAlertMsg);
}
unset($_SESSION['successAlertMsg']);

/** Form File Upload: Book Image */
$newForm->formDiv(divID: "image", divClass: "form-group mb-3");
$newForm->formLabel(labelID: "image", labelClass: "form-label", labelTitle: "Click to upload an Image:");
$newForm->formFileUploadInput(fileInputID: "image", fileInputName: "image", acceptFileType: "image/png", fileInputClass: "form-control", multiple: null, disabled: "disabled", fileInputValue: null);
if (isset($_SESSION['errors']['image'])) {
    $alertMsg = sprintf("%s", $_SESSION['errors']['image']);
    $newForm->fieldAlert(alertClass: "text-red is-invalid", alertMsg: $alertMsg);
}

/** Form Field: Book Title */
$newForm->formDiv(divID: "title", divClass: "form-group mb-3");
$newForm->formLabel(labelID: "title", labelClass: "form-label", labelTitle: "Book Title:");
$newForm->formFieldInput(inputID: "title", inputName: "title", inputType: "text", inputClass: "form-control", inputPlaceholder: "Enter book title");
if (isset($_SESSION['errors']['title'])) {
    $alertMsg = sprintf("%s", $_SESSION['errors']['title']);
    $newForm->fieldAlert(alertClass: "text-red is-invalid", alertMsg: $alertMsg);
}


unset($_SESSION['errors']);

/** Form Submit Button */
$newForm->formDiv(divID: "submitButton", divClass: "form-group mb-3");
$newForm->formButton(buttonID: "submitButton", buttonName: "submitcreateBook", buttonType: "submit", buttonClass: "btn btn-sm btn-primary", buttonTitle: "Add Book");

// Render Form
echo $newForm->render();
