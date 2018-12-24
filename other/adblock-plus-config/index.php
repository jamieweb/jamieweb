<?php include "response-headers.php"; content_security_policy(); ?>
<?php header("HTTP/1.1 301 Moved Permanently");
header("Location: /info/adblock-plus-config/"); ?>
