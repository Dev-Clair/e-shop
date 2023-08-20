<!-- views/components/header.php -->

<header class="fixed-top bg-secondary text-white text-left mt-1 py-1">
    <div class="d-flex justify-content-between align-items-center">
        <h5><strong>JoyBoy</strong></h5>

        <div class="d-flex align-items-center">
            <a type="button" class="btn btn-sm btn-outline rounded text-white me-2" href="/e-shop/cart"><strong>🛒 Cart</strong></a>

            <?php
            if (!isset($_SESSION['user_id'])) {
                echo '<a type="button" class="btn btn-sm btn-outline rounded text-white" href="/e-shop/users/logout"><strong>&#128100; Logout</strong></a>';
            } else {
                echo '<a type="button" class="btn btn-sm btn-outline rounded text-white" href="/e-shop/users"><strong>&#128100; Login</strong></a>';
            }
            ?>
        </div>
    </div>
</header>