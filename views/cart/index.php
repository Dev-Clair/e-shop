<?php
// views/cart/index.php

declare(strict_types=1);

use app\Form;

require_once __DIR__ . '/../../vendor/autoload.php';

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

<h3>Cart 🛒</h3>

<div class="table-responsive">
    <table class="table table-striped table-bordered mb-0 text-center" style="table-layout: auto;">
        <thead class="thead-dark">
            <tr>
                <th>Cart Item ID</th>
                <th>Cart Item</th>
                <th>Cart Item Qty</th>
                <th>Cart Item Price</th>
                <th>Cart Item Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $cart = $cart_items;
            if (!empty($cart)) {
                foreach ($cart as $item) {
            ?>
                    <td><?php echo $item['cart_item_id']; ?></td>
                    <td><?php echo $item['book_id']; ?></td>
                    <td class="btn-group">
                        <?php
                        // Instantiate Form Class
                        $newForm = new Form();

                        $newForm->createForm(formID: "alterQty", formName: "alterQty", formMethod: "post", formAction: $cartQuantityFormAction, enctype: null);

                        /** Add Hidden Form Input: Cart_Item_ID */
                        $newForm->formFieldInput(inputID: "cart_item_id", inputType: "hidden", inputName: "cart_item_id", value: $item['cart_item_id'] ?? "");

                        /** Add Hidden Form Input: Cart_Item_Price */
                        $newForm->formFieldInput(inputID: "cart_item_price", inputType: "hidden", inputName: "cart_item_price", value: $item['cart_item_price'] ?? "");

                        /** Item Update Field */
                        $newForm->formFieldInput(inputID: "cartQuantity", inputName: "new_qty", inputType: "number", inputClass: "me-2", value: $item['cart_item_qty']);

                        /** Item Update Button */
                        $newForm->formButton(buttonID: "alterQty", buttonName: "alterQty", buttonType: "submit", buttonClass: "btn btn-sm btn-success rounded me-2", buttonTitle: "+/-");

                        // Render Form
                        echo $newForm->render();
                        ?>
                        <?php
                        // Instantiate Form Class
                        $newForm = new Form();

                        $newForm->createForm(formID: "removeFromCart", formName: "removeFromCart", formMethod: "post", formAction: $removeFromCartFormAction, enctype: null);

                        /** Item Delete Button */
                        $newForm->formFieldInput(inputID: "removeFromCartButton", inputName: "removeFromCart[{$item['cart_item_id']}]", inputType: "submit", inputClass: "btn btn-sm btn-danger", value: "&#9851");

                        // Render Form
                        echo $newForm->render();
                        ?>
                    </td>
                    <td><?php echo $item['cart_item_price']; ?></td>
                    <td><?php echo $item['cart_item_amt']; ?></td>
                    </tr>
                <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="5">No records found.</td>
                </tr>
            <?php
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4"><strong>sub-total</strong></td>
                <td>
                    <!-- Display Summary -->
                    <?php
                    // Instantiate Form Class
                    $newForm = new Form();

                    $newForm->createForm(formID: "", formName: "", formMethod: "post", formAction: $cartQuantityFormAction, enctype: null);

                    /** Item Update Field */
                    $newForm->formFieldInput(inputID: "", inputName: "", inputType: "", inputClass: "me-2", value: "");

                    /** Item Update Button */
                    $newForm->formButton(buttonID: "", buttonName: "", buttonType: "submit", buttonClass: "btn btn-sm btn-success rounded me-2", buttonTitle: "");

                    // Render Form
                    echo $newForm->render();
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="4"><strong>Add:</strong></td>
            </tr>
            <tr>
                <td colspan="4"><strong>Shipping Fee</strong></td>
                <td><strong>Free</strong></td>
            </tr>
            <tr>
                <td colspan="4"><strong>Total Cost</strong></td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <!-- Proceed to Checkout Button -->
    <div class="text-end mt-3 mb-3">
        <button type="button" class="btn btn-sm btn-success rounded me-2" href="">proceedToCheckOut</button>
    </div>
</div>