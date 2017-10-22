<?php
namespace  bga\app\validation;

require_once 'FormValidator.php';
require_once 'EventVenueInput.php';

class EventFormValidator extends FormValidator
{
    protected function configure()
    {
        // parameters: name/key, label

        return array(
            "venue"=> new EventVenueInput("venue", "Event venue"),
            "scheduled"=> new EventVenueInput("scheduled", "Date and time")
        );
    }
}
