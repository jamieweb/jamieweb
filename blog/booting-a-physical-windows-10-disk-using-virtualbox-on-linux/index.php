<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Booting a Physical Windows 10 Disk Using VirtualBox on Linux</title>
    <meta name="description" content="Configuring VirtualBox on Linux to boot a physical Windows 10 disk connected via SATA or USB.">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/blog/booting-a-physical-windows-10-disk-using-virtualbox-on-linux/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Booting a Physical Windows 10 Disk Using VirtualBox on Linux</h1>
    <hr>
    <p><b>Friday 9th November 2018</b></p>
    <p>I recently acquired a computer with an OEM/factory-imaged Windows 10 disk inside. Straight away I took the disk out and replaced it with a Linux SSD, however since I don't own any other Windows systems, this will come in useful for testing my website for browser compatibility in Internet Explorer and Edge.</p>
    <p>I have put the Windows 10 disk in a USB SATA drive enclosure, and configured VirtualBox to be able to boot the raw disk. Now I'm able to test my site in IE and Edge usng the virtual machine running on my system.</p>
    <pre><b>Booting a Physical Windows 10 Disk Using VirtualBox on Linux</b>
&#x2523&#x2501&#x2501 <a href="#identifying-the-disk">Identifying the Disk</a>
&#x2523&#x2501&#x2501 <a href="#file-system-permissions">File System Permissions</a>
&#x2523&#x2501&#x2501 <a href="#virtualbox-raw-host-access-vmdk">VirtualBox Raw Host Access VMDK File</a>
&#x2523&#x2501&#x2501 <a href="#creating-and-configuring-the-virtual-machine">Creating and Configuring the Virtual Machine</a>
&#x2523&#x2501&#x2501 <a href="#troubleshooting-windows-is-hibernated-refused-to-mount">Troubleshooting: Windows is Hibernated, Refused to Mount</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>
    <h2 id="identifying-the-disk">Identifying the Disk</h2>
    <p>Mounting the disk/partitions is not actually required for VirtualBox to be able to boot it, however you will need to identify the correct block device ID for the disk (e.g. <code>/dev/sdb</code>).</p>
    <p>If you're using a modern desktop environment and file manager (e.g. XFCE with Thunar), the Windows 10 disk will probably be automatically mounted (if you get stuck at the error 'Windows is hibernated, refused to mount.', please see the troubleshooting <a href="#troubleshooting-windows-is-hibernated-refused-to-mount" target="_blank">here</a>). In my case, the <code>Windows</code> and <code>Recovery Image</code> partitions were auto-mounted. Then, you can use <code>lsblk</code> (List Block Devices) to identify the correct device. For example:</p>
    <pre>$ lsblk
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
    <p><b>If your disk is not automatically mounted, you don't need to mount it.</b> You can use <code>lshw</code> to determine the correct device. For example:</p>
    <pre>$ sudo lshw -short -class disk,volume
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
    <p>From this example output, you can see that <code>/dev/sdb</code> is the Windows 10 disk. This may differ for you though.</p>
    <p><b>For the rest of this document, I will refer to the correct block device ID for your system as <code>/dev/sdX</code>. Make sure to substitute this with the correct one for your system in commands that you execute.</b></p>

    <h2 id="file-system-permissions">File System Permissions</h2>
    <p>In order to have full, unrestricted access to the Windows 10 disk without having to use <code>sudo</code>, you need to give your user account the appropriate permissions.</p>
    <p>There are two main ways that this can be configured. The <a href="#higher-security-file-permissions-config">proper, higher-security method</a> which is best for <b>production/important</b> systems, or the <a href="#lower-security-file-permissions-config">quicker, lower-security method</a> which is suitable for <b>test/disposable</b> systems. You can choose which is best for you - you only need to complete one of them.</p>

    <h3 id="higher-security-file-system-permissions-config">Higher-Security File System Permissions Configuration</h3>
    <p><b>If you are using a system where security is important</b>, the best way to achieve this is to create a udev rule to match the Windows 10 disk and assign it to a particular group. Then, your non-privileged user account will have full read-write access to the disk(s) that match the rule, while the others remain protected.</p>
    <p>First, create a new group to use for the Windows 10 disk:</p>
    <pre>$ sudo groupadd win10disk</pre>
    <p>Then add your own user to the group:</pre>
    <pre>$ sudo usermod -a -G win10disk youruser</pre>
    <p>Next, you need to determine the UUID of the Windows 10 disk. You can do this using <code>udevadm</code>:</p>
    <pre>$ sudo udevadm info /dev/sdX | grep UUID</pre>
    <p>This should output the UUID of the Windows 10 disk. For example:</p>
    <pre>E: ID_PART_TABLE_UUID=01234567-89ab-cdef-0123-456789abcde</pre>
    <p><code>E:</code> means that it's a device environment variable, and the variable could be <code>ID_PART_TABLE_UUID</code>, <code>ID_FS_UUID</code> or something else with a similar meaning.</p>
    <p>If no UUID is outputted, try omitting the <code>grep</code> and looking for other variables that contain the UUID. If for some reason no UUID is returned, you may be able to use other attributes to uniquely identify the disk, however this may result in inaccuracies.</p>
    <p>Take a copy of the variable name and UUID, and create a file in the udev rules directory, such as <code>/etc/udev/rules.d/99-win10disk.rules</code>. Edit the file and add the following content, adjusting the variable name, UUID and group as required:</p>
    <pre>ENV{ID_PART_TABLE_UUID}=="01234567-89ab-cdef-0123-456789abcde", GROUP="win10disk"</pre>
    <p>Make sure to pay attention to the operators used in the rule. Like in most programming languages, <code>==</code> is an equality check and <code>=</code> is an assignment, so make sure to get these the right way around in the rule. You want to be checking the UUID and assigning the group, not the other way around!</p>
    <p>Save the file, then power cycle the Windows 10 disk (disconnect and reconnect, reboot, etc).</p>
    <p>Then, check that the rule worked by listing the block device file and checking the group:</p>
    <pre>$ ls -l /dev/sdb</pre>
    <p>This should output similar to the following:</p>
    <pre>brw-rw---- 1 root win10disk 8, 16 Nov  4 23:33 /dev/sdb</pre>
    <p>The key attribute to check is that the group is <code>win10disk</code>. If it is, then the file system permissions are configured correctly and you can <a href="">proceed to the next section</a>.</p>

    <h3 id="lower-security-file-system-permissions-config">Lower-Security File System Permissions Configuration</h3>
    <p><b>On the other hand, if you're using a system where security is less important (such as a disposable test machine)</b>, there is a quicker method. First, determine the group that has access to the drive:</p>
    <pre>$ ls -la /dev/sdX</pre>
    <p>This will output something like the following:</p>
    <pre>brw-rw---- 1 root disk 8, 16 Nov  3 23:36 /dev/sdb</pre>
    <p>From this, you can determine that the group is <code>disk</code>, and that this group has read and write access to the block device (<code>brw-<b>rw-</b>---</code>).</p>
    <p>The group name and permissions may differ for you, however in many cases it will be as above.</p>
    <p>Next, add your user to the group. <b>Please be aware of the potential security implications of this, as you will probably be giving your user account full read-write access to some or all storage devices. If the group is something else such as <code>root</code>, you should consider the <a href="#higher-security-file-system-permissions-config">higher-security setup</a> instead.</b></p>
    <pre>sudo usermod -a -G disk youruser</pre>

    <h2 id="virtualbox-raw-host-access-vmdk">VirtualBox Raw Host Access VMDK File</h2>
    <p>In order for VirtualBox to be able to boot the physical Windows 10 disk, you need to a create a special VMDK (Virtual Machine Disk) file that represents the physical disk.</p>
    <p>These raw host disk access VMDK files do not actually contain any data from the physical disk, they are just a pointer that VirtualBox can use to access it.</p>
    <p>You can create a VirtualBox raw disk image using <code>VBoxManage</code>. You can specify a location in the <code>-filename</code> argument:</p>
    <pre>$ VBoxManage internalcommands createrawvmdk -filename /path/to/diskname.vmdk -rawdisk /dev/sdX</pre>
    <p>This should output something similar to the following:</p>
    <pre>RAW host disk access VMDK file /path/to/windows10.vmdk created successfully.</pre>
    <p>The raw host disk access VMDK file only contains ASCII test, so you can <code>cat</code> or <code>less</code> it and have a look!</p>

    <h2 id="creating-and-configuring-the-virtual-machine">Creating and Configuring the Virtual Machine</h2>
    <p>Now that the raw host disk access VMDK has been created, you need to create a new VM and boot from it.</p>
    <p>Just set up a virtual machine as you normally would. Make sure to choose the correct type and version.</p>
    <p>When you get to the 'Hard disk' section, select 'Use an existing virtual hard disk file', and choose the VMDK file that you created in the previous step.</p>
    <img class="radius-8" src="/blog/booting-a-physical-windows-10-disk-using-virtualbox-on-linux/virtualbox-windows-10-hard-disk.png" width="1000px" title="The Hard Disk Section of the VirtualBox Virtual Machine Setup Wizard" alt="A screenshot of the hard disk section of the VirtualBox virtual machine setup wizard, with the VMDK file created in the previous step selected.">
    <p>Once you have completed the initial setup wizard, open the settings for the virtual machine, give it some extra CPU cores if possible, then set the boot order to 'Hard Disk' first, with all other options disabled.</p>
    <p>If the Windows 10 install on the disk is an EFI install, make sure to tick the 'Enable EFI' box.</p>
    <img class="radius-8" src="/blog/booting-a-physical-windows-10-disk-using-virtualbox-on-linux/virtualbox-windows-10-boot-order-and-efi.png" width="1000px" title="Setting the Boot Order and EFI Status for the Virtual Machine" alt="A screenshot of the virtual machine setting page showing the boot order set to 'Hard Disk', and EFI boot enabled if required.">
    <p>Save the settings, and then boot the virtual machine. If everything has worked, Windows 10 should boot up successfully.</p>
    <img class="radius-8" src="/blog/booting-a-physical-windows-10-disk-using-virtualbox-on-linux/virtualbox-windows-10-first-boot.png" width="1000px" title="Booting the Windows 10 Virtual Machine for the First Time" alt="A screenshot of the Windows 10 virtual machine booting successfully for the first time.">
    <p>If this is the first time you've booted the drive (it was for me), you'll have to go through the initial Windows 10 setup process where you choose the region, language, keyboard layout, etc. Cortana started speaking to me during the setup process so watch out for that!</p>
    <p>Once you're all done with setup, Windows 10 should boot to the desktop successfully.</p>
    <img class="radius-8" src="/blog/booting-a-physical-windows-10-disk-using-virtualbox-on-linux/virtualbox-windows-10-first-full-boot-after-setup.png" width="1000px" title="The First Full Boot After the Windows 10 Setup Was Complete" alt="A screenshot of the first full boot after the Windows 10 setup was complete.">
    <p>If you want to be able to make Windows 10 full screen, etc, install the VirtualBox Guest Additions using <code>Devices -> Insert Guest Additions CD image...</code>, then run the installer in the virtual machine.</p>
    <img class="radius-8" src="/blog/booting-a-physical-windows-10-disk-using-virtualbox-on-linux/virtualbox-windows-10-guest-additions.png" width="1000px" title="Installing the VirtualBox Guest Additions" alt="A screenshot of the installer for the VirtualBox Guest Additions running in the Windows 10 virtual machine.">
    <p>Once this is complete, reboot the virtual machine and Windows should automatically display in full screen. If not, you should be able to manually set your resolution using the display settings in Windows.</p>
    <img class="radius-8" src="/blog/booting-a-physical-windows-10-disk-using-virtualbox-on-linux/virtualbox-windows-10-full-screen-1920x1080.png" width="1000px" title="Windows 10 Running at 1920x1080 After Installing VirtualBox Guest Additions" alt="A screenshot of the Windows 10 virtual machine running at 1920x1080 after installing VirtualBox Guest Additions">
    <p>When it comes to Windows Product Activation, I'm not really able to advise. I've heard that Windows will often become unactivated when changing hardware, however in my case the activation remained. This may be because I never actually fully booted the Windows 10 disk when it was in the original desktop machine.</p>

    <h2 id="troubleshooting-windows-is-hibernated-refused-to-mount">Troubleshooting: Windows is Hibernated, Refused to Mount</h2>
    <p>When mounting the Windows 10 disk, you may see the following error:</p>
    <pre class="pre-wrap-text">Failed to mount "Windows".

Error mounting /dev/sdb3 at /media/user/Windows: Command-line `mount -t "ntfs" -o "uhelper=udisks2,nodev,nosuid,uid=1000,gid=1000" "/dev/sdb3" "/media/user/Windows"' exited with non-zero exit status 14: Window is hibernated, refused to mount.

Failed to mount '/dev/sdb3': Operation not permitted

The NTFS partition is in an unsafe state. Please resume and shutdown Windows fully (no hibernation or fast restarting), or mount the volume read-only with the 'ro' option.</pre>
    <p>This can occur if Windows 10 is hibernated, or was otherwise not correctly shut down.</p>
    <p>In order to fix this you need to remove the hibernation file. This can be done using <code>mount</code>.</p>
    <p>In the command examples below, make sure to change <code>N</code> in <code>/dev/sdXN</code> to the partition number of the main Windows partition. Also change the <code>X</code> to the correct block device ID as usual.</p>
    <p><b>Please be aware that this will permanently erase the hibernation file, so any data not properly saved will be lost.</b></p>
    <pre>$ sudo mkdir /path/to/desired/mount/directory
$ sudo mount -t ntfs-3g /dev/sdXN /path/to/desired/mount/directory -o remove_hiberfile</pre>

    <h2 id="conclusion">Conclusion</h2>
    <p>I'm pleasantly surprised that this worked - I was expecting Windows to fail to boot or at least have serious problems due to the drastic change in hardware from the original machine, but it seems to work fine.</p>
    <p>I'm going to use this VM to test my website for compatibility in Internet Explorer and Edge, in order to make sure that everything is presented as best as it can be.</p>
    <p>On a side note, look how much bloatware came pre-installed on this. It's just a standard Windows 10 disk pulled from a shop-bought HP desktop machine... unbelievable!</p>
    <img class="radius-8" src="/blog/booting-a-physical-windows-10-disk-using-virtualbox-on-linux/virtualbox-windows-10-pre-installed-hp-programs.png" width="1000px" title="The Control Panel 'Uninstall or change a program' Menu Showing a Large Number of Pre-installed HP Programs" alt="A screenshot of the Control Panel 'Uninstall or change a program' menu showing a large number of pre-installed HP programs.">
    <p>Luckily this is in a VM on my segregated test machine. I wouldn't want to be exposing all that to my network!</p>
</div>

<?php include "footer.php" ?>

</body>

</html>






