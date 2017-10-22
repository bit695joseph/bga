<?php
require_once __DIR__ . '../../app/config.php';
require_once SRC_DIR . 'App.php';
require_once SRC_VALIDATION_DIR . 'ValidationConstants.php';
require_once SRC_VALIDATION_DIR . 'MemberFormValidator.php';
require_once SRC_MODELS_DIR . 'Member.php';
require_once SRC_MODELS_DIR . 'Game.php';


use \bga\app\data\Member;
use \bga\app\data\Game;
use \bga\app\App;

App::setPageTitle("Edit Member Games");
App::setActivePage("Members");
App::setBreadcrumbs("Edit member games", ["Members" => "members.php"]);
App::setClientPageData(['model' => 'Member','crud' => 'edit']);
$member = null;
if (!Member::findByRequestId($member))
{
    App::badRequest();
}

$member->loadGames();

$allGames = Game::findAll()->models();

$memberGames = $member->getGames();



/*
 * select * from
 * */

?>
<?php include VIEWS_DIR . 'top.php'; ?>


<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h1>Editing games of <small class="text-muted"><?php App::e($member->fullName()); ?></small></h1>

            <br>
            <form action="" method="post">
            <?php foreach ($allGames as $g): ?>

                <input type="checkbox"
                       id="<?php $g->echoIdAttr(); ?>"
                       class = "game-toggle"
                       name="member_game"
                       data-member="<?php echo $member->getId(); ?>"
                       data-game="<?php echo $g->getId(); ?>"

                       <?php if ($member->hasGame($g)) echo 'checked'; ?>>
                <label for="<?php $g->echoIdAttr(); ?>"><?php App::e($g->name); ?></label>
               <br>
            <?php endforeach; ?>

            </form>


        </div>
    </div>
</div>

<?php include VIEWS_DIR . 'bottom.php'; ?>