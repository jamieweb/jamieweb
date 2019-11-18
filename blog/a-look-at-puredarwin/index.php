<?php include "response-headers.php"; content_security_policy();
include_once "bloglist.php"; bloglist("postTop", null, null, 2019); ?>

<div class="body">
    <h1><?php echo $postInfo->title; ?></h1>
    <hr>
    <p><b><?php echo $postInfo->date; ?></b></p>
    <p><?php echo $postInfo->snippet; ?></p>
    <p></p>

    <p><b>Skip to Section:</b></p>
    <pre><b><?php echo $postInfo->title ?></b>
&#x2523&#x2501&#x2501 <a href="#history-of-puredarwin-and-darwin-os">History of PureDarwin and Darwin OS</a>
&#x2523&#x2501&#x2501 <a href="#puredarwin-xmas">PureDarwin Xmas</a>
&#x2523&#x2501&#x2501 <a href="#booting-puredarwin-xmas-in-vmware">Booting PureDarwin Xmas in VMWare</a>
&#x2523&#x2501&#x2501 <a href="#puredarwin-beta-17-4">PureDarwin Beta 17.4</a>
&#x2523&#x2501&#x2501 <a href="#booting-puredarwin-beta-17-4-in-virtualbox">Booting PureDarwin Beta 17.4 in VirtualBox</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>

    <h2 id="history-of-puredarwin-and-darwin-os">History of PureDarwin and Darwin OS</h2>
</div>

<?php include "footer.php" ?>












