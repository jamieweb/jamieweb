<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Subgraph OS Overview</title>
    <meta name="description" content="Subgraph OS Overview">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/blog/subgraph-os-overview/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1 id="introduction">Subgraph OS Overview</h1>
    <hr>
    <p><b>Tuesday 21st February 2017</b></p>
    <p>Subgraph OS is a security, privacy and anonymity oriented Linux distribution that aims to provide a maximum security computing environment while maintaining ease of use for the end user. The ultimate protection against a sophisticated adversary. Subgraph is currently an alpha product, so some features are not yet working or implemented.</p>
    <p><b>Skip to Section:</b></p>
    <pre><b>Subgraph OS Overview</b>
&#x2523&#x2501&#x2501 <a href="#introduction">Introduction</a>
&#x2523&#x2501&#x2501 <a href="#downloadverify">Downloading and Verifying</a>
&#x2523&#x2501&#x2501 <a href="#installation">Installation</a>
&#x2523&#x2501&#x2501 <a href="#usage">Usage</a>
&#x2523&#x2501&#x2501 <a href="#virtualmachines">Virtual Machines</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>
    <p>Subgraph OS is based on Debian Stretch and uses the Gnome 3 desktop environment, so many people will already be familiar with it.</p>
    <div class="centertext"><img width="1000px" src="/blog/subgraph-os-overview/subgraph-desktop.png"></div>
    <p>Full disk encryption is mandatory, all network traffic is transparently routed through the Tor network, and the kernel is hardened with Grsecurity and PaX.</p>
    <pre>user@subgraph:~$ screenfetch
       _,met$$$$$gg.           <b>user@subgraph</b>
    ,g$$$$$$$$$$$$$$$P.        <b>OS:</b> Debian 9.0 Stretch
  ,g$$P""       """Y$$.".      <b>Kernel:</b> x86_64 Linux 4.9.9-grsec-amd64
 ,$$P'              `$$$.      <b>Uptime:</b> 13m
',$$P       ,ggs.     `$$b:    <b>Packages:</b> 1489
`d$$'     ,$P"'   .    $$$     <b>Shell:</b> bash 4.4.11
 $$P      d$'     ,    $$P     <b>Resolution:</b> 1024x768
 $$:      $$.   -    ,d$$'     <b>DE:</b> Gnome
 $$\;      Y$b._   _,d$P'      <b>WM:</b> GNOME Shell
 Y$$.    `.`"Y$$$$P"'          <b>WM Theme:</b> Adwaita
 `$$b      "-.__               <b>GTK Theme:</b> Adwaita [GTK2/3]
  `Y$$                         <b>Icon Theme:</b> Adwaita
   `Y$$.                       <b>Font:</b> Droid Sans II
     `$$b.                     <b>RAM:</b> 425MiB / 5953MiB
       `Y$$b.                 
          `"Y$b._             
              `""""           </pre>
    <p>Subgraph is funded by the Open Technology Fund, which in turn is funded by the United States Government. This is the same as many other privacy tools including Qubes OS, Tails OS, Tor Project, etc.</p>

    <h2 id="downloadverify">Downloading and Verifying</h2>
    <p>Subgraph can be downloaded from their official site at <a href="https://subgraph.com" target="_blank" rel="noopener">subgraph.com</a>, or their Tor hidden service at <a href="https://subgraphqov3womk.onion" target="_blank" rel="noopener">subgraphqov3womk.onion</a> (currently giving SSL errors).</p>
    <p>Below are verifications for the 30th December 2016 Subgraph release:</p>
    <pre><b>File Name:</b> subgraph-os-alpha_2016-12-30_1.iso
<b>Size:</b> 1.4 GB (1,374,388,224 bytes)
<b>SHA256:</b> bb10486b5ae4e675a6b66c9c94d408225c72e3b792ea2d629a124006f6149dbc
<b>SHA1:</b> 84b7fced5e4b914a53547347f3b2aa7671060bf6
<b>MD5:</b> 7e7d25989e125297f7fa41ffb2b70d37
<b>Link:</b> https://dist.subgraph.com/sgos/alpha/subgraph-os-alpha_2016-12-30_1.iso

<b>File Name:</b> subgraph-os-alpha_2016-12-30_1.iso.sha256
<b>Size:</b> 100 bytes
<b>SHA256:</b> 6f932382abca1af1179c119253e557b53e6e51a1f1c1af893219dc7d8577ace8
<b>SHA1:</b> b83d5100d5d477402e0d65b1590521b415cddbca
<b>MD5:</b> 8a8c13a515946cc15760a008ab681d1c
<b>Link:</b> https://dist.subgraph.com/sgos/alpha/subgraph-os-alpha_2016-12-30_1.iso.sha256

<b>File Name:</b> subgraph-os-alpha_2016-12-30_1.iso.sha256.sig
<b>Size:</b> 566 bytes
<b>SHA256:</b> 522d8a08fe0a7b4c8a38890ce4f22912f55a3baa43e4a09ff6a207986b33ffb8
<b>SHA1:</b> eba1175f60a6038d1fae7ed90ce0109c3e4f14d4
<b>MD5:</b> 2c855637901b5a902378ad07e1aeec3a
<b>Link:</b> https://dist.subgraph.com/sgos/alpha/subgraph-os-alpha_2016-12-30_1.iso.sha256.sig

<b>File Name:</b> subgraph-os-alpha_2016-12-30_1.torrent
<b>Size:</b> 26.9 kB (26,870 bytes)
<b>SHA256:</b> 620d4db2da1fe39d26c7c29588931a56e552d5785870c29b4db3cbcbefe8aa50
<b>SHA1:</b> 67adc5ef2a1103a8c89ef8e099e53e9451242914
<b>MD5:</b> c599c2952be7b92b3b99e55f51c7ff28
<b>Link:</b> https://dist.subgraph.com/sgos/alpha/subgraph-os-alpha_2016-12-30_1.torrent

<b>File Name:</b> DA11364B4760E444.asc
<b>Size:</b> 6.8 kB (6,770 bytes)
<b>SHA256:</b> 60bbab30b0ad458e5ddcc00ae8e14004962a2913ad59c62ccd353fd07e108302
<b>SHA1:</b> b02cab1f094837c04cc16beb5a9ddcee512a0806
<b>MD5:</b> b2bfc9b3c6a8706f94852b7b22b729a1
<b>Link:</b> https://subgraph.com/DA11364B4760E444.asc</pre>

    <p>Import the Subgraph Release Signing Key into GPG and verify the signature of the SHA256 file:</p>
    <pre>jamie@box:~$ gpg --verify subgraph-os-alpha_2016-12-30_1.iso.sha256.sig subgraph-os-alpha_2016-12-30_1.iso.sha256
gpg: Signature made Fri 30 Dec 2016 21:16:21 GMT using RSA key ID F999D968
gpg: Good signature from "Subgraph Release Signing Key &lt;release@subgraph.com&gt;"
gpg: WARNING: This key is not certified with a trusted signature!
gpg:          There is no indication that the signature belongs to the owner.
Primary key fingerprint: B55E 70A9 5AC7 9474 504C  30D0 DA11 364B 4760 E444
     Subkey fingerprint: AB6C 7E34 4F63 3E10 4377  D595 E1AE 39C4 F999 D968</pre>

    <h2 id="installation">Installation</h2>
    <p>I downloaded and verified the Subgraph ISO and restored the disk image to a USB flash drive using gnome-disks. Make sure to disable UEFI boot in your BIOS if you have it, since Subgraph only supports legacy boot. If you try to install it in UEFI mode, GRUB bootloader will fail to install.</p>
    <p>In order to screenshot the installation process, I installed Subraph in a VirtualBox virtual machine. The screenshot tool built into the installer didn't seem to work, the images were lost upon removing the flash drive. This is most likely since I directly restored the disk image to the flash drive using gnome-disks, so there was no persistent storage space.</p>
    <p>Upon booting from USB, you have the option to boot a live version of Subgraph or install from fresh. You can choose between a graphical installer or text-based installer. I chose the graphical one.</p>
    <div class="centertext"><img width="1000px" src="/blog/subgraph-os-overview/subgraph-install-01.png"></div>
    <p>Next are the language and keyboard selection screens:</p>
    <div class="centertext"><img class="subgraph-img-1 max-width-100-percent" width="322px" src="/blog/subgraph-os-overview/subgraph-install-02.png"><img width="322px" class="subgraph-img-1 max-width-100-percent" src="/blog/subgraph-os-overview/subgraph-install-03.png"><img class="max-width-100-percent" width="320px" src="/blog/subgraph-os-overview/subgraph-install-04.png"></div>
    <p>Now you must set up a password for the Subgraph user account. The default user account in Subgraph is "user" (/home/user/).</p>
    <div class="centertext"><img class="max-width-100-percent" src="/blog/subgraph-os-overview/subgraph-install-05.png"></div>
    <p>Partitioning is next. Subgraph has mandatory full-disk encryption (FDE), and uses logical volume management (LVM) by default.</p>
    <p>The Subgraph installer will start to overwrite your drive with random data. This is a security feature to erase all remnants of a previous operating system or files. On a 120 GB SSD, it took about 1 hour. If you do not want to perform the full disk erasure, you can press cancel and the installation will continue without a problem.</p>
    <div class="centertext"><img class="subgraph-img-2 max-width-100-percent" width="491px" src="/blog/subgraph-os-overview/subgraph-install-06.png"><img class="max-width-100-percent" width="491px" src="/blog/subgraph-os-overview/subgraph-install-07.png"></div>
    <p>Now you have to choose a password for the FDE. You will be prompted for this password whenever booting in Subgraph.</p>
    <div class="centertext"><img class="max-width-100-percent" src="/blog/subgraph-os-overview/subgraph-install-08.png"></div>
    <p>Now you have a chance to perform more advanced partition management operations. I once used this partition manager to set up a dual boot of Lubuntu and Subgraph (Lubuntu installed first), and it worked very well. At first, Subgraph did not appear as an option in GRUB. This is because Lubuntu was installed in UEFI mode and Subgraph was installed in legacy mode. In order to fix this, I temporarily changed back to UEFI boot in my BIOS, booted into Lubuntu and reconfigured GRUB using "sudo update-grub".</p>
    <div class="centertext"><img class="max-width-100-percent" src="/blog/subgraph-os-overview/subgraph-install-09.png"></div>
    <p>Subgraph will now install:</p>
    <div class="centertext"><img class="subgraph-img-2 max-width-100-percent" width="491px" src="/blog/subgraph-os-overview/subgraph-install-10.png"><img class="max-width-100-percent" width="491px" src="/blog/subgraph-os-overview/subgraph-install-11.png"></div>
    <p>Select a device to install GRUB on. This is where the installer will fail if you are in UEFI mode.</p>
    <div class="centertext"><img class="subgraph-img-2 max-width-100-percent" width="491px" src="/blog/subgraph-os-overview/subgraph-install-12.png"><img class="max-width-100-percent" width="491px" src="/blog/subgraph-os-overview/subgraph-install-13.png"></div>
    <p>Subgraph is now installed!</p>
    <div class="centertext"><img class="max-width-100-percent" src="/blog/subgraph-os-overview/subgraph-install-14.png"></div>
    <p>Entering the FDE password:</p>
    <div class="centertext"><img class="subgraph-img-2 max-width-100-percent" width="491px" src="/blog/subgraph-os-overview/subgraph-install-15.png"><img class="max-width-100-percent" width="491px" src="/blog/subgraph-os-overview/subgraph-install-16.png"></div>

    <h2 id="usage">Usage</h2>
    <p>The classic Gnome 3 launcher is present in Subgraph:</p>
    <div class="centertext"><img class="max-width-100-percent" width="1000px" src="/blog/subgraph-os-overview/subgraph-launcher.png"></div>
    <p>Nautilus is the default file manager, the same as Ubuntu and many other distributions:</p>
    <div class="centertext"><img class="max-width-100-percent" width="1000px" src="/blog/subgraph-os-overview/subgraph-nautilus.png"></div>
    <p>One of the main features of Subgraph is the Tor metaproxy, which forces all network traffic through the Tor network. Even applications that do not natively support Tor or proxying will have their network traffic redirected through Tor.</p>
    <div class="centertext"><img class="max-width-100-percent" width="1000px" src="/blog/subgraph-os-overview/subgraph-tor-bootstrap.png"></div>
    <p>The problem with this is that it makes it extremely difficult to get connected to a public Wi-Fi network that has a login/landing page. The Subgraph team are working on an official way to do this, where the browser will detect the landing page and allow you to access it locally, before resuming Tor-exclusive connectivity.</p>
    <p>For the mean time, I have found a couple of ways to get around this restriction. If you boot into a different operating system (Xubuntu in my case), and log into the Wi-Fi there, your authentication to the network should remain when you boot back into Subgraph and connect to the same Wi-Fi hotspot. Another method is to use an external Wi-Fi adapter. Connect the adapter to another computer, log into the Wi-Fi hotspot using the adapter, then plug the adapter into your Subgraph machine. If the Wi-Fi hotspot identifies devices by MAC address (most do), then the authentication will transfer over to Subgraph. If this doesn't work, then try spoofing your MAC address to be that of the authenticated Wi-Fi adapter.</p>
    <p>Subgraph uses the torbrowser-launcher program in order to automatically install and update the Tor browser, making sure that it is always on the latest version. When running the Tor browser launcher, the Tor browser will be downloaded but the signature verification will fail. This is because of a glitch in the program, causing the Tor browser signing keys not to be downloaded properly. This is not an issue exclusive to Subgraph, the same problem arsises on other Linux distrubutions too. In order to fix it, you must redownload the PGP keys used to sign the packages from a key server:</p>
    <pre>gpg --homedir /home/user/.local/share/torbrowser/gnupg_homedir/ --refresh-keys --keyserver keys.gnupg.net</pre>
    <p>The default user account on Subgraph is simply "user", so you can directly copy the command from above. If your user account is different, change it accordingly. After running the above command, the Tor browser launcher should work properly.</p>
    <p>Certain "at-risk" applications are automatically sandboxed from the rest of the system using <a href="https://github.com/subgraph/oz" target="_blank" rel="noopener">Oz</a>, which is an application sandboxing system created by the Subgraph team.</p>
    <div class="centertext"><img class="max-width-100-percent" width="1000px" src="/blog/subgraph-os-overview/subgraph-oz-profiles.png"></div>
    <p>Subgraph also has a very tight firewall. If an application tries to access the internet, the user will be prompted with information on the connection attempt. The purpose of this is to deny network access to applications that don't need it or shouldn't have it. The image viewer application obviously does not need network access, so if it tries to connect then something funny is going on.</p>

    <h2 id="virtualmachines">Virtual Machines</h2>
    <p>I have set up several Subgraph virtual machines using VirtualBox on both my desktop and laptop computers. The installation process goes through flawlessly, but after that there are significant problems. The Subgraph VM used on my desktop computer has 2 virtual processors, 6144 MB RAM, 64 MB VRAM and a 24 GB virtual hard disk.</p>
    <p>When booting the VM, GRUB loads without a problem and you can enter your FDE password, but then it gets stuck when Gnome 3 starts. The screen (tty1) starts flashing infinitely. I have tried everything I can think of to get out of this into the desktop environment that has seemingly started in the background. I tried switching to every other screen (including tty7, which is where xserver normally runs), moving the mouse and entering keys in order to refresh the screen, entering key combinations (Ctrl+Alt+T, Ctrl+Alt+L, etc) in order to invoke a window or action, but I couldn't get to the desktop. The closest I ever got was entering Ctrl+Alt+Delete, which would momentarily display a grey screen and then shut down the computer. The process was definitely running, it just seemed to be using a screen that I couldn't access or was malfunctioning.</p>
    <p>Click on the image below to see roughly what I'm talking about:</p>
    <div class="centertext"><input type="checkbox" class="subgraph-check" id="subgraph-vm-flashing">
    <label class="subgraph-label" for="subgraph-vm-flashing"></label></div>
    <p>In order to get to a desktop, you must switch to a different screen and run startx again. This is easier said than done due to another problem. Switching to tty2 (using Alt+F2 in VirtualBox) is very difficult due to the fact that it does not remove the flashing. Instead of the screen flashing between tty1 and blackness, it flashes between tty1 and tty2 (with the login prompt). The only way that I could find to get around this is to repeatedly switch between various screens. Keep flicking between tty2 and tty3, sometimes for several minutes, and perhaps hold down Alt+F2 for a few seconds. Eventually, you'll get to a solid login prompt with no flashing.</p>
    <div class="centertext"><img class="subgraph-img-2 max-width-100-percent" width="491px" src="/blog/subgraph-os-overview/subgraph-login-prompt.png"><img class="max-width-100-percent" width="491px" src="/blog/subgraph-os-overview/subgraph-logged-in.png"></div>
    <p>Now you can run startx in order to get to a desktop. I tried stopping the existing gdm3 and x11 services, however I could not get any output from them, not even the status. You must run startx as root as it will fail as a normal user with permission errors. The Gnome 3 desktop will load successfully at a default resolution of 1024x768.</p>
    <div class="centertext"><img width="1000px" src="/blog/subgraph-os-overview/subgraph-vm-desktop.png"></div>
    <p>The basic desktop features work without a problem, including opening the launcher, menu items, file manager, etc, but opening any other applications will cause the system to crash irrecoverably. The desktop freezes, leaving only the cursor working. As far as I can tell, it is an infinite freeze. I left it going for over an hour and the clock still displayed the time at which the crash occured. I have not found a way to recover the system from this crash. Alt+F4, switching workspace, switching screen, etc, do not work. It seems to only be applications that start in an Oz sandbox that cause this crash. Unfortunately, upgrading the system didn't help this issue at all, even though there were hundreds of packages to update.</p>
    <p>In order to determine whether this is an issue with the desktop environment or not, I installed the Openbox window manager. When opening torbrowser-launcher or ricochet in Openbox, the programs hung infinitely but the window manager did not crash. I was unable to access any part of the program, not even the help page (torbrowser-launcher --help).</p>
    <p>As you can see below, torbrowser-launcher hung for almost 20 minutes real-time before I killed it, and only used 0.004 seconds of processor time.</p>
    <div class="centertext"><img width="1000px" src="/blog/subgraph-os-overview/subgraph-vm-openbox.png"></div>
    <p>This problem makes Subgraph essentially unusable in a VM, which is disappointing since it would be really useful to have in a VM for testing malicious websites or something similar. I have encountered these issues on both my desktop and laptop computers, and have tried changing various virtualization settings in both VirtualBox and my BIOS, all to no avail. I guess that it could be expected that a sandboxing application may not work properly within a virtual machine.</p>

    <h2 id="conclusion">Conclusion</h2>
    <p>If you're not using it in a VirtualBox virtual machine, Subgraph is a fantastic operating system that has a big potential to become very popular. It feels much more friendly to use than Tails or Qubes, possibly because of the Gnome3 desktop environment and general ease of use. Subgraph is still an alpha product, so all of the problems that I encountered will likely be ironed out in later releases. One feature that Subgraph really needs, and they are working on it, is the ability to easily join public Wi-Fi hotspots that have login pages. Secure computing from an untrusted connection is one of the main use cases of Subgraph, so easy authentication to said untrusted network is imperative.</p>
    <p>I will definitely be keeping the Subgraph dual boot on my laptop, and will keep monitoring the project for the duration of its development. I definitely recommend checking out Subgraph OS if you are interested in secure, private and anonymous computing.</p>
    <p>I have no affiliation with Subgraph.</p>
    
</div>

<?php include "footer.php" ?>

</body>

</html>
