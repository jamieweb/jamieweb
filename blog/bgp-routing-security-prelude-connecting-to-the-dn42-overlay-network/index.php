<?php include "response-headers.php"; content_security_policy();
include_once "bloglist.php"; bloglist("postTop", null, null, 2020); ?>

<div class="body">
    <h1><?php echo $postInfo->title . "</h1>\n" . (isset($postInfo->title) ? "    <h2 class=\"subtitle-mar-top\">" . $postInfo->subtitle . "</h2>\n" : ""); ?>
    <hr>
    <p><b><?php echo $postInfo->date; ?></b></p>
    <p><?php echo $postInfo->snippet; ?></p>
    <p>This is a prelude to a multi-part series on BGP routing security:</p>
    <ul class="spaced-list">
        <li><b>Prelude:</b> Connecting to the DN42 Overlay Network (You Are Here)</li>
        <li><b>Part 1:</b> Coming Soon</li>
    </ul>
    <p>The purpose of this first article is to allow you to set up a suitible lab environment for practising BGP and the various routing security elements that are present in this guide.</p>
    <p>If you already have a lab environment set up, or are working on an existing BGP deployment, you can safely skip this prelude and go straight to Part 1.</p>
    <p><b>Skip to Section:</b></p>
    <pre class="contents"><b><?php echo $postInfo->title . (isset($postInfo->subtitle) ? "\n" . $postInfo->subtitle : ""); ?></b>
&#x2523&#x2501&#x2501 <a href="#what-is-dn42">What is DN42?</a>
&#x2523&#x2501&#x2501 <a href="#accessing-the-dn42-registry">Accessing the DN42 Registry</a>
&#x2523&#x2501&#x2501 <a href="#creating-registry-objects">Creating Registry Objects</a>
&#x2523&#x2501&#x2501 <a href="#merging-your-registry-objects-into-the-registry">Merging Your Registry Objects into the Registry</a>
&#x2523&#x2501&#x2501 <a href="#finding-a-peer">Finding a Peer</a>
&#x2523&#x2501&#x2501 <a href="#connecting-to-your-peer-using-openvpn">Connecting to Your Peer Using OpenVPN</a>
&#x2523&#x2501&#x2501 <a href="#dnsmasq-dns-setup-for-dn42-domains">Dnsmasq DNS Setup for '.dn42' Domains</a>
&#x2517&#x2501&#x2501 <a href="#part-1-conclusion">Part 1 / Conclusion</a></pre>

    <h2 id=""></h2>
    <p></p>
    <img class="radius-8" width="1000px" src="">
    <p class="two-no-mar centertext"><i></i></p>

    <div class="message-box message-box-positive/warning/warning-medium/notice">
        <div class="message-box-heading">
            <h3><u></u></h3>
        </div>
        <div class="message-box-body">
            <p></p>
        </div>
    </div>

    <h2 id="conclusion">Conclusion</h2>
    <p></p>
</div>

<?php include "footer.php" ?>
