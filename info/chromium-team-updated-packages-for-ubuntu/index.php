<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Updated Chromium Browser Packages for Ubuntu</title>
    <meta name="description" content="How to get more up-to-date chromium-browser packages on Ubuntu.">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/info/chromium-team-updated-browser-packages-for-ubuntu/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Updated Chromium Browser Packages for Ubuntu</h1>
    <hr>
    <h2>The Problem</h2>
    <p>In Ubuntu, the <code>chromium-browser</code> package is in the Canonical Universe repository, which means that it is community-maintained rather than officially supported by Canonical.</p>
    <p>The result of this is that the <code>chromium-browser</code> package is sometimes out of date, leaving you running an older version of Chromium Browser rather than the latest stable release.</p>
    <h2>The Solution</h2>
    <p>The Launchpad PPA <code>chromium-team</code> contains Chromium Browser packages that are updated more regularly. The <code>stable</code>, <code>beta</code> and <code>dev</code> branches are available.</p>
    <p>You can add this PPA to your system by first ensuring that the <code>software-properties-common</code> package is installed, then running the following command (for whicver branch you want):</p>
    <pre>$ sudo apt-add-respository ppa:chromium-team/stable</pre>
    <h2>Is the chromium-team repository safe to use?</h2>
    <p>The <code>chromium-browser</code> packages in the <code>chromium-team</code> PPA are primarily maintained by Olivier Tilloy of Canonical. The PPA is also referenced in the official Chromium repository in <code><a href="https://chromium.googlesource.com/chromium/src/+/HEAD/docs/linux_chromium_packages.md" target="_blank" rel="noopener">docs/linux_chromium_packages.md</a></code>.</p>
</div>

<?php include "footer.php" ?>

</body>

</html>
