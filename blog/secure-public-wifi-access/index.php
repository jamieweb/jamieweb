<?php include "response-headers.php"; content_security_policy(); ?>
<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Using a Public Wi-Fi Hotspot Securely</title>
    <meta name="description" content="Connecting to hotel Wi-Fi through a Raspberry Pi and forwarding an external VPN connection.">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/blog/secure-public-wifi-access/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Using a Public Wi-Fi Hotspot Securely</h1>
    <hr>
    <p><b>Tuesday 8th May 2018</b></p>
    <p><u>The problem:</u> You want to connect to the internet in a hotel or coffee shop, but don't want to expose your laptop to the insecure, unencrypted Wi-Fi network.</p>
    <p><u>A solution:</u> Connect to the internet through a Raspberry Pi, and have it forward a secure VPN connection through to your laptop.</p>
    <pre><b>Using a Public Wi-Fi Hotspot Securely</b>
&#x2523&#x2501&#x2501 <a href="#what-is-wrong-with-using-a-vpn">What is wrong with just using a VPN?</a>
&#x2523&#x2501&#x2501 <a href="#raspberry-pi-secure-connection">Using a Raspberry Pi to Connect Securely</a>
&#x2523&#x2501&#x2501 <a href="#raspberry-pi-setup">Initial Raspberry Pi Setup</a>
&#x2523&#x2501&#x2501 <a href="#vnc-ssh-tunnel">VNC SSH Tunnel</a>
&#x2523&#x2501&#x2501 <a href="#firewall-rules">Network Forwarding and Blocking</a>
&#x2523&#x2501&#x2501 <a href="#connecting-to-the-internet">Connecting to the Internet</a>
&#x2523&#x2501&#x2501 <a href="#potential-problems">Potential Problems With This Design</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>
    <h2 id="what-is-wrong-with-using-a-vpn">What is wrong with just using a VPN?</h2>
    <p>It is common advice to use a VPN when browsing the internet from a public Wi-Fi hotspot, however this is only effective to a certain extent:</p>
    <ul class="spaced-list">
        <li>Your device is still connected to the network, so everybody else can see it.</li>
        <li>You have to deal with the captive portal (login page), which is essentially a man-in-the-middle attack on your device. It can be challenging to prevent these from auto-opening too, meaning that you are essentially surrendering your device into opening an arbitrary (and potentially malicious) web page.</li>
        <li>VPN leaks can be difficult to avoid and often catch you out:</li>
            <ul>
                <li>DNS</li>
                <li>IPv6</li>
                <li>Unexpected Disconnect</li>
                <li>Initial Connection</li>
                <li>Background Services on some OS's that seem to refuse to use the VPN</li>
                <li>Routes for private IP ranges</li>
            </ul>
        </li>
    </ul>
    <h2 id="raspberry-pi-secure-connection">Using a Raspberry Pi to Connect Securely</h2>
    <p>A solution to this problem is to use a Raspberry Pi as a router, and have it forward through a connection to your external VPN.</p>
    <p>The Raspberry Pi will connect to the public Wi-Fi hotspot and deal with the captive portal. The Pi will then forward an internet connection through the ethernet interface, which has all traffic blocked except for the IP address of your external VPN.</p>
    <p>This means that your secure laptop never has to touch the insecure network, and it is not possible for VPN leaks to occur since all other traffic is blocked.</p>
    <p>Requirements:</p>
    <ul class="spaced-list">
        <li>Secure VPN accessible over the internet with a static IP (eg: OpenVPN on rented server)</li>
        <li>Raspberry Pi (any model)</li>
        <li>Wi-Fi adapter (if required)</li>
        <li>Ethernet cable</li>
        <li>SD card for Raspberry Pi</li>
    </ul>
    <p>You don't <i>have</i> to use a Raspberry Pi - any device can function in the same way. A Raspberry Pi is just convenient, cost effective and easily accessible.</p>
    <h2 id="raspberry-pi-setup">Initial Raspberry Pi Setup</h2>
    <p>This guide assumes that you already have basic Linux knowledge as well as a Raspberry Pi set up and working, and that you are able to connect to it over SSH or directly with a mouse and keyboard.</p>
    <h3>a. Ensure That SSH is Enabled at Boot</h3>
    <p>In order to ensure that the SSH server is set to start at boot, you can either place an empty file named <code>ssh</code> in the /boot directory:</p>
    <pre>$ sudo touch /boot/ssh</pre>
    <p>...followed by rebooting.</p>
    <p>Or use <code>raspi-config</code> to enable it:</p>
    <pre>$ sudo raspi-config</pre>
    <p>Navigate to <code>Interfacing Options</code> -&gt; <code>SSH</code> and ensure that SSH is enabled:</p>
    <img class="radius-8 max-width-100-percent" width="700px" src="/blog/secure-public-wifi-access/raspi-config-interfaces.png">
    <h3>b. Configure UFW (Uncomplicated Firewall) and Fail2ban</h3>
    <p>Install <code>ufw</code> and <code>fail2ban</code> if they aren't already installed:</p>
    <pre>$ sudo apt-get install ufw fail2ban</pre>
    <p>Enable rate-limiting for SSH and enable the firewall:</p>
    <pre>$ sudo ufw limit 22/tcp
$ sudo ufw enable</pre>
    <p>Set a basic fail2ban config in order to block repeated failed SSH authentication attempts. Create the file <code>/etc/ssh/jail.local</code> and add the following content:</p>
    <pre>[DEFAULT]
bantime = 3600
findtime = 3600
maxretry = 3</pre>
    <h3>c. SSH Server Hardening</h3>
    <p>It is recommended to use <a href="https://help.ubuntu.com/community/SSH/OpenSSH/Keys" target="_blank" rel="noopener">SSH key authentication</a>, however if you wish to use password authentication, ensure that the password is strong.</p>
    <p>Use your favourite text editor (eg: <code>nano</code>) to edit the file <code>/etc/fail2ban/sshd_config</code>, and ensure that the following values are set:</p>
    <pre>PermitRootLogin no
X11Forwarding no
PermitTunnel yes</pre>
    <p>Also ensure that the <code>AcceptEnv LANG_LC*</code> value is commented out (put a # at the start of the line).</p>
    <p>If you are using SSH key authetication, you should also set <code>PasswordAuthentication</code> to <code>no</code>.</p>
    <p>Additionally, you must set access rules in order to ensure that logins are only permitted from certain locations:</p>
    <pre>AllowUsers pi@&lt;your-local-ip-address&gt; pi@192.168.2.2</pre>
    <p>Substitute "&lt;your-local-ip-address&gt;" for the private IP address of your client device. This is the one that you can find from <code>ifconfig</code> (*nix) or <code>ipconfig</code> (Windows) - it most likely begins with "192.168.". Make sure that you use your private IPv4 address, as IPv6 will be disabled in order to help prevent VPN leaks.</p>
    <p>The 192.168.2.2 address is part of the subnet that will be created later in this guide. If this subnet is in use on your network, you may select another one and adjust your configuration accordingly throughout the rest of the guide.</p>
    <h3>d. Disable IPv6</h3>
    <p>As much as <a href="/blog/ipv6-site-upgrade" target="_blank">I like IPv6</a>, in this particular use case, it provides unnecessary complications and security risks. Public Wi-Fi hotspots rarely support IPv6 anyway, so it's not like you're missing out.</p>
    <p>Edit the file <code>/etc/sysctl.conf</code> and set the following values:</p>
    <pre>net.ipv6.conf.all.disable_ipv6 = 1
net.ipv6.conf.default.disable_ipv6 = 1
net.ipv6.conf.lo.disable_ipv6 = 1
net.ipv6.conf.wlan0.disable_ipv6 = 1
net.ipv6.conf.eth0.disable_ipv6 = 1</pre>

    <h2 id="vnc-ssh-tunnel">VNC SSH Tunnel</h2>
    <p>For this setup, VNC will be used in order to provide remote desktop functionality. Remote desktop is required so that you can view the captive portal and authenticate in order to access the public Wi-Fi hotspot.</p>
    <p>While it could be possible to handle the captive portal using a command-line browser such as <code>elinks</code>, many captive portals nowadays are unfortunately very JavaScript heavy and involve filling out forms, which elinks sometimes doesn't handle well.</p>
    <p>It is not safe to run a VNC server that is exposed to an untrusted network. In order to lock it down, SSH tunneling can be used. This will tunnel the insecure VNC connection through the secure SSH tunnel, meaning that the traffic will be encrypted and integrity checked.</p>
    <h3>a. Install TightVNC Server</h3>
    <p>Install TightVNC server on your Pi:</p>
    <pre>$ sudo apt-get install tightvncserver</pre>
    <p>You can then start a VNC desktop bound only to localhost using the following command (adjust screen resolution as required):</p>
    <pre>$ vncserver :3 -geometry 1920x1080 -localhost</pre>
    <p>The <code>:3</code> refers to the ID of the virtual screen. If you use another number here, you'll have to adjust the port number for connections later on.</p>
    <p>The first time you start a VNC desktop, it will ask you to set a password. This password really does not matter, as it will not be used for authentication in this setup - the SSH tunnel handles this instead.</p>
    <h3>b. Configure the SSH Tunnel</h3>
    <p>On your client device, you can start an SSH tunnel connection to your Pi with the following command:</p>
    <pre>$ ssh -e none -x -L 5902:127.0.0.1:5903 pi@&lt;your-pi-ip-address&gt;</pre>
    <p>Syntax explanation:</p>
    <ul class="spaced-list">
        <li><b>-e none</b>: Disable the escape character, which prevents binary data (in this case, VNC) from accidentally closing the connection.</li>
        <li><b>-x</b>: Disable X11 forwarding - meaning that you can't view graphical applications through the connection. In this case, X11 forwarding is not required so it is disabled for security.</li>
        <li><b>-L 5902:127.0.0.1:5903</b>: This creates the tunnel. Connections to 127.0.0.1 (localhost) on port 5902 on the client will be forwarded through the tunnel to 127.0.0.1 port 5903 on the remote host. This means that connecting from your client to <code>localhost:5902</code> will connect you to the remote desktop running on port 5903. Port 5900+N is the default port for VNC, where N is the display number. For example, if you want to connect to display 4, then port 5904 is what you should use.</p>
    </ul>
    <p>For further details, please see the <a href="https://linux.die.net/man/1/ssh" target="_blank" rel="noopener">SSH manual page</a>.</p>
    <p>If you are using SSH key authentication, you can manually specify the location of the key using <code>-i</code> for example: <code>ssh -i ~/.ssh/pi</code>
    <h3>c. Connect to VNC</h3>
    <p>Now that the SSH tunnel is established, you can connect to the remote VNC desktop through it. You must keep the SSH tunnel open for this to work and also ensure that you previously started the VNC server.</p>
    <p>Using your favourite VNC-compatible remote desktop client (eg: Remmina), simply connect to <code>localhost:5902</code>. You should be prompted for the VNC password and the remote desktop session will start.</p>
    <p><i>To clarify, connect from your client device to <code>localhost:5902</code>. The SSH tunnel that is running is listening for connections on this address, and it will forward them through the tunnel to the remote host (the Pi).</i></p>
    <img class="radius-8 max-width-100-percent" width="700px" src="/blog/secure-public-wifi-access/rpi-remote-desktop-vnc.png">
    <p>In order to terminate the VNC session, simply run <code>vncserver -kill :3</code> from the SSH tunnel connection. You can then close the SSH connection as usual.</p>
    <h3>d. Chromium Browser Hardening</h3>
    <p>Chromium will be used to deal with the captive portal on the public hotspot. In order to provide some basic protection, it is recommended to disable JavaScript, cookies, Flash, etc. All of this can be done in <code>Settings</code> -&gt; <code>Advanced</code> -&gt; <code>Content Settings</code>.</p>
    <p>You can then whitelist these on a per-site basis if required by clicking the left of the Omnibox (URL bar) and setting them to <code>Allow</code>.</p>
    <p>I also recommend adding a bookmark for a site that does not use TLS. This is because you'll need to visit a HTTP-only website in order to trigger the redirect to the captive portal. <sub><sup><sup>[HTTP]</sup></sup></sub><a href="http://neverssl.com" target="_blank" rel="noopener">neverssl.com</a> is great for this.</p>
    <h2 id="firewall-rules">Network Forwarding and Blocking</h2>
    <p>Next, you must configure your Raspberry Pi to act as a router, and then to block all connections except for those out to your VPN.</p>
    <h3>a. Enable Native IPv4 Packet Forwarding</h3>
    <p>Edit the file <code>/etc/sysctl.conf</code> and ensure that the option <code>net.ipv4.ip_forward=1</code> is set. It is probably commented out by default - just remove the hash.</p>
    <p>This configuration will be applied at the next reboot, although you can also reload the configuration now using <code>sudo sysctl -p /etc/sysctl.conf</code>.</p>
    <p>If you forget to do this, your forwarded network connection will be extremely slow.</p>
    <h3>b. Configure Firewall Rules</h3>
    <p>Create a file named <code>forward.sh</code> (any name is fine), and insert the script shown below. This script will configure your Raspberry Pi to act as a router. All traffic between the Raspberry Pi and your laptop will also be blocked except for connections to itself and your external VPN.</p>
    <p>In this example, I have used the IPv4 address of this web server (139.162.222.67) as the external VPN address - you must substitute this with the IP of yours. You may also need to use different network interface names (<code>wlan0</code> and <code>eth0</code>). Check your interfaces using <code>ifconfig</code>.</p>
    <pre>#!/bin/bash
#Allow NAT
iptables -t nat -A POSTROUTING -o wlan0 -j MASQUERADE

#Block everything between Wi-Fi and Ethernet
iptables -I FORWARD -i wlan0 -o eth0 -j DROP
iptables -I FORWARD -i eth0 -o wlan0 -j DROP

#Allow VPN out
iptables -I FORWARD -o wlan0 -i eth0 -d 139.162.222.67 -j ACCEPT

#Allow VPN in
iptables -I FORWARD -i wlan0 -o eth0 -s 139.162.222.67 -m state --state RELATED,ESTABLISHED -j ACCEPT

#Allow client to Pi communication for SSH, etc
iptables -I INPUT -i eth0 -s 192.168.2.2 -d 192.168.2.1 -j ACCEPT

#Create 192.168.2.0/24 subnet
ifconfig eth0 192.168.2.1 netmask 255.255.255.0

#Delete default route for eth0
ip route del 0/0 dev eth0</pre>
    <p>Syntax explanation:</p>
    <ul class="spaced-list">
        <li><b>iptables</b>: A tool to modify the Linux kernel firewall.</li>
        <li><b>-t</b>: The table to modify, for example: <code>-t nat</code>. When no table is specified, the <code>filter</code> table is used, which contains the standard <code>INPUT</code>, <code>OUTPUT</code>, and <code>FORWARD</code> chains.</li>
        <li><b>-A</b>: Append the rule to the specified chain, for example <code>-A POSTROUTING</code>. The <code>POSTROUTING</code> chain is part of the <code>nat</code> table, and is used to alter NATted packets as they are about to go out (<i>post</i>-routing).</li>
        <li><b>-I</b>: Insert a rule at the top of the specified chain (meaning it will be applied first), for example <code>-A FORWARD</code>. The <code>FORWARD</code> chain is used to alter packets that are being forwarded, the <code>INPUT</code> chain is used for incoming packets, and the <code>OUTPUT</code> chain is used for outgoing packets.</li>
        <li><b>-o</b>: Match the name of the outgoing network interface (where the packet is going). <code>wlan0</code> is Wi-Fi, and <code>eth0</code> is ethernet, however you may have different interface names. You can see your interfaces using the <code>ifconfig</code> command.</li>
        <li><b>-i</b>: Match the name of the incoming network interface (where the packet arrived (where the packet arrived from).</li>
        <li><b>-s</b>: Match the source address of the packets.</li>
        <li><b>-d</b>: Match the destination address of the packets.</li>
        <li><b>-m</b>: Match using an extension module. For example <code>-m state --state RELATED,ESTABLISHED</code>, which will not match unsolicited connections.</li>
        <li><b>-j</b>: The action to take, for example: <code>ACCEPT</code>, <code>DROP</code>, <code>REJECT</code> and <code>MASQUERADE</code>. Packet masquerading is another term for many-to-one NAT, which is what most IPv4 home/office networks use.</li>
    </ul>
    <p>For further details, please see the <a href="https://linux.die.net/man/8/iptables" target="_blank" rel="noopener">iptables manual page</a>.</p>
    <p>Mark the script as executable:</p>
    <pre>$ chmod +x forward.sh</pre>
    <p>...and run the script once to apply it (or you can reboot):</p>
    <pre>$ sudo ./forward.sh</pre>
    <h3>c. Configure the Script to Run at Boot</h3>
    <p>Add this file to root's crontab (task scheduler config):</p>
    <pre>$ sudo crontab -e</pre>
    <p>Add the following line, setting the correct path and name for your file:</p>
    <pre>@reboot sleep 3 && /path/to/forward.sh</pre>
    <p>This will run the script at boot, ensuring that your rules and configurations are always applied.</p>

    <h2 id="connecting-to-the-internet">Connecting to the Internet</h2>
    <p>In order to actually connect to the internet using this setup, you must go through a short process. This is what you'll have to do once you're in your hotel room and you want to access the internet:</p>
    <h3>a. Secure VPN Client Configuration</h3>
    <p>Before you start, there are a couple of configurations you can make to your VPN client/server in order to harden it. The client configurations are possible in most VPN client software, such as network-manager-openvpn or Tunnelblick. It is recommended to make sure that:</p>
    <ul class="spaced-list">
        <li>All traffic is set to go through your VPN - for example by configuring the OpenVPN <code>redirect-gateway</code> option.</li>
        <li>DNS is going through the VPN, and check for DNS leaks.</li>
        <li>Your connection is not leaking via IPv6.</li>
        <li>There are no static routes that do not use the VPN.</li>
        <li>An unexpected disconnect should cut the connection, rather than simply falling back to non-VPN.</li>
    </ul>
    <p>This is not an all-inclusive list - make sure to do your own VPN security checks before continuing.</p>
    <h3>b. Hardware Connections</h3>
    <p>Connect your laptop to your Raspberry Pi using an ethernet cable and power on both devices.</p>
    <h3>c. Manually Connect to Your Raspberry Pi Router</h3>
    <p>Since no DHCP server is set up on the Pi, you'll have to connect manually.</p>
    <p>This process varies depending on which operating system you are using, however on all common operating systems is it pretty easy to manually set your IP address, subnet mask, gateway, etc.</p>
    <p>You should use the following values:</p>
    <pre>IP Address:  192.168.2.2
Subnet Mask: 255.255.255.0
Router:      192.168.2.1</pre>
    <p>You should not set a DNS server - your VPN client will handle this. Setting a DNS server entry just poses unnecessary risk should your locked-down connection somehow fail.</p>
    <p>It is probably best to add a new network connection for this, rather than editing any existing ones.</p>
    <h3>d. Establish the SSH Tunnel</h3>
    <p>Once you are connected, you should be able to establish an SSH tunnel with your Pi. Remember that now you're using the ethernet interface, you will connect with the Pi's IP address on that interface:</p>
    <pre>$ ssh -e none -x -L 5902:127.0.0.1:5903 pi@192.168.2.1</pre>
    <p>If everything has worked, you will login to SSH successfully.</p>
    <p id="update-allowusers-config">If this is your first time connecting to the Pi whilst it is connected via ethernet directly to your laptop, you should edit the <code>/etc/ssh/sshd_config</code> file and remove the <code>AllowUsers</code> entry for your previous network private IP address. You should never need to connect to your Pi that way again. Ensure that the value reads: <code>AllowUsers pi@192.168.2.2</code>.</p>
    <h3>e. Connect to VNC</h3>
    <p>Start the VNC desktop by running the following on your Pi:</p>
    <pre>$ vncserver :3 -geometry 1920x1080 -localhost</pre>
    <p>Then, using a VNC client on your laptop, connect to <code>localhost:5902</code>. The VNC desktop should appear. This time, the session will be much more responsive and have lower latency as you have a direct connection through the ethernet cable, rather than through your home/office network/router.</p>
    <h3>f. Connect to the Public Wi-Fi Hotspot and Deal With the Captive Portal</h3>
    <p>Using the remote desktop session, you can connect to the public Wi-Fi hotspot.</p>
    <p>Open Chromium, and navigate to a website that does not use TLS, such as <sub><sup><sup>[HTTP]</sup></sup></sub><a href="http://neverssl.com" target="_blank" rel="noopener">neverssl.com</a>. The captive portal should then be shown. Ensure that you are on the legitimate captive portal (this can be hard to determine, but check the URL for known Wi-Fi services such as The Cloud or Virgin Wi-Fi - this is a prime opportunity for phishing attacks so be careful).</p>
    <p>Enable JavaScript and cookies if required, and authenticate with the captive portal. Once done, you should now have a working (but insecure) internet connection on your Raspberry Pi.</p>
    <h3>g. Connect to Your External VPN From Your Laptop</h3>
    <p>Connect to your external VPN using whichever VPN client you desire. For example network-manager-openvpn for Linux systems using GNOME, Tunnelblick for Mac, etc.</p>
    <p><b>You should now have a working internet connection through your VPN on your secure laptop.</b> If your VPN drops, all other internet communications should be blocked. Make sure to test this in a safe environment (eg: on your own home/office Wi-Fi) in order to ensure that it is working as expected.</p>
    <h3>h. Shut Down the Pi Once You're Done</h3>
    <p>Once you are done with accessing the internet and want to shut down, just SSH tunnel into your Raspberry Pi again and shut it down with <code>sudo halt</code>. Give it around a minute to fully shut down, then disconnect it from the power.</p>

    <h2 id="additional-information">Additional Information</h2>
    <p>It is extremely important that you keep your Raspberry Pi fully up to date. The device is sitting on an insecure network, so it is important that it's always fully patched. Use <code>sudo apt-get update</code> followed by <code>sudo apt-get dist-upgrade</code> in order to fully update your device. You should do this at least once per day.</p>
    <p>Also double check that you updated the <code>AllowUsers</code> value in your SSH server configuration, as specified <a href="#update-allowusers-config">here</a>.</p>
    <p>Ensure that you did not open any ports or set any firewall rules for the VNC server. These are not required as it is tunneled through the SSH connection. Check your UFW config with <code>sudo ufw status verbose</code>, and remove rules if necessary. See <code>ufw help</code> for more information.</p>

    <h2 id="potential-problems">Potential Problems With This Design</h2>
    <p>There are a couple of potential problems with this design that I considered.</p>
    <p><b>The iptables whitelisting rules are set on the device facing the insecure network:</b></p>
    <div class="indent">
        <p>Since this device is facing an insecure network and is used to visit the captive portal (which should be assumed to be malicious), it may be wise to consider this device permanently compromised - so the iptables rules cannot be trusted.</p>
        <p>This is really just a theoretical problem and in the real world is unlikely to be exploited, however it is interesting to consider.</p>
        <p>A solution to this would be to use an additional Raspberry Pi that sits in between the two devices. This second Pi would enforce the iptables rules and connect out to the VPN, meaning that the whitelisting rules are enforced by a device that isn't facing an insecure network and visiting untrusted web pages. This was my original plan for this project, however in an attempt to avoid over-complicating the setup, I tried to do it with just one Pi. I may look in to the two-Pi setup in the future.</p>
    </div>
    <p><b>The durability of the iptables rules:</b></p>
    <div class="indent">
        <p>If the iptables rules on the Pi are somehow overwritten or superseded, you may lose some of your protection. While this shouldn't happen, as general operating system activities such as connecting to a network should not modify or add any iptables rules, it is definitely worth considering.</p>
        <p>This risk can perhaps be reduced by reapplying the rules again shortly after boot, or by repeatedly reapplying them (by checking the line numbers in the iptables chain and reapplying if required). Using a robust and leak-free VPN client configuration also greatly reduces this risk.</p>
    </div>

    <h2 id="conclusion">Conclusion</h2>
    <p>Overall I am extremely happy with this setup. I recently used it in a hotel for 5 days and it worked fantastically - the network speed through the Raspberry Pi was good and the connection was consistent. Upon returning home, I didn't factory reset my laptop before connecting it to my home network again like I would normally do, as the laptop had never actually touched the untrusted network or captive portal.</p>
    <p>This device may not be convenient for short sessions. It does take around 5 minutes to get connected at the start, so this may not be ideal if you are just having a coffee or something. However, if you are in a hotel room and using your laptop for 6 hours each evening, the initial connection process is not a problem.</p>
    <p>I plan to continue using this device when I stay in hotels in the future, and I will update this guide if I find any further security improvements or optimizations!</p>
</div>

<?php include "footer.php" ?>

</body>

</html>
