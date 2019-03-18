<?php include "response-headers.php"; content_security_policy(); ?>
<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Installing UBports Ubuntu Touch on the Meizu MX4 Ubuntu Edition</title>
    <meta name="description" content="Installing UBports Ubuntu Touch on the original Meizu MX4 Ubuntu Edition using ubports-installer.">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/blog/installing-ubports-ubuntu-touch-on-the-meizu-mx4-ubuntu-edition/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Installing UBports Ubuntu Touch on the Meizu MX4 Ubuntu Edition</h1>
    <hr>
    <p><b>Monday 18th March 2019</b></p>
    <p>I recently decided to switch back to using my Meizu MX4 Ubuntu Edition that I originally purchased in 2015 (<a href="/blog/ubuntu-phone-review" target="_blank" rel="noopener">which is what the first article on this blog was about</a>).</p>
    <p>Unfortunately, Canonical decided to end development of Ubuntu Touch due to a lack of market interest, but luckily the <a href="https://ubports.com/" target="_blank" rel="noopener">UBports</a> community took over development, and are running the project successfully to this day as the <a href="https://ubports.com/foundation/ubports-foundation" target="_blank" rel="noopener">UBports Foundation</a>.</p>
    <p>In this article, I have documented the installation process using the ubports-installer application, and included a manual bug fix that is currently required for installation on some MX4 phones. This fix was kindly put together by <a href="https://forums.ubports.com/user/alainw94" target="_blank" rel="noopener">AlainW94</a> on the UBports forum, and documented here with their permission.</p>
    <p><b>Skip to Section:</b></p>
    <pre><b>Installing UBports Ubuntu Touch on the Meizu MX4 Ubuntu Edition</b>
&#x2523&#x2501&#x2501 <a href="#standard-installation-procedure">Standard Installation Procedure</a>
&#x2523&#x2501&#x2501 <a href="#fixing-the-failed-remote-unknown-command-error">Fixing the <code>FAILED (remote: unknown command)</code> Error</a>
&#x2523&#x2501&#x2501 <a href="#using-ubuntu-touch-on-the-meizu-mx4-in-2019">Using Ubuntu Touch on the Meizu MX4 in 2019</a>
&#x2523&#x2501&#x2501 <a href="#things-i-d-like-to-see">Things I'd Like to See</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>

    <h2 id="standard-installation-procedure">Standard Installation Procedure</h2>
    <div class="message-box message-box-notice">
        <div class="message-box-heading">
            <h3><u>Notice:</u></h3>
        </div>
        <div class="message-box-body">
            <p>There is currently a bug in ubports-installer affecting some Meizu devices, preventing the installation from suceeding. It may be worth <a href="#fixing-the-failed-remote-unknown-command-error">reading ahead</a> so you know what to look out for. The fix involves making a manual code change and recompiling the application.</p>
        </div>
    </div>
    <p>The official method for installing Ubuntu Touch is using the ubports-installer application, which can be installed from the <a href="https://snapcraft.io/ubports-installer" target="_blank" rel="noopener">Snap Store</a>:</p>
    <pre>$ snap install ubports-installer</pre>
    <p>I recommend running ubports-installer using the <code>ubports-installer</code> command, rather than using the desktop/menu shortcut, as seeing the verbose log output can be very useful for debugging errors and ensuring that everything is working properly.</p>
    <img class="radius-8" src="ubports-installer-1-welcome-screen.png" width="1000px" alt="A screenshot of the UBports installer application, showing the main welcome screen.">
    <p>The welcome screen will try to auto-detect your phone if it is plugged in. For me, this unfortunately didn't work, so I selected it manually.</p>
    <p>Then, you can select your desired installation options:</p>
    <img class="radius-8" src="ubports-installer-2-select-install-options.png" width="1000px" alt="A screenshot of the UBports installer application, showing my phone selected and the 'Install Options' menu.">
    <p>The latest version at the time of writing is Ubuntu Touch 16.04.</p>
    <img class="radius-8" src="ubports-installer-3-ready-to-install.png" width="1000px" alt="A screenshot of the UBports installer application, showing the installation confirmation screen.">
    <p>Then, you'll need to put your phone in Fastboot mode, by holding down the power and volume down buttons while your device is in a powered-off state. You may have to hold them for a while, as in some cases it can take up to 30 seconds. This also doesn't seem to work reliably while your device is plugged in via USB, so I suggest temporarily disconnecting it while you do this.</p>
    <img class="radius-8" src="ubports-installer-4-please-reboot-to-bootloader.png" width="1000px" alt="A screenshot of the UBports installer application, asking the user to reboot their phone into the bootloader, with a static graphic demonstrating how to do this.">
    <p>After you've done this, the installation should begin properly. However, on some Meizu devices you will run into the <code>FAILED (remote: unknown command)</code> error. If this is the case, then this is a known bug. The temporary fix involves making a minor code change and recompiling ubports-installer - I have documented the entire process <a href="#fixing-the-failed-remote-unknown-command-error">below</a>.</p>
    <p>If your installation is working successfully, you'll see the following screen:</p>
    <img class="radius-8" src="ubports-installer-5-pushing-files-to-device.png" width="1000px" alt="A screenshot of the UBports installer application, showing the installation running successfully with a 'Pushing files to device...' notice.">

    <h2 id="fixing-the-failed-remote-unknown-command-error">Fixing the <code>FAILED (remote: unknown command)</code> Error</h2>
    <h2 id="using-ubuntu-touch-on-the-meizu-mx4-in-2019">Using Ubuntu Touch on the Meizu MX4 in 2019</h2>
    <h2 id="things-i-d-like-to-see">Things I'd Like to See</h2>
    <h2 id="conclusion">Conclusion</h2>
</div>

<?php include "footer.php" ?>

</body>

</html>
