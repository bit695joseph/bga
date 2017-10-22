<?php

namespace bga\app\data {

    use DateTime;

    require_once('Model.php');

    class Event extends Model
    {
        public static function idColumn()
        {
            return 'event_id';
        }

        public static function tableName()
        {
            return 'event';
        }

        public static function columns()
        {
            return array('venue', 'scheduled');
        }
        //echo date("c", strtotime($row['Time']));


        public function getScheduledForForm()
        {
            $dt = \DateTime::createFromFormat('Y-m-d H:i:s',$this->data['scheduled']);
            $date = $dt->format('Y-m-d\TH:i');




            return  $date;
        }


    }
}