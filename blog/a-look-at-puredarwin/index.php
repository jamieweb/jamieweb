<?php include "response-headers.php"; content_security_policy();
include_once "bloglist.php"; bloglist("postTop", null, null, 2019); ?>

<div class="body">
    <h1><?php echo $postInfo->title; ?></h1>
    <hr>
    <p><b><?php echo $postInfo->date; ?></b></p>
    <p><?php echo $postInfo->snippet; ?></p>
    <p>PureDarwin is a community project to make <a href="https://en.wikipedia.org/wiki/Darwin_(operating_system)" target="_blank" rel="noopener">Darwin</a>, the open source operating system developed by <i>Apple Inc.</i> that macOS is built upon, more usable by providing bootable ISOs and documentation.</p>
    <img class="radius-8" width="1000px" src="/blog/a-look-at-puredarwin/puredarwin-org.png">
    <p class="two-no-mar centertext"><i>The <a href="https://www.puredarwin.org/" target="_blank" rel="noopener">puredarwin.org</a> homepage, showing the Hexley the Platypus mascot.</i></p>
    <p>The project was founded in 2007, and is seen as the informal successor to the OpenDarwin project (which closed down in 2006). PureDarwin is a downstream project of <a href="https://github.com/macosforge/darwinbuild" target="_blank" rel="noopener">Darwinbuild</a>, combining the open source Darwin base with other FOSS tools (such as X.org) to produce a usable system.</p>
    <img class="radius-8" width="1000px" src="puredarwin-xmas-vmware-window-maker-desktop.png">
    <p class="two-no-mar centertext"><i>The Window Maker desktop environment running in the 'PureDarwin Xmas' release from December 2008.</i></p>

    <p><b>Skip to Section:</b></p>
    <pre><b><?php echo $postInfo->title ?></b>
&#x2523&#x2501&#x2501 <a href="#a-brief-history-of-darwin-os">A Brief History of Darwin OS</a>
&#x2523&#x2501&#x2501 <a href="#puredarwin-xmas">PureDarwin Xmas</a>
&#x2523&#x2501&#x2501 <a href="#booting-puredarwin-xmas-in-vmware">Booting PureDarwin Xmas in VMWare</a>
&#x2523&#x2501&#x2501 <a href="#puredarwin-beta-17-4">PureDarwin Beta 17.4</a>
&#x2523&#x2501&#x2501 <a href="#booting-puredarwin-beta-17-4-in-virtualbox">Booting PureDarwin Beta 17.4 in VirtualBox</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>

    <h2 id="a-brief-history-of-darwin-os">A Brief History of Darwin OS</h2>
    <p>Darwin itself was originally released by Apple in November 2000. It is a fork of <a href="https://en.wikipedia.org/wiki/Rhapsody_(operating_system)" target="_blank" rel="noopener">Rhapsody</a>, which was the codename used for Apple's next-generation operating system after the purchase of <a href="https://en.wikipedia.org/wiki/NeXT" target="_blank" rel="noopener">NeXT</a> in 1998. Darwin utilises the <a href="https://en.wikipedia.org/wiki/XNU" target="_blank" rel="noopener">XNU</a> kernel, and currently runs on modern x86-64 processors, as well as 32-bit ARM processors in the case of older iOS devices (e.g. the iPhone 5C).</p>
    <p>Many well-known elements of macOS such as the <a href="https://developer.apple.com/library/archive/documentation/Cocoa/Conceptual/CocoaFundamentals/WhatIsCocoa/WhatIsCocoa.html" target="_blank" rel="noopener">Cocoa</a> framework and the famous <a href="https://en.wikipedia.org/wiki/Aqua_(user_interface)" target="_blank" rel="noopener">Aqua</a> graphical user interface are not included in Darwin, and unfortunately remain closed-source.</p>
    <img class="radius-8" width="1000px" src="unix-timeline.png">
    <p class="two-no-mar centertext"><i>A timeline of Unix-based operating systems, showing the common ancestors between different systems. <a href="https://en.wikipedia.org/wiki/File:Unix_timeline.en.svg" target="_blank" rel="noopener">Source</a> (Public Domain)</i></p>
    <p>The PureDarwin project was founded not to create a drop-in replacement for macOS. Instead it strives to be a usable implementation of Darwin which remains faithful to Apple's open source core, but without closed-source components ('Pure'). Some example use cases of PureDarwin include an Apple-compatible build environment without using official Apple hardware, or to facilitate low-level testing of the Darwin kernel, without the limitations of macOS.</p>

    <h2 id="puredarwin-xmas">PureDarwin Xmas</h2>
    <p>The first developer preview release of PureDarwin is called '<a href="https://github.com/PureDarwin/PureDarwin/wiki/Xmas" target="_blank" rel="noopener">PureDarwin Xmas</a>', and was <a href="https://www.osnews.com/story/20696/puredarwin-xmas-developer-preview-released/" target="_blank" rel="noopener">released in December 2008</a> (hence the name 'Xmas'). It is based on Darwin 9, which corresponds to Mac OS X Leopard (10.5.x).</p>
    <p>PureDarwin Xmas is a 'complete' operating system featuring a desktop environment and various GUI applications. However, as it is just a developer preview, some features such as networking and hardware support are quite limited.</p>
    <img class="radius-8" width="1000px" src="puredarwin-xmas-vmware-window-maker-desktop-with-applications.png">
    <p class="two-no-mar centertext"><i>PureDarwin Xmas, showing the applications xcalc, xclock, xterm and xfontsel running in the Window Maker desktop window manager.</i></p>
    <p>The menu controls in the top left control which workspace is currently on show. The menu on the right hand side is the application launcher, and the buttons at the bottom show the currently running applications. You can minimise, restore and resize windows using the available controls.</p>
    <p>PureDarwin Xmas runs Bash 3.2.17, utilises the XFree86 4.7.0 display server and uses Window Maker 0.92.0 as the desktop window manager. <code>uname -a</code> yields the following:</p>
    <pre class="pre-wrap-text">Darwin PureDarwin.local 9.5.0 Darwin Kernel Version 9.5.0: Thu Sep 18 14:14:00 PDT 2008; root:xnu-1228.7.58.obj/RELEASE_I386 i386</pre>
    <p>Many command-line and GUI applications come pre-installed in PureDarwin Xmas, including xedit, nano and vim. However, some applications such as Firefox and OpenOffice don't work out-of-the-box due to lack of driver support or missing files.</p>
    <img class="radius-8" width="1000px" src="puredarwin-xmas-vmware-window-maker-desktop-with-application-menus.png">
    <p class="two-no-mar centertext"><i>Each of the primary application menus, showing the various programs and tools that are available in PureDarwin Xmas.</i></p>
    <p>For example, the basic word processing tool 'xedit' is available and can be used to write, save and load documents.</p>
    <img class="radius-8" width="1000px" src="puredarwin-xmas-vmware-xedit.png">
    <p class="two-no-mar centertext"><i>The 'xedit' tool with a new document being written.</i></p>
    <p>The Window Maker environment can be heavily customised, and a magnification tool is included too.</p>
    <img class="radius-8" width="1000px" src="puredarwin-xmas-vmware-window-maker-preferences.png">
    <p class="two-no-mar centertext"><i>The Window Maker configuration tool, with the magnifier showing a zoomed-in segment.</i></p>
    <p>Networking support is very limited in PureDarwin Xmas, and unfortunately isn't supported at all when using VMWare Workstation Player. This is because VMWare uses an 'Intel e1000' device as the emulated ethernet controller, which requires the <code>AppleIntel8245XEthernet.kext</code> driver. This driver is closed-source and not available for redistribution in any form.</p>

    <h2 id="booting-puredarwin-xmas-in-vmware">Booting PureDarwin Xmas in VMWare</h2>
    <p>PureDarwin Xmas can be run as a virtual machine or on native Intel hardware, subject to relevant driver support. VirtualBox isn't supported as it isn't possible to fully emulate the required CPU type. However, VMWare and QEMU can successfully boot PureDarwin Xmas when the correct configuration is used.</p>
    <p>Modern versions of QEMU cannot boot the origination PureDarwin Xmas image, due to incompatibilities with the Apple Partition Map file system used for the bootloader. Luckily, a <a href="https://github.com/PureDarwin/LegacyDownloads/releases/tag/PDXMASNBE01" target="_blank" rel="noopener">fixed version</a> has been released where the original bootloader has been 'transplanted' with an alternate one, where the file system is adequately supported in QEMU (x86 MBR).</p>
    <p>In my case, I used VMWare Workstation Player, as the PureDarwin Xmas image is distributed primarily in the VMWare virtual machine format.</p>
    <p><b>In order to boot PureDarwin Xmas in VMWare Workstation Player, the following steps can be used:</b></p>
    <ol class="large-spaced-list">
        <li>Download <code>puredarwinxmas.tar.xz</code> from the <a href="https://code.google.com/archive/p/puredarwin/downloads" target="_blank" rel="noopener">Google Code repository</a>. Check the download against the SHA-256 checksum <code>5dad4c534ec475a87e204361cd510fec511acb655484c00ff7ce8ca41cb55f86</code>. Extract the file to yield the <code>puredarwinxmas.vmwarevm</code> directory.</li>
        <li>Download and install the appropriate version of VMWare Workstation Player for your system from the <a href="https://my.vmware.com/en/web/vmware/free#desktop_end_user_computing/vmware_workstation_player/15_0" target="_blank" rel="noopener">downloads page</a>. Verify your download against the checksums provided.</li>
        <li>Open VMWare and import the <code>.vmx</code> file from the <code>puredarwinxmas.vmwarevm</code> directory. Keep the directory structure entact, as the configuration files in the directory are required in order to load the now-unsupported 'Mac OS Server' VM profile into VMWare.</li>
        <li>Boot the VM. PureDarwin Xmas will boot directly to the desktop. On modern hardware, the total boot time is around 10 seconds.</li>
    </ol>
    <p>The PureDarwin Xmas VMWare configuration assigns only 1 virtual CPU core and 128 MB of RAM, but this is comfortably enough to run the lightweight Window Maker desktop and multiple applications.</p>
    <img class="radius-8" width="1000px" src="puredarwin-xmas-vmware-library.png">
    <p class="two-no-mar centertext"><i>The PureDarwin Xmas virtual machine in the VMWare library.</i></p>
    <p>Interestingly, the VM profile used is 'Mac OS Server 10.5'. This isn't supported in modern versions of VMWare, as full Apple operating systems can only be virtualised on official Apple hardware. However, as the VMWare VM was created in a much older version of VMWare (in 2008), the profile is saved in the exported configuration and can still be used for booting PureDarwin Xmas in the latest VMWare releases (it will generate a warning though).</p>

    <h2 id="puredarwin-beta-17-4">PureDarwin Beta 17.4</h2>
    <p>The PureDarwin developers have been able to successfully install MacPorts in PureDarwin, allowing many software packages such as Apache HTTPd, Git and even XFCE to be installed. Unfortunately this is non-trivial to achieve without strong networking support, but it shows the potential use cases of PureDarwin.</p>

    <h2 id="booting-puredarwin-beta-17-4-in-virtualbox">Booting PureDarwin Beta 17.4 in VirtualBox</h2>
    <p>Unlike PureDarwin Xmas, the Beta 17.4 release of PureDarwin can be successfully booted in modern versions of VirtualBox and QEMU if the correct settings are used. VMware cannot be used, as it doesn't support modern macOS-esque guests unless you are running on official Apple hardware.</p>
    <p>In my case, I used VirtualBox to allow for easy configuration of the relevant settings. <b>The following steps can be used to boot PureDarwin Beta 17.4 in VirtualBox:</b></p>
    <ol class="large-spaced-list">
        <li>Download <code>pd_17_4.vmdk.xz</code> from the <a href="https://www.pd-devs.org/Beta/pd_17_4.vmdk.xz" target="_blank" rel="noopener">PureDarwin Devs site</a>. Check the download against the SHA-256 checksum <code>f2bb10f2fdb309a9a4fc77083c17b5a145db132551449a01b115f470d86c317c</code>. Extract the file to yield <code>pd_17_4.vmdk</code>.</li>
        <li>Download and install the appropriate version of VirtualBox for your system, either from your system package manager or from the <a href="https://www.virtualbox.org/wiki/Downloads" target="_blank" rel="noopener">downloads page</a>. Verify your download against the checksums provided.</li>
        <li>Create a new virtual machine using type '<b>Other/Unknown (32-bit)</b>', without an attached disk. Set the chipset mode to <b>ICH9</b> and enable <b>I/O APIC</b>, then add an IDE controller in <b>ICH6</b> mode. Attach the <code>.vmdk</code> virtual disk file to the IDE controller.</li>
        <li>Boot the VM. PureDarwin Beta 17.4 will boot to a Bash 3.2 shell prompt. On modern hardware, the boot time is around 20 seconds.</li>
    </ol>
    <p>There are some common errors that you may encounter if the virtual machine settings are not configured correctly. I have documented a couple of these below.</p>
    <h3 id="still-waiting-for-root-device"><code>Still waiting for root device</code>:</h3>
    <p>This error occurs when the root file system cannot be recognised during the boot process. This seems to be related to the fact that the root file system is a virtual file system within the VMDK image, rather than one that was created using physical hardware.</p>
    <pre class="pre-wrap-text">Waiting on &lt;dict ID="0"&gt;&lt;key&gt;IOProviderClass&lt;/key&gt;&lt;string ID="1"&gt;IOResources&lt;/string&gt;&lt;key&gt;IOResourcesMatch&lt;/key&gt;&lt;string ID="2"&gt;boot-uuid-media&lt;/string&gt;&lt;/dict&gt;
Still waiting for root device
Still waiting for root device
Still waiting for root device</pre>
    <p>This will occur around half way through the boot process, and the error will be printed repeatedly:</p>
    <img class="radius-8" width="1000px" src="puredarwin-17_4-beta-virtualbox-still-waiting-for-root-device.png">
    <p class="two-no-mar centertext"><i>PureDarwin Beta 17.4 running in VirtualBox, showing the '<code class="margin-left-7">Still waiting for root device</code>' error.</i></p>
    <p>In order to resolve this error, ensure that your virtual disk is using an IDE controller in ICH6 mode, and that the chipset mode is set to ICH9, as shown below:</p>
    <img class="radius-8" width="1000px" src="puredarwin-17_4-beta-virtualbox-ide-disk-controller-setup.png">
    <p class="two-no-mar centertext"><i>The VirtualBox IDE disk controller settings.</i></p>
    <br>
    <img class="radius-8" width="1000px" src="puredarwin-17_4-beta-virtualbox-motherboard-setup.png">
    <p class="two-no-mar centertext"><i>The VirtualBox motherboard settings.</i></p>
    <p>Once you have configured these options, PureDarwin should boot successfully.</p>
    <h3 id="bad-magic-number"><code>Bad magic number</code>:</h3>
    <p>This error occurs if you try to boot PureDarwin in 64-bit mode, as currently only 32-bit is supported:</p>
    <pre class="pre-wrap-text"></pre>
    <img class="radius-8" width="1000px" src="puredarwin-17_4-beta-virtualbox-bad-magic-number.png">
    <p class="two-no-mar centertext"><i>PureDarwin Beta 17.4 running in VirtualBox, showing the '<code class="margin-left-7">Bad magic number</code>' error.</i></p>
    <p>Ensure that the virtual machine type in VirtualBox is set to either 'Other/Unknown (32-bit)' or ''. This should allow PureDarwin to boot properly.</p>
</div>

<?php include "footer.php" ?>












