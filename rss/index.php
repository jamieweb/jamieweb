<?php include "response-headers.php"; content_security_policy(["style-src" => "'unsafe-inline'"]); ?>
<?xml version="1.0" encoding="utf-8" ?>
<rss version="2.0">

<channel>
    <title>JamieWeb (jamieweb.net)</title>
    <link>https://www.jamieweb.net</link>
    <description>Website of Jamie Scaife - United Kingdom</description>
    <image>
        <title>JamieWeb (jamieweb.net)</title>
        <url>https://www.jamieweb.net/images/jamieweb.png</url>
        <link>https://www.jamieweb.net</link>
    </image>
<?php include "bloglist.php"; bloglist("rss"); ?>
</channel>

</rss>
