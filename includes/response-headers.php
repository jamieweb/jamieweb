<?php function content_security_policy($overrides = []) {
    $defaultPolicy = [
        "default-src" => "'none'",
        "base-uri" => "'none'",
        "font-src" => "'self'",
        "form-action" => "'none'",
        "frame-ancestors" => "'none'",
        "img-src" => "'self'",
        "style-src" => "'self'",
        "block-all-mixed-content"
    ];
    $header = "Content-Security-Policy: ";
    foreach(array_merge($defaultPolicy, $overrides) as $directive => $value) {
        if(is_string($directive)) {
            $header .= $directive . " ";
        }
        $header .= $value . "; ";
    }
    header(rtrim($header, "; "));
} ?>
