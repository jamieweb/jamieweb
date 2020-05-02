<?php include "response-headers.php"; content_security_policy();
include_once "bloglist.php"; bloglist("postTop", null, null, 2020); ?>

<div class="body">
    <h1><?php echo $postInfo->title . "</h1>\n" . (isset($postInfo->subtitle) ? "    <h2 class=\"subtitle-mar-top\">" . $postInfo->subtitle . "</h2>\n" : ""); ?>
    <hr>
    <p><b><?php echo $postInfo->date; ?></b></p>
    <!--INTRO START-->
    <p>Intro/snippet - automatically included on homepage.</p>
    <p>Sample sentence with <a class="exempt" href="#" target="_blank" rel="noopener">a link</a>.</p>
    <img class="radius-8 max-width-100-percent" src="/blog/full-path-to-image/">
    <p class="two-no-mar centertext"><i></i></p>
    <p>End of intro.</p>
    <!--INTRO END-->
    <p><b>Skip to Section:</b></p>
    <pre class="contents"><b><?php echo $postInfo->title . (isset($postInfo->subtitle) ? "\n" . $postInfo->subtitle : ""); ?></b>
&#x2523&#x2501&#x2501 <a href="#"></a>
&#x2523&#x2501&#x2501 <a href="#"></a>
&#x2523&#x2501&#x2501 <a href="#"></a>
&#x2523&#x2501&#x2501 <a href="#"></a>
&#x2523&#x2501&#x2501 <a href="#"></a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>

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
