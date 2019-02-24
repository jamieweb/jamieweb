<?php include "response-headers.php"; content_security_policy(); ?>
<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Forwarding Tor Hidden Services to Another Server Across the Internet</title>
    <meta name="description" content="Using a reverse HTTP proxy to forward Tor Hidden Services across the internet to another server.">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/blog/forwarding-tor-hidden-services-to-another-server-across-the-internet/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Forwarding Tor Hidden Services to Another Server Across the Internet</h1>
    <hr>
    <p><b>Sunday 24th February 2019</b></p>
    <p>I recently re-deployed my entire infrastructure onto two new servers using Ansible, and as part of this I wanted to remove all stored secrets from my public-facing web servers.</p>
    <p>Let's Encrypt certificates were no problem as they are generated on the server and can be easily replaced if needed, and I removed the need for an SSH private key for Git by just using the public repo over HTTPS.</p>
    <p>The only secrets that posed a challenge were my Tor Hidden Service private keys, both for <a href="/blog/onionv3-vanity-address/" target="_blank">Onion v3</a> and the historic <a href="/blog/tor-hidden-service/" target="_blank">Onion v2</a>. The impact of one of these keys breaching would be very high, since the associated hostnames are already widely known and indexed. Because of this, it would absolutely not be appropriate to store them in my Ansible playbooks Git repository, nor would it be ideal to store them locally on my Ansible control machine.</p>
    <p>One option would be to manually upload them whenever I deployed a new server, however this goes against the complete automation that I am achieving with Ansible. Instead, I decided to not run Tor on my public web server fleet at all, and instead host the Hidden Services elsewhere, with traffic forwarded to the web server fleet securely over the internet.</p>
    <h3 id="disclaimer">Warning:</h3>
    <p><b>If your anonymity as a Tor Hidden Server operator is important, do not use this method! It has a high chance of deanonymizing your Hidden Service traffic since it is forwarded over the public internet to a separate server.</b></p>
    <p><b>Skip to Section:</b></p>
    <pre><b>Forwarding Tor Hidden Services to Another Server Across the Internet</b>
&#x2523&#x2501&#x2501 <a href="#hidden-service-traffic">Hidden Service Traffic</a>
&#x2523&#x2501&#x2501 <a href="#why-can-t-you-natively-forward-hidden-service-across-over-the-internet">Why can't you natively forward Hidden Service traffic over the internet?</a>
&#x2523&#x2501&#x2501 <a href="#forwarding-hidden-service-traffic-with-an-apache-reverse-proxy">Forwarding Hidden Service Traffic with an Apache Reverse Proxy</a>
&#x2523&#x2501&#x2501 <a href="#alternative-methods">Alternative Methods (Just For Fun)</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>

    <h2 id="hidden-service-traffic">Hidden Service Traffic</h2>
    <p>When configuring a Tor Hidden Service, the <code>HiddenServicePort</code> configuration is used to redirect requests to your Hidden Service on one port to another service running on a different port. The most common configuration is to redirect requests to port 80 to a local web server also running on port 80:</p>
    <pre>HiddenServiceDir /var/lib/tor/onion_v3/
HiddenServiceVersion 3
HiddenServicePort 80 127.0.0.1:80</pre>
    <p>Alternatively, if you wanted to host SSH behind a Hidden Service, you could use:</p>
    <pre>HiddenServicePort 22 127.0.0.1:22</pre>
    <p>The important point to note is that Hidden Services are not protocol aware - they just redirect raw packets. This means that you can freely make Tor redirect the packets wherever you want to, but <b>you</b> are responsible for making sure that it does this securely.</p>
    <p>The <a href="https://www.torproject.org/docs/onion-services.html.en" target="_blank" rel="noopener">Onion Service Protocol</a> provides confidentiality, anonimity and integrity between Tor clients (users) and Hidden Services, but once the traffic is forwarded by the Hidden Service it is in its raw format.</p>
    <p>For example, if HTTP traffic on port 80 is forwarded, then it gets forwarded as-is (plaintext HTTP). As drastic as this may sound, it's not normally a problem as most Hidden Services forward traffic to localhost (127.0.0.1), so the unencrypted traffic isn't traversing any insecure networks. As long as the server machine is configured correctly and isn't directly accessible by adversaries, there generally isn't a security problem.</p>
    <p>However, if you want to forward your Hidden Service traffic to another server across the internet, you will need to provide a layer of security yourself.</p>

    <h2 id="#why-can-t-you-natively-forward-hidden-service-across-over-the-internet">Why can't you natively forward Hidden Service traffic over the internet?</h2>
    <p>You can if you want... but unless you have added your own extra layer of security (e.g. TLS), it will be completely unencrypted.</p>
    <p>I looked into this further by setting up a Hidden Service on a test machine, configuring it to forward traffic to one of the public JamieWeb servers (157.230.83.95, which is nyc01.jamieweb.net), and monitoring the network interface with Wireshark.</p>
    <p>I used the following Hidden Service configuration in <code>/etc/tor/torrc</code>:</p>
    <pre>HiddenServiceDir /var/lib/tor/onion_v3_test/
HiddenServiceVersion 3
HiddenServicePort 80 157.230.83.95:80</pre>
    <p>I restarted the Tor service with <code>sudo service tor restart</code>, and a new Hidden Service had been successfully created. I started a Wireshark capture, and put the Onion hostname into Tor Browser:</p>
    <img class="radius-8" src="tor-browser-80-80.png" width="1000px" alt="A screenshot of the Tor Browser showing the response from my JamieWeb server - '403 Forbidden - Direct access to IPv4 address (157.230.83.95) blocked...'">
    <p>My server blocked the request as the test Hidden Service I had created is not an authorised hostname, however you can see that the request did successfully reach my server (which to clarify, is a completely different machine to where the Hidden Service is running).</p>
    <p>In the Wireshark packet capture, you can see that this request was sent completely unencrypted between the Hidden Service and the remote server:</p>
    <img class="radius-8" src="wireshark-80-80.png" width="1000px" alt="A screenshot of a packet capture in Wireshark, showing an unencrypted HTTP GET request being forwarded to the remote JamieWeb server.">
    
</div>

<?php include "footer.php" ?>

</body>

</html>









