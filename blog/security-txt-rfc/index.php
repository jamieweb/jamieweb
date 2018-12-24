<?php include "response-headers.php"; content_security_policy(); ?>
<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>security.txt Internet Draft</title>
    <meta name="description" content="security.txt allows website owners to outline vulnerability disclosure policies in a simple TXT file format.">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/blog/security-txt-rfc/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>security.txt Internet Draft</h1>
    <hr>
    <p><b>Tuesday 26th December 2017</b></p>
    <p>Security.txt allows web service owners to outline security vulnerability disclosure policies in a simple and easily accessible .txt file format by hosting a security.txt file on their web server, file system or with their project.</p>
    <p>It is currently an <a href="https://en.wikipedia.org/wiki/Internet_Draft" target="_blank" rel="noopener">Internet Draft</a> that has been submitted to the <a href="https://www.ietf.org/" target="_blank" rel="noopener">IETF</a> (Internet Engineering Task Force) for <a href="https://en.wikipedia.org/wiki/Request_for_Comments" target="_blank" rel="noopener">RFC</a> (Request for Comments) review.</p>
    <p><b><u>Please note that this article is about version 01 of the security.txt internet draft, as that was the latest version at the time of writing. Newer versions have now been released with changes, so please see <a href="https://securitytxt.io/" target="_blank" rel="noopener">securitytxt.io</a> for the latest version.</u></b></p>
    <p><b>Skip to Section:</b></p>
    <pre><b>security.txt Internet Draft</b>
&#x2523&#x2501&#x2501 <a href="#introduction">Introduction</a>
&#x2523&#x2501&#x2501 <a href="#headers">Header Fields</a>
&#x2523&#x2501&#x2501 <a href="#chrome-extension">Chrome Extension</a>
&#x2523&#x2501&#x2501 <a href="#file-location">File Location For Websites</a>
&#x2523&#x2501&#x2501 <a href="#robots-txt">robots.txt Inclusion</a>
&#x2523&#x2501&#x2501 <a href="#conclusion">Conclusion</a>
&#x2517&#x2501&#x2501 <a href="#references">References</a></pre>
    <h2 id="introduction">Introduction</h2>
    <img width="1000px" src="/blog/security-txt-rfc/security-txt-website-header.png">
    <p class="two-no-mar centertext"><i>The header of the official website for security.txt: <a href="https://securitytxt.org/" target="_blank" rel="noopener">https://securitytxt.org/</a></i></p>
    <p class="no-mar-bottom">Abstract:</p>
    <p class="two-no-mar font-twenty-three"><i>&ldquo;When security risks in web services are discovered by independent security researchers who understand the severity of the risk, they often lack the channels to properly disclose them. As a result, security issues may be left unreported. Security.txt defines a standard to help organizations define the process for security researchers to securely disclose security vulnerabilities.&rdquo;</i></p>
    <p class="two-mar-top centertext"><i>Source: <a href="https://tools.ietf.org/html/draft-foudil-securitytxt-01" target="_blank" rel="noopener">https://tools.ietf.org/html/draft-foudil-securitytxt-01</a></i></p>
    <p>According to the <a href="https://tools.ietf.org/id/draft-foudil-securitytxt-01.txt" target="_blank" rel="noopener">latest draft</a> (as of writing this post), security.txt is a standard UTF-8 encoded .txt file that consists of various fields that contain information for security researchers who may wish to disclose a security vulnerability.</p>
    <p>The file is comparable to <sub><sup><sup>[HTTP]</sup></sup></sub><a href="http://www.robotstxt.org/" target="_blank" rel="noopener">robots.txt</a>, however it is primarily designed for human rather than robot consumption, although it's simplicity means that it is also very machine-friendly.</p>
    <p>I first came across the original <a href="https://tools.ietf.org/html/draft-foudil-securitytxt-00" target="_blank" rel="noopener">security.txt Internet Draft</a> back in September and thought it looked interesting, however an <a href="https://tools.ietf.org/html/draft-foudil-securitytxt-01" target="_blank" rel="noopener">updated version</a> of the draft has now been released and it seems to have been getting much more attention recently.</p>
    <p><b>Edit 28th Dec 2017 @ 7:18pm:</b> <i>Version 02 of the draft specification was released just a day after I published this blog post. Version 02 is available <a href="https://tools.ietf.org/html/draft-foudil-securitytxt-02" target="_blank" rel="noopener">here</a> and a diff between version 01 and version 02 is <a href="https://tools.ietf.org/rfcdiff?difftype=--hwdiff&url2=draft-foudil-securitytxt-02.txt" target="_blank" rel="noopener">here</a>. There are few changes between versions 01 and 02, the addition of the "Policy" header field being the only major one. I have added inline edits to this blog post in order to add details on the newly released draft specification version 02.</i></p>
    <p>A valid security.txt file could look like the following example:</p>
    <pre>Contact: security@example.com
Contact: https://example.com/contact#security
Encryption: https://example.com/pgp.asc
Acknowledgement: https://example.com/bug-bounty/hall-of-fame
Signature: https://example.com/.well-known/security.txt.sig</pre>
    <p>This would inform security researchers that:</p>
    <ul>
        <li>"security@example.com" is the preferred contact method, however "https://example.com/contact" contains an alternate method.</li>
        <li>Researchers can (and should) encrypt their report using the specified encryption key at "https://example.com/pgp.asc".</li>
        <li>Valid submissions may be acknowledged/thanked at "https://example.com/bug-bounty/hall-of-fame".</li>
        <li>The integrity of the security.txt file can be verified using the signature of a trusted identity.</li>
    </ul>
    <p>The security.txt file should be located in the /.well-known/ directory for web properties, and in the root as .security.txt for file systems and version control repositories.</p>
    <p>For example, all of the following are valid paths for security.txt as per draft version 01:</p>
    <pre>      <b>(Sub)Domain Name:</b> https://www.jamieweb.net/.well-known/security.txt
 <b>IPv4 Address (Public):</b> http://203.0.113.1/.well-known/security.txt
<b>IPv4 Address (Private):</b> http://192.168.0.1/.well-known/security.txt
 <b>IPv6 Address (Public):</b> http://[2001:DB8::1234:1]/.well-known/security.txt
<b>IPv6 Address (Private):</b> http://[fd00::1234:1]/.well-known/security.txt
  <b>Version Control Repo:</b> https://github.com/jamieweb/results-whitelist/tree/master/.security.txt
            <b>FTP Server:</b> ftp://ftp.example.com/.security.txt
 <b>Unix-like File System:</b> /.security.txt
   <b>Windows File System:</b> C:\.security.txt
     <b>Windows SMB Share:</b> \\exampleserver\.security.txt</pre>
    <p>A security.txt file generator is available on the security.txt website, where you can enter your variables and it will generate and offer a file for download. This really isn't needed though, since the format is extremely simple and it's probably easier to create one by hand.</p>
    <div class="centertext"><img class="max-width-100-percent" width="800px" src="/blog/security-txt-rfc/security-txt-org-generator.png"></div>
    <h2 id="headers">Header Field Specification</h2>
    <p>The draft specification outlines 4 different header fields that can all optionally be included in your security.txt file. Excluding only the "Signature" header, you can mix and match them as much as you like - you can use the headers in any order and any number of times each, making security.txt as flexible and extensible as possible.</p>
    <p>Version 01 of the draft outlines the following 4 header fields:</p>

    <p><b>Contact:</b></p>
    <p>The "Contact" header field is used to specify contact details for security researchers to use to disclose security vulnerabilities. The "Contact" header is the only mandatory field in security.txt:</p>
    <pre class="scroll-small">2.3.  Contact:

   Add an address that researchers MAY use for reporting security
   issues.  The value can be an email address, a phone number and/or a
   security page with more information.  The "Contact:" directive MUST
   always be present in a security.txt file.  URIs SHOULD be loaded over
   HTTPS.  Security email addresses SHOULD use the conventions defined
   in section 4 of [RFC2142], but there is no requirement for this
   directive to be an email address.

   The precedence is in listed order.  The first field is the preferred
   method of contact.  In the example below, the e-mail address is the
   preferred method of contact.

   &lt;CODE BEGINS&gt;
   Contact: security@example.com
   Contact: +1-201-555-0123
   Contact: https://example.com/security
   &lt;CODE ENDS&gt;</pre>
    <p class="two-no-mar centertext"><i>Source: <a href="https://tools.ietf.org/html/draft-foudil-securitytxt-01#section-2-3" target="_blank" rel="noopener">https://tools.ietf.org/html/draft-foudil-securitytxt-01#section-2-3</a></i></p>
    <div class="centertext"><sup><p class="no-mar-top"><i>Code Component: Copyright &copy; IETF Trust and the persons identified as authors of the code. All rights reserved.</i></p></sup></div>
    <p>The "Contact" field can be either an email address, phone number or link to a page with further information. For email addresses, an <a href="https://tools.ietf.org/html/rfc2142#section-4" target="_blank" rel="noopener">RFC2142</a> security contact email address should be used, which would generally be "security@domain.tld".</p>

    <p><b>Encryption:</b></p>
    <p>The "Encryption" field allows you to add a link to an encryption key that researchers can use for communication. This is highly recommended since vulnerability disclosures may contain highly confidential information.</p>
    <pre class="scroll-small">2.4.  Encryption:

   This directive allows you to add your key for encrypted
   communication.  You MUST NOT directly add your key.  The value MUST
   be a link to a page which contains your key.  Keys SHOULD be loaded
   over HTTPS.

   &lt;CODE BEGINS&gt;
   Encryption: https://example.com/pgp-key.txt
   &lt;CODE ENDS&gt;</pre>
    <p class="two-no-mar centertext"><i>Source: <a href="https://tools.ietf.org/html/draft-foudil-securitytxt-01#section-2-4" target="_blank" rel="noopener">https://tools.ietf.org/html/draft-foudil-securitytxt-01#section-2-4</a></i></p>
    <div class="centertext"><sup><p class="no-mar-top"><i>Code Component: Copyright &copy; IETF Trust and the persons identified as authors of the code. All rights reserved.</i></p></sup></div>
    <p>I am personally linking directly to my <a href="/jamie-scaife.asc" target="_blank">PGP key</a>, however I have also seen other people linking to their <a href="https://keybase.io/" target="_blank" rel="noopener">Keybase</a> profiles as well as directly to their keys on Keybase. I imagine you could also provide a link to your key on a public keyserver.</p>

    <p><b>Signature:</b></p>
    <p>The "Signature" field allows you to add the signature of your security.txt file, either linked or in-line.</p>
    <pre class="scroll-small">2.5.  Signature:

   In order to ensure the authentic[i]ty of the security.txt file one
   SHOULD use the "Signature:" directive, which allows you to link to an
   external signature or to directly include the signature in the file.
   External signature files should be named "security.txt.sig" and also
   be placed under the /.well-known/ path.

   Here is an example of an external signature file.

   &lt;CODE BEGINS&gt;
   Signature: https://example.com/.well-known/security.txt.sig
   &lt;CODE ENDS&gt;

   Here is an example inline signature.

   &lt;CODE BEGINS&gt;
   Signature:
   -----BEGIN PGP SIGNATURE-----

   ...
   -----END PGP SIGNATURE-----
   &lt;CODE ENDS&gt;</pre>
    <p class="two-no-mar centertext"><i>Source: <a href="https://tools.ietf.org/html/draft-foudil-securitytxt-01#section-2-5" target="_blank" rel="noopener">https://tools.ietf.org/html/draft-foudil-securitytxt-01#section-2-5</a> (Square Brackets Mine)</i></p>
    <div class="centertext"><sup><p class="no-mar-top"><i>Code Component: Copyright &copy; IETF Trust and the persons identified as authors of the code. All rights reserved.</i></p></sup></div>
    <p>There is nothing in the draft that specifies which key should be used to sign the file, however it would perhaps make sense to use the same key as specified in your "Encryption" field if applicable.</p>

    <p><b>Acknowledgement:</b></p>
    <p>The "Acknowledgement" field allows you to a vulnerability disclosure "hall-of-fame", where researchers are thanked for their work.</p>
    <pre class="scroll-small">2.6.  Acknowledgement:

   This directive allows you to link to a page where security
   researchers are recognized for their reports.  The page should list
   individuals or companies that disclosed security vulnerabilities and
   worked with you to remediate the issue.

   &lt;CODE BEGINS&gt;
   Acknowledgement: https://example.com/hall-of-fame.html
   &lt;CODE ENDS&gt;

   Example security acknowledgements page:

   We would like to thank the following researchers:

   (2017-04-15) Frank Denis - Reflected cross-site scripting
   (2017-01-02) Alice Quinn  - SQL injection
   (2016-12-24) John Buchner - Stored cross-site scripting
   (2016-06-10) Anna Richmond - A server configuration issue</pre>
<p class="two-no-mar centertext"><i>Source: <a href="https://tools.ietf.org/html/draft-foudil-securitytxt-01#section-2-6" target="_blank" rel="noopener">https://tools.ietf.org/html/draft-foudil-securitytxt-01#section-2-6</a></i></p>
    <div class="centertext"><sup><p class="no-mar-top"><i>Code Component: Copyright &copy; IETF Trust and the persons identified as authors of the code. All rights reserved.</i></p></sup></div>
    <p>I have seen people linking directly to their HackerOne program's thank-you page, however any format is acceptable.</p>
    <p>Comments can also be included in security.txt by prefixing lines with a hash symbol (#).</p>
    <p><b>Edit 28th Dec 2017 @ 7:26pm:</b> <i>Just one day after publishing this blog post, version 02 of the draft specification was released. This added details on the "Policy" header, which can be used to point researchers in the direction of your security/disclosure policy page. You can read the draft specification for the "Policy" header <a href="https://tools.ietf.org/html/draft-foudil-securitytxt-02#section-2.6" target="_blank" rel="noopener">here</a>.</i></p>

    <h2 id="chrome-extension">Chrome Extension</h2>
    <p>There is also an official Google Chrome/Chromium extension for security.txt, which will automatically scan the website that you are currently browsing for a security.txt file.</p>
    <p>The extension can be <a href="https://github.com/securitytxt/chrome-extension" target="_blank" rel="noopener">downloaded from the GitHub repository</a> and installed manually. It is not available on the Chrome Web Store (I prefer it this way since then you can see what you're getting <b>before</b> you actually install it).</p>
    <img width="1000px" src="/blog/security-txt-rfc/security-txt-extension-installed.png">
    <p>The current version of the extension searches for the file at both /security.txt and /.well-known/security.txt, as seen in the code for this version <a href="https://github.com/securitytxt/chrome-extension/blob/474ecc225fddc9d982deda939e75208a8b57e9ac/Security-txt/scripts/background.js#L82" target="_blank" rel="noopener">here</a>.</p>
    <p>The colour of the extension icon changes to green when a security.txt policy is detected on the current website, and you can click on the icon to see the policy:</p>
    <img width="1000px" src="/blog/security-txt-rfc/security-txt-extension-green.png">
    <p>Sites where no security.txt file can be found display a bright red icon instead.</p>
    <p>There are no configurable options for the current version of the extension (not a bad thing, there really doesn't need to be).</p>

    <h2 id="file-location">File Location for Websites</h2>
    <p>The draft specification outlines the standard file name and location for both web properties as well as file systems and version control repositories, however for now I am focusing on web properties.</p>
    <p>Version 00 of the draft states that the security.txt file should be at the root of the web server:</p>
    <pre>2.  The Specification

   Security.txt is a text file located in the website's top-level
   directory.</pre>
    <p class="two-mar-top centertext"><i>Source: <a href="https://tools.ietf.org/html/draft-foudil-securitytxt-00#section-2" target="_blank" rel="noopener">https://tools.ietf.org/html/draft-foudil-securitytxt-00#section-2</a></i></p>
    <p>However in draft version 01, this was changed to the /.well-known/ directory on a web server:</p>
    <pre>3.1.  Web-based services

   Web-based services SHOULD place the security.txt file under the
   /.well-known/ path; e.g. https://example.com/.well-known/
   security.txt.</pre>
    <p class="two-mar-top centertext"><i>Source: <a href="https://tools.ietf.org/html/draft-foudil-securitytxt-01#section-3.1" target="_blank" rel="noopener">https://tools.ietf.org/html/draft-foudil-securitytxt-01#section-3.1</a></i></p>
    <p>It is important to know that these directories are not an absolute requirement of the draft standard, as the <a href="https://tools.ietf.org/html/rfc2119#section-3" target="_blank" rel="noopener">RFC2119</a> term "SHOULD" is used.</p>
    <p>I have seen a couple of large and reputable sources still using the original draft spec rather than the newer one, and I personally agree with them. I think that the file is far better suited to being in the root of the web server rather than in the .well-known folder.</p>
    <p>There are <a href="https://www.iana.org/assignments/well-known-uris/well-known-uris.xhtml" target="_blank" rel="noopener">plenty of uses</a> for the .well-known directory, however for this application it just seems to make it unnecessarily clunky and adds extra complication to the setup. I know that it's literally just creating a folder, however for many systems even this could be difficult. For example certain content management systems or web hosting interfaces may restrict access to the .well-known folder or disallow file/folder names with dots. For technical users these issues should be easy to overcome, however security.txt should be as accessible and easy as possible.</p>
    <p>On JamieWeb, I am hosting the file at both locations:</p>
    <pre>https://www.jamieweb.net/.well-known/security.txt
https://www.jamieweb.net/security.txt</pre>
    <p>I was originally going to add a 301 redirect from /security.txt to /.well-known/security.txt, however I realised that this is not ideal for scrapers/bots since if they don't follow redirects, they'd just get the 301 redirect itself rather than the actual security.txt destination:</p>
    <pre>&lt;!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN"&gt;
&lt;html&gt;&lt;head&gt;
&lt;title&gt;301 Moved Permanently&lt;/title&gt;
&lt;/head&gt;&lt;body&gt;
&lt;h1&gt;Moved Permanently&lt;/h1&gt;
&lt;p&gt;The document has moved &lt;a href="https://www.jamieweb.net/.well-known/security.txt"&gt;here&lt;/a&gt;.&lt;/p&gt;
&lt;/body&gt;&lt;/html&gt;</pre>
    <p>Instead, I simply created a hard link using ln:</p>
    <pre>jamie@box:~/path/to/website/root$ sudo ln .well-known/security.txt security.txt</pre>
    <p>Now I only have to edit one file to update the "files" at both paths, and they can still be read and modified as though they are distinct.</p>
    <p>It is also worth noting that security.txt for web properties is not exclusive to traditional domain names, you can also use it for IP addresses and subdomains.</p>

    <h2 id="robots-txt">robots.txt Inclusion</h2>
    <p>In order to tell well-behaved bots to index your security.txt file, use the following syntax for your robots.txt file:</p>
    <pre>User-agent: *
Allow: /.well-known/security.txt</pre>

    <h2 id="conclusion">Conclusion</h2>
    <p>I have added a security.txt for my website and many others have too. I really hope it catches on as much as robots.txt did and it might be a step towards solving the problem of difficult vulnerability disclosure.</p>
    <p>One interesting idea that I had is a security.txt aggregator. One of these may already exist however I'm sure in the future there will be a resource somewhere that scrapes the web and publishes a public list of websites that have security.txt policies. This would be a great way for white-hats to find sites to research on. Perhaps website owners or members of the public could also submit links to security.txt files to add them to the list.</p>
    <p><b>Edit 25th Feb 2018 @ 10:46pm:</b> <i>A security.txt aggregator now exists! See <a href="https://securitytext.org/" target="_blank" rel="noopener">securitytext.org</a> by <a href="https://twitter.com/AustinHeap" target="_blank" rel="noopener">@AustinHeap</a>.</i></p>
    <p>Another idea that I had for the security.txt specification is to add a "Scope" header field, which would outline the systems that are in-scope of the vulnerability disclosure policy/bug bounty program. I am aware that security.txt already kind-of answers this by stating:</p>
    <pre>A security.txt file only applies to the domain, subdomain, IPv4 or IPv6 address it is located in.</pre>
<p class="two-mar-top centertext"><i>Source: <a href="https://tools.ietf.org/html/draft-foudil-securitytxt-01#section-2" target="_blank" rel="noopener">https://tools.ietf.org/html/draft-foudil-securitytxt-01#section-2</a></i></p>
    <p>...however, this applies more to the use scope of the contact details rather than researcher activity. Ultimately, security.txt is a disclosure policy rather than a researching policy, so my idea for a "Scope" header perhaps isn't really applicable.</p>
    <p><b>Edit 28th Dec 2017 @ 7:30pm:</b> <i>Just one day after publishing this blog post, version 02 of the draft specification was released. This added details on the "Policy" header, which I described above. This field kind of satisfies my idea for a "Scope" header, since you can link directly to a security/disclosure policy page which will likely include a scope and/or asset list.</i></p>
    <p>A final interesting idea of mine is to add support for Bitmessage addresses in the "Contact" field. The reason I suggest Bitmessage and not other "chat" applications is that the decentralized and secure nature of Bitmessage covers the "Encryption" part as well as the contact method. The encryption used by Bitmessage is completely in control of the user, unlike various other chat applications which provide a managed encryption service which is mostly transparent to the user. Again, there is a good chance that this wouldn't be suitable for the official standard however it is definitely interesting to discuss.</p>

    <h2 id="references">References</h2>
    <ul class="spaced-list">
        <li><a href="https://tools.ietf.org/id/draft-foudil-securitytxt-00.txt" target="_blank" rel="noopener">security.txt Internet Draft Version 00 (Sep 10th 2017)</a></li>
        <li><a href="https://tools.ietf.org/id/draft-foudil-securitytxt-01.txt" target="_blank" rel="noopener">security.txt Internet Draft Version 01 (Dec 3rd 2017)</a></li>
        <li><a href="https://tools.ietf.org/rfcdiff?difftype=--hwdiff&url2=draft-foudil-securitytxt-01.txt" target="_blank" rel="noopener">Diff Between The Two Versions</a></li>
        <li><a href="https://securitytxt.org/" target="_blank" rel="noopener">security.txt Website</a></li>
        <li><a href="https://github.com/securitytxt/security-txt" target="_blank" rel="noopener">security.txt GitHub Repository</a></li>
        <li><a href="https://github.com/securitytxt/chrome-extension" target="_blank" rel="noopener">security.txt Chrome Extension GitHub Repository</a></li>
        <li><a href="/.well-known/security.txt" target="_blank">JamieWeb security.txt File</a></li>
        <li><a href="https://twitter.com/x0rz/status/906962345439657986" target="_blank" rel="noopener">x0rz on Twitter: "Draft RFC for security.txt..."</a></li>
        <li><sub><sup><sup>[HTTP]</sup></sup></sub><a href="http://www.robotstxt.org/" target="_blank" rel="noopener">robots.txt Website</a></li>
        <li><a href="https://developers.google.com/search/reference/robots_txt" target="_blank" rel="noopener">Google Developers robots.txt Specification Reference</a></li>
    </ul>
</div>

<?php include "footer.php" ?>

</body>

</html>
