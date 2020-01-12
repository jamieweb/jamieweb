<?php $schedule = [
    array (
        "from" => "19 Jan 2019",
        "to" => "11 Jan 2020",
        "prefix" => "Want to sponsor my site?",
        "message" => "I am currently looking for sponsors for jamieweb.net - if you'd like to promote your brand or product via a sponsorship, please get in touch!",
        "href" => "/sponsor/"
    ),
    array (
        "from" => "12 Jan 2020",
        "to" => "16 Apr 2020",
        "prefix" => "Currently sponsored by:",
        "message" => "<u>KEYCHEST</u> - Expiry Management for web and intranet HTTPS/TLS - cert purchase with zero-margin - Let's Encrypt proxy & rate-limit monitoring",
        "href" => "https://keychest.net/"
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
