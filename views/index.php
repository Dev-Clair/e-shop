<?php
// views/index.php (Home Controller)

use app\Form;

require_once __DIR__ . '/../vendor/autoload.php';

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

<?php
// Instantiate Form Class
$newForm = new Form();
$newForm->createForm(formID: "searchBook", formName: "searchBook", formMethod: "post", formAction: $searchFormAction, enctype: "multipart/form-data");

/** Form Field: Search Name or Phone Number */
$newForm->formDiv(divID: "search", divClass: "btn-group mb-3");
$newForm->formLabel(labelID: "search", labelClass: "form-label", labelTitle: "Search:");
$newForm->formFieldInput(inputID: "search", inputName: "search", inputType: "search", inputClass: "form-control mb-1", inputPlaceholder: "Enter book title or author name");
if (isset($_SESSION['errors']['search'])) {
    $alertMsg = sprintf("%s", $_SESSION['errors']['search']);
    $newForm->fieldAlert(alertClass: "text-red", alertMsg: $alertMsg);
}
unset($_SESSION['errors']);

/** Submit Search Button */
$newForm->formButton(buttonID: "searchButton", buttonName: "searchBook", buttonType: "submit", buttonClass: "btn btn-sm btn-success float-end", buttonTitle: "Search");

// Render Form
echo $newForm->render();
?>

<div class="d-flex justify-content-left mt-3 mb-3">
    <!-- Create New Contact -->
    <a type="button" class="btn btn-primary rounded float-left" href="/e-shop/cart">View Cart</a>
</div>

<?
foreach ($books as $book) {
?>
    <div class="row">
        <div class="col-md-12">
            <div class="btn-group mb-2" role="group" aria-label="Fetch Buttons">
                <!-- Display Book -->
                <?php
                // Instantiate Form Class
                $newForm = new Form();
                $newForm->createForm(formID: "cartForm", formName: "cartForm", formMethod: "post", formAction: $cartFormAction, enctype: "multipart/form-data");

                $newForm->formDiv(divID: "book", divClass: "btn-group mb-3");

                /** Add Hidden Form Input: Book_ID */
                $newForm->formFieldInput(inputID: "book", inputType: "hidden", value: $book['book_id']);

                /** Add to Cart Submit Button */
                $newForm->formButton(buttonID: "addToCart", buttonName: "addToCart", buttonType: "submit", buttonClass: "btn btn-sm btn-success rounded me-2", buttonTitle: "Add to Cart");

                // Render Form
                echo $newForm->render();
                ?>
                <!-- Book Details Button trigger modal -->
                <button type="button" class="btn btn-sm btn-primary rounded me-2" data-bs-toggle="modal" data-bs-target="#showBookDetailsTableModal">More Details</button>
            </div>
        </div>
    </div>
<?
}
?>

<!-- Add to Cart Button -->
<!-- <button type="button" class="btn btn-sm btn-primary rounded me-2" onclick="">Add to Cart</button> -->

<!-- Book Details Table Modal -->
<div class="modal fade" id="showBookDetailsTableModal" tabindex="-1" aria-labelledby="showBookDetailsTableModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content mx-3 px-3 my-4 py-3">
            <div class="modal-header">
                <h5 class="modal-title" id="showBookDetailsTableModalLabel"><strong><? echo $book['book_title']; ?></strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 scrollable-container">
                <!-- Display Additional Book Info Here -->
            </div>
        </div>
    </div>
</div>