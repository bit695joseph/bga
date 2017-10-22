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

App::setPageTitle("Create Member");
App::setActivePage("Games");
App::setBreadcrumbs("Create game", ["Games" => "games.php"]);
App::setClientPageData(['model' => 'Game','crud' => 'create']);

$game_name = '';
$nameClass = '';
$nameMsg = '';

if (App::isPost()) {
    $v = new GameFormValidator();

    if ($v->validate($_POST)) {

        $game = new Game($_POST);

        if ($game->insert()) {

            header('Location: games.php');
            exit();

        } else {
            header('Location: error500.php');
            exit();
        }

    } else {

        // Posted form values
        $invalidData = $v->getData();
        $game_name = $invalidData['name'];

        $nameMsg = $v->getMessage('name');
        $nameClass = $v->getBootstrapClass('name');
    }
}

?>
<?php include VIEWS_DIR . 'top.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h1>Create Game</h1>
            <form id="game-form" action="create_game.php" method="post" name="game_form">

                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="name" class="col-form-label">Game name</label>
                        <input id="name" type="text" name="name"
                               class="form-control <?php echo $nameClass; ?>"
                               minlength="<?php echo VC::GAME_NAME_MIN_LEN; ?>"
                               maxlength="<?php echo VC::GAME_NAME_MAX_LEN; ?>"
                               value="<?php App::e($game_name); ?>"
                               placeholder="Eg. Yahtzee, Checkers etc."
                               autofocus required>
                        <div class="invalid-feedback">
                            <?php echo $nameMsg; ?>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Create Game</button>

            </form>
        </div>
    </div>
</div>

<?php include VIEWS_DIR . 'bottom.php'; ?>