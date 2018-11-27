<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>JamieWeb</title>
    <meta name="description" content="Website of Jamie Scaife - United Kingdom">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/" rel="canonical">
</head>

<body>

<?php include "navbar.php"; ?>

<div class="body">
    <div class="content redlink">
        <h1>Jamie Scaife - United Kingdom &#x1f1ec;&#x1f1e7;<?php include "holiday-emojis.php" ?></h1>
        <hr>
        <h3 class="no-mar-bottom intro-mar-top">No Ads, No Tracking, No JavaScript</h3>
        <p class="two-mar-top">This website does not have any adverts, tracking or other internet annoyances.<br/>It's also 100% JavaScript free.</p>
        <h3 class="no-mar-bottom">Tor Hidden Services</h3>
        <p class="two-no-mar">This site is available through Tor at:</p>
        <ul class="no-mar-top">
            <li>
                <p class="two-mar-bottom display-inline-block">Onion v2: </p>
                <div class="onionlink two-mar-top">
                    <p class="no-mar word-break-all"><a class="font-family-monospace" href="http://jamiewebgbelqfno.onion" target="_blank" rel="noopener">jamiewebgbelqfno.onion</a></p>
                </div>
            </li>
            <li>
                <p class="two-mar-bottom display-inline-block">Onion v3: </p>
                <div class="onionlink two-mar-top">
                    <p class="no-mar word-break-all"><a class="font-family-monospace"href="http://jamie3vkiwibfiwucd6vxijskbhpjdyajmzeor4mc4i7yopvpo4p7cyd.onion" target="_blank" rel="noopener">jamie3vkiwibfiwucd6vxijskbhpjdyajmzeor4mc4i7yopvpo4p7cyd.onion</a></p>
                </div>
            </li>
        </ul>
        <hr>
        <div class="recent-posts"><?php bloglist("home"); ?></div>
        <hr>
        <a href="/blog/">
            <div class="view-all-button centertext">
                <h3 class="no-mar-top no-mar-bottom">View All Posts</h3>
            </div>
        </a>
    </div>

    <div class="sidebar">
        <input type="radio" class="gravity-radio" id="identicon">
        <label class="gravity-label" for="identicon"></label>
        <!--Thanks to jdenticon.com for the identicon image generation!-->
        <!--My identicon seed is the sha256 hash of the plain text word "JamieOnUbuntu".-->
        <hr>
        <div class="centertext sideitems">
            <div class="sideitem">
                <a href="https://github.com/jamieweb" target="_blank" rel="noopener"><img src="/images/fontawesome/github.svg"></a>
                <h4><a href="https://github.com/jamieweb" target="_blank" rel="noopener">GitHub</a></h4>
            </div>
            <div class="sideitem">
                <a href="https://twitter.com/jamieweb" target="_blank" rel="noopener"><img src="/images/fontawesome/tw.svg"></a>
                <h4><a href="https://twitter.com/jamieweb" target="_blank" rel="noopener">Twitter</a></h4>
            </div>
            <div class="sideitem">
                <a href="https://www.youtube.com/jamie90437x" target="_blank" rel="noopener"><img src="/images/fontawesome/yt.svg"></a>
                <h4><a href="https://www.youtube.com/jamie90437x" target="_blank" rel="noopener">YouTube</a></h4>
            </div>
            <div class="sideitem">
                <a href="https://keybase.io/jamieweb" target="_blank" rel="noopener"><img src="/images/fontawesome/id-card.svg"></a>
                <h4><a href="https://keybase.io/jamieweb" target="_blank" rel="noopener">Keybase</a></h4>
            </div>
            <div class="sideitem">
                <a href="https://hackerone.com/jamieweb" target="_blank" rel="noopener"><img class="h1" src="/images/hackerone.png"></a>
                <h4><a href="https://hackerone.com/jamieweb" target="_blank" rel="noopener">HackerOne</a></h4>
            </div>
            <div class="sideitem">
                <a href="/rss.xml" target="_blank"><img src="/images/fontawesome/rss.svg"></a>
                <h4><a href="/rss.xml" target="_blank">RSS</a></h4>
            </div>
        </div>
        <hr>
        <h2 class="centertext">Popular Pages</h2>
        <div class="redlink tops">
            <a href="/projects/computing-stats/">
                <h4 class="no-mar-bottom">Raspberry Pi + BOINC Stats</h4>
                <h5 class="two-no-mar">Stats from my RPi cluster + BOINC.</h5>
                <p class="two-mar-top">Updated Every 10 Minutes</p>
            </a>
            <a href="/tools/exploitable-web-content-blocking-test/">
                <h4 class="no-mar-bottom">Exploitable Web Content Blocking Test</h4>
                <h5 class="two-no-mar">Test whether exploitable web content is blocked in your web browser.</h5>
            </a>
            <a href="/blog/onionv3-hidden-service/">
                <h4 class="no-mar-bottom">Tor Onion v3 Hidden Service</h4>
                <h5 class="two-no-mar">Testing the new Onion v3 Hidden Services.</h5>
                <p class="two-mar-top">Saturday 21st October 2017</p>
            </a>
            <a href="/blog/namecoin-bit-domain/">
                <h4 class="no-mar-bottom">Namecoin .bit Domain</h4>
                <h5 class="two-no-mar">Guide to registering a Namecoin .bit domain.</h5>
                <p class="two-mar-top">Tuesday 16th January 2018</p>
            </a>
        </div>
    </div>
</div>

<?php include "footer.php" ?>

</body>

</html>
