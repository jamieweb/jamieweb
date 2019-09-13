<?php include "response-headers.php"; content_security_policy(); ?>
<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Projects</title>
    <meta name="description" content="Jamie Scaife's Projects">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/projects/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Projects</h1>
    <hr>

    <h2 id="raspberry-pi-cluster" class="no-mar-bottom redlink"><a href="/projects/computing-stats/">Raspberry Pi Cluster</a></h2>
    <p class="two-mar-top">A five-node Raspberry Pi Cluster running Einstein@Home and various other applications. It has been running 24/7 in my garage in one form or another since October 2015, which is over 30,000 computing hours as of September 2019. Live statistics are uploaded to this website every 10 minutes, including temperature, CPU and memory usage.</p>
    <p>&#x1f4c8; <a href="/projects/computing-stats/">Live Stats</a> | &#x1f3a5; <a href="https://twitter.com/jamieweb/status/1062048785352871936" target="_blank" rel="noopener">Video</a></p>
    <hr>

    <h2 id="digitalocean-tutorials" class="no-mar-bottom redlink"><a href="https://www.digitalocean.com/community/users/jamieweb?primary_filter=tutorials" target="_blank" rel="noopener">DigitalOcean Tutorials</a></h2>
    <p class="two-mar-top">I am a freelance technical writer for the cloud computing company DigitalOcean, where I write guides and tutorials about Linux infrastructure and web technologies. I have covered topics including DNS infrastructure-as-code tools and email security. The payments for my work are kindly matched by DigitalOcean as a charitable donation to the Electronic Frontier Foundation.</p>
    <p>&#x1f4dd; <a href="https://www.digitalocean.com/community/users/jamieweb?primary_filter=tutorials" target="_blank" rel="noopener">My DigitalOcean Tutorials</a></p>
    <hr>

    <h2 id="web-server-log-file-anonymizer" class="two-mar-bottom redlink"><a href="https://gitlab.com/jamieweb/web-server-log-anonymizer-bloom-filter/" target="_blank" rel="noopener">Web Server Log File Anonymizer</a></h2>
    <p class="two-mar-top">An anonymisation tool for web server log files which removes sensitive information such as IP addresses and user agents, while retaining the uniqueness of individual log entries. The tool utilises a Bloom filter in order to determine whether a particular IP address has been seen before, without actually having to permanently store it. A customisable level of <i>k</i>-anonymity is used to ensure that the filter cannot be brute-forced. This means that the resulting log files are still useful for high-level web statistics such as unique visitor counts, without having to store the potentially sensitive information that they usually contain.</p>
    <p><img class="gl-logo-svg" src="/images/svg-logos/gitlab.svg" width="55px" title="GitLab"><a href="https://gitlab.com/jamieweb/web-server-log-anonymizer-bloom-filter/" target="_blank" rel="noopener">Source Code</a> | &#x1f4c3; <a href="/blog/using-a-bloom-filter-to-anonymize-web-server-logs/">Blog Post</a> | <img class="vertical-align-middle" src="/images/svg-logos/python.svg" width="30px" title="Python"> Written in <a href="https://www.python.org/" target="_blank" rel="noopener">Python 3</a></p>
    <hr>

    <h2 id="csp-tester-ci-pipeline-job" class="two-mar-bottom redlink"><a href="https://gitlab.com/jamieweb/travis-ci_csp-tester/" target="_blank" rel="noopener">Content Security Policy Tester CI Pipeline Job</a></h2>
    <p class="two-mar-top">A continuous integration job configuration for automatically testing for violations of your website's Content Security Policy. A copy of your PHP website with your desired CSP header is set up in the CI system and crawled using Headless Chrome Crawler, resulting in violation reports being sent to a local or remote reporting endpoint. The reports can then be reviewed in order to determine whether your site is compliant with its own security policy, helping to ensure that content will not be accidentally blocked.</p>
    <p><img class="gl-logo-svg" src="/images/svg-logos/gitlab.svg" width="55px" title="GitLab"><a href="https://gitlab.com/jamieweb/travis-ci_csp-tester/" target="_blank" rel="noopener">Source Code</a> | &#x1f4c3; <a href="/blog/testing-your-csp-using-travis-ci-and-headless-chrome-crawler/">Blog Post</a> | <img class="vertical-align-middle" src="/images/svg-logos/yaml.svg" width="75px" title="YAML"> Written in <a href="https://yaml.org/" target="_blank" rel="noopener">YAML</a></p>
    <hr>

    <h2 id="automatic-software-package-integrity-verifier" class="two-mar-bottom redlink"><a href="https://gitlab.com/jamieweb/dl-integrity-verify/" target="_blank" rel="noopener">Automatic Software Package Integrity Verifier</a></h2>
    <p class="two-mar-top">A Bash script to automatically download and perform GPG and/or hash integrity verifications on a list of pre-programmed software packages and files, including Ubuntu Linux installation ISOs and various Windows software. The purpose of this is to mitigate the risk of human error when carrying out this sensitive process, and to save time by making the process mostly automated.</p>
    <p><img class="gl-logo-svg" src="/images/svg-logos/gitlab.svg" width="55px" title="GitLab"><a href="https://gitlab.com/jamieweb/dl-integrity-verify/" target="_blank" rel="noopener">Source Code</a> | &#x1f4c3; <a href="/blog/automating-the-integrity-verification-process-for-downloaded-software/">Blog Post</a> | <img class="vertical-align-middle" src="/images/svg-logos/bash.svg" width="28px" title="Bash"> Written in <a href="https://www.gnu.org/software/bash/" target="_blank" rel="noopener">Bash</a></p>
    <hr>

    <h2 id="link-whitelist-chrome-extension" class="two-mar-bottom redlink"><a href="https://gitlab.com/jamieweb/results-whitelist/" target="_blank" rel="noopener">Link Whitelist Chrome Extension</a></h2>
    <p class="two-mar-top">A Google Chrome extension which allows you to set a whitelist of trusted websites. Hyperlinks to these websites in Google search results, Reddit and Hacker News will then be highlighted in green. This is an anti-typosquatting and anti-phishing tool designed to remove the requirement to carefully check links before clicking on them, and to provide assurance that the link you're clicking isn't a lookalike or phishing website.</p>
    <p><img class="gl-logo-svg" src="/images/svg-logos/gitlab.svg" width="55px" title="GitLab"><a href="https://gitlab.com/jamieweb/results-whitelist/" target="_blank" rel="noopener">Source Code</a> | &#x1f4c3; <a href="/blog/chrome-site-whitelist-extension/">Blog Post</a> | <img class="vertical-align-middle" src="/images/svg-logos/javascript.svg" width="28px" title="JavaScript"> Written in <a href="https://en.wikipedia.org/wiki/JavaScript" target="_blank" rel="noopener">JavaScript</a></p>
    <hr>

    <br>
    <p class="two-mar-top"><b>View more of my projects and work on my <a href="/blog/">blog</a> and <a href="https://gitlab.com/jamieweb/" target="_blank" rel="noopener">GitLab profile</a>.</b></p>
</div>

<?php include "footer.php" ?>

</body>

</html>
