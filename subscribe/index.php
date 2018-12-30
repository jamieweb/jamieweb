<?php include "response-headers.php"; content_security_policy(); ?>
<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Subscribe</title>
    <meta name="description" content="Subscribe to receive notifications when I post new content to my blog.">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/subscribe/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Subscribe</h1>
    <hr>
    <p class="two-mar-bottom">Subscribe to receive notifications when I post new content to this blog. Usually there will be only a couple of notifications per month.</p>
    <div class="icontext two-mar-top margin-right-20">
        <a href="/rss.xml" target="_blank"><img src="/images/fontawesome/rss-orange.svg"></a>
        <h4><a href="/rss.xml" target="_blank">RSS Feed</a></h4>
    </div>
    <div class="icontext two-mar-bottom">
        <a href="https://feedly.com/i/subscription/feed%2Fhttps%3A%2F%2Fwww.jamieweb.net%2Frss.xml" target="_blank" rel="noopener"><img src="/images/fy.png"></a>
        <h4><a href="https://feedly.com/i/subscription/feed%2Fhttps%3A%2F%2Fwww.jamieweb.net%2Frss.xml" target="_blank" rel="noopener">Feedly</a></h4>
    </div>
    <div class="email-form">
        <p class="two-no-mar">Or subscribe via email:</p>
        <form class="display-flex" action="https://www.getrevue.co/profile/jamieweb/add_subscriber" method="post" target="_blank">
            <input class="form-input margin-right-10 exempt" type="email" name="member[email]" placeholder="Your email address...">
            <input class="form-submit" type="submit" name="member[subscribe]" value="Go">
        </form>
        <p class="font-size-smaller color-grey no-mar-top">Email subscriptions are powered by <a class="color-grey" href="https://www.getrevue.co/" target="_blank" rel="noopener">Revue</a> | <a class="color-grey" href="https://www.getrevue.co/privacy/platform" target="_blank" rel="noopener">Privacy Notice</a></p>
    </div>
</div>

<?php include "footer.php" ?>

</body>

</html>






