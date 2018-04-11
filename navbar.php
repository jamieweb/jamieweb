<nav>
    <div class="navbar">
        <ul>
            <li class="navlogo"><a href="/"><img src="/images/js-circle-48.png" width="35px" height="35px"></a></li>
            <li><h5><a href="/">Home</a></li></h5>
            <li class="dropdown">
                <h5><a href="/blog/">Blog</a></h5>
                <div class="dropdown-content">
                    <h4>
                        <?php include_once "bloglist.php"; bloglist("navbar"); ?>
                   </h4>
                </div>
            </li>
            <li class="dropdown">
                <h5><a href="/projects/">Projects</a></h5>
                <div class="dropdown-content">
                    <h4>
                        <a href="/projects/computing-stats/">Computing Stats</a>
                        <a href="/projects/block-exploitable-content/">Exploitable Web Content</a>
                        <a href="/projects/chrome-site-whitelist-extension/">Chrome Site Whitelist Extension</a>
                        <a href="/projects/irc-drawing-bot/">IRC Drawing Bot</a>
                    </h4>
                </div>
            </li>
            <li class="dropdown">
                <h5><a href="/info/">Info</a></h5>
                <div class="dropdown-content">
                    <h4>
                        <a href="/info/adblock-plus-config/">Adblock Plus Configuration</a>
                        <a href="/info/chrome-extension-ids/">Chrome Extension IDs</a>
                        <a href="/info/firefox-extension-ids/">Firefox Extension IDs</a>
                        <a href="/info/hl-client-security/">Half-Life Client Security</a>
                    </h4>
                </div>
            </li>
            <li class="dropdown">
            <h5><a href="/other/">Other</a></h5>
                <div class="dropdown-content">
                    <h4>
                        <a href="/downloads/">Downloads</a>
                        <a href="/other/speedrun-times/">Speedrun Times</a>
                        <a href="/pastes/">Pastes</a>
                    </h4>
                </div>
            </li>
        </ul>
    </div>
</nav>
