<?php
// views/index.php (Home Controller)

use app\Form;

require_once __DIR__ . '/../vendor/autoload.php';

?>

<?php
// Instantiate Form Class
$newForm = new Form();
$newForm->createForm(formID: "searchBook", formName: "searchBook", formMethod: "post", formAction: $searchFormAction, enctype: null);
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

/** Form Field: Search Name or Phone Number */
$newForm->formDiv(divID: "search", divClass: "btn-group mb-3");
$newForm->formLabel(labelID: "search", labelClass: "form-label", labelTitle: "Search Book:");
$newForm->formFieldInput(inputID: "search", inputName: "search", inputType: "search", inputClass: "form-control mb-1", inputPlaceholder: "Enter book name");
if (isset($_SESSION['errors']['search'])) {
    $alertMsg = sprintf("%s", $_SESSION['errors']['search']);
    $newForm->fieldAlert(alertClass: "text-red is-invalid", alertMsg: $alertMsg);
}
unset($_SESSION['errors']);

/** Submit Search Button */
$newForm->formButton(buttonID: "searchButton", buttonName: "searchBook", buttonType: "submit", buttonClass: "btn btn-sm btn-success float-end", buttonTitle: "Search");

// // Render Form
echo $newForm->render();
?>

<div class="d-flex justify-content-left mt-3 mb-3">
    <!-- Create New Contact -->
    <a type="button" class="btn btn-primary rounded float-left" href="/cart/">Cart</a>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="btn-group mb-2" role="group" aria-label="Fetch Buttons">
            <!-- Add to Cart Button -->
            <button type="button" class="btn btn-sm btn-primary rounded me-2" onclick="">Add to Cart</button>
            <!-- Book Details Button trigger modal -->
            <button type="button" class="btn btn-sm btn-primary rounded me-2" data-bs-toggle="modal" data-bs-target="#showBookDetailsTableModal"><?= $bookDetails ?></button>
        </div>
    </div>
</div>


<!-- Book Details Table Modal -->
<div class="modal fade" id="showBookDetailsTableModal" tabindex="-1" aria-labelledby="showBookDetailsTableModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen">
        <div class="modal-content mx-3 px-3 my-4 py-3">
            <div class="modal-header">
                <h5 class="modal-title" id="showBookDetailsTableModalLabel"><strong><?= $bookTitle ?></strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 scrollable-container">
                <!-- Display Additional Book Info Here -->
            </div>
        </div>
    </div>
</div>