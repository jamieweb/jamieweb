<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Privacy</title>
    <meta name="description" content="Privacy">
    <meta name="keywords" content="Jamie, Scaife, jamie scaife, jamiescaife, jamieonubuntu, jamie90437, jamie90437x, jamieweb, jamieweb.net">
    <meta name="author" content="Jamie Scaife">
    <link href="/jamie.css" rel="stylesheet">
    <link href="https://www.jamieweb.net/privacy/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Privacy</h1>
    <hr>
    <p></p>
    <!--<h2 id="cookies">Cookies</h2>
    <p>This site does not set any cookies.</p>-->
    <h2 id="email">Email Notification Service</h2>
    <h3>&bull; Usage</h3>
    <p>Your email address will be used solely for sending notification emails when I post new content.
    <p>It will <b>never</b> be used for tracking, analytics, marketing, promotion, etc.</p>
    <h3>&bull; Processing</h3>
    <p>I use <a href="https://www.mailgun.com/" target="_blank">Mailgun</a> for the sending of all automated emails. (Mailgun is <b>not</b> used for receiving emails.)</p>
    <p>Upon subscribing to the email notification service, an automated verification email will be sent to you using Mailgun. Your email address will also be stored on my web server for a maximum of 10 minutes for the purpose of the verification process.</p>
    <p>If you successfully verify your email address by entering the verification code, your email address will be added to the mailing list on my Mailgun account, which is protected by a 64+ character password as well as two-factor authentication.</p>
    <p>After the 10 minute verification period has expired, your email address will be permanently deleted from my web server using <a href="https://linux.die.net/man/1/shred" target="_blank">shred</a>. This deletion occurs whether you successfully verified your email address or not. The mailing list containing your email address is not stored on my web server, it is stored only on my Mailgun account. Note that your email address may still be stored in log files, temporary files, etc. I will also take occasional offline backups of the mailing list for data redundancy purposes.</p>
    <h3>&bull; Sharing</h3>
    <p>Your email address will be shared with Mailgun in order to be added to the mailing list and to allow for sending automated email.</p>
    <h3>&bull; Unsubscribing</h3>
    <p>You can unsubscribe at any time by visiting the unsubscribe link present at the bottom of any notification email or the original subscription confirmation email.</p>
</div>

<?php include "footer.php" ?>

</body>

</html>
