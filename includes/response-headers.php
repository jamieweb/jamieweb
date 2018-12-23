<?php function content_security_policy($directives = null) {
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
    foreach($defaultPolicy as $directive => $value) {
        if($directive) {
            $header .= $directive . " ";
        }
        $header .= $value . "; ";
    }
    header(rtrim($header, "; "));
    echo(rtrim($header, "; ")); //Debug echo
}

function x_frame_options($value = null) {

}
?>







