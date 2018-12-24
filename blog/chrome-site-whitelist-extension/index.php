<?php include "response-headers.php"; content_security_policy(); ?>
<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/legal-->

<head>
    <title>Chrome Site Whitelist Extension</title>
    <meta name="description" content="Chrome Site Whitelist Extension">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/blog/chrome-site-whitelist-extension/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Chrome Site Whitelist Extension</h1>
    <hr>
    <p><b>Tuesday 7th March 2017</b></p>
    <p>Please see the associated <a href="/projects/chrome-site-whitelist-extension/" target="_blank">project page</a> for download and installation instructions. All code, version history and further information can be found on the <a href="https://github.com/jamieweb/results-whitelist/" target="_blank" rel="noopener">GitHub repository</a>.</p>
    <div class="centertext"><p>-<b><u>The project is early in development so some features are not yet working properly or tested thoroughly.</u></b>-</p></div>
    <p>I recently starting developing a browser extension for Google Chrome. It allows the user to set a list of whitelisted sites that will then be highlighted in Google Search results. The extension icon also changes to green when you are currently browsing a whitelisted site.</p>
    <p>It is designed to be an anti-typosquatting tool and to highlight known trusted sites.</p>
    <h2>What is typosquatting?</h2>
    <p>Typosquatting is a form of phishing, and refers to the malicious registration of domain names that are similar to those of popular websites, with the intent to deceive users into visiting them.</p>
    <p>Typosquatting relies on either one of two things: a user incorrectly typing a URL into the address bar, or a user only glancing at a URL before clicking it.</p>
    <p>Below are a few examples. At first glance they look like legitimate names, but when you look more closely you'll realise that they are phishing names. Use the find tool (Ctrl+F) to determine the true identity of the characters used in the names.</p>
    <pre class="arial">googIe
arnazon
paypaI
lndiegogo
steamcomrnunity
MlCROSOFT</pre>
    <p>As you can see, there are many common combinations of letters that make for a good typosquat, such as replacing an "m" with "rn" or "nn", or replacing an "I" with a "l". Using a fixed-width font is a great way to counter this.</p>
    <p>Another form of phishing domain is when subdomains are used. For example:</p>
    <pre>www.google.com.example.com
www.amazon.com.example.com
steamcommunity.com.example.com</pre>
    <p>To a less experienced user, these may look like the official sites. Instead, they are simply subdomains of a potentially malicious domain.</p>
    <p>Phishing sites may attempt to be a complete clone of the official site, or simply collect account details. A false login form will be presented on the phishing site, the user enters their details, the site logs the entered details but also posts them to the official login form before redirecting the user to the official site. This is a perfect attack, since the phishing site has collected the user account details without raising any sort of suspicion from the user, and they are now browsing the official site like normal.</p>
    <h2>Generating Phishing Domains</h2>
    <p>A particularly interesting tool that I found on GitHub a while ago is <a href="https://github.com/elceef/dnstwist/" target="_blank" rel="noopener">dnstwist</a> by elceef.</p>
    <p>It takes your domain name and generates potential phishing domains, then checks whether they are registered or not. This is useful to help find any existing phishing domains that exist for your site, as well as to find domains to register to protect against typosquatting and phishing.</p>
    <p>Example output (results condensed to 4 per type):</p>
    <pre>jamie@box:~$ ./dnstwist.py jamieweb.net
     _           _            _     _
  __| |_ __  ___| |___      _(_)___| |_
 / _` | '_ \/ __| __\ \ /\ / / / __| __|
| (_| | | | \__ \ |_ \ V  V /| \__ \ |_
 \__,_|_| |_|___/\__| \_/\_/ |_|___/\__| {1.04b}

Processing 264 domain variants ..33%.65%.98% 3 hits (1%)

Original*      jamieweb.net      139.162.222.67
Addition       jamieweba.net     -
Addition       jamiewebb.net     -
Addition       jamiewebc.net     -
Addition       jamiewebd.net     -
Bitsquatting   kamieweb.net      -
Bitsquatting   hamieweb.net      -
Bitsquatting   namieweb.net      -
Bitsquatting   bamieweb.net      -
Homoglyph      jannieweb.net     -
Homoglyph      jami&#234;web.net      -
Homoglyph      jarnieweb.net     -
Homoglyph      jami&#1077;web.net      -
Hyphenation    j-amieweb.net     -
Hyphenation    ja-mieweb.net     -
Hyphenation    jam-ieweb.net     -
Hyphenation    jami-eweb.net     -
Insertion      jami4eweb.net     -
Insertion      jamiewe3b.net     -
Insertion      jamizeweb.net     -
Insertion      jaqmieweb.net     -
Omission       jaieweb.net       -
Omission       jamieeb.net       -
Omission       jamiewb.net       -
Omission       jameweb.net       -
Repetition     jaamieweb.net     -
Repetition     jamiieweb.net     -
Repetition     jammieweb.net     -
Repetition     jjamieweb.net     -
Replacement    jajieweb.net      -
Replacement    jamiewrb.net      -
Replacement    japieweb.net      -
Replacement    j1mieweb.net      -
Subdomain      j.amieweb.net     -
Subdomain      ja.mieweb.net     -
Subdomain      jam.ieweb.net     -
Subdomain      jami.eweb.net     -
Transposition  ajmieweb.net      -
Transposition  jmaieweb.net      -
Transposition  jaimeweb.net      -
Transposition  jameiweb.net      -
Vowel-swap     jameeweb.net      -
Vowel-swap     jamiewib.net      -
Vowel-swap     jumieweb.net      -
Vowel-swap     jamiewob.net      -
Various        wwjamieweb.net    -
Various        wwwjamieweb.net   -
Various        www-jamieweb.net  -
Various        jamiewebnet.net   -</pre>
    <h2>Examples</h2>
    <p>A real-world example of typosquatting is ARNAZON.com. When displayed in lower case (arnazon.com), it looks very similar to the official site name and would likely fool a user should they only glance at it. Arnazon.com is actually owned by Amazon and will simply redirect you to the official Amazon.com site should you visit it.</p>
    <p>I personally do not like it when company-owned typosquat domains simply redirect transparently to the official website. I think that a better approach would be to redirect the user to an informational page informing them of their mistake and the dangers of typosquatting.</p>
    <h2>How does the extension work?</h2>
    <p>A content script is run whenever you load a Google search page. Only google.com and google.co.uk are available by default, however you can easily edit the manifest.json file to add your own prefered Google site. The content script fetches every anchor (hyperlink) tag (&lta&gt) on the page and checks each one individually using a for loop.</p>
    <img class="max-width-100-percent" src="/projects/chrome-site-whitelist-extension/example-result-highlighting.png">
    <p>Quite conveniently, the anchor tags for Google search result links are the only anchors on the page that have a defined href AND no defined class. This makes it easy to filter out everything else, leaving only the Google search result links. The script matches the hostnames of the links to the whitelisted hostnames from the user configuration. If there is a match, the associated search result will be highlighted in green by changing it's CSS properties.</p>
    <p>An additional content script runs on every single page. This simply checks whether the current site that you are browsing is on the whitelist. If it is, the extension icon for the tab is changed to green.</p>
    <img class="max-width-100-percent" src="/projects/chrome-site-whitelist-extension/extension-icon-green.png">
    <h2>Why did I create the extension?</h2>
    <p>I created the extension to help raise user confidence when searching on Google. Even though Google is usually pretty good at filtering out malicious websites and correcting typing errors, bad stuff still gets through. Now there is no need to manually verify every Google search result link clicked, as your manually whitelisted sites will show up in green!</p>
</div>

<?php include "footer.php" ?>

</body>

</html>
