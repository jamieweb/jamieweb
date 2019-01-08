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
    <p></p>

    <h2 id="chrooting">Chrooting</h2>
    <p></p>

    <h2 id="authorized_keys-file-options"><code>authorized_keys</code> File Options</h2>
    <p></p>

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
