<?php $cal = [
    array ( "from" => "21 Apr", "to" => "22 Apr", "output" => "&#x1f423;" ), //Easter hatching chick
    array ( "from" => "30 Oct", "to" => "02 Nov", "output" => "&#x1f383;" ), //Halloween pumpkin
    array ( "from" => "19 Dec", "to" => "31 Dec", "output" => "&#x1f384;" ), //Christmas tree
    array ( "from" => "31 Dec", "to" => "02 Jan next year", "output" => "&#x1f386;" ) //New year fireworks
];
$time = time();
foreach($cal as $event) {
    if(($time > strtotime($event['from'])) && ($time < strtotime($event['to']))) {
        echo $event['output'];
    }
} ?>
