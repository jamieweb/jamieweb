<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Using a Bloom Filter to Anonymize Web Server Logs</title>
    <meta name="description" content="Anonymizing personal data in web server access logs in order to improve data security and comply with the GDPR.">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/blog/using-a-bloom-filter-to-anonymize-web-server-logs/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Using a Bloom Filter to Anonymize Web Server Logs</h1>
    <hr>
    <p><b>Monday 17th December 2018</b></p>
    <p>Since May 2018 when the GDPR came into full effect, I have had web server access logging completely disabled for my site. This is great from a security, privacy and GDPR compliance point of view, however it meant that I had very limited insight into the amount of traffic my site was getting.</p>
    <p>In order to solve this problem, I have built an open-source log anonymization tool which will remove personal data from web server access logs, and output a clean version that can be used for statistical purposes. A bloom filter is used to identify unique IP addresses, meaning that the anonymized log files can still be used for counting unique visitor IPs.</p>
    <p>I've released the tool under the MIT license, and it's available on my GitLab profile: <a href="https://gitlab.com/jamieweb/web-server-log-anonymizer-bloom-filter" target="_blank" rel="noopener">https://gitlab.com/jamieweb/web-server-log-anonymizer-bloom-filter</a></p>

    <p><b>Skip to Section:</b></p>
    <pre><b>Using a Bloom Filter to Anonymize Web Server Logs</b>
&#x2523&#x2501&#x2501 <a href="#overview-of-the-tool">Overview of the Tool</a>
&#x2523&#x2501&#x2501 <a href="#what-is-a-bloom-filter">What is a bloom filter?</a>
&#x2523&#x2501&#x2501 <a href="#finding-the-perfect-bloom-filter-configuration">Finding the Perfect Bloom Filter Configuration</a>
&#x2523&#x2501&#x2501 <a href="#fuzzing-the-tool-with-radamsa">Fuzzing the Tool with Radamsa</a>
&#x2523&#x2501&#x2501 <a href="#implementing-the-tool">Implementing the Tool</a>
&#x2523&#x2501&#x2501 <a href="#gdpr">GDPR</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>

    <h2 id="overview-of-the-tool">Overview of the Tool</h2>
    <p>The tool is written in Python 3, and is capable of processing web server access logs produced by web servers such as Apache or nginx.</p>
    <p>A bloom filter is used to keep track of which IP addresses have been seen before. This is what allows the outputted log files to be used for counting unique visitor IPs. Other anonymization solutions rely on obfuscating, invalidating or removing IP addresses, which usually limits or prevents them being used for this purpose.</p>
    <p>User agent strings are compared against approved lists of browsers and web crawlers, and replaced accordingly. The output log files will contain only the browser name, such as <code>Chrome</code> or <code>Firefox</code>, rather than the full user agent string including version numbers, etc.</p>
    <p>Referrer URLs are stripped down to only the scheme (such as <code>https</code>) and Fully Qualified Domain Name (such as <code>www.jamieweb.net</code>).</p>
    <p>Please see the <a href="https://gitlab.com/jamieweb/web-server-log-anonymizer-bloom-filter/blob/master/README.md" target="_blank" rel="noopener">README</a> for the tool in the GitLab repository for further details.</p>
    <p>The anonymized logs can be fed into a statistics tool such as AWStats. Of course an amount of accuracy and detail is lost during the anonymization process, however key information such as the number of unique visitors, page views and referring sites is still available. This is a fantastic balance between using an intrusive, JavaScript-heavy client-side tracking and having no insight at all.</p>

    <h2 id="what-is-a-bloom-filter">What is a bloom filter?</h2>

    <h2 id="finding-the-perfect-bloom-filter-configuration">Finding the Perfect Bloom Filter Configuration</h2>

    <h2 id="fuzzing-the-tool-with-radamsa">Fuzzing the Tool</h2>

    <h2 id="implementing-the-tool">Implementing the Tool</h2>

    <h2 id="gdpr">GDPR</h2>
    <p>While it's true that <a href="https://www.privacy-regulation.eu/en/recital-49-GDPR.htm" target="_blank" rel="noopener">Recital 49</a> of the GDPR allows for the processing of personal data (such as log files) in order to ensure sufficient levels of network and data security, this particular clause does not expand to statistical and analytical purposes.</p>

    <h2 id="conclusion">Conclusion</h2>
    
</div>

<?php include "footer.php" ?>

</body>

</html>
