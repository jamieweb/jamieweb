<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/legal-->

<head>
    <title>Chrome Site Whitelist Extension</title>
    <meta name="description" content="Chrome Site Whitelist Extension">
    <meta name="keywords" content="Jamie, Scaife, jamie scaife, jamiescaife, jamieonubuntu, jamie90437, jamie90437x, jamieweb, jamieweb.net">
    <meta name="author" content="Jamie Scaife">
    <link href="/jamie.css" rel="stylesheet">
    <link href="https://www.jamieweb.net/projects/chrome-site-whitelist-extension/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Chrome Site Whitelist Extension</h1>
    <hr>
    <center><p>-<b><u>Currently early in development and is not yet fully working or tested thoroughly.</u></b>-</p></center>
    <p>A Google Chrome extension that highlights sites on Google/Reddit that have been manually whitelisted by the user.</p>
    <center><img src="/projects/chrome-site-whitelist-extension/extension-manager.png"></center>
    <p>Designed to be an anti-typosquatting tool and to highlight known trusted sites.</p>
    <center><img src="/projects/chrome-site-whitelist-extension/example-result-highlighting.png"></center>
    <p>The extension icon also changes to green when you are currently browsing a whitelisted site.</p>
    <center><img src="/projects/chrome-site-whitelist-extension/extension-icon-green.png"></center>
    <p>All code and further details are available on the GitHub respository: <a href="https://github.com/JamieOnUbuntu/results-whitelist/">https://github.com/JamieOnUbuntu/results-whitelist/</a></p>
    <h2>Downloading and Installing:</h2>
    <p>I am considering releasing the extension on the Google Chrome Web Store once it is in a more finished state and has been tested thoroughly.</p>
    <p>For the mean time, you can install it manually:</p>
    <ul>
        <div class="ext-l-1">
            <li><p><b>Download the ZIP from GitHub and extract the contained folder.</b></p>
                <ul>
                    <li><p>GitHub Repo:<br/><a href="https://github.com/JamieOnUbuntu/results-whitelist/">https://github.com/JamieOnUbuntu/results-whitelist/</a></p></li>
                    <li><p>Direct Link:<br/><a href="https://github.com/JamieOnUbuntu/results-whitelist/archive/master.zip">https://github.com/JamieOnUbuntu/results-whitelist/archive/master.zip</a></p></li>
                </ul>
            </li>
        </div>
        <div class="ext-r-1">
            <center><img src="/projects/chrome-site-whitelist-extension/github-download.png"></center><br>
        </div>
    </ul>
    <ul><li class="clearboth"><p><b>Open the Chrome extensions manager (Settings -> More Tools -> Extensions, or <a href="chrome://extensions" target="_blank">chrome://extensions</a>).</b></p></li></ul>
    <center><img src="/projects/chrome-site-whitelist-extension/extension-manager-menu.png"></center>
    <ul><li><p><b>Enable developer mode by checking the box.</b></p></li></ul>
    <center><img src="/projects/chrome-site-whitelist-extension/developer-mode.png"></center>
    <ul><li><p><b>Click "Load Unpacked Extension" and select the extracted folder containing the extension files.</b></p></li></ul>
    <center><img width="1000px" src="/projects/chrome-site-whitelist-extension/extension-files.png"></center>
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
        <center><img src="/projects/chrome-site-whitelist-extension/extension-options.png"></center><br>
    </div>
    <p class="clearboth">Click save. Now when you perform a Google search or browse Reddit, links matching those that you defined in the configuration will be highlighed in green. The extension icon at the top right will also change to green when you are currently browsing a whitelisted site.</p>
</div>

<?php include "footer.php" ?>

</body>

</html>
