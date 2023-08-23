<?php
// views/cart/index.php

declare(strict_types=1);

use app\Form;

require_once __DIR__ . '/../../vendor/autoload.php';

// Instantiate Form Class
$newForm = new Form();

$newForm->createForm(formID: "createCart", formName: "createCart", formMethod: "post", formAction: $cartformAction, enctype: "multipart/form-data");

foreach ($cartItems['item'] as $item) {
    /** Form Field: Cart Item */
    $newForm->formDiv(divID: "cartItem", divClass: "form-group mb-3");

    // Display Image Here
    echo "<img src=\"./books/book_cover_imageJ.png\" alt=\"sample_img\" class=\"mb-2\">";

    $newForm->formFieldInput(inputID: "cartItem", inputName: "", inputType: "number", inputClass: "form-inline", value: "1", min: "1", max: "100");
}

/** Form Submit Button */
$newForm->formDiv(divID: "submitCartItem", divClass: "form-group mb-3");
$newForm->formButton(buttonID: "submitCartItem", buttonName: "proceedToCheckout", buttonType: "submit", buttonClass: "btn btn-sm btn-primary", buttonTitle: "Confirm Order(s)");

// Render Form
echo $newForm->render();
