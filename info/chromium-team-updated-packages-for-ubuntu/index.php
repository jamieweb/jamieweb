<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Updated Chromium Browser Packages for Ubuntu</title>
    <meta name="description" content="How to get regularly updated chromium-browser packages on Ubuntu.">
    <meta name="keywords" content="Jamie, Scaife, jamie scaife, jamiescaife, jamieonubuntu, jamie90437, jamie90437x, jamieweb, jamieweb.net">
    <meta name="author" content="Jamie Scaife">
    <link href="/jamie.css" rel="stylesheet">
    <link href="https://www.jamieweb.net/info/chromium-team-updated-browser-packages-for-ubuntu/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Updated Chromium Browser Packages for Ubuntu</h1>
    <hr>
    <h2>The Problem</h2>
    <p>In Ubuntu, the <code>chromium-browser</code> package is in the Canonical Universe repository, which means that it is community-mainted rather than officially supported by Canonical.</p>
    <p>The result of this is that updates to <code>chromium-browser</code> are often not promptly released, leaving you running an older version than the latest stable release.</p>
    <h2>The Solution</h2>
    <p>The Launchpad PPA <code>chromium-team</code> contains Chromium Browser packages that are updated roughly in-line with the main Google Chrome release schedule. The <code>stable</code>, <code>beta</code> and <code>dev</code> branches are available.</p>
    <p>You can add this PPA to your system by first ensuring that the <code>software-properties-common</code> package is installed, then running the following command (for whicver branch you want):</p>
    <pre>$ sudo apt-add-respository ppa:chromium-team/stable</pre>
    <h2>Is the chromium-team PPA Official and Legitimate?</h2>
    <p></p>
</div>

<?php include "footer.php" ?>

</body>

</html>
