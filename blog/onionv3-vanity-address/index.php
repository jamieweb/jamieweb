<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Tor Onion v3 Vanity Address</title>
    <meta name="description" content="Generating a vanity address for a Tor Onion v3 Hidden Service">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/blog/onionv3-vanity-address/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Tor Onion v3 Vanity Address</h1>
    <hr>
    <p><b>Saturday 6th January 2018</b></p>
    <p>For 21 days, my <a href="/projects/computing-stats/" target="_blank">Raspberry Pi cluster</a> has been running <a href="https://github.com/cathugger/mkp224o" target="_blank" rel="noopener">mkp224o</a> in order to generate a vanity address for my new <a href="/blog/onionv3-hidden-service/" target="_blank">Tor Onion v3 Hidden Service</a>.</p>
    <p>It isn't as good as <a href="/blog/tor-hidden-service/" target="_blank">last time</a>, but I have chosen: <b><a href="http://jamie3vkiwibfiwucd6vxijskbhpjdyajmzeor4mc4i7yopvpo4p7cyd.onion" target="_blank" rel="noopener">jamie3vkiwibfiwucd6vxijskbhpjdyajmzeor4mc4i7yopvpo4p7cyd.onion</a></b></p>
    <p>So I guess that's... 3 volt Kiwi?</p>
    <p><s><b>Please note that this Onion v3 Hidden Service will not be available until Onion v3 reaches the stable Tor branch. For now, you can use my test Onion v3 service at <a href="http://32zzibxmqi2ybxpqyggwwuwz7a3lbvtzoloti7cxoevyvijexvgsfeid.onion/" target="_blank" rel="noopener">32zzibxmqi2ybxpqyggwwuwz7a3lbvtzoloti7cxoevyvijexvgsfeid.onion</a>, which requires tor-0.3.2.1-alpha (eg: Tor Browser 7.5a5) or newer to access.</b></s></p>
    <p><b>Edit 17th Jan 2018 @ 11:00pm:</b> <i>Onion v3 functionaility is now in the stable release of Tor, so my new hidden service is live! The Onion v3 hidden service used for testing is now offline.</i></p>
    <p><b>Skip to Section:</b></p>
    <pre><b>Tor Onion v3 Vanity Address</b>
&#x2523&#x2501&#x2501 <a href="#mkp224o">mkp224o</a>
&#x2523&#x2501&#x2501 <a href="#performance">Performance</a>
&#x2523&#x2501&#x2501 <a href="#generation-times">Address Generation Times</a>
&#x2523&#x2501&#x2501 <a href="#filtering">Filtering Generated Addresses</a>
&#x2523&#x2501&#x2501 <a href="#implementation">Implementation</a>
&#x2523&#x2501&#x2501 <a href="#other-programs">Other Onion v3 Vanity Address Generation Programs</a>
&#x2523&#x2501&#x2501 <a href="#conclusion">Conclusion</a>
&#x2517&#x2501&#x2501 <a href="#references">References</a></pre>

    <h2 id="mkp224o">mkp224o</h2>
    <p>mkp224o is a vanity address generator for Tor Onion v3 Hidden Services, created by <a href="https://github.com/cathugger/mkp224o" target="_blank" rel="noopener">cathugger</a> and available <a href="https://github.com/cathugger/mkp224o" target="_blank" rel="noopener"> on Github</a>.</p>
    <img width="1000px" src="/blog/onionv3-vanity-address/github-cathugger-mkp224o.png">
    <p class="two-no-mar centertext"><i>The mkp224o repository on cathugger's GitHub account.</i></p>
    <p><a href="https://gitweb.torproject.org/torspec.git/tree/proposals/224-rend-spec-ng.txt" target="_blank" rel="noopener">Tor Proposal 224</a> is the proposal for the new Onion v3 specification, so that's what mkp224o was named after.</p>
    <p>mkp224o is very easy to install and run. Download and extract the latest version from GitHub, then on Debian-based systems, you can use:</p>
    <pre>#Install dependencies if required
sudo apt-get install autoconf libsodium-dev

#Build
./autogen
./configure
make</pre>
    <p>You can run "./mkp224o -h" to view the available options:</p>
    <pre>js@node0:~/onionv3/mkp224o$ ./mkp224o
Usage: ./mkp224o filter [filter...] [options]
       ./mkp224o -f filterfile [options]
Options:
	-h  - print help
	-f  - instead of specifying filter(s) via commandline, specify filter file which contains filters separated by newlines
	-q  - do not print diagnostic output to stderr
	-x  - do not print onion names
	-o filename  - output onion names to specified file
	-F  - include directory names in onion names output
	-d dirname  - output directory
	-t numthreads  - specify number of threads (default - auto)
	-j numthreads  - same as -t
	-n numkeys  - specify number of keys (default - 0 - unlimited)
	-N numwords  - specify number of words per key (default - 1)
	-z  - use faster key generation method. this is now default
	-Z  - use slower key generation method
	-s  - print statistics each 10 seconds
	-S t  - print statistics every specified amount of seconds
	-T  - do not reset statistics counters when printing</pre>
    <p>You can then run mkp224o to search for an address. The "-S" argument will make mkp224o output statistics every 5 seconds, and the "-d" argument allows you to specify a directory to store the generated keys.</p>
    <pre>js@node0:~/onionv3/mkp224o$ ./mkp224o -S 5 -d onions jamie
set workdir: onions/
sorting filters... done.
filters:
	jamie
in total, 1 filter
using 4 threads
>calc/sec:17035.009192, succ/sec:0.000000, rest/sec:39.964831, elapsed:0.100088sec
>calc/sec:22250.236672, succ/sec:0.000000, rest/sec:0.000000, elapsed:5.103855sec
>calc/sec:22272.487630, succ/sec:0.000000, rest/sec:0.000000, elapsed:10.107517sec
>calc/sec:22256.077578, succ/sec:0.000000, rest/sec:0.000000, elapsed:15.111813sec
>calc/sec:22278.089855, succ/sec:0.000000, rest/sec:0.000000, elapsed:20.116102sec
>calc/sec:22253.435622, succ/sec:0.000000, rest/sec:0.000000, elapsed:25.120363sec
>calc/sec:21762.771552, succ/sec:0.000000, rest/sec:0.000000, elapsed:30.142012sec
>calc/sec:22258.870726, succ/sec:0.000000, rest/sec:0.000000, elapsed:35.146309sec
>calc/sec:22282.575137, succ/sec:0.000000, rest/sec:0.000000, elapsed:40.150578sec
>calc/sec:22258.577166, succ/sec:0.000000, rest/sec:0.000000, elapsed:45.154941sec
>calc/sec:22198.079226, succ/sec:0.000000, rest/sec:0.000000, elapsed:50.159383sec
>calc/sec:22253.661568, succ/sec:0.000000, rest/sec:0.000000, elapsed:55.163728sec
>calc/sec:22276.712822, succ/sec:0.000000, rest/sec:0.000000, elapsed:60.168057sec
>calc/sec:22254.261335, succ/sec:0.000000, rest/sec:0.000000, elapsed:65.172357sec
>calc/sec:22277.632325, succ/sec:0.000000, rest/sec:0.000000, elapsed:70.176659sec
>calc/sec:22256.428313, succ/sec:0.000000, rest/sec:0.000000, elapsed:75.180966sec
^Cwaiting for threads to finish... done.</pre>
    <p>In the example above, I exited mkp224o after 75 seconds using Ctrl+C.</p>
    <p>Matching addresses are automatically saved into either the directory where mkp224o is running or the one specified using the "-d" switch.</p>
    <pre>js@node0:~/onionv3/mkp224o$ ls onions/ | head -n 5
jamie22ezawwi5r3o7lrgsno43jj7vq5en74czuw6wfmjzkhjjryxnid.onion
jamie22jd4c7g7osiio7jnqnsqj4w7dpqmit32easwp2igjge67nktid.onion
jamie233pm4t6zkbkdyiu7yknnqccirtkcwne2h5nc73mykvckg76sqd.onion
jamie23kp7n6xgk3lvy6wnse4cuk4dawfpwl52img7za35tiyex2mvyd.onion
jamie24hjpe7ia2usa6odvoi3s77j4uegeytk7c3syfyve2t33curbyd.onion

js@node0:~/onionv3/mkp224o$ ls jamie22ezawwi5r3o7lrgsno43jj7vq5en74czuw6wfmjzkhjjryxnid.onion/
hostname  hs_ed25519_public_key  hs_ed25519_secret_key</pre>
    <p>You could also set up a cronjob to run mkp224o at boot in a detached screen session:</p>
    <pre>@reboot cd /path/to/mkp224o && screen -dmS onionv3 ./mkp224o -S 600 -d onions jamie</pre>
    <p>You can then check up on mkp224o using "screen -r onionv3". Use Ctrl+A followed by Ctrl+D to detach from a screen session without terminating it.</p>

    <h2 id="performance">Performance</h2>
    <p>Running on a Raspberry Pi 2B, mkp224o achieved a pretty consistent 22,200 calculations per second, with 1 filter running on 4 threads.</p>
    <p>The 4 Raspberry Pi Zeros all achieved around 4,180 calculations per second, with 1 filter running on 1 thread.</p>
    <p>mkp224o ran 24 hours a day for 21 days. The total number of addresses generated by each device is shown below:</p>
    <pre>Master (RPi 2B)   : 1014
Node 1 (RPi Zero) : 222
Node 2 (RPi Zero) : 192
Node 3 (RPi Zero) : 212
Node 4 (RPi Zero) : 235</pre>
    <p>This makes for a total of 1,875 addresses, which is roughly 1 matching address found every 16 minutes and 8 seconds, or 967.68 seconds.</p>

    <h2 id="generation-times">Address Generation Times</h2>
    <p>In order to get a very rough estimate for the address generation time for each vanity length, I used the total generation time for the 1,875 addresses that I generated over 21 days, and extrapolated that using the total number of possible characters (32, a-z, 2-7) in order to get values for other vanity address lengths.</p>
    <p>These values are estimated using combined data from mkp224o running on 1 Raspberry Pi 2B and 4 Raspberry Pi Zeros, simultaneously and 24/7 for 21 days.</p>
    <pre class="scroll">Vanity Characters : Approximate Generation Time
1  : &lt;1 second
2  : &lt;1 second
3  : 1 second
4  : 30 seconds
5  : 16 minutes
6  : 8.5 hours
7  : 11.5 days
8  : 1 year
9  : 32 years
10 : 1,024 years
11 : 32,768 years
12 : 1 million years
13 : 32 million years
14 : 1 billion years
15 : 32 billion years
16 : 1 trillion years
17 : 32 trillion years
18 : 1 quadrillion years
19 : 32 quadrillion years
20 : 1 quintillion years
21 : 32 quintillion years
22 : 1 sextillion years
23 : 32 sextillion years
24 : 1 septillion years
25 : 32 septillion years
26 : 1 octillion years
27 : 32 octillion years
28 : 1 nonillion years
29 : 32 nonillion years
30 : 1 decillion years
31 : 32 decillion years
32 : 1 undecillion years
33 : 32 undecillion years
34 : 1 duodecillion years
35 : 32 duodecillion years
36 : 1 tredecillion years
37 : 32 tredecillion years
38 : 1 quattuordecillion years
39 : 32 quattuordecillion years
40 : 1 quindecillion years
41 : 32 quindecillion years
42 : 1 sexdecillion years
43 : 32 sexdecillion years
44 : 1 septendecillion years
45 : 32 septendecillion years
46 : 1 octodecillion years
47 : 32 octodecillion years
48 : 1 novemdecillion years
49 : 32 novemdecillion years
50 : 1 vigintillion years
51 : 32 vigintillion years
52 : 10^66 years
53 : 10^69 years
54 : 10^72 years
55 : 10^75 years
56 : 10^78 years (1,000,000,000,000,000,000,000,000,000,000,000,000,000,000,000,000,000,000,000,000,000,000,000,000,000,000)</pre>
    <p>A copy of this is available on my Pastebin if you wish to view it without scrolling: <a href="https://pastebin.com/hdB8QU6z" target="_blank" rel="noopener">https://pastebin.com/hdB8QU6z</a></p>
    <p>I think that 11 vanity characters is realistically achievable given enough computing power, for example when/if Facebook upgrade their hidden service to Onion v3. The Raspberry Pi cluster that I used is a very low performance device when compared to a dedicated GPU crypto rig.</p>


    <h2 id="filtering">Filtering Generated Addresses</h2>
    <p>After I had been running mkp224o for 21 days, I needed to use the cluster for something else so it was time to choose an address. Glancing through the results, there wasn't anything that stood out, so I searched through it with grep for various keywords and acronyms (eg: sec, pgp, php, etc), however there wasn't anything particularly good.</p>

    <p>I wanted to search for English words in the output, so I used the /usr/share/dict/british-english file that is included with the package "wbritish" on Debian-based systems.</p>
    <p>At first I tried the following, but it turned out to be <b>extremely inefficient</b> and could <b>cause a system crash</b>, so I do not recommend trying this yourself!</p>
    <pre>#Install wbritish if required
sudo apt-get install wbritish

#Make a copy of the british-english dictionary for searching
cp /usr/share/dict/british-english wordlist.txt

#Remove one character words
grep -v "^[A-Za-z]$" wordlist.txt > wordlist2.txt

#Remove two character words
grep -v "^[A-Za-z][A-Za-z]$" wordlist2.txt > wordlist.txt

#Remove "onion", "Onion", "Jamie", "ion", "Jami", "jam" & "Amie"
egrep -v "(^onion$|^Onion$|^ion$|^Jamie$|^Amie$|^Jami$|^jam$)" wordlist.txt > wordlist2.txt

#Find words from wordlist2.txt in onion-v3-export.txt
<b>This could crash your system, be careful!</b>
grep -iFf wordlist2.txt onion-v3-export.txt</pre>
    <p>The reason that this technique is so inefficient is that it uses just one instance of grep for the entire search, and grep isn't designed to handle that. I had this running for around 5 minutes and it slowly built up 16 GB RAM usage and started eating into my swap partition, which isn't good! Grep isn't designed for handling this sort of processing, so it's unfair to discount it for this memory-handling behaviour.</p>
    <img width="1000px" src="/blog/onionv3-vanity-address/grep-system-monitor.png">
    <p>The technique that worked well was using a separate instance of grep for each word to search for, instead of trying to search for them all at once. This was a slower searching method, however it uses minimal memory.</p>
    <p>I also decided to cut the addresses to search down to just the first 12 characters, as words that aren't at the start of the address aren't of much value in most cases.</p>
    <pre>cut -c 1-12 onion-v3-export.txt > onion-cut.txt</pre>
    <p>Then use a simple bash for loop in order to check each of the dictionary words against the address list individually:</p>
    <pre>for word in `cat wordlist2.txt`; do grep --colour=always -i "$word" onion-cut.txt; done</pre>
    <p>I set this running on a Raspberry Pi 2B and it took around 5 hours to search 1875 addresses for around 90,000 dictionary words.</p>
    <p>The output can be seen below:</p>
    <pre class="scroll pre-vanity">jamiei<span>abe</span>7a4
jamie6r6z<span>ala</span>
jamie<span>ark</span>jlxm
jamiecq7k<span>aug</span>
jamiefzu<span>bmw</span>i
jamiesh<span>biko</span>l
jamieyvh7<span>chi</span>
jamielws<span>clem</span>
jamied4<span>col</span>tx
jamied4<span>colt</span>x
jamieig<span>del</span>cr
jamie35cj<span>doe</span>
jamieolr<span>dow</span>a
jami<span>east</span>rwc5
jami<span>eco</span>jx25o
jami<span>eli</span>4bdva
jami<span>eli</span>5eiua
jami<span>eli</span>ozi7k
jamiemm<span>eli</span>nl
jami<span>eng</span>dpoqe
jami<span>eng</span>zlpbx
jamiem7<span>erin</span>n
jamie6w<span>esq</span>by
jamied<span>esq</span>kt7
jamiesf7b<span>esq</span>
jamiehu<span>etna</span>o
jami<span>eva</span>5stck
jami<span>eva</span>a3tz7
jami<span>eva</span>i4mxi
jami<span>eva</span>vnyxz
jami<span>eva</span>wy4s3
jami<span>eve</span>3ay5l
jami<span>eve</span>gkrdr
jami<span>eve</span>ndyi3
jami<span>eve</span>ut4pl
jamieus7<span>fdr</span>y
jamiekl<span>fox</span>y6
jamieoy<span>geo</span>v7
jamiess73<span>geo</span>
jamieh3q<span>god</span>d
jamiei<span>god</span>yok
jamieo<span>god</span>x2p
jamie<span>gus</span>qcma
jamiey<span>gus</span>gz2
jamier<span>guy</span>22t
jamieyl<span>guy</span>sw
jamie<span>hay</span>sabt
jamieoc<span>hay</span>7v
jamie<span>hays</span>abt
jamie4m<span>ian</span>ru
jamiezayf<span>ian</span>
jamiezce5<span>ida</span>
jamie52v<span>ina</span>e
jamiei<span>inc</span>yvq
jamiea<span>ives</span>lc
jamieza5<span>jay</span>l
jamie5<span>joe</span>c2a
jamie<span>jon</span>7tqe
jamiep<span>jon</span>dzx
jamie<span>jove</span>bbc
jamie4<span>ken</span>tlb
jamie4<span>kent</span>lb
jamie<span>kong</span>x4v
jamie3<span>lee</span>gvc
jamieruez<span>len</span>
jamieg7xr<span>leo</span>
jamiemiaa<span>leo</span>
jamiejjj5<span>les</span>
jamiew<span>les</span>7cq
jamief<span>lew</span>zbs
jamiemme<span>lin</span>l
jamie<span>ltd</span>wsfu
jamieqp<span>ltd</span>vr
jamieqw<span>mci</span>wy
jamierfn<span>mhz</span>f
jamie7k<span>mar</span>hc
jamien<span>may</span>cho
jamiem<span>mel</span>inl
jamiez72<span>mel</span>u
jamie4<span>mia</span>nru
jamie<span>mia</span>aleo
jamie<span>noe</span>m2kg
jamiemy<span>noh</span>ox
jamieal<span>oct</span>kj
jamiei6rk<span>ono</span>
jamie<span>oslo</span>k3j
jamiec<span>qom</span>mgv
jamiex5i<span>qom</span>c
jamief<span>rca</span>yod
jamiei<span>rca</span>xtn
jamies<span>ray</span>bwe
jamiesamx<span>rep</span>
jamiepy<span>sap</span>tu
jamie<span>sam</span>xrep
jamie4ds<span>sgt</span>t
jamieoos<span>sol</span>s
jamiellh<span>sue</span>x
jamie3o<span>sun</span>kf
jamiefw<span>suzy</span>t
jamiekf<span>twa</span>x2
jamie<span>twa</span>u3l2
jamiecg<span>tad</span>b2
jamieof<span>tao</span>gv
jamien<span>ted</span>7pn
jamieiup3<span>tex</span>
jamie<span>tex</span>srhi
jamieenbm<span>vic</span>
jamiee45<span>wis</span>j
jamie5<span>zen</span>znc
jamie7<span>zoe</span>b5u
jamie63u<span>ado</span>4
jamiek<span>adz</span>6r3
jamie7y<span>ail</span>ju
jamieel2i<span>ail</span>
jamieb3c6<span>aim</span>
jamiek<span>aim</span>e7x
jamier<span>air</span>7zf
jamiefo<span>ale</span>mu
jamieko<span>ale</span>5v
jamiemia<span>ale</span>o
jamieou5w<span>ale</span>
jamievwui<span>all</span>
jamiepys<span>apt</span>u
jamie<span>ark</span>jlxm
jamiek<span>awl</span>t2h
jamiep<span>bag</span>zbw
jamieqkr3<span>ban</span>
jamie3f<span>bet</span>fj
jamiey<span>bog</span>dzn
jamie3dm<span>boo</span>j
jamiet4<span>bug</span>ok
jamie<span>bun</span>quil
jamieqf<span>bur</span>u7
jamie2yv<span>but</span>2
jamieg<span>cap</span>4bx
jamie<span>car</span>xx2z
jamieyvh7<span>chi</span>
jamie<span>clap</span>vft
jamiep<span>cod</span>wwz
jamied4<span>colt</span>x
jamie3i<span>coo</span>5o
jamieq<span>crud</span>or
jamieztm<span>dab</span>f
jamie4<span>deb</span>rkh
jamie<span>dew</span>p2l4
jamie<span>dig</span>jmx5
jamie2fi<span>dip</span>4
jamies4f<span>dip</span>l
jamie35cj<span>doe</span>
jamiexii<span>dog</span>t
jamieus7f<span>dry</span>
jamief3a<span>dub</span>g
jamielhi<span>dub</span>k
jamiehx<span>due</span>t6
jamiehx<span>duet</span>6
jami<span>ear</span>kjlxm
jami<span>ear</span>xrrxz
jami<span>east</span>rwc5
jami<span>eat</span>ksy64
jami<span>ebb</span>azgwr
jami<span>ebb</span>e4onn
jami<span>ebb</span>k4civ
jami<span>ebb</span>lfkwp
jami<span>ebb</span>oqkaq
jamiejov<span>ebb</span>c
jami<span>eel</span>2iail
jami<span>eel</span>c6o6e
jami<span>eel</span>vm27e
jami<span>egg</span>4cmuc
jami<span>egg</span>mw7r4
jami<span>egg</span>qukg4
jami<span>egg</span>r35m5
jami<span>egg</span>x5omp
jami<span>eke</span>6czqs
jami<span>elf</span>ccgrt
jami<span>elf</span>h3f6h
jami<span>elf</span>zwd2l
jamie4z<span>elk</span>ks
jami<span>elk</span>2btz3
jami<span>elk</span>lik6v
jami<span>ell</span>45bdv
jami<span>ell</span>hsuex
jamie<span>ems</span>2vzv
jami<span>ems</span>3bz5b
jami<span>ems</span>avbsj
jami<span>ems</span>lb7wv
jami<span>ems</span>ty6yk
jamiefoal<span>emu</span>
jami<span>emu</span>b2jhx
jami<span>emu</span>kqyol
jami<span>end</span>dpbfp
jamiep<span>end</span>5mx
jamiev<span>end</span>yi3
jamie<span>eon</span>wydp
jami<span>era</span>2wgtx
jami<span>era</span>4jhrl
jami<span>era</span>c2xhr
jami<span>era</span>ir7zf
jami<span>ere</span>4xdh5
jami<span>ere</span>iwyin
jami<span>ere</span>mhidk
jami<span>ere</span>za4ph
jami<span>ere</span>zh3pg
jami<span>erg</span>uy22t
jami<span>err</span>2jah7
jamievf<span>err</span>at
jami<span>eta</span>p7o7p
jami<span>eve</span>3ay5l
jami<span>eve</span>gkrdr
jami<span>eve</span>ndyi3
jami<span>eve</span>ut4pl
jami<span>even</span>dyi3
jami<span>ewe</span>5ihs6
jami<span>exam</span>jhrr
jami<span>eye</span>ik2sq
jami<span>eye</span>k5q45
jamiewha<span>fax</span>b
jamiev<span>fer</span>rat
jamie<span>fig</span>7jeu
jamie<span>flew</span>zbs
jamiebqf<span>flu</span>d
jamie<span>foal</span>emu
jamiewmc<span>fob</span>4
jamie<span>foe</span>7puf
jamie<span>fog</span>ksuv
jamienp<span>fop</span>ab
jamiekl<span>fox</span>y6
jamiekl<span>foxy</span>6
jamiezs<span>fun</span>tu
jamiecx<span>gel</span>4m
jamiegq3s<span>gem</span>
jamieufiu<span>gob</span>
jamieh3q<span>god</span>d
jamiei<span>god</span>yok
jamieo<span>god</span>x2p
jamied<span>graph</span>f
jamiee<span>gun</span>xiy
jamier<span>guy</span>22t
jamieyl<span>guy</span>sw
jamieyl<span>guys</span>w
jamie4<span>hat</span>4o7
jamieprw<span>haw</span>x
jamie<span>hay</span>sabt
jamieoc<span>hay</span>7v
jamie<span>hays</span>abt
jamief<span>hazy</span>vn
jamiel<span>hid</span>ubk
jamierem<span>hid</span>k
jamienrjd<span>hip</span>
jamiensqi<span>hot</span>
jamiepjd<span>hot</span>n
jamie<span>hue</span>tnao
jamieal2<span>hug</span>y
jamie<span>ifs</span>uoia
jamiem7er<span>inn</span>
jamieijx<span>jaw</span>p
jamieza5<span>jay</span>l
jamiem<span>khz</span>2zm
jamie4<span>ken</span>tlb
jamie5i<span>kid</span>cw
jamieigw<span>kin</span>4
jamie3v<span>kiwi</span>b
jamiec<span>lap</span>vft
jamien<span>lazy</span>b4
jamie<span>led</span>uvsh
jamie3<span>lee</span>gvc
jamieeaq<span>lib</span>c
jamieasl3<span>lit</span>
jamiej<span>live</span>vk
jamie5ibl<span>low</span>
jamieqcw<span>low</span>g
jamieh<span>mad</span>nlg
jamie7k<span>mar</span>hc
jamiepd<span>mas</span>xf
jamie44<span>maw</span>sj
jamie44<span>maws</span>j
jamien<span>may</span>cho
ja<span>mien</span>3qp5cw
ja<span>mien</span>42romd
ja<span>mien</span>4khbab
ja<span>mien</span>56czjy
ja<span>mien</span>6iiq47
ja<span>mien</span>6vzoon
ja<span>mien</span>766udo
ja<span>mien</span>7evqfh
ja<span>mien</span>7hxhqq
ja<span>mien</span>7rrxmx
ja<span>mien</span>a25tw3
ja<span>mien</span>a2m4ad
ja<span>mien</span>b5srqt
ja<span>mien</span>cevt24
ja<span>mien</span>ddpbfp
ja<span>mien</span>eoqsde
ja<span>mien</span>fcnozu
ja<span>mien</span>frzm5t
ja<span>mien</span>fulha7
ja<span>mien</span>gdpoqe
ja<span>mien</span>gzlpbx
ja<span>mien</span>i4wpem
ja<span>mien</span>igx3xw
ja<span>mien</span>iox2od
ja<span>mien</span>je2ohv
ja<span>mien</span>jsyflg
ja<span>mien</span>kdtpy7
ja<span>mien</span>kvdjty
ja<span>mien</span>lazyb4
ja<span>mien</span>lwvpxl
ja<span>mien</span>m27ex6
ja<span>mien</span>mafk4n
ja<span>mien</span>maycho
ja<span>mien</span>ntzth2
ja<span>mien</span>oem2kg
ja<span>mien</span>oyixsl
ja<span>mien</span>p7rstj
ja<span>mien</span>pfopab
ja<span>mien</span>ptccfs
ja<span>mien</span>rhpwj3
ja<span>mien</span>rjdhip
ja<span>mien</span>sf3icf
ja<span>mien</span>sfldni
ja<span>mien</span>sndk5t
ja<span>mien</span>sogx5u
ja<span>mien</span>sqihot
ja<span>mien</span>ted7pn
ja<span>mien</span>up4blr
ja<span>mien</span>wulrkn
ja<span>mien</span>wwuixd
ja<span>mien</span>x6zpgq
ja<span>mien</span>xcz23c
ja<span>mien</span>xdmjtp
ja<span>mien</span>yjmqc6
ja<span>mien</span>yrheg6
ja<span>mien</span>z2zsnp
ja<span>mien</span>z6du67
ja<span>mien</span>zbapkd
ja<span>mien</span>zhu36p
ja<span>mien</span>zv45tc
ja<span>miens</span>f3icf
ja<span>miens</span>fldni
ja<span>miens</span>ndk5t
ja<span>miens</span>ogx5u
ja<span>miens</span>qihot
jamiegdt<span>mix</span>a
jamiey<span>mom</span>mno
jamie7<span>nix</span>gpq
jamiee4<span>not</span>f2
jamieod2<span>nub</span>q
jamie6zu<span>odd</span>5
jamieh3qg<span>odd</span>
jamie<span>oft</span>aogv
jamiemyn<span>oho</span>x
jamielrpn<span>opt</span>
jamies<span>opt</span>rhw
jamieg<span>pad</span>bjk
jamiekwb<span>pad</span>x
jamie7<span>paw</span>j52
jamiebt<span>paw</span>pi
jamieb6<span>pay</span>gd
jamie<span>pen</span>d5mx
jamiey<span>pep</span>j3i
jamie2mv<span>pit</span>g
jamie<span>ply</span>w6bm
jamie<span>pod</span>l6ka
jamiepbzu<span>pol</span>
jamie6vd<span>pot</span>q
jamie<span>pry</span>tdwt
jamiedg<span>rap</span>hf
jamiewp2j<span>rap</span>
jamievfer<span>rat</span>
jamies<span>ray</span>bwe
jamiesamx<span>rep</span>
jamiej<span>rib</span>rux
jamieugwl<span>roe</span>
jamiezu4m<span>row</span>
jamiej4t<span>rue</span>w
jamie<span>rue</span>zlen
jamiepy<span>sap</span>tu
jamie<span>say</span>snbd
jamie<span>says</span>nbd
jamiewqs7<span>sex</span>
jamie2zzy<span>sly</span>
jamiee<span>sly</span>ftw
jamieoos<span>sol</span>s
jamieoos<span>sols</span>
jamie<span>sop</span>trhw
jamiebc<span>spy</span>d2
jamiem<span>sty</span>6yk
jamiellh<span>sue</span>x
jamie<span>sum</span>k3iw
jamie3o<span>sun</span>kf
jamie3o<span>sunk</span>f
jamiecg<span>tad</span>b2
jamie<span>tap</span>7o7p
jamiey4lv<span>tea</span>
jamieqryi<span>tie</span>
jamiew<span>tit</span>d5q
jamie<span>top</span>4unx
jamiej4<span>true</span>w
jamie5x<span>try</span>fc
jamieag<span>tub</span>qw
jamiei<span>tun</span>yoy
jamie<span>vend</span>yi3
jamie6jj<span>via</span>2
jamieou5<span>wale</span>
jamieg<span>was</span>2k5
jamiekft<span>wax</span>2
jamiel6n<span>wen</span>3
jamie<span>wig</span>oswr
jamieoqp<span>wow</span>i
jamie<span>yap</span>nyqg
jamieod6<span>yaw</span>h
jamien6v<span>zoo</span>n</pre>
    <i><p>On a side note, in order to generate HTML output of the ANSI-encoded terminal emulator colours, you can use the "aha" command:</p>
    <pre>for word in `cat wordlist4.txt`; do grep --colour=always -i "$word" onion-cut.txt; done | aha</pre>
    <p>...which will convert the input into HTML with inline colour styling and the following header:</p>
    <pre>&lt;?xml version="1.0" encoding="UTF-8" ?&gt;
&lt;!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"&gt;
&lt;!-- This file was created with the aha Ansi HTML Adapter. https://github.com/theZiz/aha --&gt;
&lt;html xmlns="http://www.w3.org/1999/xhtml"&gt;
&lt;head&gt;
&lt;meta http-equiv="Content-Type" content="application/xml+xhtml; charset=UTF-8" /&gt;
&lt;title&gt;stdin&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
...</pre>
    <p>I then edited out the inline styling and used my CSS file instead in order to be compliant with my Content-Security-Policy.</p></i>
    <p>A significantly better way of filtering the vanity addresses would have been putting them all into a database and querying it, as database software is highly optimised for handling this sort of computation.</p>
    <p>I was really hoping to get a ^jamieweb address to go along with my Onion v2 service jamiewebgbelqfno.onion, however with Onion v3 and mkp224o, my estimates show that would take around a year. With Onion v2 and <a href="https://github.com/katmagic/Shallot" target="_blank" rel="noopener">Shallot</a>, that would (and did) take around 25 days.</p>
    <p>Honourable Mentions:</p>
    <pre><b>jamie4deb</b>rkhllykiyiztbpg6fokecmzhxvj4buig5qss5m4wasn5yyd.onion - Debian?
<b>jamiedgraph</b>fwrf2mfhc4iprjjpgzapiqikjxz4yseodq2bvnqcicoad.onion - Fast Graph Database?
<b>jamiedig</b>jmx56qpxfwht6pniy2jibt6lpled4juja3wmyuk7bfeaczad.onion - DNS Lookup Utility?
<b>jamieoslo</b>k3jxyg223xdm2fftsdd33cio2p5hozkipj27wcygomy4yid.onion - Capital of Norway?
<b>jamietap</b>7o7pux6fxpnxrbqvto6dypr3tx3befc7bpon6gn5m4tsftqd.onion - Network Tap?</pre>
    <p>The full list of generated addresses is available on my Pastebin: <a href="https://pastebin.com/eiFYaCHG" target="_blank" rel="noopener">https://pastebin.com/eiFYaCHG</a></p>

    <h2 id="implementation">Implementation</h2>
    <p>As of writing this, Onion v3 support is only available alpha versions of Tor, however a Tor build with Onion v3 functionality is currently at the second release candidate, so it should be reaching the stable branch very soon.</p>
    <p>For as long as Tor Onion v3 functionality remains in alpha only, I will be keeping the current hidden service address (http://32zzibxmqi2ybxpqyggwwuwz7a3lbvtzoloti7cxoevyvijexvgsfeid.onion) as well as running the Tor alpha instance on a separate, isolated server.</p>
    <p>When Onion v3 hits Tor stable, I will move it across to a main server as well as start using the jamie3vkiwi vanity address. I will also continue hosting my <a href="/blog/tor-hidden-service" target="_blank">Onion v2 hidden service</a> for as long as it is safe to do so.</p>
    <p>Luckily it is very easy to host multiple hidden services using the same Tor instance. In your torrc, just add multiple hidden service configurations:</p>
    <pre>HiddenServiceDir /desired/path/to/v3/hidden/service/config
HiddenServiceVersion 3
HiddenServicePort &lt;localport&gt; &lt;server&gt;

HiddenServiceDir /desired/path/to/v2/hidden/service/config
HiddenServiceVersion 2
HiddenServicePort &lt;localport&gt; &lt;server&gt;</pre>

    <h2 id="other-programs">Other Onion v3 Vanity Address Generation Programs</h2>
    <p>In addition to <a href="https://github.com/cathugger/mkp224o" target="_blank" rel="noopener">mkp224o</a> by <a href="https://github.com/cathugger" target="_blank" rel="noopener">cathugger</a> (which is what I used), there are also other Onion v3 vanity address generation programs out there:</p>
    <ul class="references">
        <li>horse25519: <a href="https://github.com/Yawning/horse25519" target="_blank" rel="noopener">https://github.com/Yawning/horse25519</a></li>
        <li>oniongen-go: <a href="https://github.com/rdkr/oniongen-go" target="_blank" rel="noopener">https://github.com/rdkr/oniongen-go</a></li>
        <li>oniongen-c: <a href="https://github.com/rdkr/oniongen-c" target="_blank" rel="noopener">https://github.com/rdkr/oniongen-c</a></li>
    </ul>
    <p>I personally tried out oniongen-go and oniongen-c in addition to mkp224o.</p>
    <p>If I have missed any, please <a href="/contact/" target="_blank">let me know</a>.</p>

    <h2 id="conclusion">Conclusion</h2>
    <p>To conclude, I think that mkp224o is fantastic software that worked stably for prolonged amounts of time on low-end hardware. If you want to generate a vanity address for your own Onion v3 service, definitely check out mkp224o.</p>
    <p>I am definitely not as happy with my Onion v3 vanity address as I am with my <a href="http://jamiewebgbelqfno.onion/" target="_blank" rel="noopener">Onion v2 vanity address</a>, however due to the enormously increased cryptographic security of Onion v3, vanity address generation takes slightly longer. This is not a problem for me though, since security is always more important that vanity, especially with software like Tor.</p>
    <h2 id="references">References</h2>
    <ul class="references">
        <li><a href="https://blog.torproject.org/tor-0328-rc-released-important-updates-relays" target="_blank" rel="noopener">Tor Blog - Tor 0.3.2.8-rc Released</a></li>
        <li><a href="https://gitweb.torproject.org/torspec.git/tree/proposals/224-rend-spec-ng.txt" target="_blank" rel="noopener">Tor Proposal 224 - Next-Generation Hidden Services in Tor</a></li>
        <li><a href="https://github.com/cathugger/mkp224o" target="_blank" rel="noopener">cathugger/mkp224o on GitHub</a></li>
        <li><a href="https://github.com/Yawning/horse25519" target="_blank" rel="noopener">Yawning/horse25519 on GitHub</a></li>
        <li><a href="https://github.com/rdkr/oniongen-go" target="_blank" rel="noopener">rdkr/oniongen-go on GitHub</a></li>
        <li><a href="https://github.com/rdkr/oniongen-c" target="_blank" rel="noopener">rdkr/oniongen-c on GitHub</a></li>
        <li><a href="https://github.com/katmagic/Shallot" target="_blank" rel="noopener">katmagic/Shallot on GitHub</a></li>
        <li><a href="https://pastebin.com/hdB8QU6z" target="_blank" rel="noopener">Pastebin - Onion v3 Vanity Characters Time Estimate</a></li>
        <li><a href="https://pastebin.com/eiFYaCHG" target="_blank" rel="noopener">Pastebin - All Generated Onion v3 Vanity Addresses</a></li>
        <li><a href="/projects/computing-stats" target="_blank">JamieWeb - Raspberry Pi Cluster Stats</a></li>
        <li><a href="/blog/onionv3-hidden-service" target="_blank">JamieWeb - Tor Onion v3 Hidden Service - 21st Oct 2017</a></li>
        <li><a href="/blog/tor-hidden-service" target="_blank">JamieWeb - Tor Hidden Service - 12th Feb 2017</a></li>
        <li><a href="http://jamiewebgbelqfno.onion/" target="_blank" rel="noopener">JamieWeb Onion v2 Hidden Service - jamiewebgbelqfno.onion</a></li>
        <li><a href="http://32zzibxmqi2ybxpqyggwwuwz7a3lbvtzoloti7cxoevyvijexvgsfeid.onion/" target="_blank" rel="noopener">JamieWeb Onion v3 Alpha Hidden Service (Now Offline) - 32zzibxmqi2ybxpqyggwwuwz7a3lbvtzoloti7cxoevyvijexvgsfeid.onion</a></li>
        <li><a href="http://jamie3vkiwibfiwucd6vxijskbhpjdyajmzeor4mc4i7yopvpo4p7cyd.onion/" target="_blank" rel="noopener">JamieWeb Onion v3 Production Hidden Service - jamie3vkiwibfiwucd6vxijskbhpjdyajmzeor4mc4i7yopvpo4p7cyd.onion</a></li>
    </ul>
</div>

<?php include "footer.php" ?>

</body>

</html>
