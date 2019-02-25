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
    <p><b>Tuesday 26th February 2019</b></p>
    <div class="message-box message-box-positive">
        <div class="message-box-heading">
            <h3 id="disclaimer"><u>Skip to Solution...</u></h3>
        </div>
        <div class="message-box-body">
            <p>If you just want to skip to the solution, please <a href="#forwarding-hidden-service-traffic-with-an-apache-reverse-proxy">click here</a>. If you'd like to hear about some of the story and investigation behind this, please read on...</p>
        </div>
    </div>
    <p>I recently re-deployed my entire infrastructure onto two new servers using Ansible, and as part of this I wanted to remove all stored secrets from my public-facing web servers.</p>
    <p>Let's Encrypt certificates were no problem as they are generated on the server and can be easily replaced if needed, and I removed the need for an SSH private key for Git by just using the public repo over HTTPS.</p>
    <p>The only secrets that posed a challenge were my Tor Hidden Service private keys, both for <a href="/blog/onionv3-vanity-address/" target="_blank">Onion v3</a> and the historic <a href="/blog/tor-hidden-service/" target="_blank">Onion v2</a>. The impact of one of these keys breaching would be very high, since the associated hostnames are already widely known and indexed. Because of this, it would absolutely not be appropriate to store them in my Ansible playbooks Git repository, nor would it be ideal to store them locally on my Ansible control machine.</p>
    <p>One option would be to manually upload them whenever I deployed a new server, however this goes against the complete automation that I am achieving with Ansible. Instead, I decided to not run Tor on my public web server fleet at all, and instead host the Hidden Services elsewhere, with traffic forwarded to the web server fleet securely over the internet with an Apache reverse HTTP proxy.</p>
    <p><b>Skip to Section:</b></p>
    <pre><b>Forwarding Tor Hidden Services to Another Server Across the Internet</b>
&#x2523&#x2501&#x2501 <a href="#hidden-service-traffic">Hidden Service Traffic</a>
&#x2523&#x2501&#x2501 <a href="#why-can-t-you-natively-forward-hidden-service-across-over-the-internet">Why can't you natively forward Hidden Service traffic over the internet?</a>
&#x2523&#x2501&#x2501 <a href="#forwarding-hidden-service-traffic-with-an-apache-reverse-proxy">Forwarding Hidden Service Traffic with an Apache Reverse Proxy</a>
&#x2523&#x2501&#x2501 <a href="#troubleshooting">Troubleshooting</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>

    <h2 id="hidden-service-traffic">Hidden Service Traffic</h2>
    <p>When configuring a Tor Hidden Service, the <code>HiddenServicePort</code> configuration is used to redirect requests to your Hidden Service on one port to another service running on a different port. The most common configuration is to redirect requests to port 80 to a local web server also running on port 80:</p>
    <pre>HiddenServiceDir /var/lib/tor/onion_v3/
HiddenServiceVersion 3
HiddenServicePort 80 127.0.0.1:80</pre>
    <p>Alternatively, if you wanted to host SSH behind a Hidden Service, you could use:</p>
    <pre>HiddenServicePort 22 127.0.0.1:22</pre>
    <p>The important point to note is that Hidden Services are not protocol-aware - they just redirect raw packets. This means that you can freely make Tor redirect the packets wherever you want to, but <b>you</b> are responsible for making sure that it does this securely.</p>
    <p>The <a href="https://www.torproject.org/docs/onion-services.html.en" target="_blank" rel="noopener">Onion Service Protocol</a> provides confidentiality, anonymity and integrity between Tor clients (users) and Hidden Services, but once the traffic is forwarded by the Hidden Service it is in its raw format.</p>
    <p>For example, if HTTP traffic on port 80 is forwarded, then it gets forwarded as-is (plaintext HTTP). As drastic as this may sound, it's not normally a problem as most Hidden Services forward traffic to localhost (127.0.0.1), so the unencrypted traffic isn't traversing any insecure networks. As long as the server machine is configured correctly and isn't directly accessible by adversaries, there generally isn't a security problem.</p>
    <p>However, if you want to forward your Hidden Service traffic to another server across the internet, you will need to provide a layer of security yourself.</p>

    <h2 id="why-can-t-you-natively-forward-hidden-service-across-over-the-internet">Why can't you natively forward Hidden Service traffic over the internet?</h2>
    <p>You can if you want... but unless you have added your own extra layer of security (e.g. TLS), it will be completely unencrypted.</p>
    <p>I looked into this further by setting up a Hidden Service on a test machine, configuring it to forward traffic to one of the public JamieWeb servers (157.230.83.95, which is nyc01.jamieweb.net), and monitoring the network interface with Wireshark.</p>
    <p>I used the following Hidden Service configuration in <code>/etc/tor/torrc</code>:</p>
    <pre>HiddenServiceDir /var/lib/tor/onion_v3_test/
HiddenServiceVersion 3
HiddenServicePort 80 157.230.83.95:80</pre>
    <p>I restarted the Tor service with <code>sudo service tor restart</code>, and a new Hidden Service had been successfully created. I started a Wireshark capture, and put the Onion hostname into Tor Browser:</p>
    <img class="radius-8" src="tor-browser-80-80-jamieweb.png" width="1000px" alt="A screenshot of the Tor Browser showing the response from my JamieWeb server - '403 Forbidden - Direct access to IPv4 address (157.230.83.95) blocked...'">
    <p>My server blocked the request as the test Hidden Service I had created is not an authorised hostname, however you can see that the request did successfully reach my server (which to clarify, is a completely different machine to where the Hidden Service is running).</p>
    <p>In the Wireshark packet capture, you can see that this request was sent completely unencrypted between the Hidden Service and the remote server:</p>
    <img class="radius-8" src="wireshark-80-80.png" width="1000px" alt="A screenshot of a packet capture in Wireshark, showing an unencrypted HTTP GET request being forwarded to the remote JamieWeb server.">
    <p>Tracing the TCP stream shows that the request and response was unencrypted, which is the expected and intended behaviour:</p>
    <img class="radius-8" src="wireshark-80-80-tcpstream.png" width="1000px" alt="A screenshot of a TCP trace in Wireshark, showing the complete HTTP request and response.">
    <p>Modifying <code>HiddenServicePort</code> to forward the traffic to port 443 does not resolve this problem though. As I discussed earlier, Hidden Services are not protocol-aware, so the packets will just be forwarded in their raw format to port 443. This is no good, as web servers listening on port 443 are generally expecting a TLS connection first, before HTTP traffic is sent:</p>
    <img class="radius-8" src="wireshark-80-443-http-to-https-port.png" width="1000px" alt="A screenshot of a packet capture in Wireshark, showing raw HTTP being sent to port 443 without the required TLS connection in place.">
    <p>As you can see in the screenshot above, Wireshark actually notices that plain HTTP traffic was sent to the usual HTTPS port.</p>
    <p>Tor does not intelligently create the TLS connection it needs, as ultimately it's not supposed to - this is way beyond the scope of what Hidden Services are designed to do.</p>

    <h2 id="forwarding-hidden-service-traffic-with-an-apache-reverse-proxy">Forwarding Hidden Service Traffic with an Apache Reverse Proxy</h2>
    <p>In order to securely forward my Tor Hidden Service traffic to a remote server across the public internet, I set up an Apache reverse proxy to forward requests over HTTPS.</p>
    <p>This works by having the Hidden Service forward packets to a local web server running on 127.0.0.1, which will then proxy the requests to the remote server natively using HTTPS.</p>
    <div class="message-box message-box-warning">
        <div class="message-box-heading">
            <h3 id="disclaimer"><u>Warning!</u></h3>
        </div>
        <div class="message-box-body">
            <p>If your anonymity as a Tor Hidden Service operator is important, do not use this method! It has a high chance of deanonymizing your Hidden Service, as the traffic from it will be forwarded over the public internet to a separate server.</p>
        </div>
    </div>
    <p>In order to set this up for your own Hidden Service, you will need to create a new Virtual Host. On Debian-based systems, you can create a new file in the <code>/etc/apache2/sites-available</code> directory named something applicable like <code>tor-forward.conf</code>, and add the following configuration to the file:</p>
    <pre>&lt;VirtualHost 127.0.0.1:80&gt;
    SSLProxyEngine On
    ProxyRequests Off
    ProxyPass "/" "https://your-website-here.example/"
    ProxyPassReverse "/" "https://your-website-here.example/"
&lt;/VirtualHost&gt;</pre>
    <p>This configuration will forward requests to <code>127.0.0.1:80</code> on to the remote server specified over HTTPS.</p>
    <ul class="spaced-list">
        <li><code>SSLProxyEngine On</code> allows <code>mod_proxy</code> to use HTTPS, and requires <code>mod_ssl</code> to be enabled.</li>
        <li><code>ProxyRequests Off</code> prevents your Apache server being used as a forward proxy server, which prevents unauthorised people connecting and using your machine as a front for their nefarious activity.</li>
        <li><code>ProxyPass</code> passes requests to the first argument (<code>"/"</code> in this case, which is essentially every request) through to the the second argument (which in this case, will the public-facing address of your remote web server).</li>
        <li><code>ProxyPassReverse</code> allows Apache to rewrite the <code>Location</code>, <code>Content-Location</code> and <code>URI</code> headers in HTTP redirects, to ensure that they continue working properly and do not accidentally redirect out of the reverse proxy setup.</li>
    </ul>
    <p>If you don't want to bind this VirtualHost to port 80, you can use a different one if you want, but you'll need to update the <code>HiddenServicePort</code> configuration accordingly. A <code>ServerName</code> is also not needed, as this Virtual Host will only accept connections from localhost.</p>
    <p>Also make sure that you always use trailing slashes for the arguments in the <code>ProxyPass</code> and <code>ProxyPassReverse</code> directives, otherwise requests will be improperly proxied and could allow for your server to be used as an open proxy (since without a trailing slash, requests to <code>/index.html</code> will be forwarded to <code>https://your-website-here.exampleindex.html</code> [note the missing slash], which can be exploited to reach unauthorized destinations).</p>
    <p>Before enabling the new VirtualHost, you'll need to enable the <code>proxy</code>, <code>proxy_http</code> and <code>ssl</code> Apache modules.</p>
    <p>On Debian-based systems, you can do this with <code>sudo a2enmod module_name</code>. Once this is done, you can also enable the new Virtual Host with <code>sudo a2ensite tor-forward.conf</code> (or whatever you named the Virtual Host file).</p>
    <p>Then, test your Apache config with <code>apachectl configtest</code>, and restart the Apache server with <code>sudo service apache2 restart</code>.</p>
    <p>Now when you make a request to the web server and hit the Virtual Host that you created, the response should be from the remote server specified in your configuration.</p>
    <p>If everything works as expected, you can update your Tor Hidden Service configuration in <code>/etc/tor/torrc</code> to set <code>HiddenServicePort</code> to <code>80 127.0.0.1:80</code> (or whichever IP/port you used), and then restart Tor with <code>sudo service tor restart</code>.</p>
    <p>Connecting to the Hidden Service will now result in Apache establishing a TLS connection with the remote server and proxying the request through:</p>
    <img class="radius-8" src="wireshark-80-reverse-proxy-tls-1-2.png" width="1000px" alt="A screenshot of a packet capture in Wireshark, showing a TLS 1.2 connection being established between the Apache reverse proxy and remote server.">
    <p>Tracing the TCP stream shows the TLS handshake taking place:</p>
    <img class="radius-8" src="wireshark-80-reverse-proxy-tls-handshake.png" width="1000px" alt="A screenshot of a TCP trace in Wireshark, showing the TLS 1.2 handshake taking place.">
    <p>And the website is displayed as expected in Tor Browser:</p>
    <img class="radius-8" src="tor-browser-80-reverse-proxy-jamieweb.png" width="1000px" alt="A screenshot of Tor Browser, showing the JamieWeb homepage loaded successfully from the Hidden Service, with the circuit information menu on display as well.">
    <p>As an additional configuration, if you wish to prevent people from connecting directly to your origin server, you could use a firewall rule to restrict connections to port 443 to only allow your Hidden Service, or you could use <code>mod_authz_host</code>'s <code><a href="https://httpd.apache.org/docs/2.4/mod/mod_authz_host.html#requiredirectives" target="_blank" rel="noopener">Require</a></code> directive to whitelist the IP address required.</p>

    <h2 id="troubleshooting">Troubleshooting</h2>
    <p>I've documented some common errors that you may encounter with this setup:</p>
    <h4><code>AH01144: No protocol handler was valid for the URL /. If you are using a DSO version of mod_proxy, make sure the proxy submodules are included in the configuration using LoadModule.</code>:</h4>
    <p>Ensure that the <code>proxy_http</code> module is enabled.</p>
    <h4><code>Invalid command 'SSLProxyEngine', perhaps misspelled or defined by a module not included in the server configuration</code>:</h4>
    <p>Ensure that the <code>ssl</code> module is enabled.</p>
    <h4><code>AH01144: No protocol handler was valid for the URL / (scheme 'https'). If you are using a DSO version of mod_proxy, make sure the proxy submodules are included in the configuration using LoadModule.</code>:</h4>
    <p>Ensure that the <code>SSLProxyEngine</code> configuration is enabled for the relevant Virtual Host, and that the <code>ssl</code> module is enabled for the server.</p>
    <h4><code>AH00961: HTTPS: failed to enable ssl support</code>:</h4>
    <p>Ensure that the <code>SSLProxyEngine</code> configuration is enabled for the relevant Virtual Host.</p>
    <h4><code>AH00898: DNS lookup failure</code>:</h4>
    <p>Ensure that you used trailing slashes in the <code>ProxyPass</code> and <code>ProxyPassReverse</code> directives.</p>

    <h2 id="conclusion">Conclusion</h2>
    <p>This setup isn't ideal for some use cases, but for me it has allowed me to vastly improve the resilience and disaster recovery time of my infrastructure, without posing an undue risk to my Hidden Service private keys.</p>
    <p>In future I may even bring the reverse proxy completely on-site and host it on a Raspberry Pi or something similar, as that would allow for further cost savings and ease of setup.</p>
    <p>There are also other ways that you could securely forward a Hidden Service across the internet, for example using an SSH tunnel, however a reverse HTTP proxy seems like the most suitable way, as it is the most resilient. Either end can go down and it will start working again automatically when it comes back online, but with an SSH tunnel you'd have to resort to a potentially unreliable monitoring script to reestablish the connection if/when it goes offline.</p>
</div>

<?php include "footer.php" ?>

</body>

</html>









