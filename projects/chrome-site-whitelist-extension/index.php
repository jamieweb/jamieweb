<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/legal-->

<head>
    <title>Chrome Site Whitelist Extension</title>
    <meta name="description" content="Chrome Site Whitelist Extension">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/projects/chrome-site-whitelist-extension/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Chrome Site Whitelist Extension</h1>
    <hr>
    <div class="centertext"><p>-<b><u>Currently early in development and is not yet fully working or tested thoroughly.</u></b>-</p></div>
    <p>A Google Chrome extension that highlights sites on Google/Reddit that have been manually whitelisted by the user.</p>
    <div class="centertext"><img src="/projects/chrome-site-whitelist-extension/extension-manager.png"></div>
    <p>Designed to be an anti-typosquatting tool and to highlight known trusted sites.</p>
    <div class="centertext"><img src="/projects/chrome-site-whitelist-extension/example-result-highlighting.png"></div>
    <p>The extension icon also changes to green when you are currently browsing a whitelisted site.</p>
    <div class="centertext"><img src="/projects/chrome-site-whitelist-extension/extension-icon-green.png"></div>
    <p>All code and further details are available on the GitHub respository: <a href="https://github.com/jamieweb/results-whitelist/" target="_blank" rel="noopener">https://github.com/jamieweb/results-whitelist/</a></p>
    <h2>Downloading and Installing:</h2>
    <p>I am considering releasing the extension on the Google Chrome Web Store once it is in a more finished state and has been tested thoroughly.</p>
    <p>For the mean time, you can install it manually:</p>
    <ul>
        <div class="ext-l-1">
            <li><p><b>Download the ZIP from GitHub and extract the contained folder.</b></p>
                <ul>
                    <li><p>GitHub Repo:<br/><a href="https://github.com/jamieweb/results-whitelist/" target="_blank" rel="noopener">https://github.com/jamieweb/results-whitelist/</a></p></li>
                    <li><p>Direct Link:<br/><a href="https://github.com/jamieweb/results-whitelist/archive/master.zip" target="_blank" rel="noopener">https://github.com/jamieweb/results-whitelist/archive/master.zip</a></p></li>
                </ul>
            </li>
        </div>
        <div class="ext-r-1">
            <div class="centertext"><img src="/projects/chrome-site-whitelist-extension/github-download.png"></div><br>
        </div>
    </ul>
    <ul><li class="clearboth"><p><b>Open the Chrome extensions manager (Settings -> More Tools -> Extensions, or go to the URL chrome://extensions.</b></p></li></ul>
    <div class="centertext"><img src="/projects/chrome-site-whitelist-extension/extension-manager-menu.png"></div>
    <ul><li><p><b>Enable developer mode by checking the box.</b></p></li></ul>
    <div class="centertext"><img src="/projects/chrome-site-whitelist-extension/developer-mode.png"></div>
    <ul><li><p><b>Click "Load Unpacked Extension" and select the extracted folder containing the extension files.</b></p></li></ul>
    <div class="centertext"><img width="1000px" src="/projects/chrome-site-whitelist-extension/extension-files.png"></div>
    <h2>Configuration:</h2>
    <div class="ext-l-2">
        <p class="no-mar-top">You can access the options page by clicking "Options" from the extensions manager, or by right clicking the extension icon at the top right of Chrome.</p>
        <p>Enter website names into the box, one per line. This must be the full website name, including subdomains if required. Example:</p>
        <pre>example.com
github.com
www.reddit.com</pre>
        <p>Regular expressions (regex) are not supported.</p>
    </div>
    <div class="ext-r-2">
        <div class="centertext"><img src="/projects/chrome-site-whitelist-extension/extension-options.png"></div><br>
    </div>
    <p class="clearboth">Click save. Now when you perform a Google search or browse Reddit, links matching those that you defined in the configuration will be highlighed in green. The extension icon at the top right will also change to green when you are currently browsing a whitelisted site.</p>
</div>

<?php include "footer.php" ?>

</body>

</html>
