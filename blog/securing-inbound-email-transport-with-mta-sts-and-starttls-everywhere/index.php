<?php include "response-headers.php"; content_security_policy();
include_once "bloglist.php"; bloglist("postTop", null, null, 2019); ?>

<div class="body">
    <h1><?php echo $postInfo->title; ?></h1>
    <hr>
    <p><b><?php echo $postInfo->date; ?></b></p>
    <p><?php echo $postInfo->snippet; ?></p>
    <p>The web security ecosystem has matured significantly over the past few years, partly thanks to organisations like Let's Encrypt and the ACME protocol, as well as because of encouragement from browser vendors for websites to implement HTTPS and other security controls such as Content Security Policy.</p>
    <p>However, the email ecosystem unfortunately hasn't seen such levels of development. Existing technologies for securely transporting emails, such as STARTTLS, are not as resistant to attacks as their web-based counterparts, and the implementation methods available to sysadmins are far more limited.</p>
    <p>In this blog post I'm going to talk about three new email security technologies: <b>MTA-STS</b>, <b>TLSRPT</b> and <b>STARTTLS-Everywhere</b>. These allow you to have greater control and insight into how your emails are securely transported. In this post I will focus on security and reporting for inbound/incoming emails, however in the future I may also cover outbound/outgoing emails.</p>
    <p><b>Skip to Section:</b></p>
    <pre><b><?php echo $postInfo->title ?></b>
&#x2523&#x2501&#x2501 <a href="#mta-sts">MTA-STS</a>
&#x2523&#x2501&#x2501 <a href="#enabling-mta-sts-for-inbound-email">Enabling MTA-STS For Inbound Email</a>
&#x2523&#x2501&#x2501 <a href="#tlsrpt">TLSRPT</a>
&#x2523&#x2501&#x2501 <a href="#enabling-tlsrpt-for-your-domain">Enabling TLSRPT For Your Domain</a>
&#x2523&#x2501&#x2501 <a href="#interpreting-tlsrpt-reports">Interpreting TLSRPT Reports</a>
&#x2523&#x2501&#x2501 <a href="#starttls-everywhere">STARTTLS-Everywhere</a>
&#x2523&#x2501&#x2501 <a href="#adding-your-domain-to-the-starttls-everywhere-list">Adding Your Domain to the STARTTLS-Everywhere List</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>

    <h2 id="mta-sts">MTA-STS</h2>
    <p>MTA-STS (Mail Transfer Agent Strict Transport Security) is a new internet standard (<a href="https://tools.ietf.org/html/rfc8461" target="_blank" rel="noopener">RFC8461</a>) which allows you to advertise a force-TLS policy for your domain by hosting a plaintext policy file at a specific location. Supported MTAs (Mail Transfer Agents) will then automatically read this policy when they send email to you, and force the connection to use TLS with a valid certificate. It is very similar to <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Strict-Transport-Security" target="_blank" rel="noopener">HTTP Strict Transport Security</a>, which is a web security header used by websites to instruct browsers that future connections should be conducted over HTTPS only.</p>
    <p>At the time of writing, the only large provider to have implemented MTA-STS is Google Mail. However, it is likely that many other providers such as Office 365 and FastMail will follow along in the future.</p>
    <p>MTA-STS works on a TOFU (Trust On First Use) basis, meaning that once a policy is read at least once, it will be cached by the MTA for a specified length of time. This does technically mean that an attacker could defeat MTA-STS by preventing a victim MTA from ever making a request to the MTA-STS policy file hosted on the recipient's domain, however in most cases this isn't a significant concern. However, a mitigation for this is <a href="#starttls-everywhere">STARTTLS-Everywhere</a>, which is discussed later in this blog post.</p>

    <h2 id="enabling-mta-sts-for-inbound-email">Enabling MTA-STS For Inbound Email</h2>
    <p>In order to enable MTA-STS for incoming email, you'll first need to create and host a policy file. MTA-STS policy files are plaintext files that must be accessible via HTTPS at the <code>/.well-known/mta-sts.txt</code> file path on the <code>mta-sts</code> subdomain. For example, a valid MTA-STS policy file path would be <code>https://mta-sts.example.com/.well-known/mta-sts.txt</code>.</p>
    <p>An example of a policy file is shown below:</p>
    <pre>version: STSv1
mode: enforce
max_age: 86401
mx: mail1.example.com
mx: mail2.example.com</pre>
    <p>The file contains a selection of 4 standard directives:</p>
    <ul class="spaced-list">
        <li><b><code>version</code></b>: The version of the MTA-STS standard in use. Currently only <code>STSv1</code> is supported.</li>
        <li><b><code>mode</code></b>: The enforcement mode, which can be either of:
        <ul class="spaced-list">
            <li><code>enforce</code>: Bounce emails that cannot be securely delivered and report on failures.</li>
            <li><code>testing</code>: Allow non-secure emails to be delivered, but still report on failures.</li>
        </ul>
        <li><b><code>max_age</code></b>: The length of time (in seconds) that a policy should be cached for. Longer times are advantageous for security.</li>
        <li><b><code>mx</code></b>: A mail server that is permitted to process email for your domain, and serves a valid certificate for the hostname. All of your mail servers should be specified (usually all hosts present in your <code>MX</code> DNS records).</li>
    </ul>
    <p>Your policy file must be served over a valid HTTPS connection using the <code>text/plain</code> MIME type at exactly the <code>/.well-known/mta-sts.txt</code> on the <code>mta-sts</code> subdomain.</p>
    <div class="message-box message-box-warning-medium">
        <div class="message-box-heading">
            <h3><u>Warning!</u></h3>
        </div>
        <div class="message-box-body">
            <p>Enabling MTA-STS in <code class="color-darkslategrey">enforce</code> mode means that email deliverability will be directly dependent on TLS being enabled and a valid certificate being served on all of your mail servers. If your certificate expires or becomes otherwise invalid, or if your TLS implementation becomes non-functional, some emails sent to you may not get through.</p><br>
            <p>Any updates to your mail server setup may also need to be reflected in your MTA-STS policy file, for example adding/removing/adjusting MX records.</p><br>
            <p>It is recommended to first enable MTA-STS in <code class="color-darkslategrey">testing</code> mode, and use the associated <a href="#tlsrpt">TLSRPT</a> standard (which is also discussed in this blog post) to verify that deliverability has not been impacted.</p>
        </div>
    </div>
    <p>In addition to hosting a policy file, you also need to add a DNS TXT record under the <code>_mta-sts</code> label. This is used to indicate to supported MTAs that they should check for a policy file and enable MTA-STS using the specified mode if one is found.</p>
    <p>An example of a valid DNS record for MTA-STS is below:</p>
    <pre>_mta-sts.example.com IN TXT "v=STSv1; id=20191211235602"</pre>
    <p>The DNS record contains just 2 standard directives, both of which are mandatory:</p>
    <ul class="spaced-list">
        <li><b><code>v</code></b>: The version of the MTA-STS standard in use. Currently only <code>STSv1</code> is supported.</li>
        <li><b><code>id</code></b>: A unique value to identify the current version of the policy file in place. <u>If you update your policy file, you should also update the ID value in the DNS record.</u> Any unique value can be used, but generally the current date and time is easiest to manage (e.g. <code>20191211235602</code> is 23:56:02 on 2019-12-11.</li>
    </ul>
    <p>You don't need to specify the URL or path to your <code>mta-sts.txt</code> policy file anywhere in the DNS record, as the path is standardised within the specification.</p>
    <p>Once you have hosted your policy file and set the required DNS record, MTA-STS will be enabled for your domain. You can use an <a href="https://aykevl.nl/apps/mta-sts/" target="_blank" rel="noopener">MTA-STS validator</a> in order to verify your configuration.</p>

    <h2 id="tlsrpt">TLSRPT</h2>
    <p>MTA-STS is directly complemented by TLSRPT (SMTP TLS Reporting, <a href="https://tools.ietf.org/html/rfc8460" target="_blank" rel="noopener">RFC8460</a>), which is a reporting mechanism that allows you to collect information on whether emails are successfully being delivered over TLS, as well as any errors that may have occured (e.g. an expired certificate).</p>
    <p>TLSRPT works in a very similar way to DMARC reporting. You specify a reporting endpoint (a URL or an email address) via a DNS record, which then causes email service providers to send you daily reports in JSON format.</p>

    <h2 id="enabling-tlsrpt-for-your-domain">Enabling TLSRPT For Your Domain</h2>
    <p>TLSRPT is enabled by setting a DNS TXT record under the <code>_smtp._tls</code> label to specify that you'd like to receive reports and where these should be sent. You'll need to have MTA-STS configured and enabled as well, in either <code>testing</code> or <code>enforce</code> mode.</p>
    <p>An example of a valid TLSRPT record is shown below:</p>
    <pre>_smtp._tls.example.com IN TXT "v=TLSRPTv1; rua=mailto:tlsrpt@example.com,https://reports.example.com/tlsrpt/"</pre>
    <p>Like MTA-STS, the DNS record for TLSRPT contains just 2 standard directives, both of which are mandatory:</p>
    <ul class="spaced-list">
        <li><b><code>v</code></b>: The version of the TLSRPT standard in use. Currently only <code>TLSRPTv1</code> is supported.</li>
        <li><b><code>rua</code></b>: A comma-separated list of URLs or email addresses where reports should be sent. Email addresses must be prefixed with <code>mailto:</code>, and API endpoint URLs should use HTTPS and accept <code>POST</code> requests containing the report in gzip format (containing compressed JSON), or in some cases, just plain JSON. You do not have to use APIs/email addresses on the same domain as you are reporting for - any domain can be used.</li>
    </ul>
    <p>Once you have enabled MTA-STS and TLSRPT, you should receive your first report within 48 hours, as long as an email provider which supports MTA-STS and TLSRPT (such as Google Mail) sends at least one email to an address on your domain.</p>
    <div class="message-box message-box-notice">
        <div class="message-box-heading">
            <h3><u>Note:</u></h3>
        </div>
        <div class="message-box-body">
            <p>In the event that sending MTAs cannot comply with your MTA-STS policy (e.g. if the certificate on your mail server expires, etc), TLSRPT emails will still be delivered. This is explicitly stated in the standard (<a href="https://tools.ietf.org/html/rfc8460#section-5.3.1" target="_blank" rel="noopener">section 5.3.1</a>) in order to ensure that report emails will always get through, no matter whether they are delivered securely or not:</p>
        </div>
    </div>

    <h2 id="interpreting-tlsrpt-reports">Interpreting TLSRPT Reports</h2>
    <p>Reports will be delivered in the form of a JSON payload, usually compressed using gzip. The <code>.json.gz</code> file will be HTTP <code>POST</code>-ed to an API endpoint or sent as an email attachment to the address(es) that you specified in the TLSRPT DNS record.</p>
    <p>You can decompress gzipped reports using <code>gzip -d report.json.gz</code>. You can then prettify the resulting JSON using <code>jq . report.json</code> or <code>python -m json.tool report.json</code>.</p>
    <p>An example of a TLSRPT report is shown below (prettified JSON):</p>
    <pre>{
    "organization-name": "Google Inc.",
    "date-range": {
        "start-datetime": "2019-12-11T00:00:00Z",
        "end-datetime": "2019-12-11T23:59:59Z"
    },
    "contact-info": "smtp-tls-reporting@google.com",
    "report-id": "2019-12-11T00:00:00Z_example.com",
    "policies": [
        {
            "policy": {
                "policy-type": "sts",
                "policy-string": [
                    "version: STSv1",
                    "mode: enforce",
                    "mx: mail1.example.com",
                    "mx: mail2.example.com",
                    "max_age: 86401"
                ],
                "policy-domain": "example.com"
            },
            "summary": {
                "total-successful-session-count": 773,
                "total-failure-session-count": 0
            }
        }
    ]
}</pre>
    <p>This report shows that Google's MTA (for Gmail and G Suite) successfully detected an MTA-STS policy for the domain <code>example.com</code>, and that there were 773 successful TLS sessions (emails delivered from Google's MTA to your domain) during the report timeframe.</p>
    <div class="message-box message-box-notice">
        <div class="message-box-heading">
            <h3><u>Note:</u></h3>
        </div>
        <div class="message-box-body">
            <p>One TLS session is not necessarily equivalent to one email, as in some cases multiple emails will be delivered over the same TLS session. However, the session count is a good rough guidance number for the total number of delivered emails in the majority of cases.</p>
        </div>
    </div>
    <p>I personally use the <a href="https://uriports.com/" target="_blank" rel="noopener">URIports</a> service as my reporting endpoint, which will automatically process reports, produce a graph showing deliverability, and can be configured to send alerts if a failure is reported.</p>

    <h2 id="starttls-everywhere">STARTTLS-Everywhere</h2>
    <p></p>

    <h2 id="adding-your-domain-to-the-starttls-everywhere-list">Adding Your Domain to the STARTTLS-Everywhere List</h2>
    <p></p>

    <h2 id="conclusion">Conclusion</h2>
    <p></p>
</div>

<?php include "footer.php" ?>
