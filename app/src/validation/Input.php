<?php

namespace bga\app\validation;

abstract class Input
{
    /**
     * @var The validated value (optionally cleaned up).
     */
    private $value;

    /**
     * @var
     */
    private $key;

    /**
     * @var Readable name for error messages.
     */
    private $label;

    /**
     * @var Validation error message.
     */
    private $message;


    private $required;

    private $column;



    /**
     * @var The outcome of the validation (TRUE if valid).
     * Exists only to prevent invalid access to error messages
     * and the prepared value.
     */
    private $ok;
    private $invalidated;


    function __construct($key, $label, $required = true)
    {
        $this->invalidated = false;
        $this->key = $key;
        $this->label = $label;
        $this->required = $required;
    }


    /**
     * Prepares and validates the input.
     *
     * @param $rawValue the value as it was entered into the system.
     * @return bool TRUE if validation was successful, otherwise FALSE.
     */
    public function validate($rawValue)
    {
        $this->value = $this->prepare($rawValue);

        if ($this->required && empty($this->value)) {
            return $this->invalidate($this->label . " is required.");
        }

        return $this->performValidation($this->value);
    }



    public function getMessage()
    {
        return $this->message;
    }


    public function getValue()
    {
        return $this->value;
    }


    public function getKey()
    {
        return $this->key;
    }

    public function ok()
    {
        return $this->ok;
    }


    /**
     * Clean up the input - called before performValidation().
     * Default implementation removes leading and trailing whitespace.
     * @param $raw_value
     * @return string
     */
    protected function prepare($raw_value)
    {
        return trim($raw_value);
    }

    protected function invalidate($message)
    {
        $this->ok = false;
        $this->invalidated = true;
        $this->message = $message;
        return false;
    }

    public function invalidated() {

        return $this->invalidated;
    }

    protected function checkLen($value, $minLen, $maxLen)
    {
        $len = strlen($value);

        if ($len < $minLen)
            return sprintf("%s must have at least %d characters.", $this->label, $minLen);

        if ($len > $maxLen)
            return sprintf("%s cannot exceed %d characters.", $this->label, $maxLen);

        return true;
    }


    /**
     * @param $value
     * @return mixed
     */
    abstract protected function performValidation($value);
}