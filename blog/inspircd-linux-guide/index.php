<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>InspIRCd Linux Setup Guide</title>
    <meta name="description" content="How to Install and Configure InspIRCd on Linux">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/blog/inspircd-linux-guide/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>How to Install and Configure 'InspIRCd' on Linux</h1>
    <hr>
    <p><b>Tuesday 16th May 2017</b></p>
    <p><a href="http://www.inspircd.org/" target="_blank" rel="noopener">InspIRCd</a> is a modular Internet Relay Chat (IRC) server written in C++ for Linux, BSD, Windows and Mac OS systems.</p>
    <p>This guide will cover installation, configuration and Let's Encrypt SSL. It is written with the assumption that you already have basic knowledge of Linux and IRC.</p>
    <p>The guide is targeted at Ubuntu/Debian systems, however it should be possible to follow for other Linux distributions too. Just make sure to use the appropriate package management commands for your distribution.</p>
    <p>The version of InspIRCd that I am using in this guide is 2.0.23, however you should be able to use the guide with newer versions. Just swap out 2.0.23 for the version number you are using.</p>
    <p>The main focus for the configuration of InspIRCd outlined here is security and simplicity.</p>
    <p>Jump to step: <a href="#step1">#1: Preparations</a> | <a href="#step2">#2: Downloading and Verifying</a> | <a href="#step3">#3: Installation</a> | <a href="#step4">#4: Configuration Files</a> | <a href="#step5">#5: Let's Encrypt SSL</a> | <a href="#step6">#6: Final Configuration</a></p>
    <p>Guide Created by Jamie Scaife 14th/15th May 2017.</p>

    <h2 id="step1">Step #1: Preparations</h2>
    <p><b>a.</b> It is highly recommended to create a new, unprivileged user account for running InspIRCd:</p>
    <pre>$ sudo adduser --disabled-password inspircd</pre>
    <p>This command will create a new user called "inspircd", with a disabled password. This means that there is no password set and you will not be able to log in with a password. Instead, you can just su into the user. If you'd like to set a password, simply omit "--disabled-password".</p>
    <p><b>b.</b> Install the required dependencies:</p>
    <pre>$ sudo apt-get install libgnutls-dev gnutls-bin pkg-config</pre>
    <p>If you are using a distribution other than Ubuntu/Debian, please see the <a href="https://wiki.inspircd.org/System_Requirements" target="_blank" rel="noopener">InspIRCd Wiki</a> for more information.</p>
    <p><b>c.</b> If you don't already have a command-line IRC client, it is useful to install one. I personally recommend Irssi:</p>
    <pre>$ sudo apt-get install irssi</pre>
    <p><b>d.</b> Log in as your new user:</p>
    <pre>$ sudo su inspircd</pre>

    <h2 id="step2">Step #2: Downloading and Verifying</h2>
    <p><b>It is important that you do not install InspIRCd from the Debian/Ubuntu Universe package repositories. These packages are out of date and potentially insecure. The out of date packages are not the fault of the InspIRCd development team, but rather the independent package maintainers.</b></p>
    <p><b>a.</b> The source for InspIRCd can be downloaded from their <a href="https://github.com/inspircd/inspircd/" target="_blank" rel="noopener">GitHub repository</a>. Visit the releases page and download the source code Tarball (.tar.gz) for the latest stable release. At the time of writing this guide, the latest version is 2.0.23.</p>
    <pre>########################################################################
<b>InspIRCd 2.0.23 Source Code</b>

Name: inspircd-2.0.23.tar.gz / v2.0.23.tar.gz
Size: 714.5 KB (731,695 bytes)
MD5: 8f9ae3c377334248af6f675b568d7234
SHA1: b1b575d2b3896f93b6a3a5b1cc7498541d223282
SHA256: 522b31fc80e8fd90b66837bf50f8a941233709d5b1fc9c0b3c47a413fb69f162
VirusTotal: <a href="https://www.virustotal.com/en/file/522b31fc80e8fd90b66837bf50f8a941233709d5b1fc9c0b3c47a413fb69f162/analysis/" target="_blank" rel="noopener">0/55 Detection Ratio</a>
Link: <a href="https://github.com/inspircd/inspircd/archive/v2.0.23.tar.gz" target="_blank" rel="noopener">https://github.com/inspircd/inspircd/archive/v2.0.23.tar.gz</a>
########################################################################</pre>
    <p>You can download the file using wget:</p>
    <pre>$ wget https://github.com/inspircd/inspircd/archive/v2.0.23.tar.gz</pre>
    <p><b>b.</b> Verify the integrity of your download:</p>
    <pre>$ sha256sum v2.0.23.tar.gz
522b31fc80e8fd90b66837bf50f8a941233709d5b1fc9c0b3c47a413fb69f162  v2.0.23.tar.gz
$ sha1sum v2.0.23.tar.gz
b1b575d2b3896f93b6a3a5b1cc7498541d223282  v2.0.23.tar.gz
$ md5sum v2.0.23.tar.gz
8f9ae3c377334248af6f675b568d7234  v2.0.23.tar.gz</pre>
    <p><b>c.</b> Extract the compressed file:</p>
    <pre>$ tar xvf v2.0.23.tar.gz</pre>

    <h2 id="step3">Step #3: Installation</h2>
    <p><b>a.</b> If you created a new user for InspIRCd, make sure you are logged in as it.</p>
    <p>Change directory into the inspircd-2.0.23 directory:</pre>
    <pre>$ cd inspircd-2.0.23</pre>
    <p>Press tab after the first few characters in order to autocomplete.</p>
    <p>Now start the InspIRCd pre-compilation configuration.</p>
    <pre>$ ./configure</pre>
    <p>Follow the wizard, choosing the options as outlined below. Values that you should change are marked in bold and underline.</p>
    <pre>Welcome to the InspIRCd configuration program! (interactive mode)
Package maintainers: Type ./configure --help for non-interactive help

*** If you are unsure of any of these values, leave it blank for    ***
*** standard settings that will work, and your server will run      ***
*** using them. Please consult your IRC network admin if in doubt.  ***

Press &lt;RETURN&gt; to accept the default for any option, or enter
a new value. Please note: You will HAVE to read the docs
dir, otherwise you won't have a config file!

Your operating system is: linux (linux)
Your InspIRCd revision ID is r0
.

I have detected the following compiler: g++ (version 5.4)

In what directory do you wish to install the InspIRCd base?
[/home/inspircd/inspircd-2.0.23/run] -&gt;
/home/inspircd/inspircd-2.0.23/run does not exist. Create it?
[y] y

In what directory are the configuration files?
[/home/inspircd/inspircd-2.0.23/run/conf] -&gt;
/home/inspircd/inspircd-2.0.23/run/conf does not exist. Create it?
[y] y

In what directory are the modules to be compiled to?
[/home/inspircd/inspircd-2.0.23/run/modules] -&gt;
/home/inspircd/inspircd-2.0.23/run/modules does not exist. Create it?
[y] y

In what directory is the IRCd binary to be placed?
[/home/inspircd/inspircd-2.0.23/run/bin] -&gt;
/home/inspircd/inspircd-2.0.23/run/bin does not exist. Create it?
[y] y

In what directory are variable data files to be located in?
[/home/inspircd/inspircd-2.0.23/run/data] -&gt;
/home/inspircd/inspircd-2.0.23/run/data does not exist. Create it?
[y] y

In what directory are the logs to be stored in?
[/home/inspircd/inspircd-2.0.23/run/logs] -&gt;
/home/inspircd/inspircd-2.0.23/run/logs does not exist. Create it?
[y] y

In what directory do you want the build to take place?
[/home/inspircd/inspircd-2.0.23/build] -&gt;
/home/inspircd/inspircd-2.0.23/build does not exist. Create it?
[y] y

You are running a Linux 2.6+ operating system, and epoll
was detected. Would you like to enable epoll support?
This is likely to increase performance.
If you are unsure, answer yes.

Enable epoll? [y] -&gt; y

Detected GnuTLS version: 3.4.10
Detected OpenSSL version: 1.0.2

One or more SSL libraries detected. Would you like to enable SSL support? [n] -&gt; y
Would you like to enable SSL with m_ssl_gnutls? (recommended) [n] -&gt; y
Would you like to enable SSL with m_ssl_openssl? (recommended) [n] -&gt; n

Using GnuTLS SSL module.
Would you like to check for updates to third-party modules? [n] -&gt; n

Pre-build configuration is complete!

Base install path:		/home/inspircd/inspircd-2.0.23/run
Config path:			/home/inspircd/inspircd-2.0.23/run/conf
Module path:			/home/inspircd/inspircd-2.0.23/run/modules
GCC Version Found:		5.4
Compiler program:		g++
GnuTLS Support:			y
OpenSSL Support:		n

Important note: The maximum length values are now configured in the
                configuration file, not in ./configure! See the &lt;limits&gt;
                tag in the configuration file for more information.

Would you like to generate SSL certificates now? [y] -&gt; y
Symlinking src/modules/m_ssl_gnutls.cpp from extra/
SSL certificates not found, generating..


*************************************************************
* Generating the private key may take some time, once done, *
* answer the questions which follow. If you are unsure,     *
* just hit enter!                                           *
*************************************************************

What is the hostname of your server?
[irc.example.com] -> <b>irc.example.tld</b>

What email address can you be contacted at?
[example@example.com] -> <b><u>mail@example.tld (You can leave this blank.)</u></b>

What is the name of your unit?
[Server Admins] -> <b><u>Department Name (You can leave this blank if you want.)</u></b>

What is the name of your organization?
[Example IRC Network] -> <b><u>Network Name (You can leave this blank if you want.)</u></b>

What city are you located in?
[Example City] -> <b><u>City Name (You can leave this blank if you want.)</u></b>

What state are you located in?
[Example State] -> <b><u>State Name (You can leave this blank if you want.)</u></b>

What is the ISO 3166-1 code for the country you are located in?
[XZ] -> <b><u>Country Code, eg: GB, US, DE</u></b>

How many days do you want your certificate to be valid for?
[365] -> 365

Generating a 3072 bit RSA private key...
Generating a self signed certificate...
Signing certificate...

Certificate generation complete, copying to config directory... Done.

Detecting modules ...
Ok, 145 modules.
Locating library directory for package gnutls for module m_ssl_gnutls.cpp... -lgnutls (version 3.4.10)
Writing inspircd_config.h
Writing GNUmakefile ...
Writing BSDmakefile ...
Writing inspircd ...
Writing cache file for future ./configures ...


To build your server with these settings, please run 'make' now.
Please note: for SSL support you will need to load required
modules in your config. This configure script has added those modules to the
build process. For more info, please refer to:
http://wiki.inspircd.org/Installation_From_Tarball
*** Remember to edit your configuration files!!! ***</pre>

    <p><b>b.</b> Build the package:</p>
    <pre>$ make</pre>
    <p>This will take a couple of minutes.</p>
    <pre>*************************************
*       BUILDING INSPIRCD           *
*                                   *
*   This will take a *long* time.   *
*     Why not read our wiki at      *
*     http://wiki.inspircd.org      *
*  while you wait for make to run?  *
*************************************
	BUILD:              bancache.cpp
	BUILD:              base.cpp
	BUILD:              channels.cpp
	BUILD:              cidr.cpp
...</pre>
    <p><b>c.</b> Install the package:</p>
    <pre>$ make install</pre>
    <p>This command should complete in less than a second.</p>
    <pre>*************************************
*       BUILDING INSPIRCD           *
*                                   *
*   This will take a *long* time.   *
*     Why not read our wiki at      *
*     http://wiki.inspircd.org      *
*  while you wait for make to run?  *
*************************************

*************************************
*        INSTALL COMPLETE!          *
*************************************
Paths:
  Base install: /home/inspircd/inspircd-2.0.23/run
  Configuration: /home/inspircd/inspircd-2.0.23/run/conf
  Binaries: /home/inspircd/inspircd-2.0.23/run/bin
  Modules: /home/inspircd/inspircd-2.0.23/run/modules
  Data: /home/inspircd/inspircd-2.0.23/run/data
To start the ircd, run: /home/inspircd/inspircd-2.0.23/run/inspircd start
Remember to create your config file: /home/inspircd/inspircd-2.0.23/run/conf/inspircd.conf
Examples are available at: /home/inspircd/inspircd-2.0.23/run/conf/examples/</pre>
    <p>Installation is now complete. Do not try to run your IRC server yet, you must make the configuration files first.</p>

    <h2 id="step4">Step #4: Configuration Files</h2>
    <p>The example configuration files that come with InspIRCd provide a lot of useful information but are extremely long and contain many configurations that are not required for the average server. Because of this, they are not really suitable for editing directly. I have been through all of the configuration examples and filtered out all of the options that you'll need for a standard, working server.</p>
    <p><b>a.</b> Create and edit the file "inspircd.conf" in your inspircd configuration directory.</p>
    <pre>$ nano run/conf/inspircd.conf</pre>
    <p>Edit my configuration file below to suit your own server. Each option is explained with a comment, which is prefixed with a hash (#) and bolded. If you do not wish to set an option or want to use the default, comment it out by placing a hash (#) at the start of the line.</p>
    <p>You can either copy the unannotated version from the text area directly below, or use the fully annotated version.</p>
    <textarea rows="12" cols="100" readonly>&lt;config format="xml"&gt;

&lt;server name="irc.example.tld"
    description="My IRC Server"
    network="My Network Name"&gt;

&lt;admin name="Joe Bloggs" nick="Administrator"&gt;

&lt;bind address="ip.ip.ip.ip"
    port="7000"
    type="clients"
    ssl="gnutls"&gt;

&lt;bind address="127.0.0.1"
    port="7000"
    type="clients"
    ssl="gnutls"&gt;

&lt;connect allow="*"
    modes="+xS"
    maxchans="5"
    timeout="5"
    localmax="5"
    globalmax="5"
    limit="20"
    requiressl="off"
    hardsenq="96K"
    softsendq="72K"
    recvq="8192"
    threshold="10"
    commandrate="1000"
    fakelag="off"&gt;

&lt;files motd="conf/motd.txt" rules="conf/rules.txt"&gt;

&lt;channels users="5" opers="5"&gt;

&lt;dns timeout="5"&gt;

&lt;disabled commands="NICK"
    usermodes=""
    chanmodes=""
    fakenoneexistant="no"&gt;

&lt;options fixedquit="Quit"
    fixedpart="Left Channel"
    syntaxhints="yes"
    announcets="yes"
    hostintopic="no"
    defaultmodes="ntzS"
    moronbanner="You are banned from this server."
    welcomenotice="yes"&gt;

&lt;performance netbuffersize="10240"
    somaxconn="5"&gt;

&lt;security announceinvites="ops"
    hidewhois=""
    hidebans="no"
    maxtargets="5"
    customversion="ircd"
    restrictbannedusers="yes"
    genericoper="yes"&gt;

&lt;limits maxnick="16"
    maxident="16"
    maxchan="16"
    maxtopic="64"
    maxgecos="32"
    maxmodes="10"
    maxquit="64"
    maxkick="64"
    maxaway="64"&gt;

&lt;log method="file" #Log to a file.
    type="* -USERINPUT -USEROUTPUT"
    level="default"
    target="logs/ircd.log"&gt;

&lt;whowas groupsize="8"
    maxgroups="256"
    maxkeep="3d"&gt;

&lt;badnick nick="ChanServ" reason="Nick reserved for services."&gt;
&lt;badnick nick="NickServ" reason="Nick reserved for services."&gt;
&lt;badnick nick="OperServ" reason="Nick reserved for services."&gt;
&lt;badnick nick="MemoServ" reason="Nick reserved for services."&gt;
&lt;badnick nick="Jamie*" reason="Nick disallowed."&gt;

&lt;badhost host="root@*" reason="Don't IRC as root!"&gt;

&lt;class name="admins"
    commands="*"
    usermodes=""
    chanmodes=""&gt;

&lt;type name="Administrator"
    classes="admins"
    vhost="irc.example.tld"&gt;

&lt;oper name="JoeBloggs"
    hash="hmac-sha256"
    password="HASH_HERE"
    host="*@127.0.0.1"
    sslonly="yes"
    type="Administrator"&gt;

&lt;module name="m_ssl_gnutls.so"&gt;
&lt;gnutls certfile="conf/cert.pem"
    keyfile="conf/key.pem"
    dhbits="4096"
    priority="SECURE256:-MD5"
    hash="sha1"&gt;

&lt;module name="m_sslinfo.so"&gt;
&lt;module name="m_sslmodes.so"&gt;

&lt;module name="m_cloaking.so"&gt;
&lt;cloak mode="full" key="KEY_HERE"
    prefix="cloaked-"&gt;

&lt;module name="m_conn_umodes.so"&gt;
&lt;module name="m_password_hash.so"&gt;
&lt;module name="m_sha256.so"&gt;
&lt;module name="m_md5.so"&gt;
&lt;module name="m_stripcolor.so"&gt;

&lt;module name="m_permchannels.so"&gt;
&lt;permchannels channel="#general"
    modes="ntzSP"
    topic="My Channel Topic"&gt;

&lt;module name="m_conn_join.so"&gt;
&lt;autojoin channel="#general"&gt;

&lt;module name="m_securelist.so"&gt;
&lt;securelist waittime="15"&gt;</textarea>
    <p>If you're using the fully annotated version, you do not have to remove the comments, InspIRCd can read it without a problem.</p>
    <pre>&lt;config format="xml"&gt; #Set the configuration file format to XML.</u></b>

&lt;server name="irc.example.tld" <b><u>#The name of your server, preferably the hostname that users connect from.</u></b>
    description="My IRC Server" <b><u>#Description of your server.</u></b>
    network="My Network Name"&gt; <b><u>#The name of your IRC network.</u></b>

&lt;admin name="Joe Bloggs" nick="Administrator"&gt; <b><u>#Real name and IRC nickname of the IRC administrator.</u></b>

&lt;bind address="ip.ip.ip.ip" <b><u>#An IP address for the server to bind to. This should be your global/public IP address.</u></b>
    port="7000" <b><u>#Port for connections. 6697 is often used for SSL connections, but anything above 1023 is technically fine.</u></b>
    type="clients" <b><u>#Only clients can connect using this bind. IRC allows for servers to connect to eachother too.</u></b>
    ssl="gnutls"&gt; <b><u>#Use GnuTLS for handling the SSL connection.</u></b>

&lt;bind address="127.0.0.1" <b><u>#Another bind but for local connections.</u></b>
    port="7000" <b><u>#Local connections are useful if you want to chat or have an IRC bot connect from the same machine.</u></b>
    type="clients"
    ssl="gnutls"&gt;

&lt;connect allow="*" <b><u>#Which IPs/hosts can connect to the server. Wildcard "*" for all.</u></b>
    modes="+xS" <b><u>#Apply user modes. "x" = user cloaking, "S" = strip colour control codes.</u></b>
    maxchans="5" <b><u>#Maximum number of channels a user can be in simultaneously.</u></b>
    timeout="5" <b><u>#How long the user has to register upon connecting before been dropped.</u></b>
    localmax="5" <b><u>#Maximum local connections per IP.</u></b>
    globalmax="5" <b><u>#Maximum network-wide connections per IP.</u></b>
    limit="20" <b><u>#Number of user "slots" available.</u></b>
    requiressl="off" <b><u>#This option must be set to "off" in order to allow the initial handshake to take place.</u></b>
    hardsenq="96K" <b><u>#A hard limit on the amount of data in each user's send queue.</u></b>
    softsendq="72K" <b><u>#A soft limit for the above. Useful to reduce spam/denial of service.</u></b>
    recvq="8192" <b><u>#Amount of data in a user's receive queue before they are dropped.</u></b>
    threshold="10" <b><u>#Anti-spam threshhold before been dropped or fakelagged.</u></b>
    commandrate="1000" <b><u>#Maximum command lines that can be processed per second. 1000 is equal to 1 line per second.</u></b>
    fakelag="off"&gt; <b><u>#Induce fake lag upon users instead of dropping them when they exceed their threshold.</u></b>

&lt;files motd="conf/motd.txt" rules="conf/rules.txt"&gt; <b><u>#Include source texts for the "message of the day" and server rules.</u></b>

&lt;channels users="5" opers="5"&gt; <b><u>#Maximum number of channels a user/operator is allowed to be in simultaneously.</u></b>

&lt;dns timeout="5"&gt; <b><u>#How long to wait for a response from the DNS server.</u></b>

&lt;disabled commands="NICK" <b><u>#Disabled commands. I disable the NICK command to reduce nickname-change spam.</u></b>
    usermodes="" <b><u>#Disabled user modes.</u></b>
    chanmodes="" <b><u>#Disabled channel mades.</u></b>
    fakenoneexistant="no"&gt; <b><u>#Tell the user that the command is unknown instead of just disabled.</u></b>

&lt;options fixedquit="Quit" <b><u>#Force all quit messages to be this value.</u></b>
    fixedpart="Left Channel" <b><u>#Force all left channel messages to be this value.</u></b>
    syntaxhints="yes" <b><u>#Provide help when a user issues an erroneous command.</u></b>
    announcets="yes" <b><u>#All users are notified when a channel timestamp changes.</u></b>
    hostintopic="no" <b><u>#Channels show hostname of the topic setter.</u></b>
    defaultmodes="ntzS" <b><u>#Default channel modes. "n" = must be in channel to chat,
    #"t" = prevent topic change by normal user, "z" = SSL users only, "S" = strip colour control codes.</u></b>
    moronbanner="You are banned from this server." <b><u>#Message shown to banned users.</u></b>
    welcomenotice="yes"&gt; <b><u>#Welcome text shown to users upon successful registration.</u></b>

&lt;performance netbuffersize="10240" <b><u>#Size of buffer for receiving client data.</u></b>
    somaxconn="5"&gt; <b><u>#Maximum amount of connections that may be waiting in the accept queue.</u></b>

&lt;security announceinvites="ops" <b><u>#Which group of users receive notifcations when someone is invited to a channel.</u></b>
    hidewhois="" <b><u>#Text to hide the server a user is currently on when they are whoised by a non-operator.</u></b>
    hidebans="no" <b><u>#Hide ban messages from non-operator users.</u></b>
    maxtargets="5" <b><u>#Maximum number of targets per command. Stop users sending messages to more than X channels at once.</u></b>
    customversion="ircd" <b><u>#Custom server version number. Used to hide the true version number of InspIRCd.</u></b>
    restrictbannedusers="yes" <b><u>#Prevent banned users from chatting or changing nickname.</u></b>
    genericoper="yes"&gt; <b><u>#Don't distinguish between different operator types when they are whoised.</u></b>

&lt;limits maxnick="16" <b><u>#Maximum length of nicknames.</u></b>
    maxident="16" <b><u>#Maximum length of usernames. Usernames are your computer's username unless specified otherwise.</u></b>
    maxchan="16" <b><u>#Maximum length of a channel name.</u></b>
    maxtopic="64" <b><u>#Maximum length of a channel topic.</u></b>
    maxgecos="32" <b><u>#Maximum length of a real name. This is your real name, for example: "Joe Bloggs".</u></b>
    maxmodes="10" <b><u>#Maximum number of mode changes per command.</u></b>
    maxquit="64" <b><u>#Maximum length of a quit message.</u></b>
    maxkick="64" <b><u>#Maximum length of a kick message.</u></b>
    maxaway="64"&gt; <b><u>#Maximum length of an away message.</u></b>

&lt;log method="file" <b><u>#Log to a file.</u></b>
    type="* -USERINPUT -USEROUTPUT" <b><u>#Log everything except user input/output.</u></b>
    level="default" <b><u>#Loggin level. "default" = general messages, including errors.</u></b>
    target="logs/ircd.log"&gt; <b><u>#File to log to.</u></b>

&lt;whowas groupsize="8" <b><u>#Maximum entries per nickname when using /whowas.</u></b>
    maxgroups="256" <b><u>#Maximum number of nickname groups to keep track of server-wide.</u></b>
    maxkeep="3d"&gt; <b><u>#Maximum time to keep nickname history.</u></b>

&lt;badnick nick="ChanServ" reason="Nick reserved for services."&gt; <b><u>#Disallowed nickname.</u></b>
&lt;badnick nick="NickServ" reason="Nick reserved for services."&gt;
&lt;badnick nick="OperServ" reason="Nick reserved for services."&gt;
&lt;badnick nick="MemoServ" reason="Nick reserved for services."&gt;
&lt;badnick nick="Jamie*" reason="Nick disallowed."&gt; <b><u>#Wildcards can be used.</u></b>

&lt;badhost host="root@*" reason="Don't IRC as root!"&gt; <b><u>#Disallowed user/hostname.</u></b>

&lt;class name="admins" <b><u>#Classes are like permission groups for server operators.</u></b>
    commands="*" <b><u>#Which commands they can perform.</u></b>
    usermodes="" <b><u>#Operator-only user modes that operators in this class can use.</u></b>
    chanmodes=""&gt; <b><u>#Operator-only channel modes that operators in this class can use.</u></b>

&lt;type name="Administrator" <b><u>#Name of operator group.</u></b>
    classes="admins" <b><u>#Which permission classes this operator group has.</u></b>
    vhost="irc.example.tld"&gt; <b><u>#Hostname given to operators.</u></b>

&lt;oper name="JoeBloggs" <b><u>#Name used to oper-up.</u></b>
    hash="hmac-sha256" <b><u>#Hashing algorithm used for passwords.</u></b>
    password="HASH_HERE" <b><u>#Place the password hash generated in the next section here.</u></b>
    host="*@127.0.0.1" <b><u>#Only allow local connections.</u></b>
    sslonly="yes" <b><u>#Only allow SSL users to oper-up.</u></b>
    type="Administrator"&gt; <b><u>#Which permission group this operator is a member of.</u></b>

&lt;module name="m_ssl_gnutls.so"&gt; <b><u>#Load the GnuTLS module.</u></b>
&lt;gnutls certfile="conf/cert.pem" <b><u>#Path to certificate file.</u></b>
    keyfile="conf/key.pem" <b><u>#Path to private key file.</u></b>
    dhbits="4096" <b><u>#Bits to use for Diffie Hellman parameter generation.</u></b>
    priority="SECURE256:-MD5" <b><u>#Only use ciphers that use a 256-bit key. Disable md5.</u></b>
    hash="sha1"&gt; <b><u>#Use sha1 fingerprint instead of md5.</u></b>

&lt;module name="m_sslinfo.so"&gt; <b><u>#Load the SSL info module. Shows information about SSL connections.</u></b>
&lt;module name="m_sslmodes.so"&gt; <b><u>#Load the sslmodes channel. Allows SSL-only channels.</u></b>

&lt;module name="m_cloaking.so"&gt; <b><u>#Load the user cloaking module. Allows the masking of user IPs/hostnames.</u></b>
&lt;cloak mode="full" key="KEY_HERE" <b><u>#Insert the cloak key here. More about this in next section.</u></b>
    prefix="cloaked-"&gt; <b><u>#Prefix for cloaked users.</u></b>

&lt;module name="m_conn_umodes.so"&gt; <b><u>#Load connection user modes module. Allows user modes to be applied upon connection.</u></b>
&lt;module name="m_password_hash.so"&gt; <b><u>#Load the password hashing module. Allows passwords to be hashed.</u></b>
&lt;module name="m_sha256.so"&gt; <b><u>#Load the sha256 module. Allows sha256 hashing.</u></b>
&lt;module name="m_md5.so"&gt; <b><u>#Load the md5 module. Allows md5 hashing.</u></b>
&lt;module name="m_stripcolor.so"&gt; <b><u>#Load the strip colours module. Allows colour control codes to be stripped from messages.</u></b>

&lt;module name="m_permchannels.so"&gt; <b><u>#Load the permanent channels module. Allows for permanent channels.</u></b>
&lt;permchannels channel="#general" <b><u>#Create a permanent channel.</u></b>
    modes="ntzSP" <b><u>#Apply channel modes. "P" = make the channel permanent.</u></b>
    topic="My Channel Topic"&gt; <b><u>#Default channel topic.</u></b>

&lt;module name="m_conn_join.so"&gt; <b><u>#Load the connection join module. Automatically joins a user to a channel upon connection.</u></b>
&lt;autojoin channel="#general"&gt; <b><u>#The channel to automatically join.</u></b>

&lt;module name="m_securelist.so"&gt; <b><u>#Load the secure list module. Prevents repeated use of the list command.</u></b>
&lt;securelist waittime="15"&gt; <b><u>#How many seconds from connection to prevent the list command.</u></b></pre>

    <p><b>b.</b> Create your cloak key. This is what will be used to mask the IPs/hostnames of cloaked users. It is essentially a password. Anybody who has the cloak key will be able to reverse the cloak hashes and find the real IP/hostname, so it should be secure and kept private. I suggest generating a long, random password.</p>
    <p>Place your cloak key in your configuration file. Edit the value "KEY_HERE", as seen in the example below:</p>
    <pre>&lt;cloak mode="full" key="KEY_HERE" prefix="cloaked-"&gt;</pre>

    <p><b>c.</b> Now it's time to start your server for the first time and set up hashed passwords for your operators.</p>
    <pre>$ run/inspircd start</pre>
    <p>InspIRCd should start as shown below:</p>
    <pre>Inspire Internet Relay Chat Server, compiled on May 15 2017 at 00:58:46
(C) InspIRCd Development Team.

Developers:
	Brain, FrostyCoolSlug, w00t, Om, Special, peavey
	aquanight, psychon, dz, danieldg, jackmcbarn
	Attila

Others:			See /INFO Output
InspIRCd Process ID: 1432


Loading core commands.....................................................
[*] Loading module:	m_ssl_gnutls.so
[*] Loading module:	m_sslinfo.so
[*] Loading module:	m_sslmodes.so
[*] Loading module:	m_cloaking.so
[*] Loading module:	m_conn_umodes.so
[*] Loading module:	m_password_hash.so
[*] Loading module:	m_sha256.so
[*] Loading module:	m_md5.so
[*] Loading module:	m_stripcolor.so
[*] Loading module:	m_permchannels.so
[*] Loading module:	m_conn_join.so
[*] Loading module:	m_securelist.so
InspIRCd is now running as 'irc.example.tld'[245] with 1024 max open sockets</pre>
    <p>Now you should be able to connect to your IRC server using your IRC client. This guide uses Irssi, so if you're using a different client, use the commands appropriate for that client.</p>
    <p>Open Irssi:</p>
    <pre>$ irssi</pre>
    <p>You should see the Irssi interface take up your entire terminal.</p>
    <pre>Irssi v0.8.19 - http://www.irssi.org
17:45 -!-  ___           _
17:45 -!- |_ _|_ _ _____(_)
17:45 -!-  | || '_(_-&lt;_-&lt; |
17:45 -!- |___|_| /__/__/_|
17:45 -!- Irssi v0.8.19 - http://www.irssi.org

...

[17:46] [] [1]
[(status)]</pre>
    <p>Join your server by entering the connection information into the command bar (at the bottom):</p>
    <pre>[(status)] /connect -ssl &lt;ip/hostname&gt; &lt;port&gt; &lt;password&gt; &lt;nickname&gt;</pre>
    <p>For my example server, the command would be:</p>
    <pre>[(status)] /connect -ssl 127.0.0.1 7000 stuff JoeBloggs</pre>
    <p>Since you do not have a password, simply enter anything in the password field.</p>
    <p>If you have connected successfully, you should see something similar to the following:</p>
    <pre>17:57 -!- Irssi: Looking up 127.0.0.1
17:57 -!- Irssi: Connecting to 127.0.0.1 [127.0.0.1] port 7000
17:57 -!- Irssi: Connection to 127.0.0.1 established
17:57 !irc.example.tld *** Looking up your hostname...
17:57 !irc.example.tld *** Found your hostname (localhost)
17:57 !irc.example.tld Welcome to My Network Name!
17:57 -!- Welcome to the My Network Name IRC Network JoeBloggs!jamie@localhost
17:57 -!- Your host is irc.example.tld, running version InspIRCd-2.0
17:57 -!- This server was created 00:58:57 May 15 2017
17:57 -!- irc.example.tld InspIRCd-2.0
17:57 -!- There are 1 users and 0 invisible on 1 servers
17:57 -!- 1 channels formed
17:57 -!- I have 1 clients and 0 servers
17:57 -!- Current Local Users: 1  Max: 1
17:57 -!- Current Global Users: 1  Max: 1
17:57 -!- cloaked-############.IP is now your displayed host
17:57 -!- Mode change [+xS] for user JoeBloggs
17:57 !irc.example.tld *** You are connected using SSL cipher "ECDHE-RSA-AES-256-GCM-AEAD"
17:57 -!- Mode change [+i] for user JoeBloggs</pre>
    <p>Once you are connected to your server, generate a password hash for your operator accounts. Repeat this for as many operator users as you have configured in your configuration file.</p>
    <p>When using Irssi, you must use the quote command to send raw commands to the server. This is because Irssi handles unknown commands client-side, causing many useful commands not to be sent to the server.</p>
    <pre>[(status)] /quote mkpasswd hmac-sha256 &lt;password&gt;</pre>
    <p>Simply replace &lt;password&gt; with your desired password. This should be a very strong password since it gives anybody who has it administrator rights on your IRC server.</p>
    <p>The command should output the hmac-sha256 hash for the password that you entered:</p>
    <pre>18:06 !irc.example.tld hmac-sha256 hashed password for helloworld is ERv6oMeU$qJHBXm+6fwMOvF/AJZUjb8Bkczk9XtPIZjw7IAaki5k</pre>
    <p>Copy the outputted hash to your clipboard.</p>
    <p><b>Do not copy from the example above!</b> That is an example hash of the password "helloworld".</p>
    <p>Quit Irssi:</p>
    <pre>[(status)] /quit</pre>
    <p>Then, paste the password hash into your InspIRCd configuration file. Just like you did with the cloak key, replace "HASH_HERE" with the hash you copied.</p>
    <pre>password="HASH_HERE"</pre>
    <p>Restart your InspIRCd server to apply the new configuration.</p>
    <pre>$ run/inspircd restart</pre>
    <p>Now you can connect to you server and authenticate as an operator. Once connected:</p>
    <pre>[(status)] /oper &lt;username&gt; &lt;password&gt;</pre>
    <p>In my example, this command would be:</p>
    <pre>[(status)] /oper JoeBloggs helloworld</pre>
    <p>You should now be an operator:</p>
    <pre>19:20 -!- Mode change [+i] for user JoeBloggs
19:20 -!- Mode change [+o] for user JoeBloggs
19:20 -!- Mode change [-x] for user JoeBloggs
19:20 -!- irc.example.tld is now your displayed host
19:20 -!- You are now an Administrator</pre>
    <p>Now you can use any operator commands that you wish!</p>
    <p>Server configuration is complete!</p>

    <h2 id="step5">Step #5: Let's Encrypt SSL</h2>
    <p>Most IRC clients are configured to allow self-signed SSL certificates, but when making direct connections to an IRC server without using an IRC client (for example an IRC bot), it is common to run into SSL errors. It is easy to use a Let's Encrypt SSL Domain Validation certificate with InspIRCd, all you have to do is obtain the certificate and copy it to your InspIRCd configuration directory. I have checked the Let's Encrypt Terms of Service and it is perfectly fine to use their certificates for web services other than a web server.</p>
    <p><b>If you are not running a web server on the same machine as your IRC server, you'll need to follow different steps.</b> <a href="https://suchsecurity.com/using-letsencrypt-for-your-ircd.html" target="_blank" rel="noopener">This guide on Such Security</a> is fantastic and is what you need to follow. Come back here once you've obtained the certificate.</p>
    <p>If you are already running a web server on the same machine as your IRC server, setup will be much easier. I'm going to assume that you already have Let's Encrypt set up and working too. If not, there are plenty of guides out there.</p>
    <p>It is useful to have a web server running on the same hostname as your IRC server. This way, if anybody tries to visit your IRC server using http, they can be redirected to an information page. For example, redirect http://irc.example.tld to http://www.example.tld/irc.</p>
    <p>I do not suggest hosting any actual web content on http://irc.example.tld, a redirection to your main site is much safer. This is because the SSL certificate used for irc.example.tld is also going to be used for your IRC server. This involves storing it in a location that I would consider less secure than the default location. If your IRC server were to be compromised and the private key for the SSL certificate were to leak, encrypted traffic to and from irc.example.tld could be tampered with. By redirecting users away from http://irc.example.tld as soon as they visit it, you are reducing the impact of such a breach. Of course the IRC traffic would be compromised too. It would be possible for this HTTP redirection to be modified by an attacker, but it's an extra step of protection anyway.</p>
    <p><b>a.</b> Obtain a Let's Encrypt certificate using certbot for the hostname of your IRC server. Certbot will configure your web server to use the SSL certificate.</p>
    <p><b>b.</b> Change directory back to your home folder, then create and edit the file "copy-certs.sh":</p>
    <pre>$ cd
$ nano copy-certs.sh</pre>
    <p>Let's Encrypt certificates are valid for only 90 days. This script will copy the SSL certificate and private key to your InspIRCd directory once per day in order to keep them up to date.</p>
    <p>Copy the following script into the file:</p>
    <pre>#!/bin/bash
sudo cp /etc/letsencrypt/live/<b><u>irc.example.tld</u></b>/fullchain.pem /home/<b><u>inspircd</u></b>/inspircd-2.0.23/run/conf/cert.pem
sudo cp /etc/letsencrypt/live/<b><u>irc.example.tld</u></b>/privkey.pem /home/<b><u>inspircd</u></b>/inspircd-2.0.23/run/conf/key.pem
sudo chown <b><u>inspircd</u></b>:<b><u>inspircd</u></b> /home/<b><u>inspircd</u></b>/inspircd-2.0.23/run/conf/cert.pem /home/<b><u>inspircd</u></b>/inspircd-2.0.23/run/conf/key.pem</pre>
    <p>The values that must be edited to suit your server setup are marked with bold and underline.</p>
    <p>Mark the script as executable:</p>
    <pre>$ chmod +x copy-certs.sh</pre>
    <p>This script requires sudo/root access to run successfully. This is because it has to be able to read and write in private directories.</p>
    <p>Add this script to the crontab of any user that has unauthenticated sudo access, or the root account. This script is a simple copy and change owner operation so it is safe to run as root.</p>
    <p>In order to edit root's crontab, log in as a user with sudo privileges and run the following:</p>
    <pre>$ sudo crontab -e</pre>
    <p>If prompted to select a text editor, choose your preferred one. Nano is easiest.</p>
    <p>Add following entry to your crontab. Just add a new line, paste the following and edit the bolded/underlined sections to match your server configuration.</p>
    <pre>55 4 * * * /home/<b><u>inspircd</u></b>/copy-certs.sh</pre>
    <p>This will run the script once per day at 4:55 am. You can change these values to a different time of day if you wish.</p>
    <p>Then run your script once to perform the initial copying of the certificates.</p>
    <pre>$ ./copy-certs.sh</pre>
    <p>Log back in as your InspIRCd user and restart InspIRCd:</p>
    <pre>$ sudo su inspircd
$ inspircd-2.0.34/run/inspircd restart</pre>
    <p>You can test your IRC server by connecting. If your new certificates have worked, you should see the SSL information upon joining:</p>
    <pre>23:30 !irc.example.tld *** You are connected using SSL cipher "ECDHE-RSA-AES-256-GCM-AEAD"</pre>
    <p>Now you should be able to connect to your IRC server using an application that does not allow self-signed certificates.</p>

    <h2 id="step6">Step #6: Final Configuration</h2>
    <p><b>a.</b> In order to start your InspIRCd server at boot, you must add an entry to your crontab.</p>
    <p>Make sure you are logged in as your InspIRCd user, then run:</p>
    <pre>$ crontab -e</pre>
    <p>Add the following line to the bottom of the file, editing the bolded/unlined values:</p>
    <pre>@reboot sleep 20 && cd /home/<b><u>inspircd</u></b>/inspircd-2.0.23/run && /home/<b><u>inspircd</u></b>/inspircd-2.0.23/run/inspircd start</pre>
    <p>This will wait 20 seconds to ensure that the system is fully booted, then start InspIRCd.</p>
    <p>Make doubly sure that you added this to the crontab of your InspIRCd user. If you added it to another user's or even root's, InspIRCd may not work and may be a security risk.</p>
    <p><b>b.</b> Place your message of the day into the file run/conf/motd.txt and your server rules into run/conf/rules.txt.</p>
    <p>These files will be outputted when the commands /motd and /rules are used.</p>
    <p>The MOTD should contain important information about your server such as who the owner is, available channels, commands, etc. ASCII art text is particularly appealing in an IRC MOTD, which can be generated using an <a href="http://www.network-science.de/ascii/" target="_blank" rel="noopener">ASCII art text generator</a>.</p>
    <br>
    <p>Please let me know if you find any issues with this guide. Thanks for reading and good luck!</p>
    <p>I have no affiliation with InspIRCd.</p>
</div>

<?php include "footer.php" ?>

</body>

</html>
