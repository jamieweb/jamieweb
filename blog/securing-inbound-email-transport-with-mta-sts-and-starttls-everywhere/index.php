<?php include "response-headers.php"; content_security_policy();
include_once "bloglist.php"; bloglist("postTop", null, null, 2019); ?>

<div class="body">
    <h1><?php echo $postInfo->title; ?></h1>
    <hr>
    <p><b><?php echo $postInfo->date; ?></b></p>
    <p><?php echo $postInfo->snippet; ?></p>
    <p>The web security ecosystem has matured significantly over the past few years, partly thanks to organisations like Let's Encrypt and the ACME protocol, as well as because of encouragement from browser vendors for websites to implement HTTPS and other security controls such as Content Security Policy.</p>
    <p>However, the email ecosystem unfortunately hasn't seen such levels of development. Existing technologies for securely transporting emails, such as STARTTLS, are not as resistant to attacks as their web-based counterparts, and the implementation methods available to sysadmins are far more limited.</p>
    <p>In this blog post I'm going to talk about two new email security technologies: <b>MTA-STS</b> and <b>STARTTLS-Everywhere</b>. These allow you to have greater control and insight into how your emails are securely transported. In this post I will focus on security and reporting for inbound/incoming emails, however in the future I may also cover outbound/outgoing emails.</p>
    <p><b>Skip to Section:</b></p>
    <pre><b><?php echo $postInfo->title ?></b>
&#x2523&#x2501&#x2501 <a href="#mta-sts">MTA-STS</a>
&#x2523&#x2501&#x2501 <a href="#tlsrpt">TLSRPT</a>
&#x2523&#x2501&#x2501 <a href="#enabling-mta-sts-and-tlsrpt-for-your-domain">Enabling MTA-STS For Your Domain</a>
&#x2523&#x2501&#x2501 <a href="#starttls-everywhere">STARTTLS-Everywhere</a>
&#x2523&#x2501&#x2501 <a href="#adding-your-domain-to-the-starttls-everywhere-list">Adding Your Domain to the STARTTLS-Everywhere List</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>

    <h2 id="mta-sts">MTA-STS</h2>
    <p>MTA-STS (Mail Transfer Agent Strict Transport Security) is a new internet standard (<a href="https://tools.ietf.org/html/rfc8461" target="_blank" rel="noopener">RFC8461</a>) which allows you to advertise a force-TLS policy for your domain by hosting a plaintext policy file at a specific location. Supported MTAs (Mail Transfer Agents) will then automatically read this policy when they send email to you, and force the connection to use TLS with a valid certificate. It is very similar to HTTP Strict Transport Security, which is a web security header used by websites to instruct browsers that future connections should be conducted over HTTPS only.</p>
    <p>MTA-STS works on a TOFU (Trust On First Use) basis, meaning that once a policy is read at least once, it will be cached by the MTA for a specified length of time. This does technically mean that an attacker could defeat MTA-STS by preventing a victim MTA from ever making a request to the MTA-STS policy file hosted on the recipient's domain, however in most cases this isn't a significant concern. However, a mitigation for this is <a href="#starttls-everywhere">STARTTLS-Everywhere</a>, which is discussed later in this blog post.</p>
    <p>MTA-STS policy files are plaintext files that must be accessible via HTTPS at the <code>/.well-known/mta-sts.txt</code> file path on the <code>mta-sts</code> subdomain. For example, a valid MTA-STS policy file path would be <code>https://mta-sts.example.com/.well-known/mta-sts.txt</code>. An example of a policy file is shown below:</p>
    <pre>version: STSv1
mode: enforce
max_age: 86401
mx: mail1.example.com
mx: mail2.example.com</pre>
    <p>The file contains a selection of 4 standard directives:</p>
    <ul class="spaced-list">
        <li><b><code>version</code></b>: The version of the MTA-STS standard in-use. Currently only <code>STSv1</code> is supported.</li>
        <li><b><code>mode</code></b>: The enforcement mode, which can be either of:
        <ul>
            <li><code>enforce</code>: Bounce emails that cannot be securely delivered and report on failures.</li>
            <li><code>testing</code>: Allow non-secure emails to be delivered, but still report on failures.</li>
        </ul>
        <li><b><code>max_age</code></b>: The length of time (in seconds) that a policy should be cached for. Longer times are advantageous for security.</li>
        <li><b><code>mx</code></b>: A mail server that is permitted to process email for your domain, and serves a valid certificate for the hostname. All of your mail servers should be specified (usually all hosts present in your <code>MX</code> DNS records).</li>
    </ul>
    <p>Your policy file must be served over a valid HTTPS connection using the <code>text/plain</code> MIME type at exactly the <code>/.well-known/mta-sts.txt</code> on the <code>mta-sts</code> subdomain.</p>

    <h2 id="tlsrpt">TLSRPT</h2>
    <p>MTA-STS is directly complemented by TLSRPT (TLS Reporting), which is a reporting mechanism for </p>

    <h2 id="mta-sts">Enabling MTA-STS and TLSRPT For Your Domain</h2>
    <p></p>

    <h2 id="starttls-everywhere">STARTTLS-Everywhere</h2>
    <p></p>

    <h2 id="adding-your-domain-to-the-starttls-everywhere-list">Adding Your Domain to the STARTTLS-Everywhere List</h2>
    <p></p>

    <h2 id="conclusion">Conclusion</h2>
    <p></p>
</div>

<?php include "footer.php" ?>
