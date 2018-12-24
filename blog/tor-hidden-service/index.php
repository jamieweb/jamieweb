<?php include "response-headers.php"; content_security_policy(); ?>
<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Tor Hidden Service</title>
    <meta name="description" content="Setting up a Tor Hidden Service for JamieWeb">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/blog/tor-hidden-service/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Tor Hidden Service</h1>
    <hr>
    <p><b>Sunday 12th February 2017</b></p>
    <p>Last night I launched a Tor Hidden Service for my site, available at <a href="http://jamiewebgbelqfno.onion" target="_blank" rel="noopener">jamiewebgbelqfno.onion</a>.</p>
    <p>It serves exactly the same content as the main surface web site, nothing has been added or removed. My own anonymity is definitely not the purpose of having a Tor hidden service, it's just for demonstrative/research purposes.</p>
    <div class="centertext"><img width="1000px" src="/blog/tor-hidden-service/tor-browser-jamieweb.png"></div>
    <p>I generated the vanity onion address using <a href="https://github.com/katmagic/Shallot" target="_blank" rel="noopener">Shallot</a> on my Raspberry Pi cluster. I ran the program on all nodes 24/7 for 35 days, and achieved an average hashrate of 1.25 MH/s. I was searching for URLs that matched the following regex pattern:</p>
    <pre>^jamie[234567]\|^jamieweb\|^jamiesca\|^jamieonubuntu</pre>
    <p>The total number of matches for each address pattern:</p>
    <pre>jamie[234567]??????????.onion : 11,765
jamieweb????????.onion        : 2
jamiesca????????.onion        : 1
jamieonubuntu???.onion        : 0</pre>
    <p>As you can see, I found a copious amount of addresses for the ^jamie[234567] search, and very little for the others, which is to be expected.</p>
    <p>I wrote a simple bash script in order to run the program and calculate the hashrate:</p>
    <pre>#!/bin/bash
while true
do
    date=$(date +%d-%m-%Y)
    runtime=$((/usr/bin/time -f %e shallot ^jamie[234567]\|^jamieweb\|^jamiesca\|^jamieonubuntu >> urls-$date.txt) 2>&1)
    attempts=$(tail -n 17 urls-$date.txt | head -n 1 | awk '{print $5}')
    awk 'BEGIN {print sprintf("%.0f",('$attempts' / '$runtime') / 1000)}' > hashrate.txt
done</pre>
    <p>Every time a matching address is found, it will be output to the file for today's date. The hashrate will be outputted to hashrate.txt in KH/s. Shallot then starts again and keeps searching for matching addresses. I used cron to start the script automatically at boot. Use grep to view a list of the addresses that you have found without printing all of the private keys.</p>
    <p>The original vanity onion address that I have been displaying on my homepage for a while now (jamie6boo7fo44ky.onion) unfortunately did not work. When putting the private key into the Tor Hidden Service config, it produced a completely different address. It seems that a few users of Shallot have experienced similar issues with the keys not matching the addresses. I tried a dozen or so other keys that I generated, including those directly before and after jamie6boo, and they all worked fine.</p>
    <p>I am certain that I did not accidentally modify or otherwise change the key for jamie6boo, it was handled in exactly the same way as every other key. I also compared the key to numerous backups, and it had not been changed at all since the original generation. It seems I was just unlucky. :(</p>
    <p>This is a shame, since the name jamie6boo7fo44ky is very easy to remember and also sounds quite goofy. The new address that I chose (jamiewebgbelqfno.onion) is one of one two ^jamieweb addresses that I generated, but unfortunately doesn't have quite the same ring to it as jamie6boo.</p>
    <div class="centertext"><img class="max-width-100-percent" src="/blog/tor-hidden-service/tor-browser-url.png"></div>
    <p>I never expected to find any ^jamieonubuntu addresses, but I thought it might as well be in there just in case I get intensely lucky. Below is an excerpt from the readme for Shallot, showing the estimated amount of time to find vanity addresses of each length on an average 1.5 GHz processor:</p>
    <pre>Vanity Characters : Approximate Generation Time
1  : &lt;1 second
2  : &lt;1 second
3  : &lt;1 second
4  : 2 seconds
5  : 1 minute
6  : 30 minutes
7  : 1 day
8  : 25 days
9  : 2.5 years
10 : 40 years
11 : 640 years
12 : 10,000 years
13 : 160,000 years
14 : 2,600,000 years</pre>
    <p>I extrapolated this to include 15 and 16 characters:</p>
    <pre>15 : 83,200,000 years
16 : 2,662,400,000 years</pre>
    <p>The technical process of generating onion addresses is extremely interesting. First, generate a 1024 bit RSA key pair. Then, find the SHA-1 hash of the DER-encoded ASN.1 public key. Take the first half of this hash (20 out of 40 characters) and convert it into Base32. Add the .onion suffix and you have your address. This can be done manually on your computer by using OpenSSL to generate the key and a <a href="http://www.geocachingtoolbox.com/index.php?page=asciiConversion" target="_blank" rel="noopener">Base32 converter</a>. If done correctly, you should end up with a 16 character address made up only of the lower case letters a-z and numbers 2-7.</p>
    <p>The total number of possible unique onion addresses is 1,208,925,819,614,629,174,706,176. This is simply 32^16. 32 because the Base32 alphabet consists of 32 unique characters (usually a-z and 2-7), and 16 because an onion address is 16 characters long.</p>
</div>

<?php include "footer.php" ?>

</body>

</html>
