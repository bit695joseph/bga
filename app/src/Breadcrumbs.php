<?php


namespace bga\app {


    /**
     * Class Breadcrumbs
     *
     * @package bga\app
     */
    class Breadcrumbs
    {
        public  $activeName;
        public  $crumbs;

        public function __construct($activeName, $upArr, $baseUrl)
        {
            $this->activeName = $activeName;


            $this->crumbs = [
                "Home" => $baseUrl
            ];

            if ($upArr != null) {
                foreach ($upArr as $name => $fileName) {
                    $this->crumbs[$name] = $baseUrl . $fileName;
                }
            }
        }



    }

}