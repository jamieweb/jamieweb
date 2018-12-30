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
    <p>Last Updated: <b>Sunday 30th December 2018</b></p>
    <h2 id="web-server-logs">Web Server Logs</h2>
    <p>When visiting <a href="/">www.jamieweb.net</a>, each request is automatically logged by the web server in the Combined Log Format.</p>
    <p>All log entires are thoroughly anonymized within two hours of collection.</p>
    <p>IP addresses are checked against a bloom filter in order to determine whether they are unique or not, and then replaced with generic non-routable addresses that cannot be programatically returned to their original form.</p>
    <p>User agent strings are matched against an approved list - if no match is found, they will be discarded.</p>
    <p>Referrer URLs are stripped down to only the scheme and hostname.</p>
    <p>The anonymization is performed using this tool: <a href="https://gitlab.com/jamieweb/web-server-log-anonymizer-bloom-filter" target="_blank" rel="noopener">web-server-log-anonymizer-bloom-filter</a></p>
    <p>Within two hours, all original logs are erased. Anonymized logs may be kept indefinitely.</p>
    <h4 id="web-server-logs-purpose-and-legal-basis-for-processing">Purpose and Legal Basis for Processing</h4>
    <p>The purpose of collecting the above web server access log data is to monitor high-level website statistics such as the total number of unique visitors and which search terms are bringing visitors to the site. The legal basis that I rely on to process this personal data is article 6(1)(f) of the GDPR, which allows me to process personal data when it is required for the purposes of my legitimate interests.</p>
    <h2 id="email-subscriptions">Email Subscriptions</h2>
    <p>You may optionally provide your email address in order to receive notifications when I post new content to this blog.</p>
    <p>The email subscription service is provided by <a href="https://www.getrevue.co/" target="_blank" rel="noopener">Revue</a>. You can read their applicable privacy policy <a href="https://www.getrevue.co/privacy/platform" target="_blank" rel="noopener">here</a>.</p>
    <p>I will also take periodic backups of the email address list for data redundancy purposes, and these will be securely stored offline in an encrypted format.</p>
    <h2 id="contact">Contact</h2>
    <p>If you have any queries related to this privacy notice, please do not hesitate to <a href="/contact/">contact me</a> using any of the available methods.</p>
</div>

<?php include "footer.php" ?>

</body>

</html>






