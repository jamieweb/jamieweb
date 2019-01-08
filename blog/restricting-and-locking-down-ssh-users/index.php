<?php include "response-headers.php"; content_security_policy(); ?>
<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Restricting and Locking Down SSH Users</title>
    <meta name="description" content="Restricting SSH users to specific commands, directories and system access.">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/blog/restricting-and-locking-down-ssh-users/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Restricting and Locking Down SSH Users</h1>
    <hr>
    <p><b>Friday 10th January 2018</b></p>
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
    <p>There are two main options that are particularly useful for security: <code>restrict</code> and <code>command</code>. You can view a full list of options from the manual page here: <a href="https://linux.die.net/man/5/sshd_config" target="_blank" rel="noopener">https://linux.die.net/man/5/sshd_config</a></p>

    <h3 id="restrict"><code>restrict</code></h3>
    <p>The <code>restrict</code> option will enable <b>all</b> of the following restrictions for users authenticating against the key:</p>
    <ul>
        <li><code>no-agent-forwarding</code> - Disable SSH agent forwarding.</li>
        <li><code>no-port-forwarding</code> - Deny all port forwarding requests.</li>
        <li><code>no-pty</code> - Deny requests to allocate a tty.</li>
        <li><code>no-user-rc</code> - Disable execution of <code>~/.ssh/rc</code>.</li>
        <li><code>no-X11-forwarding</code> - Deny requests to forward an X11 session</li>
    </ul>

    <h2 id="forcecommand"><code>ForceCommand</code> Configuration</h2>
    <p></p>

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
