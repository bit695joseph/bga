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

    if (is_null($game) || is_null($member) || (! App::isPost())) {
        AjaxHelper::outputBadRequest();
    }

    $member->loadGames();

    if (! $member->hasGame($game)) {
        AjaxHelper::outputSuccessWithData([ 'message' => 'did not have game!']);

    }

    if ($member->removeGame($game)) {
        AjaxHelper::outputSuccessWithData([ 'message' => 'Removed game successfully.']);
    }

    AjaxHelper::outputInternalServerError();
}