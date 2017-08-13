<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Half-Life Client Security</title>
    <meta name="description" content="Security configuration/hardening for the Half-Life client.">
    <meta name="keywords" content="Jamie, Scaife, jamie scaife, jamiescaife, jamieonubuntu, jamie90437, jamie90437x, jamieweb, jamieweb.net">
    <meta name="author" content="Jamie Scaife">
    <link href="/jamie.css" rel="stylesheet">
    <link href="https://www.jamieweb.net/info/hl-client-security/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Half-Life Client Security</h1>
    <hr>
    <p><b>Vulnerabilities:</b></p>
    <p>There are several ways that the Half-Life client can be exploited by malicious servers. These can range from obnoxious advertising to a full client takeover. The most common attack is "admin slowhacking", where a server will rewrite configuration files in order to takeover your client, usually forcing it to connect to a specific server at launch. Below are a few ways to harden your client in order to prevent slowhacking and other attacks.</p>
    <p><b>Console variables:</b></p>
    <p>Add these commands to your userconfig.cfg in order to disable certain functions that are commonly exploited:</p>
    <pre>cl_allowdownload 0
cl_allowupload 0
cl_download_ingame 0
cl_filterstuffcmd 1
sv_allowdownload 0
sv_allowupload 0</pre>
    <p>This will prevent your client from downloading custom assets when connecting to a server. These may include maps, models, textures, sounds, sprays, etc. The problem with this is that your client will no longer be able to automatically download custom content when connecting to a server. This is an issue for custom maps that you don't already have, so you'll have to download them from somewhere else. Servers that have a mandatory download of large amounts of custom models and sounds are probably best avoided.</p>
    <p>"cl_filterstuffcmd" is a command found only in versions of Half-Life from February 21st 2013 onwards. It blocks certain sensitive commands and prevents modification of certain console variables, making slowhacking much more difficult. There are ways for servers to bypass this though, so it shouldn't be trusted. Read more <a href="https://developer.valvesoftware.com/wiki/Admin_Slowhacking#List_of_blocked_cvars_and_commands" target="_blank">here</a> and <a href="https://github.com/ValveSoftware/halflife/issues/1497" target="_blank">here</a>.
    <p><b>Making configuration files read-only:</b></p>
    <p>Mark your configuration files as read-only in order to prevent malicious modification of them.</p>
    <p>The most important ones are:</p>
    <pre>autoexec.cfg
config.cfg
userconfig.cfg
valve.rc</pre>
    <p>However, you might as well do the rest of them too just to be on the safe side:</p>
    <pre>banned.cfg
default.cfg
listenserver.cfg
listip.cfg
resource
server.cfg
skill.cfg</pre>
    <p>Marking "config.cfg" as read-only will prevent you from modifying your in-game settings. This shouldn't be an issue once they are already set up, as you can still make temporary changes that last for the duration of your session using the console, as well as make changes manually.</p>
    <p>On Linux systems, use the following commands for all configuration files:</p>
    <pre>$ chmod -w valve.rc
$ sudo chown root:root valve.rc</pre>
    <p><b>Restricting Network Access:</b></h2>
    <p>By restricting network access to Half-Life, you can prevent it from communicating with any servers except for ones that you have whitelisted. This makes it difficult to find servers, however if you only play on a limited number of known, trusted servers it is a good solution.</p>
    <p>The configuration below is for Linux systems, however I'm sure that the same could be achieved using Windows Firewall or other tools for your operating system.</p>
    <p>Create a new group and add your user to that group:</p>
    <pre>$ sudo addgroup block-net
$ sudo adduser username block-net</pre>
    <p>Create and edit a script to be executed when your network interface is brought up:</p>
    <pre>$ sudo nano /etc/network/if-pre-up.d/block-net</pre>
    <p>The above path works for Ubuntu/Debian systems. Your own Linux distribution may use a different path.</p>
    <p>Add the following script to the file:</p>
    <pre>#!/bin/bash
iptables -I OUTPUT 1 -m owner --gid-owner block-net -j DROP</pre>
    <p>This will block all network access to any applications that are run as the group "block-net".</p>
    <p>You can then allow access to certain whitelisted IP addresses. For example, allow access to the master servers which are used to display the server list in the server browser:</p>
<pre>iptables -I OUTPUT 1 -d 208.64.200.117 -m owner --gid-owner block-net -j ACCEPT
iptables -I OUTPUT 1 -d 208.64.200.118 -m owner --gid-owner block-net -j ACCEPT</pre>
    <p>"208.64.200.117" and "208.64.200.118" are the official Half-Life master servers run by Valve. There are also third-party master servers, such as "188.40.40.201", which is what New Gauge Half-Life uses.</p>
    <pre>iptables -I OUTPUT 1 -d 188.40.40.201 -m owner --gid-owner block-net -j ACCEPT</pre>
    <p>The server browser will still show an empty list since it only shows servers that it can reach directly. So even though your client is able to reach the master servers, it can not reach any of the servers that the master servers return. Once you have whitelisted other trusted servers, they will appear in the server browser.</p>
    <p>Since this is not particularly user-friendly, I suggest finding servers using other sources, then whitelisting them manually before playing.</p>
    <p>If you add a server to your favourites list, you do not need to whitelist the master server IPs. Your client will reach out to the favourited servers directly and display them on the favourites tab.</p>
    <p>Mark the script as executable:</p>
    <pre>$ sudo chmod +x /etc/network/if-pre-up.d/block-net</pre>
    <p>The script will be automatically run whenever your network is brought up, such as at boot. To avoid rebooting right now, simply run the script:</p>
    <pre>$ sudo ./etc/network/if-pre-up.d/block-net</pre>
    <p>You can now run applications as the "block-net" group using the "sg" command, and they will only have access to the whitelisted IP addresses. For example:</p>
    <pre>sg block-net "ping 89.34.99.41"
PING 89.34.99.41 (89.34.99.41) 56(84) bytes of data.
ping: sendmsg: Operation not permitted</pre>
    <p>But if you ping a whitelisted address, you have access:</p>
    <pre>sg block-net "ping 208.64.200.117"
PING 208.64.200.117 (208.64.200.117) 56(84) bytes of data.
64 bytes from 208.64.200.117: icmp_seq=1 ttl=# time=# ms</pre>
    <p>Edit your launcher for Half-Life so that it is run under the "block-net" group. Then you will only have access to your trusted, whitelisted servers.</p>
</div>

<?php include "footer.php" ?>

</body>

</html>
