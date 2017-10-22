<?php

namespace bga\app\ajax {

    require_once __DIR__ . '/../../app/config.php';
    require_once SRC_CONFIG_DIR . 'AjaxHelper.php';
    require_once SRC_MODELS_DIR . 'Event.php';

    use bga\app\data\Event;

    if (isset($_POST['event_id'])) {

        $eventFound = Event::findById($_POST['event_id']);

        if ($eventFound->success()) {
            $eventDeleted = $eventFound->model()->delete();

            if ($eventDeleted->success()) {
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