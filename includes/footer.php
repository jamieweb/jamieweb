<?php if(basename(dirname(getcwd())) === "blog") {
    if(!(isset($postInfo))) {
        $postInfo = new stdClass();
        $postInfo->license = "CC BY-SA 4.0";
        $postInfo->format_version = 1;
    }
    if(!($postInfo->license === "none")) {
        echo "    <div class=\"centertext\">
        <h5 class=\"license\">This article is licensed under a " . license_text($postInfo->license) . ".</h5>
    </div>";
    }
} ?>
<footer>
    <div class="footer">
        <div class="footer-column">
            <h2><a href="/"><img class="footer-logo" src="/images/jamieweb.png">JamieWeb</a></h2>
            <p><b><a href="/blog/">Blog</a> | <a href="/projects/">Projects</a> | <a href="/tools/">Tools</a> | <a href="/info/">Info</a></b></p>
            <p class="footer-email"><b>Email:</b> <img class="two-mar-left" src="/images/blog-jamieweb-ffffff.png"></p>
            <p><b><a href="/contact/">Contact Info</a> | <a href="/contact/#hackerone">Security</a> | <a href="/privacy/">Privacy</a> | <a href="/contact/#legal">Legal</a> | <a href="/sponsor/">Sponsor My Blog</a></b></p>
            <p>Copyright &copy; Jamie Scaife <?php echo date("Y"); ?></p>
        </div>
        <div class="footer-column footer-middle">
            <h2>&#x1f517; Links</h2>
            <a href="https://gitlab.com/jamieweb" target="_blank" rel="noopener">
                <div class="footer-item">
                    <img class="invert" src="/images/fontawesome/gl.svg">
                    <h4>GitLab</h4>
                </div>
            </a>
            <a href="https://twitter.com/jamieweb" target="_blank" rel="noopener">
                <div class="footer-item">
                    <img class="invert" src="/images/fontawesome/tw.svg">
                    <h4>Twitter</h4>
                </div>
            </a>
            <a href="https://www.youtube.com/jamie90437x" target="_blank" rel="noopener">
                <div class="footer-item">
                    <img class="invert" src="/images/fontawesome/yt.svg">
                    <h4>YouTube</h4>
                </div>
            </a>
            <a href="https://keybase.io/jamieweb" target="_blank" rel="noopener">
                <div class="footer-item">
                    <img class="invert" src="/images/fontawesome/kb.svg">
                    <h4>Keybase</h4>
                </div>
            </a>
            <a href="https://hackerone.com/jamieweb" target="_blank" rel="noopener">
                <div class="footer-item">
                    <img class="invert h1 exempt" src="/images/hackerone.png">
                    <h4>HackerOne</h4>
                </div>
            </a>
            <a href="https://news.ycombinator.com/user?id=jamieweb" target="_blank" rel="noopener">
                <div class="footer-item">
                    <img class="invert hn exempt" src="/images/fontawesome/hn.svg"><h4>Hacker News</h4><!-- No newline here to prevent whitespace text nodes causing wrapping -->
                </div>
            </a>
        </div>
        <div class="footer-column">
            <h2>&#x1f514; Subscribe</h2>
            <a href="/rss.xml" target="_blank">
                <div class="footer-item">
                    <img src="/images/fontawesome/rss-orange.svg">
                    <h4>RSS Feed</h4>
                </div>
            </a>
            <p class="margin-top-16">My website does not serve any intrusive adverts, tracking cookies or other internet annoyances. It's also friendly to users with JavaScript disabled.</p>
        </div>
    </div>
    <div class="footer flex-justify-center">
        <p class="margin-top--8 font-size-smaller color-grey">This request was served by <?php include "hostinfo.txt"; ?> - <a class="color-grey" href="https://status.jamieweb.net/" target="_blank" rel="noopener">View Site Status</a></p>
    </div>
</footer>
<?php if((isset($postInfo)) && ($postInfo->format_version >= 2)) {
    echo "\n</body>\n\n</html>";
} ?>
