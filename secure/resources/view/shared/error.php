<?php
$number = $number ?? "000";
$title = $title ?? "Error Not Found";
$description = $description ?? ["The requested error code has not been found."];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="mobile-web-app-capable" content="yes">

    <link rel="manifest" href="<?= PUBLIC_URL . "/manifest.json" ?>">

    <link rel="shortcut icon" href="<?= PUBLIC_URL . "/favicon.ico" ?>" type="image/x-icon">
    <link rel="icon" href="<?= PUBLIC_URL . "/addons/images/icon.png" ?>">
    <link rel="apple-touch-icon" href="<?= PUBLIC_URL . "/addons/images/icon.png" ?>">

    <link rel="stylesheet" type="text/css" href="<?= PUBLIC_URL . "/addons/css/core/root.css" ?>">
    <link rel="stylesheet" type="text/css" href="<?= PUBLIC_URL . "/addons/css/core/bootstrap.css" ?>">
    <link rel="stylesheet" type="text/css" href="<?= PUBLIC_URL . "/addons/css/core/bootstrap-icons.min.css" ?>">
    <link rel="stylesheet" type="text/css" href="<?= PUBLIC_URL . "/addons/css/core/error.min.css" ?>">
    <link rel="stylesheet" type="text/css" href="<?= PUBLIC_URL . "/addons/css/global.css" ?>">

    <script src="<?= PUBLIC_URL . "/addons/js/core/theme.min.js" ?>"></script>

    <title><?= "Fronsky® PHP Framework | " . $number ?></title>
</head>
<body>
    <div class="error-container">
        <div class="error-number text-danger"><?= $number ?></div>
        <div class="error-title"><?= $title ?></div>
        <div class="error-description">
            <?php foreach ($description as $line) { ?>
                <p><?= $line ?></p>
            <?php } ?>
        </div>
        <a href="<?= PUBLIC_URL ?>" class="btn btn-primary default-rounded">Go Back Home</a>
    </div>

    <script src="<?= PUBLIC_URL . "/addons/js/core/jquery.min.js" ?>"></script>
    <script src="<?= PUBLIC_URL . "/addons/js/core/bootstrap.bundle.min.js" ?>"></script>
    <script src="<?= PUBLIC_URL . "/addons/js/global.js" ?>"></script>
</body>
</html>
