<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Tor Onion v3 Hidden Service</title>
    <meta name="description" content="Testing the new Tor Onion v3 Hidden Services">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/blog/onionv3-hidden-service/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Tor Onion v3 Hidden Service</h1>
    <hr>
    <p><b>Saturday 21st October 2017</b></p>
    <p>I have set up a new Onion v3 Tor Hidden Service for JamieWeb, available at:</p>
    <pre><a href="http://jamie3vkiwibfiwucd6vxijskbhpjdyajmzeor4mc4i7yopvpo4p7cyd.onion" target="_blank" rel="noopener">jamie3vkiwibfiwucd6vxijskbhpjdyajmzeor4mc4i7yopvpo4p7cyd.onion</a></pre>
    <p><b>Edit 17th Jan 2018 @ 10:48pm:</b> <i>Now that Onion v3 functionality is in the stable release version of Tor, I have moved over to a new Onion v3 hidden service with a vanity address, as seen above. The hidden service that I originally hosted for testing Onion v3 in the alpha builds is: <a href="http://32zzibxmqi2ybxpqyggwwuwz7a3lbvtzoloti7cxoevyvijexvgsfeid.onion" target="_blank" rel="noopener">32zzibxmqi2ybxpqyggwwuwz7a3lbvtzoloti7cxoevyvijexvgsfeid.onion</a>, however this is now offline. You can read my blog post about generating an Onion v3 vanity address using mkp224o <a href="/blog/onionv3-vanity-address" target="_blank">here</a>.</i></p>
    <p>As of writing this post, you need at least tor-0.3.2.1-alpha (eg: Tor Browser 7.5a5) in order to access the new Onion v3 hidden services.</p>
    <p><b>Skip to Section:</b></p>
    <pre><b>Tor Onion v3 Hidden Service</b>
&#x2523&#x2501&#x2501 <a href="#onionconfig">Hidden Service Configuration</a>
&#x2523&#x2501&#x2501 <a href="#apacheconfig">Apache Configuration</a>
&#x2523&#x2501&#x2501 <a href="#vanityaddresses">Vanity Addresses</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>
    <p>Onion v3 is the new next-generation Tor Onion Services specification. The most noticable change is the increase in address length, however Onion v3 uses better cryptography, ECC (eliptic curve cryptography) rather than RSA, and has an improved hidden service directory protocol.</p>
    <img width="1000px" src="/blog/onionv3-hidden-service/onion-alpha.png">
    <p>Since this hidden service is running on an alpha build of Tor, I am hosting it on a separate, isolated server. I'm also using a virtual machine for testing the Tor Browser alpha builds, as seen above.</p>
    <h2 id="onionconfig">Hidden Service Configuration</h2>
    <p>In order to set up an Onion v3 hidden service, you'll have to build Tor from source.</p>
    <p>Download and verify Tor (standalone) from the <a href="https://www.torproject.org/download/download.html" target="_blank" rel="noopener">Tor downloads page</a>. Below are my verifications for Tor 0.3.2.2 Alpha and Tor Browser 7.5a5 for Linux 64 bit, but always make sure to do your own verifications too:</p>
    <pre class="scroll"><b>File Name:</b> tor-0.3.2.2-alpha.tar.gz
<b>Size:</b> 6 MB (6,257,177 bytes)
<b>SHA256:</b> 948f82246370eadf2d52a5d1797fa8966e5238d28de5ec69120407f22d59e774
<b>SHA1:</b> ffd6f805fcd7282b8ed3e10343ac705519bdc8f2
<b>MD5:</b> 18f95b54ac0ba733bd83c2a2745761a8
<b>Link:</b> https://www.torproject.org/dist/tor-0.3.2.2-alpha.tar.gz


<b>File Name:</b> tor-0.3.2.2-alpha.tar.gz.asc
<b>Size:</b> 0.8 KB (801 bytes)
<b>SHA256:</b> f5a1bb1087814753f1ade3ba16dfaf8cb7a77475cb9b09c91a56bacf42c35d24
<b>SHA1:</b> 6fd356bcec3d337bf458c9ad784ab148afcbeb30
<b>MD5:</b> a20385bae042b0407737147421e3f426
<b>Link:</b> https://www.torproject.org/dist/tor-0.3.2.2-alpha.tar.gz.asc

-----BEGIN PGP SIGNATURE-----

iQIcBAABAgAGBQJZ0rZPAAoJEGr+5tSekrYBTEUP/1fZxznEkQGwolHbt6+3CRl3
fDJF8z/4a17mHj31uggQB5Y9zGZ+rNOAJxFt7tRZe9qpGmQ9+6leHlKKjER37WFn
3TiqsipVaCFGM3J8FxCHyk1LbwJi2u9QIflkY5/j0h44DQ+QyI1Z3nTeSeF2gN/O
WsyQ9s+xLMfwu8f/VbjVWztKtYNeQuV78pPC9sq+On2VdGo4Lbj4E5jM9RHK9AZ2
oQVIBkanDFGNsJSizJX2Oig7OXM7zbxUy0qcjg6cSNXyvsw80GHzPNaws8yf50Ds
ElC6k2OVJW0orY0pGmZ9HXURQ4+gc81E2xoFX13jrOHMEbZQrRI0B05FCFF7+Fb5
FLUYNQCSasMiiXayh2uaU3F9cpp9p4cTW9I3Z/BZ75UW+k+ox7S81bE+tpKXW7yU
xeHxklYgQhvtt+fKJT7jZW4khD/1sJucjzGCWhdn9PTaRKqhRjd0AiXJYSpg0/bA
02SuhiZW+UasTNaQ72aAk6b3+HLc7fsbWYdcEGouxvc8/sADyDoaJd4a6LUNkFzv
gfg6q47qgucNgEWqi7St5VChKJ22cU9ydDWJOb0G7iFUNGnFFkPuBGVmDoP+0BXu
9NYieLXO8E8SQmN1/hzGCVzR5A3MxLJtfWUppVePNTv2v53BcwOkeTtWxPl7UzNQ
MOC0zwpmB6vQzFgAMtez
=d/lF
-----END PGP SIGNATURE-----

<b>File Name:</b> tor-browser-linux64-7.5a5_en-US.tar.xz
<b>Size:</b> 72 MB (75,076,296 bytes)
<b>SHA256:</b> 8cee4cc0f82463da782cf3e7817e0b72507e6b200b5cccd549fe9f7e77d1d90d
<b>SHA1:</b> 3e041335e2fa45daeb658ac082eac722322d0a73
<b>MD5:</b> 53a696af2bfe7103c7b83d0dd243cd5c
<b>Link:</b> https://www.torproject.org/dist/torbrowser/7.5a5/tor-browser-linux64-7.5a5_en-US.tar.xz

<b>File Name:</b> tor-browser-linux64-7.5a5_en-US.tar.xz.asc
<b>Size:</b> 0.8 KB (801 bytes)
<b>SHA256:</b> f209d9242ca86e6cecebd30611412ffbb8ea489326b74a69244621754a87831c
<b>SHA1:</b> 23620d7c03593b94f1303ba642da6d0738755209
<b>MD5:</b> 5daf333a90e189a16786d08d3aaf6a19
<b>Link:</b> https://www.torproject.org/dist/torbrowser/7.5a5/tor-browser-linux64-7.5a5_en-US.tar.xz.asc

-----BEGIN PGP SIGNATURE-----

iQIcBAABCgAGBQJZyr7hAAoJENFIP6bDwHE2cPMP/1c5PMjuBRAtipry8v+inadB
4S8HpuOFI+vrUoYRo7MadI8KYtrKqtmXK5PWUV7e+bIJW82LBvHZZH7UB52QuX+5
v+woiWxf8Y4CzAWqDHicHJ0Ya5sf6aZk7O7RncwhqXJ0hVlk3kG7kfluLwRzGZFz
XF4eKZE5HG4BuvB/P9ZYykUqHMzn3r2UW8tjMLhxqyWKF77N+/JQ34Ot9n4WJ2Yt
Pbsj8k0xgF/zwXkD4MJA/PIfRY7x/pGv9ns2lcgKhe3MsJIusn9ckx+Q2mtb6KXv
VkjVOKpTZBWuLtezRZv35khji6cTT8oEe2jvAtoib1ZYGyP7y5jwt0l0sRGxVA+l
i92k3Auu98RIrfJtNeca1pyVWfC0jBZBt9aMClRanwqYOCsc/oFhhNEhbMMiOOGr
Y/9kr7JUVkme5bt0Qevjt58X3sFjiEG323KbTEgaf5g5GRvnooD+oVkufNNucSBn
azON7BrkEWQj1DBGd+Vwu5XpR6ezJlXOfJ67Mh+2f6JTlydZi2F2PAiS1kfkLAqO
uib+mHxNogSm6SarDyo1zMWRq4u2Bn0/s5+XmU5uAthWLX11uFdyi9ePy3B9trUZ
jsMpnTWMoW4MhDiMwGl5RRsYtmVCtcTYgut/Z5bbRe0VUQ+uR1lTSsBkP1sAWedz
DWPyb6xyGNMI5kjHOXRI
=xzdk
-----END PGP SIGNATURE-----</pre>
    <p>Compile Tor with ./configure followed by make. On a fresh Ubuntu Server 16.04 system, you'll need to install gcc, libevent-dev, libssl-dev and make.</p>
    <p>Once compiled, create the directory and file /usr/local/etc/tor/torrc. This is the default configuration file location for Tor when built from source. Sample torrcs are available within the src/config/ directory of your compiled Tor installation.</p>
    <p>In order to set up an Onion v3 Hidden Service, add the following to your torrc:</p>
    <pre>HiddenServiceDir /desired/path/to/hidden/service/config
HiddenServiceVersion 3
HiddenServicePort &lt;localport&gt; &lt;server&gt;</pre>
    <p>The HiddenServiceDir can be any folder on your system that Tor will have write access to, although it should be a private area since the keys will be stored here.</p>
    <p>&lt;localport&gt; is the local port that the hidden service is "listening" on, and the &lt;server&gt; is the server where requests to that port will be forwarded to.</p>
    <p>In my case, I have:</p>
    <pre>HiddenServicePort 80 139.162.222.67</pre>
    <p>...which will forward requests to port 80 onto the main JamieWeb server across the internet.</p>
    <p id="deanonymization"><b>Important Note:</b> <i>Forwarding requests to a remote server has a major potential to de-anonymize you if done incorrectly. If your own anonymity is important, it's probably better to run a local web server (eg: forward requests to 127.0.0.1). Please refer to the official Tor documentation since I am in no way qualified to provide advice on running a properly anonymized hidden service. In my case, my own anonymity is not important so it's fine for me to forward requests to an external web server over the internet.</i></p>
    <p>You can theoretically host anything behind a hidden service, including a file server, IRC server, email server, etc.</p>
    <p>You can now run Tor located in src/or/tor. Successful output is as follows:</p>
    <pre>Oct 19 23:58:25.320 [notice] Tor 0.3.2.2-alpha (git-e2a2704f17415d8a) running on Linux with Libevent 2.0.21-stable, OpenSSL 1.0.2g, Zlib 1.2.8, Liblzma N/A, and Libzstd N/A.
Oct 19 23:58:25.320 [notice] Tor can't help you if you use it wrong! Learn how to be safe at https://www.torproject.org/download/download#warning
Oct 19 23:58:25.320 [notice] This version is not a stable Tor release. Expect more bugs than usual.
Oct 19 23:58:25.320 [notice] Read configuration file "/usr/local/etc/tor/torrc".
Oct 19 23:58:25.326 [notice] Scheduler type KIST has been enabled.
Oct 19 23:58:25.326 [notice] Opening Socks listener on 127.0.0.1:9050
Oct 19 23:58:25.000 [notice] Bootstrapped 0%: Starting
Oct 19 23:58:26.000 [notice] Starting with guard context "default"
Oct 19 23:58:26.000 [notice] Bootstrapped 80%: Connecting to the Tor network
Oct 19 23:58:26.000 [notice] Bootstrapped 85%: Finishing handshake with first hop
Oct 19 23:58:27.000 [notice] Bootstrapped 90%: Establishing a Tor circuit
Oct 19 23:58:27.000 [notice] Tor has successfully opened a circuit. Looks like client functionality is working.
Oct 19 23:58:27.000 [notice] Bootstrapped 100%: Done</pre>
    <p>If you have errors relating to communication with directory servers, double check the permissions on your hidden service configuration directory. Both the folder and contained files should only be readable and writable by the owner (user that is running Tor):</p>
    <pre>drwx------ 2 tor tor 4096 Oct 20 00:00 .
drwxr-xr-x 5 tor tor 4096 Oct 19 22:29 ..
-rw------- 1 tor tor   63 Oct 20 00:00 hostname
-rw------- 1 tor tor   64 Oct 18 23:29 hs_ed25519_public_key
-rw------- 1 tor tor   96 Oct 18 23:29 hs_ed25519_secret_key</pre>
    <p>In order to make Tor run at boot, you could set it up as a cronjob or use any other method for starting a program at boot. Don't run Tor as root.</p>
    <p>The "hostname" file  in your hidden service configuration directory contains the hostname for your new Onion v3 hidden service. The other files are your hidden service keys, so it is imperative that these are kept private. If your keys leak, other people can impersonate your hidden service, deeming it compromised, useless and dangerous to visit.</p>
    <h2 id="apacheconfig">Apache Configuration</h2>
    <p>Configuring a local web server for your hidden service is exactly the same as with Onion v2, just make sure that your web server is accessible locally on 127.0.0.1 and everything should work. <b>If your own anonymity is important, make sure that your web server is configured correctly so that it is not going to de-anonymize you.</b></p>
    <p>However, in my setup I am using a remote web server as the forwarding destination for the hidden service. To clarify, my Onion v3 hidden service is running on a separate server to the main JamieWeb server, and the hidden service is forwarding requests across the internet to the main server.</p>
    <p><b>Important Note:</b> <i>Please <a href="#deanonymization">read my note above</a> as there is potentially a major risk of de-anonymization when forwarding requests to a remote server.</i></p>
    <p>Since I have IP address catch-all virtual hosts set up, the request is blocked by default:</p>
    <pre>403 Forbidden - Direct request to IPv4 address (139.162.222.67) blocked. Please use https://www.jamieweb.net instead.</pre>
    <p>In order to get around this, you can simply create a virtual host with the ServerName value set to the Onion address. In my configuration, I have the following (irrelevant lines removed):</p>
    <pre>&lt;VirtualHost 139.162.222.67:80&gt;
    ServerName jamie3vkiwibfiwucd6vxijskbhpjdyajmzeor4mc4i7yopvpo4p7cyd.onion
&lt;/VirtualHost&gt;</pre>
    <p>The request will no longer be blocked, allowing the hidden service to work as normal.</p>
    <h2 id="vanityaddresses">Vanity Addresses</h2>
    <p><b>Edit 7th Jan 2017 @ 12:01am:</b> <i>I have now written an entire blog post about Onion v3 vanity address generation, which you can read <a href="/blog/onionv3-vanity-address" target="_blank">here</a>.</i></p>
    <p>As with my <a href="http://jamiewebgbelqfno.onion" target="_blank" rel="noopener">Onion v2 hidden service</a>, I am very interested in generating a vanity address to use for my site. As of writing this, there are several tools already available for Onion v3 vanity address generation. However, as I did with the Onion v2 address, I am also looking into writing a basic script to perform the cryptography outside of Tor in order to generate addresses automatically. This isn't designed to be a highly efficient program to generate millions of addresses per second, just a basic script that is able to do it faster than a human.</p>
    <p>The script that I wrote for automatically generating Onion v2 addresses was quite inefficient, but was still able to generate ~5 addresses per second. While something like this isn't going to be able to generate a long vanity address in any reasonable timeframe, it's enough to get a few characters and understand the how the cryptography behind it is working.</p>
    <p>With Onion v2 and an efficient CPU/GPU vanity address generation program, an 8 character vanity address is realistically achievable with an average home computer running for around a month. Onion v3 addresses are still Base32, but are 56 characters rather than 16, so the search space is significantly larger. I am going to set my <a href="/projects/computing-stats/" target="_blank">Raspberry Pi cluster</a> to work generating an Onion v3 vanity address straight away!</p>
    <p>I am also interested to see what Facebook are going to do with their <a href="https://facebookcorewwwi.onion" target="_blank" rel="noopener">Onion v2 hidden service</a>. They are one of the few organisations to have an Extended Validation (EV) SSL certificate for their hidden service, so I wonder if DigiCert will issue a new one to them when/if Facebook upgrades to Onion v3?</p>
    <h2 id="conclusion">Conclusion</h2>
    <p>I will be continuing to test the Tor alpha builds with Onion v3. Once they are in a stable release, I'll move it back over to the main JamieWeb server where it can be hosted alongside the existing Onion v2 hidden service (it is possible to host multiple hidden services with a single Tor instance).</p>
    <p>Overall I really like Onion v3, it is a well-needed update to the cryptography behind Tor, and hopefully people will adopt it as soon as possible.</p>
</div>

<?php include "footer.php" ?>

</body>

</html>
