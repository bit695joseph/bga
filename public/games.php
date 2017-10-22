<?php
    require_once __DIR__ . '/../app/config.php';
    require_once SRC_DIR . 'App.php';
    require_once SRC_MODELS_DIR . 'Game.php';
    require_once SRC_DATA_DIR . 'Result.php';
    use \bga\app\App;
    use \bga\app\data\Game;

    App::setPageTitle("Games");
    App::setActivePage("Games");
    App::setBreadcrumbs("Games");
    App::setClientPageData([
        'model' => 'Game',
        'crud' => 'list'
    ]);
    $foundGames = Game::findAll();
?>


<?php include VIEWS_DIR . 'top.php'; ?>


<div class="container-fluid">

    <div class="row">

        <div class="col">
            <h1>Games <button type="button" class="btn btn-success btn-sm create-btn">Create New</button></h1>

            <?php if ($foundGames->success()): ?>
            <br>
                <table class="table table-sm table-hover">
                    <thead>
                    <tr>
                        <th>Game</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($foundGames->models() as $g): ?>
                        <tr id="<?php App::e($g->game_id); ?>" scope="row">
                            <td><?php App::e($g->name); ?></td>
                            <td>
                                <button type="button" class="btn btn-secondary btn-sm edit-btn row-btn">Edit</button>
                                <button type="button" class="btn btn-danger btn-sm delete-btn row-btn">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>


                    </tbody>
                </table>

            <?php elseif ($foundGames->none()): ?>
                <i>There are no games in the database.</i>
            <?php else: ?>
                <i><?php $foundGames->message(); ?></i>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php include VIEWS_DIR . 'bottom.php'; ?>