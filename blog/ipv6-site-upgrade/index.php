<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Upgrading to IPv6</title>
    <meta name="description" content="Setting up and configuring IPv6.">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/blog/ipv6-site-upgrade/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Upgrading to IPv6</h1>
    <hr>
    <p><b>Saturday 5th August 2017</b></p>
    <p>As of this week, JamieWeb is fully accessible over IPv6! The new IPv6 address for JamieWeb is <b>2a01:7e00:e001:c500::1</b>.</p>
    <p><b>Skip to Section:</b></p>
    <pre><b>Upgrading JamieWeb to IPv6</b>
&#x2523&#x2501&#x2501 <a href="#info">IPv6 Information</a>
&#x2523&#x2501&#x2501 <a href="#dns">DNS Configuration</a>
&#x2523&#x2501&#x2501 <a href="#apache">Apache Configuration</a>
&#x2523&#x2501&#x2501 <a href="#direct">Blocking Direct IP Access</a>
&#x2523&#x2501&#x2501 <a href="#tunnels">IPv6 Tunnels</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>
    <h2 id="info">IPv6 Information</h2>
    <p>IPv6 is the latest version of Internet Protocol, and has been standardised for well over a decade. However, IPv6 is underutilised, resulting in lack of support and compatibility in many modern applications. In many places, IPv6 is not available at all or has only been deployed by ISPs recently, with support for the general consumer still very lacking.</p>
    <p>The IPv6 address space contains a total of 340,282,366,920,938,463,463,374,607,431,768,211,456 (2^128, 340 undecillion) unique addresses. Compare this to IPv4 which only has 4,294,967,296 (2^32, 4.29 billion) addresses and you can see the true scale of the IPv6 address space.</p>
    <p>Since IPv6 addresses are so abundant, network address translation (NAT) is not used on IPv6 networks. Each client device can have its own IPv6 address. It is also common for enormous IPv6 ranges to be handed out to individuals like candy. You can acquire a /48 IPv6 range for free from some places, and many ISPs allocate large ranges too. Acquiring a large range of IPv4 addresses would be extremely costly, and even then you'd never be able to get anywhere near the amount of addresses you'd get with even a small IPv6 range.</p>
    <p>IPv6 addresses are made up of 32 hex characters (128 bits), with colons separating each "hextet" of 4 hex characters (16 bits). Double colons (::) are used to represent padded zeros, filling up to the maximum length of the address. For example:</p>
    <pre>2a01:7e00:e001:c500::1</pre>
    <p>...is equivalent to:</p>
    <pre>2a01:7e00:e001:c500:0000:0000:0000:0001</pre>
    <p>...as well as:</p>
    <pre>2a01:7e00:e001:c500:0:0:0:1</pre>
    <p>Double colons can only be used once in an IPv6 address, usually to represent the largest block of zeros.</p>
    <p>IPv6 addresses are also often encased in square brackets ([]) when used in URLs, command arguments, configuration files, etc.</p>
    <h2 id="dns">DNS Configuration</h2>
    <p>AAAA records are the equivalent of A records, but for IPv6 addresses.</p>
    <p>Both the IPv6 and IPv4 addresses are present in the DNS entries for (www.)jamieweb.net:</p>
    <pre>jamie@box:~$ dig @8.8.8.8 +short www.jamieweb.net AAAA jamieweb.net AAAA
2a01:7e00:e001:c500::1
2a01:7e00:e001:c500::1
jamie@box:~$ dig @8.8.8.8 +short www.jamieweb.net A jamieweb.net A
139.162.222.67
139.162.222.67</pre>
    <p>By default in modern web browsers, the IPv6 address will be prefered. If the client does not support IPv6 it will fall back to using IPv4.</p>
    <p>Reverse DNS is also set up. A reverse lookup of 2a01:7e00:e001:c500::1 returns jamieweb.net.
    <pre>jamie@box:~$ dig @8.8.8.8 +short -x 2a01:7e00:e001:c500::1
jamieweb.net.</pre>
    <h2 id="apache">Apache Configuration</h2>
    <p>Configuring Apache to work with IPv6 is extremely simple. If you are not using virtual hosts, it will probably already work by default. If not, make sure that your Apache server is actually listening on IPv6. It may be that you configured your entire server to only listen on predefined IP addresses.</p>
    <p>You do not need to create new virtual hosts for the IPv6 versions of your sites, you can simply configure the virtual hosts to listen on IPv6 too by adding the IPv6 address to the virtual host directive. The IPv6 address must be enclosed in square brackets. For example:</p>
    <pre>&lt;VirtualHost 139.162.222.67:443 [2a01:7e00:e001:c500::1]:443&gt;</pre>
    <h2 id="direct">Blocking Direct IP Access</h2>
    <p>For my IPv4 address (139.162.222.67), I have an Apache virtual host configured in order to block direct access to the website via the IP address. I don't see a good reason to be able to access the website directly by IP address, other than perhaps if you didn't have DNS available. Allowing direct access by IP address would also mean that the connection would be unencrypted, since SSL can not be set up for just an IP address.</p>
    <p>If you visit the IP address directly, you will get a 403 forbidden error:</p>
    <pre>403 Forbidden - Direct request to IPv4 address (139.162.222.67) blocked. Please use <a href="https://www.jamieweb.net">https://www.jamieweb.net</a> instead.</pre>
    <p>The virtual host for this configuration is as follows (irrelevant lines removed):</p>
    <pre>&lt;VirtualHost 139.162.222.67:80&gt;
    ServerName 139.162.222.67

    &lt;Location /&gt;
        Deny from all
        ErrorDocument 403 "403 Forbidden - Direct request to IPv4 address (139.162.222.67) blocked."
    &lt;/Location&gt;
&lt;/VirtualHost&gt;</pre>
    <p>Unfortunately, this same setup did not work for the IPv6 address. This is because the Apache ServerName directive must be an RFC1123 DNS name. This is fine for IPv4 addresses however IPv6 addresses contain colons (:) and are often encased in square brackets ([]).</p>
    <p>I order to fix this I had to use a catch-all virtual host and a bit of a trick based on the way that the Apache virtual host system works.</p>
    <p>In Apache, if the request host header does not match the ServerName of any of the available virtual hosts, it automatically falls back to using the first virtual host defined that is listening on the request address. Apache checks through virtual hosts in the order that they are defined in the configuration. If multiple files are used, the files are read alphabetically by file name.</p>
    <p>For example, if I made a request to "139.162.222.67" with the host header "does-not-exist.jamieweb.net", no virtual hosts would match this request. Apache would then fall back to the first virtual host that is listening on "139.162.222.67", and serve the content from there. If there is nothing listening on the address, the request will time out.</p>
    <p>If you configure the first virtual host to listen on an IPv6 address, but then set the ServerName to something that does not exist, direct requests to the IPv6 address will be directed there. See the virtual host config below (irrelevant lines removed):</p>
    <pre>&lt;VirtualHost [2a01:7e00:e001:c500::1]:80&gt;
    ServerName null.jamieweb.net

    &lt;Location /&gt;
        Deny from all
        ErrorDocument 403 "403 Forbidden - Direct request to IPv6 address (2a01:7e00:e001:c500::1) blocked."
    &lt;/Location&gt;
&lt;/VirtualHost&gt;</pre>
    <p>The virtual host above must be the first IPv6-listening virtual host to be defined in order for this to work. Put it right at the top of your configuration file and/or ensure that the file name is first when sorted alphabetically.</p>
    <p>A catch-all virtual host has two main uses: preventing direct access to your web server via IP address, and preventing other people from pointing their domain names at your server and having your server serve content through them.</p>
    <p>With a misconfigured Apache server, it would be possible for somebody to point their domain's DNS at your server and have your server serve content when people visit it. For example, if I owned the domain "example.tld", and I set up a DNS record to point to somebody else's misconfigured Apache server, people who visit my domain name would see content from somebody else's web server.</p>
    <p>As far as I know there are no direct security implications of this. It does not give somebody control of your web server or domain name. However, there are major indirect implications such as the fact that somebody else is "borrowing" your server without permission, users may be mislead and confused, etc.</p>
    <p>You can test these configurations out at <a href="http://139.162.222.67" target="_blank" rel="noopener">http://139.162.222.67</a> and <a href="http://[2a01:7e00:e001:c500::1]" target="_blank" rel="noopener">http://[2a01:7e00:e001:c500::1]</a>.
    <h2 id="tunnels">IPv6 Tunnels</h2>
    <p>If you do not have native IPv6 access on your internet connection but would like to be able to access the IPv6 internet, one option is to use an IPv6 tunnel.</p>
    <p>There are many IPv6 tunnel providers, known as "tunnel brokers" available. The most popular and best in my opinion is <a href="https://tunnelbroker.net" target="_blank" rel="noopener">tunnelbroker.net</a> by <a href="https://he.net" target="_blank" rel="noopener">Hurricane Electric Internet Services</a>. It is very easy to sign up and configure a tunnel, and you will be provided with instructions for connecting to the tunnel on different operating systems. For Linux systems, they provide you a set of IP routing commands to copy and paste into a terminal.</p>
    <p>A couple of possible downsides are that you have to manually enter your IPv4 public address to the tunnel configuration. This is inconvenient if your ISP gives you a dynamic IP address since you'll have to update your tunnel configuration every time your IP changes. Your IPv4 public address must also be pingable over the internet, which may be an issue from a security perspective as well as the fact that it is not possible to allow remote ICMP on some routers.</p>
    <p>An alternative to using an IPv6 tunnel service is to host your own! A standard OpenVPN setup running on a server with IPv6 access can be configured to tunnel IPv6 to connected clients. I'd say this is the best way of doing it if you want permanent tunnelled IPv6 access for everyday use, since you are in full control of your connection. There are configuration guides available online for this.</p>
    <h2 id="conclusion">Conclusion</h2>
    <p>I am very happy that IPv6 is all set up and working for my site. All that is needed now is for more and more people to adopt it, since it is overall a much better system to use. It's just the lack of support and deployment holding it back! My site is still accessible over IPv4 as a fallback.</p>
    <p><b>Edit 19th Aug 2017 @ 3:31pm:</b> <i>I have configured two new subdomains for IPv4/6 testing: <a href="https://ipv4.jamieweb.net" target="_blank" rel="noopener">https://ipv4.jamieweb.net</a> and <a href="https://ipv6.jamieweb.net" target="_blank" rel="noopener">https://ipv6.jamieweb.net</a>. These subdomains are only accessible over the protocol version specified, so they are very useful for testing your connection. I submitted these two subdomains to <a href="https://test-ipv6.com" target="_blank" rel="noopener">https://test-ipv6.com</a> and my site is now listed on the "Other IPv6 Sites" tab, which is visible if you pass the IPv6 test.</i></p>
</div>

<?php include "footer.php" ?>

</body>

</html>
