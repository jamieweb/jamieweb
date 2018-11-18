<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Launching a Public HackerOne Security Vulnerability Disclosure Program</title>
    <meta name="description" content="A write-up of launching the public HackerOne security vulnerability disclosure program for JamieWeb. hackerone.com/jamieweb">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/blog/launching-a-public-hackerone-program/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Launching a Public HackerOne Security Vulnerability Disclosure Program</h1>
    <hr>
    <p><b>Friday 11th May 2018</b></p>
    <p>Last month, I launched a public HackerOne security vulnerability disclosure program for my website. I've been working on this for a while, and I'm now very happy to have launched the program publicly!</p>
    <p><b>Skip to Section:</b></p>
    <pre><b>Launching a Public HackerOne Security Vulnerability Disclosure Program</b>
&#x2523&#x2501&#x2501 <a href="#what-is-hackerone">What is HackerOne?</a>
&#x2523&#x2501&#x2501 <a href="#setting-up-the-program">Setting up the Program</a>
&#x2523&#x2501&#x2501 <a href="#controlled-launch-private-invite-only">Controlled Launch (Private/Invite-only Mode)</a>
&#x2523&#x2501&#x2501 <a href="#public-launch">Public Launch</a>
&#x2523&#x2501&#x2501 <a href="#reports-received">Security Reports Received</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>
    <p>If you're a hacker and you'd like to have a go, the program is accessible on HackerOne here: <b><a href="https://hackerone.com/jamieweb" target="_blank" rel="noopener">https://hackerone.com/jamieweb</a></b></p>
    <img class="radius-8" width="1000px" src="/blog/launching-a-public-hackerone-program/hackerone-jamieweb.png">
    <p class="two-no-mar centertext"><i>The front page of my HackerOne program at <a href="https://hackerone.com/jamieweb" target="_blank" rel="noopener">https://hackerone.com/jamieweb</a>.</i></p>
    <h2 id="what-is-hackerone">What is HackerOne?</h2>
    <div class="display-flex">
        <div class="width-545 float-left">
            <p class="no-mar-top"><a href="https://www.hackerone.com" target="_blank" rel="noopener">HackerOne</a> is a security vulnerability coordination and bug bounty platform, with the aim of connecting ethical hackers with businesses for hacker-powered security testing.</p>
            <p class="no-mar-bottom">The company was founded in 2012, and has since grown to have offices in San Francisco, New York City, London and Groningen (Netherlands).</p>
        </div>
        <div class="width-450 float-right display-flex flex-align-center flex-justify-center margin-left-auto">
           <img src="/blog/launching-a-public-hackerone-program/hackerone-full.png">
        </div>
    </div>
    <p class="clearboth">I am using the HackerOne 'Response' service to host my vulnerability disclosure program. This service allows you to set up a security page on HackerOne for your organisation/project, which contains your security policy, disclosure guidelines and a list of assets that are in-scope of the program. The page essentially tells hackers what they do/don't have permission to test.</p>
    <p>Security reports can be submitted to your program via your security page. These may come from users of your organisation's service/product who have come across a vulnerability, or from hackers on the HackerOne platform who have been proactively testing your systems. Once a report is submitted, the program's team members are alerted, and the report is handled within the HackerOne platform in a similar way to a customer service ticket.</p>

    <h2 id="setting-up-the-program">Setting up the Program</h2>
    <p>The first stage of launching a HackerOne program is to define your vulnerability disclosure policy and scope. This outlines the guidelines for hackers to follow when participating in your program, as well as the assets that are in-scope of the program.</p>
    <p>Your security policy should be short and concise, and usually includes details on things for hackers to look for, guidelines for security reports and activities that are not permitted as part of your program.</p>
    <img class="radius-8" width="1000px" src="/blog/launching-a-public-hackerone-program/policy.png">
    <p>In my policy, I decided to allow hackers to test most things, however there are exclusions for things that I do not have full control over or could cause major damage, such as DoS (denial of service), phishing, etc.</p>
    <p>You also need to define a scope, which outlines which of your assets are considered part of the program and eligible for bug submissions, and which assets are excluded from bug submissions.</p>
    <p>You can add assets of different types, including domain names, IP addresses, mobile apps and even direct links to source code. The maximum impact to confidentiality, integrity and availability can be specified, as well as additional notes to guide hackers.</p>
    <img class="radius-8" width="1000px" src="/blog/launching-a-public-hackerone-program/add-asset.png">
    <p>In my case, I added my main (sub)domain names, IP addresses, Tor Hidden Services and some of my source code hosted on GitHub:</p>
    <table class="width-1000 padding-6 border-1-4c4c4c border-collapse">
        <tr class="bg-lightgreen">
            <th class="h1-scope-type">Type</th>
            <th class="h1-scope-identifier">Identifier</th>
            <th class="h1-scope-max-severity">Max. Severity</th>
            <th class="h1-scope-in-scope">In Scope</th>
        </tr>
        <tr>
            <td>Domain</td>
            <td>www.jamieweb.net</td>
            <td>Critical</td>
            <td>Yes</td>
        </tr>
        <tr>
            <td>Domain</td>
            <td>jamieweb.net</td>
            <td>Critical</td>
            <td>Yes</td>
        </tr>
        <tr>
            <td>Domain</td>
            <td>ipv6.jamieweb.net</td>
            <td>Critical</td>
            <td>Yes</td>
        </tr>
        <tr>
            <td>Domain</td>
            <td>ipv4.jamieweb.net</td>
            <td>Critical</td>
            <td>Yes</td>
        </tr>
        <tr>
            <td>Domain</td>
            <td>jamiewebgbelqfno.onion</td>
            <td>Critical</td>
            <td>Yes</td>
        </tr>
        <tr>
            <td>Domain</td>
            <td>jamie3vkiwibfiwucd6vxijskbhpjdyajmzeor4mc4i7yopvpo4p7cyd.onion</td>
            <td>Critical</td>
            <td>Yes</td>
        </tr>
        <tr>
            <td>Source Code</td>
            <td>https://github.com/jamieweb/results-whitelist</td>
            <td>Critical</td>
            <td>Yes</td>
        </tr>
        <tr>
            <td>CIDR</td>
            <td>139.162.222.67</td>
            <td>Critical</td>
            <td>Yes</td>
        </tr>
        <tr>
            <td>CIDR</td>
            <td>2a01:7e00:e001:c500::1</td>
            <td>Critical</td>
            <td>Yes</td>
        </tr>
    </table>
    <p>My program's security policy and scope are also available on GitHub: <a href="https://github.com/jamieweb/config/blob/master/hackerone/policy.md" target="_blank" rel="noopener">Policy</a> | <a href="https://github.com/jamieweb/config/blob/master/hackerone/scope.md" target="_blank" rel="noopener">Scope</a></p>
    <p>HackerOne programs are bound by a response SLA (service level agreement), which you can customize yourself. This feature is more useful if you are operating your program as a team, in order to ensure that your members are responding to reports within an appropriate time frame. I'm operating my program myself though, and there is nobody else involved, so I've left these as the default.</p>
    <div class="centertext"><img class="radius-8" width="1000px" src="/blog/launching-a-public-hackerone-program/response-sla.png"></div>

    <h2 id="controlled-launch-private-invite-only">Controlled Launch (Private/Invite-only Mode)</h2>
    <p>Once you have finalised your policy and scope, you must submit your program for approval. HackerOne will ensure that your policy includes all of the information it requires, and that the assets in scope are suitable for the program.</p>
    <p>One thing to check before submitting is that your HackerOne account has a verified email address on the domain of the website for your program (in my case, an @jamieweb.net email address). This is to help prove that you are authorized to launch a HackerOne program for your organisation.</p>
    <p>Once your HackerOne program has been approved, it will enter 'Controlled Launch'. This means that your program is not yet accessible to the general public and is hidden from the HackerOne website. However, some hackers from the HackerOne platform are automatically invited to the program in order to test it out.</p>
    <img class="radius-8" width="1000px" src="/blog/launching-a-public-hackerone-program/controlled-launch1.png">
    <p>When my program first entered controlled launch, around 30 invites were sent out per day, which eventually built up to around 1,100 invites sent. Towards the end of the controlled launch phase, I requested for my daily invites to be increased, which took me up to 1,670 invites sent before the program launched publicly. Out of these 1,670 invites, 358 hackers accepted, which is a 21.4% acceptance rate.</p>
    <img class="radius-8" width="1000px" src="/blog/launching-a-public-hackerone-program/controlled-launch2.png">
    <p>When a program is under controlled launch, its growth is managed by the 'Desired Reports Per Month' value. This value is to help prevent the program from been inundated with reports, and to ensure that the program can sustain good response times.</p>
    <p>An additional important step of running a vulnerability disclosure program is to inform any third-parties that may be inadvertently affected by it. It is a good idea to inform your hosting provider, DNS provider and any other third-parties that may be responsible for hosting any of your services. This is to ensure that they are OK with this sort of activity, and also so that they understand what is going on if your account suddenly has a spike in suspicious incoming traffic, etc.</p>
    <p>If a third-party provider does not like the idea of you running a vulnerability disclosure program, I think that you should be looking elsewhere, as this potentially demonstrates that they do not proactively follow modern security best-practises.</p>

    <h2 id="public-launch">Public Launch</h2>
    <p>On 14th April 2018, I received approval from HackerOne for my program to be launched publicly.</p>
    <img class="radius-8" width="1000px" src="/blog/launching-a-public-hackerone-program/public-launch.png">
    <p>The public launch means that my <a href="https://hackerone.com/jamieweb" target="_blank" rel="noopener">program page</a> is now publicly accessible, and hackers do not have to be invited in order to submit bugs. My program is now also listed on the <a href="https://hackerone.com/directory" target="_blank" rel="noopener">HackerOne directory</a>, which makes it easy for hackers to find organisations to work with:</p>
    <img class="radius-8" width="1000px" src="/blog/launching-a-public-hackerone-program/directory.png">
    <p>The pink circle with a lightning strike next to some of the program icons indicates that the program's time to first response is less than 48 hours, and the purple circle means that the program awards bounties within 14 days.</p>
    <p>The weekend of the public launch was particularly busy. My server was hit with many more vulnerability scans, exploit attempts and general traffic than normal which was great to see, and several minor bugs were discovered.</p>

    <h2 id="reports-received">Reports Received</h2>
    <p>As of writing this, I have received 14 unique reports to my program. Out of these, 8 were valid and are now resolved, and 6 were 'Informative'.</p>
    <p>The 6 'Informative' reports were most likely automated scan results providing false positives, or less-experienced hackers that didn't understand that something was intended rather than a vulnerability. I don't believe that any of these were 'spam' attempts.</p>
    <p>Below are some details on a few of the reports that I have received so far:</p>

    <h3 id="tls1.0-tls1.1">TLS 1.0 and TLS 1.1 Enabled</h3>
    <p>The first valid report that I received was from <a href="https://hackerone.com/retr0" target="_blank" rel="noopener">retr0</a>, who raised the issue of having TLS 1.0 and TLS 1.1 enabled on my site.</p>
    <p>While there isn't currently a direct risk of using these as long as you are using the latest server and client side implementations, they are older protocols and it is good hygiene to disable them.</p>
    <p>Before doing this, I assessed the potential compatibility impact by logging the TLS protocol versions in use using an Apache CustomLog:</p>
    <pre>CustomLog ${APACHE_LOG_DIR}/tls.log "%t %h %{SSL_PROTOCOL}x %{SSL_CIPHER}x"</pre>
    <p>I actually wrote an entire blog post about this at the time, please see it <a href="/blog/disabling-tls1.0-tls1.1/" target="_blank">here</a>.</p>
    <p>Again I'd like to send a big thanks to <a href="https://hackerone.com/retr0" target="_blank" rel="noopener">retr0</a> for their useful researching and great communication!</p>

    <h3 id="cfduid">__cfduid Cookie Not Marked As Secure</h3>
    <p>The second valid report that I received was also from <a href="https://hackerone.com/retr0" target="_blank" rel="noopener">retr0</a>, who identified that the Cloudflare <code>__cfduid</code> cookie did not have the 'Secure' flag.</p>
    <p>At the time, I was testing out the Cloudflare reverse-proxy and caching service, which involves the Cloudflare edge nodes making various modifications to your HTTP traffic, including setting the <code>__cfduid</code> cookie. This cookie is used in order to remember when a user has passed a Cloudflare security challenge - so that they are not immediately challenged again on their next request.</p>
    <p>I had set the Cloudflare security options to 'Essentially Off', as they didn't offer a significant benefit to a site like mine, with purely lightweight and static content, and where the origin server IP addresses are not intended to be hidden. However, Cloudflare still unfortunately sets the <code>__cfduid</code> cookie and it doesn't seem to be possible to disable it unless you have an enterprise plan. Even though this is kind of harmless in the real world, I really dislike the idea of having a cookie set upon visiting my website in the first place, nevermind one without the 'Secure' flag - to a user who is not aware of what the <code>__cfduid</code> cookie is for, it may just look like a tracking cookie (which I would never use on my site). Cloudflare state that the cookie does not contain any confidential information so its lack of the 'Secure' flag is not significant. While this is true, it just doesn't feel right to me.</p>
    <p>I resolved this report by deciding not to continue using the Cloudflare reverse-proxy and caching service. Just to be clear, the Cloudflare reverse-proxy service is absolutely fantastic and I highly recommend it for most websites. It's just my particular type of site where security is the #1 priority and I want fine-grain control over absolutely everything where Cloudflare can get in the way slightly.</p>
    <p>Thanks again to <a href="https://hackerone.com/retr0" target="_blank" rel="noopener">retr0</a> for raising this!</p>

    <h3 id="404-injection">404 Error Page Content Injection</h3>
    <p>This vulnerability was particularly interesting... <a href="https://hackerone.com/abdelkader" target="_blank" rel="noopener">abdelkader</a> reported to me that the 404 pages on some areas of my site were vulnerable to a form of content injection:</p>
    <img class="radius-8" width="1000px" src="/blog/launching-a-public-hackerone-program/404-content-injection.png">
    <p>As you can see in the screenshot above, this is just the standard Apache HTTP 404 'Not Found' error page, and as usual it is echoing back the requested URI that cannot be found.</p>
    <p>I had actually set some custom ErrorDocuments in my global Apache configuration file in order to help prevent this 'echo' from happening:</p>
    <pre>ErrorDocument 400 /400.php
ErrorDocument 401 /401.php
ErrorDocument 403 /403.php
ErrorDocument 404 /404.php
ErrorDocument 500 /500.php</pre>
    <p>However, due to how my catch-all virtual hosts are set up, these ErrorDocuments were not used in some situations. The catch-all virtual hosts are designed to prevent people accessing my website via the IP addresses directly, or by pointing another domain name at my server. If the <code>Host</code> header or SNI (Server Name Indication) doesn't match any of my virtual hosts, it will fall back to one of the 'catch-all' virtual hosts which shows a 403 Forbidden page with a link to my main site. You can see an example of catch-all by connecting to my: <a href="http://139.162.222.67/" target="_blank" rel="noopener">IPv4 address</a> or <a href="http://[2a01:7e00:e001:c500::1]/" target="_blank" rel="noopener">IPv6 address</a> directly.</p>
    <p>Before receiving this report, I had my catch-all virtual hosts configured as follows:</p>
    <pre>&lt;Location /&gt;
    Deny from all
    ErrorDocument 403 "403 Forbidden - Direct request to IPv4 address (139.162.222.67) blocked. Please use &lt;a href=\"https://www.jamieweb.net\" rel=\"noopener\"&gt;https://www.jamieweb.net&lt;/a&gt; instead."
&lt;/Location&gt;
</pre>
    <p>There are two problems with this configuration:</p>
    <ul>
        <li><p><b>Firstly, the </b><code>Location</code><b> directive only performs URL-matching:</b> This means that simply accessing a URL outside of the specified value means that the directive will not be applied. Even though the location value in my configuration is set to "/", you can still achieve this by using URL-encoded characters, such as <code>%2f</code>, which is a forward slash.</p>
    <p>For example: <code>GET /..%2f</code> is equivalent to <code>GET /../</code>, or "GET the directory above". This may look like a directory traversal vulnerability, but in this case it's not - the web server will not serve content outside of the directory that it is supposed to. What's actually happening is the URL no longer falls under the scope of the <code>&lt;Location /&gt;</code> directive, so the request is never denied and the 403 Forbidden error page is never displayed. Instead, it simply returns with a 404 Not Found error.</p>
    <p>Perhaps the most ideal solution to this would be to switch to using the <code>Directory</code> directive instead, as this matches based on file-system directories rather than URLs. These cannot be easily controlled by user input like URLs can. However, I am unable to use these with my current configuration. This is because where the main <code>Directory</code> directives are initially defined in my global Apache configuration, I have set the directive <code>AllowOverride None</code> in order to prevent further changes to the directory configuration in other configuration files or in .htaccess files. I do not want to relax the override configuration at all as this puts me at risk of .htaccess exploits.</p>
    <p>For example, if my GitHub account were to be compromised and I unfortunately issued a <code>git pull</code> from the web server without properly checking the changes and commit signing, it would be possible for malicious .htaccess files to be added to my website without the attacker ever accessing the server. Then, the attacker would have full control over the Apache configuration. One possible mitigation for this would be to set the <code>AccessFileName</code> directive to something arbitrary, kind of like a password, however this is simply security through obscurity rather than a robust solution, so it should not be relied on.</p>
    <p>It would be possible to define the <code>Directory</code> directive on a per-virtual host basis in order to have fine-grain control over the override configuration, however this is a suboptimal configuration since the security of it relies on a request actually hitting a virtual host. While this should always happen on a well-configured server, there is a potential for accidental misconfigurations to have a large impact.</p></li>
    <li><p><b>Secondly, the globally defined ErrorDocuments are not actually accessible:</b> This is because they are located in the "/" web server directory, which is restricted by the <code>Deny from all</code>, and also because they could not be located relative to the <code>/../</code> directory.</p></li></ul>
    <p>The solution that I decided on was to continue using the <code>Location</code> directive, but to specify ErrorDocuments specifically for the catch-all virtual hosts:</p>
    <pre>ErrorDocument 400 "400 Bad Request"
ErrorDocument 401 "401 Unauthorized"
ErrorDocument 403 "403 Forbidden"
ErrorDocument 404 "404 Not Found"
ErrorDocument 500 "500 Internal Server Error"</pre>
    <p>Since these are defined directly within the virtual host configuration, there will be no access issues or edge-cases where they cannot be served.
    <p>The impact of 404 page content injection is that an attacker could potentially use this in order to construct a phishing 'page' that would be served by my web server. Designing a phishing page like this would be quite difficult, since it would only be possible to use one continuous line of plain text. However, with some careful text padding, line breaks and perhaps ASCII art, it could be possible to create a somewhat usable phishing page. I plan to investigate this further and see what the limits of this vulnerability are.</p>
    <p>One important thing to note here is that the majority of websites on the internet are 'vulnerable' to this. This is the default configuration for the Apache web server, and unfortunately a large proportion of websites running on Apache are using the default configuration.</p>
    <p>Thanks again to <a href="https://hackerone.com/abdelkader" target="_blank" rel="noopener">abdelkader</a> for reporting this vulnerability - it was a particularly interesting one!</p>

    <h2 id="conclusion">Conclusion</h2>
    <p>Overall I am absolutely delighted with my HackerOne program. It's great to interact with the hackers and see the different techniques that they each use in order to identify problems, as well as the creativity of some of the vulnerabilities that they find.</p>
    <p>I think that working directly with hackers is a crucial part of maintaining robust security. Now that I've run my HackerOne program for a few weeks, it has definitely re-enforced the fact that it's not feasible to create and maintain a hardened application without involving hackers - and I don't just mean planned, formal penetration-tests, I mean letting hackers from all over the world conduct continuous testing on your production environment.</p>
    <p>I have also updated my <a href="https://www.jamieweb.net/.well-known/security.txt" target="_blank">security.txt</a> file to include details of my HackerOne program:</p>
    <pre>Contact: https://hackerone.com/jamieweb
Contact: https://www.jamieweb.net/contact/
Policy: https://hackerone.com/jamieweb
Acknowledgement: https://hackerone.com/jamieweb
Signature: https://www.jamieweb.net/.well-known/security.txt.sig

# This file is available identically at these locations:
# https://www.jamieweb.net/.well-known/security.txt
# https://www.jamieweb.net/security.txt</pre>
    <p>Finally, I would like to send a big thanks to Shay, Chris and George as well as the rest of the team at HackerOne for their amazing support throughout this process!</p>
</div>

<?php include "footer.php" ?>

</body>

</html>
