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
&#x2523&#x2501&#x2501 <a href="#adding-your-domain-to-the-starttls-everywhere-policy-list">Adding Your Domain to the STARTTLS-Everywhere Policy List</a>
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
    <p><a href="https://starttls-everywhere.org/" target="_blank" rel="noopener">STARTTLS-Everywhere</a> is a project founded by the <a href="https://eff.org/" target="_blank" rel="noopener">EFF</a> with the goal of creating a globally shared list of mail servers that are known to support STARTTLS.</p>
    <p>The purpose of this list is to act as a point of reference for mail servers to know whether other mail servers support STARTTLS, prior to actually connecting to them and trying. This means that emails can be delivered between secured domains over TLS by default, rather than having to negotiate a secure/insecure connection.</p>
    <p>Implementing STARTTLS-Everywhere means that man-in-the-middle and/or downgrade attacks against the email transport would be significant more complex to carry out, as the bar is raised from having network-level access to now also requiring a valid certificate for the victim mail server.</p>
    <p>STARTTLS-Everywhere is essentially <a href="https://hstspreload.org/" target="_blank" rel="noopener">HSTS Preload</a>, but for email.</p>

    <h2 id="adding-your-domain-to-the-starttls-everywhere-policy-list">Adding Your Domain to the STARTTLS-Everywhere Policy List</h2>
    <p>Adding your domain to the list will result in incoming email from supported providers being delivered over forced TLS by default, even if your MTA-STS policy hasn't yet been cached by the sending mail server. In other words, STARTTLS-Everywhere eliminates the TOFU (Trust On First Use) aspect of MTA-STS.</p>
    <p>If you also wish to utilise the STARTTLS-Everywhere list for outgoing email, you'll need to install the list on your mail server and configure it to force TLS connections to domains present on the list. I won't be covering this in the current article, however the EFF have <a href="https://github.com/EFForg/starttls-policy-cli" target="_blank" rel="noopener">published a Python utility</a> to automatically update the list and generate config files for using the list with Postfix.</p>
    <p>Before submitting your domain to the list, you can perform a prelimiary security check on your domain using the form on the <a href="https://starttls-everywhere.org/" target="_blank" rel="noopener">STARTTLS-Everywhere homepage</a>. This will check whether your domain has implemented MTA-STS, and whether your mail servers support STARTTLS with a valid certificate and strong TLS configuration. It also checks whether your domain is already on the STARTTLS-Everywhere list.</p>
    <img class="radius-8 border-2px-solid" width="1000px" src="starttls-everywhere-domain-check-results.png">
    <p class="two-no-mar centertext"><i>A screenshot of the STARTTLS-Everywhere domain check results for jamieweb.net, showing that my mail servers support STARTTLS, but that I am not yet on the policy list.</i></p>
    <p>If your domain check results are all OK, you can proceed to the <a href="https://starttls-everywhere.org/add-domain" target="_blank" rel="noopener">STARTTLS-Everywhere submission form</a> in order to add your domain.</p>
    <img class="radius-8 border-2px-solid" width="1000px" src="starttls-everywhere-adding-domain-to-list.png">
    <p class="two-no-mar centertext"><i>A screenshot of the STARTTLS-Everywhere submission form, with the details filled in for jamieweb.net.</i></p>
    <p>It helps massively if you have already implemented MTA-STS, as the form can just pull a list of mail servers from your hosted <code>mta-sts.txt</code> policy file. Otherwise, you'll have to manually enter each of the mail servers which are authorised to process mail for your domain.</p>
    <p>Once you have completed the form, a verification email will be sent to the <code>postmaster</code> mailbox on your domain.</p>
    <img class="radius-8 border-2px-solid" width="1000px" src="starttls-everywhere-adding-domain-to-list-confirmation.png">
    <p class="two-no-mar centertext"><i>A screenshot of the confirmation prompt after filling in the form, asking me to check my email to view the verification message that has been sent.</i></p>
    <p>Once you have received the verification email and visited the verification link, your domain will be queued for addition to the list.</p>
    <img class="radius-8 border-2px-solid" width="1000px" src="starttls-everywhere-adding-domain-to-list-success.png">
    <p class="two-no-mar centertext"><i>A screenshot of the completed verification, confirming that my domain has been successfully queued for addition to the list.</i></p>
    <p>Your domain will continue to be assessed for security and compliance for a period of time before being added to the list. If for any reason your domain ceases to be compliant (e.g. if you stop supporting STARTTLS, your certificate expires, etc), you will be removed from the queue and will have to re-submit.</p>
    <p>You'll receive a confirmation email once you've been fully added to the list (which may take several weeks), however in the mean time you can run the domain security check again to view your status in the queue.</p>
    <img class="radius-8 border-2px-solid" width="1000px" src="starttls-everywhere-domain-check-queued.png">
    <p class="two-no-mar centertext"><i>A screenshot of the STARTTLS-Everywhere domain security check, showing that my jamieweb.net domain is currently queued for addition to the list.</i></p>
    <p>Once you receive your confirmation email, you can <a href="https://dl.eff.org/starttls-everywhere/policy.json" target="_blank" rel="noopener">view the full, raw policy list</a> and have a look for your domain!</p>
    <p>Email providers which implement the STARTTLS-Everywhere policy list will now connect to your mail servers securely by default, no matter whether an MTA-STS policy has been cached or not.</p>

    <h2 id="conclusion">Conclusion</h2>
    <p>I am hoping that adoption of MTA-STS and utilisation of the STARTTLS-Everywhere policy list will continue to increase, however support for both of these is currently quite limited, especially in proprietary email systems/services used by many large enterprises and governments.</p>
    <p>I have also recently written a full end-to-end step-by-step guide on implementing MTA-STS and TLSRPT, including setting up a web server to host your policy file. This was done as part of my freelance writing work for DigitalOcean, so feel tree to <a href="https://www.digitalocean.com/community/tutorials/how-to-configure-mta-sts-and-tls-reporting-for-your-domain-using-apache-on-ubuntu-18-04" target="_blank" rel="noopener">take a look</a> if you'd prefer more of a tutorial-style article.</p>
</div>

<?php include "footer.php" ?>
