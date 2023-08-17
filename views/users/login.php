<?php
// views/users/login.php

use app\Form;

// require_once __DIR__ . '/../vendor/autoload.php';

?>

<?
if (isset($_SESSION['errorAlertMsg'])) {
    $errorAlertMsg = sprintf("%s", $_SESSION['errorAlertMsg']);
?>
    <div class="danger"><? echo $errorAlertMsg; ?></div>
<?
}
unset($_SESSION['errorAlertMsg']);
?>

<?
if (isset($_SESSION['successAlertMsg'])) {
    $successAlertMsg = sprintf("%s", $_SESSION['successAlertMsg']);
?>
    <div class="success"><? echo $successAlertMsg; ?></div>
<?
}
unset($_SESSION['successAlertMsg']);
?>

<div class="d-flex justify-content-left mt-3 mb-3">
    <!-- Create New Contact -->
    <a type="button" class="btn btn-primary rounded float-left" href="/e-shop/users/">Admin</a>
</div>

<div class="text-center">
    <h4>Log in</h4>

    <?php
    // Instantiate Form Class
    $newForm = new Form();
    $newForm->createForm(formID: "loginForm", formName: "loginForm", formMethod: "post", formAction: $loginFormAction, enctype: null);

    /** Form Field: Email */
    $newForm->formDiv(divID: "email", divClass: "btn-group mb-3");
    $newForm->formLabel(labelID: "email", labelClass: "form-label", labelTitle: "Email:");
    $newForm->formFieldInput(inputID: "email", inputName: "email", inputType: "email", inputClass: "form-control mb-1", inputPlaceholder: "Enter email adddress");
    if (isset($_SESSION['errors']['email'])) {
        $alertMsg = sprintf("%s", $_SESSION['errors']['email']);
        $newForm->fieldAlert(alertClass: "text-red", alertMsg: $alertMsg);
    }

    /** Form Field: Password */
    $newForm->formDiv(divID: "password", divClass: "btn-group mb-3");
    $newForm->formLabel(labelID: "password", labelClass: "form-label", labelTitle: "Password:");
    $newForm->formFieldInput(inputID: "password", inputName: "password", inputType: "password", inputClass: "form-control mb-1", inputPlaceholder: "Enter password");
    if (isset($_SESSION['errors']['password'])) {
        $alertMsg = sprintf("%s", $_SESSION['errors']['password']);
        $newForm->fieldAlert(alertClass: "text-red", alertMsg: $alertMsg);
    }

    unset($_SESSION['errors']);

    /** Submit Search Button */
    $newForm->formButton(buttonID: "submitLoginForm", buttonName: "submitLoginForm", buttonType: "submit", buttonClass: "btn btn-sm btn-success float-end", buttonTitle: "Log in");

    // Render Form
    echo $newForm->render();
    ?>
</div>

<!-- Book Details Button trigger modal -->
<button type="button" class="btn btn-sm btn-primary rounded me-2" data-bs-toggle="modal" data-bs-target="#showCustomerFormTableModal">New Account</button>


<!-- Customer Register Form Modal -->
<div class="modal fade" id="showCustomerFormTableModal" tabindex="-1" aria-labelledby="showCustomerFormTableModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content mx-3 px-3 my-4 py-3">
            <div class="modal-header">
                <h5 class="modal-title" id="showCustomerFormTableModalLabel"><strong>Create New Account</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 scrollable-container">
                <!-- Display Form Here -->
            </div>
        </div>
    </div>
</div>

<!-- Admin Registration Form Modal -->
<div class="modal fade" id="showAdminFormTableModal" tabindex="-1" aria-labelledby="showAdminFormTableModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content mx-3 px-3 my-4 py-3">
            <div class="modal-header">
                <h5 class="modal-title" id="showAdminFormTableModalLabel"><strong>Create New Admin Account</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 scrollable-container">
                <!-- Display Form Here -->
            </div>
        </div>
    </div>
</div>