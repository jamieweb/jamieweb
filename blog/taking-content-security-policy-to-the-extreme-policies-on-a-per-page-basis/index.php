<?php include "response-headers.php"; content_security_policy(); ?>
<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Taking Content Security Policy to the Extreme! - Policies on a Per-page Basis</title>
    <meta name="description" content="Implementing a Content Security Policy on your PHP website with fine-grain control over the policy on a per-page basis.">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/blog/taking-content-security-policy-to-the-extreme-policies-on-a-per-page-basis/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Taking Content Security Policy to the Extreme! - Policies on a Per-page Basis</h1>
    <hr>
    <p><b>Saturday 19th December 2019</b></p>
    <p>For about two years at the time of writing, my website has had a <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP" target="_blank" rel="noopener">Content Security Policy</a> in order to lock-down and restrict the locations that content such as images and stylesheets can be loaded from. I had used Apache configurations in order to set a more relaxed policy for specific pages that require it, however this solution is not ideal as it becomes challenging to manage when used with larger websites with many different pages, each requiring a different policy.</p>
    <p>I have now developed some useful PHP code that allows me to easily set a default policy for the entire website, and then override individual parts of the policy on specific pages where it is required. The code is open-source under the MIT license, so you are welcome to use it for your own projects!</p>
    <p><b>Skip to Section:</b></p>
    <pre><b>Taking Content Security Policy to the Extreme! - Policies on a Per-page Basis</b>
&#x2523&#x2501&#x2501 <a href="#the-code">The Code</a>
&#x2523&#x2501&#x2501 <a href="#other-headers-feature-policy">Other Headers</a>
&#x2523&#x2501&#x2501 <a href="#implementing-the-code-with-apache-and-php">Implementing the Code with Apache and PHP</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>

    <h2 id="the-code">The Code</h2>
    <p>If you want to dive straight in, put the code below in a file on your server that can be included using the PHP <code>include()</code> function:</p>
    <pre>&lt;?php function content_security_policy($overrides = []) {
    $defaultPolicy = [
        "default-src" =&gt; "'self'",
        "block-all-mixed-content"
    ];
    $header = "Content-Security-Policy: ";
    foreach(array_merge($defaultPolicy, $overrides) as $directive =&gt; $value) {
        if(is_string($directive)) {
            $header .= $directive . " ";
        }
        $header .= $value . "; ";
    }
    header(rtrim($header, "; "));
} ?&gt;</pre>
    <p>This code defines the <code>content_security_policy($overrides = [])</code> function. Calling this function without passing it any arguments serves the default Content-Security-Policy header as defined in the <code>$defaultPolicy</code> array in the code.</p>
    <pre>Content-Security-Policy: default-src 'none'; block-all-mixed-content</pre>
    <p>However, you can override individual Content Security Policy directives by passing them in with the <code>$overrides</code> array. Directives and values in this array will either override or be added to the default policy. This allows you to make page-specific overrides to your Content Security Policy, in order set a tigher or more relaxed policy in the exact places that it's needed.</p>
    <p>For example:</p>
    <pre>content_security_policy(["script-src" =&gt; "'none'"])</pre>
    <p>This will serve the default policy, but the <code>script-src</code> directive will be overriden. In this case, <code>script-src</code> is not defined in the policy, so it is simply added to the end, resulting in:</p>
    <pre>Content-Security-Policy: default-src 'none'; block-all-mixed-content; script-src 'none'</pre>
</div>

<?php include "footer.php" ?>

</body>

</html>
