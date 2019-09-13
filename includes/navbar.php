<nav>
    <div class="navbar">
        <ul>
            <li class="navlogo"><a href="/"><img src="/images/js-circle-48.png" width="35px" height="35px"></a></li>
            <li><h5><a href="/"><span>&#x1f3e0;&#xfe0e;</span> <span>Home</span></a></h5></li>
            <li class="dropdown">
                <h5><a href="/blog/"><span class="exempt">&#x1f58b;&#xfe0e;</span> <span>Blog</span></a></h5>
                <div class="dropdown-content">
                    <h4>
<?php include_once "bloglist.php"; bloglist("navbar"); ?>
                    </h4>
                </div>
            </li>
            <li class="dropdown">
                <h5><a href="/projects/"><span>&#x1f4bb;&#xfe0e;</span> <span>Projects</span></a></h5>
                <div class="dropdown-content">
                    <h4>
                        <a href="/projects/computing-stats/">Raspberry Pi Cluster Live Stats</a>
                        <a href="/projects/#digitalocean-tutorials">DigitalOcean Tutorials</a>
                        <a href="/projects/#web-server-log-file-anonymizer">Web Server Log File Anonymizer</a>
                        <a href="/projects/#csp-tester-ci-pipeline-job">Content Security Policy Tester CI Pipeline Job</a>
                        <a href="/projects/#automatic-software-package-integrity-verifier">Automatic Software Package Integrity Verifier</a>
                        <a href="/projects/#link-whitelist-chrome-extension">Link Whitelist Chrome Extension</a>
                    </h4>
                </div>
            </li>
            <li class="dropdown">
                <h5><a href="/tools/"><span>&#x1f6e0;&#xfe0e;</span> <span>Tools</span></a></h5>
                <div class="dropdown-content">
                    <h4>
                        <a href="/tools/exploitable-web-content-blocking-test/">Exploitable Web Content Blocking Test</a>
                        <a href="/tools/ipv6-ipv4-test/">IPv6 / IPv4 Test</a>
                    </h4>
                </div>
            </li>
            <li class="dropdown">
                <h5><a href="/info/"><span>&#x1f4d6;&#xfe0e;</span> <span>Info</span></a></h5>
                <div class="dropdown-content">
                    <h4>
                        <a href="/info/adblock-plus-config/">Adblock Plus Configuration</a>
                        <a href="/info/chrome-extension-ids/">Chrome Extension IDs</a>
                        <a href="/info/firefox-extension-ids/">Firefox Extension IDs</a>
                        <a href="/info/git-hosting-service-ssh-server-key-fingerprints/">Git Services SSH Fingerprints</a>
                        <a href="/info/restricting-and-locking-down-ssh-users/">Locking Down SSH Users</a>
                        <a href="/info/up-to-date-chromium-browser-on-ubuntu/">Up-to-date Chromium on Ubuntu</a>
                        <a href="/info/x86_64-general-purpose-registers-reference/">x86_64 GPR Reference</a>
                    </h4>
                </div>
            </li>
            <li class="float-right">
                <h5><a href="/contact/"><span class="exempt">&#x1f4e7;&#xfe0e;</span> <span>Contact</span></a></h5>
            </li>
            <li class="float-right">
                <h5><a href="/rss.xml" target="_blank"><img class="invert exempt" width="18px" src="/images/fontawesome/rss.svg"> <span>RSS Feed</span></a></h5>
            </li>
        </ul>
    </div>
</nav>
