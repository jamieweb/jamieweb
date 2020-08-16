<?php include "response-headers.php"; content_security_policy();
include_once "bloglist.php"; bloglist("postTop", null, null, 2020); ?>

<div class="body">
    <h1><?php echo $postInfo->title . "</h1>\n" . (isset($postInfo->subtitle) ? "    <h2 class=\"subtitle-mar-top\">" . $postInfo->subtitle . "</h2>\n" : ""); ?>
    <hr>
    <p><b><?php echo $postInfo->date; ?></b></p>
    <!--INTRO START-->
    <p>Tor is a fantastic networking and privacy technology that makes private and anonymous browsing available to millions. Despite this, it is unfortunately seen by some people as a system that solely exists to facilitate an illegal criminal underground, </p>
    <p>However, to take a literal view, <i>Tor is just a networking tool</i>, and it can be used in any way that you want. The features that enable privacy and anonymity are also extremely useful for many of the tasks carried out by Network Engineers and Systems Administrators on a daily basis. For example:</p>
    <ul class="spaced-list">
        <li><a href="/blog/tor-is-a-great-sysadmin-tool/#testing-ip-address-based-access-rules">Testing IP address based access rules</a></li>
        <li><a href="/blog/tor-is-a-great-sysadmin-tool/#testing-internally-hosted-services-from-an-external-perspective">Testing internally-hosted services from an external perspective</a></li>
        <li><a href="/blog/tor-is-a-great-sysadmin-tool/#making-reliable-external-dns-lookups-when-operating-in-a-split-horizon-dns-environment">Making reliable external DNS lookups when operating in a split-horizon DNS environment</a></li>
        <li><a href="/blog/tor-is-a-great-sysadmin-tool/#bypassing-blocked-outbound-ports">Bypassing blocked outbound ports</a></li>
        <li><a href="/blog/tor-is-a-great-sysadmin-tool/#exposing-services-when-behind-nat-or-cgnat">Exposing services when behind NAT or CGNAT</a></li>
    </ul>
    <p>In this article, I will demonstrate how Tor can be used to carry out some of these tasks, and why using Tor may be advantageous to other methods.</p>
    <!--INTRO END-->

    <div class="message-box message-box-warning-medium">
        <div class="message-box-heading">
            <h3><u>Warning:</u></h3>
        </div>
        <div class="message-box-body">
            <p>The techniques described within this article should only be used in environments where you are permitted to do so.</p><br>
            <p>Please ensure that you comply with all local policies regarding the usage of Tor, including from your employer, customer/client, or other relevant entities.</p>
        </div>
    </div>

    <h2 id="testing-ip-address-based-access-rules">Testing IP Address Based Access Rules</h2>
    <p>In some network environments, IP address based access rules are used to either restrict or allow access to a service, or are used as a decision factor in a conditional access policy. For example, a common use-case is removing the requirement for two-factor authentication upon login if you are connecting from a trusted IP address, or requiring additional verification steps when connecting for the first time from a new location.</p>
    <p>However, it is usually quite difficult to fully test such policies without access to multiple unique devices and/or VPNs.</p>
    <p>Using Tor and the Tor Browser, you can test your access rules from multiple arbitrary external IP addresses. You can also very easily reset your browser profile or establish a new Tor circuit at any time, allowing you to very easily create a new 'identity' for testing, without the risk of previous tests impacting the results.</p>
    <p>If you want to test something that isn't a web-based service, you can use the <code>torsocks</code> wrapper to force the network connections of any program to be routed over Tor. For example, to test an IP address based SSH access rule, you could route an SSH connection over Tor to make it originate from a new/unknown IP address:</p>
    <pre>$ torsocks ssh <span class="color-red">jamieweb.net</span></pre>
    <p>Unfortunately <code>torsocks</code> cannot be used with setuid programs such as <code>ping</code>, nor can it be used with programs that exclusively use UDP.</p>

    <h2 id="testing-internally-hosted-services-from-an-external-perspective">Testing Internally-Hosted Services From an External Perspective</h2>
    <p>If you are hosting certain network services internally/on-site, e.g. web servers or mail servers, it can often be a challenge to properly test these from an external/public-facing perspective.</p>
    <p>It's very important that this testing is carried out, as network services will often have differing configurations or policies depending on where you are connecting from. The lack of an easy way to perform this testing internally often leads to crude solutions involving personal devices or mobile data tethering, which are neither convenient or reliable.</p>
    <p>However, similarly to how IP address based access rules can be tested with Tor, you can also use Tor to access your internally-hosted services from an external perspective. This will allow you to carry out all required testing from your standard device.</p>
    <p>For example, you can use <code>torsocks</code> with cURL:</p>
    <pre>$ torsocks curl <span class="color-red">https://www.jamieweb.net</span></pre>
    <p>Alternatively, if you don't want to use the <code>torsocks</code> wrapper, you can point cURL to the local SOCKS5 proxy directly, which runs on <code>127.0.0.1:9050</code>:</p>
    <pre>$ curl --socks5-hostname 127.0.0.1:9050 <span class="color-red">https://www.jamieweb.net</span></pre>

    <h2 id="making-reliable-external-dns-lookups-when-operating-in-a-split-horizon-dns-environment">Making Reliable External DNS Lookups When Operating in a Split-Horizon DNS Environment</h2>
    <p>Most corporate networks operate a 'split-horizon' or 'split-brain' DNS setup, which is where a separate internally-hosted DNS server and associated zone is used to serve DNS requests that originate internally. The internal DNS server will often respond with 'internal' addresses, i.e. private or RFC1918 addresses, rather than 'external' public-facing addresses.</p>
    <p>This is usually used in combination with a configured search domain or DNS scope, in order to allow internal services to be accessed via their direct hostname, without requiring the fully-qualified domain name (FQDN).</p>
    <p>However, these split-horizon DNS setups can often pose a problem when you explicitly need a request to go to an external DNS server. Some networks will forcefully route <i>all</i> DNS traffic to the internal DNS server, and others will even intercept and rewrite DNS responses at the network edge, e.g. using the DNS doctoring or DNS NAT rewriting features that are present in many commercial edge firewall products.</p>
    <p>You can usually get around these issues by forcing your external DNS lookups to take place over TCP, i.e. using the <code>+tcp</code> option in DiG (also known as 'virtual circuit' mode), but this isn't always supported or available.</p>
    <p>By routing your external DNS lookup over Tor, you can know for certain that the response hasn't been tampered with during the 'last mile' as it passes through your network edge:</p>
    <pre>$ torsocks dig +tcp @1.1.1.1 <span class="color-red">jamieweb.net</span></pre>
    <p>You'll need to use <code>+tcp</code> mode, as well as ensure that the request will be routed directly to the external DNS server, and not through a local caching resolver such as <code>dnsmasq</code>. This is because the Tor daemon will block requests to access local addresses such as <code>127.0.0.1</code>. If you do accidentally attempt to access a local address, Tor will display the following error:</p>
    <pre>WARNING torsocks[]: [connect] Connection to a local address are denied since it might be a TCP DNS query to a local DNS server. Rejecting it for safety reasons. (in tsocks_connect() at connect.c:192)</pre>

    <h2 id="bypassing-blocked-outbound-ports">Bypassing Blocked Outbound Ports</h2>
    <p>In many corporate network environments, permitted outbound ports are limited in order to help ensure that all outbound traffic is tightly controlled, e.g. for the purposes of Data Loss Prevention (DLP).</p>
    <p>However, for people in technical roles, this can pose quite a challenge, as various legitimate services will inadvertently be blocked too, and exceptions can be difficult to implement on a per-user basis.</p>
    <p>A common one that is often overlooked is the WHOIS protocol, which operates on TCP port 43.</p>
    <p>Using the <code>torsocks</code> wrapper, you can route these requests through Tor in order to get around the blocked outbound port:</p>
    <pre>$ torsocks whois jamieweb.net</pre>
    <p>In some cases, firewalls performing Deep Packet Inspection (DPI) can also prevent certain connections to otherwise allowed ports. For example, a sysadmin using <code>openssl s_client</code> to retrieve a certificate from a web server may have their request blocked, as they aren't establishing a full HTTPS connection.</p>
    <p>However, by routing the request through Tor, the connection can be made successfully:</p>
    <pre>$ torsocks openssl s_client -connect jamieweb.net:443</pre>

    <h2 id="exposing-services-when-behind-nat-or-cgnat">Exposing Services When Behind NAT or CGNAT</h2>
    <p>There may be cases where you need to expose a locally running service to the internet, e.g. SSH or a web server. Unfortunately, this is often non-trivial due to NAT, and especially CGNAT (carrier-grade NAT).</p>
    <p>One particular use case that I've worked on is accessing a 4G-connected device remotely using SSH. Because the majority of consumer data plans operate using CGNAT, you cannot just bind the service to your perceived public address and have it work, as there will potentially be hundreds of other customers sharing that same IP address. Multiple layers of NAT are often used too, which of course complicates things.</p>
    <p>However, you can use Tor to expose your service via a Hidden Service, also known as a <code>.onion</code> site. This way, your service will be easily accessible over Tor no matter how many layers of NAT or filtering you are behind.</p>
    <p>This can be achieved by adding a few lines to your <code>/etc/tor/torrc</code> configuration file:</p>
    <pre>HiddenServiceDir /var/lib/tor/<span class="color-red">my_service</span>
HiddenServicePort <span class="color-red">22 127.0.0.1:22</span></pre>
    <p>The <code>HiddenServiceDir</code> configuration specifies where your Hidden Service public/private keys will be stored. This should be an arbitrary directory in <code>/var/lib/tor/</code>. You should not create this yourself, as the Tor daemon will create it for you using the correct permissions.</p>
    <p>The <code>HiddenServicePort</code> option is used to specify where incoming requests to a specific port will be forwarded to. In this case, requests to the Hidden Service on port <code>22</code> will be forwarded verbatim to <code>127.0.0.1:22</code>.</p>
    <p>You can also optionally configure your Hidden Service in single-hop mode, which will allow it to connect to the Tor network using a single hop, rather than the usual three, potentially improving performance. <b>This will completely de-anonymise your Hidden Service, so <u>DO NOT</u> use single-hop mode if your own anonymity is important.</b> In most legitimate sysadmin use cases, single-hop mode is perfectly safe and acceptable.</p>
    <p>You can enable single-hop mode by adding the following to your Hidden Service configuration:</p>
    <pre>HiddenServiceNonAnonymousMode 1
HiddenServiceSingleHopMode 1</pre>
    <p>However, running in single-hop mode will prevent your Tor daemon being used as a client, as your connection to the Tor network is not anonymised. If a SOCKS port is configured in your <code>torrc</code> file, you'll also need to disable this:</p>
    <pre>SocksPort 0</pre>
    <p>Once you've finalised your Hidden Service configuration, save the <code>torrc</code> file and restart the Tor daemon:</p>
    <pre>sudo service tor restart</pre>
    <p>You can now view the <code>/var/lib/tor/my_service/hostname</code> file in order to identify the <code>.onion</code> address for your Hidden Service. This can be used from any other Tor-capable device anywhere in the world in order to directly access your locally-hosted service.</p>

    <div class="message-box message-box-warning">
        <div class="message-box-heading">
            <h3><u>Warning:</u></h3>
        </div>
        <div class="message-box-body">
            <p>Using Tor to expose local services on your machine can be dangerous if not done properly, and should be only done in safe environments where you are permitted to do so.</p><br>
            <p>Also note that requests to your local service via your Hidden Service will appear to originate from localhost, so make sure to consider this when it comes to things like access rules, virtual hosts, IP address bindings, etc.</p>
        </div>
    </div>

    <h2 id="conclusion">Conclusion</h2>
    <p>This article covered just a few of the uses for Tor that I've come across over the years, but there is definitely a lot of further potential. I'd really love to see Tor take off as a systems administration tool, as it allows for some really unique and quirky networking tasks to be carried out with ease.</p>
    <p>I'm definitely interested to hear about your own uses of Tor, so please feel free to <a href="/contact/" target="_blank">contact me</a>!</p>
</div>

<?php include "footer.php" ?>
