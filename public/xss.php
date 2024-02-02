<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XSS Example</title>
</head>
<body>
    <?php if($_REQUEST['name'] ?? null): ?>
        <div>Hello <strong><?= $_REQUEST['name'] ?></strong>!</div>
    <?php else:  ?>
        <div>Enter your name:</div>
    <?php endif; ?>

    <form action="">
        <input type="text" name="name" value="<?= $_REQUEST['name'] ?? '' ?>">
    </form>
</body>
</html>

<?php
    // <script>alert("Hello!")</script>