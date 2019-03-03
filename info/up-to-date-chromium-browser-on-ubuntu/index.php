<?php include "response-headers.php"; content_security_policy(); ?>
<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Up-to-date Chromium Browser on Ubuntu</title>
    <meta name="description" content="How to run an up-to-date Chromium browser on Ubuntu using the Chromium Snap.">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/info/up-to-date-chromium-browser-for-ubuntu/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Up-to-date Chromium Browser on Ubuntu</h1>
    <hr>
    <h2>The Problem</h2>
    <p>In Ubuntu, the <code>chromium-browser</code> package is in the Canonical Universe repository, which means that it is community-maintained rather than officially supported by Canonical.</p>
    <p>The result of this is that the <code>chromium-browser</code> package is sometimes out of date, leaving you running an older version of Chromium rather than the latest stable release.</p>

    <h2>The Solution</h2>
    <p>Canonical are working on entirely deprecating the Deb package and moving to using Snaps as the only official method for running always-updated Chromium. Source: <a href="https://community.ubuntu.com/t/intent-to-provide-chromium-as-a-snap-only/5987" target="_blank" rel="noopener">https://community.ubuntu.com/t/intent-to-provide-chromium-as-a-snap-only/5987</a></p>
    <p>The official Chromium snap can be found in the Snap Store here: <a href="https://snapcraft.io/chromium" target="_blank" rel="noopener">https://snapcraft.io/chromium</a></p>
    <p>To install the Chromium Snap on Ubuntu, use the following command:</p>
    <pre>$ snap install chromium</pre>
    <p>Then, when you want to check for upgrades and install them if available, use:</p>
    <pre>$ snap refresh chromium</pre>

    <h2>Migrating Data From <code>chromium-browser</code></h2>
    <p>The Chromium Snap and old <code>chromium-browser</code> package can co-exist, as their installation and configuration directories are completely separate. The command to launch the Chromium Snap is <code>chromium</code>, while the command to launch the Deb packaged version is <code>chromium-browser</code>.</p>
    <p>If you wish to transfer your user data (browsing history, bookmarks, extensions, etc) from the <code>chromium-browser</code> version to the new Chromium Snap, this can be easily done:</p>
    <ol class="spaced-list">
        <li>Moving your Chromium user profile may cause your cookies to be lost, meaning you'll be logged out of any saved sessions. Make sure you have your password manager and 2FA codes available to log back in to any sites needed.</li>
        <li>Ensure that both browsers are fully closed.</li>
        <li>Take a backup of your old Chromium user profile from <code>~/.config/chromium/</code>, just in case something goes wrong.If you are the only user of Chromium, your user profile will most likely be a directory named <code>Default</code>. If you have multiple Chromium users, it may be called something else, which you can check at <code>chrome://version</code> under the 'Profile Path' variable.</li>
        <li>Copy (or move) your old Chromium user profile to <code>~/snap/chromium/000/.config/chromium/</code>. The numbers in the Snap path (000) may be different for your system.</li>
        <li>Start the new Chromium Snap using either the <code>chromium</code> command, or by using the application launcher. In order to quickly identify which launcher is the new Chromium Snap, the Snap usually has a more modern, flat-design icon, while the old <code>chromium-browser</code> launcher has an older '3d' icon. This may differ for your own system though.</li>
        <li>If you wish, remove the old <code>chromium-browser</code> package and any associated package repositories.</li>
        <li>Update all of your desktop icons, launchers, keyboard shortcuts, etc to use the new Chromium Snap.</li>
    </ol>
</div>

<?php include "footer.php" ?>

</body>

</html>
