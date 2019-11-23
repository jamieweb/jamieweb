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
    <p>The PureDarwin project was founded not to create a drop-in replacement for macOS. Instead it strives to be a usable implementation of Darwin which remains faithful to Apple's open source core, but without closed-source components ('Pure'). Some example use cases of PureDarwin include an Apple-compatible build environment without using official Apple hardware, or to facilitate low-level testing of the Darwin kernel, without the limitations of macOS.</p>

    <h2 id="puredarwin-xmas">PureDarwin Xmas</h2>
    <p>The first developer preview release of PureDarwin is called '<a href="https://github.com/PureDarwin/PureDarwin/wiki/Xmas" target="_blank" rel="noopener">PureDarwin Xmas</a>', and was <a href="https://www.osnews.com/story/20696/puredarwin-xmas-developer-preview-released/" target="_blank" rel="noopener">released in December 2008</a> (hence the name 'Xmas'). It is based on Darwin 9, which corresponds to Mac OS X Leopard (10.5.x).</p>
    <p>PureDarwin Xmas is a 'complete' operating system featuring a desktop environment and various GUI applications. However, as it is just a developer preview, some features such as networking and hardware support are quite limited.</p>
    <img class="radius-8" width="1000px" src="puredarwin-xmas-vmware-window-maker-desktop-with-applications.png">
    <p class="two-no-mar centertext"><i>PureDarwin Xmas, showing the applications xcalc, xclock, xterm and xfontsel running in the Window Maker desktop window manager.</i></p>
    <p>The menu controls in the top left control which workspace is currently on show. The menu on the right hand side is the application launcher, and the buttons at the bottom show the currently running applications. You can minimise, restore and resize windows using the available controls.</p>
    <p>PureDarwin Xmas runs Bash 3.2 and uses Window Maker as the desktop window manager. <code>uname -a</code> yields the following:</p>
    <pre>Darwin PureDarwin.local 9.5.0 Darwin Kernel Version 9.5.0: Thu Sep 18 14:14:00 PDT 2008; root:xnu-1228.7.58.obj/RELEASE_I386 i386</pre>
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
        <li>Download <code>puredarwinxmas.tar.xz</code> from the <a href="https://code.google.com/archive/p/puredarwin/downloads" target="_blank" rel="noopener">Google Code repository</a>. Check the download against the SHA-1 checksum <code>80f88f44cc540ea05aa847bb18b94bdd133b6c07</code>. Extract the file to yield the <code>puredarwinxmas.vmwarevm</code> directory.</li>
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
</div>

<?php include "footer.php" ?>












