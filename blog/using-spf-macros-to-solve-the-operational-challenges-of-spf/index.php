<?php include "response-headers.php"; content_security_policy();
include_once "bloglist.php"; bloglist("postTop", null, null, 2020); ?>

<div class="body">
    <h1><?php echo $postInfo->title . "</h1>\n" . (isset($postInfo->subtitle) ? "    <h2 class=\"subtitle-mar-top\">" . $postInfo->subtitle . "</h2>\n" : ""); ?>
    <hr>
    <p><b><?php echo $postInfo->date; ?></b></p>
    <!--INTRO START-->
    <p>Sender Policy Framework (SPF) provides a way to restrict the mail servers that are permitted to send as your domain, and is particularly effective when used with DMARC.</p>
    <p>However, maintaining an SPF policy for a large or complex infrastructure with numerous distinct mail servers can pose a significant operational challenge. Some of the most common issues include:</p>
    <ul class="spaced-list">
        <li>SPF record is too long</li>
        <li>Maximum number of DNS lookups has been reached</li>
        <li>Keeping your SPF record up-to-date when mail is sent by third-parties</li>
        <li>Keeping track of which whitelisted senders are for what, who put them there, and removing them when they're no-longer needed</li>
        <li>Having to globally whitelist third-party systems when they only need to send-as a single or small number of addresses</li>
        <li>SPF record syntax becoming messy or breaking when it is maintained by multiple different people</li>
    </ul>
    <p>SPF macros, a seldom used yet widely supported feature of the SPF specification, provide a potential solution to some of these challenges.</p>
    <p>This article includes an introduction to SPF macros, as well as several examples of how they can be used to solve the various operational complications that SPF so often poses.</p>
    <!--INTRO END-->
    <p><b>Skip to Section:</b></p>
    <pre class="contents"><b><?php echo $postInfo->title . (isset($postInfo->subtitle) ? "\n" . $postInfo->subtitle : ""); ?></b>
&#x2523&#x2501&#x2501 <a href="#what-are-spf-macros">What are SPF macros?</a>
&#x2523&#x2501&#x2501 <a href="#macro-syntax">Macro Syntax</a>
&#x2523&#x2501&#x2501 <a href="#example-1">Example #1: Permit individual IP addresses by adding a single DNS record for each</a>
&#x2523&#x2501&#x2501 <a href="#example-2">Example #2: Permit ranges of IP addresses using wildcard DNS records</a>
&#x2523&#x2501&#x2501 <a href="#example-3">Example #3: Restrict a third-party service to sending from a specific address</a>
&#x2523&#x2501&#x2501 <a href="#example-4">Example #4: Keep track of what the IP addresses within your SPF record are for</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>

    <h2 id="what-are-spf-macros">What are SPF macros?</h2>
    <p>SPF macros are a feature of the SPF specification which allow for the creation of dynamic SPF policies. They allow for variables to be included within a policy, which are then evaluated by the receiving MTA and 'filled in' using data from the email being processed, such as the sender address or source IP address.</p>
    <p>This enables various advanced SPF processing routines such as conditional lookups, and allows for additional email metadata to influence the decision.</p>
    <p>SPF macros are present in the original SPF specification (<a href="https://tools.ietf.org/html/rfc4408#section-8" target="_blank" rel="noopener">RFC4408</a>), as well as the revised specification (<a href="https://tools.ietf.org/html/rfc7208#section-7" target="_blank" rel="noopener">RFC7208</a>), and are widely supported by MTAs.</p>

    <h2 id="macro-syntax">Macro Syntax</h2>
    <p>SPF macros are represented by different single characters, surrounded by curly braces (<code>{ }</code>) and prepended by a percent (<code>%</code>) sign, e.g. <code>%{i}</code>. There are currently 8 'core' macros that are supported, as defined in <a href="https://tools.ietf.org/html/rfc7208#section-7.2" target="_blank" rel="noopener">section 7.2 of the RFC.</a>. These will be evaluated and expanded by receiving MTAs in a way very similar to templating engines such as <a href="https://en.wikipedia.org/wiki/Jinja_(template_engine)" target="_blank" rel="noopener">Jinja</a>.</p>
    <ul class="large-spaced-list">
        <li><code>%{s}</code>: The sender of the received email, e.g. <code>joe@example.com</code></li>
        <li><code>%{l}</code>: The local part of the sender, e.g. <code>joe</code></li>
        <li><code>%{o}</code>: The domain of the sender, e.g. <code>example.com</code></li>
        <li><code>%{d}</code>: WIP</li>
        <li><code>%{i}</code>: The source IP address of the message, e.g. <code>203.0.113.1</code></li>
        <li><code>%{p}</code>: The validated reverse-DNS domain of the source IP, e.g. if <code>example.com IN A</code> is <code>203.0.113.1</code> and <code>1.113.0.203.in-addr.arpa IN PTR</code> is <code>example.com</code>, the validated domain will be <code>example.com</code>
        <li><code>%{v}</code>: The static string <code>in-addr</code> or <code>ip6</code> depending on the protocol version of the source IP --- used to construct macros utilising reverse DNS/PTR record syntax as seen in the <code>.arpa</code> zone</li>
        <li><code>%{h}</code>: The domain used in the most recent SMTP <code>HELO</code> or <code>EHLO</code> command, e.g. <code>mail.example.com</code>
    </ul>
    <p>Multiple macros can be used within an SPF record. You can also use modifiers such as <code>r</code> in order to reverse the order of the elements within an expanded macro variable, for example to convert a normal IP address such as <code>203.0.113.1</code> into a reverse lookup zone (<code>1.113.0.203</code> in this case).</p>

    <h2 id="example-1">Example #1: Permit individual IP addresses by adding a single DNS record for each</h2>
    <p>If your SPF record is getting too long, you may be tempted to begin using multiple <code>include:</code> statements, which can easily get messy, and doesn't actually solve the problem - it just delays it.</p>
    <p>Instead of having to specify each individual IP address, you can use an SPF macro within your global policy, and then add a separate DNS record for each IP address that you want to add to your policy.</p>
    <p>This keeps your policy short, whilst allowing an essentially unlimited number of IP addresses to be whitelisted.</p>
    <p>For example, you could use the following as your global policy:</p>
    <pre>example.com IN TXT "v=spf1 exists:{i}._spf.example.com -all"</pre>
    <p>Receiving MTAs will evaluate this and replace <code>%{i}</code> with the source IP address of the email.</p>
    <p>Then, to permit <code>203.0.113.1</code> and </code>203.0.113.2</code> to send as your domain, add the following DNS records:</p>
    <pre>203.0.113.1._spf.example.com IN A 127.0.0.2
203.0.113.2._spf.example.com IN A 127.0.0.2</pre>
    <p>The <code>exists:</code> mechanism within the global policy is used to permit the sender if a DNS <code>A</code> record exists at the queried address. You can use any value for the <code>A</code> record - all that matters is that is contains <i>some</i> value, although it is recommended to use an address that is not publicly routable, such as <code>127.0.0.2</code>.</p>
    <p>The <code>_spf</code> subdomain is known as a semantic scope, as defined in <a href="https://tools.ietf.org/html/rfc8552#section-4.1.2" target="_blank" rel="noopener">section 4.1.2 of RFC8552</a>.</p>
    <p>To permit an IPv6 address, use the <b>full</b> address in dot format rather than using colons:</p>
    <pre>2.0.0.1.0.d.b.8.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.1._spf.example.com IN A 127.0.0.2</pre>
    <p>Note that when using IPv6 addresses, a DNS <code>A</code> lookup is still performed, not an <code>AAAA</code>.</p>

    <h2 id="example-2">Example #2: Permit ranges of IP addresses using wildcard DNS records</h2>
    <p>Similar to the first example, SPF macros can also be used to permit IP address ranges without having to specify every single one within your global policy.</p>
    <p>This is achieved using wildcard DNS records combined with the SPF macro <code>r</code> modifier in order to reverse the parts of the IP address to create a reverse lookup. Unfortunately, with IPv4 addresses, this is limited to <code>/24</code>, </code>/16</code> and <code>/8</code> ranges.</p>
    <p>For example:</p>
    <pre>example.com IN TXT "v=spf1 exists:{ir}.{v}_spf.example.com -all"</pre>
    <p>The <code>%{ir}</code> macro will be replaced with the source IP address of the email, but with the parts reversed (due to the <code>r</code> modifier). For example, <code>203.0.113.1</code> will become <code>1.113.0.203</code>.</p>
    <p>The <code>%{v}</code> macro will be replaced with <code>in-addr</code> if the source address is IPv4, and <code>ip6</code> if the source address is IPv6. This isn't technically required, but it creates a semantically-correct reverse lookup using the <code>.arpa</code> top-level domain.</p>
    <p>To permit <code>203.0.113.0/24</code> to send as your domain, add the following wildcard record:</p>
    <pre>*.113.0.203.in-addr.arpa._spf.example.com IN A 127.0.0.2</pre>

    <h2 id="example-3">Example #3: Restrict a third-party service to sending from a specific address</h2>
    <p>In many cases, your SPF record will be mainly populated by third-party SaaS systems that each serve a very specific purpose. For example, a customer service system which exclusively sends messages as <code>support@example.com</code>, or a finance system which uses <code>billing@example.com</code>.</p>
    <p>Usually, the SPF configuration required for these third-party services means that you are granting them the ability to send as absolutely any address on your domain. This isn't good for security, as in the event that the third-party is compromised, makes a configuration error, or simply turns malicious, the reputation of your entire domain could be at stake.</p>
    <p>It is also quite inefficient to globally whitelist a third-party provider when it only needs to send-as one single address.</p>
    <p>Using SPF macros, it is possible to restrict third-party services who send on your behalf to a single or small number of addresses. This is great hardening and defence-in-depth, and also helps to keep a tight grip on the list of people authorised to send on your behalf.</p>
    <p>The following example will allow a third-party service to send-as your domain, but <b>only</b> using <code>noreply@example.com</code>. Other SMTP <code>FROM</code> addresses will be treated as an SPF fail:</p>
    <pre>example.com IN TXT "v=spf1 include:{l}._spf.example.com -all"</pre>
    <p>The <code>%{l}</code> macro will be replaced with the local part of the sender address. For example, if the sender is <code>steve@example.com</code>, the 'local' part is <code>steve</code>.</p>
    <p>Then add the third-party SPF records (as generated by the provider, e.g. Mailgun, Sendgrid, etc) to your zone under the <code>noreply</code> name:</p>
    <pre>noreply._spf.example.com IN TXT "v=spf1 include:spf.example.org"</pre>
    <p>When the third-party sends an email using the <code>noreply</code> address, the email will be permitted. However, if the third-party attempts to send using a different address, it will not match the SPF policy and will be treated as an SPF fail (as defined by the <code>-all</code> or <code>~all</code> within your global policy).</p>

    <h2 id="example-4">Example #4: Keep track of what the IP addresses within your SPF record are for</h2>
    <p>Within large organisations, there may be multiple people maintaining an SPF record, and potentially lots of different third-party systems sending email. This can sometimes make it challenging to maintain an accurate record of what each whitelisted IP address is for.</p>
    <p>By utilising SPF macros to split each permitted IP address into a separate DNS record, you then have the ability to add a DNS <code>TXT</code> record 'next to' the <code>A</code> record to note what it's for. This helps to keep a live audit log of what each IP address is for, who put it there, and when it can be removed.</p>
    <p>For example:</p>
    <pre>203.0.113.1._spf.example.com IN A 127.0.0.2
203.0.113.1._spf.example.com IN TXT "Customer service email system, see internal change notice #6511"</pre>
    <p>Keep in mind that the content of these <code>TXT</code> records is public, and may allow for the enumeration of systems, etc. However, the reality is that the existence and purpose of these systems is probably already fairly easy to identify, so in most cases I wouldn't consider this to be a significant risk.</p>
    <p>If you're still using legacy BIND zone files, you could also add the note using a comment (line starting with a semicolon).</p>

    <h2 id="conclusion">Conclusion</h2>
    <p>Unfortunately the real-world usage of SPF macros is fairly low, despite them being widely supported by MTAs. They unlock various advanced features, both from a usability and security point of view, so I really hope to see their usage increase in the future.</p>
    <p>Whilst researching for this article, I came across <a href="https://www.m3aawg.org/documents/en/m3aawg-best-practices-for-managing-spf-records" target="_blank" rel="noopener">this useful guidance</a> from the M3AAWG (Messaging, Malware and Mobile Anti-Abuse Working Group), which while not specifically about SPF macros, still provides a wealth of best-practise and recommendations for managing an SPF policy.</p>
</div>

<?php include "footer.php" ?>
