<?php

namespace bga\app\validation;

require_once 'Input.php';
require_once 'ValidationConstants.php';

class PhoneInput extends Input
{

    function performValidation($value)
    {
        // Check length.

        $lenResult = $this->checkLen($value,
            ValidationConstants::PHONE_MIN_LEN,
            ValidationConstants::PHONE_MAX_LEN);

        if ($lenResult !== true) {
            return $this->invalidate($lenResult);
        }

        // Check digit count.

        $digitCount = strlen(
            preg_replace("/[^0-9]/", "", $value));

        // Check min digits.
        if ($digitCount < ValidationConstants::PHONE_MIN_DIGITS) {
            $msg = sprintf("Phone number must have at least %d digits.",
                ValidationConstants::PHONE_MIN_DIGITS);

            return $this->invalidate($msg);
        }

        // Check max digits.
        if ($digitCount > ValidationConstants::PHONE_MAX_DIGITS) {
            $msg = sprintf("Phone number cannot exceed %d digits.",
                ValidationConstants::PHONE_MAX_DIGITS);

            return $this->invalidate($msg);
        }

        return true;
    }
}