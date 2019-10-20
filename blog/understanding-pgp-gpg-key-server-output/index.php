<?php include "response-headers.php"; content_security_policy();
include_once "bloglist.php"; bloglist("postTop", null, null, 2019); ?>

<div class="body">
    <h1><?php echo $postInfo->title; ?></h1>
    <hr>
    <p><b><?php echo $postInfo->date; ?></b></p>
    <p><?php echo $postInfo->snippet; ?></p>
    <pre><i>Type bits/keyID            cr. time   exp time   key expir</i>

<b>pub</b> rsa4096/a40ced0a9eaba810f55bb88ca41a7776121ce43c
         Hash=f24c4ff33f09e7da1b0cb2cf72cb2be3

<b>uid</b> <u>Alice &lt;alice@example.com&gt;</u>
sig  sig  a41a7776121ce43c 2019-10-19T21:43:52Z 2020-10-18T21:43:52Z ____________________ [selfsig]
sig  sig  24b1fb13f1b3b06c 2019-10-19T21:51:07Z ____________________ ____________________ 24b1fb13f1b3b06c

<b>uid</b> <u>Alice &lt;alice@example.com&gt;</u>
sig  sig  a41a7776121ce43c 2019-10-19T21:34:23Z 2020-10-18T21:34:23Z ____________________ [selfsig]
sig  sig  24b1fb13f1b3b06c 2019-10-19T21:51:08Z ____________________ ____________________ 24b1fb13f1b3b06c



<b>sub</b> dsa3072/d7cff40b9c95ede5f8d10b62e91a02198a286d8f 2019-10-19T23:05:19Z
sig sbind a41a7776121ce43c 2019-10-19T23:05:19Z ____________________ 2020-10-18T23:05:19Z []

<b>sub</b> rsa4096/b8d4d1ab55a0f662596c52ab47652ce725cb3e8f 2019-10-19T21:16:21Z
sig sbind a41a7776121ce43c 2019-10-19T21:16:21Z ____________________ 2020-10-18T21:16:21Z []</pre>

    <h2 id="type-bits">Type bits</h2>
    <p></p>

    <h2 id="conclusion">Conclusion</h2>
    <p></p>
</div>

<?php include "footer.php" ?>
