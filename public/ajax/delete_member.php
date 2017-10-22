<?php

namespace bga\app\ajax {

    require_once __DIR__ . '/../../app/config.php';
    require_once SRC_CONFIG_DIR . 'AjaxHelper.php';
    require_once SRC_MODELS_DIR . 'Member.php';

    use bga\app\data\Member;
    use bga\app\AjaxHelper;

    if (isset($_POST['member_id'])) {

        $memberFound = Member::findById($_POST['member_id']);

        if ($memberFound->success()) {
            $memberDeleted = $memberFound->model()->delete();



            if ($memberDeleted->success()) {
                AjaxHelper::outputSuccess();
            } else {
                die($memberDeleted->getMessage());
                // Unexpected problem deleting the model.
                AjaxHelper::outputInternalServerError();
            }
        } else {
            // Member id not found.
            AjaxHelper::outputBadRequest();
        }
    } else {
        // No member id provided.
        AjaxHelper::outputBadRequest();
    }
}