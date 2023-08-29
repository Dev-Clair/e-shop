<?php
// views/books/show.php (Book Controller)

declare(strict_types=1);

use app\Utils\Form;

?>

<!-- Alerts :: Danger | Success -->
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

<!-- Display :: Search Field -->
<?php
// Instantiate Form Class
$newForm = new Form();
$newForm->createForm(formID: "searchBook", formName: "searchBook", formMethod: "post", formAction: $adminSearchFormAction, enctype: "multipart/form-data");

/** Form Field: Search Book */
$newForm->formDiv(divID: "searchBook", divClass: "form-goup mb-3");
$newForm->formFieldInput(inputID: "searchBook", inputName: "searchBook", inputType: "search", inputClass: "form-control me-2", inputPlaceholder: "&#128269 Search...");

// Render Form
echo $newForm->render();
?>

<!-- Create Book Form - Modal Trigger Button -->
<div class="text-end mt-3 mb-3">
    <button type="button" class="btn btn-sm btn-primary rounded me-2" data-bs-toggle="modal" data-bs-target="#showBookFormTableModal">Create</button>
</div>

<!-- Create Book Form Modal -->
<div class="modal fade" id="showBookFormTableModal" tabindex="-1" aria-labelledby="showBookFormTableModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content mx-3 px-3 my-4 py-3">
            <div class="modal-header">
                <h5 class="modal-title" id="showBookFormTableModalLabel"><strong>Create New Book</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 scrollable-container">
                <?php
                // Instantiate Form Class
                $newForm = new Form();

                $newForm->createForm(formID: "createBook", formName: "createBook", formMethod: "post", formAction: $createFormAction, enctype: "multipart/form-data");

                /** Form File Upload: Book Image */
                $newForm->formDiv(divID: "image", divClass: "form-group mb-3");
                $newForm->formLabel(labelID: "image", labelClass: "form-label", labelTitle: "Click to upload an Image:");
                $newForm->formFileUploadInput(fileInputID: "image", fileInputName: "book_cover_image", acceptFileType: "image/png", fileInputClass: "form-control", multiple: null, disabled: "disabled", fileInputValue: null);
                if (isset($_SESSION['errors']['book_cover_image'])) {
                    $alertMsg = sprintf("%s", $_SESSION['errors']['book_cover_image']);
                    $newForm->fieldAlert(alertClass: "text-danger", alertMsg: $alertMsg);
                }

                /** Form Field: Book Title */
                $newForm->formDiv(divID: "title", divClass: "form-group mb-3");
                $newForm->formLabel(labelID: "title", labelClass: "form-label", labelTitle: "Book Title:");
                $newForm->formFieldInput(inputID: "title", inputName: "book_title", inputType: "text", inputClass: "form-control", inputPlaceholder: "Enter book title");
                if (isset($_SESSION['errors']['book_title'])) {
                    $alertMsg = sprintf("%s", $_SESSION['errors']['book_title']);
                    $newForm->fieldAlert(alertClass: "text-danger", alertMsg: $alertMsg);
                }

                /** Form Field: Book Author */
                $newForm->formDiv(divID: "author", divClass: "form-group mb-3");
                $newForm->formLabel(labelID: "author", labelClass: "form-label", labelTitle: "Book Author:");
                $newForm->formFieldInput(inputID: "author", inputName: "book_author", inputType: "text", inputClass: "form-control", inputPlaceholder: "Enter book author(s)");
                if (isset($_SESSION['errors']['book_author'])) {
                    $alertMsg = sprintf("%s", $_SESSION['errors']['book_author']);
                    $newForm->fieldAlert(alertClass: "text-danger", alertMsg: $alertMsg);
                }

                /** Form Field: Book Edition */
                $newForm->formDiv(divID: "edition", divClass: "form-group mb-3");
                $newForm->formLabel(labelID: "edition", labelClass: "form-label", labelTitle: "Book Edition:");
                $newForm->formFieldInput(inputID: "edition", inputName: "book_edition", inputType: "text", inputClass: "form-control", inputPlaceholder: "Enter book edition");
                if (isset($_SESSION['errors']['book_edition'])) {
                    $alertMsg = sprintf("%s", $_SESSION['errors']['book_edition']);
                    $newForm->fieldAlert(alertClass: "text-danger", alertMsg: $alertMsg);
                }

                /** Form Field: Book Price */
                $newForm->formDiv(divID: "price", divClass: "form-group mb-3");
                $newForm->formLabel(labelID: "price", labelClass: "form-label", labelTitle: "Book Price:");
                $newForm->formFieldInput(inputID: "price", inputName: "book_price", inputType: "text", inputClass: "form-control", inputPlaceholder: "Enter book price");
                if (isset($_SESSION['errors']['book_price'])) {
                    $alertMsg = sprintf("%s", $_SESSION['errors']['book_price']);
                    $newForm->fieldAlert(alertClass: "text-danger", alertMsg: $alertMsg);
                }

                /** Form Field: Book Quantity */
                $newForm->formDiv(divID: "qty", divClass: "form-group mb-3");
                $newForm->formLabel(labelID: "qty", labelClass: "form-label", labelTitle: "Book Quantity:");
                $newForm->formFieldInput(inputID: "qty", inputName: "book_qty", inputType: "text", inputClass: "form-control", inputPlaceholder: "Enter book quantity");
                if (isset($_SESSION['errors']['book_qty'])) {
                    $alertMsg = sprintf("%s", $_SESSION['errors']['book_qty']);
                    $newForm->fieldAlert(alertClass: "text-danger", alertMsg: $alertMsg);
                }

                /** Form Field: Book Publication Date */
                $newForm->formDiv(divID: "publication_date", divClass: "form-group mb-3");
                $newForm->formLabel(labelID: "publication_date", labelClass: "form-label", labelTitle: "Book Publication Date:");
                $newForm->formFieldInput(inputID: "publication_date", inputName: "book_publication_date", inputType: "date", inputClass: "form-control", inputPlaceholder: "Enter book publication date");
                if (isset($_SESSION['errors']['book_publication_date'])) {
                    $alertMsg = sprintf("%s", $_SESSION['errors']['book_publication_date']);
                    $newForm->fieldAlert(alertClass: "text-danger", alertMsg: $alertMsg);
                }

                unset($_SESSION['errors']);

                /** Form Submit Button */
                $newForm->formDiv(divID: "submitButton", divClass: "form-group mb-3");
                $newForm->formButton(buttonID: "submitButton", buttonName: "submitcreateBook", buttonType: "submit", buttonClass: "btn btn-sm btn-primary mt-3 mb-3 float-end ", buttonTitle: "Create");

                // Render Form
                echo $newForm->render();
                ?>
            </div>
        </div>
    </div>
</div>

<?php
// Search Result Variable :: Only set when a search is carried out
$searchResult = $_SESSION['searchResult'] ?? [];

// Retrieved Database Variable :: Set by default by Controller
$books = $retrieved_books;

if (count($searchResult) > 0) {
?>
    <div id="result">
        <?php
        foreach ($searchResult as $result) {
        ?>
            <div class="resultCard card mb-3">
                <div class="card-body">
                    <div class="row justify-content-end">
                        <div class="col-md-6">
                            <p class="card-text"><strong>Title:</strong> <?php echo ucwords($result["book_title"]); ?></p>
                            <p class="card-text"><strong>Product ID:</strong> <?php echo $result["book_id"]; ?></p>
                            <p class="card-text"><strong>Author:</strong> <?php echo $result["book_author"]; ?></p>
                            <p class="card-text"><strong>Edition:</strong> <?php echo $result["book_edition"]; ?></p>
                            <p class="card-text"><strong>Publication Date:</strong> <?php echo $result["book_publication_date"]; ?></p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <?php
                            $base_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
                            ?>
                            <p class="card-text"><img src="<?php echo $base_url; ?>/img/book_cover_imageP.jpg" alt="Book_Cover_Image"></p>
                            <p class="card-text">
                                <?php
                                // Instantiate Form Class
                                $newForm = new Form();
                                $newForm->createForm(formID: "editForm", formName: "editForm", formMethod: "post", formAction: $editFormAction, enctype: "");

                                /** Add Hidden Form Input: Book_ID */
                                $newForm->formFieldInput(inputID: "book_id", inputType: "hidden", inputName: "book_id", value: $result['book_id'] ?? "");

                                /** Submit Button */
                                $newForm->formButton(buttonID: "updateBook", buttonName: "updateBook", buttonType: "submit", buttonClass: "btn btn-sm btn-success rounded me-2", buttonTitle: "Update &#9856");

                                /** View Book Details Button trigger modal */
                                $newForm->formButton(buttonID: "view", buttonType: "button", buttonClass: "btn btn-sm btn-primary rounded me-2", data_bs_toggle: "modal", data_bs_target: "#showBookDetailsTableModal-{$result['book_id']}", buttonTitle: "more Details");

                                // Render Form
                                echo $newForm->render();
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        unset($_SESSION['searchResult']);
        ?>
    </div>
<?php
} else {
?>
    <div class="row">
        <?php
        foreach ($books as $book) {
        ?>
            <!-- Display :: Main Page View -->
            <div class="col-md-3">
                <div class="book-container text-center">
                    <img src="./books/book_cover_imageP.jpg" alt="sample_img">
                    <h6><?php echo "{$book['book_title']} | {$book['book_edition']} ed"; ?></h6>
                    <div class="btn-group">
                        <!-- Display Each Book Entity -->
                        <?php
                        // Instantiate Form Class
                        $newForm = new Form();
                        $newForm->createForm(formID: "editForm", formName: "editForm", formMethod: "post", formAction: $editFormAction, enctype: "");

                        /** Add Hidden Form Input: Book_ID */
                        $newForm->formFieldInput(inputID: "book_id", inputType: "hidden", inputName: "book_id", value: $book['book_id']);

                        echo "<div class= \"btn-group text-center\">";
                        /** Update Button */
                        $newForm->formButton(buttonID: "updateBook", buttonName: "updateBook", buttonType: "submit", buttonClass: "btn btn-sm btn-success rounded me-2", buttonTitle: "Update &#9856");

                        /** Delete Button */
                        $newForm->formButton(buttonID: "deleteBook", buttonName: "deleteBook", buttonType: "submit", buttonClass: "btn btn-sm btn-danger rounded me-2", buttonTitle: "Delete &#9851");

                        /** View Book Details Button trigger modal */
                        $newForm->formButton(buttonID: "View", buttonType: "button", buttonClass: "btn btn-sm btn-secondary rounded me-2 text-light", data_bs_toggle: "modal", data_bs_target: "#showBookDetailsTableModal-{$book['book_id']}", buttonTitle: "more Details");

                        echo "</div>";
                        // Render Form
                        echo $newForm->render();
                        ?>
                    </div>
                </div>
            </div>

            <!-- Book Details Table Modal -->
            <div class="modal fade" id="showBookDetailsTableModal-<?php echo $book['book_id'] ?? $result['book_id']; ?>" tabindex="-1" aria-labelledby="showBookDetailsTableModalLabel-<?php echo $book['book_id'] ?? $result['book_id']; ?>" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content mx-3 px-3 my-4 py-3">
                        <div class="modal-header">
                            <h5 class="modal-title" id="showBookDetailsTableModalLabel"><strong>Product Details</strong></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-0 scrollable-container text-center">
                            <!-- Display Additional Book Info Here -->
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td><strong>Title</strong></td>
                                        <td><?php echo $book['book_title'] ?? $result['book_id']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Author</strong></td>
                                        <td><?php echo $book['book_author'] ?? $result['book_id']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Edition</strong></td>
                                        <td><?php echo $book['book_edition'] ?? $result['book_id']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Price</strong></td>
                                        <td><?php echo "&#36;" . $book['book_price'] ?? $result['book_id']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Publication Date</strong></td>
                                        <td><?php echo $book['book_publication_date'] ?? $result['book_id']; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>

    </div>
<?php
}
?>