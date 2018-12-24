<?php include "response-headers.php"; content_security_policy(); ?>
<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Adblock Plus Configuration</title>
    <meta name="description" content="Adblock Plus Filter Configuration">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/info/adblock-plus-config/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Adblock Plus Filter Configuration</h1>
    <hr>
    <p><b>Extra filter lists:</b></p>
    <p>Adblock Plus used to include a few extra filter lists that could be enabled from the firstrun configuration page. For some reason, these extra optional filter lists were removed from the firstrun page.</p>
    <p>The lists are still available from the Adblock Plus website if you enter them manually. The top two filter URLs below are the default filters included in Adblock Plus, the other three are the missing ones. Add them to your Adblock Plus config for extra blocking!</p>
    <pre>https://easylist-downloads.adblockplus.org/antiadblockfilters.txt
https://easylist-downloads.adblockplus.org/easylist.txt
https://easylist-downloads.adblockplus.org/malwaredomains_full.txt
https://easylist-downloads.adblockplus.org/fanboy-social.txt
https://easylist-downloads.adblockplus.org/easyprivacy.txt</pre>
    <p><b>Other useful filters:</b></p>
    <pre>*$subdocument
*$object
*.swf
*.pdf</pre>
    <p>Subdocument refers to frames/iframes, object refers to embedded/interactive/rich content.</p>
    <p>Use the following syntax for whitelisting domains:</p>
    <pre>*$subdocument,domain=~whitelisted1.tld|~whitelisted2.tld|~whitelisted3.tld</pre>
    <p>Blocking frames/iframes will completely break many poorly built websites. A possible workaround for this is to open the developer console and find the ERR_BLOCKED_BY_CLIENT error for the blocked frame/iframe and go to the URL directly in a new tab. It also breaks Google reCAPTCHA, so you'll have to whitelist websites where you need to solve those.</p>
    <p>These filter lists and the filter syntax is also compatible with some other Adblocking software such as uBlock Origin.</p>
</div>

<?php include "footer.php" ?>

</body>

</html>
