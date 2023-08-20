<!-- views/layout.php -->

<!DOCTYPE html>
<html>

<head>
    <?php
    require_once __DIR__ . '/components/head.php';
    ?>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php
                require_once __DIR__ . '/components/header.php';
                ?>
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
                <?php
                require_once __DIR__ . '/components/footer.php';
                ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>