<?php
$this->db = db_connect();
$seiteinfo = siteinfo();
foreach ($seiteinfo['setting'] as $setting_data) {
} ?>
<?php foreach ($seiteinfo['singleuser'] as $user) {
} ?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8">

    <title> <?= $setting_data->title; ?></title>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>/assets/img/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/plugins.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/main.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/themes.css">
    <script src="js/vendor/modernizr.min.js"></script>
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/uikit/css/uikit.min.css" />
    <script src="<?php echo base_url(); ?>/assets/uikit/js/uikit.min.js"></script>
    <script src="<?php echo base_url(); ?>/assets/uikit/js/uikit-icons.min.js"></script>


    <script src="<?php echo base_url(); ?>/assets/ckeditor/ckeditor.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>

</head>

<body>
    <!-- Page Wrapper -->

    <div id="page-wrapper">
        <!-- Page Container -->
        <div id="page-container" class="sidebar-partial sidebar-visible-lg sidebar-no-animations">