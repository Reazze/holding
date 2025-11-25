<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title ?? 'Dashboard Admin' ?></title>
    
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?= ASSETS ?>vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?= ASSETS ?>vendors/css/vendor.bundle.base.css">
    
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="<?= ASSETS ?>vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="<?= ASSETS ?>vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="<?= ASSETS ?>vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= ASSETS ?>vendors/owl-carousel-2/owl.theme.default.min.css">
    
    <!-- Layout styles -->
    <link rel="stylesheet" href="<?= ASSETS ?>css/style.css">
    <!-- Theme Switcher CSS -->
    <link rel="stylesheet" href="<?= ASSETS ?>css/themes.css">
    

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= ASSETS ?>images/favicon.png" />
    
    <!-- CSS adicional por página -->
    <?php if(isset($extraCSS)): ?>
        <?= $extraCSS ?>
    <?php endif; ?>
</head>