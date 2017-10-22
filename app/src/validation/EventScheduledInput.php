<?php
namespace  bga\app\validation;

require_once 'Input.php';

class EventScheduledInput extends Input
{
    function performValidation($value)
    {
        return true;

        // Check length.

//        $lenResult = $this->checkLen($value,
//            ValidationConstants::EVENT_VENUE_MIN_LEN,
//            ValidationConstants::EVENT_VENUE_MAX_LEN);
//
//        if ($lenResult !== true) {
//            return $this->invalidate($lenResult);
//        }
//
//        return true;
    }
}