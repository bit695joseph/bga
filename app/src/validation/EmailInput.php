<?php

namespace bga\app\validation;

require_once 'Input.php';

class EmailInput extends Input
{

    function performValidation($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return $this->invalidate("Email address is not in the correct format.");
        }

        return true;
    }


}