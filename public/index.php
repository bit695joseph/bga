<?php
require_once __DIR__ . '/../app/config.php';
require_once SRC_DIR . 'App.php';
require_once SRC_DATA_DIR . 'Result.php';

use \bga\app\App;
use \bga\app\data\Member as Member;
?>
<?php

App::setPageTitle("Home");
//App::setActivePage("");
//App::setBreadcrumbs("Members");
//App::setClientPageData([
//    'model' => 'Member',
//    'crud' => 'list'
//]);

?>
<?php include VIEWS_DIR . 'top.php'; ?>

    <div class="container-fluid">

        <div class="row">

            <div class="col">
                <h1>Home</h1>
            </div>
        </div>
    </div>
<?php include VIEWS_DIR . 'bottom.php'; ?>