<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Half-Life Client Security</title>
    <meta name="description" content="Security configuration/hardening for the Half-Life client.">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/info/hl-client-security/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Half-Life Client Security</h1>
    <hr>
    <p>There are several ways that the Half-Life client can be exploited by malicious servers, which can range from obnoxious advertising to a full client takeover. The most common attack is "admin slowhacking", where a server will rewrite configuration files in order to takeover your client, usually modifying controls or forcing it to connect to a specific server at launch.</p>
    <p>Other attacks include servers repeatedly sending the "screenshot" command to your client in order to fill up your storage as well as servers that send the "cd" command in order to physically open your CD drive.</p>
    <p>Below are a few ways to harden your client in order to prevent slowhacking and other attacks.</p>
    <p>Some of these configurations overlap eachother, so do whatever is best for your own situation.</p>
    <p><b>Skip to Section:</b></p>
    <pre><b>Half-Life Client Security</b>
&#x2523&#x2501&#x2501 <a href="#cvars">Console Variables</a>
&#x2523&#x2501&#x2501 <a href="#config-readonly">Read-only Config Files</a>
&#x2523&#x2501&#x2501 <a href="#directory-readonly">Read-only Game Directory</a>
&#x2523&#x2501&#x2501 <a href="#dlls">Using Separate DLLs</a>
&#x2517&#x2501&#x2501 <a href="#network">Restricting Network Access</a></pre>
    <h2 id="cvars">Console Variables</h2>
    <p>Add these commands to your userconfig.cfg in order to disable certain functions that are commonly exploited:</p>
    <pre>cl_allowdownload 0
cl_allowupload 0
cl_download_ingame 0
cl_filterstuffcmd 1
sv_allowdownload 0
sv_allowupload 0
voice_enable 0</pre>
    <p>This will prevent your client from downloading custom assets when connecting to a server. These may include maps, models, textures, sounds, sprays, etc. The problem with this is that your client will no longer be able to automatically download custom content when connecting to a server. This is an issue for custom maps that you don't already have, so you'll have to download them from somewhere else. Servers that have a mandatory download of large amounts of custom models and sounds are probably best avoided.</p>
    <p>Unfortunately, in older versions of the game it is possible for malicious servers to override the download blocking commands by simply sending them to your client before the downloads begin.</p>
    <p>"cl_filterstuffcmd" is a command found only in versions of Half-Life from February 21st 2013 onwards. It blocks certain sensitive commands and prevents modification of certain console variables, making slowhacking much more difficult. There are ways for servers to bypass this though, so it shouldn't be trusted. Read more <a href="https://developer.valvesoftware.com/wiki/Admin_Slowhacking#List_of_blocked_cvars_and_commands" target="_blank" rel="noopener">here</a> and <a href="https://github.com/ValveSoftware/halflife/issues/1497" target="_blank" rel="noopener">here</a>.</p>
    <p>"voice_enable 0" will disabled voice communication. There most likely isn't a direct security benefit to this, however if you don't need voice communication then it's a good idea to disable it to reduce the potential attack surface.</p>
    <h2 id="config-readonly">Read-only Config Files</h2>
    <p>Mark your configuration files as read-only in order to prevent malicious modification of them.</p>
    <p>The most important ones are:</p>
    <pre>autoexec.cfg
config.cfg
userconfig.cfg
valve.rc</pre>
    <p>However, you might as well do the rest of them too just to be on the safe side:</p>
    <pre>banned.cfg
default.cfg
hltv.cfg
listenserver.cfg
listip.cfg
server.cfg
skill.cfg</pre>
    <p>Marking "config.cfg" as read-only will prevent you from modifying your in-game settings. This shouldn't be an issue once they are already set up, as you can still make temporary changes that last for the duration of your session using the console, as well as make changes manually.</p>
    <p>On Linux systems, use the following commands for all configuration files:</p>
    <pre>$ chmod -w valve.rc
$ sudo chown root:root valve.rc</pre>
    <p>If you have any mods installed such as "bshift" or "gearbox", you should also change your configuration file permissions there as well.</p>
    <h2 id="directory-readonly">Read-only Game Directory</h2>
    <p>Setting your entire game directory to read-only will prevent any sort of modification of it. This protects against servers that override your download preferences as well as the screenshot attack.</p>
    <p>The screenshot attack is where malicious servers send repeated screenshot commands to your client in order to take screenshots and fill up your storage. The "screenshot" command takes raw screen captures in TGA format, which are 6.2 MB in size for a 1920x1080 display. As you can imagine, thousands of these could quickly fill up your storage.</p>
    <p>On Linux systems, use the following commands on your Half-Life directory (in this case it is called "hl").</p>
    <p>As always, be extremely careful when operating recursively on any directory:</p>
    <pre>$ sudo chmod -R ugo-wx hl
$ sudo chown -R root:root hl
$ sudo find hl -type d -exec chmod +x {} +</pre>
    <p>This will mark your entire hl/ directory as read only and owned by root, but then give back execute permissions to directories only in order to allow directory listings, which are required for the game to run. If you would like to allow saving and loading, you must also allow writing to the valve/save/ folder:</p>
    <pre>$ sudo chmod -R ug+w hl/valve/save
$ sudo chown -R user:group hl/valve/save</pre>
    <p>In the second command above, replace "user" and "group" with whatever user and group you are running the game under. By default this will just be your normal username, but if you're using the network whitelisting configuration from below, make sure to use the group you created there.</p>
    <p>Keep in mind that Half-Life needs write access in order to load certain saves, which seems to be because it creates various temporary files containing other data. The client behaves extremely weirdly when it doesn't have write access to saves, often losing player coordinates and sometimes loading a completely different save to the one you specified. Read more <a href="https://developer.valvesoftware.com/wiki/Save_Game_Files" target="_blank" rel="noopener">here</a>.</p>
    <p>If you have any mods installed such as "bshift" or "gearbox", you must also configure the correct save folder permissions there as well.</p>

    <h2 id="dlls">Using Separate DLLs</h2>
    <p>You can use different client and server DLLs for different modes of play. For example, you can use the DLLs from the latest Steam build for online play, then use the older Bunnymod DLLs for offline play. The latest Steam DLLs are the most up-to-date available, so they should theoretically be the most secure to use.</p>
    <p>This applies mostly to Windows DLL files since most mods use them. If you happen to have modded Linux .so files or modded macOS .dylib files, you can do this for them too.</p>
    <p>In order to add a new game version, create a new folder in your Half-Life directory, for example "olddlls". Inside this new folder, create the folders "cl_dlls" and "dlls".</p>
    <p>Now you can put into the DLL folders whatever DLLs you would like to use for this version. For example, if this version is to use for offline play, you could use out of date, vulnerable DLLs from a mod or older version of the game.</p>
    <p>"client.dll" needs to be put into the "cl_dlls" folder, and "hl.dll" needs to go into the "dlls" folder. You do not need to copy across "GameUI.dll" or "particleman.dll", since the game will load these from the default valve directory.</p>
    <p>If you are using a game version solely for online play, you do not need the "hl.dll" file. This file is used to run the local game server for your client to connect to. When you are playing online, you are connecting to a remote server rather than a local one, so the "hl.dll" file is not required. However, the game will crash if you try to play offline without a server DLL, so it's up to you whether you want to put it in the folder or not.</p>
    <p>Copy the file "liblist.gam" from the valve folder into your new game version folder. Edit the file and change the "name" value to whatever you desire, this name is what will appear in the "Change Game" menu. For example:</p>
    <pre>// Valve Game Info file
//  These are key/value pairs.  Certain mods will use different settings.
//
game "Old DLLs"
startmap "c0a0"
trainmap "t0a0"
mpentity "info_player_deathmatch"
gamedll "dlls\hl.dll"
gamedll_linux "dlls/hl_i386.so"
type "singleplayer_only"</pre>
    <p>If your version of the game doesn't have the "Change Game" option on the main menu (Steam version has it disabled by default), you should enable it in order to allow you to easily switch between versions. This can do this by editing the file valve/resource/GameMenu.res and setting the "notsteam" value to "0" in entry 13 (this may be a different number for you), as seen below:</p>
    <pre>"13"
{
        "label" "#GameUI_GameMenu_ChangeGame"
        "command" "OpenChangeGameDialog"
        "notsteam" "0"
        "notsingle" "1"
        "notmulti" "1"
}</pre>
    <p>Now you will have an extra button your main menu named "Change Game". Clicking it will open a list of other available games that you can switch to, such as your new "Old DLLs" version as well as Blue Shift or Opposing Force if you have them.</p>
    <p>In some cases, it is not possible to enable the "Change Game" menu item. If this is the case, make a copy of your Half-Life launcher or shortcut file, and add "-game NAME" to the launch options. Change the "NAME" variable to the name of the version directory. For example, "hl.exe -game olddlls".</p>
    <p>You can also copy across your "config.cfg" file from the valve folder in order to avoid having to set up your controls again. You do not need to copy any other configuration files (including userconfig.cfg), as these will all be read from the default valve directory.</p>
    <p>You can also hide the server browser from the menu on your insecure game version. In the insecure game version folder, create the folder "resource", and then copy across the file "GameMenu.res" from the valve/resource directory.</p>
    <p>Edit the file and delete entry 9 (this may be a different number for you):</p>
    <pre>"9"
{
        "label" "#GameUI_GameMenu_FindServers"
        "command" "OpenServerBrowser"
        "notsingle" "1"
}</pre>
    <p>You should then edit the numbers of the other entries to make sure that they are in order. This isn't mandatory, but it's best to keep the file clean and properly ordered.</p>
    <p>This just prevents you from accidentally opening the server browser and connecting to a server, you can still connect to a server using the console if you really want to.</p>

    <h2 id="network">Restricting Network Access</h2>
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
    <p>You can then allow access to certain whitelisted IP addresses. For example, add the following to the file in order to allow access to the master servers which are used to display the server list in the server browser:</p>
<pre>iptables -I OUTPUT 1 -d 208.64.200.117 -m owner --gid-owner block-net -j ACCEPT
iptables -I OUTPUT 1 -d 208.64.200.118 -m owner --gid-owner block-net -j ACCEPT</pre>
    <p>"208.64.200.117" and "208.64.200.118" are the official Half-Life master servers run by Valve.</p>
    <p><b>The server browser will still show an empty list since it only shows servers that it can reach directly.</b> Even though your client is able to reach the master servers, it can not reach any of the servers that the master servers return. Once you have whitelisted other trusted servers, they will appear in the server browser.</p>
    <p>Since this is not particularly user-friendly, I suggest finding servers using other sources, then whitelisting them manually using the file above before playing.</p>
    <p>You can also specify the port for whitelisting, as shown below with an example server IP and default port:</p>
    <pre>iptables -I OUTPUT 1 -d 139.162.222.67 -p tcp --dport 27015 -m owner --gid-owner block-net -j ACCEPT
iptables -I OUTPUT 1 -d 139.162.222.67 -p udp --dport 27015 -m owner --gid-owner block-net -j ACCEPT</pre>
    <p>The default server port is 27015, and the default master server port is anything between 27010 and 27013. For more information see <a href="https://developer.valvesoftware.com/wiki/Master_Server_Query_Protocol" target="_blank" rel="noopener">Master Server Query Protocol</a>.</p>
    <p>If you add a server to your favourites list, you do not need to whitelist the master server IPs. Your client will reach out to the favourited servers directly and display them on the favourites tab.</p>
    <p>Mark the script as executable:</p>
    <pre>$ sudo chmod +x /etc/network/if-pre-up.d/block-net</pre>
    <p>The script will be automatically run whenever your network is brought up, such as at boot. To avoid rebooting right now, simply run the script:</p>
    <pre>$ sudo ./etc/network/if-pre-up.d/block-net</pre>
    <p>You can now run applications as the "block-net" group using the "sg" command, and they will only have access to the whitelisted IP addresses. For example:</p>
    <pre>$ sg block-net "ping 139.162.222.67"
PING 139.162.222.67 (139.162.222.67) 56(84) bytes of data.
ping: sendmsg: Operation not permitted</pre>
    <p>But if you ping a whitelisted address, you have access:</p>
    <pre>$ sg block-net "ping 208.64.200.117"
PING 208.64.200.117 (208.64.200.117) 56(84) bytes of data.
64 bytes from 208.64.200.117: icmp_seq=1 ttl=# time=# ms</pre>
    <p>Edit your launcher for Half-Life so that it is run under the "block-net" group. Then you will only have access to your trusted, whitelisted servers.</p>
</div>

<?php include "footer.php" ?>

</body>

</html>
