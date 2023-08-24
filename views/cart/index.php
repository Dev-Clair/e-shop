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

<?php

// echo "<pre>";
// var_dump($cart_items);

?>
<h3> Cart 🛒</h3>

<div class="table-responsive">
    <table class="table table-striped table-bordered mb-0" style="table-layout: auto;">
        <thead class="thead-dark">
            <tr>
                <th>Cart Item ID</th>
                <th>Cart Item</th>
                <th>Cart Item Qty</th>
                <th>Cart Item Price</th>
                <th>Cart Item Amount</th>
                <th>Remove From 🛒 </th>
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
                    <td>
                        <?php
                        // Instantiate Form Class
                        $newForm = new Form();

                        $newForm->createForm(formID: "cartQuantity", formName: "cartQuantity", formMethod: "post", formAction: $cartQuantityFormAction, enctype: null);

                        /** Item Update Button */
                        $newForm->formFieldInput(inputID: "cartQuantity", inputName: "default_qty", inputType: "number", inputClass: "", inputPlaceholder: "1", value: $item['cart_item_qty']);

                        // Render Form
                        echo $newForm->render();
                        ?>
                    </td>
                    <td><?php echo $item['cart_item_price']; ?></td>
                    <td><?php echo $item['cart_item_amt']; ?></td>
                    <td class="btn-group">
                        <?php
                        // Instantiate Form Class
                        $newForm = new Form();

                        $newForm->createForm(formID: "removeFromCart", formName: "removeFromCart", formMethod: "post", formAction: $removeFromCartFormAction, enctype: null);

                        /** Item Delete Button */
                        $newForm->formFieldInput(inputID: "removeFromCartButton", inputName: "removeFromCart[{$item['book_id']}]", inputType: "submit", inputClass: "btn btn-sm btn-danger", value: "&#9851");

                        // Render Form
                        echo $newForm->render();
                        ?>
                    </td>
                    </tr>
                <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="6">No records found.</td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>