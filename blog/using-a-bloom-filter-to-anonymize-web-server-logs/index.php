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
    <p>A bloom filter is a method for determining whether a particular piece of data exists within a set, without actually requiring access to the set itself.</p>
    <p>They consist of an array of bits, and can be either written to, or queried. If you want to add a piece of data to a bloom filter, hashes of the data are generated, and the corresponding bits in the bloom filter are set to <code>1</code>. Full, cryptographically secure hashes are not normally used - instead, they are split into segments (such as 5 characters at a time), or other algorithms such as murmur are used.</p>
    <p>For example, imagine a brand new bloom filter which is 16 bits in size:</p>
    <pre>0000000000000000</pre>
    <p>If we want to add the data <code>helloworld</code> to the bloom filter, we must first generate a hash of the data. The maximum potential value of the hash should be the same size as the bloom filter. In this case, the bloom filter is 16 bits in size, so the maximum value of the hash can be 16.</p>
    <pre>$ echo "helloworld" | sha256sum
8cd07f3a5ff98f2a78cfc366c13fb123eb8d29c1ca37c79df190425d5b9e424d  -</pre>
    <p>The SHA-256 hash value of <code>helloworld</code> is obviously significantly larger than 16 when converted to base 10, so we need to cut it down to an appropriate size. SHA-256 hashes are represented in hexadecimal (base 16), meaning that each character can represent the values 0 to 15 in base 10.</p>
    <p>This means that in this example, one single character could represent each of the bits in the bloom filter uniquely, so we need to split the hash into one character segments. You can use as many segments as you wish, however generally only a few are used. In this case, we'll use two segments.</p>
    <p>The more segments we use, the more accurate the bloom filter will be, however the capacity of the filter will be reduced. Increased accuracy may sound like a good thing, however in many use cases (such as anonymizing web server logs), being too accurate can actually result in the bloom filter being easy to brute-force, potentially revealing the original un-anonymized data.</p>
    <p>The first two single-character segments of the hash are <code>8</code> and <code>c</code>. When converted to base 10, these equal <code>8</code> and <code>12</code> respectively.</p>
    <p>This means that we need to set the 8th and 12th bits of the bloom filter to <code>1</code>. Since we're talking arrays, and arrays start at 0, that's really the 9th and 13th bits:</p>
    <pre>0000000010001000
        ^   ^</pre>
    <p>Now let's add another piece of data to the filter:</p>
    <pre>$ echo "123" | sha256sum
181210f8f9c779c26da1d9b2075bde0127302ee0e3fca38c9a83f5b1dd8e5d3b  -</pre>
    <p>The first two segments in base 10 are <code>1</code> and <code>8</code>. So we'll set the 2nd and 9th bits to <code>1</code>:</p>
    <pre>0100000010001000
 ^      ^</pre>
    <p>Notice how the 9th bit was already set. There is no problem there, it's already set so it can remain set.</p>
    <p>Now we can query the bloom filter to determine whether a particular piece of data exists:</p>
    <pre>$ echo "wheel" | sha256sum
1f148121b804b2d30f7b87856b0840eba32af90607328a5756802771f8dbff57  -</pre>
    <p>The first two segments in base 10 are <code>1</code> and <code>15</code>, so we need to check whether the 2nd and 16th bits are both set to <code>1</code>:</p>
    <pre>0100000010001000
 ^             ^</pre>
    <p>As you can see, only one of required bits is set to <code>1</code>, so this proves that the data is definitely <b>not</b> present in the bloom filter.</p>
    <p>Let's try querying the filter again:</p>
    <pre>$ echo "helloworld" | sha256sum
8cd07f3a5ff98f2a78cfc366c13fb123eb8d29c1ca37c79df190425d5b9e424d  -</pre>
    <p>As we worked out previously, the first two segments in base 10 and <code>8</code> and <code>12</code>, so we again need to check the 9th and 13th bits:</p>
    <pre>0100000010001000
        ^   ^</pre>
    <p>Both of the required bits are set, so this proves that the data <i>might</i> be present in the filter.</p>
    <p>Bloom filters have a non-zero inaccuracy rate. Querying a filter will give you either one of two outputs: that the data <i>might</i> exist, or that the data definitely doesn't exist. In other words, false positives are possible, but false negatives are impossible. This doesn't make them useless though, as there are many use cases where 100% accuracy is not required.</p>
    <p>The most well-known use of bloom filters is performance and efficiency. Querying large databases or other sets of data directly can take a large amount of computer processing power and time. Having a bloom filter for the data set and querying that first can help to narrow down the search, potentially resulting in huge performance increases for the system.</p>

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
