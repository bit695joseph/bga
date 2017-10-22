<?php
require_once __DIR__ . '\..\config.php';
require_once SRC_DIR . 'App.php';

use function bga\app\getClientDataJsonString;
use bga\app\App;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo App::getPageTitle(); ?></title>
<!--<link href="https://fonts.googleapis.com/css?family=Roboto|Roboto+Slab" rel="stylesheet">-->
<link rel="stylesheet" href="/bga/public/css/vendor/bootstrap.css">
<link rel="stylesheet" href="/bga/public/css/bga.css">
<script>var BgaData = <?php echo App::getClientDataJsonString(); ?></script>

</head>
<body>

<!-- No script -->
<noscript>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        Please enable javascript for full functionality.
    </div>
</noscript>


<!-- Top Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

    <a class="navbar-brand" href="#"><span class="badge badge-primary">BGA</span></a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">

            <?php foreach (App::getNavItems() as $navItem): ?>
                <li class="nav-item <?php echo $navItem->activeClass; ?>">
                    <a class="nav-link <?php echo $navItem->disabledClass; ?>"
                       href="<?php echo $navItem->href; ?>"><?php echo $navItem->title; ?></a>
                </li>
            <?php endforeach; ?>

        </ul>
    </div>
</nav>


<!-- Breadcrumbs -->
<?php if (App::hasBreadcrumbs()): ?>
    <?php $bc = App::getBreadcrumbs(); ?>

    <nav class="breadcrumb" style="background-color: transparent;">

        <?php foreach ($bc->crumbs as $name => $href): ?>
            <a class="breadcrumb-item" href="<?php echo $href; ?>"><?php echo $name; ?></a>
        <?php endforeach; ?>

        <span class="breadcrumb-item active"><?php echo $bc->activeName ?></span>
    </nav>
<?php endif ?>

