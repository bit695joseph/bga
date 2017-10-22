<?php

namespace bga\app\ajax {

    require_once __DIR__ . '/../../app/config.php';
    require_once SRC_DIR . 'App.php';
    require_once SRC_CONFIG_DIR . 'AjaxHelper.php';
    require_once SRC_MODELS_DIR . 'Game.php';
    require_once SRC_MODELS_DIR . 'Member.php';

    use bga\app\App;
    use bga\app\AjaxHelper;
    use bga\app\data\Member;
    use bga\app\data\Game;

    $game = null;
    $member = null;
    Member::findByRequestId($member);
    Game::findByRequestId($game);

    // Validation.
    if (is_null($game) || is_null($member) || (! App::isPost())) {
        AjaxHelper::outputBadRequest();
    }

    // Get the games for this member from the database.
    $member->loadGames();

    // todo: this shouldn't happen.
    if ($member->hasGame($game)) {
        AjaxHelper::outputSuccessWithData([ 'message' => 'Member already had game.']);
    }

    // Input looks valid. Associate the member with the game.
    if ($member->addGame($game)) {
        AjaxHelper::outputSuccessWithData([ 'message' => 'Added game successfully.']);
    }

    AjaxHelper::outputInternalServerError();
}