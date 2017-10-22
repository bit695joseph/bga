<?php

namespace bga\app {

    include 'NavItem.php';
    include 'Breadcrumbs.php';

    /**
     * Class App
     *
     * Utility methods.
     *
     * @package bga\app
     */
    class App
    {
        private static $activePage;

        private static $breadcrumbs = null;

        private static $pageData;

        private static $pageTitle;

        /**
         * Set the page title.
         * @param $pageTitle
         */
        public static function setPageTitle($pageTitle)
        {
            self::$pageTitle = $pageTitle;
        }


        /**
         * Sets the highlighted link in the nav menu.
         * @param $activePage
         */
        public static function setActivePage($activePage)
        {
            self::$activePage = $activePage;
        }

        /**
         * True if this page has breadcrumbs defined.
         * @return bool
         */
        public static function hasBreadcrumbs()
        {
            return !empty(self::$breadcrumbs);
        }


        /**
         * Setse the breadcrumbs for this page.
         * @param $activeName
         * @param array $upArr
         */
        public static function setBreadcrumbs($activeName, $upArr = [])
        {
            self::$breadcrumbs =
                new Breadcrumbs($activeName, $upArr, self::publicBaseUrl());
        }


        /**
         * The breadcrumbs for this page.
         */
        public static function getBreadcrumbs()
        {
            return self::$breadcrumbs;
        }

        /**
         * Gets the navigation link data.
         * @return array
         */
        public static function getNavItems()
        {
            $base = self::publicBaseUrl();

            $navItems = [
                "Events" => new NavItem("Events", $base . "events.php"),
                "Members" => new NavItem("Members", $base . "members.php"),
                "Games" => new NavItem("Games", $base . "games.php"),
                "Scores" => new NavItem("Scores", $base . "scores.php"),
            ];

            // Change the state of the active nav item, if there is one.
            if (self::$activePage != null) {
                $activeNavItem = $navItems[self::$activePage];
                $activeNavItem->activeClass = 'active';
                $activeNavItem->disabledClass = 'disabled';
            }

            return $navItems;
        }


        /**
         * Address for publicallly accessible files.
         * @return string
         */
        private static function publicBaseUrl()
        {
            return self::baseUrl() . '/bga/public/';
        }


        /**
         * Appends the website name to the page title.
         *
         * @return string
         */
        public static function getPageTitle()
        {
            return self::$pageTitle . " | Board Game Aficionados";
        }


        /**
         * Outputs a location header for redirecting.
         * @param $location
         */
        public static function redirectTo($location)
        {
            header("Location: {$location}");
        }

        /**
         * Outputs a 400 header.
         */
        public static function badRequest()
        {
            header($_SERVER["SERVER_PROTOCOL"] . " 400 bad request.");
            exit();
        }

        /**
         * Outputs a 500 header.
         */
        public static function serverError()
        {
            header($_SERVER["SERVER_PROTOCOL"] . " 500 server error.");
            exit();
        }


        /**
         * Shorthand for _SERVER['REQUEST_METHOD'] === 'POST';
         * @return bool
         */
        public static function isPost()
        {
            return $_SERVER['REQUEST_METHOD'] === 'POST';
        }

        /**
         * Shorthand for $_SERVER['REQUEST_METHOD'] === 'GET'
         * @return bool
         */
        public static function isGet()
        {
            return $_SERVER['REQUEST_METHOD'] === 'GET';
        }

        /**
         * escape HTML special characters and echo.
         *
         * @param $textToEscapeAndEcho
         */
        public static function e($textToEscapeAndEcho)
        {
            echo htmlspecialchars($textToEscapeAndEcho);
        }

        /**
         *
         * TODO: Duplicated in config.php - consolidate.
         *
         * @return string
         */
        public static function baseUrl()
        {

            return sprintf(
                "%s://%s",
                isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
                $_SERVER['SERVER_NAME']
            );
        }


        /**
         * Sets the data for javascript.
         * @param $pageData
         */
        public static function setClientPageData($pageData)
        {
            self::$pageData = $pageData;
        }


        /**
         * The client data as a json string.
         * @return string
         */
        public static function getClientDataJsonString()
        {
            $baseUrl = baseUrl();

            return json_encode([

                'url' => $baseUrl . '/bga/public/',
                'ajaxUrl' => $baseUrl . '/bga/public/ajax/',
                'pageData' => self::$pageData

            ], JSON_UNESCAPED_SLASHES);
        }
    }
}


