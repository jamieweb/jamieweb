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
    <h2 id="identifying-the-disk">Identifying the Disk</h2>
    <p>Mounting the disk/partitions is not actually required for VirtualBox to be able to boot it, however you will need to identify the correct block device ID for the disk (e.g. <code>/dev/sdb</code>).</p>
    <p>If you're using a modern desktop environment and file manager (e.g. XFCE with Thunar), the Windows 10 disk will probably be automatically mounted (if you get stuck at the error 'Windows is hibernated, refused to mount.', please see the troubleshooting <a href="#windows-is-hibernated-refused-to-mount" target="_blank">here</a>). In my case, the <code>Windows</code> and <code>Recovery Image</code> partitions were auto-mounted. Then, you can use <code>lsblk</code> (List Block Devices) to identify the correct device:</p>
    <pre>jamie@box:~$ lsblk
NAME           MAJ:MIN RM   SIZE RO TYPE  MOUNTPOINT
sdb              8:16   0 931.5G  0 disk  
├─sdb4           8:20   0   980M  0 part  
├─sdb2           8:18   0   128M  0 part  
├─sdb5           8:21   0  17.2G  0 part  /media/jamie/Recovery Image
├─sdb3           8:19   0 912.9G  0 part  /media/jamie/Windows
└─sdb1           8:17   0   360M  0 part  
sda              8:0    0 111.8G  0 disk  
├─sda2           8:2    0     1K  0 part  
├─sda5           8:5    0   3.9G  0 part  
│ └─cryptswap1 253:0    0   3.9G  0 crypt 
└─sda1           8:1    0 107.9G  0 part  /</pre>
    <p>From this, you can determine that <code>/dev/sdb</code> is the Windows 10 disk.</p>
    <p><b>If your disk is not automatically mounted, you don't need to mount it.</b> You can use <code>lshw</code> to determine the correct device:</p>
    <pre>jamie@box:~$ sudo lshw -short -class disk,volume
H/W path               Device           Class          Description
==================================================================
/0/100/14/0/7/0.0.0    /dev/sdb         disk           1TB 2115
/0/100/14/0/7/0.0.0/1  /dev/sdb1        volume         359MiB Windows FAT volume
/0/100/14/0/7/0.0.0/2  /dev/sdb2        volume         127MiB reserved partition
/0/100/14/0/7/0.0.0/3  /dev/sdb3        volume         912GiB Windows NTFS volume
/0/100/14/0/7/0.0.0/4  /dev/sdb4        volume         979MiB Windows NTFS volume
/0/100/14/0/7/0.0.0/5  /dev/sdb5        volume         17GiB Windows NTFS volume
/0/1/0.0.0             /dev/sda         disk           120GB KINGSTON SV300S3
/0/1/0.0.0/1           /dev/sda1        volume         107GiB EXT4 volume
/0/1/0.0.0/2           /dev/sda2        volume         4008MiB Extended partition
/0/1/0.0.0/2/5         /dev/sda5        volume         4008MiB Linux swap / Solaris partition</pre>
    <p>From this output, you can see that <code>/dev/sdb</code> is the Windows 10 disk.</p>

    <h2 id="file-system-permissions">File System Permissions</h2>
    <p>In order to have full, unrestricted access to the Windows 10 disk without having to use <code>sudo</code>, you need to give your user account the appropriate permissions.</p>
    <p>First, determine the group that has access to the drive. <b>Substitute <code>/dev/sdb</code> with the block device ID that you determined in the previous section:</b></p>
    <pre>jamie@box:~$ ls -la /dev/sdb
brw-rw---- 1 root disk 8, 16 Nov  3 23:36 /dev/sdb</pre>
    <p>From this, you can determine that the group is <code>disk</code>, and that this group has read and write access to the block device (<code>brw-<b>rw-</b>---</code>).</p>
    <p>The group name and permissions may differ for you, however in many cases it will be as above.</p>
</div>

<?php include "footer.php" ?>

</body>

</html>
