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
    <h4 class="two-mar-bottom">Allow normal certificates from ca1, but deny all wildcard certificates:</h4>
    <pre class="two-mar-top">example.com IN CAA 0 issue "ca1.example.net"
example.com IN CAA 0 issuewild ";"</pre>
    <h4 class="two-mar-bottom">Deny normal certificates but allow wildcard certificates from ca1:</h4>
    <pre class="two-mar-top">example.com IN CAA 0 issue ";"
example.com IN CAA 0 issuewild "ca1.example.net"</pre>
    <h4 class="two-mar-bottom">Deny all wildcard certificates:</h4>
    <pre class="two-mar-top">example.com IN CAA 0 issuewild ";"</pre>
    <h4 class="two-mar-bottom">Deny all certificate requests:</h4>
    <pre class="two-mar-top">example.com IN CAA 0 issue ";"</pre>
    <h4 class="two-mar-bottom">Report policy violations via email and via HTTP <code>POST</code> to an API:</h4>
    <pre class="two-mar-top">example.com IN CAA 0 iodef "mailto:caa-violations@example.com"
example.com IN CAA 0 iodef "https://api.example.com/report/caa/"</pre>

    <h2 id="dns-record-format">DNS Record Format</h2>
    <p>The format of DNS CAA records consists of the following:</p>
    <pre>example.com IN CAA <i>&lt;flags&gt; &lt;property tag&gt; &lt;property value&gt;</i></pre>
    <h3 id="property-tag">Property Tag</h3>
    <p>The property tag is used to specify which specific CAA policy setting a particular CAA record is referring to. Currently there are 3 different property tags defined in the specification:</p>
    <ul class="large-spaced-list">
        <li><b><code>issue</code></b>: Used to specify a CA that is permitted to issue certificates for your domain. This applies to both normal and wildcard certificates, unless at least one <code>issuewild</code> property tag is present, at which point it applies only to non-wildcard certificates.</li>
        <li><b><code>issuewild</code></b>: Used to specify a CA that is permitted to issue wildcard certificates for your domain. This applies only to wildcard certificates, meaning that you'll still need to add an <code>issue</code> property if you wish to restrict the issuance of non-wildcard certificates as well.</li>
        <li><b><code>iodef</code></b>: Used to specify a HTTP endpoint or email address that policy violation reports should be sent to in Incident Object Description Exchange Format (IODEF / <a href="https://tools.ietf.org/html/rfc7970" target="_blank" rel="noopener">RFC7970</a>).</li>
    </ul>
    <h3 id="property-value">Property Value</h3>
    <p>The property value is the actual setting value that is associated with the property tag. In the case of <code>issue</code> and <code>issuewild</code>, the property value will be the name of a certificate authority, and possibly other metadata such as an account ID (though the latter is not widely supported/implemented). In the case of <code>iodef</code>, the property value will be either an email address prefixed with <code>mailto:</code>, or a HTTP endpoint starting with <code>http://</code> or <code>https://</code>.</p>
    <h3 id="flags">Flags</h3>
    <p>Flags are designed to allow for extending the CAA specification in the future. They are defined using a single unsigned integer (0 to 255, or <code>00000000</code> to <code>11111111</code> when represented in binary). Currently there is only one supported flag, which is the Issuer Critical Flag (represented by bit 0). At the time of writing, the flag value is almost always <code>0</code>.</p>
    <p>The Issuer Critical Flag is used to indicate to CAs that they must only issue certificates if all of the critical flagged property tags contained with the CAA policy for a domain are understood.</p>
    <p>This is to allow the CAA specification to be extended in the future, without creating a loophole where CAs who don't yet conform to the new specification may still be able to issue certificates for a domain because they don't understand or know how to interpret the potentially more stringent CAA policy requirements.</p>
    <p>As a silly example, suppose that the CAA specification was extended to allow for restricting the day of the week that certificates can be issued. E.g.:</p>
    <pre>example.com IN CAA 0 issue "letsencrypt.org"
example.com IN CAA 0 dayofweek "Monday"</pre>
    <p>If we assume that Let's Encrypt haven't yet updated their CAA policy parsing implementation, the <code>dayofweek</code> property cannot be parsed/understood. If someone requests a certificate on a Tuesday, Let's Encrypt will issue it, as even though they do not understand the <code>dayofweek</code> property, the critical flag is <code>0</code> so the issuance goes ahead anyway. This issuance would be in violation of the CAA policy.</p>
    <p>However, if the CAA policy were to be changed to have the Issuer Critical Flag set:</p>
    <pre>example.com IN CAA 0 issue "letsencrypt.org"
example.com IN CAA 1 dayofweek "Monday"</pre>
    <p>...all certificate requests would now be denied until Let's Encrypt upgrade their CAA parser. This is compliant with the CAA policy.</p>
    <p>Once Let's Encrypt update their CAA parser, certificate requests would then be permitted on Mondays.</p>

    <h2 id="example-caa-policy-violation-report">Example CAA Policy Violation Report</h2>
    <p>When using Let's Encrypt with Certbot, attempting to issue a certificate that is in violation of the CAA policy for a domain will result in an error similar to the following:</p>
    <pre>Failed authorization procedure. www.jamiescaife.uk (http-01): urn:ietf:params:acme:error:caa :: CAA record for www.jamiescaife.uk prevents issuance

<b>IMPORTANT NOTES:</b>
 - The following errors were reported by the server:

   Domain: www.jamiescaife.uk
   Type:   None
   Detail: CAA record for www.jamiescaife.uk prevents issuance</pre>
    <p>Each distinct certificate authority has their own CAA error format, however the general details will usually be the same.</p>
    <p>If the targeted domain has a CAA violation reporting endpoint specified via an <code>iodef</code> property, a violation report will also be sent (to be received by the owner of the affected domain).</p>
    <p>Below is an example of a CAA violation report:</p>
    <pre></pre>
    <p>CAA violation reports use the Incident Object Description Exchange Format (IODEF / <a href="https://tools.ietf.org/html/rfc7970" target="_blank" rel="noopener">RFC7970</a>), which is a standardised mechanism for exchanging security report information.</p>
    <p>It's also worth noting that the CAA checking and violation reporting usually only takes place after the standard validation requirements for a certificate request have been satisfied. This means that someone cannot overload you with CAA violation reports just by endlessly requesting certificates for your domain - they must actually be able to prove ownership of the domain/site first.</p>

    <h2 id="other-considerations">Other Considerations</h2>
    <p>Keep in mind that CAA does not give blanket permission to whitelisted CAs to issue certificates. It just means that they are <i>allowed</i> to, as long as all other required validation methods are satisfied as well. For example, proving ownership of the domain name/website.</p>
    <p>Also note that CAA does not necessarily prevent malicious or compromised CAs from issuing certificates for your domain, nor can it stop a person from socially engineering one of your whitelisted CAs or bypassing their technical validation requirements. These scenarios are not likely to be a concern unless you are a high-profile target, and any CA found to be involved or partaking in such activity would be in clear violation of the <a href="https://cabforum.org/about-the-baseline-requirements/" target="_blank" rel="noopener">Baseline Requirements</a>, and would most likely have their status as a publicly trusted CA removed.</p>
    <p>I also recommend implementing <a href="https://developer.mozilla.org/en-US/docs/Web/Security/Certificate_Transparency" target="_blank" rel="noopener">Certificate Transparency</a> (CT) monitoring, which will allow you to receive alerts whenever a certificate is issued for your domain. This is because modern browsers require all certificates to be recorded at the point of issuance in a series of public ledgers known as the Certificate Transparency logs, otherwise they will not be considered trusted. You can read more about this in my article <a href="/blog/letsencrypt-scts-in-certificates" target="_blank">Let's Encrypt SCTs in Certificates</a>.</p>

    <h2 id="conclusion">Conclusion</h2>
    <p>CAA is a valuable extra security control that you can implement for your domain names. Combined with CT log monitoring, it allows you to have control and oversight over the certificates that are issued for your domain.</p>
    <p>Now that support for <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Public_Key_Pinning" target="_blank" rel="noopener">HTTP Public Key Pinning</a> (HPKP) <a href="https://www.chromestatus.com/feature/5903385005916160" target="_blank" rel="noopener">has been removed</a> from most browsers, it is no-longer possible to implement strict certificate fingerprint checking for web-based TLS connections. HPKP was rightly removed due to the <a href="https://scotthelme.co.uk/using-security-features-to-do-bad-things/#usinghpkpforevil" target="_blank" rel="noopener">availability risks</a> that it brought, however CAA + CT still allows you to achieve 95% of the protection.</p>
    <p>If bad actors falsely acquiring certificates is really part of your threat model, then TLS with a trust store full of public CAs is most likely not the best option for you. You may wish to consider using something with native support for strict signature checking instead, such as SSH or GPG, and distributing trusted signatures/fingerprints using a secure out-of-band channel.</p>
</div>

<?php include "footer.php" ?>
