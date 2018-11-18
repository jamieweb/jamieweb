<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Hosts File Site Blocking</title>
    <meta name="description" content="Blocking websites using the hosts file and an integrity verification script.">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/blog/hosts-file-integrity/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Hosts File Site Blocking</h1>
    <hr>
    <p><b>Saturday 15th July 2017</b></p>
    <p>Please see the <a href="https://github.com/jamieweb/hosts-file-integrity/" target="_blank" rel="noopener">associated GitHub repository</a> for details on the hosts-file-integrity scripts.</p>
    <p>I recently became interested in using the hosts file in order to block access to malicious and/or undesirable domains. This is similar to using an adblocker however it is applied system-wide, rather than just in your web browser. When using the hosts file, the request is blocked at a much lower level than when using an adblocking browser extension.</p>
    <p><b>Skip to Section:</b></p>
    <pre><b>Hosts File Site Blocking + Hosts File Integrity Script</b>
&#x2523&#x2501&#x2501 <a href="#whatis">What is the hosts file?</a>
&#x2523&#x2501&#x2501 <a href="#steven">Steven Black's Hosts File</a>
&#x2523&#x2501&#x2501 <a href="#script">Hosts File Integrity Script</a>
&#x2523&#x2501&#x2501 <a href="#pseudo">Pseudo-Verification</a>
&#x2523&#x2501&#x2501 <a href="#how">How do the scripts work?</a>
&#x2523&#x2501&#x2501 <a href="#dnsmasq">Dnsmasq</a>
&#x2523&#x2501&#x2501 <a href="#mobile">iOS/Android</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>
    <h2 id="whatis">What is the hosts file?</h2>
    <p>The hosts file is present on all modern systems, including Linux, Windows, Mac, iOS and Android. It contains mappings of hostnames to IP addresses, similar to DNS, however can be locally controlled by the user and usually takes priority over DNS.</p>
    <p>This allows you to add local, manual overrides for DNS entries. In this case, it is used to redirect undesirable domain names to a null address, which essentially blocks them.</p>
    <p>Example hosts file contents:</p>
    <pre>127.0.0.1 localhost
127.0.0.1 hostname
192.168.1.2 local-override-domain.tld
192.168.1.2 custom-extension-domain.qwerty
0.0.0.0 blocked-website.tld
0.0.0.0 another-blocked-website.tld</pre>
    <h2 id="steven" class="left-right-title-margin">Steven Black's Hosts File</h2>
    <div class="text-left-a"><p><a href="https://github.com/StevenBlack/" target="_blank" rel="noopener">Steven Black on GitHub</a> maintains a fantastic unified hosts file, containing data from many different reputable sources.</p>
    <p>The hosts file contains a list of malicious, undesirable or inappropriate sites that should be blocked.</p>
    <p>Multiple different variations of it are available and it is updated regularly.</p>
    <div class="centertext"><p><b><a href="https://github.com/StevenBlack/hosts/" target="_blank" rel="noopener">https://github.com/StevenBlack/hosts/</a></b></p></div></div>
    <div class="image-right-a"><div class="centertext"><a href="https://github.com/StevenBlack/hosts/" target="_blank" rel="noopener"><img width="450px" src="/blog/hosts-file-integrity/hosts-github.png"></a></div></div>
    <h2 id="script" class="clearboth">Hosts File Integrity Script</h2>
    <p>I am now using one of Steven Black's hosts files on all of my systems, and I wrote a bash script that will automatically keep it up to date. The repository is available on my GitHub profile:</p>
    <div class="centertext"><p><b><a href="https://github.com/jamieweb/hosts-file-integrity/" target="_blank" rel="noopener">https://github.com/jamieweb/hosts-file-integrity/</a></b></p></div>
    <p>This is not designed to be a robust, plug and play solution. It is made specifically to work with one particular variation of Steven Black's hosts files. However, this script could be easily modified in order to work with another variation of the available hosts files or otherwise adapted for the needs of somebody else.</p>
    <p>I am aware that Steven Black already provides several different scripts for keeping the file up to date on various different platforms, however I created an alternative for my own use that focuses more on security, automation and producing an output that is useful to me.</p>
    <p>The script should be run on a regular basis, every 24 hours is ideal. It automatically checks for an update and if one is available, downloads it and pseudo-verifies it. A second script is also available that should be run as a user with write access to /etc/hosts. This second script will automatically implement the new hosts file by moving it to /etc/hosts.</p>
    <p><b>All usage details for the script are available on the <a href="https://github.com/jamieweb/hosts-file-integrity/" target="_blank" rel="noopener">GitHub repository</a>.</b></p>
    <h2 id="pseudo">Pseudo-Verification</h2>
    <p>The "pseudo-verification" performed by this script refers to checking statistics and filtering out content that matches a specific regex pattern. The theory behind this is that all whitelisted/legitimate content is accounted for, leaving behind anything that shouldn't be there. This of course is not a perfect solution, however it is a good way to perform basic checks on the integrity of the file before putting it in place on your system.</p>
    <p>This is a bit of a silly term that I have been using during this project, but does seem to be viable since it could detect things that cryptographic proof could not. For example, if the signing keys of a particular developer were compromised or they simply decided to act maliciously. A potentially malicious file signed with a trusted key would then be distributed out to everybody, and due to the trust of a cryptographic system, people are compromised. While this is a highly unlikely scenario, it is worth considering and I personally wouldn't even consider using an automatically updating hosts file without some form of verification.</p>
    <p>Unfortunately Steven Black does not use signed commits when maintaining the GitHub repository. I know that I don't do this either, but for a project that is likely used by so many people with automatic updates, it would be nice to see.</p>
    <h2 id="how">How do the scripts work?</h2>
    <p>There are two scripts available in the GitHub repository: "<a href="https://github.com/jamieweb/hosts-file-integrity/blob/master/update-verify-file.sh" target="_blank" rel="noopener">update-verify-file.sh</a>" and "<a href="https://github.com/jamieweb/hosts-file-integrity/blob/master/verify-implement-file.sh" target="_blank" rel="noopener">verify-implement-file.sh</a>".</p>
    <ul><li><p>The first script (update-verify-file.sh) should be run as a non-privileged user, and will check for an update, download it if one is available and pseudo-verify the file.</p></li>
    <li><p>The second script (verify-implement-file.sh) should be run as a user with write access to /etc/hosts. This script will verify the latest version of the hosts file created by the first script and write it to /etc/hosts.</p></li></ul>
    <p>The scripts consist of various stages that must be completed successfully in order for the hosts file to be verified:</p>
    <div class="centertext"><p><b><u><i>Note that the code snippets below only show the logic, not the full code which includes nicely formatted output, etc.<br/>See the <a href="https://github.com/jamieweb/hosts-file-integrity/" target="_blank" rel="noopener">GitHub repository</a> for the full code.</i></u></b></p></div>
    <p><b>Checking/creating a lockfile:</b> The script uses a lockfile in order to ensure that two instances of the script are never run at the same time. There is always a 3 second delay between creating a lockfile and the script continuing. This probably isn't required, however it may help to prevent problems when two instances of the script are run very closely to each other.</p>
    <p><b>Checking network connectivity and access:</b> There are 3 different checks that take place right at the start of the script, all of which must be passed before it continues. These checks are: ping, SSL connection and SSL certificate details. The ping check is the first basic network check:</p>
    <pre>githubping=$(ping -c 3 -W 2 raw.githubusercontent.com | grep -o "3 packets transmitted, 3 received, 0% packet loss, time ")
if [ "$githubping" == "3 packets transmitted, 3 received, 0% packet loss, time " ]; then
    #ping check passed
    verifications=$((verifications+1))
else
    #ping check failed
    exit
fi</pre>
    <p>Checking the SSL connection and certificate details are required in order to ensure that there is access to the real GitHub user content website, rather than something that may be intercepting it, such as a captive portal or locally-accepted root certificate.</p>
    <pre>githubssl=$(echo | openssl s_client -connect raw.githubusercontent.com:443 2>&1 | egrep "^(    Verify return code: 0 \(ok\)|depth=0 C = US, ST = California, L = San Francisco, O = \"GitHub, Inc[.]\", CN = www[.]github[.]com)$")
if [[ $(echo "$githubssl" | tail -n 1) == "    Verify return code: 0 (ok)" ]]; then
    #ssl connection passed
    verifications=$((verifications+1))
else
    #ssl connection failed
    exit
fi
if [[ $(echo "$githubssl" | head -n 1) == "depth=0 C = US, ST = California, L = San Francisco, O = \"GitHub, Inc.\", CN = www.github.com" ]]; then
    #certificate details check passed
    verifications=$((verifications+1))
else
    #certificate details check failed
    exit
fi</pre>
    <p>Another network check that I could have implemented would have been checking for a particular piece of content on the GitHub user content website. For example, downloading a known file and ensuring that it matches. I decided against this though since it would require some form of permanent, immutable file. I could have simply created a file in the repository for this but it doesn't really seem like the right thing to do.</p>
    <p><b>Restoring the original file: </b>At this point, a function is defined that will restore the original file should the file verification fail.</p>
    <p><b>Checking for an update to the hosts file: </b>The script gets the SHA256 hash of the live version and compares it to the local version. If the hashes do not match, it is assumed that an update is available.</p>
    <pre>livehash=$(curl -s "https://raw.githubusercontent.com/StevenBlack/hosts/master/alternates/REDACTED-REDACTED-REDACTED/host...
...s" | sha256sum | awk '{ print $1 }')
localhash=$(sha256sum latest.txt | awk '{ print $1 }')
if [ $livehash == $localhash ]; then
    #no update available
    exit
else
    #update available, downloading update
    mv latest.txt old.txt
    curl -s "https://raw.githubusercontent.com/StevenBlack/hosts/master/alternates/REDACTED-REDACTED-REDACTED/hosts" > latest.txt
    if [[ $(sha256sum latest.txt | awk '{ print $1 }') == $livehash ]]; then
        #updated file hash matches
    else
        #updated file hash mismatch
        mv old.txt latest.txt
        exit
    fi
fi</pre>
    <p><b>Whitelisted character check: </b>Next, the newly downloaded file is checked against a whitelist of allowed characters.</p>
    <pre>if egrep -q "[^][a-zA-Z0-9 #:|=?+%&\*()_;/	@~'\"<>.,\\-]" latest.txt; then
    #whitelist check failed
    mv old.txt latest.txt
    exit
else
    #whitelist check passed
    verifications=$((verifications+1))
fi</pre>
    <p>This returns all characters except for those in the list. If verification is successful, nothing will be returned. If something is returned, verification has failed at this stage.</p>
    <p>At the time of writing, the whitelist check uses the regex pattern:</p>
    <pre>[^][a-zA-Z0-9 #:|=?+%&\*()_;/	@~'\"<>.,\\-]</pre>
    <p><b>Stripping allowed content from the file: </b>Grep is used to strip content from the file that matches specific regex patterns. The idea behind this is that everything legitimate is accounted for, leaving behind anything that shouldn't be there.</p>
    <pre>#All 0.0.0.0 entries (including xn-- domains as well as erroneous entires)
grepstrip=$(egrep -v "^0.0.0.0 [a-zA-Z0-9._-]{,96}[.][a-z0-9-]{2,20}$" latest.txt)

#All lines starting with a hash (comments)
grepstrip2=$(echo "$grepstrip" | egrep -v "^#.*$")

#Blank lines
grepstrip=$(echo "$grepstrip2" | egrep -v "^$")

#Lines starting with spaces/multiple tabs
grepstrip2=$(echo "$grepstrip" | egrep -v "^(  | {32}|	|	{4}| ?	{5})# ")

#Remove default/system hosts file entries
grepstrip=$(echo "$grepstrip2" | egrep -v "^(127[.]0[.]0[.]1 localhost|127[.]0[.]0[.]1 localhost[.]localdomain|127[.]0[.]0[.]1 local|255[.]255[.]255[.]255 broadcasthost|::1 localhost|fe80::1%lo0 localhost|0[.]0[.]0[.]0 0[.]0[.]0[.]0)$")

#Remove bits left behind
grepstrip2=$(echo "$grepstrip" | egrep -v "^(0[.]0[.]0[.]0 REDACTED|0[.]0[.]0[.]0 REDACTED|0[.]0[.]0[.]0 REDACTED)$")

if [ "$grepstrip2" == "" ]; then
    #all content stripped, check passed
    verifications=$((verifications+1))
else
    #some content remains, check failed
    mv old.txt latest.txt
    exit
fi</pre>
    <p><b>Checking the file byte and newline count: </b>Checking the rough size of the file ensures that something significant was actually downloaded, rather than just a blank/missing file.</p>
    <pre>bytecount=$(wc -c latest.txt | awk '{ print $1 }')
if (( $bytecount > 1200000 )); then
    #byte count check passed
    verifications=$((verifications+1))
else
    #byte count check failed
    mv old.txt latest.txt
    exit
fi

echo -n "- Checking file newline count: "
newlinecount=$(wc -l latest.txt | awk '{ print $1 }')
if (( $newlinecount > 50000 )); then
    #new line count check passed
    verifications=$((verifications+1))
else
    #new line count check failed
    mv old.txt latest.txt
    exit
fi</pre>
    <p><b>Verification complete: </b>If all verification checks were passed, the verification count should be 7. If this is the case, statistics of the file are output in order to produce a report for the user, such as hashes, timestamps and a diff between the new and old files. A backup is taken and the file also is modified to include the default entries for a Linux system. It is at this point that you could edit the script to add your own custom hosts entries that will be prepended to the file. A timestamp is also added as the first line of the file.</p>
    <pre>if [ $verifications == "7" ]; then
    #file verification successful
    mv current-hosts.txt backup-hosts.txt
    egrep -v "^(127[.]0[.]0[.]1 localhost|127[.]0[.]0[.]1 localhost[.]localdomain|127[.]0[.]0[.]1 local|255[.]255[.]255[.]255 broadcasthost|::1 localhost|fe80::1%lo0 localhost|0[.]0[.]0[.]0 0[.]0[.]0[.]0)$" latest.txt > current-hosts.txt
    filedate=$(date "+%a %d %b %Y - %r")
    filehostname=$(hostname)
    sed -i "1 i\#Updated: $filedate\n127.0.0.1 localhost\n127.0.0.1 $filehostname\n" current-hosts.txt
else
    #Verification count != 7
    mv old.txt latest.txt
    exit
fi</pre>
    <p><b>Verify and implement hosts script: </b>The second script that is available performs the same file verifications and then actually implements the script on your system by writing it to /etc/hosts. The script does not attempt to update the hosts file. This script needs to be run as a user that has write access to /etc/hosts.</p>
    <h2 id="dnsmasq">Dnsmasq</h2>
    <p>If a system or application that you are using does not read the hosts file, does not support the usage of the hosts file, or allows DNS to take priority, Dnsmasq is one possible solution.</p>
    <p>It is a DNS forwarder and DHCP server, however we are only interested in the DNS forwarding part of it in this case.</p>
    <p>By configuring your system or application to use the DNS server provided by Dnsmasq, you can force the usage of the hosts file. This does not necessarily have to be on the same device as the Dnsmasq server, you could run a local DNS server for your network or even one that can be accessed remotely, and then configure all of your devices to use it.</p>
    <h2 id="mobile">iOS/Android</h2>
    <p>While iOS and Android have hosts file functionality, is it generally not accessible to the user unless the phone is jailbroken/rooted. There are workarounds for some versions of Android, however generally speaking it is not possible unless you are rooted.</p>
    <p>In order to make use of your hosts file on a non-jailbroken/non-rooted device, you have two main options:</p>
    <ul><li><p>Host your own DNS server and use that on your device.</p></li>
    <li><p>Use a VPN that forces clients to use a particular DNS server.</p></li></ul>
    <p>Both of these options are not too difficult to configure and are definitely worth it since it will allow you to block ads and other undesirable content on your mobile device.</p>
    <h2 id="conclusion">Conclusion</h2>
    <p>Overall, the whole thing is a bit noddy, but it works well in my situation and I hope that somebody else will find it useful!</p>
</div>

<?php include "footer.php" ?>

</body>

</html>
