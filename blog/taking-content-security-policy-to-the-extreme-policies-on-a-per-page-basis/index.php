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
    <p>I have now developed some useful PHP code that allows me to easily set a default policy for the entire website, and then override individual parts of the policy on specific pages where it is required. I've released the code to the public domain under the <a href="http://unlicense.org/" target="_blank" rel="noopener">Unlicense</a>, so you are welcome to use it for your own projects!</p>
    <p><b>Skip to Section:</b></p>
    <pre><b>Taking Content Security Policy to the Extreme! - Policies on a Per-page Basis</b>
&#x2523&#x2501&#x2501 <a href="#the-code">The Code</a>
&#x2523&#x2501&#x2501 <a href="#other-uses-for-the-code">Other Uses for the Code</a>
&#x2523&#x2501&#x2501 <a href="#implementing-the-code-with-apache-and-php">Implementing the Code with Apache and PHP</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>

    <h2 id="the-code">The Code</h2>
    <p>If you want to dive straight in, put the code below in a file on your server that can be included using the PHP <code>include()</code> function:</p>
    <pre class="two-mar-bottom">&lt;?php function content_security_policy($overrides = []) {
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
    <p class="two-no-mar centertext"><i>I have released the above PHP code to the public domain using the <a href="http://unlicense.org/" target="_blank" rel="noopener">Unlicense</a>.</i></p>
    <p>This code defines the <code>content_security_policy($overrides = [])</code> function. Calling this function without passing it any arguments serves the default Content-Security-Policy header as defined in the <code>$defaultPolicy</code> array in the code:</p>
    <pre>Content-Security-Policy: default-src 'none'; block-all-mixed-content</pre>
    <p>However, you can override individual Content Security Policy directives by passing them in with the <code>$overrides</code> array. Directives and values in this array will either override or be added to the default policy. This allows you to make page-specific overrides to your Content Security Policy, in order set a tighter or more relaxed policy in the exact places that it's needed.</p>
    <p>For example:</p>
    <pre>content_security_policy(["script-src" =&gt; "'none'"]);</pre>
    <p>This will serve the default policy, but the <code>script-src</code> directive will be overridden. In this case, <code>script-src</code> is not defined in the default policy, so it is simply added to the end, resulting in:</p>
    <pre>Content-Security-Policy: default-src 'self'; block-all-mixed-content; script-src 'none'</pre>
    <p>However, if you override a directive in the default policy:</p>
    <pre>content_security_policy(["default-src" =&gt; "'none'"]);</pre>
    <p>...the directive will be overridden in the resulting policy:</p>
    <pre>Content-Security-Policy: default-src 'none'; block-all-mixed-content</pre>
    <p>You can pass in as many overrides as you want - directives with associated values (such as <code>script-src</code> must be passed in with the format of <code>"directive" =&gt; "value"</code>, whereas directives without a configuration value (such as <code>block-all-mixed-content</code> or <code>upgrade-insecure-requests</code>) can just be passed directly as <code>"directive"</code>. Make sure to use commas to separate each element of the array.</p>
    <p>The code will automatically take care of constructing the header, including adding semicolons between directives (except for the last one), and will also serve the header using the PHP <code>header()</code> function.</p>

    <h2 id="other-uses-for-the-code">Other Uses for the Code</h2>
    <p>A potential interesting use for this code is for implementing targeted policy violation reporting using the <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/report-uri" target="_blank" rel="noopener"><code>report-uri</code></a> directive (will be <code>report-to</code> in the future). If there is a particular area of your site that was recently changed or is particularly susceptible to policy violations, you can only enable the reporting there in order to help ensure that more relevant reports are sent to your reporting endpoint (for example the <a href="https://report-uri.com/" target="_blank" rel="noopener">Report URI</a> service).</p>
    <p>The code can also be easily modified in order to serve other similar headers, such as <a href="https://scotthelme.co.uk/a-new-security-header-feature-policy/" target="_blank" rel="noopener">Feature-Policy</a>.</p>
    <p>Additionally, you could use it to serve other, more-general security headers such as <code>Strict-Transport-Security</code>, however it's unlikely that there is a valid reason to serve differing HSTS policies depending on which page you're visiting. If you can think of a good reason to do this, please <a href="/contact/" target="_blank">let me know</a>.</p>
    <p>Another good use for this code would be for serving different <code>Cache-Control</code> headers for different pages. For example, pages with dynamic content could have caching reduced or disabled, while static pages still have caching enabled.</p>

    <h2 id="implementing-the-code-with-apache-and-php">Implementing the Code with Apache and PHP</h2>
    <h3 id="implementing-the-code-with-php">PHP:</h3>
    <p>In order to implement this code in a PHP application, the file containing the function needs to be included in every page, and then the function needs to be called once in order for the header to be served.</p>
    <p>All HTTP response headers must be served before any of the actual HTML document - in other words, you can only use the PHP <code>header()</code> function before the <code>&lt;!DOCTYPE html&gt;</code> and <code>&lt;html&gt;</code>, etc.</p>
    <p>The exact method of implementation will depend on how your site is designed, however you can simply include the file containing the function, and then call it, all on the first line of your code:</p>
    <pre>&lt;?php include "response-headers.php"; content_security_policy(); ?&gt;</pre>
    <p>If you have other existing includes at the top of your code, you could include the code in there if that would be appropriate. Just make sure that the function will be called before any of the response body (HTML) is written.</p>

    <h3 id="implementing-the-code-with-apache-and-php">Apache + PHP:</h3>
    <p>The header code outlined in this article will only serve the header for documents where the function is called. This is great if every single PHP page calls the function, but what about images, stylesheets, scripts, error pages, etc? A Content-Security-Policy should be applied to all resources on your website, not just the pages themselves. While it's true that the policy for a page will cascade down to the subresources in most cases, often subresources will be loaded directly by the visitor, or there will be edge-cases causing the policy to not be applied or enforced.</p>
    <p>In order to resolve this issue, you should configure Apache to serve a default, locked-down Content-Security-Policy on all resources returned by the server. However, Apache can then be configured to allow PHP documents to set their own Content-Security-Policy header in situations where the header is set using the code in this article.</p>
    <p>There are some challenges with this setup due to the way that Apache handles HTTP response headers. For each request, Apache has two different 'lists' of headers - <code>always</code> and <code>onsuccess</code>. Headers set using <code>Header always set</code> are added to the <code>always</code> list, and headers set using <code>Header set</code> are added to the <code>onsuccess</code> list. <code>onsuccess</code> is the default value, which is why it can be omitted. You can still use <code>Header onsuccess set</code> if you want to.</p>
    <p>Headers in the <code>always</code> list are always applied to the request, even if there is an error. However, headers in <code>onsuccess</code> are only applied to successful requests. <b>The key point to note is that these are two distinct lists of headers which will both potentially be applied to the response for the request.</b> This means that setting a particular header in the <code>always</code> list will not override a header with the same name in the <code>onsuccess</code> list, resulting in the response having a duplicate header.</p>
    <p>Headers set using PHP go into the <code>onsuccess</code> list, and they can be overridden by Apache. For example, if you set a header in PHP using the <code>header()</code> function, but there is also a header with the same name in the Apache configuration set using <code>Header set</code>, the header set with Apache will be given priority, and a single header will be returned. On the other hand, if you have a header set in PHP using <code>header()</code>, and then another with the same name set in the Apache configuration using <code>Header always set</code>, both headers will be returned, resulting in a duplicate.</p>
    <p>It is important that your Content-Security-Policy is served on all pages, including your error pages and other unsuccessful requests, so the <code>always</code> list should be used. However, since PHP will be setting a header in the <code>onsuccess</code> list, this will result in a duplicate header by default, which is not good.</p>
    <p>In order to resolve this, you have to conditionally unset the Content-Security-Policy header in the <code>always</code> list for PHP files which will be setting their own headers. There are two parts to this configuration - a global fallback Content-Security-Policy header which is applied to all responses by default, and then an expression which conditionally unsets the global fallback header only for PHP files which serve their own custom header.</p>
    <p>I have included a copy of my configuration for this below:</p>
    <pre>Header always set Content-Security-Policy: "default-src 'none'; base-uri 'none'; font-src 'none'; form-action 'none'; frame-ancestors 'none'; img-src 'self'; style-src 'self'; block-all-mixed-content"
&lt;FilesMatch \.php$&gt;
    Header always unset Content-Security-Policy "expr=%{REQUEST_STATUS} -in {'200', '400', '401', '403', '404', '500'}"
&lt;FilesMatch \.php$&gt;</pre>
    <p>This configuration will unset the Content-Security-Policy header in the <code>always</code> list for all requests to .php files which have the response code 200, 400, 401, 403, 404 or 500.</p>
    <p>I have custom PHP error pages for 400, 401, 403, 404 and 500 errors, which is why the global override header is removed for those too.</p>
    <p>Put this configuration in one of your Apache configuration files, then test the configuration using <code>apachectl configtest</code>. Then you can reload the server configuration using <code>service apache2 reload</code> (or whatever the equivalent is for your operating system). In order to test your headers, you can use the developer console in your browser, or a website such as <a href="https://securityheaders.com/" target="_blank" rel="noopener">Security Headers</a>.</p>

    <h2 id="conclusion">Conclusion</h2>
    <p>I am extremely happy with this addition to my website, as it has made it significantly easier to have fine-grain control over the Content Security Policy and which directives are used on which pages. Being able to make changes to it directly in the files for my site is a much better approach, as everything is clearly visible, easy to read and most importantly, tracked with Git.</p>
    <p>Hopefully somebody else finds this code useful, please feel free to <a href="/contact/" target="_blank">let me know</a> if you've used it for your own site or modified it for your own purposes!</p>
</div>

<?php include "footer.php" ?>

</body>

</html>
