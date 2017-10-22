<?php

namespace bga\app\validation;

/**
 * Class VC
 *
 * Validation Constants.
 *
 * @package bga\app\validation
 */
class ValidationConstants
{

    // MEMBER

    const NAME_MIN_LEN = 1;
    const NAME_MAX_LEN = 32;

    const PHONE_MIN_LEN = 6;
    const PHONE_MAX_LEN = 20;

    const PHONE_MIN_DIGITS = 4;
    const PHONE_MAX_DIGITS = 15;

    const EMAIL_MIN_LEN = 6;
    const EMAIL_MAX_LEN = 64;

    // GAME

    const GAME_NAME_MIN_LEN = 1;
    const GAME_NAME_MAX_LEN = 64;

    // EVENT

    const EVENT_VENUE_MIN_LEN = 1;
    const EVENT_VENUE_MAX_LEN = 512;


}