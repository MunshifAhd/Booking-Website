<?php
require_once ( 'Connection.php' );
// $date = date("y-m-d");
class EntryClass extends connectionClass{
// $isToday = date('Ymd') == date('Ymd', strtotime($someDate));
public function addEntry($name){
        $insert="UPDATE booking SET booking_status='$name' WHERE booking_status='booked'";
        $this->query($insert);
    }
}

 ?>
