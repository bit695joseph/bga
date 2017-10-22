<?php
namespace  bga\app\validation;

require_once 'Input.php';

class GameNameInput extends Input
{
    function performValidation($value)
    {
        // Check length.

        $lenResult = $this->checkLen($value,
            ValidationConstants::GAME_NAME_MIN_LEN,
            ValidationConstants::GAME_NAME_MAX_LEN);

        if ($lenResult !== true) {
            return $this->invalidate($lenResult);
        }

        return true;
    }
}