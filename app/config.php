<?php

namespace bga\app {

    define('BASE_DIR', dirname(dirname(__FILE__)) . '/');

    define('APP_DIR', BASE_DIR . 'app/');
    define('VIEWS_DIR', APP_DIR . 'views/');
    define('SRC_DIR', APP_DIR . 'src/');
    define('SRC_CONFIG_DIR', SRC_DIR . 'ajax/');
    define('SRC_DATA_DIR', SRC_DIR . 'data/');
    define('SRC_MODELS_DIR', SRC_DATA_DIR . 'models/');
    define('SRC_VALIDATION_DIR', SRC_DIR . 'validation/');

    define('PUBLIC_DIR', BASE_DIR . 'public/');

    ob_start();


    /**
     * Provides global data for javascript.
     * @return string
     */
    function getClientDataJsonString()
    {
        $baseUrl = baseUrl();

        $clientData = array(
            'url' => $baseUrl . '/bga/public/',
            'ajaxUrl' => $baseUrl . '/bga/public/ajax/'
        );

        return json_encode($clientData, JSON_UNESCAPED_SLASHES);
    }


    /**
     * based on: https://stackoverflow.com/questions/2820723/how-to-get-base-url-with-php
     * @return string
     */
    function baseUrl()
    {
        return sprintf(
            "%s://%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME']
        );
    }



}