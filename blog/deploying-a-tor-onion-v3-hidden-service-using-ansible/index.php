<?php include "response-headers.php"; content_security_policy();
include_once "bloglist.php"; bloglist("postTop", null, null, 2019); ?>

<div class="body">
    <h1><?php echo $postInfo->title; ?></h1>
    <hr>
    <p><b><?php echo $postInfo->date; ?></b></p>
    <p><?php echo $postInfo->snippet; ?></p>
    <p>The guide assumes that you already have an Ansible playbook set up, including a hosts file, and are able to connect via SSH to the intended server.</p>

    <p><b>Skip to Section:</b></p>
    <pre><b><?php echo $postInfo->title ?></b>
&#x2523&#x2501&#x2501 <a href="#installing-tor">Installing Tor</a>
&#x2523&#x2501&#x2501 <a href="#configuring-tor">Configuring Tor</a>
&#x2523&#x2501&#x2501 <a href="#testing-the-hidden-service">Testing the Hidden Service</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>

    <h2 id="installing-tor">Installing Tor</h2>
    <p>If you are using a Debian system, a long-term support version of Tor is available in the default Apt repositories. However, to benefit from the latest features and security improvements, it is recommended to add the Tor repository to your Apt sources and install the latest stable version.</p>
    <p>If you are using an Ubuntu system, you shouldn't use the <code>tor</code> package from the default Apt repositories, as it is frequently out of date. This is not the fault of the Tor Project maintainers, but rather because the package is part of the 'Universe' repositories, meaning that the packages are community-maintained, rather than maintained by Canonical.</p>

    <p>The Tor repositories are available over HTTPS, so it is recommended to install <code>apt-transport-https</code> to allow Apt to download packages this way:</p>
    <pre>- name: "Install apt-transport-https"
  apt:
    update_cache: yes
    name: apt-transport-https</pre>

    <p>Next, you need to download and import the Tor package GPG signing key to Apt. Make sure to verify the key fingerprint and download location below:</p>
    <pre>- name: "Add Tor repo GPG signing key to Apt"
  apt_key:
    url: "https://deb.torproject.org/torproject.org/A3C4F0F979CAA22CDBA8F512EE8CBC9E886DDD89.asc"
    id: A3C4F0F979CAA22CDBA8F512EE8CBC9E886DDD89
    state: present</pre>

    <p>The next step is to actually add the Tor repository to your Apt sources and update the Apt cache. If you're using a distribution other than <code>bionic</code>, make sure to adjust the example to specify your own distribution name:</p>
    <pre>- name: "Add Tor repo to Apt sources"
  apt_repository:
    repo: "deb https://deb.torproject.org/torproject.org bionic main"
    update_cache: yes
    validate_certs: yes
    state: present</pre>

    <p>Finally, install the required packages for Tor - <code>tor</code> and <code>deb.torproject.org-keyring</code>, which will keep the package repository signing keys up to date:</p>
    <pre>- name: "Install Tor packages"
  apt:
    update_cache: yes
    name: "{{ tor_packages }}"
  vars:
    tor_packages:
    - tor
    - deb.torproject.org-keyring</pre>

    <h2 id="configuring-tor">Configuring Tor</h2>
    <p>Now that you've written the steps required for securely installing Tor, the next step is to configure it and set up your hidden service.</p>
    <p>Firstly, you need to create and then set a <code>torrc</code> file, which is the Tor configuration file. In your local Ansible directory, you can create the <code>torrc</code> file, and then have this be uploaded to the server when you run the playbook.</p>
    <p>Create the file on your local machine in a location that Ansible will be able to read. I personally prefer to create a <code>files</code> directory in my local Ansible directory, and then recreate the file system structure of the remote server. For example, the file <code>/etc/tor/torrc</code> on the remote machine would be stored in <code>files/etc/tor/torrc</code> on the local machine:</p>
    <pre>HiddenServiceDir /var/lib/tor/v3_hidden_service/
HiddenServiceVersion 3
HiddenServicePort 80 127.0.0.1:80</pre>
    <p>You can configure the parameters in the file as required. The <code>HiddenServicePort</code> configuration is used to forward traffic arriving at your hidden service on a particular port to a different destination, such as a local web server. In the sample above, connections to port 80 will be forwarded to 127.0.0.1 on port 80. It is not recommended to forward traffic outside of the local machine, as this has the potential to de-anonymize your hidden service.</p>

    <p>Next, copy the <code>torrc</code> file and set the required owner and permissions:</p>
    <pre>- name: "Set Torrc"
  copy:
    src: "files/etc/tor/torrc"
    dest: "/etc/tor/torrc"
    owner: root
    group: root
    mode: u=rw,g=r,o=r</pre>

    <p>The next two sections are only required if you wish to import the private key from an existing hidden service, e.g. if you want to use the same <code>.onion</code> address instead of generating a new one.</p>

    <p>Create the directory where your hidden service private key will be copied to:</p>
    <pre>- name: "Create Tor HS directory"
  file:
    path: /var/lib/tor/v3_hidden_service
    state: directory
    owner: debian-tor
    group: debian-tor
    mode: u=rwx,g=,o=</pre>

    <p>In order to securely copy your existing Tor hidden service private key onto the server, I recommend creating a separate <code>secrets</code> directory in your local Ansible directory, and storing the private key(s) in there.</p>
    <div class="message-box message-box-warning">
        <div class="message-box-heading">
            <h3 id="disclaimer"><u>Warning!</u></h3>
        </div>
        <div class="message-box-body">
            <p>If you are storing your Ansible configuration and playbooks in a version control system such as Git, make sure to consider whether it is appropriate for your Tor Hidden Service private key(s) to be checked in. It is recommended to exclude these files, for example using <code class="color-darkslategrey">.gitignore</code>. Access to these files will allow someone to fully impersonate your hidden service, putting yourself and your users at risk, and requiring the keys to be changed, meaning that you'll lose your <code class="color-darkslategrey">.onion</code> address and have to switch to a new one.</p>
        </div>
    </div>
    <p>Make sure to adjust the file paths and names as required. You only need to copy the private key file - the public key and/or hostname files are not required:</p>
    <pre>- name: "Set Tor HS keys"
  copy:
    src: secrets/hs_ed25519_secret_key
    dest: /var/lib/tor/v3_hidden_service/hs_ed25519_secret_key
    owner: debian-tor
    group: debian-tor
    mode: u=rw,g=,o=</pre>

    <p>Finally, restart the Tor service to apply the configuration:</p>
    <pre>- name: "Restart Tor"
  systemd:
    name: tor
    state: restarted</pre>
    <p>The Ansible 'notify' functionality could have instead been used to automatically restart Tor when required, but I have instead opted to explicitly restart Tor. This is to ensure that the Tor service is not accidentally re-enabled at the end of the playbook if you decide to follow the additional step below.</p>

    <p>By default, you can only announce a hidden service from one machine at a time, so if you are deploying this configuration to multiple remote hosts, you should disable Tor (including starting Tor at boot) on all but one of them:</p>
    <pre>- name: "Disable Tor on all hosts except host1"
  systemd:
    name: tor
    enabled: no
    state: stopped
  when: ansible_hostname != "host1"</pre>

    <h2 id="testing-the-hidden-service">Testing the Hidden Service</h2>
    <p>Once you have run your Ansible playbook against the desired remote hosts, you can perform some basic tests to verify that the hidden service is working correctly.</p>
    <p>Firstly, check your hidden service hostname. You can run the following command on the remote host to view the hostname file containing the <code>.onion</code> address:</p>
    <pre>$ cat /var/lib/tor/v3_hidden_service/hostname</pre>
    <p>If the file isn't present, run <code>sudo service tor status</code> to check whether the Tor service is running properly. If not, there may be an issue somewhere, so check the Tor logs (which should be <code>/var/log/tor</code>, or included in <code>/var/log/syslog</code>) for errors and double check all of your configuration.</p>

    <p>Secondly, check that you can connect to the hidden service. If you're running a web server behind your hidden service, you can connect to it either by entering the <code>.onion</code> address into the URL bar of the Tor Browser, or using the <code>curl</code> utility to connect through a local TorSOCKS proxy server, which should be running if you have Tor or Tor Browser installed:</p>
    <pre>$ curl --socks5-hostname 127.0.0.1:9050 <i>your-hidden-service</i>.onion</pre>
    <p>If you're unable to connect to your hidden service, try restarting Tor both on the local and remote machines, as sometimes there is a slight delay in connecting to brand-new hidden services when using an already-established Tor connection.</p>

    <h2 id="conclusion">Conclusion</h2>
    <p>This Ansible playbook configuration should hopefully make deploying Tor Hidden Services much easier and more time efficient. It vastly improves the reliability of the setup process, and makes it fully reproducible.</p>
    <p>To take the process to another level, you could implement some form of automatic testing that will ensure that the hidden service is responding correctly. For example, this could be done by automatically connecting to the hidden service over Tor at the end of the playbook, and checking for a specific response.</p>
    <p>If you have any questions or encounter any issues with this configuration, please feel free to <a href="/contact/" target="_blank">get in touch</a>.</p>
</div>

<?php include "footer.php" ?>
