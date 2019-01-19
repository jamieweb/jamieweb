<?php $schedule = [
    array (
        "from" => "19 Jan 2019",
        "to" => "19 Jan 2020",
        "prefix" => "Want to sponsor my site?",
        "message" => "I am currently looking for sponsors for jamieweb.net - if you'd like to promote your brand or product via a sponsorship, please get in touch!",
        "href" => "/sponsor/"
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
