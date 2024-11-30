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
    <?php if (isset($bootstrapEnabled) && $bootstrapEnabled) { ?>
        <link rel="stylesheet" type="text/css" href="<?= PUBLIC_URL . "/addons/css/core/bootstrap.css" ?>">
        <link rel="stylesheet" type="text/css" href="<?= PUBLIC_URL . "/addons/css/core/bootstrap-icons.min.css" ?>">
    <?php } ?>
    <link rel="stylesheet" type="text/css" href="<?= PUBLIC_URL . "/addons/css/core/lightbox.min.css" ?>">
    <link rel="stylesheet" type="text/css" href="<?= PUBLIC_URL . "/addons/css/global.css" ?>">

    <?php foreach ($styles ?? [] as $style) { ?>
        <link rel="stylesheet" href="<?= PUBLIC_URL . "/addons/css/$style" ?>">
    <?php } ?>

    <script src="<?= PUBLIC_URL . "/addons/js/core/theme.min.js" ?>"></script>

    <title><?= $title ?? "" ?></title>
</head>
<body>
    <?php if(isset($header)) { ?>
        <header>
            <?= $header ?>
        </header>
    <?php } ?>

    <main class="container">
        <?= $content ?? "" ?>

        <?php if (!isCookieActive("cookies_accepted")) { ?>
            <div class="cookies lightbox-container lightbox-active">
                <div class="lightbox-dialog">
                    <div class="lightbox-content bg-body-secondary">
                        <div class="mb-3">
                            <img class="rounded mb-3" src="<?= PUBLIC_URL . "/images/cookies.png" ?>" width="75" alt="cookies-img">
                            <p>
                                By using cookies, we aim to provide the best website experience. If you continue without changing your settings, we assume that you consent to receive all cookies from us.
                            </p>
                        </div>

                        <button type="button" class="btn btn-secondary btn me-2 default-rounded" onclick="setCookie('cookies_accepted', 'no', 365); dismissLightbox();">Deny</button>
                        <button type="button" class="btn btn-primary btn default-rounded" onclick="setCookie('cookies_accepted', 'yes', 365); dismissLightbox();">Accept</button>
                    </div>
                </div>
            </div>
        <?php } ?>
    </main>

    <?php if(isset($footer)) { ?>
        <footer>
            <?= $footer ?>
        </footer>
    <?php } ?>

    <script src="<?= PUBLIC_URL . "/addons/js/core/jquery.min.js" ?>"></script>
    <?php if (isset($bootstrapEnabled) && $bootstrapEnabled) { ?>
        <script src="<?= PUBLIC_URL . "/addons/js/core/bootstrap.bundle.min.js" ?>"></script>
    <?php } ?>
    <script src="<?= PUBLIC_URL . "/addons/js/core/cookies.min.js"; ?>"></script>
    <script src="<?= PUBLIC_URL . "/addons/js/global.js" ?>"></script>

    <?php foreach ($scripts ?? [] as $script) { ?>
        <script src="<?= PUBLIC_URL . "/addons/js/$script" ?>"></script>
    <?php } ?>
</body>
</html>