<?php include "response-headers.php"; content_security_policy();
include_once "bloglist.php"; bloglist("postTop", null, null, 2020); ?>

<div class="body">
    <h1><?php echo $postInfo->title . "</h1>\n" . (isset($postInfo->title) ? "    <h2 class=\"subtitle-mar-top\">" . $postInfo->subtitle . "</h2>\n" : ""); ?>
    <hr>
    <p><b><?php echo $postInfo->date; ?></b></p>
    <p>This is a prelude to a multi-part series on BGP routing security:</p>
    <ul class="spaced-list">
        <li><b>Prelude:</b> Connecting to the DN42 Overlay Network (You Are Here)</li>
        <li><b>Part 1:</b> Coming Soon</li>
    </ul>
    <p>The purpose of this first article is to allow you to set up a suitable lab environment for practising BGP and the various routing security elements that are present in this guide.</p>
    <p>If you already have a lab environment set up, or are working on an existing BGP deployment, you can safely skip this prelude and go straight to Part 1.</p>
    <p><b>Skip to Section:</b></p>
    <pre class="contents"><b><?php echo $postInfo->title . (isset($postInfo->subtitle) ? "\n" . $postInfo->subtitle : ""); ?></b>
&#x2523&#x2501&#x2501 <a href="#what-is-dn42">What is DN42?</a>
&#x2523&#x2501&#x2501 <a href="#accessing-the-dn42-registry">Accessing the DN42 Registry</a>
&#x2523&#x2501&#x2501 <a href="#creating-registry-objects">Creating Registry Objects</a>
&#x2523&#x2501&#x2501 <a href="#merging-your-registry-objects-into-the-registry">Merging Your Registry Objects into the Registry</a>
&#x2523&#x2501&#x2501 <a href="#finding-a-peer">Finding a Peer</a>
&#x2523&#x2501&#x2501 <a href="#connecting-to-your-peer-using-openvpn">Connecting to Your Peer Using OpenVPN</a>
&#x2523&#x2501&#x2501 <a href="#dnsmasq-dns-setup-for-dn42-domains">Dnsmasq DNS Setup for '.dn42' Domains</a>
&#x2517&#x2501&#x2501 <a href="#part-1-conclusion">Part 1 / Conclusion</a></pre>

    <h2 id="what-is-dn42">What is DN42?</h2>
    <p><?php echo $postInfo->snippet; ?></p>
    <img class="radius-8" width="1000px" src="dn42-wiki.png">
    <p class="two-no-mar centertext"><i>The DN42 wiki homepage, available at <a href="https://wiki.dn42.us/" target="_blank" rel="noopener">wiki.dn42.us</a>.</i></p>
    <p>This article will guide you through the process of registering and connecting to DN42, which is the equivalent of physically 'plugging yourself in' to the network. This won't yet let you communicate with the DN42 network fully, but it'll provide the foundation to begin BGP peering and announcing your IP address ranges to other members of the network.</p>
    <p>While it is possible to connect to DN42 using a physical router, the most common setup is to use a standard Linux server. Any modern Linux distribution should be suitable, however in this article I am focusing on Debian-based systems such as Ubuntu Server. macOS and Windows systems are also supported if you really want them to be, however for optimal compatibility and ease of configuration, I would strongly recommend using a Linux distribution designed for use on servers.</p>

    <h2 id="accessing-the-dn42-registry">Accessing the DN42 Registry</h2>
    <p>The DN42 registry is a central database containing all of the users of the network, the <a href="https://en.wikipedia.org/wiki/Autonomous_system_(Internet)" target="_blank" rel="noopener">Autonomous Systems</a> (ASs) that they maintain and the IP address ranges assigned to them.</p>
    <p>This is equivalent to a <a href="https://en.wikipedia.org/wiki/Regional_Internet_registry" target="_blank" rel="noopener">Regional Internet Registry</a> (RIR), such as <a href="https://www.ripe.net/" target="_blank" rel="noopener">RIPE</a> (Europe), <a href="https://www.arin.net/" target="_blank" rel="noopener">ARIN</a> (North America) or <a href="https://www.apnic.net/" target="_blank" rel="noopener">APNIC</a> (Asia Pacific).</p>
    <p>DN42's registry is stored and operated as a Git repository, with a group of moderators responsible for reviewing and approving change requests.</p>
    <img class="radius-8" width="1000px" src="registry.png">
    <p class="two-no-mar centertext"><i>The DN42 registry, which can be accessed at <a href="https://git.dn42.us/dn42/registry" target="_blank" rel="noopener">git.dn42.us/dn42/registry</a>.</i></p>
    <p>In order to join DN42, you'll need to download a copy of the registry, add your information and configuration values to it (known as 'registry objects'), and then submit a change request back to the main registry.</p>
    <p>Begin by <a href="https://git.dn42.us/user/sign_up/" target="_blank" rel="noopener">signing up to the Git frontend for the registry</a>. Please note that <b>the email address that you use will be shared publicly</b>. If you're concerned about this, I recommend creating a new alias on your domain, such as <code>dn42@example.com</code> or <code>bgp@example.com</code>.</p>
    <p>Once you've signed up, navigate to the <a href="https://git.dn42.us/dn42/registry" target="_blank" rel="noopener">repository for the main DN42 registry</a> and create a fork of it by clicking the 'Fork' button. This will create a copy of the repository within your own registry account.</p>
    <img class="radius-8" width="1000px" src="registry-forked.png">
    <p class="two-no-mar centertext"><i>An example of a forked copy of the DN42 registry.</i></p>
    <p>Next, you'll need to add an SSH public key to your registry account in order to allow you to authenticate to it using Git over SSH from the command-line. I recommend creating a new SSH key pair for this, which can be done using the following command:</p>
    <pre>$ ssh-keygen -t rsa -b 4096</pre>
    <p>Once you've generated the SSH key pair, add the public key to your registry account via your account settings, in the same way that you would add an SSH key to your GitHub/GitLab account.</p>
    <img class="radius-8" width="1000px" src="registry-add-ssh-key.png">
    <p class="two-no-mar centertext"><i>Successfully adding an SSH key to my DN42 registry account.</i></p>
    <p>Each user of DN42 should sign each of their change requests using a GPG key or SSH key in order to help prevent other users from submitting malicious change requests to the registry on their behalf. The key that you use when initially creating your registry objects will need to be used to sign all future change requests in order to validate your identity, otherwise they will not be accepted by the DN42 registry moderators.</p>
    <p>In this article we will focus on the usage of GPG, as it is the most widely used option. If you don't already have a GPG key suitable for use, you can create one using the following command:</p>
    <pre>$ gpg2 --full-generate-key</pre>
    <p>Select option #1 (rsa and rsa), and choose a suitable expiration date for the key. It may take quite some time to source enough entropy to properly generate your private key, so continue using your computer normally until it completes.</p>
    <p>Once your key has been successfully generated, identify its full key ID by listing all of your keys:</p>
    <pre>$ gpg2 --list-keys</pre>
    <p>Find your new key in the list and take a note of the full key ID, as shown in red in the example below:</p>
    <pre>pub   rsa4096 2019-10-19 [SC] [expires: 2020-10-18]
      <span class="color-red">AB72FE12526F44B611B99F7C24B1FB13F1B3B06C</span>
uid           [ultimate] Bob &lt;bob@example.com&gt;
sub   rsa4096 2019-10-19 [E] [expires: 2020-10-18]</pre>
    <p>Next, you'll need to submit your key to the public key servers, in order to allow the DN42 community to download your full key, just based on the key ID:</p>
    <pre>$ gpg2 --keyserver hkp://keyserver.ubuntu.com --send-keys <span class="color-red">your-key-fingerprint-here</span></pre>
    <p>Your key will appear on the <a href="https://keyserver.ubuntu.com/" target="_blank" rel="noopener">Ubuntu Keyserver</a> straight away, but may take a couple of hours to sync to the other key servers.</p>
    <p>Before proceeding, take a secure backup of your GPG key, as losing access to it could potentially mean losing access to your DN42 resources too.</p>
    <p>Now that you've got your SSH and GPG keys, you can proceed with connecting to the registry over SSH in order to make sure that everything is working.</p>
    <p>In order to make sure that SSH uses the correct private key for the connection, you may wish to add the following to the bottom of your <code>~/.ssh/config</code> file:
    <pre>host git.dn42.us
  IdentityFile ~/.ssh/<span class="color-red">your-ssh-private-key</span></pre>
    <p>You can now proceed with connecting to the registry, using the <code>-T</code> option to prevent a terminal session from being created:</p>
    <pre>$ ssh -T git@git.dn42.us</pre>
    <p>Since this is your first time connecting, you'll be asked whether you want to accept the server host key fingerprint or not. Modern SSH clients should display the ECDSA SHA256 fingerprint, as shown below in red:</p>
    <pre>The authenticity of host 'git.dn42.us (2607:5300:60:3d95::1)' can't be established.
ECDSA key fingerprint is SHA256:<span class="color-red">NxZ5DJlVKTdS8Kv0Dcyew76iAKDAp5K7QmWUM7gLZS8</span>.
Are you sure you want to continue connecting (yes/no)?</pre>
    <p>Double check that the fingerprint matches, and then proceed with connecting.</p>
    <p>Once you have connected successfully, the help page for Gogs should be printed (Gogs is the Git frontend used for the DN42 registry):</p>
    <pre>NAME:
  Gogs - A painless self-hosted Git service
 
USAGE:
  gogs [global options] command [command options] [arguments...]
 
VERSION:
  0.11.86.0130</pre>
    <p>The SSH session should terminate straight after printing the above help text, but if not, press Ctrl+C or Ctrl+D to forcefully close it.</p>
    <p>Now that you've successfully tested your SSH connection to the registry Git frontend, you can proceed with cloning your fork of the registry repository:</p>
    <pre>$ git clone git@git.dn42.us:<span class="color-red">your-registry-username-here</span>/registry.git</pre>
    <p>This will create a complete local copy of the DN42 registry. You can freely browse the directory structure and view all of the files, as well as make your own local changes ready to be submitted back to main repository.</p>
    <p>You should also configure Git to use your GPG key and enable forced commit signing, which can be done by running the following commands from within the <code>registry</code> directory:</p>
    <pre>$ git config user.signingkey <span class="color-red">your-key-fingerprint-here</span>
$ git config commit.gpgsign true</pre>
    <p>Finally, you should update your Git name and email address to match the details used to sign up to the registry. These details will be present on each commit that you make, so ensure that you're happy for them to be shared publicly:</p>
    <pre>$ git config user.name "<span class="color-red">your-name</span>"
$ git config user.email "<span class="color-red">your-dn42-email-address</span>"</pre>
    <p>You have now signed up to the DN42 registry, created the required cryptographic keys, downloaded a forked copy of the registry and configured your local Git environment. Next, you can begin to create registry objects to define the Autonomous Systems, IP address ranges and domain names that you want to register.</p>

    <h2 id="creating-registry-objects">Creating Registry Objects</h2>
    <p>The structure of the DN42 registry very closely matches that of an <a href="https://en.wikipedia.org/wiki/Internet_Routing_Registry" target="_blank" rel="noopener">Internet Routing Registry</a> (IRR) on the real internet, such as RIPE. <a href="https://en.wikipedia.org/wiki/Routing_Policy_Specification_Language" target="_blank" rel="noopener">Routing Policy Specification Language</a> (RPSL) is used to define objects (data) within a registry, such as IP address assignments, Autonomous System (AS) numbers, maintainership permissions and personal contact details. Data submitted to a registry is shared publicly, which allows networks around the world to correctly route traffic and identify organisations responsible for different parts of the wider internet</p>
    <p>In order to register your own network on DN42, you'll need to create a series of objects within your downloaded copy of the registry, which are stored as standard plain text configuration files. You can do this using whichever method you find easiest, e.g. using a terminal session with <code>nano</code> or <code>vim</code>, or using a GUI file manager and text editor.</p>

    <h3 id="person-object">Person Object</h3>
    <p>Firstly, you'll need to create a 'person' object, which is essentially a file containing your own personal details. You should specify your name, public contact email address, as well as the PGP fingerprint of the key that you have configured for use with the registry. You can also optionally specify the address of your website.</p>
    <p>Your <a href="https://en.wikipedia.org/wiki/NIC_handle" target="_blank" rel="noopener">NIC handle</a> (Network Information Centre handle) is a unique alphanumeric string used to identify you within the registry database, usually suffixed by the name of the registry that you're a part of, in this case <code>-DN42</code>. You can use any name that you want for this, including your real name or an online pseudonym, for example <code>JOEBLOGGS-DN42</code> or <code>NETWORKUSER1234-DN42</code>. Check the contents of the <code>/data/person</code> directory to make sure that the string you want to use hasn't already been taken by someone else.</p>
    <p>Proceed by creating an empty text file within the <code>/data/person</code> directory of the registry. The name of your 'person' object should match your NIC handle. Below is a copy of my own 'person' object, which should help you to understand the required format and layout of registry object files.</p>
    <p class="two-mar-bottom"><b>/data/person/JAMIEWEB-DN42</b>:</p>
    <pre class="two-mar-top">person:             Jamie Scaife
contact:            bgp@jamieweb.net
www:                https://www.jamieweb.net/
pgp-fingerprint:    9F23651633635B68EC10122232920E2ACC4B075D
nic-hdl:            JAMIEWEB-DN42
mnt-by:             JAMIEWEB-MNT
source:             DN42</pre>
    <p>Note that the second column always starts at character 21 on each line, i.e. there are 20 characters padded by spaces before it on each line.</p>
    <p>The <code>source</code> parameter refers to the authoritative registry that the object is registered to (always DN42 in this case). The <code>mnt-by</code> parameter will be covered in the next section.</p>

    <h3 id="maintainer-object">Maintainer Object</h3>
    <p>Next, you'll need to create a 'maintainer' object, which is used to specify credentials that are permitted to create, modify or delete registry objects under your maintainership.</p>
    <p>Each registry object that you create will refer back to your maintainer object, helping to ensure that unauthorised changes cannot be made to your registry objects, as well as to make sure that every registry object has a properly assigned owner.</p>
    <p>Different methods exist for specifying authentication information, however in most cases within DN42's registry, a PGP key fingerprint is used. Some other registries, such as RIPE, implement their own single sign-on system for authentication and authorisation. Historically, some registries allowed you to specify the MD5 hash of a password within your maintainer object, which is a process that has luckily been mostly phased out by now.</p>
    <p>Below is a copy of my own maintainer object, which will help you to understand and populate the required fields. Make sure to update the PGP fingerprint to your own.</p>
    <p class="two-mar-bottom"><b>/data/mntner/JAMIEWEB-MNT</b>:</p>
    <pre class="two-mar-top">mntner:             JAMIEWEB-MNT
admin-c:            JAMIEWEB-DN42
tech-c:             JAMIEWEB-DN42
mnt-by:             JAMIEWEB-MNT
source:             DN42
auth:               pgp-fingerprint 9F23651633635B68EC10122232920E2ACC4B075D</pre>
    <p>You may recognise the <code>admin-c</code> and <code>tech-c</code> configuration parameters from domain name WHOIS records. These are used to specify the administrative and technical contacts for your maintainer object, which in the case of DN42, should usually refer back to your own 'person' object.</p>

    <h3 id="autonomous-system-number">Autonomous System (AS) Number</h3>
    <p>An Autonomous System refers to a collection of IP address range assignments that belong to a single administrative entity, such as a business or individual. Each AS has an AS number (ASN), which is used to uniquely identify it within internet routing policies.</p>
    <p>You can find the AS that you're a part of using the <a href="https://bgp.he.net/" target="_blank" rel="noopener">Hurricane Electric BGP toolkit</a>. You'll most likely see the AS of your ISP or upstream network provider, such as BT, Comcast, Telstra, etc.</p>
    <p>You can register your own ASN at a RIR, however the prerequisites and costs are often prohibitive for individuals or small businesses. For example, you may have to provide evidence of having contracts in place with upstream network providers, or have to be sponsored by an existing member of the RIR.</p>
    <p>Luckily within DN42, you can freely register an ASN for use within the network. Unfortunately it isn't usable outside of DN42, but the technical concepts for managing it are very similar.</p>
    <p>DN42 currently allocates ASNs from the range <code>AS4242420000</code> to <code>AS4242423999</code>. My own AS number on DN42 is <code>AS4242420171</code>.</p>
    <p>Begin by <a href="https://git.dn42.us/dn42/registry/src/master/data/aut-num/" target="_blank" rel="noopener">searching through the DN42 registry</a> to identify an unclaimed ASN. Most of the ASNs towards the start of the allowed range have already been taken, so you may wish to start looking half way down the list.</p>
    <p>Once you have identified an unclaimed ASN, proceed with creating an object in the registry for it, using my example below for guidance.</p>
    <p class="two-mar-bottom"><b>/data/aut-num/AS4242420171</b>:</p>
    <pre class="two-mar-top">aut-num:            AS4242420171
as-name:            JAMIEWEB-AS
descr:              JamieWeb AS
admin-c:            JAMIEWEB-DN42
tech-c:             JAMIEWEB-DN42
mnt-by:             JAMIEWEB-MNT
source:             DN42</pre>
    <p>The <code>as-name</code> and <code>descr</code> parameters can be used to add a human-readable name and description to your AS. Also notice how you are referring back to your person and maintainer objects with the <code>admin-c</code>, <code>tech-c</code> and <code>mnt-by</code> parameters.</p>

    <h3 id="ipv4-address-range-assignment">IPv4 Address Range Assignment</h3>
    <p>Now that you've claimed an ASN, you can proceed to allocate and assign an IPv4 address range for your use on DN42. Like on the real internet, IPv4 addresses on DN42 are in short supply, so you'll only be able to claim a small prefix as an individual. You'll be able to get a large IPv6 address range though, which is covered in the next step.</p>
    <p>DN42 uses the following private IPv4 address ranges:</p>
    <ul class="spaced-list">
        <li><code>172.20.0.0/14</code> - DN42 Main Network</li>
        <li><code>172.20.0.0/24</code> - Anycast Network</li>
        <li><code>172.21.0.0/24</code> - Anycast Network</li>
        <li><code>172.22.0.0/24</code> - Anycast Network</li>
        <li><code>172.23.0.0/24</code> - Anycast Network</li>
    </ul>
    <p>The anycast network is used to operate core DN42 network services such as the root DNS servers, where any DN42 member is able to anycast announce the relevant IP addresses and host their own root DNS server for use by the community.</p>
    <p>Like when assigning an ASN, you'll need to search through the registry in order to identify an unclaimed IPv4 address range. To make things a bit easier, you can use the <a href="https://dn42.us/peers/free/" target="_blank" rel="noopener">IPv4 open netblocks</a> page to see a list of unclaimed prefixes.</p>
    <img class="radius-8" width="1000px" src="ipv4-open-netblocks.png">
    <p class="two-no-mar centertext"><i>A list of open IPv4 netblocks on DN42, accessible at <a href="https://dn42.us/peers/free/" target="_blank" rel="noopener">dn42.us/peers/free</a>.</i></p>
    <p>Once you have found a suitable IPv4 address range, you can create the registry object for it, using the example of my own IPv4 range for reference.</p>
    <p class="two-mar-bottom"><b>/data/inetnum/172.20.32.96_28</b>:</p>
    <pre class="two-mar-top">inetnum:            172.20.32.96 - 172.20.32.111
cidr:               172.20.32.96/28
netname:            JAMIEWEB-V4-NET-1
country:            GB
admin-c:            JAMIEWEB-DN42
tech-c:             JAMIEWEB-DN42
mnt-by:             JAMIEWEB-MNT
status:             ASSIGNED
source:             DN42</pre>
    <p>You'll need to specify the exact IP address range within the <code>inetnum</code> configuration value, so make sure to double-check your subnet calculation where necessary.</p>
    <p>In order to actually announce your IPv4 address range, you must create a 'route' object, which is used to specify which AS is permitted to announce the prefix.</p>
    <p>In many cases this will be your own AS, however if you want someone else, such as a network operator, to announce the prefix on your behalf, you'll need to specify their ASN here. Delegating the permission to announce a particular prefix like this allows you to more safely utilise the services of third-party network operators, whilst still retaining full legal ownership of your prefixes.</p>
    <p>Proceed with creating the route object as required, using my own as an example.</p>
    <p class="two-mar-bottom"><b>/data/route/172.20.32.96_28</b>:</p>
    <pre class="two-mar-top">route:              172.20.32.96/28
origin:             AS4242420171
mnt-by:             JAMIEWEB-MNT
source:             DN42</pre>

    <h3 id="ipv6-address-range-assignment">IPv6 Address Range Assignment</h3>
    <p>You should also assign yourself an IPv6 address range. Within DN42, IPv6 uses the <a href="https://tools.ietf.org/html/rfc4193/" target="_blank" rel="noopener">Unique Local Address</a> (ULA) range, which is <code>fd00::/8</code>.</p>
    <p>You should generate a random prefix rather than trying to directly choose one, which can be done using an <a href="https://simpledns.com/private-ipv6/" target="_blank" rel="noopener">IPv6 ULA generator</a>.</p>
    <img class="radius-8" width="1000px" src="ipv6-ula-generator.png">
    <p class="two-no-mar centertext"><i>The IPv6 ULA generator provided by Simple DNS, available at <a href="https://simpledns.com/private-ipv6/" target="_blank" rel="noopener">simpledns.com/private-ipv6</a>.</i></p>
    <p>Once you've generated your own ULA range, create the registry object for it using my own below for guidance.</p>
    <p class="two-mar-bottom"><b>/data/inet6num/fd5c:d982:d80d:9243::_64</b>:</p>
    <pre class="two-mar-top">inet6num:           fd5c:d982:d80d:9243:0000:0000:0000:0000 - fd5c:d982:d80d:9243:ffff:ffff:ffff:ffff
cidr:               fd5c:d982:d80d:9243::/64
netname:            JAMIEWEB-V6-NET-1
country:            GB
admin-c:            JAMIEWEB-DN42
tech-c:             JAMIEWEB-DN42
mnt-by:             JAMIEWEB-MNT
status:             ASSIGNED
source:             DN42</pre>
    <p>Like with your IPv4 range, you'll also need to create a route object in order to authorise the prefix to be announced by the relevant AS.</p>
    <p class="two-mar-bottom"><b>/data/route6/fd5c:d982:d80d:9243::_64</b>:</p>
    <pre class="two-mar-top">route6:             fd5c:d982:d80d:9243::/64
origin:             AS4242420171
mnt-by:             JAMIEWEB-MNT
source:             DN42</pre>

    <h3 id="dn42-domain-name-registration"><code>.dn42</code> Domain Name Registration (Optional)</h3>
    <p>Within DN42, you can also optionally register your own domain name under the <code>.dn42</code> top-level domain (TLD). You can then use this to operate named services within DN42, such as websites or IRC servers.</p>
    <p>Registering a domain name isn't required in order to enjoy the low-level networking aspects of DN42, however if you would like one, you can use the example below in order to create a registry object for it.</p>
    <p class="two-mar-bottom"><b>/data/dns/jamieweb.dn42</b>:</p>
    <pre class="two-mar-top">domain:             jamieweb.dn42
descr:              JamieWeb
admin-c:            JAMIEWEB-DN42
tech-c:             JAMIEWEB-DN42
mnt-by:             JAMIEWEB-MNT
nserver:            ns1.jamieweb.dn42 172.20.32.97
nserver:            ns1.jamieweb.dn42 fd5c:d982:d80d:9243::2
source:             DN42</pre>
    <p>The <code>nserver</code> parameters are used to specify the glue records for your domain, which include the DNS name of each name server and its associated IP address. In my case, I have specified a primary name server with both an IPv4 and IPv6 address from my assigned ranges.</p>
    <p>Once you're properly set up and connected to DN42, you can then run an authoritative DNS server for your domain, which will allow other members of DN42 to resolve it and access your named services.</p>

    <h3 id="validating-your-registry-objects">Validating Your Registry Objects</h3>
    <p>The DN42 registry repository includes three validation scripts that can be run against your registry objects in order to help ensure that they are syntactically correct and accurate prior to being reviewed by the DN42 moderators.</p>
    <p>The scripts are present in the root of the repository. You should run each of these accordingly and check for any errors or warnings before proceeding:</p>
    <ul class="spaced-list">
        <li><code>./fmt-my-stuff <span class="color-red">YOURNAME</span>-MNT</code> - Automatically fix minor formatting errors.</li>
        <li><code>./check-my-stuff <span class="color-red">YOURNAME</span>-MNT</code> - Validate your objects against the DN42 registry schema.</li>
        <li><code>./check-pol origin/master <span class="color-red">YOURNAME</span>-MNT</code> - Check for routing policy violations.</li>
    </ul>
    <p>These scripts will also be run automatically by the DN42 registry Continuous Integration (CI) system when you submit your changes to the registry, with the output being shared as a pull request comment.</p>

    <h2 id="merging-your-registry-objects-into-the-registry">Merging Your Registry Objects into the Registry</h2>
    <p>Now that you've created all of the required registry objects, you need to submit these to the registry for approval.</p>
    <p>This is done by creating a Git pull request/merge request, which once reviewed by the DN42 registry moderators, will allow your registry objects to be seamlessly merged into the main DN42 registry.</p>
    <p>Begin by adding your newly created registry objects to your local Git index, ready to be committed. You can use the following command from the root of the registry repository:</p>
    <pre>$ git add .</pre>
    <p>Next, commit the changes to the repository:</p>
    <pre>$ git commit</pre>
    <p>Enter a suitable commit message, e.g. 'Added AS424242xxxx'. You should then be asked for your GPG passphrase to cryptographically sign your commit.</p>
    <p>Once the changes have been successfully committed, push them up to your fork of the repository on the DN42 registry Git server:</p>
    <pre>$ git push origin master</pre>
    <p>If you browse to your fork of the registry in your web browser, you should now see that your registry objects have been uploaded successfully.</p>
    <img class="radius-8" width="1000px" src="registry-commit.png">
    <p class="two-no-mar centertext"><i>My forked copy of the DN42 registry, showing the commit for my initial submission.</i></p>
    <p>You now need to create a pull request at the main DN42 registry, in order to request for your changes to be merged in. This can be done by clicking the 'New Pull Request' button from the main DN42 registry repository.</p>
    <p>You can add a name and description to your pull request, and you should also be able to see a summary of the changes that you made locally.</p>
    <p>All of the pull requests submitted by other members of DN42 are also publicly visible, so you may wish to <a href="https://git.dn42.us/dn42/registry/pulls/" target="_blank" rel="noopener">review some of these</a> to double-check that your submission is in-line with the others.</p>
    <p>Once you've submitted your pull request, it will be visible in the DN42 main registry waiting for moderator review.</p>
    <img class="radius-8" width="1000px" src="registry-pull-request">
    <p class="two-no-mar centertext">The pull request that I originally submitted to join DN42 as AS4242420171.</i></p>
    <p>It may take a few hours or days for your submission to be reviewed by the DN42 moderators. Keep checking your pull request as they may add comments to ask further clarifying questions or to ask you to fix any mistakes.</p>
    <p>In the event that there is a mistake in your submission and you need to resubmit, the easiest way to do this is to softly roll-back the commit that you made (this will not overwrite or delete any of your changes):</p>
    <pre>$ git reset HEAD~1</pre>
    <p>Then make the required fixes or adjustments, and commit and push them back to your forked repository:</p>
    <pre>$ git add .
$ git commit
$ git push origin master</pre>
    <p>Once this is complete, your pull request will have been automatically updated with the new changes. You don't need to manually submit another one unless you committed further changes to your repository between making your initial submission and implementing the fixes or adjustments.</p>

    <h2 id="finding-a-peer">Finding a Peer</h2>
    <p>In order to actually get connected to DN42, you'll need to find at least one peer. This is an individual or organisation who is willing to provide you with a VPN tunnel into the DN42 network, which you can then BGP peer through to announce your IP address ranges. This is equivalent to an upstream network provider.</p>
    <p>Peering usually takes place over a Wireguard or OpenVPN tunnel, with GRE, IPsec and PPTP being used in some cases too. You could also peer with someone via a physical link if you really wanted to, though in reality that is quite impractical unless you are physically proximate.</p>
    <p>Many prominent members of DN42 will happily peer with you if you ask nicely via email or IRC. Others offer 'open peering' or 'automatic peering', which is where you're able to peer with them either semi-automatically by filling out a sign-up form, or in some cases fully automatically using a command-line wizard interface.</p>
    <p>In order to identify a suitable peer, which is ideally one located within the same continent as you and accessible over a low-latency connection, you can use the <a href="https://dn42.us/peers/" target="_blank" rel="noopener">DN42 PeerFinder</a>.</p>
    <img class="radius-8" width="1000px" src="peerfinder.png">
    <p class="two-no-mar centertext"><i>The DN42 PeerFinder, accessible at <a href="https://dn42.us/peers/" target="_blank" rel="noopener">dn42.us/peers</a>.</i></p>
    <p>OpenVPN is easier to configure as a client (but not as a server), and also has greater monitoring and debugging capabilities. However, Wireguard is much more lightweight and is now included in the latest versions of the Linux Kernel. In this article we will use OpenVPN, however you can safely use Wireguard as an alternative if you'd prefer.</p>
    <p>Below I've linked a few of the reputable peers that I found when I first joined DN42:</p>
    <ul class="spaced-list">
        <li><a href="https://dn42-svc.weiti.org/" target="_blank" rel="noopener">dn42-svc.weiti.org</a> - Wireguard</li>
        <li><a href="https://graffen.dk/dn42.html" target="_blank" rel="noopener">graffen.dk/dn42.html</a> - Wireguard</li>
        <li><a href="https://dn42.g-load.eu/peering/" target="_blank" rel="noopener">dn42.g-load.eu/peering</a> - OpenVPN, Wireguard</li>
    </ul>
    <p>My personal favourite is the <a href="https://dn42.g-load.eu/" target="_blank" rel="noopener">Kioubit Network</a>. I'm currently peering with their Lithuania node, and overall I've found the service to be very stable and reliable.</p>
    <img class="radius-8" width="1000px" src="peering-locations.png">
    <p class="two-no-mar centertext"><i>The wide range of peering locations available on the Kioubit Network peering page, accessible at <a href="https://dn42.g-load.eu/peering/" target="_blank" rel="noopener">dn42.g-load.eu/peering</a>.</i></p>
    <p>If you want to use Kioubit's automatic peering, you can <a href="https://dn42.g-load.eu/peering/auto/" target="_blank" rel="noopener">sign up online</a> to receive your OpenVPN client configuration and private key. <b>Note that inactive peerings with Kioubit are removed after one week, so make sure to keep your session active 24/7 if possible.</b></p>
    <p>Alternatively, if you'd like to peer with someone else, fill out the relevant sign-up forms or contact them to get set up.</p>

    <h2 id="connecting-to-your-peer-using-openvpn">Connecting to Your Peer Using OpenVPN</h2>
    <p>If you opt to connect to your peering partner using OpenVPN, you'll most likely be provided with an OpenVPN client configuration file with the <code>.ovpn</code> file extension, as well as a private key for the connection.</p>
    <p>The setup varies depending on your peer, however the following rough steps should provide enough guidance to get the VPN tunnel connected.</p>
    <p>Begin by installing OpenVPN:</p>
    <pre>$ sudo apt install openvpn</pre>
    <p>Next, put your OpenVPN client configuration file somewhere safe, such as in your home directory. Make sure not to accidentally put it in your local copy of the DN42 registry, as this file shouldn't be shared publicly.</p>
    <p>If your OpenVPN key was provided as a separate file, put this somewhere private. Often this should go in the <code>/etc/openvpn</code> directory, however check your client configuration first, as sometimes a different directory is used.</p>
    <p>Ensure that the permissions on the file containing your key are appropriately locked down, i.e. by removing all access for all but your own user:</p>
    <pre>$ chmod go-rwx <span class="color-red">yourkey</span>.key</pre>
    <p>You can then bring the tunnel online:</p>
    <pre>$ sudo openvpn --config <span class="color-red">yourconfig</span>.ovpn</pre>
    <p>If you don't see any output, then this generally means that the connection was made successfully.</p>
    <p>You can double-check this by viewing the network interface information with the <code>ifconfig</code> command, and then pinging remote tunnel endpoint address of your peering partner, which will usually be a private IPv4 address in the <code>10.0.0.0/8</code>, <code>172.16.0.0/12</code> or <code>192.168.0.0/16</code> range.</p>
    <p>If you don't seem to have a connection, keep pinging it for a while, as it can often take quite a few packets for the connection to become active. Alternatively, try restarting or stopping and starting the OpenVPN service:</p>
    <pre>$ sudo service openvpn <span class="color-red">restart/stop/start</span></pre>

    <h2 id="dnsmasq-dns-setup-for-dn42-domains">Dnsmasq DNS Setup for '.dn42' Domains</h2>
    <p>DN42 has its own root DNS servers that are responsible for resolving <code>.dn42</code> domain names, as well as providing reverse DNS for the DN42 IP address ranges.</p>
    <p>The main DN42 DNS resolver can be accessed via <code>172.20.0.53</code> or <code>fd42:d42:d42:54::1</code>. Both of these addresses are anycasted, meaning that the same IP address routes to multiple distinct geographical locations. This is very similar to how public resolvers on the internet work, such as <code>1.1.1.1</code> or <code>8.8.8.8</code>.</p>
    <p>On DN42, any member can run their own authoritative DNS server and apply to become a part of the root DNS infrastructure. This does bring with it the risk of malicious DNS resolvers, however in most lab environments, this isn't usually a concern. If this is a concern for you, then you should look into using a known trusted resolver, such as one provided by your peering partner or another reputable member of DN42.</p>
    <p>You can configure your local system to direct lookups for DN42 resources to the DN42 authoritative DNS servers using a custom Dnsmasq resolver configuration. The configuration described below will work on most Debian or Ubuntu-based systems, however should also be applicable to other Linux distributions with some minor modifications.</p>
    <p>Begin by installing Dnsmasq:</p>
    <pre>$ sudo apt install dnsmasq</pre>
    <p>Next, create a new config file at <code>/etc/dnsmasq.d/dn42.conf</code> and add the following to it:</p>
    <pre>no-resolv
server=<span class="color-red">1.1.1.1</span>
server=/dn42/172.20.0.53
server=/20.172.in-addr.arpa/172.20.0.53
server=/21.172.in-addr.arpa/172.20.0.53
server=/22.172.in-addr.arpa/172.20.0.53
server=/23.172.in-addr.arpa/172.20.0.53
server=/d.f.ip6.arpa/fd42:d42:d42:54::1</pre>
    <p>The <code>no-resolv</code> configuration is used to prevent Dnsmasq from using the <code>/etc/resolv.conf</code> file to identify the recursive/upstream resolver to use, as this is instead specified directly in the Dnsmasq configuration. I've used <code>1.1.1.1</code> in the example above, however you can change this to something else if you wish.</p>
    <p>The rest of the configuration is used to specify the resolver to use for <code>.dn42</code> domains, as well as reverse DNS (<code>*.in-addr.arpa</code> and <code>*.ip6.arpa</code>).</p>
    <p>In order to begin using Dnsmasq, you'll first need to disable your existing local resolver, which in the case of most Debian-based systems, can be done using the following (<b>note that this will temporarily kill local DNS resolution</b>):</p>
    <pre>$ sudo service systemd-resolved stop</pre>
    <p>Next, edit your <code>/etc/resolv.conf</code> file and ensure that the following configuration is set:</p>
    <pre>nameserver 127.0.0.53</pre>
    <p>This will ensure that all local DNS lookups use Dnsmasq.</p>
    <p>Usually it isn't recommended to edit the <code>/etc/resolv.conf</code> file, as it is managed automatically by <code>systemd-resolved</code>. However, now that this service has been disabled, you can safely edit the file.</p>
    <p>You can then start Dnsmasq:</p>
    <pre>$ sudo service dnsmasq start</pre>
    <p>Your new local resolver should now be working. You won't be able to resolve DN42 names yet, but normal internet names should be working:</p>
    <pre>$ dig +short ldn01.jamieweb.net
139.162.222.67</pre>
    <p>Once you've confirmed that Dnsmasq is working, you can set it to be your default resolver at boot using the following two commands:</p>
    <pre>$ sudo systemctl disable systemd-resolved
$ sudo systemctl enable dnsmasq</pre>
    <p>Once you're announcing your IP address ranges and are able to communicate with DN42 fully, you'll be able to properly look up names such as <code>wiki.dn42</code> and <code>ca.dn42</code>.</p>

    <h2 id="part-1-conclusion">Part 1 / Conclusion</h2>
    <p>You've now successfully connected to DN42, meaning that you have a suitable lab environment to begin BGP peering with.</p>
    <p>In the next article, we'll look at Quagga BGPd, and set up a basic IPv4 and IPv6 BGP configuration.</p>
</div>

<?php include "footer.php" ?>
