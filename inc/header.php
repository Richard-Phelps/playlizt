<!DOCTYPE html>
<html>

<head>

    <!-- Title -->
    <title>Playlizt - <?php echo $page_title; ?></title>

    <!-- Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.1/css/materialize.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300">
    <link rel="stylesheet" href="<?php echo $config->site_url; ?>/css/styles.css">

</head>

<body class="light-grey-bg">

<header class="main-bg white-text smooth-box-shadow">

    <div class="container">

        <div class="row mb0">

            <div class="col m6 left-align">
                <a href="<?php echo $config->site_url; ?>" class="white-text-important">
                    <p class="margin0 header-text-size header-line-height">Playlizt</p>
                </a>
            </div>

            <div class="col m6 right-align">
                <i class="material-icons pointer-cursor header-line-height">account_circle</i>
            </div>

        </div><!-- .row -->

    </div><!-- .container -->

</header>
