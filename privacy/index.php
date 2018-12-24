<?php include "response-headers.php"; content_security_policy(); ?>
<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Privacy Notice</title>
    <meta name="description" content="Information on data that is collected and how it is processed.">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/privacy/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Privacy Notice</h1>
    <hr>
    <p>Last Updated: <b>Thursday 13th December 2018</b></p>
    <h2 id="web-server-logs">Web Server Logs</h2>
    <p>When browsing <a href="/">www.jamieweb.net</a>, each request is automatically logged by the web server in the Combined Log Format.</p>
    <p>All log entires are thoroughly anonymized within two hours of collection.</p>
    <p>IP addresses are checked against a bloom filter in order to determine whether they are unique or not, and then replaced with generic non-routable addresses that cannot be programatically returned to their original form.</p>
    <p>User agent strings are matched against an approved list - if no match is found, they will be discarded.</p>
    <p>Referrer URLs will be stripped down to only the scheme and hostname.</p>
    <p>Within two hours, all original logs are erased. Anonymized logs may be kept indefinitely.</p>
    <h2 id="purpose-and-legal-basis-for-processing">Purpose and Legal Basis for Processing</h2>
    <p>The purpose of collecting the above data is to monitor high-level website statistics such as the total number of unique visitors and which search terms are bringing visitors to the site. The legal basis that I rely on to process this personal data is article 6(1)(f) of the GDPR, which allows me to process personal data when it is required for the purposes of my legitimate interests.</p>
    <h2 id="contact">Contact</h2>
    <p>If you have any queries related to this privacy notice, please do not hesitate to <a href="/contact/">contact me</a> using any of the available methods.</p>
    
    
</div>

<?php include "footer.php" ?>

</body>

</html>






