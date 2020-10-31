<?php include "response-headers.php"; content_security_policy();
include_once "bloglist.php"; bloglist("postTop", null, null, 2020); ?>

<div class="body">
    <h1><?php echo $postInfo->title . "</h1>\n" . (isset($postInfo->subtitle) ? "    <h2 class=\"subtitle-mar-top\">" . $postInfo->subtitle . "</h2>\n" : ""); ?>
    <hr>
    <p><b><?php echo $postInfo->date; ?></b></p>
    <p>This is part 2 of a multi-part series on BGP routing and security:</p>
    <ul class="spaced-list">
        <li><b>Prelude:</b> <a href="/blog/bgp-routing-security-prelude-connecting-to-the-dn42-overlay-network/">Connecting to the DN42 Overlay Network</a></li>
        <li><b>Part 1:</b> <a href="/blog/bgp-routing-security-part-1-bgp-peering-with-quagga/">BGP Peering with Quagga</a></li>
        <li><b>Part 2:</b> Preventing Transit (You Are Here)</li>
        <li><b>Part 3:</b> Coming Soon</li>
    </ul>
    <p>This article details several methods that can be used to prevent your Autonomous System (AS) from becoming a so-called 'transit AS', which may be undesirable in certain BGP setups.</p>
    <p><b>Skip to Section:</b></p>
    <pre class="contents"><b><?php echo $postInfo->title . (isset($postInfo->subtitle) ? "\n" . $postInfo->subtitle : ""); ?></b>
&#x2523&#x2501&#x2501 <a href="#what-is-a-transit-as-and-why-is-it-sometimes-undesirable-to-become-one">What is a transit AS, and why is it sometimes undesirable to become one?</a>
&#x2523&#x2501&#x2501 <a href="#key-terminology">Key Terminology</a>
&#x2523&#x2501&#x2501 <a href="#no-export-community">No-Export Community</a>
&#x2523&#x2501&#x2501 <a href="#restricting-packet-forwarding">Restricting Packet Forwarding</a>
&#x2517&#x2501&#x2501 <a href="#part-3-conclusion">Part 3 / Conclusion</a></pre>

    <h2 id="what-is-a-transit-as-and-why-is-it-sometimes-undesirable-to-become-one">What is a transit AS, and why is it sometimes undesirable to become one?</h2>
    <!--INTRO START-->
    <p>A transit AS (Autonomous System) refers to an AS that is able to provide IP transit, i.e. it can receive packets from one peer and forward them on through another. In other words, a transit AS allows 'through' traffic, rather than just traffic explicitly destined for itself. It's a bit like the difference between a main road and a dead end on a road traffic network - a main road always leads somewhere else, while a dead end only leads to itself.</p>
    <p>The most common example of transit AS's is large ISPs and transit providers, which each have multiple connections with a diverse range of networks, allowing for resilient routing and connectivity. <b>However, any BGP setup that is multi-homed (i.e. has two or more unique peers) has the potential to become a transit AS, and this is by-design.</b></p>
    <p>For example, if you are peering with two different upstream ISPs, but they don't have a direct connection between each other (or the connection is disrupted), the traffic might end up being routed through <i>your</i> network, as ultimately your network provides a valid path between the two ISPs.</p>
    <p>If you are a network provider or ISP yourself, then this is most likely what you want to happen, as ultimately that's what your business is for. However, if you're simply wanting to announce the prefixes for your own network, it may be undesirable to become a transit AS, as your network resources and bandwidth may be used to handle traffic that is completely unrelated to your business operations. To use the road traffic network analogy again - it's like an emergency diversion routing traffic from a major road down a quiet back street and overloading it, much to the dismay of the residents!</p>
    <p>This article will detail how you can configure your Quagga BGP daemon to prevent becoming a transit AS.</p>
    <!--INTRO END-->

    <h2 id="key-terminology">Key Terminology</h2>
    <p>Before proceeding with the hands-on content of the article, I've documented some key terminology that may be useful and hasn't been covered so far in this series.</p>
    <h3 id="community">BGP Community</h3>
    <p>BGP communities are extra bits of information that can be included with route announcements, and are used to control additional settings that may impact routing decisions or propagation.</p>
    <p>Lots of BGP communities exist, many of which are provider-specific or for internal use, however there are 4 'well known' BGP communities that are officially defined by IANA:</p>
    <ul class="spaced-list">
        <li><code>Internet</code>: Advertise the prefix to all BGP peers, both internal BGP (iBGP) and external BGP (eBGP).</li>
        <li><code>No-Advertise</code>: Don't advertise the prefix to any BGP peers.</li>
        <li><code>No-Export</code>: Don't advertise the prefix to any external BGP (eBGP) peers.</li>
        <li><code>Local AS</code>: Don't advertise the prefix outside of the current AS within a <a href="https://en.wikipedia.org/wiki/Border_Gateway_Protocol#BGP_confederation" target=_blank" rel="noopener">BGP confederation</a>, which is a scalability mechanic used by very large networks to allow multiple AS's to be 'grouped' together and identified as just one AS from an external perspective.</li>
    </ul>
    <h3 id="packet-forwarding">Packet Forwarding</h3>
    <p>Packet forwarding refers to the process of accepting packets intended for a particular destination and 'forwarding' them on via another network node.</p>
    <p>Usually packet forwarding is performed by dedicated routers and other core networking devices, however the Linux Kernel also has considerable packet forwarding/routing capabilities, which is what we're working with here.</p>

    <h2 id="no-export-community">No-Export Community</h2>
    <p>The primary method for preventing yourself from becoming a transit AS is using the <code>No-Export</code> community, which is used to prevent prefixes from being advertised to any external BGP (eBGP) peers.</p>
    <p>You'll need to configure Quagga to apply the <code>No-Export</code> community to all routes that are received from external peers, but <i>not</i> to your own locally-originating routes (as this would prevent them from being shared upstream). This is done using a route map configuration.</p>
    <p>Begin by opening a VTY session using <code>vtysh</code>, and entering configuration mode using <code>conf t</code>.</p>
    <p>Next, create a new route map named <code>RM_NO_EXPORT</code> with a policy of <code>permit</code> and a sequence number of <code>10</code>:</p>
    <pre>quagga(config)# route-map RM_NO_EXPORT permit 10</pre>
    <p>You should now be in route map configuration mode. Now you can configure the route map to apply the <code>No-Export</code> community:</p>
    <pre>quagga(config-route-map)# set community no-export</pre>
    <p>You can now exit route map configuration mode and launch a BGP protocol process for your AS:</p>
    <pre>quagga(config)# router bgp <span class="color-red">64497</span></pre>
    <p>From here, you need to configure the <code>RM_NO_EXPORT</code> route map to be applied to all routes that are received from each of your peers:</p>
    <pre>quagga(config-router)# neighbor <span class="color-red">10.0.0.1</span> route-map RM_NO_EXPORT in</pre>
    <p>Note that the <code>in</code> option is used to match only inbound routes, in order to ensure that the route map doesn't apply to your own locally-originating routes and prevent them from being shared with peers.</p>
    <p>Next, you need to enable the sending of BGP community information for the peer:</p>
    <pre>quagga(config-router)# neighbor <span class="color-red">10.0.0.1</span> send-community</pre>
    <p>If you're using IPv6 too, you can repeat the same steps for the IPv6 address family:</p>
    <pre>quagga(config-router)# address-family ipv6
quagga(config-router-af)# neighbor <span class="color-red">fc00:abcd:1234::1</span> route-map RM_NO_EXPORT in
quagga(config-router-af)# neighbor <span class="color-red">fc00:abcd:1234::1</span> send-community</pre>
    <p><b>Make sure to repeat these steps for all of the relevant IPv4 and IPv6 peers.</b></p>
    <p>You can now use <code>exit</code> a few times to leave configuration mode, and then use <code>write</code> to save your configuration to disk.</p>
    <p>From here, you can also optionally print out your <code>RM_NO_EXPORT</code> route map configuration to make sure that everything is correct:</p>
    <pre># show route-map RM_NO_EXPORT
ZEBRA:
route-map RM_NO_EXPORT, permit, sequence 10
  Match clauses:
  Set clauses:
  Call clause:
  Action:
    Exit routemap
BGP:
route-map RM_NO_EXPORT, permit, sequence 10
  Match clauses:
  Set clauses:
    community no-export
  Call clause:
  Action:
    Exit routemap</pre>
    <p>You can also check that the <code>RM_NO_EXPORT</code> community has been properly applied to inbound routes (though you may need to restart BGPd for this to begin working). In the example below from my own BGPd, you can see that the route received from one of my external neighbours isn't shared outside of my local AS:</p>
    <pre># sh ip bgp 172.20.1.0/24
BGP routing table entry for 172.20.1.0/24
Paths: (1 available, best #1, table Default-IP-Routing-Table, <b>not advertised to EBGP peer</b>)
  <b>Not advertised to any peer</b>
  4242423914 4242420119
    192.168.163.37 from 192.168.163.37 (172.20.53.99)
      Origin IGP, localpref 100, valid, external, best
      <b>Community: no-export</b>
      Large Community: 4242420119:2000:2
      Last update: Sun Oct 18 20:53:02 2020</pre>
    <p>However, if you check a prefix that you're advertising yourself, you'll see that the <code>No-Export</code> community hasn't been applied. You can see this in the following additional example from my own BGPd, where I am advertising <code>172.20.32.96/28</code>:</p>
    <pre># sh ip bgp 172.20.32.96/28
BGP routing table entry for 172.20.32.96/28
Paths: (1 available, best #1, table Default-IP-Routing-Table)
  <b>Advertised to non peer-group peers:
  192.168.163.37</b>
  Local
    0.0.0.0 from 0.0.0.0 (172.20.32.97)
      Origin IGP, metric 0, localpref 100, weight 32768, valid, sourced, local, best
      Last update: Thu Sep 17 09:06:50 2020</pre>

    <h2 id="restricting-packet-forwarding">Restricting Packet Forwarding</h2>
    <p>While the <code>No-Export</code> community is reliable at preventing externally-received routes from being advertised to eBGP peers, it's best practise to combine this with at least one other additional 'layer', in order to act as a failsafe should an accidental error or misconfiguration occur.</p>
    <p>You should use your local packet filter/firewall, which in my case is <code>iptables</code>, to block all packet forwarding for the relevant network interfaces. For example, the following rule will block forwarding for packets received from <code>10.0.0.1</code>:</p>
    <pre>iptables -A FORWARD -s <span class="color-red">10.0.0.1</span> -j REJECT</pre>
    <p>You can also outright block forwarding for the relevant network interface that you're connected to your peer with:</p>
    <pre>iptables -A FORWARD -i <span class="color-red">eth1</span> -j REJECT</pre>
    <p>Make sure to set these rules accordingly for your own setup, and ensure that they are automatically set properly at boot, e.g. by putting them in <code>/etc/ufw/before.rules</code> and/or <code>/etc/ufw/before6.rules</code>.</p>
    <p>In addition to this, if you're only running Quagga on a single machine that isn't acting as a router for a wider network, you should consider explicitly disabling IPv4 and IPv6 packet forwarding for all network interfaces, which will fully prevent your device being used for general IP transit.</p>
    <p>You can do this by setting the following in <code>/etc/sysctl.conf</code>, or alternatively a custom configuration file in <code>/etc/sysctl.d/</code>, such as <code>/etc/sysctl.d/99-disable-packet-forwarding.conf</code>:</p>
    <pre>net.ipv4.ip_forward=0
net.ipv6.conf.all.forwarding=0</pre>
    <p>The IPv6 configuration is defined on a per-interface basis, so you should also add a line for each relevant interface, e.g.:</p>
    <pre>net.ipv6.conf.eth1.forwarding=0
net.ipv6.conf.eth2.forwarding=0</pre>
    <p>Once your system networking services have been restarted, IP packet forwarding will be disabled.</p>

    <h2 id="part-3-conclusion">Part 3 / Conclusion</h2>
    <p>You've now further configured your Quagga BGPd setup, and are operating as a non-transit AS to ensure that you don't propagate arbitrary routes to your peers.</p>
    <p>In the next part, we'll implement route filtering, which is used to control and restrict which routes will be accepted from your peers. Route filtering is a key feature when it comes to mitigating the risk of BGP leaks/hijacks.</p>
</div>

<?php include "footer.php" ?>
