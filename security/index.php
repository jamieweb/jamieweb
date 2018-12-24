<?php include "response-headers.php"; content_security_policy(); ?>
<?php http_response_code(301);
header("Location: /contact/"); ?>
