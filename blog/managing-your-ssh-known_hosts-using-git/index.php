<?php include "response-headers.php"; content_security_policy();
include_once "bloglist.php"; bloglist("postTop", null, null, 2019); ?>

<div class="body">
    <h1><?php echo $postInfo->title; ?></h1>
    <hr>
    <p><b><?php echo $postInfo->date; ?></b></p>
    <p><?php echo $postInfo->snippet; ?></p>
    <p><b>Skip to Section:</b></p>
    <pre><b><?php echo $postInfo->title ?></b>
&#x2523&#x2501&#x2501 <a href="#what-is-the-ssh-known_hosts-file-for">What is the SSH known_hosts file for?</a>
&#x2523&#x2501&#x2501 <a href="#verifying-the-fingerprints">Verifying the Fingerprints</a>
&#x2523&#x2501&#x2501 <a href="#managing-known_hosts-using-git">Managing known_hosts Using Git</a>
&#x2523&#x2501&#x2501 <a href="#client-configuration">Client Configuration</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>

    <h2 id="what-are-ssh-known_hosts">What is the SSH known_hosts file for?</h2>
    <p>The <code>known_hosts</code> file, normally located at <code>~/.ssh/known_hosts</code>, is used to store the SSH server key fingerprints of the servers that you have connected to in the past. Each SSH server has its own (normally unique) server key and associated fingerprint. This is how a server identifies itself cryptographically, and are used by SSH clients to verify that future connections to the same server, <i>are</i> actually to the same server, and not to a different server because of a man-in-the-middle attack, DNS hijack, etc.</p>
    <p>A <code>known_hosts</code> file may look similar to the following example:</p>
    <pre>ldn01.jamieweb.net,139.162.222.67 ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQC4bVleGrAZFttdMBen/ExLWbUUr5UaaX3Wd8U4nwH6LEaOMxuYu2cyrBuwIVZ9gjSoI0fEWhe345HeQJbdNzE/rd5ojebtS9bQiAB9+GVNKHxemBP01M0OaZJVA/GJnSzjdoEfrCGG8SWIDPQjY02yTQwgQHW5zYlr12Hq3FjKzofJ1Q2PSWbCy3crsA/R4vPHRVLPd8RDj+EXWVwvFgTHriuQWnt9Q/djy1LOPrqNgHn1n17cIED1M0zgXpImoLNC+Z44DmopVdmtwRW57IkedktWQdpCNRYTyOj/as/xn5YStXIWwxila16NYeq6O7zqoedWPiad6qnFloobOcft
nyc01.jamieweb.net,157.230.83.95 ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQC8Gh3exdEvvWqZHdbBogN3kbfutx3af0oO9dof1L+4vFsA8xmMOURjdB/BF9uF44i+1yosOhxh+k0Kjgeo0JAjPWy8e94SpEn2oUFJ3/9y1QzpWR81aAi/B9gSX9KR6uDys1yIhjjBKE0omP6vvSSVndY7BkxXnxBsmvWqeCWP59tFFDVFADG4FLRQW6IPUlD3mJLXxzsbsBUP4x67TAFeHynL/ZyImSlHXWBow3hWopwPouqQpkcIcUZxdt8zR9xmAiEwk8wUDWQg5aMoYp2a8zy7fuUL6PXyomRpoVWKHyZposl1cmST88NXjK+J14oWPHzKAd7zcY29XOXSbKnR</pre>
    <p>Fingerprints can be added to the <code>known_hosts</code> file in multiple ways, but there are two main ones:</p>
    <ul>
        <li>
            <p><b>Automatically when connecting to a server for the first time:</b> When you connect to a server using SSH for the first time, if the fingerprint isn't already trusted, the SSH client will show a warning, and prompt you to accept or decline the fingerprint:</p>
            <pre>$ ssh ldn01.jamieweb.net
The authenticity of host 'ldn01.jamieweb.net (139.162.222.67)' can't be established.
ECDSA key fingerprint is SHA256:cNtT9V+VonaofCCCYjtul100tp1/g/wqdUJZ76GYoP4.
Are you sure you want to continue connecting (yes/no)?</pre>
            <p>If you choose 'Yes', the full key fingerprint will be added to your <code>~/.ssh/known_hosts</code> file.</p>
        </li>
        <li>
           <p><b>Manually:</b> You can also manually add fingerprints to your <code>~/.ssh/known_hosts</code> file. The <a href="https://man.openbsd.org/sshd.8#SSH_KNOWN_HOSTS_FILE_FORMAT" target="_blank" rel="noopener">manual page</a> explain the format in detail.</p>
           <p>In order to actually acquire the fingerprint to add to the file, you can use the <code>ssh-keyscan</code> command. This tool is included as part of OpenSSH on most Linux distributions, and is used to show the fingerprint(s) of a local or remote server. For example:</p>
            <pre>$ ssh-keyscan ldn01.jamieweb.net
write (ldn01.jamieweb.net): Connection refused
# ldn01.jamieweb.net:22 SSH-2.0-OpenSSH_7.6p1
ldn01.jamieweb.net ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQC4bVleGrAZFttdMBen/ExLWbUUr5UaaX3Wd8U4nwH6LEaOMxuYu2cyrBuwIVZ9gjSoI0fEWhe345HeQJbdNzE/rd5ojebtS9bQiAB9+GVNKHxemBP01M0OaZJVA/GJnSzjdoEfrCGG8SWIDPQjY02yTQwgQHW5zYlr12Hq3FjKzofJ1Q2PSWbCy3crsA/R4vPHRVLPd8RDj+EXWVwvFgTHriuQWnt9Q/djy1LOPrqNgHn1n17cIED1M0zgXpImoLNC+Z44DmopVdmtwRW57IkedktWQdpCNRYTyOj/as/xn5YStXIWwxila16NYeq6O7zqoedWPiad6qnFloobOcft
# ldn01.jamieweb.net:22 SSH-2.0-OpenSSH_7.6p1
ldn01.jamieweb.net ecdsa-sha2-nistp256 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAAAIbmlzdHAyNTYAAABBBL1leJtyWMXV+xAny4v6E7JYM8CY4Oyac34L8gEDLGhvFWMIEHkjREVpfmWVLMYF7iMaaCY7ntxOfxSEReTQnV0=</pre>
            <p>Keep in mind that <code>ssh-keyscan</code> is still susceptible to man-in-the-middle and other spoofing/hijacking attacks, so it shouldn't be used as an authoritative method for checking the integrity/authenticity of keys.</p>
            <p>However, if you are running the <code>ssh-keyscan</code> tool against localhost, then that is a valid way to get the correct version of a fingerprint. This can then be used to check that you have the correct fingerprint on your other devices as well.</p>
        </li>
    </ul>
    <p>On some Linux distributions, the <code>HashKnownHosts on</code> option is used in the default global SSH client configuration (<code>/etc/ssh/ssh_config</code>). If this option is enabled, it means that the hostnames and/or IP addresses of the hosts in your <code>known_hosts</code> file will be hashed. This is a security feature designed to obscure the hosts that you have connected to, should an attacker gain access to your <code>known_hosts</code> file. However, in many cases, this protection will not be adequate, as there will be plenty of other evidence as to which servers you have been connecting to (<code>~/.bash_history</code>, local firewall logs, etc).</p>

    <h2 id="verifying-the-fingerprints">Verifying the Fingerprints</h2>
    <p>In order for the security model of SSH to be effective, it is absolutely imperative that you correctly verify the fingerprints of a server before connecting for the first time. Failing to do this is equivalent to bypassing a HTTPS certificate warning, or installing an Apt package that has invalid GPG fingerprints.</p>
    <p>Most public SSH servers share their official fingerprints through an alternate channel that is resistant to man-in-the-middle attacks, such as a website served over HTTPS. For example, here are the official fingerprints for <a href="https://docs.gitlab.com/ee/user/gitlab_com/#ssh-host-keys-fingerprints" target="_blank" rel="noopener">GitLab</a> and <a href="https://help.github.com/articles/github-s-ssh-key-fingerprints/" target="_blank" rel="noopener">GitHub</a>.</p>
    <p>Then, when connecting to the SSH server, you can verify that the fingerprint displayed on your screen match the official ones distributed by the provider:</p>
    <pre>$ ssh -T git@github.com
The authenticity of host 'github.com (140.82.118.4)' can't be established.
RSA key fingerprint is SHA256:nThbg6kXUpJWGl7E1IGOCspRomTxdCARLviKw6E5SY8.
Are you sure you want to continue connecting (yes/no)? yes
Warning: Permanently added 'github.com,140.82.118.4' (RSA) to the list of known hosts.</pre>
    <p>If you are setting up a new server of your own, checking the fingerprints can often be a challenge. My go-to solution to this is to log onto the server directly, i.e. using KVM or a remote console, and then checking the keys manually using <code>ssh-keyscan localhost</code>. Unless somebody is able to MitM connections to localhost (which is unlikely unless they're already on your server), this is a good way to check the fingerprints of a remote server before connecting.</p>
    <p>If for some reason it's not possible to get a verified fingerprint from the provider or by checking manually, there are still some things that you can do to gain some level of assurance of the authenticity of the fingerprint:</p>
    <ul class="spaced-list">
        <li>Check the fingerprint from multiple different devices and network connections</li>
        <li>Ask some trusted friends to check it from one of their own machines</li>
        <li>Check the fingerprint over Tor</li>
        <li>Check the fingerprint using a public internet connection</li>
    </ul>
    <p>If all of these methods return the same fingerprint, that is good assurance that there is no localised MitM attack ongoing. However, it's important to keep in mind that these methods do not protect against possible MitM attacks that are non-local, e.g. on the remote end or at the ISP or DNS level.</p>
    <p>The Qubes OS '<a href="https://www.qubes-os.org/security/verifying-signatures/" target="_blank" rel="noopener">Why and How to Verify Signatures</a>' documentation, while not directly about SSH, explains the mindset that you need to approach signature/fingerprint verification with really well. Their approach to '<a href="https://www.qubes-os.org/faq/#what-does-it-mean-to-distrust-the-infrastructure" target="_blank" rel="noopener">Distrusting the Infrastructure</a>' also fits in perfectly with the security model of SSH.</p>

    <h2 id="managing-known_hosts-using-git">Managing known_hosts Using Git</h2>
    <p>When I deploy new servers, they have new, unique SSH server key fingerprints, and I need to distribute these fingerprints securely to all of the other devices that will be connecting. For example, my Ansible control machine, log collector, etc.</p>
    <p>Previously, the was a manual job. For a couple of devices from time-to-time, it's not a major problem. However, now that I'm further going down the road of ephemeral infrastructure, where my individual servers are essentially fungible and can be redeployed in minutes using Ansible, I needed a better solution.</p>
    <p>I've created a <a href="https://gitlab.com/jamieweb/known_hosts" target="_blank" rel="noopener"> public Git repository on GitLab</a>, which I am using as an authoritative source for my server SSH key fingerprints. When a fingerprint changes, I just need to manually verify it, then update it in the repository using the <a href="https://gitlab.com/jamieweb/known_hosts/blob/master/update-known_hosts.sh" target="_blank" rel="noopener">little script</a> that is included.</p>
    <p>I recently redeployed my ldn01.jamieweb.net (London) server, which was my first time using this setup in production. I first took a note of the fingerprint directly on the server using console access and <code>ssh-keyscan localhost</code>, then proceeded as follows on my local development machine:</p>
    <pre>$ ./update-known_hosts.sh ldn01
Getting LIVE fingerprint for 'ldn01' (ldn01.jamieweb.net)...
Files /dev/fd/63 and /dev/fd/62 differ
The live fingerprint has CHANGED:
# ldn01.jamieweb.net:22 SSH-2.0-OpenSSH_7.6p1
ldn01.jamieweb.net ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQC4bVleGrAZFttdMBen/ExLWbUUr5UaaX3Wd8U4nwH6LEaOMxuYu2cyrBuwIVZ9gjSoI0fEWhe345HeQJbdNzE/rd5ojebtS9bQiAB9+GVNKHxemBP01M0OaZJVA/GJnSzjdoEfrCGG8SWIDPQjY02yTQwgQHW5zYlr12Hq3FjKzofJ1Q2PSWbCy3crsA/R4vPHRVLPd8RDj+EXWVwvFgTHriuQWnt9Q/djy1LOPrqNgHn1n17cIED1M0zgXpImoLNC+Z44DmopVdmtwRW57IkedktWQdpCNRYTyOj/as/xn5YStXIWwxila16NYeq6O7zqoedWPiad6qnFloobOcft
Accept updated fingerprint? (y/n) y
Updating saved fingerprint...
Done. Saved old fingerprint as ldn01/fingerprint.bak.</pre>
    <p>Note that I only accepted the changed fingerprint after checking that it matched the one I got directly from the server.</p>
    <p>Once the key fingerprint file had been updated, I committed the changes:</p>
    <img class="radius-8" src="git-commit.png" width="1000px" alt="A screenshot of a Git log, showing a commit for 'Updated ldn01 fingerprint'.">
    <p>Next, I pushed the changes to GitLab. In my case, I pushed to a completely separate staging repository first, so that I can formally review the changes on my sandboxed Ansible control machine before proceeding.</p>
    <p>In order to merge the changes from <code>jamieweb-staging/known_hosts</code> to <code>jamieweb/known_hosts</code>, I created, reviewed and accepted a <a href="https://gitlab.com/jamieweb/known_hosts/merge_requests/2/diffs" target="_blank" rel="noopener">merge request</a>:</p>
    <img class="radius-8" src="gitlab-merge-request-diff.png" width="1000px" alt="A screenshot of the merge request diff within GitLab.">
    <p>An interesting note about this diff is that the new fingerprint still shows the full OpenSSH version details from the SSH banner. This is because this was a completely fresh server that had been deployed only minutes earlier, and I had not yet run my Ansible playbooks to configure and update the server, part of which involves disabling the extended version information in the SSH banner with <code>DebianBanner no</code> in <code>/etc/ssh/sshd_config</code>.</p>
    <p>Once I had completed the merge request, I pulled the updated repository contents to my Ansible control machine, where I proceeded to run my playbooks against the new server securely over SSH. I didn't have to accept the fingerprint, as simply pulling from the Git repository had done that for me, in a secure and automated way.</p>

    <h2 id="client-configuration">Client Configuration</h2>
    <p>In order for this setup to work, there are a couple of minor client configurations that you'll need to do.</p>
    <ul>
        <li>
            <p><b>Firstly, you'll need to tell SSH where your fingerprints are stored:</b> This can be done using the <code>UserKnownHostsFile</code> option in your local (or global if you want) SSH config.</p>
            <p><code>UserKnownHostsFile</code> is a space-separated list of paths to files containing valid fingerprints that SSH will use when connecting to servers. The first defined file is used as the main one, and is where new fingerprints will be saved to. I prefer to use the default <code>~/.ssh/known_hosts</code> file as the main one, and then add the other files from the Git repository afterwards. For example:</p>
            <pre>UserKnownHostsFile ~/.ssh/known_hosts ~/jamieweb/known_hosts/ldn01/fingerprint ~/.ssh/known_hosts/nyc01/fingerprint</pre>
        </li>
        <li>
            <p><b>Secondly, when updating the fingerprints, you may have to remove the old ones from <code>~/.ssh/known_hosts</code>:</b> Depending on your configuration, SSH will add a copy of the fingerprints from the Git repository to the main fingerprints file (which in my case is <code>~/.ssh/known_hosts</code>. When you update the fingerprints by pulling from the Git repository in the future, you may need to remove (or comment out) the old ones in your main fingerprints file.</p>
            <p>This normally happens if there are already existing fingerprints in <code>~/.ssh/known_hosts</code> for the hostnames or IP addresses that you are managing the fingerprints for in Git.</p>
        </li>
    </ul>

    <h2 id="conclusion">Conclusion</h2>
    <p>This setup has resulted in an enormous improvement in efficiency when it comes to deploying and managing my infrastructure. It's another great example for why all manual processes should be automated in a repeatable and verifiable way, in order to ensure that infrastructure is robust and resilient.</p>
    <p>Using this setup has shaved off a significant percentage of my total infrastructure build time. However, I plan to keep using and working on this system in order to identify any further improvements that I can make.</p>
</div>

<?php include "footer.php" ?>
