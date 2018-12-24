<?php include "response-headers.php"; content_security_policy(); ?>
<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Let's Encrypt SCTs in Certificates</title>
    <meta name="description" content="Let's Encrypt certificates now have Signed Certificate Timestamps (SCTs) included by default.">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/blog/letsencrypt-scts-in-certificates/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Let's Encrypt SCTs in Certificates</h1>
    <hr>
    <p><b>Wednesday 4th April 2018</b></p>
    <p>As of 29th March 2018, all certificates issued by Let's Encrypt now include a Signed Certificate Timestamp (SCT) embedded in the certificate in the form of an <a href="https://tools.ietf.org/html/rfc5280#section-4.2" target="_blank" rel="noopener">X.509 v3 extension</a>.</p>
    <p><b>Skip to Section:</b></p>
    <pre><b>Let's Encrypt SCTs in Certificates</b>
&#x2523&#x2501&#x2501 <a href="#chrome-requirements">Upcoming Chrome Certificate Transparency Requirements</a>
&#x2523&#x2501&#x2501 <a href="#expect-ct">Expect-CT HTTP Response Header</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>
    <p>Below is part of the <a href="https://www.ssllabs.com/ssltest/index.html" target="_blank" rel="noopener">SSLLabs</a> report for my site that is using a recently issued Let's Encrypt certificate, showing that Certificate Transparency (CT) is working, and that the SCT is embedded in the certificate:</p>
    <img width="1000px" src="/blog/letsencrypt-scts-in-certificates/ssllabs-ct.png">
    <p>Let's Encrypt certificates have always been published to CT logs, however by default there was no straightforward way to serve SCTs. Now SCTs are included by default in all newly issued Let's Encrypt certificates. Please see the original announcement by Let's Encrypt: <a href="https://community.letsencrypt.org/t/signed-certificate-timestamps-embedded-in-certificates/57187" target="_blank" rel="noopener">https://community.letsencrypt.org/<wbr>t/signed-certificate-timestamps-embedded-in-certificates/57187</a></p>
    <h2 id="chrome-requirements">Upcoming Chrome Certificate Transparency Requirements</h2>
    <p>This new Let's Encrypt feature is in good time for Chrome's upcoming CT requirements, which state that all certificates issued after 30th April 2018 must be compliant with the <a href="https://github.com/chromium/ct-policy" target="_blank" rel="noopener">Chromium CT policy</a>:</p>
    <p class="two-no-mar font-twenty-three quote-indent"><i>&ldquo;Chrome will require that all TLS server certificates issued after 30 April, 2018 be compliant with the Chromium CT Policy. After this date, when Chrome connects to a site serving a publicly-trusted certificate that is not compliant with the Chromium CT Policy, users will begin seeing a full page interstitial indicating their connection is not CT-compliant. Sub-resources served over https connections that are not CT-compliant will fail to load and will show an error in Chrome DevTools...&rdquo;</i></p>
    <p class="two-mar-top centertext"><i>Source: <a href="https://groups.google.com/a/chromium.org/d/msg/ct-policy/wHILiYf31DE/iMFmpMEkAQAJ" target="_blank" rel="noopener">https://groups.google.com/<wbr>a/chromium.org/d/msg/ct-policy/wHILiYf31DE/iMFmpMEkAQAJ</a></i></p>
    <p>This essentially means that all certificates issued after 30th April 2018 need to prove their compliance with the CT requirements by serving a valid SCT to clients in either of the following forms:</p>
    <ul>
        <li>X.509 v3 Certificate Extension</li>
        <li>OCSP Stapling with SCT in OCSP Extension</li>
        <li>TLS Extension</li>
    </ul>
    <p>Websites/servers that fail to do this will no longer be considered trusted by Chrome and Chromium. However, in most cases, the Certificate Authority (CA) will resolve this by issuing certificates with the SCTs embedded (as Let's Encrypt have), so for the average website owner, they likely will not have to do anything. Certificates issued before the deadline will continue to work as normal as they are not subject to these new requirements.</p>
    <p>Below is an example of the full-page error screen as described in the Google Chrome Team's announcement that will be shown instead:</p>
    <img width="1000px" src="/blog/letsencrypt-scts-in-certificates/chromium-ct-warning-example.png">
    <p>In order to simulate enforced certificate transparency before the 30th April 2018 deadline, you can add your site to the Expect-CT list in your local version of Chrome at <a href="chrome://net-internals#hsts" target="_blank">chrome://net-internals#hsts</a>:</p>
    <img width="1000px" src="/blog/letsencrypt-scts-in-certificates/chrome-net-internals-expect-ct.png">
    <p>Make sure to check the 'Enforce' box. This will now simulate enforced certificate transparency for the domain you specified in your local browser only. In order to revert these local changes, enter your domain into the 'Delete domain security policies' form on the same page.</p>
    <h2 id="expect-ct">Expect-CT HTTP Response Header</h2>
    <p>Now that Let's Encrypt is issuing certificates with the SCT included, it makes it significantly easier to deploy a working <code>Expect-CT</code> HTTP response header. This header allows you to opt-in to the new requirements early, as well as providing a reporting functionality using the <code>report-uri</code> directive.</p>
    <p>An example of a valid <code>Expect-CT</code> header is as follows:</p>
    <pre>Expect-CT: max-age=63072000, enforce, report-uri="https://report-uri.example.com/ct/"</pre>
    <p>This will instruct browsers to cache the policy for 63,072,000 seconds (2 years), enforce the policy strictly (rather than being report-only), and report violations to the specified URI.</p>
    <p>Going straight in at a 2 year enforcement policy is perhaps a bit overzealous, especially for a newer technology. If something goes wrong and you have to go back to using a non-CT-compliant configuration, you risk locking users out of your site for a prolonged period of time. While this is very unlikely to happen, especially given that Chrome and Chromium are going to be automatically enforcing this at the end of April anyway, it's still better to play it safe and increment the <code>max-age</code> value of your policy. Start out at a very short amount of time (a few minutes) and check for issues. Once your happy that there are no problems, raise it to 1 day, then 1 week, etc.</p>
    <p>It is also important to note that as per the <a href="https://tools.ietf.org/html/draft-ietf-httpbis-expect-ct-03" target="_blank" rel="noopener">Expect-CT draft specification</a>, your client will not cache the policy if the connection is not CT-compliant. This prevents you from accidentally setting an <code>Expect-CT</code> policy when the connection is not CT-compliant in the first place:</p>
    <pre>If the connection does not comply with the UA's CT Policy (i.e. is
not CT-qualified), then the UA MUST NOT note this host as a Known
Expect-CT Host.</pre>
    <p class="two-no-mar centertext"><i>Source: <a href="https://tools.ietf.org/html/draft-ietf-httpbis-expect-ct-03#section-2.3.1" target="_blank" rel="noopener">https://tools.ietf.org/<wbr>html/draft-ietf-httpbis-expect-ct-03#section-2.3.1</a></i></p>
    <h2 id="conclusion">Conclusion</h2>
    <p>I have reissued all of my Let's Encrypt certificates in order to make use of the new automatically included SCTs, and have also enabled the <code>Expect-CT</code> security header on my site with the <code>enforce</code> directive set.</p>
    <p>It'll also be interesting to keep an eye on CT up until and beyond the deadline - it's another piece of the TLS puzzle solved hopefully.</p>
</div>

<?php include "footer.php" ?>

</body>

</html>
