<?php $cal = [
    array ( "from" => "21 Apr", "to" => "22 Apr", "output" => "&#x1F423;" ), //Easter hatching chick
    array ( "from" => "30 Oct", "to" => "02 Nov", "output" => "&#x1F383;" ), //Halloween pumpkin
    array ( "from" => "19 Dec", "to" => "31 Dec", "output" => "&#x1F384;" ), //Christmas tree
    array ( "from" => "31 Dec", "to" => "02 Jan next year", "output" => "&#x1F386;" ) //New year fireworks
];
$output = "";
$time = time();
foreach($cal as $event) {
    if(($time > strtotime($event['from'])) && ($time < strtotime($event['to']))) {
        $output .= $event['output'];
    }
}
echo $output; ?>
