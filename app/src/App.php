<?php

namespace bga\app {

    include 'NavItem.php';
    include 'Breadcrumbs.php';

    class App
    {
        private static $activePage;

        private static $breadcrumbs = null;

        private static $pageData;

        private static $pageTitle;

        public static function setPageTitle($pageTitle)
        {
            self::$pageTitle = $pageTitle;
        }

        public static function setActivePage($activePage)
        {
            self::$activePage = $activePage;
        }

        public static function hasBreadcrumbs()
        {
            return !empty(self::$breadcrumbs);
        }



        public static function setBreadcrumbs($activeName, $upArr = [])
        {
            self::$breadcrumbs =
                new Breadcrumbs($activeName, $upArr, self::publicBaseUrl());
        }


        public static function getBreadcrumbs()
        {
            return self::$breadcrumbs;
        }

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


        private static function publicBaseUrl()
        {
            return self::baseUrl() . '/bga/public/';
        }


        public static function getPageTitle()
        {
            return self::$pageTitle . " | Board Game Aficionados";
        }


        public static function redirectTo($location)
        {
            header("Location: {$location}");
        }

        public static function badRequest()
        {
            header($_SERVER["SERVER_PROTOCOL"] . " 400 bad request.");
            exit();
        }

        public static function serverError()
        {
            header($_SERVER["SERVER_PROTOCOL"] . " 500 server error.");
            exit();
        }


        public static function isPost()
        {
            return $_SERVER['REQUEST_METHOD'] === 'POST';
        }

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


        public static function setClientPageData($pageData)
        {
            self::$pageData = $pageData;
        }



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


