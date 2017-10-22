<?php
/**
 * Created by PhpStorm.
 * User: Joseph
 * Date: 22/10/2017
 * Time: 12:10 PM
 */

namespace bga\app\data;


class MemberGame
{
    public static function idColumn()
    {
        return 'member_game_id';
    }

    public static function tableName()
    {
        return 'member_game';
    }

    public static function columns()
    {
        return array('member_id', 'game_id');
    }
}