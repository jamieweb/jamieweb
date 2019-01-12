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
&#x2523&#x2501&#x2501 <a href="#restricted-shells">Restricted Shells</a>
&#x2523&#x2501&#x2501 <a href="#chrooting">Chrooting</a>
&#x2523&#x2501&#x2501 <a href="#authorized_keys-file-options">authorized_keys File Options</a>
&#x2523&#x2501&#x2501 <a href="#forcecommand">ForceCommand Configuration</a>
&#x2523&#x2501&#x2501 <a href="#user-and-group-whitelisting">User and Group Whitelisting</a>
&#x2523&#x2501&#x2501 <a href="#secure-sftp-configuration">Creating a Secure SFTP Configuration</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>

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
    <p></p>

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
    <p>Please note that the <code>command</code> option will be overidden by <a href="#forcecommand"><code>ForceCommand</code></a> if it is set in <code>/etc/ssh/sshd_config</code>.</p>

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
    <p>The <code>ForceCommand</code> option is very similar to the <a href="#command"><code>command</code></a> option described above, however it is set in the server configuration in <code>/etc/ssh/sshd_config</code> rather than on a per-key basis in <code>authorized_keys</code>.</p>
    <p><code>ForceCommand</code> is most useful in <code>Match</code> blocks, as shown below:</p>
    <pre>Match user jamie
  ForceCommand echo "Hello"</pre>
    <p>This configuration will force the user <code>jamie</code> to execute the command <code>echo "Hello"</code> upon connection, and then disconnect (unless something else such as X11 forwarding keeps the connection open).</p>
    <p>You can also use <code>ForceCommand internal-sftp</code> to force the creation of an in-process SFTP server which doesn't require any support files when used in a chroot jail. This option is best combined with the <a href="#crooting"><code>ChrootDirectory</code></a> option.</p>

    <h2 id="user-and-group-whitelisting">User and Group Whitelisting</h2>
    <p></p>

    <h2 id="secure-sftp-configuration">Creating a Secure SFTP Configuration</h2>
    <p></p>

    <h2 id="conclusion">Conclusion</h2>
    <p></p>
</div>

<?php include "footer.php" ?>

</body>

</html>
