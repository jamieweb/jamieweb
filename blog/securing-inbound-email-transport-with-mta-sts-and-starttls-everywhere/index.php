<?php include "response-headers.php"; content_security_policy();
include_once "bloglist.php"; bloglist("postTop", null, null, 2019); ?>

<div class="body">
    <h1><?php echo $postInfo->title; ?></h1>
    <hr>
    <p><b><?php echo $postInfo->date; ?></b></p>
    <p><?php echo $postInfo->snippet; ?></p>

    <p><b>Skip to Section:</b></p>
    <pre><b><?php echo $postInfo->title ?></b>
&#x2523&#x2501&#x2501 <a href="#mta-sts">MTA-STS</a>
&#x2523&#x2501&#x2501 <a href="#enabling-mta-sts-for-your-domain">Enabling MTA-STS For Your Domain</a>
&#x2523&#x2501&#x2501 <a href="#starttls-everywhere">STARTTLS-Everywhere</a>
&#x2523&#x2501&#x2501 <a href="#adding-your-domain-to-the-starttls-everywhere-list">Adding Your Domain to the STARTTLS-Everywhere List</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>

    <h2 id=""></h2>
    <p></p>
</div>

<?php include "footer.php" ?>
