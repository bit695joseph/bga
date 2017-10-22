<?php
namespace  bga\app\validation;

require_once 'Input.php';

class EventVenueInput extends Input
{
    function performValidation($value)
    {
        // Check length.

        $lenResult = $this->checkLen($value,
            ValidationConstants::EVENT_VENUE_MIN_LEN,
            ValidationConstants::EVENT_VENUE_MAX_LEN);

        if ($lenResult !== true) {
            return $this->invalidate($lenResult);
        }

        return true;
    }
}