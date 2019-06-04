<?php include "response-headers.php"; content_security_policy();
include_once "bloglist.php"; bloglist("postTop", null, null, 2019); ?>

<div class="body">
    <h1><?php echo $postInfo->title; ?></h1>
    <hr>
    <p><b><?php echo $postInfo->date; ?></b></p>
    <p><?php echo $postInfo->snippet; ?></p>
    <p>I've developed a Bash script that can automatically download and perform integrity verifications for various pieces of software, including Ubuntu ISOs, Kali Linux and some Windows software.</p>
    <p>The reason for creating this is to make it significantly easier, more reliable and faster to acquire integrity-checked versions of the software that I regularly use. Previously, downloading and updating this software was a manual process, which is natureally slow and unnecessarily prone to human error.</p>
    <p>I've released the script under the MIT license, and it's available on my GitLab profile: <a href="https://gitlab.com/jamieweb/download-verify" target="_blank" rel="noopener">https://gitlab.com/jamieweb/download-verify</a></p>
    <p><b>Skip to Section:</b></p>
    <pre><b><?php echo $postInfo->title ?></b>
&#x2523&#x2501&#x2501 <a href="#script-demo">Script Demo</a>
&#x2523&#x2501&#x2501 <a href="#how-does-it-work">How does it work?</a>
&#x2523&#x2501&#x2501 <a href="#why-is-there-a-need-to-automate-the-integrity-verification-process">Why is there a need to automate the integrity verification process?</a>
&#x2523&#x2501&#x2501 <a href="#whiptail">Whiptail</a>
&#x2523&#x2501&#x2501 <a href="#handling-errors">Handling Errors</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>

    <h2 id="script-demo">Script Demo</h2>
    <p></p>

    <h2 id="how-does-it-work">How does it work?</h2>
    <p></p>

    <h2 id="why-is-there-a-need-to-automate-the-integrity-verification-process">Why is there a need to automate the integrity verification process?</h2>
    <p></p>

    <h2 id="whiptail">Whiptail</h2>
    <p></p>

    <h2 id="handling-errors">Handling Errors</h2>
    <p></p>

    <h2 id="conclusion">Conclusion</h2>
    <p></p>
</div>

<?php include "footer.php" ?>
