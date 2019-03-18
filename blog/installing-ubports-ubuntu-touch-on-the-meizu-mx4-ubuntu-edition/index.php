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
    <p>If you encounter another error, it may be that you don't have permission to access your device over USB. You should add the following rules to <code>/etc/udev/rules.d/51-meizu.rules</code> (or another name of your choice), and ensure that your Linux user account is in the <code>plugdev</code> group:</p>
    <pre>SUBSYSTEM=="usb", ATTRS{idVendor}=="0bb4", MODE="0666", GROUP="plugdev"
SUBSYSTEM=="usb", ATTRS{idVendor}=="2a45", MODE="0666", GROUP="plugdev"</pre>
    <p>...then restart udev by running <code>udevadm control --reload-rules</code> followed by <code>udevadm trigger</code> as root.</p>
    <p>If your installation is working successfully, you'll see the following screen:</p>
    <img class="radius-8" src="ubports-installer-5-pushing-files-to-device.png" width="1000px" alt="A screenshot of the UBports installer application, showing the installation running successfully with a 'Pushing files to device...' notice.">
    <p>Installation takes around 5 minutes, and then there is another stage of installation that takes place on the phone itself. This also takes around 5 minutes.</p>
    <p>Your phone will reboot, and you can begin using Ubuntu Touch!</p>

    <h2 id="fixing-the-failed-remote-unknown-command-error">Fixing the <code>FAILED (remote: unknown command)</code> Error</h2>
    <p>At the time of writing, there is a known bug in ubports-installer affecting some Meizu devices. Essentially, the installer tries to reboot the phone into recovery mode, but Meizu phones don't fully support this, so you have to put it into recovery mode manually by holding the power button and volume up.</p>
    <p>If you're affected by this, you'll see the following error both in the GUI and terminal output of ubports-installer:</p>
    <pre>debug: fastboot: flash; [{"type":"recovery","url":"http://cdimage.ubports.com/devices/recovery-arale.img","checksum":"27160d1ce2d55bd940b38ebf643018b33e0516795dff179942129943fabdc3d8","path":"/home/j/snap/ubports-installer/183/.cache/ubports/images/arale"}]
info: Booting into recovery image...
error: Devices: Error: Fastboot: Unknown error:  downloading 'boot.img'...
OKAY [  0.702s]
booting...
FAILED (remote: unknown command)
finished. total time: 0.716s</pre>
    <p>Unfortunately the error handling in ubports-installer doesn't allow you to bypass this error by manually rebooting into recovery mode. The solution is to manually remove the error handling code and recompile the application.</p>
    <div class="message-box message-box-positive">
        <div class="message-box-heading">
            <h3><u>Thank You to AlainW94 on the UBports Forum</u></h3>
        </div>
        <div class="message-box-body">
            <p>I'd like to give a massive thanks to <a href="https://forums.ubports.com/user/alainw94" target="_blank" rel="noopener">AlainW94</a> on the UBports Forum for devising this solution and assisting with my problem in my <a href="https://forums.ubports.com/topic/2492/mx4-ubuntu-edition-failed-remote-unknown-command" target="_blank" rel="noopener">forum thread</a>. They provide a lot of valuable support and contributions to UBports, so I am very grateful for their help!</p>
        </div>
    </div>
    <p>In order to implement the workaround, you'll need to download a copy of the ubports-installer source code:</p>
    <pre>$ git clone https://github.com/ubports/ubports-installer.git</pre>
    <p><code>cd</code> into the downloaded directory, and open the <code>src/devices.js</code> in your text editor.</p>
    <p>Next, scroll down to the following section:</p>
    <pre>                 // If we can't find it, report error!
                  if (!recoveryImg){
                    bootstrapEvent.emit("error", "Cant find recoveryImg to boot: "+images);
                  }else {
                    fastboot.boot(recoveryImg, p, (err, errM) => {
                      if (err) {
                        handleBootstrapError(err, errM, bootstrapEvent, () => {
                          instructBootstrap(fastbootboot, images, bootstrapEvent);
                        });
                      }else
                        bootstrapEvent.emit("bootstrap:done", fastbootboot);
                    })
                  }</pre>
    <p>Then, comment out the error handling code, and replace it with the contents of the corresponding <code>else</code> condition. I've marked the modified lines below with <code>**</code>:</p>
    <pre>                 // If we can't find it, report error!
                  if (!recoveryImg){
                    bootstrapEvent.emit("error", "Cant find recoveryImg to boot: "+images);
                  }else {
                    fastboot.boot(recoveryImg, p, (err, errM) => {
                      if (err) {
**                      bootstrapEvent.emit("bootstrap:done", fastbootboot);
**                      //handleBootstrapError(err, errM, bootstrapEvent, () => {
**                      //  instructBootstrap(fastbootboot, images, bootstrapEvent);
**                      //});
                      }else
                        bootstrapEvent.emit("bootstrap:done", fastbootboot);
                    })
                  }</pre>
    <p>Once you've saved this change, you need to compile the application. To do this on Ubuntu 18.04, you'll need the <code>npm</code> and <code>libgconf2-4</code> packages. You can also just run <code>setup-dev.sh</code> which should setup your build environment for you.</p>
    <p>Next, run <code>npm run-script dist:linux</code> (or <code>dist:mac</code>/<code>dist:win</code>, for whichever your platform is).</p>
    <p>Finally, you can run the application with <code>npm start</code>. Now, ubports-installer will bypass errors at the point where the phone is required to be booted into recovery mode. This should allow you to proceed with the installation by manually putting your phone into recovery (hold power + volume up) when it prompts you to.</p>
    <p>This is of course not a perfect solution, as anything that involves bypassing error handling code is generally a bad idea, but as a temporary solution is does the job.</p>

    <h2 id="using-ubuntu-touch-on-the-meizu-mx4-in-2019">Using Ubuntu Touch on the Meizu MX4 in 2019</h2>
    <p></p>

    <h2 id="things-i-d-like-to-see">Things I'd Like to See</h2>
    <h2 id="conclusion">Conclusion</h2>
</div>

<?php include "footer.php" ?>

</body>

</html>
