<?php
// views/users/login.php (User Controller)

declare(strict_types=1);

use app\Utils\Form;
?>

<?php
if (isset($_SESSION['errorAlertMsg'])) {
    $errorAlertMsg = sprintf("%s", $_SESSION['errorAlertMsg']);
?>
    <div class="alert alert-danger"><?php echo $errorAlertMsg; ?></div>
<?php
}
unset($_SESSION['errorAlertMsg']);
?>

<?php
if (isset($_SESSION['successAlertMsg'])) {
    $successAlertMsg = sprintf("%s", $_SESSION['successAlertMsg']);
?>
    <div class="alert alert-success"><?php echo $successAlertMsg; ?></div>
<?php
}
unset($_SESSION['successAlertMsg']);
?>

<!-- Admin Register Form - Modal Trigger Button -->
<div class="text-end mt-3 mb-3">
    <button type="button" class="btn btn-sm btn-success rounded me-2" data-bs-toggle="modal" data-bs-target="#showAdminFormTableModal">Admin</button>
</div>

<!-- Login Form -->
<div>
    <h2>Log in</h2>
    <hr class="mb-3">

    <?php
    // Instantiate Form Class
    $newForm = new Form();
    $newForm->createForm(formID: "loginForm", formName: "loginForm", formMethod: "post", formAction: $loginFormAction, enctype: null);

    /** Form Field: Email */
    $newForm->formDiv(divID: "email", divClass: "form-group mb-3");
    $newForm->formLabel(labelID: "email", labelClass: "form-label", labelTitle: "Email:");
    $newForm->formFieldInput(inputID: "email", inputName: "loginEmail", inputType: "email", inputClass: "form-control", inputPlaceholder: "Enter email adddress");
    if (isset($_SESSION['errors']['loginEmail'])) {
        $alertMsg = sprintf("%s", $_SESSION['errors']['loginEmail']);
        $newForm->fieldAlert(alertClass: "text-danger", alertMsg: $alertMsg);
    }

    /** Form Field: Password */
    $newForm->formDiv(divID: "password", divClass: "form-group mb-3");
    $newForm->formLabel(labelID: "password", labelClass: "form-label", labelTitle: "Password:");
    $newForm->formFieldInput(inputID: "password", inputName: "loginPassword", inputType: "password", inputClass: "form-control", inputPlaceholder: "Enter password");
    if (isset($_SESSION['errors']['loginPassword'])) {
        $alertMsg = sprintf("%s", $_SESSION['errors']['loginPassword']);
        $newForm->fieldAlert(alertClass: "text-danger", alertMsg: $alertMsg);
    }

    unset($_SESSION['errors']);

    /** Customer Register Form - Modal Trigger Button */
    $newForm->formDiv(divID: "registerForm", divClass: "form-group mb-3");
    $newForm->formButton(buttonID: "registerForm", buttonType: "button", buttonClass: "btn btn-sm btn-success rounded me-2 float-end", buttonTitle: "Register", data_bs_target: "#showCustomerFormTableModal", data_bs_toggle: "modal");

    /** Submit Form Button */
    $newForm->formDiv(divID: "submitLoginForm", divClass: "form-group mb-3");
    $newForm->formButton(buttonID: "submitLoginForm", buttonName: "submitLoginForm", buttonType: "submit", buttonClass: "btn btn-sm btn-primary rounded me-2 float-end", buttonTitle: "Log in");

    // Render Form
    echo $newForm->render();
    ?>
</div>

<!-- Customer Register Form Modal -->
<div class="modal fade" id="showCustomerFormTableModal" tabindex="-1" aria-labelledby="showCustomerFormTableModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content mx-3 px-3 my-4 py-3">
            <div class="modal-header">
                <h5 class="modal-title" id="showCustomerFormTableModalLabel"><strong>Create New User Account</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 scrollable-container">
                <?php
                // Instantiate Form Class
                $newForm = new Form();
                $newForm->createForm(formID: "registerForm", formName: "registerForm", formMethod: "post", formAction: $registerFormAction, enctype: null);

                /** Form Field: Name */
                $newForm->formDiv(divID: "name", divClass: "form-group mb-3");
                $newForm->formLabel(labelID: "name", labelClass: "form-label", labelTitle: "Name:");
                $newForm->formFieldInput(inputID: "name", inputName: "name", inputType: "text", inputClass: "form-control", inputPlaceholder: "Enter first and last names");
                if (isset($_SESSION['errors']['name'])) {
                    $alertMsg = sprintf("%s", $_SESSION['errors']['name']);
                    $newForm->fieldAlert(alertClass: "text-danger", alertMsg: $alertMsg);
                }

                /** Form Field: Email */
                $newForm->formDiv(divID: "email", divClass: "form-group mb-3");
                $newForm->formLabel(labelID: "email", labelClass: "form-label", labelTitle: "Email:");
                $newForm->formFieldInput(inputID: "email", inputName: "registerEmail", inputType: "email", inputClass: "form-control", inputPlaceholder: "Enter email adddress");
                if (isset($_SESSION['errors']['registerEmail'])) {
                    $alertMsg = sprintf("%s", $_SESSION['errors']['registerEmail']);
                    $newForm->fieldAlert(alertClass: "text-danger", alertMsg: $alertMsg);
                }

                /** Form Field: Password */
                $newForm->formDiv(divID: "password", divClass: "form-group mb-3");
                $newForm->formLabel(labelID: "password", labelClass: "form-label", labelTitle: "Password:");
                $newForm->formFieldInput(inputID: "password", inputName: "registerPassword", inputType: "password", inputClass: "form-control", inputPlaceholder: "Enter password");
                if (isset($_SESSION['errors']['registerPassword'])) {
                    $alertMsg = sprintf("%s", $_SESSION['errors']['registerPassword']);
                    $newForm->fieldAlert(alertClass: "text-danger", alertMsg: $alertMsg);
                }

                /** Form Field: Confirm Password */
                $newForm->formDiv(divID: "confirm_password", divClass: "form-group mb-3");
                $newForm->formLabel(labelID: "confirm_password", labelClass: "form-label", labelTitle: "Confirm Password:");
                $newForm->formFieldInput(inputID: "confirm_password", inputName: "confirm_registerPassword", inputType: "password", inputClass: "form-control", inputPlaceholder: "Re-Enter password");
                if (isset($_SESSION['errors']['confirm_registerPassword'])) {
                    $alertMsg = sprintf("%s", $_SESSION['errors']['confirm_registerPassword']);
                    $newForm->fieldAlert(alertClass: "text-danger", alertMsg: $alertMsg);
                }

                /** Form Field: Address */
                $newForm->formDiv(divID: "address", divClass: "form-group mb-3");
                $newForm->formLabel(labelID: "address", labelClass: "form-label", labelTitle: "Address:");
                $newForm->formFieldInput(inputID: "address", inputName: "address", inputType: "text", inputClass: "form-control", inputPlaceholder: "Enter home or office address");
                if (isset($_SESSION['errors']['address'])) {
                    $alertMsg = sprintf("%s", $_SESSION['errors']['address']);
                    $newForm->fieldAlert(alertClass: "text-danger", alertMsg: $alertMsg);
                }

                unset($_SESSION['errors']);

                /** Submit Form Button */
                $newForm->formDiv(divID: "submitRegisterForm", divClass: "form-group mb-3");
                $newForm->formButton(buttonID: "submitRegisterForm", buttonName: "submitRegisterForm", buttonType: "submit", buttonClass: "btn btn-sm btn-primary float-end", buttonTitle: "submit");

                // Render Form
                echo $newForm->render();
                ?>
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
                <?php
                // Instantiate Form Class
                $newForm = new Form();
                $newForm->createForm(formID: "adminRegisterForm", formName: "adminRegisterForm", formMethod: "post", formAction: $registerFormAction, enctype: null);

                /** Form Field: Name */
                $newForm->formDiv(divID: "name", divClass: "form-group mb-3");
                $newForm->formLabel(labelID: "name", labelClass: "form-label", labelTitle: "Name:");
                $newForm->formFieldInput(inputID: "name", inputName: "name", inputType: "text", inputClass: "form-control", inputPlaceholder: "Enter first and last names");
                if (isset($_SESSION['errors']['name'])) {
                    $alertMsg = sprintf("%s", $_SESSION['errors']['name']);
                    $newForm->fieldAlert(alertClass: "text-danger", alertMsg: $alertMsg);
                }

                /** Form Field: Email */
                $newForm->formDiv(divID: "email", divClass: "form-group mb-3");
                $newForm->formLabel(labelID: "email", labelClass: "form-label", labelTitle: "Email:");
                $newForm->formFieldInput(inputID: "email", inputName: "registerEmail", inputType: "email", inputClass: "form-control", inputPlaceholder: "Enter email adddress");
                if (isset($_SESSION['errors']['registerEmail'])) {
                    $alertMsg = sprintf("%s", $_SESSION['errors']['registerEmail']);
                    $newForm->fieldAlert(alertClass: "text-danger", alertMsg: $alertMsg);
                }

                /** Form Field: Password */
                $newForm->formDiv(divID: "password", divClass: "form-group mb-3");
                $newForm->formLabel(labelID: "password", labelClass: "form-label", labelTitle: "Password:");
                $newForm->formFieldInput(inputID: "password", inputName: "registerPassword", inputType: "password", inputClass: "form-control", inputPlaceholder: "Enter password");
                if (isset($_SESSION['errors']['registerPassword'])) {
                    $alertMsg = sprintf("%s", $_SESSION['errors']['registerPassword']);
                    $newForm->fieldAlert(alertClass: "text-danger", alertMsg: $alertMsg);
                }

                /** Form Field: Confirm Password */
                $newForm->formDiv(divID: "confirm_password", divClass: "form-group mb-3");
                $newForm->formLabel(labelID: "confirm_password", labelClass: "form-label", labelTitle: "Confirm Password:");
                $newForm->formFieldInput(inputID: "confirm_password", inputName: "confirm_registerPassword", inputType: "password", inputClass: "form-control", inputPlaceholder: "Re-Enter password");
                if (isset($_SESSION['errors']['confirm_registerPassword'])) {
                    $alertMsg = sprintf("%s", $_SESSION['errors']['confirm_registerPassword']);
                    $newForm->fieldAlert(alertClass: "text-danger", alertMsg: $alertMsg);
                }

                /** Form Field: Address */
                $newForm->formDiv(divID: "address", divClass: "form-group mb-3");
                $newForm->formLabel(labelID: "address", labelClass: "form-label", labelTitle: "Address:");
                $newForm->formFieldInput(inputID: "address", inputName: "address", inputType: "text", inputClass: "form-control", inputPlaceholder: "Enter home or office address");
                if (isset($_SESSION['errors']['address'])) {
                    $alertMsg = sprintf("%s", $_SESSION['errors']['address']);
                    $newForm->fieldAlert(alertClass: "text-danger", alertMsg: $alertMsg);
                }

                /** Form Field: Pass Key */
                $newForm->formDiv(divID: "passkey", divClass: "form-group mb-3");
                $newForm->formLabel(labelID: "passkey", labelClass: "form-label", labelTitle: "Admin Passkey:");
                $newForm->formFieldInput(inputID: "passkey", inputName: "passkey", inputType: "text", inputClass: "form-control", inputPlaceholder: "Enter secure passkey : 'ADMIN'");
                if (isset($_SESSION['errors']['passkey'])) {
                    $alertMsg = sprintf("%s", $_SESSION['errors']['passkey']);
                    $newForm->fieldAlert(alertClass: "text-danger", alertMsg: $alertMsg);
                }

                unset($_SESSION['errors']);

                /** Submit Form Button */
                $newForm->formDiv(divID: "submitRegisterForm", divClass: "form-group mb-3");
                $newForm->formButton(buttonID: "submitRegisterForm", buttonName: "submitRegisterForm", buttonType: "submit", buttonClass: "btn btn-sm btn-primary float-end", buttonTitle: "submit");

                // Render Form
                echo $newForm->render();
                ?>
            </div>
        </div>
    </div>
</div>