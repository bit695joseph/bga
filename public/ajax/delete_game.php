<?php

namespace bga\app\ajax {

    require_once __DIR__ . '/../../app/config.php';
    require_once SRC_CONFIG_DIR . 'AjaxHelper.php';
    require_once SRC_MODELS_DIR . 'Game.php';

    use bga\app\data\Game as Game;

    if (isset($_POST['game_id'])) {

        $gameFound = Game::findById($_POST['game_id']);

        if ($gameFound->success()) {
            $gameDeleted = $gameFound->model()->delete();

            if ($gameDeleted->success()) {
                AjaxHelper::outputSuccess();
            } else {
                // Unexpected problem deleting the model.
                AjaxHelper::outputInternalServerError();
            }
        } else {
            // id not found.
            AjaxHelper::outputBadRequest();
        }
    } else {
        // No id provided.
        AjaxHelper::outputBadRequest();
    }
}