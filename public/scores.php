<?php
    require_once __DIR__ . '/../app/config.php';
    require_once SRC_DIR . 'App.php';

    use \bga\app\App;

    App::setPageTitle("Scores");
    App::setActivePage("Scores");
    App::setBreadcrumbs("Scores");
    App::setClientPageData([
        'model' => 'Score',
        'crud' => 'list'
    ]);

?>


<?php include VIEWS_DIR . 'top.php'; ?>


<div class="container-fluid">

    <div class="row">

        <div class="col">
            <h1>Scores</h1>

            <em>Under construction</em>

        </div>
    </div>
</div>

<?php include VIEWS_DIR . 'bottom.php'; ?>