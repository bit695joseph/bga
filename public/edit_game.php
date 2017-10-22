<?php
require_once __DIR__ . '../../app/config.php';
require_once SRC_DIR . 'App.php';
require_once SRC_VALIDATION_DIR . 'ValidationConstants.php';
require_once SRC_VALIDATION_DIR . 'GameFormValidator.php';
require_once SRC_MODELS_DIR . 'Game.php';


use \bga\app\data\Game;
use \bga\app\validation\GameFormValidator;
use \bga\app\App;
use \bga\app\validation\ValidationConstants as VC;
App::setPageTitle("Edit Game");
App::setActivePage("Games");
App::setBreadcrumbs("Edit Game", ["Games" => "games.php"]);
App::setClientPageData(['model' => 'Game','crud' => 'edit']);

$game = null;

if (!Game::findByRequestId($game))
{
    App::badRequest();
}

$nameVal = '';
$nameClass = '';
$nameMsg = '';

if (App::isPost()) {
    $v = new GameFormValidator();

    if ($v->validate($_POST)) {
        if ($game->updateAll($_POST))
            App::redirectTo('games.php');
        else App::serverError();
    } else {
        // Posted form values
        $invalidData = $v->getData();
        $nameVal = $invalidData['name'];

        // Validation error messages
        $nameMsg = $v->getMessage('name');
        $nameClass = $v->getBootstrapClass('name');

    }
} else {
    $nameVal = $game->name;
}

?>
<?php include VIEWS_DIR . 'top.php'; ?>


<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h1>Editing <small class="text-muted"><?php App::e($game->name); ?></small></h1>
            <form id="game-form" action="edit_game.php" method="post" name="game_form">
                <input type="hidden" name="game_id" value="<?php echo $game->getId(); ?>">
                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="name" class="col-form-label">Game name</label>
                        <input id="name" type="text" name="name"
                               class="form-control <?php echo $nameClass; ?>"
                               minlength="<?php echo VC::GAME_NAME_MIN_LEN; ?>"
                               maxlength="<?php echo VC::GAME_NAME_MAX_LEN; ?>"
                               value="<?php App::e($nameVal); ?>"
                               autofocus
                               required>
                        <div class="invalid-feedback">
                            <?php echo $nameMsg; ?>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    </div>
</div>

<?php include VIEWS_DIR . 'bottom.php'; ?>