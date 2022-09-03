<?php
if (!(PHP_VERSION_ID >= 80100)) {
    $alert = 'danger';
    $msg = '<strong>ERROR:</strong> Your Composer dependencies require a PHP version ">= 8.0.2". You are running ' . PHP_VERSION . '.<br>Please contact your hosting provider if this error still persists after you changed the PHP version!';
} else {
    $alert = 'primary';
    $msg = '<strong>Info:</strong> If after click submit you see ERROR 500 because you enter the wrong database credentials!<br>
    Solution: cPanel file manager -> delete ".env" and delete "/storage/installed", then come back to this page again!<br>
    If you put database credentials correctly, it will start installation on the next page.';
}

if (! file_exists('.env') && ! empty($_POST)) {
    $data =
    '# App configs' . "\n" .
    'APP_KEY=base64:sh9573zgJd8a5uxjE5w5KAvw0V5Lg3uyJxMsi9pZFz4=' . "\n" .
    'APP_URL=' . $_POST['APP_URL'] . "\n" .
    'APP_PORT=' . $_POST['APP_PORT'] . "\n\n" .
    '# Database' . "\n" .
    'DB_CONNECTION=' . $_POST['DB_CONNECTION'] . "\n" .
    'DB_HOST=' . $_POST['DB_HOST'] . "\n" .
    'DB_PORT=' . $_POST['DB_PORT'] . "\n" .
    'DB_DATABASE=' . $_POST['DB_DATABASE'] . "\n" .
    'DB_USERNAME=' . $_POST['DB_USERNAME'] . "\n" .
    'DB_PASSWORD=' . $_POST['DB_PASSWORD'] . "\n\n" .
    '# Salla Token' . "\n" .
    'SALLA_TOKEN=' . $_POST['SALLA_TOKEN'] . "\n\n" .
    '# Outgoing mail server' . "\n" .
    'MAIL_MAILER=smtp' . "\n" .
    'MAIL_HOST=mail.arrocy.com' . "\n" .
    'MAIL_PORT=465' . "\n" .
    'MAIL_USERNAME=demo@arrocy.com' . "\n" .
    'MAIL_PASSWORD=SuperSecret@123!' . "\n" .
    'MAIL_ENCRYPTION=ssl' . "\n" .
    'MAIL_FROM_ADDRESS="demo@arrocy.com"' . "\n" .
    'MAIL_FROM_NAME="${APP_NAME}"' . "\n";

    file_put_contents('.env', $data);
}
if (file_exists('.htaccess')) rename('.htaccess', '.htaccess.wz');
if (file_exists('.env')) {
    if (file_exists('.htaccess.wz')) rename('.htaccess.wz', '.htaccess');

    $file = file_get_contents('.env');
    $arr = explode("\n", $file);
    $APP_URL = '';
    $APP_PORT = '';
    $DB_CONNECTION = '';
    $DB_HOST = '';
    $DB_PORT = '';
    $DB_DATABASE = '';
    $DB_USERNAME = '';
    $DB_PASSWORD = '';
    $SALLA_TOKEN = '';
    foreach($arr as $a) {
        $x = explode("=", $a);
        if ($x[0] == 'APP_URL') {$APP_URL = $x[1];}
        if ($x[0] == 'APP_PORT') {$APP_PORT = $x[1];}
        if ($x[0] == 'DB_CONNECTION') {$DB_CONNECTION = $x[1];}
        if ($x[0] == 'DB_HOST') {$DB_HOST = $x[1];}
        if ($x[0] == 'DB_PORT') {$DB_PORT = $x[1];}
        if ($x[0] == 'DB_DATABASE') {$DB_DATABASE = $x[1];}
        if ($x[0] == 'DB_USERNAME') {$DB_USERNAME = $x[1];}
        if ($x[0] == 'DB_PASSWORD') {$DB_PASSWORD = $x[1];}
        if ($x[0] == 'SALLA_TOKEN') {$SALLA_TOKEN = $x[1];}
    }

    $data =
    '# Server configs' . "\n" .
    'APP_URL=' . $APP_URL . "\n" .
    'APP_PORT=' . $APP_PORT . "\n" .
    'TIMER_REFRESH=true'."\n\n".
    '# Database' . "\n" .
    'DB_CONNECTION=' . $DB_CONNECTION . "\n" .
    'DB_HOST=' . $DB_HOST . "\n" .
    'DB_PORT=' . $DB_PORT . "\n" .
    'DB_DATABASE=' . $DB_DATABASE . "\n" .
    'DB_USERNAME=' . $DB_USERNAME . "\n" .
    'DB_PASSWORD=' . $DB_PASSWORD . "\n";
    file_put_contents('.env.node.server', $data);
    return header('Location: public/update/');
}
?>

<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="Wazone installer.">
    <meta name="keywords" content="wazone gateway, multi device, baileys, multi sessions, multi users">
    <meta name="author" content="arrocy">
    <title>Wazone Gateway - Installer</title>
    <link rel="apple-touch-icon" href="public/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="public/app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="public/app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="public/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="public/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="public/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="public/app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="public/app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="public/app-assets/css/themes/bordered-layout.css">
    <link rel="stylesheet" type="text/css" href="public/app-assets/css/themes/semi-dark-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="public/app-assets/css/core/menu/menu-types/horizontal-menu.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="public/assets/css/style.css">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu blank-page navbar-floating footer-static  " data-open="hover" data-menu="horizontal-menu" data-col="blank-page">
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-md-12"><br><br>
                        <h4 class="mb-2">Pre-install check</h4>
                        <div class="card">
                            <div class="card-header">
                                <div class="card-body">
                                    <form action="index.php" method="POST">
                                        <h4>Application and Database configuration</h4>
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="APP_URL">Application url</label>
                                                <input type="text" name="APP_URL" required class="form-control" value="<?= isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https://' : 'http://' ?><?= $_SERVER['SERVER_NAME'] ?><?= str_replace('/index.php','',$_SERVER['PHP_SELF']) ?>">
                                            </div><br>
                                            <div class="col-6">
                                                <label for="APP_PORT">Application port (8000)</label>
                                                <input type="number" name="APP_PORT" required class="form-control" value="8000">
                                            </div><br>
                                            <div class="col-6">
                                                <label for="DB_CONNECTION">Database connection (mysql)</label>
                                                <input type="text" name="DB_CONNECTION" required class="form-control" value="mysql">
                                            </div><br>
                                            <div class="col-6">
                                                <label for="DB_HOST">Database host (localhost)</label>
                                                <input type="text" name="DB_HOST" required class="form-control" value="localhost">
                                            </div><br>
                                            <div class="col-6">
                                                <label for="DB_PORT">Database port (3306)</label>
                                                <input type="number" name="DB_PORT" required class="form-control" value="3306">
                                            </div><br>
                                            <div class="col-6">
                                                <label for="DB_DATABASE">Database name</label>
                                                <input type="text" name="DB_DATABASE" required class="form-control" placeholder="Database name">
                                            </div><br>
                                            <div class="col-6">
                                                <label for="DB_USERNAME">Database user</label>
                                                <input type="text" name="DB_USERNAME" required class="form-control" placeholder="Database user">
                                            </div><br>
                                            <div class="col-6">
                                                <label for="DB_PASSWORD">Database password</label>
                                                <input type="text" name="DB_PASSWORD" class="form-control" placeholder="Database password">
                                            </div><br>
                                            <div class="col-6">
                                                <label for="SALLA_TOKEN">Salla token</label>
                                                <input type="text" name="SALLA_TOKEN" class="form-control" placeholder="Salla token">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="alert alert-<?= $alert ?>" role="alert">
                                            <div class="alert-body">
                                                <?= $msg ?>
                                            </div>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary" <?= (PHP_VERSION_ID >= 80002) ? '' : 'disabled' ?>>Submit >></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="public/app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="public/app-assets/vendors/js/ui/jquery.sticky.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="public/app-assets/js/core/app-menu.js"></script>
    <script src="public/app-assets/js/core/app.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <!-- END: Page JS-->

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>
</body>
<!-- END: Body-->

</html>
