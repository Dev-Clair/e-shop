<?php
// views/cart/index.php

declare(strict_types=1);

use app\Form;

require_once __DIR__ . '/../../vendor/autoload.php';

?>

<div class="table-responsive">
    <table class="table table-striped table-bordered mb-0" style="table-layout: auto;">
        <thead class="thead-dark">
            <tr>
                <th>Cart Item ID</th>
                <th>Cart Item </th>
                <th>Cart Item Qty</th>
                <th>Cart Item Price</th>
                <th>Cart Item Amount</th>
                <th></th>
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

                        $newForm->createForm(formID: "userAction", formName: "userAction", formMethod: "post", formAction: $cartFormAction, enctype: null);

                        /** Item Update Button */
                        $newForm->formFieldInput(inputID: "updateField", inputName: "default_qty", inputType: "number", inputClass: "", inputPlaceholder: "1", value: $item['cart_item_qty']);

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

                        $newForm->createForm(formID: "userAction", formName: "userAction", formMethod: "post", formAction: $cartFormAction, enctype: null);

                        /** Item Delete Button */
                        $newForm->formFieldInput(inputID: "deleteButton", inputName: "deleteCartItem[{$item['book_id']}]", inputType: "submit", inputClass: "btn btn-sm btn-danger", value: "&#9851");

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