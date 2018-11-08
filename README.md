# jamieweb

[![This project welcomes security reports](https://img.shields.io/badge/This%20project%20welcomes%20security%20reports-hackerone%2ecom%2fjamieweb-brightgreen.svg)](https://hackerone.com/jamieweb)

My personal website, available at:

* Web: https://www.jamieweb.net
* Onion v2: http://jamiewebgbelqfno.onion
* Onion v3: http://jamie3vkiwibfiwucd6vxijskbhpjdyajmzeor4mc4i7yopvpo4p7cyd.onion
* Namecoin: https://www.jamieweb.bit

## HackerOne:

I have a public HackerOne security vulnerability disclosure program for my website. If you would like to search for vulnerabilities or report one, please view the program here: [https://hackerone.com/jamieweb](https://hackerone.com/jamieweb)

Valid submissions will be thanked publicly on my HackerOne program page.

**Please note that my HackerOne program does not provide bounties/rewards as JamieWeb is only a small personal project.**

Thank you!

## IP Addresses:

16th Dec 2017 - Present:

    IPv4: 139.162.222.67
    IPv6: 2a01:7e00:e001:c500::1
    
Historic:

    IPv4: 89.34.99.41
    IPv6: 2a01:4020:1::129
    
* IPv4 Test: https://ipv4.jamieweb.net
* IPv6 Test: https://ipv6.jamieweb.net
* IPv4 Direct (403 Forbidden): http://139.162.222.67
* IPv6 Direct (403 Forbidden): <a href="http://[2a01:7e00:e001:c500::1]">http://[2a01:7e00:e001:c500::1]</a>

## Site Ideas/To-do List:
    Better mobile compatibility
    ✓ - All blog/projects/other pages should now have acceptable levels of mobile readability
    ✓ - Must fix navbar on mobile (doesn't extend to full page width)
    ✓ - Fix homepage sidebar overflow on mobile
      
    Grid/list layout for /projects (same as /info and /other?)
    Raspberry Pi Cluster blog post
    Python & C++ - cycles per second - "tickrate"
    Casio watch mod (N-O-D-E style) - in progress but I am having issues with masking for spray painting!
    Air-gapped RPi PGP decryption device using binary-over-audio
    PHP blog list generation - efficiency? - mod_cache is the solution here most likely
    iptables configuration
    pf configuration
    Chrome sign-in/sync risk
    Homepage quick links
    Search box?
    Malicious links overview/spamtraps
    Link integrity
    KeyChest
    JamieWeb status page, like status.io (Use gh-pages?)
    Tor IPv6
    Next/previous blog post links when on /blog/*? - Tried but looks too 'spammy'
    <noscript> tag neglect
    JamieWeb organisation
    Apache security headers on a per-page basis blog post/guide
    Link to IPv[46] test pages & direct IP links in /other or somewhere easy to access
    Geodiverse hosting?
    Change favicon to identicon
    OpenPGP keyserver? keyserver.jamieweb.net
    Snippets (auto gen list with PHP, store in JSON?)
    
    TLS 1.3 - Waiting for native support in Ubuntu repo Apache package
    HTTP/2 - Waiting for native support in Ubuntu repo Apache package
    tls1.3.jamieweb.net (TLS 1.3 Test Page)
    http2.jamieweb.net (HTTP/2 Test Page)
    brotli.jamieweb.net (Brotli Test Page[?])

    ✓ Git Hosting Service SSH Server Fingerprints
    ✓ Cutter tutorial
    ✓ Travis-CI for website/build integrity checking (CSP checking done, working on blog post)
    ✓ Full-width footer
    ✓ /security - Redirect to /contact#hackerone
    ✓ Homepage rework
    ✓ Improved tag function
    ✓ Add IRC to other/
    ✓ rel="noopener" - All links to different origins now have rel="noopener"
    ✓ Vulnerability disclosure - HackerOne program is now live! https://hackerone.com/jamieweb
    ✓ SCTs and Expect-CT - Waiting for Let's Encrypt SCTs in certificate support, Q1 2018 - 2018-Apr-04 see /blog/letsencrypt-scts-in-certificates/
    ✓ Disable TLS 1.0 and TLS 1.1 support
    ✓ Move all images from /images to their respective content folders (except for 'CDN-appropriate' content)
    ✓ New site-wide font
    ✓ Signed commits with JamieWeb signing key, rather than GitHub key
    ✓ Bitcoin node over Tor, 6poxn47ur5mvxflg2dim6cgozipe7oprcnn3uknoboynvfbbswhordyd.onion & kw7dsbyawemqdxfq.onion, port 8333
    ✓ Navbar/footer account links?
    ✓ New design for Blog Project Other homepage buttons - not a new design in the end, but fixed them with a flexbox
    ✓ humans.txt
    ✓ Onion v3 vanity address blog post
    ✓ Remove all <center> tags (deprecated)
    ✓ DMARC "v=DMARC1; p=reject; rua=mailto:abuse@jamieweb.net; aspf=r; adkim=r;" on _dmarc.jamieweb.net
    ✓ Onion v3 Tor Hidden Service - ~~32zzibxmqi2ybxpqyggwwuwz7a3lbvtzoloti7cxoevyvijexvgsfeid.onion~~ jamie3vkiwibfiwucd6vxijskbhpjdyajmzeor4mc4i7yopvpo4p7cyd.onion
    ✓ Notifications (IFTTT, email, etc) - /notifications (now discontinued)
    ✓ Privacy policy/info
    ✓ Link to GitHub on /projects?
    ✓ Host bunnymod on /downloads
    ✓ IPv6 - (Originally 2a01:4020:1::129, as of 16th Dec 2017 now 2a01:7e00:e001:c500::1)
    ✓ Linux /etc/hosts adblocking - file integrity verification
    ✓ IRC drawing bot blog post
    ✓ Control channel over IRC
    ✓ Grid layout for /other (ended up as a list with icons)
    ✓ SubGraph OS overview
    ✓ Ethereum donation address
    ✓ Tor hidden service mirror - jamiewebgbelqfno.onion
    ✓ Flash/media block checker
    ✓ Advanced AdblockPlus filter syntax
    ✓ Browsing with JavaScript disabled (will be in blog post)
    ✓ Local network device check script
    ✓ Speedrun times in /other
    ✓ AdblockPlus default + custom filters
