<?php


namespace bga\app;


/**
 * Class AjaxHelper
 *
 * Json responses.
 *
 * @package bga\app
 */
class AjaxHelper
{
    // Messages.
    const SUCCESS = 'success';
    const BAD_REQUEST = '400 Bad Request';
    const INTERNAL_SERVER_ERROR = '500 Internal Server Error';


    /* Public Methods */


    public static function outputSuccess()
    {
        self::outputJsonHeader();
        self::exitWithJsonMessage(self::SUCCESS);
    }

    public static function outputSuccessWithData($data)
    {
        $payload = array_merge(array('success' => true), $data);
        self::outputJsonHeader();
        exit(json_encode($payload));

    }

    public static function outputBadRequest()
    {
        self::outputErrorAndExit(self::BAD_REQUEST);
    }

    public static function outputInternalServerError()
    {
        self::outputErrorAndExit(self::INTERNAL_SERVER_ERROR);
    }





    /* Private Methods */


    private static function outputErrorAndExit($message)
    {
        self::outputErrorHeader($message);
        self::outputJsonHeader();
        self::exitWithJsonMessage($message);
    }

    private static function outputJsonHeader()
    {
        header('Content-Type: application/json; charset=UTF-8');
    }

    private static function exitWithJsonMessage($message)
    {
        exit(json_encode(array('message' => $message)));
    }

    private static function outputErrorHeader($message)
    {
        header($_SERVER["SERVER_PROTOCOL"] . $message);
    }





}