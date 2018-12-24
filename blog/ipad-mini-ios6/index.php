<?php include "response-headers.php"; content_security_policy(); ?>
<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>iPad Mini iOS 6</title>
    <meta name="description" content="iPad Mini iOS 6 Downgrade Without SHSH Blobs is NOT Currently Possible - Dual Boot Instead.">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/blog/ipad-mini-ios6/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>iPad Mini iOS 6 Downgrade Without SHSH Blobs is NOT Currently Possible - Dual Boot Instead</h1>
    <hr>
    <p><b>Tuesday 19th September 2017</b></p>
    <div class="ios6-slider">
    <div class="ios9-slider">
    <textarea readonly cols="0" rows="0" class="ios-slider"></textarea>
    </div>
    </div>
    <p class="centertext two-mar-top"><i>iOS 9 / iOS 6 Home Screen Comparison Slider</i></p>
    <p>As of writing this post, it is not possible to natively downgrade an iPad Mini First Generation to iOS 6.1.3 without SHSH blobs. The only alternative at the moment is to dual-boot iOS 6 with your current OS.</p>
    <p>The iPhone 5, iPad Mini 1st Generation, iPad 4th Generation and iPhone 5c are the only 32 bit devices that did not originally ship with iOS 5 or earlier. This is why the iOS 6.1.3 upgrade is not being signed by Apple for these devices, making it impossible to downgrade to it at the moment unless you have saved SHSH blobs.</p>
    <p>The reason that Apple still signs 6.1.3 and 8.1.4 for some 32 bit devices is that it is not possible to upgrade from iOS 5 directly to the latest version. You have to hop to 6.1.3, then 8.1.4 before being able to upgrade to the latest supported version. Note that the iPhone 5c originally shipped with iOS 7, so it is probably impossible for it to ever run iOS 6 natively.</p>
    <h2>Security</h2>
    <p>The most recent version of iOS 6 is 6.1.3*, which was released on 19th March 2013. This means that there are currently over 4 years of unpatched security vulnerabilities and a lack of all new iOS security features. I highly recommend reading <a href="https://www.apple.com/business/docs/iOS_Security_Guide.pdf" target="_blank" rel="noopener"><sub><sup><sup>[PDF]</sup></sup></sub> Apple's iOS 10 Security White Paper</a> for more information.</p>
    <p><i>*There were 3 further releases of iOS 6 (6.1.4, 6.1.5 and 6.1.6), however these were not released for all devices. They were device-specific bug fix releases for the iPhone 5 and twice for the iPod Touch 4th Generation respectively. Read more <a href="https://en.wikipedia.org/wiki/IOS_6#6.1.4" target="_blank" rel="noopener">here</a>.</i></p>
    <p>Many of the known security vulnerabilities can be mitigated by simply using the device in a highly defensive manner, such as by only visiting known trusted websites, only connecting to trusted Wi-Fi networks, only using disposable online accounts, not reading email, etc. However, there are also numerous remote code execution vulnerabilities that do not require any user interaction what so ever.</p>
    <p>Having an iOS 6 device connected to your Wi-Fi access point is a potential risk to your network and is not recommended.</p>
    <h2>Known Vulnerabilities</h2>
    <p>Below is a list of all of the iOS update security advisories for versions between 6.1.3 and 10.3.3.</p>
    <p>Vulnerabilities that allow for <b>remote code execution (RCE) without user interaction</b>, or vulnerabilities that <b>can not be easily defended against</b> are highlighted.</p>
    <p>To clarify, vulnerabilities are highlighted if they still affect you even if you use the device in a highly defensive manner as described above.</p>
    <p>This list does not include vulnerabilities that require user interaction or for the attacker to be present on your Wi-Fi network.</p>
    <p>The iOS version that they are listed under indicates the version at which they were patched, not the version(s) that they affect.</p>
    <p>Many of these vulnerabilities may have been introduced in versions after iOS 6.1.3, however it should still give you a general idea of the state of iOS 6 security.</p>
    <pre><b>iOS 7</b> ------ <a href="https://support.apple.com/kb/HT5934" target="_blank" rel="noopener">https://support.apple.com/kb/HT5934</a>
<b>iOS 7.0.2</b> -- <a href="https://support.apple.com/kb/HT5957" target="_blank" rel="noopener">https://support.apple.com/kb/HT5957</a>
<b>iOS 7.0.3</b> -- <a href="https://support.apple.com/kb/HT6010" target="_blank" rel="noopener">https://support.apple.com/kb/HT6010</a>
<b>iOS 7.0.4</b> -- <a href="https://support.apple.com/kb/HT6058" target="_blank" rel="noopener">https://support.apple.com/kb/HT6058</a>
<b>iOS 7.0.6</b> -- <a href="https://support.apple.com/kb/HT6147" target="_blank" rel="noopener">https://support.apple.com/kb/HT6147</a>
<b>iOS 7.1</b> ---- <a href="https://support.apple.com/kb/HT6162" target="_blank" rel="noopener">https://support.apple.com/kb/HT6162</a>
<b>iOS 7.1.1</b> -- <a href="https://support.apple.com/kb/HT6208" target="_blank" rel="noopener">https://support.apple.com/kb/HT6208</a>
<b>iOS 7.1.2</b> -- <a href="https://support.apple.com/kb/HT6297" target="_blank" rel="noopener">https://support.apple.com/kb/HT6297</a>
<b>iOS 8</b> ------ <a href="https://support.apple.com/kb/HT6441" target="_blank" rel="noopener">https://support.apple.com/kb/HT6441</a>
&#x2517&#x2501&#x2501 <a href="https://cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2014-4364" target="_blank" rel="noopener">CVE-2014-4364</a> - <b>Credential Theft</b> - An attacker can potentially obtain Wi-Fi credentials by impersonating a trusted access point.
<b>iOS 8.1</b> ---- <a href="https://support.apple.com/kb/HT6541" target="_blank" rel="noopener">https://support.apple.com/kb/HT6541</a>
<b>iOS 8.1.1</b> -- <a href="https://support.apple.com/kb/HT204418" target="_blank" rel="noopener">https://support.apple.com/kb/HT204418</a>
<b>iOS 8.1.2</b> -- <a href="https://support.apple.com/kb/HT204422" target="_blank" rel="noopener">https://support.apple.com/kb/HT204422</a>
<b>iOS 8.1.3</b> -- <a href="https://support.apple.com/kb/HT204245" target="_blank" rel="noopener">https://support.apple.com/kb/HT204245</a>
<b>iOS 8.2</b> ---- <a href="https://support.apple.com/kb/HT204423" target="_blank" rel="noopener">https://support.apple.com/kb/HT204423</a>
&#x2517&#x2501&#x2501 <a href="https://cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2015-1063" target="_blank" rel="noopener">CVE-2015-1063</a> - <b>Denial of Service</b> - A malicious Class 0 (Flash) SMS message can cause the device to crash and restart.
<b>iOS 8.3</b> ---- <a href="https://support.apple.com/kb/HT204661" target="_blank" rel="noopener">https://support.apple.com/kb/HT204661</a>
<b>iOS 8.4</b> ---- <a href="https://support.apple.com/kb/HT204941" target="_blank" rel="noopener">https://support.apple.com/kb/HT204941</a>
&#x2517&#x2501&#x2501 <a href="https://cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2015-3728" target="_blank" rel="noopener">CVE-2015-3728</a> - <b>Man in the Middle</b> - Devices may auto-associate with an untrusted Wi-Fi access point that is advertising a known SSID, but with a downgraded security type.
<b>iOS 8.4.1</b> -- <a href="https://support.apple.com/kb/HT205030" target="_blank" rel="noopener">https://support.apple.com/kb/HT205030</a>
&#x2517&#x2501&#x2501 <a href="https://cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2015-3778" target="_blank" rel="noopener">CVE-2015-3778</a> - <b>Sensitive Information Disclosure</b> - Devices broadcast MAC addresses from previously accessed Wi-Fi networks.
<b>iOS 9</b> ------ <a href="https://support.apple.com/kb/HT205212" target="_blank" rel="noopener">https://support.apple.com/kb/HT205212</a>
<b>iOS 9.0.2</b> -- <a href="https://support.apple.com/kb/HT205284" target="_blank" rel="noopener">https://support.apple.com/kb/HT205284</a>
<b>iOS 9.1</b> ---- <a href="https://support.apple.com/kb/HT205370" target="_blank" rel="noopener">https://support.apple.com/kb/HT205370</a>
<b>iOS 9.2</b> ---- <a href="https://support.apple.com/kb/HT205635" target="_blank" rel="noopener">https://support.apple.com/kb/HT205635</a>
<b>iOS 9.2.1</b> -- <a href="https://support.apple.com/kb/HT205732" target="_blank" rel="noopener">https://support.apple.com/kb/HT205732</a>
<b>iOS 9.3</b> ---- <a href="https://support.apple.com/kb/HT206166" target="_blank" rel="noopener">https://support.apple.com/kb/HT206166</a>
<b>iOS 9.3.1</b> -- <a href="https://support.apple.com/kb/HT206225" target="_blank" rel="noopener">https://support.apple.com/kb/HT206225</a>
<b>iOS 9.3.2</b> -- <a href="https://support.apple.com/kb/HT206568" target="_blank" rel="noopener">https://support.apple.com/kb/HT206568</a>
<b>iOS 9.3.3</b> -- <a href="https://support.apple.com/kb/HT206902" target="_blank" rel="noopener">https://support.apple.com/kb/HT206902</a>
<b>iOS 9.3.4</b> -- <a href="https://support.apple.com/kb/HT207026" target="_blank" rel="noopener">https://support.apple.com/kb/HT207026</a>
<b>iOS 9.3.5</b> -- <a href="https://support.apple.com/kb/HT207107" target="_blank" rel="noopener">https://support.apple.com/kb/HT207107</a>
<b>iOS 10</b> ----- <a href="https://support.apple.com/kb/HT207143" target="_blank" rel="noopener">https://support.apple.com/kb/HT207143</a>
<b>iOS 10.0.1</b> - <a href="https://support.apple.com/kb/HT207145" target="_blank" rel="noopener">https://support.apple.com/kb/HT207145</a>
<b>iOS 10.0.2</b> - <a href="https://support.apple.com/kb/HT207199" target="_blank" rel="noopener">https://support.apple.com/kb/HT207199</a>
<b>iOS 10.0.3</b> - <a href="https://support.apple.com/kb/HT207263" target="_blank" rel="noopener">https://support.apple.com/kb/HT207263</a>
<b>iOS 10.1</b> --- <a href="https://support.apple.com/kb/HT207271" target="_blank" rel="noopener">https://support.apple.com/kb/HT207271</a>
<b>iOS 10.1.1</b> - <a href="https://support.apple.com/kb/HT207287" target="_blank" rel="noopener">https://support.apple.com/kb/HT207287</a>
<b>iOS 10.2</b> --- <a href="https://support.apple.com/kb/HT207422" target="_blank" rel="noopener">https://support.apple.com/kb/HT207422</a>
<b>iOS 10.2.1</b> - <a href="https://support.apple.com/kb/HT207482" target="_blank" rel="noopener">https://support.apple.com/kb/HT207482</a>
<b>iOS 10.3</b> --- <a href="https://support.apple.com/kb/HT207617" target="_blank" rel="noopener">https://support.apple.com/kb/HT207617</a>
&#x2517&#x2501&#x2501 <a href="https://cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2017-2461" target="_blank" rel="noopener">CVE-2017-2461</a> - <b>Denial of Service</b> - A malicious SMS message can cause denial of service (resource consumption).
<b>iOS 10.3.1</b> - <a href="https://support.apple.com/kb/HT207688" target="_blank" rel="noopener">https://support.apple.com/kb/HT207688</a>
&#x2517&#x2501&#x2501 <a href="https://cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2017-6975" target="_blank" rel="noopener">CVE-2017-6975</a> - <b>Remote Code Execution</b> - An attacker within range may be able to execute arbitrary code on the Broadcom Wi-Fi chip.
<b>iOS 10.3.2</b> - <a href="https://support.apple.com/kb/HT207798" target="_blank" rel="noopener">https://support.apple.com/kb/HT207798</a>
<b>iOS 10.3.3</b> - <a href="https://support.apple.com/kb/HT207923" target="_blank" rel="noopener">https://support.apple.com/kb/HT207923</a>
&#x2523&#x2501&#x2501 <a href="https://cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2017-7063" target="_blank" rel="noopener">CVE-2017-7063</a> - <b>Denial of Service</b> - A malicious message possibly delivered by SMS can cause denial of service (memory consumption and application crash).
&#x2517&#x2501&#x2501 <a href="https://cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2017-9417" target="_blank" rel="noopener">CVE-2017-9417</a> - <b>Remote Code Execution</b> - An attacker within range may be able to execute arbitrary on the Broadcom Wi-Fi chip (Broadpwn).</pre>
    <p>When reading through the Apple security advisories, I noticed that there were a lot of vulnerabilities related to UI spoofing/manipulation in Safari, for example <a href="https://cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2013-5152" target="_blank" rel="noopener">CVE-2013-5152</a> and <a href="https://cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2015-5904" target="_blank" rel="noopener">CVE-2015-5904</a>. This reminds me of the Chrome Punycode URL spoofing bug from April 2017, however in the case of MobileSafari it requires you to visit a malicious website that will then spoof the URL, rather than a non-spoofed URL simply looking like the URL of a legitimate website.</p>
    <p>I also wonder how the patch for Broadpwn works. It depends whether the patch actually patches the chip's firmware or is simply an iOS software patch. Perhaps if you upgraded to a version where Broadpwn was patched, but then downgraded back to a version where it is not patched, Broadpwn would still be patched because the change persists in the chip's firmware rather than in iOS itself. That's all just theory, but maybe it's an idea worth putting out there.</p>
    <h2>Conclusion</h2>
    <p>Overall, it was definitely an interesting project however due to the security issues with Wi-Fi and that fact that it is not possible to get iOS 6 running natively, I will probably just stick to using iOS 9.3.5 with the low performance. I only use the iPad Mini as a standalone VoIP client anyway, so the low performance in iOS 9 doesn't cause too much of an issue for me.</p>
    <p>iOS 11 was released to the public today, and the new <a href="https://support.apple.com/kb/HT208112" target="_blank" rel="noopener">iOS 11 security advisory</a> was made available just a few hours ago. I was surprised to see such a small number of patched vulnerabilities. Normally major releases have dozens and dozens of new security patches, whereas iOS 11 has only eight! This could be taken both ways, were fewer vulnerabilities found or are there fewer to find? I guess we'll have to wait and see.</p>
    <p><b>Edit 1st Oct 2017 @ 8:53am:</b> <i>Around a day after the initial release of the new iOS 11 security advisory, Apple updated it with many new vulnerabilities. It still seems to have fewer than the average major release, but my statement about there being "only eight" is definitely not correct anymore.</i></p>
</div>

<?php include "footer.php" ?>

</body>

</html>
