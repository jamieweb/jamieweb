<?php include "response-headers.php"; content_security_policy(["script-src" => "'self'", "require-sri-for" => "script"]); ?>
<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Lookalike Domains</title>
    <meta name="description" content="Contact Information">
    <?php include "head.php" ?>
    <link href="lookalike-domains-test.css" rel="stylesheet">
    <link href="https://www.jamieweb.net/apps/lookalike-domains-test/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Lookalike Domain Name Test</h1>
    <hr>
    <p>This app is designed to test your ability to quickly spot potential lookalike domains, which may be used in typosquatting or phishing attacks.</p>
    <p>A selection of well-known websites will be shown, with a random permutation applied to each one. Glance at the domain, then click either 'Real' or 'Lookalike'. <a href="#what-are-lookalike-domain-names">Read more...</a></p>
    <hr>
    <?php include "lookalike.html" ?>
    <script src="lookalike-domains-test.js" integrity="sha384-PCCWbBnQRkcTkpyxLGiE/cHP59k0eimC5MLmUDujpwdCr3rKjcmnET5QstKOFgA4"></script>
    <hr>

    <h2 id="what-are-lookalike-domain-names">What are lookalike domain names?</h2>
    <p>Lookalike domain names, also known as 'cousin domains' or 'doppelganger domains', are a common technique used by internet scammers to make phishing websites look more convincing. They are domain names that are just a few characters different to a legitimate site, for example by swapping letters around or substituting common characters.</p>
    <p>A real-world example of a lookalike domain is <b>arnazon.com</b>. At first glance this looks like the official Amazon website, but if you look closely you'll see that the '<code>m</code>' has been replaced with '<code>rn</code>'. Luckily in this case, the lookalike domain is actually owned by Amazon.</p>

    <h2 id="do-lookalike-domain-names-pose-a-real-risk">Do lookalike domain names pose a real risk?</h2>
    <p>Yes, lookalike domains are regularly used to conduct phishing and scams, and there have been numerous large profile attacks in the past which utilised lookalike domains.</p>
    <p>For example, in 2019 <a href="https://research.checkpoint.com/2019/incident-response-casefile-a-successful-bec-leveraging-lookalike-domains/" target="_blank" rel="noopener">$1,000,000 was stolen from a Chinese venture capital firm</a> by attackers who used lookalike domains to send fraudulent emails and intercept an existing conversation about seed funding for an Israeli startup. The attackers were eventually able to trick the VC firm into transferring the money to the attackers' bank account, rather than to the intended recipient of the funds.</p>
    <p>Lookalike domains have also been <a href="https://news.netcraft.com/archives/2014/06/25/steam-phishing-attacks-exploiting-look-alike-domain-names.html" target="_blank" rel="noopener">used many times to conduct phishing attacks against users of Steam</a>, resulting in stolen accounts and virtual items being turned into real money by scammers.</p>

    <h2 id="how-can-lookalike-domain-names-be-spotted">How can lookalike domain names be spotted?</h2>
    <p>As an end-user, it is unfortunately not easy in many cases to identify a lookalike domain, as depending on the text size or font used, they can be visually identical to the real thing.</p>
    <p>Unless you resort to carefully analysing each character, your best bet is to simply avoid clicking a suspicious link all together. If the link destination is important enough to you, there will almost certainly be another way to get there, for example by searching for the content you want using a search engine or using a saved bookmark.</p>
    <p>If you are a website operator and want to search for potential lookalike domains that may be impacting your business, you can use a tool such as <a href="https://dnstwister.report/" target="_blank" rel="noopener">dnstwister.report</a> or the <a href="https://holdintegrity.com/checker" target="_blank" rel="noopener">Hold Integrity IDN checker</a>.</p>

    <h2 id="what-are-some-other-types-of-lookalike-domain-names">What are some other types of lookalike domain names?</h2>
    <p>Some phishing sites use subdomains or file paths to make a particular URL look more legitimate. In the examples below, the actual authoritative domain is written in bold, but it's easy to see how these could be mistaken as the real site if they are only glanced at:</p>
    <pre>www.apple.com-page1.index.php.<b>scamsite.invalid</b>
<b>scamsite.invalid</b>/www.google.com/search/index.php</pre>
    <p>Other phishing sites may use the <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Authentication#Access_using_credentials_in_the_URL" target="_blank" rel="noopener">HTTP basic authentication username and password</a> in order to make a URL look more convincing. This is a historic specification allowing for users to authenticate to websites by specifying a username and password either in a login prompt or directly in the URL. It is rarely used on modern websites, but can make phishing URLs look more like the real thing:</p>
    <pre>www.twitter.com:password@<b>scamsite.invalid</b>
www.microsoft:com@<b>scamsite.invalid</b></pre>
    <p>The worst type of lookalike domain name is an <a href="https://en.wikipedia.org/wiki/IDN_homograph_attack" target="_blank" rel="noopener">IDN (Internationalised Domain Name) homograph attack</a>. This is where similar-looking characters from alternate alphabets or writing scripts are used, for example using the Cyrillic '&#x430;' character to replace a Latin 'a' (they are visually identical), or a Greek '&#x3bf;' (Omicron) to replace a Latin 'o'.</p>
    <p>A famous example of an IDN homograph domain name was <a href="https://www.xudongz.com/blog/2017/idn-phishing/" target="_blank" rel="noopener">created by security researcher Xudong Zheng</a>, who registered a proof-of-concept lookalike domain for 'apple.com' using Cyrillic characters. The Google Chrome browser has now implemented protections for this, by preventing IDNs from displaying if they contain characters from more than one alphabet.</p>

    <h2 id="how-can-lookalike-domain-names-be-prevented">How can lookalike domain names be prevented?</h2>
    <p>If you want to prevent domain names that are similar to your own from being registered, your only real option is to register them yourself. This technique, known as 'defensive registration', is very commonly used by large organisations to prevent scammers from registering lookalike domains that may be used for fraudulent activity against their customers and staff.</p>
    <p>In order to identify the best lookalike domain names to register, you could use a tool such as <a href="https://github.com/elceef/dnstwist" target="_blank" rel="noopener">dnstwist</a> in order to apply random permutations to your domain, and identify good candidates for defensive registration (or possibly lookalike domains that have already been registered). An online version of dnstwist with support for email notifications is available at <a href="https://dnstwister.report/" target="_blank" rel="noopener">dnstwister.report</a>.</p>
    <p>The UK Ministry of Justice have <a href="https://ministryofjustice.github.io/security-guidance/guides/defensive-domain-registration/" target="_blank" rel="noopener">published some well-written and balanced guidance on defensive registration</a>, including the protective measures that should be applied to domain names that are registered defensively, such as SPF and DMARC. This is primarily intended to be internal guidance, however it is still very useful for other domains too.</p>
    <p>If you've identified that a lookalike domain name exists for your organisation, your options for taking ownership of the domain or otherwise shutting it down vary massively depending on the domain in question and your own legal circumstances.</p>
    <p>If you own a trademark for the domain (or very similar to it), or are able to prove reputational/financial losses as a result of the lookalike domain, you may be able to claim ownership of the domain via the registry dispute resolution process. This process varies massively depending on the domain registry in question, and in many cases can result in significant legal costs (especially if the owner of the lookalike domain is non-cooperative).</p>
    <p>If the lookalike domain is being used to carry out phishing, scams or other fraudulent activity, it is definitely worth reporting the domain to online malware/phishing reporting services such as <a href="https://safebrowsing.google.com/safebrowsing/report_general/" target="_blank" rel="noopener">Google Safe Browsing</a> or <a href="https://report.netcraft.com/report" target="_blank" rel="noopener">Netcraft</a>. This may result in the domain been de-listed in search engines, flagged with a scam warning or deleted all together.</p>
    <p>If you do not own a trademark for the domain and the lookalike domain isn't carrying out any activity that may negatively impact your business, it is unlikely that you'll be able to take ownership of it in most cases. If you really want the domain, keep an eye on the expiry date via WHOIS, as these domains are often left to expire. Make sure to use the official WHOIS servers, not a third-party one provided by a domain registrar, as in some cases domain registrars may detect this activity and increase the sale price, etc.</p>
    <p>If the lookalike domain is parked by a large domain sales company, the listed price will usually be far above what the domain is actually worth. Generally you'll be able to get at least 50% off by haggling, however this is a risky process since as soon as they know you are interested in the domain, they will usually try to keep the price as high as possible. Be smart, research domain sales/haggling techniques before-hand, and decide how much you are prepared to pay before making your first offer.</p>
    <p>Finally, if the lookalike domain is owned by an innocent individual or legitimate small business, you may wish to just let them keep it. You'll obviously have to assess this decision yourself on a case-by-case basis, but domain names matter far less than they used to nowadays, as most visitors are probably accessing your services via search engine results, saved bookmarks or shared links - not by typing URLs directly.</p>
</div>

<div class="centertext">
    <h5 class="license">This page is licensed under a <a href="https://creativecommons.org/licenses/by-sa/4.0/" target="_blank" rel="noopener">Creative Commons Attribution-ShareAlike 4.0 International License</a>.</h5>
</div>

<?php include "footer.php" ?>

</body>

</html>
