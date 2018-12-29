<nav>
    <div class="navbar">
        <ul>
            <li class="navlogo"><a href="/"><img src="/images/js-circle-48.png" width="35px" height="35px"></a></li>
            <li><h5><a href="/">&#x1f3e0;&#xfe0e; <span>Home</span></a></h5></li>
            <li class="dropdown">
                <h5><a href="/blog/">&#x1f58b;&#xfe0e; <span>Blog</span></a></h5>
                <div class="dropdown-content">
                    <h4>
                        <?php include_once "bloglist.php"; bloglist("navbar"); ?>
                    </h4>
                </div>
            </li>
            <li class="dropdown">
                <h5><a href="/projects/">&#x1f4bb;&#xfe0e; <span>Projects</span></a></h5>
                <div class="dropdown-content">
                    <h4>
                        <a href="/projects/computing-stats/">Computing Stats</a>
                        <a href="/projects/chrome-site-whitelist-extension/">Chrome Site Whitelist Extension</a>
                        <a href="/projects/irc-drawing-bot/">IRC Drawing Bot</a>
                    </h4>
                </div>
            </li>
            <li class="dropdown">
                <h5><a href="/tools">&#x1f6e0;&#xfe0e; <span>Tools</span></a></h5>
                <div class="dropdown-content">
                    <h4>
                        <a href="/tools/exploitable-web-content-blocking-test/">Exploitable Web Content Blocking Test</a>
                        <a href="/tools/ipv6-ipv4-test/">IPv6 / IPv4 Test</a>
                    </h4>
                </div>
            </li>
            <li class="dropdown">
                <h5><a href="/info/">&#x1f4d6;&#xfe0e; <span>Info</span></a></h5>
                <div class="dropdown-content">
                    <h4>
                        <a href="/info/adblock-plus-config/">Adblock Plus Configuration</a>
                        <a href="/info/chrome-extension-ids/">Chrome Extension IDs</a>
                        <a href="/info/firefox-extension-ids/">Firefox Extension IDs</a>
                        <a href="/info/git-hosting-service-ssh-server-key-fingerprints/">Git Services SSH Fingerprints</a>
                        <a href="/info/hl-client-security/">Half-Life Client Security</a>
                        <a href="/info/chromium-team-updated-packages-for-ubuntu/">Updated Chromium Browser Packages for Ubuntu</a>
                        <a href="/info/x86_64-general-purpose-registers-reference/">x86_64 GPR Reference</a>
                    </h4>
                </div>
            </li>
            <li class="float-right">
                <h5><a href="/contact/">&#x1f4e7;&#xfe0e; <span>Contact</span></a></h5>
            </li>
            <li class="float-right">
                <h5><a href="/subscribe/">&#x1f514;&#xfe0e; <span>Subscribe</span></a></h5>
            </li>
        </ul>
    </div>
</nav>
