<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Pastebin Keyword Alerts</title>
    <meta name="description" content="Using the Pastebin Alerts Service to find your public information in data dumps.">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/blog/pastebin-keyword-alerts/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Pastebin Keyword Alerts</h1>
    <hr>
    <p><b>Saturday 2nd September 2017</b></p>
    <p>The <a href="https://pastebin.com/alerts" target="_blank" rel="noopener">Pastebin Alerts Service</a> is a lesser-known feature of Pastebin that I find extremely useful. It's a notification service that allows you to set alert keywords, and when those keywords appear in a new public paste, you will be notified via email.</p>
    <img src="/blog/pastebin-keyword-alerts/alerts-description.png">
    <p>A standard Pastebin account can set up to 3 keywords, each of which has a maximum of 10 notifications or 90 days before they must be renewed, whichever is met first. To clarify, if you receive 10 paste notifications for a particular keyword, the notifications will stop and you'll have to manually set up the keywords again. This is to prevent abuse. Note that Pastebin PRO accounts do not have these restrictions, and can have up to 15 keywords permanently enabled.</p>
    <p>Whenever a public paste is made that contains one of your keywords, you will receive a notification via email, for example:</p>
    <pre>Hi JamieOnUbuntu

You are currently subscribed to the Pastebin Alerts service.

We found pastes online that matched your alerts keyword: '139.162.222.67'.

https://pastebin.com/QbwBqQQr

If you want to cancel this alerts service, please login to your Pastebin account, and remove this keyword from your Alerts page.

Kind regards,

The Pastebin Team</pre>
    <p>I personally use the alerts feature to monitor various public information associated with my website, such as the IP addresses, domain name, etc. I have received a few notifications so far, none of which were particularly noteworthy however it is incredibly interesting to see where your information is been posted online:</p>
    <pre><a href="https://pastebin.com/njwxPKrt" target="_blank" rel="noopener">https://pastebin.com/njwxPKrt</a> - "jamieweb" - 1st September 2017 @ 2:20pm - <b>Tor Hidden Service Address List</b>
<a href="https://pastebin.com/QERfB0jv" target="_blank" rel="noopener">https://pastebin.com/QERfB0jv</a> - "jamieweb" - 1st September 2017 @ 8:08am - <b>Unknown (Paste Removed)</b>
<a href="https://pastebin.com/QbwBqQQr" target="_blank" rel="noopener">https://pastebin.com/QbwBqQQr</a> - "139.162.222.67" - 10th August 2017 @ 6:03pm - <b>IP Address List</b></pre>
    <p>It may not be necessary to add your email address as a keyword since there is already kind of a service for this. <a href="https://twitter.com/dumpmon" target="_blank" rel="noopener">@dumpmon</a> on Twitter is a bot that monitors multiple different paste websites and automatically tweets when it finds a suspected information dump. Dump Monitor is also responsible for bringing paste data to <a href="https://haveibeenpwned.com/" target="_blank" rel="noopener">Have I been pwned?</a>, where you can easily search pastes for your email address.</p>
    <p>The main downside of the Pastebin Alerts Service is the limit of 3 keywords for standard user accounts. This limit can be raised to 15 with a Pastebin PRO account, however I personally am absolutely fine with just the 3. I'm sure it would be possible to cheat the system by using multiple user accounts, however this is a violation of the <a href="https://pastebin.com/terms" target="_blank" rel="noopener">Pastebin Terms of Service</a>, so I do not recommend it. Account terms, section 5 reads:</p>
    <pre>5. One person or legal entity may not maintain more than one free account.</pre>
    <p>Talking about the alerts that I have set up here does not compromise their usefulness. I have the alerts set up in order to alert me when my details are found in a mass information dump, not to detect more sophisticated attack. If there was a more sophisticated attack on myself, it's unlikely the attacker would be posting about it publicly on Pastebin.</p>
    <p>I highly recommend that you sign up for Pastebin if you haven't already and add some alert keywords, it's very interesting to see what information dumps your data ends up in. I do not recommend setting keywords that contain private information, such as passwords, home addresses or phone numbers. The Pastebin Alerts service is better suited for notifying you when your public information appears in a dump, rather than checking whether your private information has been leaked.</p>
    <p>Of course there are countless other online paste services, however Pastebin is the most popular so a large portion of the information available will likely be found there.</p>
    <p>I have no affiliation with Pastebin.</p>
</div>

<?php include "footer.php" ?>

</body>

</html>
