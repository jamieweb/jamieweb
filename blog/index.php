<?php include "response-headers.php"; content_security_policy(); ?>
<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Blog</title>
    <meta name="description" content="Jamie Scaife's Blog">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/blog/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Blog</h1>
    <hr>
<?php bloglist("blog"); ?>
</div>

<?php include "footer.php" ?>

</body>

</html>
