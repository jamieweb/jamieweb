<?php include "response-headers.php"; content_security_policy();
include_once "bloglist.php"; bloglist("postTop", null, null, 2020); ?>

<div class="body">
    <h1><?php echo $postInfo->title . "</h1>\n" . (isset($postInfo->subtitle) ? "    <h2 class=\"subtitle-mar-top\">" . $postInfo->subtitle . "</h2>\n" : ""); ?>
    <hr>
    <p><b><?php echo $postInfo->date; ?></b></p>
    <p>This is part 1 of a multi-part series on BGP routing and security:</p>
    <ul class="spaced-list">
        <li><b>Prelude:</b> <a href="/blog/bgp-routing-security-prelude-connecting-to-the-dn42-overlay-network/">Connecting to the DN42 Overlay Network</a></li>
        <li><b>Part 1:</b> BGP Peering with Quagga (You Are Here)</li>
        <li><b>Part 2:</b> <a href="/blog/bgp-routing-and-security-part-2-preventing-transit/">Preventing Transit</a></li>
        <li><b>Part 3:</b> Coming Soon</li>
    </ul>
    <p>This article serves as a practical introduction to BGP peering using the Quagga network routing software suite. This will set the groundwork for the security-related elements that will be covered later in the series.</p>
    <p><b>Skip to Section:</b></p>
    <pre class="contents"><b><?php echo $postInfo->title . (isset($postInfo->subtitle) ? "\n" . $postInfo->subtitle : ""); ?></b>
&#x2523&#x2501&#x2501 <a href="#what-is-quagga">What is Quagga?</a>
&#x2523&#x2501&#x2501 <a href="#why-quagga">Why Quagga?</a>
&#x2523&#x2501&#x2501 <a href="#key-terminology">Key Terminology</a>
&#x2523&#x2501&#x2501 <a href="#installing-quagga">Installing Quagga</a>
&#x2523&#x2501&#x2501 <a href="#configuring-vty-access">Configuring VTY Access</a>
&#x2523&#x2501&#x2501 <a href="#binding-the-source-address-to-the-loopback-interface">Binding the Source Address to the Loopback Interface</a>
&#x2523&#x2501&#x2501 <a href="#setting-the-default-source-address-for-routes">Setting the Default Source Address for Routes</a>
&#x2523&#x2501&#x2501 <a href="#configuring-bgp-ipv4">Configuring BGP (IPv4)</a>
&#x2523&#x2501&#x2501 <a href="#configuring-bgp-ipv6">Configuring BGP (IPv6)</a>
&#x2523&#x2501&#x2501 <a href="#viewing-bgp-peering-session-info-and-routes">Viewing BGP Peering Session Info and Routes</a>
&#x2517&#x2501&#x2501 <a href="#part-2-conclusion">Part 2 / Conclusion</a></pre>

    <h2 id="what-is-quagga">What is Quagga?</h2>
    <!--INTRO START-->
    <p><a class="exempt" href="https://www.quagga.net/" target="_blank" rel="noopener">Quagga</a> is a network routing software suite providing implementations of various routing protocols, including <a class="exempt" href="https://en.wikipedia.org/wiki/Routing_Information_Protocol" target="_blank" rel="noopener">RIP</a>, <a class="exempt" href="https://en.wikipedia.org/wiki/Open_Shortest_Path_First" target="_blank" rel="noopener">OSPF</a> and <a class="exempt" href="https://en.wikipedia.org/wiki/Border_Gateway_Protocol" target="_blank" rel="noopener">BGP</a>. It is a fork of the discontinued <a class="exempt" href="https://en.wikipedia.org/wiki/GNU_Zebra" target="_blank" rel="noopener">GNU Zebra</a> project, and utilises a configuration syntax very similar to that of <a class="exempt" href="https://en.wikipedia.org/wiki/Cisco_IOS#Command-line_interface" target="_blank" rel="noopener">Cisco IOS</a>.</p>
    <img class="radius-8 max-width-100-percent" src="/blog/bgp-routing-security-part-1-bgp-peering-with-quagga/quagga.jpg">
    <p class="two-no-mar centertext"><i>An 1804 illustration by Samuel Daniell of a South African quagga, an extinct subspecies of plains zebra after which the Quagga network routing software suite was named. <a class="exempt" href="https://en.wikipedia.org/wiki/File:Daniell_Quagga.jpg" target="_blank" rel="noopener">Source</a> (Public Domain)</i></p>
    <p>Unlike traditional routing daemons which interact directly with the kernel, Quagga operates a central kernel routing manager (known as zebra) which exposes an API to the various Quagga routing daemons. This allows the routing daemons to be enabled, disabled and configured on a 'pick and mix' basis, including the ability to run multiple of the same routing daemon on one machine.</p>
    <p>This article and series will be primarily focusing on Quagga BGPd, which is Quagga's BGP routing implementation.</p>
    <!--INTRO END-->

    <h2 id="why-quagga">Why Quagga?</h2>
    <p>Quagga BGPd is a very 'traditional' BGP routing daemon, which lacks many of the more advanced automation/software-defined networking features of the alternatives such as <a href="https://bird.network.cz" target="_blank" rel="noopener">Bird</a>, <a href="https://github.com/Exa-Networks/exabgp" target="_blank" rel="noopener">ExaBGP</a>, or <a href="https://osrg.github.io/gobgp/" target="_blank" rel="noopener">GoBGP</a>.</p>
    <p>However, Quagga provides a simple, clean and portable environment to learn about BGP, and many people will already be familiar with the configuration syntax due to it's similarities with Cisco IOS.</p>
    <p>In addition, for those running in an Ubuntu environment, the Quagga package is present in the Canonical 'main' repository, so it is kept up to date by the Ubuntu Core Developers. Other BGP daemons are unfortunately in the 'universe' repository, meaning that they only receive community support.</p>

    <h2 id="key-terminology">Key Terminology</h2>
    <p>Before proceeding with the hands-on usage of Quagga, I've documented some of the key terminology that will come in useful later.</p>
    <h3 id="autonomous-system">Autonomous System (AS)</h3>
    <p>An autonomous system is a collection of IP address range assignments (prefixes) that are owned by a particular administrative entity, such as a business or individual.</p>
    <p>Each registered AS has an assigned autonomous system number (ASN), which uniquely identifies the network on the internet. For example, <code>AS64497</code> or <code>AS4242420171</code>.</p>
    <p>ASNs are assigned by <a href="https://en.wikipedia.org/wiki/Regional_Internet_registry" target="_blank" rel="noopener">Regional Internet Registries</a> (RIRs) such as <a href="https://www.ripe.net/" target="_blank" rel="noopener">RIPE</a> or <a href="https://www.arin.net/" target="_blank" rel="noopener">ARIN</a>. You can identify the AS that you're a part of using the <a href="https://bgp.he.net/" target="_blank" rel="noopener">Hurricane Electric BGP toolkit</a>.</p>
    <h3 id="as-path">AS Path</h3>
    <p>The AS path (known as <code>AS_PATH</code>) is the set of unique networks that must be traversed in order to reach a particular destination.</p>
    <p>The length of the AS path, meaning the number of 'hops' between one network and another, is one of the key metrics used when deciding the preferred route to a particular network.</p>
    <h3 id="prefix">Prefix</h3>
    <p>A prefix is an IP address range, referring to the network as a whole rather than any specific host.</p>
    <p>For example, <code>203.0.113.0/24</code>, <code>192.0.2.0/27</code> and <code>172.20.0.0/16</code> are all network prefixes.</p>
    <p>The 'size' of a specific prefix is referred to as the 'prefix length', which is essentially another way of saying subnet mask. A 'long' prefix refers to a more specific network, for example, <code>172.16.1.0/24</code> is a longer and more specific prefix than <code>172.16.0.0/12</code>.</p>
    <p>Within BGP, the 'longest' or 'most specific' prefix will always take precedence in routing decisions, no matter the length of the path.</p>
    <p>The longest prefix allowed within internet BGP routing tables is generally <code>/24</code> for IPv4 and <code>/48</code> for IPv6. This is why it's not possible to announce a <code>/25</code> IPv4 address range on the internet.</p>
    <h3 id="route">Route</h3>
    <p>A route describes the path or 'next hop' to access a particular network. For example, the following route says that the <code>203.0.113.0/24</code> network can be accessed via the router at address <code>192.0.2.1</code> using network interface <code>eth0</code>:</p>
    <pre>203.0.113.0/24 via 192.0.2.1 dev eth0</pre>
    <p>A particular system or router will usually have a 'routing table', which is essentially a list of known routes. BGP and other routing protocols are used to update and maintain these routing tables.</p>
    <p>The 'default route' refers to the route that is used if there isn't an explicit route in place for the destination network. In other words, this is where traffic is sent if the system doesn't know how to reach the destination directly.</p>
    <h3 id="neighbour">Neighbour / Peer</h3>
    <p>BGP neighbours, more commonly known as 'peers', are other routers that you connect to in order to exchange routing information. This is usually configured manually within your BGP daemon, and takes place over TCP port 179 by default.</p>
    <p>Making your own prefixes available (routable) to the internet is achieved by 'announcing' or 'advertising' them to your peers, which is one of the primary roles of BGP.</p>
    <p>In many setups, you will peer with your upstream network provider(s) in order to announce your own routes and receive theirs (usually to gain access to the wider internet). This is known as External BGP (EBGP).</p>
    <p>If you operate a more complex network and are exchanging routing information internally (within the same AS), this is known as Internal BGP (IBGP).</p> 
    <p>The act of maintaining an active connection to a neighbour is known as 'peering', and each occurrence of this is known as a 'session'.</p>
    <p>By default, your router must be on the same subnet as your peer(s) and be able to resolve each of them using ARP. This usually means having a physical link, however a VPN connection or tunnel will also suffice. BGP packets have a TTL of 1 by default, so they will be dropped at the network boundary.</p>
    <p>It is possible to BGP peer without a direct connection by using manually-configured static routes and 'multi-hop' mode, however this won't be covered in this series as it is a lesser-used feature.</p>
    <h3 id="bogon-route">Bogon / Bogon Route</h3>
    <p>A bogon, also known as a bogon route, is a route that shouldn't be present on the global internet.</p>
    <p>For example, erroneous announcements of private IP addresses (such as <code>192.168.0.0/16</code>), or otherwise reserved address space.</p>
    <h3 id="default-free-zone">Default-free Zone</h3>
    <p>The default-free zone (DFZ) is the collection of autonomous systems that are able to route any packet without requiring a default route. In other words, they have visibility over the entire internet.</p>
    <p>The DFZ primarily consists of large network providers and internet exchange points (known as IXs or IXPs).</p>

    <h2 id="installing-quagga">Installing Quagga</h2>
    <p>This particular guide details the Quagga installation process on Ubuntu Server. The process is very similar for other Linux distributions or BSD-based systems, so it should still be possible to follow along.</p>
    <p>Begin by downloading and installing Quagga from the default Ubuntu Apt repositories:</p>
    <pre>$ sudo apt install quagga-bgpd</pre>
    <p>This will install the <code>quagga-bgpd</code> and <code>quagga-core</code> packages.</p>
    <p>Optionally, if you want to install all of the other routing daemons too, including <code>quagga-ripd</code> and <code>quagga-ospfd</code>, you can just install the <code>quagga</code> metapackage, which includes all of them.</p>
    <p>Next, create empty configuration files for Quagga to use:</p>
    <pre>$ cd /etc/quagga
$ sudo touch bgpd.conf zebra.conf</pre>
    <p>Finally, start the BGPd service:</p>
    <pre>$ sudo service bgpd start</pre>
    <p>This will automatically start the zebra service too, as BGPd is dependent on it. Note that if you ever want to fully stop Quagga, you'll need to stop the zebra service too.</p>

    <h2 id="configuring-vty-access">Configuring VTY Access</h2>
    <p>Once Quagga BGPd has been installed, add yourself to the <code>quaggavty</code> group, which will allow you to access the Quagga command-line interface (known as VTY or Virtual Teletype):</p>
    <pre>$ sudo adduser <span class="color-red">user</span> quaggavty</pre>
    <p>Quagga's command-line interface uses a pager in order to provide a scrollable/paginated interface when an output is too large to fit on the screen (for example when printing a full routing table). By default, the <code>more</code> program is used, however the modern alternative, <code>less</code>, generally provides a better user experience.</p>
    <p>If you wish to use <code>less</code> instead of <code>more</code>, which I would recommend, you can add the following environment variable to your <code>~/.profile</code> or <code>~/.bash_profile</code> configuration file:</p>
    <pre>export VTYSH_PAGER="less -FX"</pre>
    <p>The <code>-F</code> argument is used to prevent <code>less</code> from activating if the output is smaller than one screen in size, and <code>-X</code> is used to prevent the screen being unnecessarily cleared.</p>
    <p>Finally, run the <code>vtysh</code> command in order to connect. You should see the welcome text followed by a terminal prompt:</p>
    <pre>$ vtysh

Hello, this is Quagga (version 1.2.4).
Copyright 1996-2005 Kunihiro Ishiguro, et al.

quagga#</pre>
    <p>Feel free to have a look around the interface. Most of the commands are either identical or very similar to Cisco IOS.</p>
    <p>Commands can also be abbreviated, as long as enough of the command is provided in order to provide an unambiguous match. For example, <code>conf t</code> can be used in place of <code>configure terminal</code>.</p>
    <p>You can use <code>quit</code> to exit once done.</p>

    <h2 id="binding-the-source-address-to-the-loopback-interface">Binding the Source Address to the Loopback Interface</h2>
    <p>In order to properly BGP peer, you need to assign an IP address to your router from one of the prefixes that you're wanting to announce. This is to allow your router to be addressable on the internet, and to allow the correct source address to be set for BGP communications.</p>
    <p>For example, if your prefix is <code>203.0.113.0/24</code>, you may choose to assign the <code>203.0.113.1</code> address to your router.</p>
    <p>Note that this address is not the one that your BGP peers will use to communicate with you. Instead, an address within the private subnet that you have with your peer(s) will be used, e.g. via a physical link or network tunnel.</p>
    <p>If you want to announce multiple prefixes, your router only needs to be assigned an IP address from one of them. If you are operating a dual-stack configuration with both IPv4 and IPv6 prefixes, you should assign one address from each.</p>
    <p>In order to test your configuration, you can manually bind the address to your loopback interface:</p>
    <pre>$ sudo ip addr add <span class="color-red">203.0.113.1</span> dev lo</pre>
    <p>You can then manually check the route to ensure that it's a local one:</p>
    <pre>$ ip route get <span class="color-red">203.0.113.1</span></pre>
    <p>This should return something similar to the following:</p>
    <pre>local 203.0.113.1 dev lo src 203.0.113.1 uid 1000</pre>
    <p>The first field is the 'route type', which should be 'local'.</p>
    <p>As this address was manually added, the configuration will not persist after the networking services are restarted or the system is rebooted. In order to make the change persistent, you'll need to add a Netplan configuration (as of Ubuntu 17.10, Netplan has replaced the traditional <code>/etc/network/interfaces</code> configuration methodology, and is now the default).</p>
    <p>Begin by creating a new Netplan configuration file:</p>
    <pre>$ sudo nano /etc/netplan/99-quagga-lo.yaml</pre>
    <p>The add the following configuration, adjusting the values where needed:</p>
    <pre>network:
  version: 2
  renderer: networkd
  ethernets:
    lo:
      addresses:
        - <span class="color-red">203.0.113.1/24</span></pre>
    <p>Make sure to specify the correct prefix length. Once done, save and close the file, then test and apply the configuration:</p>
    <pre>$ sudo netplan try</pre>
    <p>You can now reboot your system and the address will be automatically added to the loopback interface. You may wish to test this using the <code>ip route get</code> command from earlier in this step.</p>

    <h2 id="setting-the-default-source-address-for-routes">Setting the Default Source Address for Routes</h2>
    <p>Next, you need to manually set the source address that Quagga BGPd will use for all of the routes that it will add to your system routing table. This is to ensure that outbound traffic is correctly sent from your router using the address assigned to it from your prefix.</p>
    <p>This is achieved using a 'route map', which is a form of conditional statement used to make routing decisions. For example, permitting or denying a particular route based on certain criteria, or applying additional configuration values.
    <p>Route maps are comparable to <code>if/else</code> statements, and generally consist of an 'action' (permit or deny a route), as well as 'match' and 'set' clauses. A 'match' clause is used to create a conditional statement which routes are evaluated against (to determine whether they match or not), and a 'set' clause is used to apply specific settings to any routes which match the route map entry.</p>
    <p>Begin by opening a VTY session using <code>vtysh</code>, and then enter 'configuration' mode using the <code>configure terminal</code> command, which can be abbreviated as <code>conf t</code>:</p>
    <pre>quagga# conf t</pre>
    <p>Your VTY prompt will now display <code>(config)</code> in order to indicate that you're in configuration mode.</p>
    <p>Then, create a new route map named <code>RM_SET_SRC</code>:</p>
    <pre>quagga(config)# route-map RM_SET_SRC permit 10</pre>
    <p>The <code>permit</code> attribute is the 'action' which is applied to routes which match this route map.</p>
    <p>The <code>10</code> is the sequence number, which represents the order that route map entries are evaluated, starting from the lowest sequence number. Route maps are evaluated in order until a successful match is found, at which point, by default, the evaluation stops. However, route maps can also be configured to continue evaluation after a successful match.</p>
    <p>Currently you only have one route map, so the default sequence number of <code>10</code> can be safely used.</p>
    <p>You should now be in route map configuration mode, as shown by the <code>(config-route-map)</code> text present in your VTY prompt.</p>
    <p>As this route map needs to apply to all routes, you do not need to specify any 'match' clauses, which has the effect of making every single route match.</p>
    <p>Proceed by adding a 'set' clause to set the source address for all routes:</p>
    <pre>quagga(config-route-map)# set src <span class="color-red">203.0.113.1</span></pre>
    <p>Then configure the route map to apply to all BGP routes:</p>
    <pre>quagga(config-route-map)# ip protocol bgp route-map RM_SET_SRC</pre>
    <p>Once you press return on this, Quagga should exit route map configuration mode and return back to the general configuration mode.</p>
    <p>Before proceeding to the next step, you may wish to save your configuration so far by writing it to disk:</p>
    <pre>quagga(config)# exit
quagga# write
Building Configuration...
Configuration saved to /etc/quagga/zebra.conf
Configuration saved to /etc/quagga/bgpd.conf
[OK]</pre>
    <p>From here, you can optionally print out your route map configuration in order to make sure that it's all correct:</p>
    <pre>quagga# show route-map RM_SET_SRC
ZEBRA:
route-map RM_SET_SRC, permit, sequence 10
  Match clauses:
  Set clauses:
    src <span class="color-red">203.0.113.1</span>
  Call clause:
  Action:
    Exit routemap
BGP:
route-map RM_SET_SRC, permit, sequence 10
  Match clauses:
  Set clauses:
  Call clause:
  Action:
    Exit routemap</pre>

    <h2 id="configuring-bgp-ipv4">Configuring BGP (IPv4)</h2>
    <p>Now that all of the prerequisite configuration has been completed, it's time to actually configure your BGP neighbours and begin peering.</p>
    <p>Start by ensuring that you're in configuration mode, which can be done using <code>conf t</code> if needed.</p>
    <p>Next, spawn a BGP protocol process for your AS number:</p>
    <pre>quagga(config)# router bgp <span class="color-red">64497</span></pre>
    <p>You're now in BGP configuration mode, so you can enter any relevant BGP commands in order to configure your neighbours and announcements.</p>
    <p>Add a neighbour by specifying their locally routable IP address and the AS that they're a part of. Note that the American English spelling of 'neighbour' is used within Quagga BGPd configuration (neighbor):</p>
    <pre>quagga(config-router)# neighbor <span class="color-red">10.0.0.1</span> remote-as <span class="color-red">4242420171</span></pre>
    <p>You must also configure the network interface that the neighbour can be reached on:</p>
    <pre>quagga(config-router)# neighbor <span class="color-red">10.0.0.1</span> interface <span class="color-red">eth1</span></pre>
    <p>This example covers a single-homed BGP setup, where you only have one neighbour/peer. However, if you're wanting to operate a multi-homed setup (with multiple peers), you can continue to add neighbours as required.</p>
    <p>Next, you can specify the prefix(es) that you want to announce to your peers:</p>
    <pre>quagga(config-router)# network <span class="color-red">203.0.113.0/24</span></pre>
    <p>Finally, set the router ID, which is used to uniquely identify your router among your peers.</p>
    <p>By default, Quagga BGPd will select the 'largest' or 'highest' IP address from the available network interfaces and use this as the router ID. This isn't usually the desired behaviour, so you can instead manually set your router ID to match the address assigned to it from your prefix(es).</p>
    <pre>quagga(config-router)# router-id <span class="color-red">203.0.113.1</span></pre>
    <p>This completes your initial IPv4 BGP configuration. You can exit configuration mode and write the configuration to disk:</p>
    <pre>quagga(config)# exit
quagga# write
Building Configuration...
Configuration saved to /etc/quagga/zebra.conf
Configuration saved to /etc/quagga/bgpd.conf
[OK]</pre>

    <h2 id="configuring-bgp-ipv6">Configuring BGP (IPv6)</h2>
    <p>If you're also wanting to peer over IPv6 and announce IPv6 prefixes, you can configure an IPv6 session.</p>
    <p>As with your IPv4 configuration, you'll need to add a route map to override the default source address. The configuration is mostly the same, but note the few minor differences:</p>
    <pre>quagga(config)# route-map RM_SET_SRC6 permit 10
quagga(config-route-map)# set src <span class="color-red">2001:db8::1</span>
quagga(config-route-map)# ipv6 protocol bgp route-map RM_SET_SRC6</pre>
    <p>Next, enter BGP configuration mode for your AS again and configure the required neighbours accordingly:</p>
    <pre>quagga(config)# router bgp <span class="color-red">64497</span>
quagga(config-router)# neigh <span class="color-red">fc00:abcd:1234::1</span> remote-as <span class="color-red">4242420171</span>
quagga(config-router)# neigh <span class="color-red">fc00:abcd:1234::1</span> interface <span class="color-red">eth1</span></pre>
    <p>By default, Quagga will configure each neighbour as an IPv4 neighbour. In order to switch a neighbour to IPv6, you'll need to disable it within the default IPv4 configuration, and then enable it under the IPv6 address family:</p>
    <pre>quagga(config-router)# no neigh <span class="color-red">fc00:abcd:1234::1</span> activate
quagga(config-router)# address-family ipv6
quagga(config-router-af)# neigh <span class="color-red">fc00:abcd:1234::1</span> activate</pre>
    <p>Once you've done this for each neighbour, the initial IPv6 BGP configuration has been completed. You can exit configuration mode and write your configuration to disk:</p>
    <pre>quagga(config-router-af)# exit
quagga(config-router)# exit
quagga(config)# exit
quagga# write</pre>

    <h2 id="viewing-bgp-peering-session-info-and-routes">Viewing BGP Peering Session Info and Routes</h2>
    <p>Once you've completed your initial BGP configuration, Quagga should automatically establish connections to your peers and begin exchanging routing information.</p>
    <p>The first thing to check is a summary of BGPd's connection status, which will show how many active sessions are open and how many routes have been received:</p>
    <pre>quagga# show ip bgp summary</pre>
    <p>The above command can be abbreviated to <code>sh ip b s</code>.</p>
    <p>Below is an example output from my own Quagga BGP router:</p>
    <pre>BGP router identifier 172.20.32.97, local AS number 4242420171
RIB entries 826, using 90 KiB of memory
Peers 1, using 9088 bytes of memory

Neighbor V AS MsgRcvd MsgSent TblVer InQ OutQ Up/
Down State/PfxRcd
192.168.163.29 4 4242423914 286 8 0 0 0 00:
03:00 427

Total number of neighbors 1

Total num. Established sessions 1
Total num. of routes received 427</pre>
    <p>Next, you can view a list of routes that you have received from your peer(s):</p>
    <pre>quagga# sh ip bgp</pre>
    <p>This will yield an output similar to the below example:</p>
<pre>BGP table version is 0, local router ID is 172.20.32.97
Status codes: s suppressed, d damped, h history, * valid, &gt; best, = multipath,
              i internal, r RIB-failure, S Stale, R Removed
Origin codes: i - IGP, e - EGP, ? - incomplete

   Network          Next Hop            Metric LocPrf Weight Path
*&gt; 10.23.0.0/16     192.168.163.37                         0 4242423914 4242420880 65043 65210 i
*&gt; 10.26.64.0/18    192.168.163.37                         0 4242423914 76190 4242420022 i
*&gt; 10.37.0.0/16     192.168.163.37                         0 4242423914 4242420880 65043 65037 i
*&gt; 10.50.0.0/16     192.168.163.37                         0 4242423914 4242422950 65024 i
*&gt; 10.56.0.0/16     192.168.163.37                         0 4242423914 4242420880 65043 65037 i
...</pre>
    <p>You can also do the same for IPv6:</p>
    <pre>quagga# sh ipv6 bgp</pre>
    <p>This will show all of the IPv6 routes that you have received, similar to the example from my own router:</p>
    <pre>BGP table version is 0, local router ID is 172.20.32.97
Status codes: s suppressed, d damped, h history, * valid, &gt; best, = multipath,
              i internal, r RIB-failure, S Stale, R Removed
Origin codes: i - IGP, e - EGP, ? - incomplete

   Network          Next Hop            Metric LocPrf Weight Path
   fd00:bad:f00d::/48
                    ::                                     0 4242423914 4242422341 4242420899 i
   fd00:191e:1470::/48
                    ::                       0             0 4242423914 4242422601 4242421470 i
   fd00:1926:817::/48
                    ::                                     0 4242423914 4242421331 i
   fd00:4242:3348::/48
                    ::                                     0 4242423914 4242422950 4242423348 i
...</pre>
    <p>Finally, you can also directly interrogate your system routing table in order to make sure that Quagga has installed the routes correctly. You can do this for individual IP addresses using <code>ip route get</code>, or print out the full routing table:</p>
    <pre>$ ip route</pre>
    <p>Use the <code>-6</code> argument to view the IPv6 routing table too:
    <pre>$ ip -6 route</pre>
    <p>This will result in something similar to the following example from my own router:</p>
    <pre>default via 172.16.0.1 dev eth0 proto static
10.23.0.0/16 via 192.168.163.37 dev tun-kioubit proto zebra src 172.20.32.97 metric 20
10.26.64.0/18 via 192.168.163.37 dev tun-kioubit proto zebra src 172.20.32.97 metric 20
10.37.0.0/16 via 192.168.163.37 dev tun-kioubit proto zebra src 172.20.32.97 metric 20
10.50.0.0/16 via 192.168.163.37 dev tun-kioubit proto zebra src 172.20.32.97 metric 20
...</pre>

    <h2 id="part-2-conclusion">Part 2 / Conclusion</h2>
    <p>You've now completed your initial Quagga BGPd configuration, and are successfully exchanging routing information with your peers.</p>
    <p>In the <a href="/blog/bgp-routing-and-security-part-2-preventing-transit/">next part</a>, we'll look at various ways of preventing transit, which is a preferable configuration if you're not an ISP and don't want your router to share arbitrary routes with peers.</p>
</div>

<?php include "footer.php" ?>
