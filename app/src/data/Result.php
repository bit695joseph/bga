<?php


namespace bga\app\data;


/**
 * Class Result
 * @package bga\app\data
 */
class Result
{
    const SUCCESS = 1;
    const EMPTY = 0;
    const ERROR = -1;

    private $status;
    private $models;
    private $message;


    private function __construct($status, $models = null, $message = null)
    {
        $this->status = $status;
        $this->models = $models;
        $this->message = $message;
    }

    public static function createSuccess($models = null)
    {
        if (is_null($models)) {
            return new Result(self::SUCCESS);
        } else if (is_array($models)) {
            return new Result(self::SUCCESS, $models);
        } else {
            return new Result(self::SUCCESS, array($models));
        }
    }

    public static function createError($message)
    {
        return new Result(self::ERROR, $message);
    }

    public static function createEmpty()
    {
        return new Result(self::EMPTY);
    }


    public function success()
    {
        return $this->status === self::SUCCESS;
    }

    public function none()
    {
        return $this->status === self::EMPTY;
    }

    public function error()
    {
        return $this->status === self::ERROR;
    }

    public function status()
    {
        return $this->status;
    }

    public function message()
    {
        return $this->message;
    }


    /**
     * @return mixed The single model in the result.
     */
    public function model()
    {
        switch (count($this->models)) {
            case 1:
                return $this->models[0];
            case 0:
                throw new Exception("Attempted to retrieve singular model but result is empty.");
            default:
                throw new Exception("Attempted to retrieve singular model but there are many.");
        }
    }

    /**
     * @return The models.
     */
    public function models()
    {
        if (!empty($this->models)) {
            return $this->models;
        }

        throw new Exception("Attempted to retrieve models but there are none.");
    }
}