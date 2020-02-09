<?php include "response-headers.php"; content_security_policy();
include_once "bloglist.php"; bloglist("postTop", null, null, 2020); ?>

<div class="body">
    <h1><?php echo $postInfo->title; ?></h1>
    <hr>
    <p><b><?php echo $postInfo->date; ?></b></p>
    <p><?php echo $postInfo->snippet; ?></p>
    <p>Certificate Authority Authorisation (CAA) is a security control that can be used to restrict the Certificate Authorities (CAs) that are permitted to issue certificates for your domain. The purpose of this is to help ensure that only explicitly whitelisted CAs are able to issue certificates, and also to report on any attempted violations of this policy.</p>
    <p>CAA policies are set using the <code>CAA</code> DNS resource record type, and it has been mandatory for issuing CAs to check for and comply with CAA policies since 8th September 2017. The CAA specification is defined in <a href="https://tools.ietf.org/html/rfc8659" target="_blank" rel="noopener">RFC8659</a>.</p>
    <p>The following sample CAA policy marks Let's Encrypt as the only CA authorised to issue certificates for <code>example.com</code>, while reporting violations to the <code>caa@example.com</code> mailbox:</p>
    <pre>example.com IN CAA 0 issue "letsencrypt.org"
example.com IN CAA 0 iodef "mailto:caa@example.com"</pre>
    <p><b>Skip to Section:</b></p>
    <pre class="contents"><b><?php echo $postInfo->title ?></b>
&#x2523&#x2501&#x2501 <a href="#example-caa-policies">Example CAA Policies</a>
&#x2523&#x2501&#x2501 <a href="#dns-record-format">DNS Record Format</a>
&#x2523&#x2501&#x2501 <a href="#example-caa-policy-violation-report">Example CAA Policy Violation Report</a>
&#x2523&#x2501&#x2501 <a href="#"></a>
&#x2523&#x2501&#x2501 <a href="#other-considerations">Other Considerations</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>

    <h2 id="example-caa-policies">Example CAA Policies</h2>
    <p>Below are examples of a wide variety of different CAA policy configurations, which should help you to get CAA set up in the way that you want.</p>
    <p class="two-mar-bottom">Note that I have used <code>ca1.example.net</code> and <code>ca2.example.org</code> to represent two different Certificate Authorities. In reality you'll need to use the CAA policy address of your preferred CA. This is usually just their domain name (e.g. for Let's Encrypt the policy address is <code>letsencrypt.org</code>), however you should check their customer documentation to be sure.</p>
    <h4 class="two-mar-bottom">Allow two CAs to issue normal and wildcard certificates for your domain:</h4>
    <pre class="two-mar-top">example.com IN CAA 0 issue "ca1.example.net"
example.com IN CAA 0 issue "ca2.example.org"</pre>
    <h4 class="two-mar-bottom">Allow ca1 to issue only normal certificates, and ca2 to issue only wildcard certificates:</h4>
    <pre class="two-mar-top">example.com IN CAA 0 issue "ca1.example.net"
example.com IN CAA 0 issuewild "ca2.example.org"</pre>
    <h4 class="two-mar-bottom">Allow ca1 to issue only normal certificates, and ca2 to issue both normal and wildcard certificates:</h4>
    <pre class="two-mar-top">example.com IN CAA 0 issue "ca1.example.net"
example.com IN CAA 0 issue "ca2.example.org"
example.com IN CAA 0 issuewild "ca2.example.org"</pre>
    <h4 class="two-mar-bottom">Allow ca1 to issue certificates, except for <code>subdomain.example.com</code> where only ca2 is allowed:</h4>
    <pre class="two-mar-top">example.com IN CAA 0 issue "ca1.example.net"
subdomain.example.com IN CAA 0 issue "ca2.example.org"</pre>
    <h4 class="two-mar-bottom">Deny all wildcard certificates, except for <code>subdomain.example.com</code> where they are allowed from ca1:</h4>
    <pre class="two-mar-top">example.com IN CAA 0 issuewild ";"
subdomain.example.com IN CAA 0 issuewild "ca1.example.net"</pre>
    <h4 class="two-mar-bottom">Allow normal certificates from any CA, but deny all wildcard certificates:</h4>
    <pre class="two-mar-top">example.com IN CAA 0 issue "ca1.example.net"
example.com IN CAA 0 issuewild ";"</pre>
    <h4 class="two-mar-bottom">Deny normal certificates but allow wildcard certificates from ca1:</h4>
    <pre class="two-mar-top">example.com IN CAA 0 issue ";"
example.com IN CAA 0 issuewild "ca1.example.net"</pre>
    <h4 class="two-mar-bottom">Deny all certificate requests:</h4>
    <pre class="two-mar-top">example.com IN CAA 0 issue ";"</pre>

    <h2 id="dns-record-format">DNS Record Format</h2>
    <p>The format of DNS CAA records consists of the following:</p>
    <pre>example.com IN CAA <i>&lt;flags&gt; &lt;property tag&gt; &lt;property value&gt;</i></pre>
    <h3 id="property-tag">Property Tag</h3>
    <p>The property tag is used to specify which specific CAA policy setting a particular CAA record is referring to. Currently there are 3 different property tags defined in the specification:</p>
    <ul class="large-spaced-list">
        <li><b><code>issue</code></b>: Used to specify a CA that is permitted to issue certificates for your domain. This applies to both normal and wildcard certificates, unless at least one <code>issuewild</code> property tag is present, at which point it applies only to non-wildcard certificates.</li>
        <li><b><code>issuewild</code></b>: Used to specify a CA that is permitted to issue wildcard certificates for your domain. This applies only to wildcard certificates, meaning that you'll need to add an <code>issue</code> property as well if you wish to restrict the issuance of non-wildcard certificates too.</li>
        <li><b><code>iodef</code></b>: Used to specify a HTTP endpoint or email address that policy violation reports should be sent to in Incident Object Description Exchange Format (IODEF / <a href="https://tools.ietf.org/html/rfc7970" target="_blank" rel="noopener">RFC7970</a>).</li>
    <h3 id="property-value">Property Value</h3>
    <p></p>
    <h3 id="flags">Flags</h3>
    <p>Flags are designed to allow for additional extensibility of CAA in the future. They are defined using a single unsigned integer (0 to 255, or <code>00000000</code> to <code>11111111</code> when respresented in binary). Currently there is only one supported flag, which is the Issuer Critical Flag (respresented by bit 0). At the time of writing, the flag value is almost always <code>0</code>.</p>
    <p>The Issuer Critical Flag is used to indicate to CAs that they must only issue certificates if <b>all</b> of the property tags contained with the CAA policy for a domain are understood.</p>
    <p>This is to allow the CAA specification to be extended in the future, without creating a loophole where CAs who don't yet conform to the new specification may still be able to issue certificates for a domain because they don't understand or know how to interpret the potentially more stringent CAA policy requirements.</p>
    <p>As a silly example, suppose that the CAA specification was extended to allow for restricting the day of the week that certificates can be issued. E.g.:</p>
    <pre>example.com IN CAA 0 issue "letsencrypt.org"
example.com IN CAA 0 dayofweek "Monday"</pre>
    <p>If we assume that Let's Encrypt haven't yet updated their CAA policy parsing implementation, the <code>dayofweek</code> property cannot be parsed/understood. If someone requests a certificate on a Tuesday, Let's Encrypt will issue it, as even though they do not understand the <code>dayofweek</code> property, the critical flag is <code>0</code> so the issuance goes ahead anyway. This issuance would be in violation of the CAA policy.</p>
    <p>However, if the CAA policy were to be changed to have the Issuer Critical Flag set:</p>
    <pre>example.com IN CAA 0 issue "letsencrypt.org"
example.com IN CAA 1 dayofweek "Monday"</pre>
    <p>...all certificate requests would now be denied until Let's Encrypt upgrade their CAA parser. This is compliant with the CAA policy.</p>

    <h2 id="example-caa-policy-violation-report">Example CAA Policy Violation Report</h2>

    <h2 id="other-considerations">Other Considerations</h2>
    <p>Keep in mind that CAA does not give blanket permission to whitelisted CAs to issue certificates. It just means that they are <i>allowed</i> to, as long as all other required validation methods are satisified as well. For example, providing ownership of the domain name/website.</p>
    <p>Also note that CAA does not necessarily prevent malicious or compromised CAs from issuing certificates for your domain, nor can it stop a person from socially engineering one of your whitelisted CAs or bypassing their technical validation requirements. These scenarios are not likely to be a concern unless you are a high-profile target, and any CA found to be involved or partaking in such activity would be in clear violation of the Baseline Requirements, and would most likely have their status as a publicly trusted CA removed.</p>
    <p>I also recommend implementing Certificate Transarency monitoring, which will allow you to receive alerts whenever a certificate is issued for your domain. This is because modern browsers require all certificates to be recorded at the point of issuance in a public ledger known as the Certificate Transparency logs, otherwise they will not be considered trusted. You can read more about this in my article <a href="/blog/letsencrypt-scts-in-certificates" target="_blank">Let's Encrypt SCTs in Certificates</a>.</p>

    <h2 id="conclusion">Conclusion</h2>
    <p></p>
</div>

<?php include "footer.php" ?>
