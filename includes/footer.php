<?php if(basename(dirname(getcwd())) === "blog") {
        echo "    <div class=\"centertext\">
        <h5 class=\"license\">This article is licensed under a <a href=\"https://creativecommons.org/licenses/by-sa/4.0/\" target=\"_blank\" rel=\"noopener\">Creative Commons Attribution-ShareAlike 4.0 International License</a>.</h5>
    </div>";
} ?>
<footer>
    <div class="footer">
        <div class="footer-column">
            <h2><a href="/"><img class="footer-logo" src="/images/jamieweb.png">JamieWeb</a></h2>
            <p><b><a href="/blog/">Blog</a> | <a href="/projects/">Projects</a> | <a href="/tools/">Tools</a> | <a href="/info/">Info</a></b></p>
            <p class="footer-email"><b>Email:</b> <img class="two-mar-left" src="/images/jamie-jamieweb-4d4d4d.png"></p>
            <p><b><a href="/contact/">Contact Info</a> | <a href="/security/">Security</a> | <a href="/privacy/">Privacy</a></b></p>
            <p>Copyright &copy; Jamie Scaife 2018</p>
        </div>
        <div class="footer-column footer-middle">
            <h2>&#x1f517; Links</h2>
            <a href="https://github.com/jamieweb" target="_blank" rel="noopener">
                <div class="footer-item">
                    <img class="invert" src="/images/fontawesome/github.svg">
                    <h4>GitHub</h4>
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
                    <img class="invert" src="/images/fontawesome/id-card.svg">
                    <h4>Keybase</h4>
                </div>
            </a>
            <a href="https://hackerone.com/jamieweb" target="_blank" rel="noopener">
                <div class="footer-item">
                    <img class="invert h1" src="/images/hackerone.png">
                    <h4>HackerOne</h4>
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
            <div class="email-form">
                <p class="no-mar-top no-mar-bottom">Or subscribe via email:</p>
                <form class="display-flex" action="https://www.getrevue.co/profile/jamieweb/add_subscriber" method="post" target="_blank">
                    <input class="form-input margin-right-10 flex-grow-1" type="email" name="member[email]" placeholder="Your email address...">
                    <input class="form-submit" type="submit" name="member[subscribe]" value="Go">
                </form>
                <p class="font-size-smaller color-lightgrey no-mar-top">Email subscriptions are powered by <a class="color-lightgrey footer-subtext" href="https://www.getrevue.co/" target="_blank" rel="noopener">Revue</a> | <a class="color-lightgrey footer-subtext" href="https://www.getrevue.co/privacy/platform" target="_blank" rel="noopener">Privacy Notice</a></p>
            </div>
        </div>
    </div>
</footer>
