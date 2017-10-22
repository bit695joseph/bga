<?php

namespace bga\app\data {

    require_once('Model.php');

    class Game extends Model
    {
        public static function idColumn()
        {
            return 'game_id';
        }

        public static function tableName()
        {
            return 'game';
        }

        public static function columns()
        {
            return array('name');
        }


    }
}