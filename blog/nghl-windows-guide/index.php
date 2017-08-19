<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>NGHL Windows Guide</title>
    <meta name="description" content="Installing New Gauge Half-Life on Windows">
    <meta name="keywords" content="Jamie, Scaife, jamie scaife, jamiescaife, jamieonubuntu, jamie90437, jamie90437x, jamieweb, jamieweb.net">
    <meta name="author" content="Jamie Scaife">
    <link href="/jamie.css" rel="stylesheet">
    <link href="https://www.jamieweb.net/blog/nghl-windows-guide/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>How to Install 'New Gauge Half-Life' on Windows</h1>
    <hr>
    <p><b>Wednesday 10th June 2015</b></p>
    <p>New Gauge Half-Life is a modified version of Half-Life 1 designed for speedrunning, created by rofi.</p>
    <p>Note that NGHL is no longer used for official speedrunning of Half-Life, its expansions or mods.</p>
    <p>Please see the rules at <a href="http://www.speedrun.com/hl1">speedrun.com/hl1</a> for legitimate competitive speedrunning.</p>
    <p>This is my own prefered configuration of NGHL, with Bunnymod Pro replacing the default game.</p>
    <p>Jump to step: <a href="#step1">#1: Downloads</a> | <a href="#step2">#2: NGHL Installation</a> | <a href="#step3">#3: Mods/Maps/Config</a> | <a href="#step4">#4: Launch Options</a> | <a href="#step5">#5: Starting the Game</a> | <a href="#step6">#6: Final Configuration</a> | <a href="#trouble">Troubleshooting</a></p>
    <p>Guide Created by Jamie Scaife 10th June 2015. Updated 29th September 2016, 26th February 2017 and 19th August 2017.</p>

    <h3 id="step1">Step #1: Downloads</h3>
    <p>Download all of the listed files and save them somewhere safe. This is everything that you need to install/set up NGHL.</p>
    <p>These files are not created or owned by me. All credit goes to the original authors. External download links are not hyperlinked.</p>
    <pre>########################################################################
<b>New Gauge Half-Life Installer</b> (Installer)

Name: NGHL_Full_v1_34.exe
Size: 196.8 MB (196,753,838 bytes)
MD5: 1a99a97a7f6309daad549264b1e8734c
SHA1: 6bb8de2a66be4dc71a57a6fb8e5b592da2119193
SHA256: 1dd5715962d40dc72242892ad0f15d05833cd7e865bc9b75265e9b450d7b13e3
VirusTotal: N/A - File Too Large
Link: http://ngageclan.ucoz.ru/load/nghl/12-1-0-41
########################################################################

########################################################################
<b>Bunnymod Pro (Mod)</b>

Name: bunnymodpro.zip
Size: 798.9 KB (818,023 bytes)
MD5: fcdd8b201f3cd481a8daf32ea9c4fca2
SHA1: 64f01783613317ad6bab5b2871a321032ccd5347
SHA256: cbb38bf58140bbfe0f62291025032e295f7aacd077e092293cc5c08b4046b917
VirusTotal: <a href="https://www.virustotal.com/en/file/cbb38bf58140bbfe0f62291025032e295f7aacd077e092293cc5c08b4046b917/analysis/" target="_blank">0/59 Detection Ratio</a>
Link: <a href="https://www.jamieweb.net/downloads/bunnymodpro.zip" target="_blank">https://www.jamieweb.net/downloads/bunnymodpro.zip</a>
########################################################################

########################################################################
<b>Bunnyrace Beta 2</b> (Map)

Name: bunnyrace_beta2.bsp
Size: 2.7 MB (2,803,500 bytes)
MD5: 2cff96007a35332cef81be81e0756bf9
SHA1: d16f54b1b8554b2853355ba900c21597caeaf1a1
SHA256: 1b5cb500b41b5383fe6865347c4fe7cc3cc3bb3b2438dc10d5fde1c68f0c21ba
VirusTotal: <a href="https://www.virustotal.com/en/file/1b5cb500b41b5383fe6865347c4fe7cc3cc3bb3b2438dc10d5fde1c68f0c21ba/analysis/">0/55 Detection Ratio</a>
Link: <a href="https://www.jamieweb.net/downloads/bunnyrace_beta2.bsp" target="_blank">https://www.jamieweb.net/downloads/bunnyrace_beta2.bsp</a>
########################################################################

########################################################################
<b>AdrenalineGamer Longjump 2 (Map)</b>

Name: ag_longjump2.bsp
Size: 2.2 MB (2,297,864 bytes)
MD5: 939d0b2236e257ae2a602badf8268640
SHA1: 7f7748894fd4f65ed932cb3abf9ea00608c2ae5c
SHA256: f0ac72b26f6ca157b54c14dd2801c243856d055c589a4882063d3597616091a2
VirusTotal: <a href="https://www.virustotal.com/en/file/f0ac72b26f6ca157b54c14dd2801c243856d055c589a4882063d3597616091a2/analysis/">0/56 Detection Ratio</a>
Link: <a href="https://www.jamieweb.net/downloads/ag_longjump2.bsp" target="_blank">https://www.jamieweb.net/downloads/ag_longjump2.bsp</a>
########################################################################

########################################################################
<b>AdrenalineGamer Tricks</b> (Map)

Name: agtricks.rar
Size: 1.3 MB (1,362,329 bytes)
MD5: c5115555faa62eabe48c3ffeb743d984
SHA1: 648e68b0d83fb1012e87cc3cd7e122a144a5990e
SHA256: a6d2e31f844b71575169f2df82b979cd0726bf143f85467cfffe6309482a7085
VirusTotal: <a href="https://www.virustotal.com/en/file/a6d2e31f844b71575169f2df82b979cd0726bf143f85467cfffe6309482a7085/analysis/">0/55 Detection Ratio</a>
Link: https://dl.dropboxusercontent.com/u/9297051/agtricks.rar
########################################################################

########################################################################
<b>Deathmatch Classic WAD</b> (Texture File)

Name: dmc.wad
Size: 2.1 MB (2,252,124 bytes)
MD5: dff62c4444247a77f435f63476515528
SHA1: c83c5106aa4a67909d41accdf25545907120acac
SHA256: 20df9be175665dc27f0603cb6bd6ab2a60c4e597267ba8353fe6419ea32f9736
VirusTotal: <a href="https://www.virustotal.com/en/file/20df9be175665dc27f0603cb6bd6ab2a60c4e597267ba8353fe6419ea32f9736/analysis/">0/53 Detection Ratio</a>
Link: http://www.dusty-clan.net/download.php?view.595
########################################################################</pre>

    <h3 id="step2">Step #2: NGHL Installation</h3>
    <p><b>a.</b> Run 'NGHL_Full_v1_34.exe'. The NGHL installation wizard should appear.</p>
    <p><b>b.</b> Proceed through the installation process. Set the install directory to 'NGHL'. When asked to select components: Select the default Half-Life DLLs. Deselect everything except for the Cyrillic font fix.</p>
    <p><b>c.</b> Wait for the installation to finish. Do not open the game yet.</p>

    <h3 id="step3">Step #3: Mods/Maps/Config</h3>
    <p><b>a.</b> Extract the 'bunnymodpro.zip' file into the '\Program Files (x86)\NGHL\valve' folder, and overwrite all files when prompted.</p>
    <p><b>b.</b> Move 'dmc.wad' into '\Program Files (x86)\NGHL\valve'. This file is required to load the textures on bunnyrace_beta2.</p>
    <p><b>c.</b> Extract the files: 'ag_longjump2.rar' and 'agtricks.rar', move the resulting .bsp files into '\Program Files (x86)\NGHL\valve\maps' and move 'aw_agctf.wad' into '\Program Files (x86)\NGHL\valve'.</p>
    <pre><b>bunnyrace_beta2.bsp</b> - A large bunnyhop racetrack/course.
<b>agtricks.bsp</b> - Bunnyhop course with multiple stages.
<b>ag_longjump2.bsp</b> - Longjump/strafe/object boost practise.</pre>
    <p><b>d.</b> Edit the file '\Program Files (x86)\NGHL\valve\userconfig.cfg'. This file contains all of the custom scripts and settings to (speed)run the game properly. Set the file contents to be the following:</p>
    <pre>clockwindow 0                          //remove short lag after loading
default_fov 110                        //view angle (field of view)
developer 1                            //developer messages in the console (off)
gl_texturemode GL_LINEAR_MIPMAP_LINEAR //disable ugly 'stairs effect' on textures
MP3FadeTime 0.0                        //prevent music from playing forever
cl_showfps 1                           //show the game fps

//bunnyhop script
alias +bhop "alias _special _h;_h"
alias _h "+jump;wait;-jump;wait;special"
alias -bhop "alias _special"

//climb script
alias +climb "+duck;wait;-duck;wait;+duck"
alias -climb -duck

//gauss boost script
alias gauss "cl_pitchup 180;cl_pitchdown -180;-attack2;wait;cl_pitchup -12;cl_pitchdown 12;wait;cl_pitchup 89.999;cl_pitchdown 89.999"

//object boost script
alias obbo2000 "+use;w12;-use;+jump;w;-jump"

//zoom
alias "+fov" "default_fov 35"
alias "-fov" "default_fov 110"

//wait table
alias "w" "wait"
alias "w2" "w;w"
alias "w3" "w2;w"
alias "w6" "w3;w3"
alias "w12" "w6;w6"</pre>
    <p>Thanks to quadrazid on the SourceRuns.org forum for the gauss boost, object boost and wait table scripts.</p>
    <p>If you want to add your own scripts or configuration, edit this file.</p>
    <p><b>e.</b> Edit the file '\Program Files (x86)\NGHL\valve\liblist.gam'. Change the "game" value from "Bunnymod Pro" to "Half-Life".</p>
    <pre>game "Half-Life"</pre>
    <p>This will allow you to edit your player settings, such as name, model, colours, etc.</p>

    <h3 id="step4">Step #4: Launch Options</h3>
    <p><b>a.</b> Right click the NGHL shortcut, go to 'Properties', and add the following launch options to the target file:</p>
    <pre>-noforcemparms -noipx -nojoy -noforcemaccel -noforcemspd</pre>

    <h3 id="step5">Step #5: Starting the Game</h3>
    <p><b>a.</b> Run the game using the desktop/start menu shortcut, or directly from '\Program Files (x86)\NGHL\hl.exe'.</p>
    <p><b>b.</b> The game should appear. Open the video settings and set your renderer to 'Hardware', and then the resolution/aspect ratio that you desire.</p>
    <p>Now you should be free to play the game, set your controls, change any settings, etc.</p>

    <h3 id="step6">Step #6: Final Configuration</h3>
    <p>Set up your binds for object boosting, gauss boosting and zoom. Use ` (grave/backtick) to open the console and execute the following:</p>
    <pre>bind "key" "obbo2000"
bind "key" "gauss"
bind "key" "+zoom"</pre>
    <p>Replace "key" with your desired key.</p>
    <p>To perform a gauss boost using the gauss cannon, charge the cannon by holding right click, look in the direction you want to go and press the key that you set.</p>
    <p>To perform an object boost, stand infront of an object, hold down the directional key of which direction you want to go and press the key that you set.</p>
    <p>By default, holding down the spacebar will automatically spam jump. You can rebind this in the in-game options menu.</p>
    <p>Use the console command 'map c1a0' to start a new game, skipping the tram ride intro.</p>
    <p>When loading maps for the first time, you may encounter a message saying 'Node graph out of date, rebuilding...'. Just ignore this message, it means that it is setting up the pathfinding for NPCs.</p>
    <p>On the game HUD, the top number in the middle shows the speed of your previous jump, and the bottom number shows your current speed.</p>
    <p>If you would like to hide the demo timer (the numbers at the middle left of your HUD), execute "hud_demorec_counter 0".</p>

    <h3 id="trouble">Troubleshooting</h3>
    <p>If you launch the game and your sounds are slow, delayed or non-existent, restarting the game will normally fix it.</p>
    <p>Sometimes, bad nodegraphs will be generated for maps causing certain NPC related actions not to work properly. Examples of this include Barney opening the door in c1a2b (Office Complex, door to skip the freezer room and vents section), and the scientist opening the door in c3a2d (Lambda Complex, supply room before Xen teleporter). In order to fix this, simply delete the associated node graph files from /valve/maps/graphs/ and they should be regenerated correctly next time the map is loaded.</p>
</div>

<?php include "footer.php" ?>

</body>

</html>
