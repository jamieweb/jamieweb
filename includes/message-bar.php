<?php $schedule = [
    array (
        "from" => "04 Jan 2019",
        "to" => "05 Jan 2019",
        "prefix" => "Currently sponsored by:",
        "message" => "Example message.",
        "href" => "/"
    ),
    array (
        "from" => "04 Jan 2019",
        "to" => "05 Jan 2019",
        "prefix" => "Currently supported by:",
        "message" => "Example message.",
        "href" => "/"
    ),
];
$time = time();
foreach($schedule as $message) {
    if(($time > strtotime($message['from'])) && ($time < strtotime($message['to']))) {
        echo "<div class=\"full-width-bar message-bar\">
    <div class=\"body-width-bar\">
        <div class=\"centertext\">
            <p><b>" . $message['prefix'] . "</b> <a href=\"" . $message['href'] . "\" target=\"_blank\" rel=\"noopener\">" . $message['message'] . "</p></a>
        </div>
    </div>
</div>\n";
        break;
    }
} ?>
