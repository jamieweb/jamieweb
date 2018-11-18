<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Disabling TLS 1.0 and TLS 1.1</title>
    <meta name="description" content="Assessing browser compatibility and disabling older TLS protocol versions.">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/blog/disabling-tls1.0-tls1.1/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Disabling TLS 1.0 and TLS 1.1</h1>
    <hr>
    <p><b>Tuesday 13th March 2018</b></p>
    <p>I recently received a security report to my <a href="/contact/#hackerone" target="_blank">HackerOne program</a> by <a href="https://hackerone.com/retr0" target="_blank" rel="noopener">retr0</a>, who suggested that I disable TLS 1.0 on my web server.</p>
    <p>At first I was reluctant as this breaks compatibility with many older browsers, however after monitoring the TLS protocol versions in use by users, I've now disabled both TLS 1.0 and TLS 1.1, meaning that only TLS 1.2 can be used.</p>
    <p>Thanks again to <a href="https://hackerone.com/retr0" target="_blank" rel="noopener">retr0</a> for raising this!</p>
    <p><b>Skip to Section:</b></p>
    <pre><b>Disabling TLS 1.0 and TLS 1.1</b>
&#x2523&#x2501&#x2501 <a href="#why">What is wrong with TLS 1.0 and TLS 1.1?</a>
&#x2523&#x2501&#x2501 <a href="#checking-support">Checking for TLS 1.0 and TLS 1.1 Support</a>
&#x2523&#x2501&#x2501 <a href="#browser-compatibility">Browser Compatibility</a>
&#x2523&#x2501&#x2501 <a href="#logs">Logging TLS Protocol Versions in Use in Apache</a>
&#x2517&#x2501&#x2501 <a href="#disabling">Disabling TLS 1.0 and TLS 1.1 in Apache</a></pre>

    <h2 id="why">What is wrong with TLS 1.0 and TLS 1.1?</h2>
    <p>These versions of the Transport Layer Security (TLS) protocol were first defined in January 1999 (<a href="https://www.ietf.org/rfc/rfc2246.txt" target="_blank" rel="noopener">RFC2246</a>) and April 2006 (<a href="https://www.ietf.org/rfc/rfc4346.txt" target="_blank">RFC4346</a>) respectively, and since then various issues and vulnerabilities have been discovered.</p>
    <p>However, there are currently no major vulnerabilities affecting TLS 1.0 and TLS 1.1 when using the latest browsers and server-side implementations. The notable issues with these protocols are found in certain TLS implementations, rather than being fundamental protocol flaws. This means that simply updating your TLS implementation (eg: OpenSSL, GnuTLS) as well as your browser will fix the issues.</p>
    <p><a href="https://tools.ietf.org/html/rfc7457" target="_blank" rel="noopener">RFC7457</a> provides summaries on some of these attacks, and there is an <a href="https://www.acunetix.com/blog/articles/tls-vulnerabilities-attacks-final-part/" target="_blank" rel="noopener">article by Acunetix</a> that also provides some useful details.</p>
    <p>However, older versions of TLS have begun to be phased out across the internet. Many large sites such as <a href="https://githubengineering.com/crypto-removal-notice/" target="_blank" rel="noopener">GitHub</a> and <a href="https://www.nist.gov/oism/tls-10-being-turned-wwwnistgov" target="_blank" rel="noopener">NIST</a> have already disabled older versions, while many more organisations have plans in place to disable them in the near future. Just yesterday as I was writing this, <a href="https://blog.cloudflare.com/deprecating-old-tls-versions-on-cloudflare-dashboard-and-api/" target="_blank" rel="noopener">Cloudflare announced</a> that they are going to be deprecating TLS 1.0 and TLS 1.1 on their API and dashboard come 4th June 2018.</p>
    <p>It is also important to note that the new PCI DSS requirements state that <a href="https://blog.pcisecuritystandards.org/are-you-ready-for-30-june-2018-sayin-goodbye-to-ssl-early-tls" target="_blank" rel="noopener">TLS 1.0 must be disabled by 30th June 2018</a> in order to remain compliant.</p>

    <h2 id="checking-support">Checking for TLS 1.0 and TLS 1.1 Support</h2>
    <p>You can easily check whether your server supports TLS 1.0 and TLS 1.1 using <a href="https://nmap.org/" target="_blank" rel="noopener">Nmap</a>. This is available in the default repositories on most Linux distributions, and is also available on BSD, macOS and Windows.</p>
    <p>Nmap has a built-in script to enumerate the available ciphers and protocols:</p>
    <pre>$ nmap -p 443 --script ssl-enum-ciphers jamieweb.net</pre>
    <p>This will output all of the supported SSL/TLS protocol versions and ciphers.</p>
    <p>Alternatively, you can use the <a href="https://www.ssllabs.com/ssltest/index.html" target="_blank" rel="noopener">Qualys SSLLabs Scanner</a>.</p>

    <h2 id="browser-compatibility">Browser Compatibility</h2>
    <p>The main downside to disabling TLS 1.0 and TLS 1.1 is that you lose support for some older browsers.</p>
    <p>TLS 1.0 is supported in essentially all web browsers since the early 2000's.</p>
    <p>TLS 1.1 support was added in:</p>
    <ul>
        <li><b>Chrome 22</b>: 31st July 2012</li>
        <li><b>Firefox 24*</b>: 6th August 2013</li>
        <li><b>Safari 7</b>: 27th October 2013</li>
        <li><b>iOS 5</b>: 7th March 2012</li>
        <li><b>Opera 12.1</b>: 5th November 2012</li>
        <li><b>Internet Explorer 11*</b>: 17th October 2013</li>
        <li><b>Microsoft Edge</b>: All Versions Supported</li>
    </ul>
    <p>...and TLS 1.2 support was added in:</p>
    <ul>
        <li><b>Chrome 30</b>: 20th August 2013</li>
        <li><b>Firefox 27*</b>: 4th Febuary 2014</li>
        <li><b>Safari 7</b>: 22nd October 2013</li>
        <li><b>iOS 5</b>: 7th March 2012</li>
        <li><b>Opera 17*</b>: 7th October 2013</li>
        <li><b>Internet Explorer 11*</b>: 17th October 2013</li>
        <li><b>Microsoft Edge</b>: All Versions Supported</li>
    </ul>
    <p>*: <i>Some browsers supported TLS 1.1 and TLS 1.2 in versions earlier than those stated above, but it was disabled by default. If a legitimate user is still using such a dated browser, it is unlikely that they would have manually enabled support for the newer TLS protocol versions. One possible exeption to this is a managed organisation environment where out of date browsers are used, but support for the newer protocols is enabled via a centralised management tool such as Puppet.</i></p>
    <p>Browser Compatibility Information Source: <a href="https://caniuse.com/" target="_blank" rel="noopener">caniuse.com</a> - Please see their fantastic browser compatibility reference pages on <a href="https://caniuse.com/#feat=tls1-1" target="_blank" rel="noopener">TLS 1.1</a> and <a href="https://caniuse.com/#feat=tls1-2" target="_blank" rel="noopener">TLS 1.2</a>.</p>
    <img width="1000px" src="/blog/disabling-tls1.0-tls1.1/firefox-3-6.png">
    <p class="two-no-mar centertext"><i>Connecting to jamieweb.net using Firefox 3.6, which does not support TLS 1.1 or TLS 1.2. Original screenshot generated by <a href="https://urlquery.net/" target="_blank" rel="noopener">urlquery.net</a>.</i></p>
    <p>Losing compatibility with most of these browsers is not a major problem since their usage shares are now extremely low. The only one that looks slightly concerning is Internet Explorer 10, since many unpatched versions of Windows 7 still use this browser, however according to the stats above its usage share is only 0.12%.</p>

    <h2 id="logs">Logging TLS Protocol Versions in Use in Apache</h2>
    <p>Before disabling TLS 1.0 and TLS 1.1, it is important to assess the impact that this could have on your users. The best way to do this is by monitoring the web server log files directly, as this gives the most raw results.</p>
    <p>In Apache, this is extremely easy to configure using the <code>CustomLog</code> directive. Add the following to the virtual host that you want to monitor, and the TLS protocol version will be logged for all requests:</p>
    <pre>CustomLog ${APACHE_LOG_DIR}/tls.log "%t %h %{SSL_PROTOCOL}x %{SSL_CIPHER}x"</pre>
    <p>You can also optionally log the user agent string in order to help identify which client software is still using older TLS protocol versions:</p>
    <pre>CustomLog ${APACHE_LOG_DIR}/tls.log "%t %h %{SSL_PROTOCOL}x %{SSL_CIPHER}x \"%{User-agent}i\""</pre>
    <p><i>As far as I know, this configuration does not work when specified in a global configuration file, it has to be directly in the virtual host configuration. I'm not sure why this is, but when defining the CustomLog globally, it doesn't seem to log the TLS information correctly even when there are definitely TLS requests reaching the server.</i></p>
    <p>Leave this running for a while in order to get a good set of sample data.</p>
    <p>You can then check the total number of requests, as well as the number of requests that did not use TLSv1.2:</p>
    <pre>$ wc -l tls.log
$ grep -v "TLSv1.2" tls.log | wc -l</pre>
    <p>Using the results from the above commands, you can calculate the percentage of requests that did not use TLSv1.2.</p>
    <p>I left my log running for around 20 hours, and in total there were just over 100,000 TLS requests. Out of these, only 0.078% were not using TLS 1.2.</p>
    <img width="1000px" src="/blog/disabling-tls1.0-tls1.1/tls-chart.png">
    <p class="two-no-mar centertext"><i>A graph showing the number of TLS connections per protocol version during the 20 hour monitoring period.</i></p>
    <p>As you can see above, the columns for TLS 1.0 and TLS 1.1 are barely even visible.</p>
    <p>It is important to note that the data for my site is probably very biased, as this is a technical site with likely technical visitors. However that is OK, as I wanted to know the potential impact on my site, rather than on the internet as a whole.</p>

    <h2 id="disabling">Disabling TLS 1.0 and TLS 1.1 in Apache</h2>
    <p>In order to specify which SSL/TLS protocol versions you want to use in Apache, the <code>SSLProtocol</code> directive must be used. In order to only allow TLS 1.2, simply use:</p>
    <pre>SSLProtocol TLSv1.2</pre>
    <p>You can also specify multiple versions, including using the <code>all</code> shortcut:</p>
    <pre>SSLProtocol all -SSLv2 -SSLv3</pre>
    <p>Please see the <a href="https://httpd.apache.org/docs/2.4/mod/mod_ssl.html#sslprotocol" target="_blank" rel="noopener">Apache documentation</a> for full details.</p>
    <p>Test the server configuration with <code>apachectl configtest</code>, then reload the server with <code>service apache2 reload</code>.</p>
    <p>You should then re-test your server in order to make sure that the configuration was correct. Also, if you enabled the TLS protocol version logging, don't forget to disable it as the log files can get quite large.</p>
    <p>An alternative to hard-disabling these protocols is to redirect them to a page suggesting that the user upgrade their browser. This can be achieved in Apache using <code>mod_rewrite</code>:</p>
    <pre>RewriteEngine on
RewriteCond %{SSL:SSL_PROTOCOL} ^TLSv1.0$
RewriteCond %{SSL:SSL_PROTOCOL} ^TLSv1.1$
RewriteRule ^ https://www.jamieweb.net/tls-unsupported.php [END,R=302]</pre>
    <p>...although this does require you to keep the insecure protocols enabled in order to allow the connection for the redirect.</p>
</div>

<?php include "footer.php" ?>

</body>

</html>
