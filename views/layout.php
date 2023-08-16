<?php
// views/layout.php

// use app\Form;

// require_once __DIR__ . '/../vendor/autoload.php';

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/style.css" />
    <title><?= $pageTitle ?></title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <header class="fixed-top bg-secondary text-white text-left mt-1 py-1">
                    <h4>JoyBoy</h4>
                </header>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <main class="mt-5 py-1">
                    <?= $pageContent ?>
                </main>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <footer class="fixed-bottom bg-secondary text-white text-left mb-1 py-1">
                    <small>&copy; joyboy designs | 2023</small>
                </footer>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>