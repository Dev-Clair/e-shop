<?php
// views/books/create.php

declare(strict_types=1);

use app\Form;

require_once __DIR__ . '/../../vendor/autoload.php';

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

foreach ($cartItems['item'] as $item) {
    /** Form Field: Cart Item */
    $newForm->formDiv(divID: "cartItem", divClass: "form-group mb-3");
    $newForm->formFileUploadInput(fileInputID: "cartItem", fileInputName: null, acceptFileType: "image/png", fileInputClass: "", multiple: null, fileInputValue: "");
    $newForm->formFieldInput(inputID: "cartItem", inputName: "", inputType: "number", value: "1", min: "1", max: "100");
}

/** Form Submit Button */
$newForm->formDiv(divID: "submitButton", divClass: "form-group mb-3");
$newForm->formButton(buttonID: "submitButton", buttonName: "proceedToCheckout", buttonType: "submit", buttonClass: "btn btn-sm btn-primary", buttonTitle: "Confirm Order(s)");

// Render Form
echo $newForm->render();
