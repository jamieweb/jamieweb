<?php include "response-headers.php"; content_security_policy();
include_once "bloglist.php"; bloglist("postTop", null, null, 2019); ?>

<div class="body">
    <h1><?php echo $postInfo->title; ?></h1>
    <hr>
    <p><b><?php echo $postInfo->date; ?></b></p>
    <p><?php echo $postInfo->snippet; ?></p>
    <p>One of the largest challenges with infrastructure deployment and automatation is managing and verifying the SSH server key fingerprints for your servers and devices. Each new server will have its own unique SSH fingerprint that needs to be verified and accepted before your devices (e.g. Ansible control machine, log collector) can securely connect via SSH.</p>
    <p>Often, verifying the distributing the fingerprints is a manual process, involving connecting to machines to check and accept the fingerprint, or manually copying lines to your <code>~/.ssh/known_hosts</code> file. In some cases, people also unfortunately bypass the warnings and accept the fingerprint without checking it, which fundamentally breaks the security model of SSH host authenticity checking.</p>
    <p>I have recently solved all of these challenges by implementing a new solution for managing my saved SSH server key fingerprints (known_hosts). I'm storing a verified copy of each fingerprint centrally in a public Git repository, and I can then pull from the repository on all of my machines/devices whenever the key changes. This allows me to securely and semi-automatically distribute the fingerprints with minimal manual work required.</p>
    <p><b>Skip to Section:</b></p>
    <pre><b><?php echo $postInfo->title ?></b>
&#x2523&#x2501&#x2501 <a href="#what-is-the-ssh-known_hosts-file-for">What is the SSH known_hosts file for?</a>
&#x2523&#x2501&#x2501 <a href="#managing-known-hosts-using-git">Managing known_hosts Using Git</a>
&#x2523&#x2501&#x2501 <a href="#verifying-the-fingerprints">Verifying the Fingerprints</a>
&#x2523&#x2501&#x2501 <a href="#client-configuration">Client Configuration</a>
&#x2523&#x2501&#x2501 <a href="#example-usage">Example Usage</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>

    <h2 id="what-are-ssh-known_hosts">What is the SSH known_hosts file for?</h2>
    <p></p>
</div>

<?php include "footer.php" ?>














