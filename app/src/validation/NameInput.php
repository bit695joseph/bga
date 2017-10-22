<?php
namespace  bga\app\validation;

require_once 'Input.php';

class NameInput extends Input
{
    function performValidation($value)
    {
        // Check length.

        $lenResult = $this->checkLen($value,
            ValidationConstants::NAME_MIN_LEN,
            ValidationConstants::NAME_MAX_LEN);

        if ($lenResult !== true) {
            return $this->invalidate($lenResult);
        }

        return true;
    }
}