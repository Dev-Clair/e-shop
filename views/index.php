<?php
// views/index.php (Home Controller)

use app\Form;

require_once __DIR__ . '/../vendor/autoload.php';

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

<?php
// Instantiate Form Class
$newForm = new Form();
$newForm->createForm(formID: "searchBook", formName: "searchBook", formMethod: "post", formAction: $searchFormAction, enctype: "multipart/form-data");

/** Form Field: Search Book */
$newForm->formDiv(divID: "search", divClass: "form-inline");
$newForm->formFieldInput(inputID: "search", inputName: "search", inputType: "search", inputClass: "form-control me-2", inputPlaceholder: "&#128269 Search...");

// Render Form
echo $newForm->render();
?>

<?php
foreach ($books as $book) {
?>
    <div class="book-container text-left">
        <img src="./books/book_cover_imageP.jpg" alt="sample_img">
        <h6><?php echo $book['book_title']; ?></h6>
        <div class="btn-group">
            <!-- Display Each Book Entity -->
            <?php
            // Instantiate Form Class
            $newForm = new Form();
            $newForm->createForm(formID: "cartForm", formName: "cartForm", formMethod: "post", formAction: $cartFormAction, enctype: "multipart/form-data");

            /** Add Hidden Form Input: Book_ID */
            $newForm->formFieldInput(inputID: "book", inputType: "hidden", inputName: "book_id", value: $book['book_id'] ?? "");

            /** Add Hidden Form Input: Book_Title */
            $newForm->formFieldInput(inputID: "book", inputType: "hidden", inputName: "book_title", value: $book['book_title'] ?? "");

            /** Add to Cart Submit Button */
            $newForm->formButton(buttonID: "addToCart", buttonName: "addToCart", buttonType: "submit", buttonClass: "btn btn-sm btn-success rounded me-2", buttonTitle: "Add to Cart");

            /** Book Details Button trigger modal */
            $newForm->formButton(buttonID: "moreDetails", buttonType: "button", buttonClass: "btn btn-sm btn-primary rounded me-2", data_bs_toggle: "modal", data_bs_target: "#showBookDetailsTableModal-{$book['book_id']}", buttonTitle: "More Details");

            // Render Form
            echo $newForm->render();
            ?>
        </div>
    </div>

    <!-- Book Details Table Modal -->
    <div class="modal fade" id="showBookDetailsTableModal-<?php echo $book['book_id']; ?>" tabindex="-1" aria-labelledby="showBookDetailsTableModalLabel-<?php echo $book['book_id']; ?>" aria-hidden="true">
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
                                <td><?php echo $book['book_title']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Author</strong></td>
                                <td><?php echo $book['book_author']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Edition</strong></td>
                                <td><?php echo $book['book_edition']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Price</strong></td>
                                <td><?php echo "&#36;" . $book['book_price']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Publication Date</strong></td>
                                <td><?php echo $book['book_publication_date']; ?></td>
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