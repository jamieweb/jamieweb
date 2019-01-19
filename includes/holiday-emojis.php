<?php $cal = [
    array ( "from" => "21 Apr", "to" => "23 Apr", "output" => "<span title=\"Happy Easter!\">&#x1f423;</span>" ), //Easter hatching chick
    array ( "from" => "30 Oct", "to" => "02 Nov", "output" => "<span title=\"Happy Halloween!\">&#x1f383;</span>" ), //Halloween pumpkin
    array ( "from" => "19 Dec", "to" => "31 Dec", "output" => "<span title=\"Happy Holidays!\">&#x1f384;</span>" ), //Christmas tree
    array ( "from" => "31 Dec", "to" => "02 Jan next year", "output" => "<span title=\"Happy New Year!\">&#x1f386;</span>" ) //New year fireworks
];
$time = time();
foreach($cal as $event) {
    if(($time > strtotime($event['from'])) && ($time < strtotime($event['to']))) {
        echo $event['output'];
    }
} ?>
