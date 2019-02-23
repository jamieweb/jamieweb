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
</div>

<?php include "footer.php" ?>

</body>

</html>
