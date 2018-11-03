<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Booting a Physical Windows 10 Disk Using VirtualBox on Linux</title>
    <meta name="description" content="New Site Design">
    <meta name="keywords" content="Jamie, Scaife, jamie scaife, jamiescaife, jamieonubuntu, jamie90437, jamie90437x, jamieweb, jamieweb.net">
    <meta name="author" content="Jamie Scaife">
    <link href="/jamie.css" rel="stylesheet">
    <link href="https://www.jamieweb.net/blog/booting-a-physical-windows-10-disk-using-birtualbox-on-linux/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Booting a Physical Windows 10 Disk using VirtualBox on Linux</h1>
    <hr>
    <p><b>Sunday 4th November 2018</b></p>
    <p>I recently inherited a computer with an OEM/factory-imaged Windows 10 disk inside. Straight away I took the drive out and replaced it with a Linux SSD, however since I don't own any other Windows systems, this will come in useful for testing my website for browser compatibility in Internet Explorer and Edge.</p>
    <p>I have put the Windows 10 disk in a USB SATA drive enclosure, and configured VirtualBox to be able to boot the raw disk. Now I'm able to test my site in IE and Edge usng the virtual machine running on my system.</p>
    <pre><b>Booting a Physical Windows 10 Disk Using VirtualBox on Linux</b>
&#x2523&#x2501&#x2501 <a href="#installing-namecoin-core">Installing Namecoin Core</a>
&#x2523&#x2501&#x2501 <a href="#configuring-namecoin-core">Configuring Namecoin Core</a>
&#x2523&#x2501&#x2501 <a href="#buying-namecoin">Buying Namecoin</a>
&#x2523&#x2501&#x2501 <a href="#registering-domain">Registering A .bit Domain Name</a>
&#x2523&#x2501&#x2501 <a href="#configuring-domain">Configuring A .bit Domain Name</a>
&#x2523&#x2501&#x2501 <a href="#ncdns">Local DNS Resolver Setup (ncdns)</a>
&#x2523&#x2501&#x2501 <a href="#tls">TLS (HTTPS) Certificate Generation</a>
&#x2523&#x2501&#x2501 <a href="#apache-tls">Apache Web Server TLS Configuration</a>
&#x2523&#x2501&#x2501 <a href="#apache-vhost">Apache Web Server Virtual Host Configuration</a>
&#x2523&#x2501&#x2501 <a href="#problems">Problems With Namecoin</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>
    <h2 id="initial-setup">
    <p>If you notice any mistakes, errors or 404 links, please let me know. Thanks!</p>
</div>

<?php include "footer.php" ?>

</body>

</html>
