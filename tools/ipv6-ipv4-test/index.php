<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>IPv6 / IPv4 Connection Test</title>
    <meta name="description" content="Test whether you have a working IPv6 and IPv4 internet connection.">
    <meta name="keywords" content="Jamie, Scaife, jamie scaife, jamiescaife, jamieonubuntu, jamie90437, jamie90437x, jamieweb, jamieweb.net">
    <meta name="author" content="Jamie Scaife">
    <link href="/jamie.css" rel="stylesheet">
    <link href="https://ipv6.jamieweb.net/ipv6-only.css" rel="stylesheet">
    <link href="https://ipv4.jamieweb.net/ipv4-only.css" rel="stylesheet">
    <link href="https://www.jamieweb.net/tools/ipv6-ipv4-test/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>IPv6 / IPv4 Connection Test</h1>
    <hr>
    <p>This page will allow you to check whether you have a working IPv6 and IPv4 internet connection.</p>
    <ul class="ipv6-ipv4-test">
        <li>IPv4 Connection? <span class="ipv4-test"></span></li>
        <li>IPv6 Connection? <span class="ipv6-test"></span></li>
    </ul>
    <hr>
    <h2>How does it work?</h2>
    <p>I operate two additional subdomains, ipv4.jamieweb.net and ipv6.jamieweb.net. These are only accessible over their corresponding IP versions, and just host simple pages in order to test your connection.</p>
    <p>This page will try to load some CSS from each of the test subdomains. If your browser is able to connect, the style will load and be applied, which will change the text above to "Yes" in green from the default which is "No" in red.</p>
    <h2>API</h2>
    <p>I am working on setting up a basic API in order to check your connection, the details will be available here once complete.</p>
</div>

<?php include "footer.php" ?>

</body>

</html>
