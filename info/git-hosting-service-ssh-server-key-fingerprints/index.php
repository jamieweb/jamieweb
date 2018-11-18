<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Git Hosting Service SSH Server Key Fingerprints</title>
    <meta name="description" content="The SSH server key fingerprints for various online Git hosting services.">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/info/git-hosting-service-ssh-server-key-fingerprints/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Git Hosting Service SSH Server Key Fingerprints</h1>
    <hr>
    <p>This page contains the SSH server key fingerprints for various online Git hosting services.</p>
    <p>These fingerprints help you to verify the identity of the SSH server that you are connecting to.</p>

    <h2 id="github">GitHub</h2>
    <table class="width-100-percent padding-6 border-1-4c4c4c border-collapse">
        <tr class="bg-lightgreen">
            <th>Algorithm</th>
            <th>Type</th>
            <th>Fingerprint</th>
        </tr>
        <tr>
            <td>RSA</td>
            <td>SHA256</td>
            <td class="x-scroll"><code>nThbg6kXUpJWGl7E1IGOCspRomTxdCARLviKw6E5SY8</code></td>
        </tr>
        <tr>
            <td>DSA</td>
            <td>SHA256</td>
            <td class="x-scroll"><code>br9IjFspm1vxR3iA35FWE+4VTyz1hYVLIE2t1/CeyWQ</code></td>
        </tr>
        <tr>
            <td>RSA</td>
            <td>MD5</td>
            <td class="x-scroll"><code>16:27:ac:a5:76:28:2d:36:63:1b:56:4d:eb:df:a6:48</code></td>
        </tr>
        <tr>
            <td>DSA</td>
            <td>MD5</td>
            <td class="x-scroll"><code>ad:1c:08:a4:40:e3:6f:9c:f5:66:26:5d:4b:33:5d:8c</code></td>
        </tr>
    </table>
    <p>Source: <a href="https://help.github.com/articles/github-s-ssh-key-fingerprints/" target="_blank" rel="noopener">https://help.github.com/articles/github-s-ssh-key-fingerprints/</a></p>

    <h2 id="gitlab">GitLab</h2>
    <table class="width-100-percent padding-6 border-1-4c4c4c border-collapse">
        <tr class="bg-lightgreen">
            <th>Algorithm</th>
            <th>Type</th>
            <th>Fingerprint</th>
        </tr>
        <tr>
            <td>ECDSA</td>
            <td>SHA256</td>
            <td class="x-scroll"><code>HbW3g8zUjNSksFbqTiUWPWg2Bq1x8xdGUrliXFzSnUw</code></td>
        </tr>
        <tr>
            <td>ED25519</td>
            <td>SHA256</td>
            <td class="x-scroll"><code>eUXGGm1YGsMAS7vkcx6JOJdOGHPem5gQp4taiCfCLB8</code></td>
        </tr>
        <tr>
            <td>RSA</td>
            <td>SHA256</td>
            <td class="x-scroll"><code>ROQFvPThGrW4RuWLoL9tq9I9zJ42fK4XywyRtbOz/EQ</code></td>
        </tr>
        <tr>
            <td>DSA</td>
            <td>SHA256</td>
            <td class="x-scroll"><code>p8vZBUOR0XQz6sYiaWSMLmh0t9i8srqYKool/Xfdfqw</code></td>
        </tr>
        <tr>
            <td>ECDSA</td>
            <td>MD5</td>
            <td class="x-scroll"><code>f1:d0:fb:46:73:7a:70:92:5a:ab:5d:ef:43:e2:1c:35</code></td>
        </tr>
        <tr>
            <td>ED25519</td>
            <td>MD5</td>
            <td class="x-scroll"><code>2e:65:6a:c8:cf:bf:b2:8b:9a:bd:6d:9f:11:5c:12:16</code></td>
        </tr>
        <tr>
            <td>RSA</td>
            <td>MD5</td>
            <td class="x-scroll"><code>b6:03:0e:39:97:9e:d0:e7:24:ce:a3:77:3e:01:42:09</code></td>
        </tr>
        <tr>
            <td>DSA</td>
            <td>MD5</td>
            <td class="x-scroll"><code>7a:47:81:3a:ee:89:89:64:33:ca:44:52:3d:30:d4:87</code></td>
        </tr>
    </table>
    <p>Source: <a href="https://docs.gitlab.com/ee/user/gitlab_com/#ssh-host-keys-fingerprints" target="_blank" rel="noopener">https://docs.gitlab.com/ee/user/gitlab_com/#ssh-host-keys-fingerprints</a></p>

    <h2 id="bitbucket">Bitbucket</h2>
    <table class="width-100-percent padding-6 border-1-4c4c4c border-collapse">
        <tr class="bg-lightgreen">
            <th>Algorithm</th>
            <th>Type</th>
            <th>Fingerprint</th>
        </tr>
        <tr>
            <td>RSA</td>
            <td>SHA256</td>
            <td class="x-scroll"><code>zzXQOXSRBEiUtuE8AikJYKwbHaxvSc0ojez9YXaGp1A</code></td>
        </tr>
        <tr>
            <td>DSA</td>
            <td>SHA256</td>
            <td class="x-scroll"><code>RezPkAnH1sowiJM0NQXH90IohWdzHc3fAisEp7L3O3o</code></td>
        </tr>
        <tr>
            <td>RSA</td>
            <td>MD5</td>
            <td class="x-scroll"><code>97:8c:1b:f2:6f:14:6b:5c:3b:ec:aa:46:46:74:7c:40</code></td>
        </tr>
        <tr>
            <td>DSA</td>
            <td>MD5</td>
            <td class="x-scroll"><code>35:ee:d7:b8:ef:d7:79:e2:c6:43:9e:ab:40:6f:50:74</code></td>
        </tr>
    </table>
    <p>Source: <a href="https://confluence.atlassian.com/bitbucket/ssh-keys-935365775.html" target="_blank" rel="noopener">https://confluence.atlassian.com/bitbucket/ssh-keys-935365775.html</a></p>

    <h2 id="launchpad">Launchpad</h2>
    <p>Bazaar and Ubuntu Package hosting is also provided by Launchpad, so I have included these fingerprints too for completeness.</p>
    <table class="width-100-percent padding-6 border-1-4c4c4c border-collapse">
        <tr class="bg-lightgreen">
            <th>Algorithm</th>
            <th>Type</th>
            <th>Fingerprint</th>
        </tr>
        <tr>
            <td class="bg-lightgrey" colspan="3">git.launchpad.net:</td>
        </tr>
        <tr>
            <td>RSA</td>
            <td>SHA256</td>
            <td class="x-scroll"><code>UNOzlP66WpDuEo34Wgs8mewypV0UzqHLsIFoqwe8dYo</code></td>
        </tr>
        <tr>
            <td>RSA</td>
            <td>MD5</td>
            <td class="x-scroll"><code>df:b0:16:7e:55:54:96:58:79:85:ba:e2:c3:72:d9:09</code></td>
        </tr>
        <tr>
            <td class="bg-lightgrey" colspan="3">bazaar.launchpad.net:</td>
        </tr>
        <tr>
            <td>RSA</td>
            <td>SHA256</td>
            <td class="x-scroll"><code>dS2DmMhdbMsWaFP4HOF7A/ut73ozMR/gDL2Xxs01/7A</code></td>
        </tr>
        <tr>
            <td>RSA</td>
            <td>MD5</td>
            <td class="x-scroll"><code>9d:38:3a:63:b1:d5:6f:c4:44:67:53:49:2e:ee:fc:89</code></td>
        </tr>
        <tr>
            <td class="bg-lightgrey" colspan="3">ppa.launchpad.net:</td>
        </tr>
        <tr>
            <td>RSA</td>
            <td>SHA256</td>
            <td class="x-scroll"><code>MGq+4hxD7RduVTcfwlwwboZnsgJC6SL/NltM8ye+gNg</code></td>
        </tr>
        <tr>
            <td>RSA</td>
            <td>MD5</td>
            <td class="x-scroll"><code>6b:03:de:98:33:25:23:18:a6:46:b3:47:22:cd:54:f2</code></td>
        </tr>
        <tr>
            <td class="bg-lightgrey" colspan="3">upload.ubuntu.com:</td>
        </tr>
        <tr>
            <td>RSA</td>
            <td>SHA256</td>
            <td class="x-scroll"><code>FN8sNU/MMmyvw/xtY5sAzkLGmkVQt2QpGZcwsHoBzjc</code></td>
        </tr>
        <tr>
            <td>RSA</td>
            <td>MD5</td>
            <td class="x-scroll"><code>79:57:63:97:d3:d3:be:b6:6d:da:81:d0:73:29:80:48</code></td>
        </tr>
    </table>
    <p>Source: <a href="https://help.launchpad.net/SSHFingerprints" target="_blank" rel="noopener">https://help.launchpad.net/SSHFingerprints</a></p>
</div>

<?php include "footer.php" ?>

</body>

</html>
