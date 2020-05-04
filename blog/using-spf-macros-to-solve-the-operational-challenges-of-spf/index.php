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
&#x2523&#x2501&#x2501 <a href="#supported-macros">Supported Macros</a>
&#x2523&#x2501&#x2501 <a href="#"></a>
&#x2523&#x2501&#x2501 <a href="#"></a>
&#x2523&#x2501&#x2501 <a href="#"></a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>

    <h2 id="what-are-spf-macros">What are SPF macros?</h2>
    <p>SPF macros are a feature of the SPF specification which allow for the creation of dynamic SPF policies. They allow for variables to be included within a policy, which are then evaluated by the receiving MTA and 'filled in' using data from the email being processed, such as the sender address or source IP address.</p>
    <p>This enables various advanced SPF processing routines such as conditional lookups, and allows for additional email metadata to influence the decision.</p>
    <p>SPF macros are present in the original SPF specification (<a href="https://tools.ietf.org/html/rfc4408#section-8" target="_blank" rel="noopener">RFC4408</a>), as well as the revised specificaion (<a href="https://tools.ietf.org/html/rfc7208#section-7" target="_blank" rel="noopener">RFC7208</a>), and are widely supported by MTAs.</p>

    <h2 id="supported-macros">Supported Macros</h2>
    <p>SPF macros are represented by different single characters, surrounded by curly braces (<code>{ }</code>) and prepended by a percent (<code>%</code>) sign, e.g. <code>%{i}</code>. There are currently 8 'core' macros that are supported, as defined in <a href="https://tools.ietf.org/html/rfc7208#section-7.2" target="_blank" rel="noopener">section 7.2 of the RFC.</a>. These will be evaluated and expanded by receiving MTAs in a way very similar to templating engines such as <a href="https://en.wikipedia.org/wiki/Jinja_(template_engine)" target="_blank" rel="noopener">Jinja</a>.</p>

    <ul class="large-spaced-list">
        <li><code>s</code>: The sender of the received email, e.g. <code>joe@example.com</code></li>
        <li><code>l</code>: The local part of the sender, e.g. <code>joe</code></li>
        <li><code>o</code>: The domain of the sender, e.g. <code>example.com</code></li>
        <li><code>d</code>: WIP</li>
        <li><code>i</code>: The source IP address of the message, e.g. <code>203.0.113.1</code></li>
        <li><code>p</code>: The validated reverse-DNS domain of the source IP, e.g. if <code>example.com IN A</code> is <code>203.0.113.1</code> and <code>1.113.0.203.in-addr.arpa IN PTR</code> is <code>example.com</code>, the validated domain will be <code>example.com</code>
        <li><code>v</code>: The static string <code>in-addr</code> or <code>ip6</code> depending on the protocol version of the source IP --- used to construct macros utilising reverse DNS/PTR record syntax as seen in the <code>.arpa</code> zone</li>
        <li><code>h</code>: The domain used in the most recent SMTP <code>HELO</code> or <code>EHLO</code> command, e.g. <code>mail.example.com</code>
    </ul>

EXAMPLES:

permit individual IP addresses by simply adding a single DNS record to your zone:

if spf record is getting too long, instead of using messy nested includes, use below:

example.com IN TXT "v=spf1 exists:{i}._spf.example.com -all"

note that the _spf DNS semantic scope is used as defined in section 4.1.2 of https://tools.ietf.org/html/rfc8552#section-4.1.2

then to allow 203.0.113.1 and 203.0.113.2 to send as your domain, simply add:

203.0.113.1._spf.example.com IN A 127.0.0.2
203.0.113.2._spf.example.com IN A 127.0.0.2

to allow an ipv6 address, use the address in dot format rather than using colons:

2.0.0.1.0.d.b.8.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.1._spf.example.com IN A 127.0.0.2
(32 total chars, 20010db8---1)

note that when using ipv6 addresses, an A lookup is still performed, not an AAAA

you can use ANY DNS A RR record value, but a non-publicly-routable one is preferable

permit ranges of IP addresses using wildcard DNS records:

example.com IN TXT "v=spf1 exists:{ir}.{v}_spf.example.com -all"

then to allow 203.0.113.0/24 to send as your domain:

*.113.0.203.in-addr._spf.example.com IN A 127.0.0.2

note that this is limited to /24, /16 and /8

allow a supported third-party mail provider to dynamically update their mail infrastructure without every customer having to update their spf policy, without having messy nested includes - strictly limited to one additional lookup per supported provider:

example.com IN TXT "v=spf1 exists:{i}._spf.example.net -all"

example.net can now add/remove any ip addresses that they want to their own zone:

203.0.113.10._spf.example.net IN A 127.0.0.2
203.0.113.11._spf.example.net IN A 127.0.0.2

allow a third-party service to send-as a particular address, without having to consume space in your global spf policy
also useful for
restrict a third-party service to sending from a specific address

e.g. for customer service noreply system

it is quite inefficient, and also a potential security weakness, to globally whitelist a third-party provider when it only needs to send-as one single address

this will allow a third-party service to send-as your domain, but ONLY using noreply@example.com. Other FROM addresses will be treated as an SPF fail

example.com IN TXT "v=spf1 include:{l}._spf.example.com -all"

then add third-party spf records to zone (e.g. as generated by Mailgun, Sendgrid, etc):

noreply._spf.example.com IN TXT "v=spf1 include:spf.example.org"

keep track of what ip addresses within your spf record are for

within large organisations where there may be multiple people maintaining an SPF record, and potentially lots of different third-party systems sending email, it can be a challenge to maintain an accurate record of what each whitelisted IP is for

use a txt record next to the A record to note what it's for, so that in 5 years when something goes wrong with that system, you remember what it's for

or if using legacy BIND zonefiles, add a comment with a semicolon

203.0.113.1._spf.example.com IN A 127.0.0.2
203.0.113.1._spf.example.com IN TXT "Customer service system, see internal change notice #6511"

keep in mind info is public and may allow enumeration of systems, etc
    <p></p>
    <img class="radius-8" width="1000px" src="">
    <p class="two-no-mar centertext"><i></i></p>

    <div class="message-box message-box-positive/warning/warning-medium/notice">
        <div class="message-box-heading">
            <h3><u></u></h3>
        </div>
        <div class="message-box-body">
            <p></p>
        </div>
    </div>

    <h2 id="conclusion">Conclusion</h2>
    <p>useful guidance from M3AAWG (Messaging, Malware and Mobile Anti-Abuse Working Group) - https://www.m3aawg.org/documents/en/m3aawg-best-practices-for-managing-spf-records</p>
</div>

<?php include "footer.php" ?>
