<?php

namespace bga\app\validation;

abstract class FormValidator
{
    private $inputs;
    private $messages;
    private $ok;
    private $posted;


    public function __construct()
    {
        $this->invalidated = false;
        $this->posted = $_SERVER['REQUEST_METHOD'] === 'POST';
        $this->inputs = $this->configure();
    }

    public function validateIfPost($model)
    {
        if ($this->posted)
            return $this->validate($model);
        return null;
    }

    public function validate($model)
    {
        $this->clear();

        foreach ($this->inputs as $key => $input) {

            $rawValue = $model[$key];

            if (!$input->validate($rawValue)) {
                $this->messages[$key] = $input->getMessage();
            }
        }

        $this->ok = count($this->messages) === 0;

        return $this->ok;
    }

    private function clear()
    {
        $this->ok = false;
        $this->messages = array();
    }

    /**
     * returns an array of messages keyed by input key.
     */
    public function getMessages()
    {
        return $this->messages;
    }

    public function posted()
    {
        return $this->posted;
    }

    public function valueIfPost($key)
    {
        if ($this->posted && isset($this->inputs[$key])) {

            $input = $this->inputs[$key];

            return htmlspecialchars($input->getValue());
        }
    }

    /**
     * Whether the model is valid (ok) or not.
     * @return bool TRUE if valid, otherwise FALSE.
     */
    public function ok()
    {
        return $this->ok;
    }


    public function ifInvalid($key, $class)
    {
        if ($this->posted && $this->inputs[$key]->invalidated())
            return $class;

        return "";
    }

    public function getMessage($key)
    {
        if ($this->posted && $this->inputs[$key]->invalidated())
            return $this->messages[$key];

        return "";
    }

    public function getBootstrapClass($key)
    {
        if ($this->posted)
        {
            return $this->inputs[$key]->invalidated()
                ? "is-invalid"
                : "is-valid";
        }

        return "";
    }



    public function getData()
    {
        $data = array();

        foreach ($this->inputs as $key => $input) {
            $data[$key] = $input->getValue();
        }

        return $data;
    }


    /**
     * Override for each form.
     * @return array The Input subclasses object that validate each form field.
     */
    abstract protected function configure();




    public static function reqVar($name) {
        return $_REQUEST[$name];
    }




}