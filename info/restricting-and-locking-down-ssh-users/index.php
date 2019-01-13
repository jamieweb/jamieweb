<?php include "response-headers.php"; content_security_policy(); ?>
<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Restricting and Locking Down SSH Users</title>
    <meta name="description" content="Restricting SSH users to specific commands, directories and system access.">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/info/restricting-and-locking-down-ssh-users/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Restricting and Locking Down SSH Users</h1>
    <hr>
    <p>This article outlines a number of techniques for restricting and locking down SSH users on Linux systems, and how you can use multiple different protections at once to create the most secure setup.</p>
    <p><b>Skip to Section:</b></p>
    <pre><b>Restricting and Locking Down SSH Users</b>
&#x2523&#x2501&#x2501 <a href="#ssh-security-strategy">SSH Security Strategy</a>
&#x2523&#x2501&#x2501 <a href="#restricted-shells">Restricted Shells</a>
&#x2523&#x2501&#x2501 <a href="#chrooting">Chrooting</a>
&#x2523&#x2501&#x2501 <a href="#authorized_keys-file-options">authorized_keys File Options</a>
&#x2523&#x2501&#x2501 <a href="#forcecommand">ForceCommand Configuration</a>
&#x2523&#x2501&#x2501 <a href="#ip-host-whitelisting">IP/Host Whitelisting</a>
&#x2517&#x2501&#x2501 <a href="#secure-sftp-configuration">Creating a Secure SFTP Configuration</a></pre>

    <h2 id="ssh-security-strategy">SSH Security Strategy</h2>
    <p>My personal strategy when it comes to locking down and restricting SSH users is to ensure that there are <b>always</b> multiple protections in place, so that if one were to fail, it fails securely, rather than failing open.</p>
    <h3 id="why-would-an-ssh-security-configuration-fail">Why would an SSH security configuration fail?</h3>
    <p>There are many ways that an SSH security configuration could fail:</p>
    <ul class="spaced-list">
        <li>A software update overwrites your custom configuration file</li>
        <li>You make an error in a configuration file, which isn't detected until it's too late</li>
        <li>Another user updates the configuration without realising what it does or why it's there</li>
        <li>You rotate your keys or change your username and forget to update the security configurations accordingly</li>
        <li>An attacker or piece of malware gains partial access to your system, allowing them to override some security controls but not others</li>
        <li>A bug in OpenSSH or other supporting libraries causes a security control to be bypassable</li>
    </ul>
    <p>The key message is that relying on more than one security control is great defence-in-depth and hardening, and really has the potential to save you should something go wrong.</p>
    <p>In this article, I have explained each control individually, however in most cases they can be easily combined without any problems. <a href="#secure-sftp-configuration">At the end of this page</a>, I have documented a secure SFTP configuration, which combines multiple security controls in order to result in a secure, restricted directory that can be accessed via SFTP.</p>    

    <h2 id="restricted-shells">Restricted Shells</h2>
    <p>User accounts can be restricted by setting their shell to be either restricted, or completely disabled.</p>

    <h3 id="rssh">rssh</h3>
    <p>rssh is a restricted shell which allows you to impose restrictions on user accounts accessing an SSH server. You can view the manual page here: <a href="https://linux.die.net/man/1/rssh" target="_blank" rel="noopener">https://linux.die.net/man/1/rssh</a></p>
    <p>For Debian-based systems, you can install rssh using <code>apt install rssh</code>. In order for rssh to effective, you'll have to set the shell of the user you want to restrict to be rssh. The path of the rssh binary is probably <code>/usr/bin/rssh</code>, however you can double-check with <code>which rssh</code>.</p>
    <p>In order to change the shell of an existing user to rssh, you can use <code>usermod --shell /usr/bin/rssh username</code>, and in order to create a new user with rssh as the default shell, you can use <code>adduser --shell /usr/bin/rssh username</code>.</p>
    <p>Now when you try to log in as the restricted user, you'll see the following message:</p>
    <pre>This account is restricted by rssh.
This user is locked out.

If you believe this is in error, please contact your system administrator.</pre>
    <p>In order to remove specific restrictions to give access to the system features you need, edit the file <code>/etc/rssh.conf</code>:</p>
    <pre># This is the default rssh config file

# set the log facility.  "LOG_USER" and "user" are equivalent.
logfacility = LOG_USER 

# Leave these all commented out to make the default action for rssh to lock
# users out completely...

#allowscp
#allowsftp
#allowcvs
#allowrdist
#allowrsync
#allowsvnserve
...</pre>
    <p>To remove the restrictions for a particular service (e.g. scp), simply remove the hash (#) from the start of the line, then save the file. Log out and back in, and the user will have the newly adjusted restrictions.</p>

    <h3 id="usr-sbin-nologin">nologin</h3>
    <p>An alternative restricted shell is nologin, which is a shell that completed disables the ability for the user to log in. On Debian-based systems the path is usually <code>/usr/sbin/nologin</code>, however you can double-check using <code>which nologin</code>.</p>
    <p>In order to change the shell of an existing user to nologin, you can use <code>usermod --shell /usr/sbin/nologin username</code>, and in order to create a new user with nologin as the default shell, you can use <code>adduser --shell /usr/sbin/nologin username</code>.</p>
    <p>If you attempt to log in to a user which uses the nologin shell, you'll see the following message:</p>
    <pre>This account is currently not available.</pre>
    <p>The nologin shell is best used along with other protections in this article in order to provide failover should one of your configuration files be overwritten or a user account changed accidentally.</p>

    <h2 id="chrooting">Chrooting</h2>
    <p>Crooting simply refers to changing the perceived root directory of a system, but the term 'croot jail' is often used to describe the use of croot to provide security. Crooting can provide security by limiting the resources and files that a particular user or application can access, helping to prevent a further system compromise or privilegde escalation should the crooted user or application turn rogue.</p>
    <p>There are several different ways to croot on Linux, but a particularly useful method for crooting SSH users is the <code>CrootDirectory</code> option in <code>sshd_config</code>. It's most useful when used inside a <code>Match</code> block, as shown below:</p>
    <pre>Match User jamie
  CrootDirectory /home/jamie/</pre>
    <p>This configuration will restrict the <code>jamie</code> user to <code>/home/jamie/</code>. Running <code>ls /</code> as this crooted user will show the contents of <code>/home/jamie</code>, but this will be transprent to the user in the croot jail.</p>
    <p>Setting this configuration and connecting via SSH will probably result in an error like below:</p>
    <pre>packet_write_wait: Connection to 192.168.1.8 port 22: Broken pipe</pre>
    <p>This is because the chroot directory must be fully owned by root in order for chrooting to be possible. You can change this using <code>chown root:root /path/to/chroot/dir</code>.</p>
    <p>Then, upon connecting, you'll most likely see a further error:</p>
    <pre>/bin/bash: No such file or directory</pre>
    <p>This is because the user is trying to start their shell, which in this case is <code>/bin/bash</code>. However, <code>/bin/bash</code> doesn't exist at the path <code>/home/jamie/bin/bash</code>, so the connection fails.</p>
    <p>In order to resolve this, all of the required files and directories for whatever you want to be able to do within the croot jail need to be available. To run a basic bash shell, the required files/directories are usually just the following:</p>
    <ul>
        <li>/bin/bash</li>
        <li>/lib</li>
        <li>/lib64</li>
    </ul>
    <p>However, in some cases you'll also need <code>/usr</code>.</p>
    <p>You can copy all of these into your chroot jail by executing the following commands whilst in your desired chroot directory:</p>
    <pre>$ mkdir bin
$ cp /bin/bash bin
$ cp /lib /lib64 .</pre>
    <p>The total size of these files depends on the exact system type, but for a Xubuntu 16.04 machine they are around 1 GB. It would be very inefficient to store multiple copies of these files if you had more than 1 chroot jail, however you can use <a href="https://unix.stackexchange.com/questions/214647/how-to-use-bindfs-to-create-a-shared-folder-between-a-chroot-environment-and-its" target="_blank" rel="noopener">bind mounts</a> to share the files between your host and the chroot directory. <b>This can have serious security implications if not done properly, as it would potentially allow the chrooted user or application to modify files outside of their jail, which could lead to a full chroot escape and system compromise.</b></p>
    <p>In addition to the basic files required to get a bash shell working, you'll also need to copy in anything else that is needed to do whatever you want your chrooted SSH user to be able to do. If you need to copy in more executable files, the <code>ldd</code> (list dynamic dependencies) command will help you to identify which libraries a particular program requires, so that you can copy those in too. For example:</p>
    <pre>ldd /bin/cat
        linux-vdso.so.1 =>  (0x00007ffcc838e000)
        libc.so.6 => /lib/x86_64-linux-gnu/libc.so.6 (0x00007fd58773e000)
        /lib64/ld-linux-x86-64.so.2 (0x00007fd587b08000)</pre>
    <p>When you log in to the chrooted user via SSH, you'll be fully restricted to the chroot directory, and will only be able to use the commands/programs that are available to you. For example, with a basic chroot containing only only bash and the required libraries, the resulting chroot environment will just have a raw bash prompt, and the only commands available will be bash builtins such as <code>pwd</code>, <code>cd</code> and <code>printf</code>.</p>

    <h2 id="authorized_keys-file-options"><code>authorized_keys</code> File Options</h2>
    <p>It's possible to impose restrictions on users on a per-key basis using options in the <code>authorized_keys</code> file.</p>
    <p>There are two main options that are particularly useful for security: <code>restrict</code> and <code>command</code>. You can view a full list of options on the manual page here: <a href="https://linux.die.net/man/5/sshd_config" target="_blank" rel="noopener">https://linux.die.net/man/5/sshd_config</a></p>

    <h3 id="restrict">'<code>restrict</code>'</h3>
    <p>The <code>restrict</code> option will enable <b>all</b> of the following restrictions for users authenticating against the key:</p>
    <ul>
        <li><code>no-agent-forwarding</code> - Disable SSH agent forwarding.</li>
        <li><code>no-port-forwarding</code> - Deny all port forwarding requests.</li>
        <li><code>no-pty</code> - Deny requests to allocate a tty.</li>
        <li><code>no-user-rc</code> - Disable execution of <code>~/.ssh/rc</code>.</li>
        <li><code>no-X11-forwarding</code> - Deny requests to forward an X11 session</li>
    </ul>
    <p>You can then re-enable specific functionality using the corresponding options without the <code>no-</code> prefix.</p>
    <p>If you wish to have an insecure-by-default setup and just lock down individual options, you can just use the restrictions with the <code>no-</code> prefix on their own (i.e. without setting <code>restrict</code>), however it is definitely more secure to use <code>restrict</code> and then override specific restrictions where needed.</p>

    <h3 id="command">'<code>command</code>'</h3>
    <p>The <code>command</code> option allows you to force execution of a specific command using the user's shell upon initial connection. The output of the command is sent back to the connecting client, and then it is disconnected (unless another feature such as TCP forwarding is in-use).</p>
    <p>The <code>command</code> is best used along with the restrictions describe <a href="#restrict">above</a> in order to ensure a high level of security.</p>
    <p>Please note that the <code>command</code> option will be overidden by <a href="#forcecommand"><code>ForceCommand</code></a> if it is set in <code>sshd_config</code>.</p>

    <h3 id="implementing-authorized_keys-options">Implementing the Options in <code>authorized_keys</code></h3>
    <p>The options for a specific key should be set in the <code>authorized_keys</code> file in a comma-separated format directly before the key. A space should be used between the options and the key. In the examples below I have used <code>ssh-rsa AAAB...</code> as a placeholder for the key, but in reality this is where <b>your</b> SSH public key goes.</p>
    <p>Example configuration:</p>
    <pre>restrict,X11-forwarding,command="ls -la" ssh-rsa AAAB...</pre>
    <p>This particular setup will restrict any users that connect using this key, but still allow X11 forwarding to take place. Upon connection, the command <code>ls -la</code> will be executed using the user's shell.</p>
    <p>If you just want to restrict the user fully, then you'll need to use:</p>
    <pre>restrict ssh-rsa AAAB...</pre>
    <p>...and if you want to enforce no specific restrictions, but enforce the execution of a specific command, use:</p>
    <pre>command="echo \"Hello\"" ssh-rsa AAAB...</pre>
    <p>Notice that double quotes (") must be escaped in the command configuration value.</p>    

    <h2 id="forcecommand"><code>ForceCommand</code> Configuration</h2>
    <p>The <code>ForceCommand</code> option is very similar to the <a href="#command"><code>command</code></a> option described above, however it is set in the server configuration in <code>sshd_config</code> rather than on a per-key basis in <code>authorized_keys</code>.</p>
    <p><code>ForceCommand</code> is most useful in <code>Match</code> blocks, as shown below:</p>
    <pre>Match User jamie
  ForceCommand echo "Hello"</pre>
    <p>This configuration will force the user <code>jamie</code> to execute the command <code>echo "Hello"</code> upon connection, and then disconnect (unless something else such as X11 forwarding keeps the connection open).</p>
    <p>You can also use <code>ForceCommand internal-sftp</code> to force the creation of an in-process SFTP server which doesn't require any support files when used in a chroot jail. This option is best combined with the <a href="#crooting"><code>ChrootDirectory</code></a> option.</p>

    <h2 id="ip-host-whitelisting">IP/Host Whitelisting</h2>
    <p>SSH users can be restricted to connecting from specific hosts using the <code>AllowUsers</code> option in <code>sshd_config</code>.</p>
    <p>The syntax for <code>AllowUsers</code> is <code>localuser[@remotehost]</code>. Ensure that you don't accidentally use <code>remoteuser[@remotehost]</code>, as this is incorrect.</p>
    <p>For example, in order to restrict the <code>jamie</code> user to connecting from 192.168.1.2:</p>
    <pre>AllowUsers jamie@192.168.1.2</pre>
    <p>You can specify multiple users in the same line:</p>
    <pre>AllowUsers jamie@192.168.1.2 fred@192.168.1.3</pre>
    <p>You can also choose multiple different hosts for the same user, for example an IPv4 and IPv6 address, or the addresses of completely separate machines entirely:</p>
    <pre>AllowUsers jamie@192.168.1.2 jamie@2a01:db8::1</pre>
    <p>Wildcards are supported too, both on user names and IPv4 addresses:</p>
    <pre>AllowUsers jamie@192.168.* fred@10.*.5.* *@172.16.0.1</pre>

    <h2 id="secure-sftp-configuration">Creating a Secure SFTP Configuration</h2>
    <p>My <a href="/projects/computing-stats/" target="_blank">Raspberry Pi cluster</a> uploads statistics from each of the nodes to the main JamieWeb server every 10 minutes using a secure SFTP link. This is locked down throughly in order to ensure that the impact would be as low as possible were the Raspberry Pi's to be compromised and taken over by an attacker.</p>
    <p>The result is that the Raspberry Pi's only have SFTP access to a specific directory, and they can only read and write the exact files that they need to be able to, and nothing more.</p>
    <p>The configuration is as follows:</p>
    <ul class="spaced-list">
        <li>The Raspberry Pi service account on the JamieWeb server uses the shell <code>/usr/sbin/nologin</code></li>
        <li><code>/etc/ssh/sshd_config</code> has the following configuration:
        <pre>Match User service_pi
    ForceCommand internal-sftp
    ChrootDirectory /home/service_pi/sftp/</pre></li>
        <li>The SSH public key used for authenticating connections in <code>/home/service_pi/.ssh/authorized_keys</code> has the following options:
        <pre>restrict,command="false" ssh-rsa AAAB...</pre></li>
        <li>The chroot directory (<code>/home/service_pi/sftp/</code>) is fully owned by root, and only the exact files that <code>service_pi</code> need to be able to write to have write permissions.</li>
        <li>The files are treated as untrusted and actively dangerous until they have been moved to a secure directory and passed a thorough, line-by-line verification process.</li>
    </ul>
    <p>This configuration provides a high level of defence-in-depth and hardening, and means that even if multiple of these controls were to fail, it is unlikely that an attacker would be able to get to a shell on my server to cause more serious damage.</p>
</div>

<?php include "footer.php" ?>

</body>

</html>











