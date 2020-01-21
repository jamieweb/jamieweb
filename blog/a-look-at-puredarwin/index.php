<?php include "response-headers.php"; content_security_policy();
include_once "bloglist.php"; bloglist("postTop", null, null, 2019); ?>

<div class="body">
    <h1><?php echo $postInfo->title; ?></h1>
    <hr>
    <p><b><?php echo $postInfo->date; ?></b></p>
    <p><?php echo $postInfo->snippet; ?></p>
    <img class="radius-8" width="1000px" src="puredarwin-xmas-vmware-window-maker-desktop.png">
    <p class="two-no-mar centertext"><i>The Window Maker desktop environment running in the 'PureDarwin Xmas' release from December 2008.</i></p>

    <p><b>Skip to Section:</b></p>
    <pre class="contents"><b><?php echo $postInfo->title ?></b>
&#x2523&#x2501&#x2501 <a href="#a-brief-history-of-darwin-os">A Brief History of Darwin OS</a>
&#x2523&#x2501&#x2501 <a href="#puredarwin-xmas">PureDarwin Xmas</a>
&#x2523&#x2501&#x2501 <a href="#booting-puredarwin-xmas-in-vmware">Booting PureDarwin Xmas in VMware</a>
&#x2523&#x2501&#x2501 <a href="#puredarwin-17-4-beta">PureDarwin 17.4 Beta</a>
&#x2523&#x2501&#x2501 <a href="#booting-puredarwin-17-4-beta-in-virtualbox">Booting PureDarwin 17.4 Beta in VirtualBox</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>

    <h2 id="a-brief-history-of-darwin-os">A Brief History of Darwin OS</h2>
    <p>Darwin itself was originally released by Apple in November 2000. It is a fork of <a href="https://en.wikipedia.org/wiki/Rhapsody_(operating_system)" target="_blank" rel="noopener">Rhapsody</a>, which was the codename used for Apple's next-generation operating system after the purchase of <a href="https://en.wikipedia.org/wiki/NeXT" target="_blank" rel="noopener">NeXT</a> in 1998. Darwin utilises the <a href="https://en.wikipedia.org/wiki/XNU" target="_blank" rel="noopener">XNU</a> kernel, and currently runs on modern x86-64 processors, as well as 32-bit ARM processors in the case of older iOS devices (e.g. the iPhone 5C).</p>
    <p>Many well-known elements of macOS such as the <a href="https://developer.apple.com/library/archive/documentation/Cocoa/Conceptual/CocoaFundamentals/WhatIsCocoa/WhatIsCocoa.html" target="_blank" rel="noopener">Cocoa</a> framework and the famous <a href="https://en.wikipedia.org/wiki/Aqua_(user_interface)" target="_blank" rel="noopener">Aqua</a> graphical user interface are not included in Darwin, and unfortunately remain closed source.</p>
    <img class="radius-8" width="1000px" src="unix-timeline.png">
    <p class="two-no-mar centertext"><i>A timeline of Unix-based operating systems, showing the common ancestors between different systems. <a href="https://en.wikipedia.org/wiki/File:Unix_timeline.en.svg" target="_blank" rel="noopener">Source</a> (Public Domain)</i></p>
    <p>The PureDarwin project was founded not to create a drop-in replacement for macOS. Instead it strives to be a usable implementation of Darwin which remains faithful to Apple's open source core, but without closed source components ('Pure'). Some example use cases of PureDarwin include an Apple-compatible build environment without using official Apple hardware, or to facilitate low-level testing of the Darwin kernel, without the limitations of macOS.</p>

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
    <p>Networking support is very limited in PureDarwin Xmas, and unfortunately isn't supported at all when using VMware Workstation Player. This is because VMware uses an 'Intel e1000' device as the emulated ethernet controller, which requires the <code>AppleIntel8245XEthernet.kext</code> driver. This driver is closed source and not available for redistribution in any form.</p>

    <h2 id="booting-puredarwin-xmas-in-vmware">Booting PureDarwin Xmas in VMware</h2>
    <p>PureDarwin Xmas can be run as a virtual machine or on native Intel hardware, subject to relevant driver support. VirtualBox isn't supported as it isn't possible to fully emulate the required CPU type. However, VMware and QEMU can successfully boot PureDarwin Xmas when the correct configuration is used.</p>
    <p>Modern versions of QEMU cannot boot the original PureDarwin Xmas image, due to incompatibilities with the Apple Partition Map file system used for the bootloader. Luckily, a <a href="https://github.com/PureDarwin/LegacyDownloads/releases/tag/PDXMASNBE01" target="_blank" rel="noopener">fixed version</a> has been released where the original bootloader has been 'transplanted' with an alternate one, where the file system is adequately supported in QEMU (x86 MBR).</p>
    <p>In my case, I used VMware Workstation Player, as the PureDarwin Xmas image is distributed primarily in the VMware virtual machine format.</p>
    <p><b>In order to boot PureDarwin Xmas in VMware Workstation Player, the following steps can be used:</b></p>
    <ol class="large-spaced-list">
        <li>Download <code>puredarwinxmas.tar.xz</code> from the <a href="https://code.google.com/archive/p/puredarwin/downloads" target="_blank" rel="noopener">Google Code repository</a>. Check the download against the SHA-256 checksum <code>5dad4c534ec475a87e20<wbr>4361cd510fec511acb65<wbr>5484c00ff7ce8ca41cb55f86</code>. Extract the file to yield the <code>puredarwinxmas.vmwarevm</code> directory.</li>
        <li>Download and install the appropriate version of VMware Workstation Player for your system from the <a href="https://my.vmware.com/en/web/vmware/free#desktop_end_user_computing/vmware_workstation_player/15_0" target="_blank" rel="noopener">downloads page</a>. Verify your download against the checksums provided.</li>
        <li>Open VMware and import the <code>.vmx</code> file from the <code>puredarwinxmas.vmwarevm</code> directory. Keep the directory structure intact, as the configuration files in the directory are required in order to load the now-unsupported 'Mac OS Server' VM profile into VMware.</li>
        <li>Boot the VM. PureDarwin Xmas will boot directly to the desktop. On modern hardware, the total boot time is around 10 seconds.</li>
    </ol>
    <p>The PureDarwin Xmas VMware configuration assigns only 1 virtual CPU core and 128 MB of RAM, but this is comfortably enough to run the lightweight Window Maker desktop and multiple applications.</p>
    <img class="radius-8" width="1000px" src="puredarwin-xmas-vmware-library.png">
    <p class="two-no-mar centertext"><i>The PureDarwin Xmas virtual machine in the VMware library.</i></p>
    <p>Interestingly, the VM profile used is 'Mac OS Server 10.5'. This isn't supported in modern versions of VMware, as full Apple operating systems can only be virtualised on official Apple hardware. However, as the VMware VM was created in a much older version of VMware (in 2008), the profile is saved in the exported configuration and can still be used for booting PureDarwin Xmas in the latest VMware releases (it will generate a warning though).</p>

    <h2 id="puredarwin-17-4-beta">PureDarwin 17.4 Beta</h2>
    <p>At the time of writing, the latest release of PureDarwin is <a href="https://github.com/PureDarwin/PD-17.4-Beta" target="_blank" rel="noopener">17.4 Beta</a>. This was released in 2018, and is based on Darwin 17, which corresponds to macOS High Sierra (10.13.x).</p>
    <p>Unlike PureDarwin Xmas, the 17.4 Beta release is a more lightweight/stripped-down OS, which doesn't feature a full GUI or display server. However, it has much improved driver support for modern hardware and hypervisors, and allows for basic networking when used in specific environments.</p>
    <img class="radius-8" width="1000px" src="puredarwin-17_4-beta-virtualbox-bash.png">
    <p class="two-no-mar centertext"><i>The Bash 3.2 shell prompt in PureDarwin 17.4 Beta, showing the output of the commands <code>hostinfo</code>, <code>df -h</code>, <code>ps aux</code> and <code>ifconfig</code>.</i></p>
    <p>The 17.4 Beta release runs Bash 3.2.57, and <code>uname -a</code> yields the following:</p>
    <pre class="pre-wrap-text">Darwin PureDarwin-17.4.local 17.4.0 Darwin Kernel Version 17.4.0: Mon 12 Feb 2018 00:19:58 GMT; ethan:xnu-4570.41.2/obj/RELEASE_X86_64 x86</pre>

    <h2 id="booting-puredarwin-17-4-beta-in-virtualbox">Booting PureDarwin 17.4 Beta in VirtualBox</h2>
    <p>Unlike PureDarwin Xmas, the 17.4 Beta release of PureDarwin can be successfully booted in modern versions of VirtualBox and QEMU if the correct settings are used. VMware cannot be used, as it doesn't support modern macOS-esque guests unless you are running on official Apple hardware.</p>
    <p>In my case, I used VirtualBox to allow for easy configuration of the relevant settings. <b>The following steps can be used to boot PureDarwin 17.4 Beta in VirtualBox:</b></p>
    <ol class="large-spaced-list">
        <li>Download <code>pd_17_4.vmdk.xz</code> from the <a href="https://www.pd-devs.org/Beta/pd_17_4.vmdk.xz" target="_blank" rel="noopener">PureDarwin Devs site</a>. Check the download against the SHA-256 checksum <code>f2bb10f2fdb309a9a4fc<wbr>77083c17b5a145db1325<wbr>51449a01b115f470d86c317c</code>. Extract the file to yield <code>pd_17_4.vmdk</code>.</li>
        <li>Download and install the appropriate version of VirtualBox for your system, either from your system package manager or from the <a href="https://www.virtualbox.org/wiki/Downloads" target="_blank" rel="noopener">downloads page</a>. Verify your download against the checksums provided.</li>
        <li>Create a new virtual machine using type '<b>Mac OS X -> macOS 10.13 High Sierra (64-bit)</b>', without an attached disk. Set the chipset mode to <b>ICH9</b> and enable <b>I/O APIC</b>, then add an IDE controller in <b>ICH6</b> mode. Attach the <code>.vmdk</code> virtual disk file to the IDE controller.</li>
        <li>Boot the VM. PureDarwin 17.4 Beta will boot to a Bash 3.2 shell prompt. On modern hardware, the boot time is around 20 seconds.</li>
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
    <p class="two-no-mar centertext"><i>PureDarwin 17.4 Beta running in VirtualBox, showing the '<code class="margin-left-7">Still waiting for root device</code>' error.</i></p>
    <p>In order to resolve this error, ensure that your virtual disk is using an IDE controller in ICH6 mode, and that the chipset mode is set to ICH9, as shown below:</p>
    <img class="radius-8" width="1000px" src="puredarwin-17_4-beta-virtualbox-ide-disk-controller-setup.png">
    <p class="two-no-mar centertext"><i>The VirtualBox IDE disk controller settings.</i></p>
    <br>
    <img class="radius-8" width="1000px" src="puredarwin-17_4-beta-virtualbox-motherboard-setup.png">
    <p class="two-no-mar centertext"><i>The VirtualBox motherboard settings.</i></p>
    <p>Once you have configured these options, PureDarwin should boot successfully.</p>
    <h3 id="mach-o-i386-file-has-bad-magic-number"><code>Mach-O (i386) file has bad magic number</code>:</h3>
    <p>This error occurs if you try to boot PureDarwin 17.4 Beta in 32-bit mode, as currently only 64-bit is supported:</p>
    <pre class="pre-wrap-text">Mach-O (i386) file has bad magic number
Decoding kernel failed.
Press a key to continue...</pre>
    <img class="radius-8" width="1000px" src="puredarwin-17_4-beta-virtualbox-bad-magic-number.png">
    <p class="two-no-mar centertext"><i>PureDarwin 17.4 Beta running in VirtualBox, showing the '<code class="margin-left-7">bad magic number</code>' error.</i></p>
    <p>Ensure that the virtual machine type in VirtualBox is set to either 'Mac OS X -> macOS 10.13 High Sierra (64-bit)' or 'Other -> Other/Unknown (64-bit)', as shown below:</p>
    <img class="radius-8" width="1000px" src="puredarwin-17_4-beta-virtualbox-general-basic-settings.png">
    <p class="two-no-mar centertext"><i>The VirtualBox general/basic settings.</i></p>
    <p>Once you have done this, PureDarwin 17.4 Beta should be able to boot successfully.</p>

    <h2 id="conclusion">Conclusion</h2>
    <p>Overall I am impressed with the PureDarwin project and have enjoyed conducting my research around it. They have achieved a lot, considering that the project is funded by community donations and run by volunteers. It definitely isn't a production-ready system, but for developers it has the potential to come in very useful.</p>
    <p>The PureDarwin team have been able to successfully install MacPorts in PureDarwin, allowing many software packages such as Apache HTTPd, Git and even XFCE to be installed. Unfortunately this is non-trivial to achieve without strong networking support, but it shows the potential use cases of PureDarwin.</p>
    <p>Please check out the project at <a href="https://www.puredarwin.org" target="_blank" rel="noopener">www.puredarwin.org</a>, and support their work by contributing if you are able to.</p>
</div>

<?php include "footer.php" ?>
