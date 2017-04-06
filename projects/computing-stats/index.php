<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Computing Stats</title>
    <meta name="description" content="Raspberry Pi Cluster + BOINC Stats">
    <meta name="keywords" content="Jamie, Scaife, jamie scaife, jamiescaife, jamieonubuntu, jamie90437, jamie90437x, jamieweb, jamieweb.net">
    <meta name="author" content="Jamie Scaife">
    <link href="/jamie.css" rel="stylesheet">
    <link href="https://www.jamieweb.net/projects/computing-stats/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1 class="two-mar-bottom">Raspberry Pi Cluster Stats</h1>
    <table width="100%">
        <tr>
            <!-- Note to self: Fix the ridiculous number of classes here. -->
            <td bgcolor="limegreen" width="20%"><center><h2>Master</h2></center></td>
            <td bgcolor="limegreen" width="20%"><center><h2>Node 1</h2></center></td>
            <td bgcolor="limegreen" width="20%"><center><h2>Node 2</h2></center></td>
            <td bgcolor="limegreen" width="20%"><center><h2>Node 3</h2></center></td>
            <td bgcolor="limegreen" width="20%"><center><h2>Node 4</h2></center></td>
        </tr>
        <tr>
            <td width="20%"><p class="info">CPU: <b>99%</b></p>
            <p class="info">Memory: <b>922 MB</b></p>
            <p class="info">Disk: <b>4315 MB</b></p>
            <p class="info">Temp: <b>33.6'C</b></td>

            <td width="20%"><p class="info">CPU: <b>99.7%</b></p>
            <p class="info">Memory: <b>252 MB</b></p>
            <p class="info">Disk: <b>4369 MB</b></p>
            <p class="info">Temp: <b>35.8'C</b></td>

            <td width="20%"><p class="info">CPU: <b>99.7%</b></p>
            <p class="info">Memory: <b>249 MB</b></p>
            <p class="info">Disk: <b>4304 MB</b></p>
            <p class="info">Temp: <b>39.0'C</b></td>

            <td width="20%"><p class="info">CPU: <b>99.7%</b></p>
            <p class="info">Memory: <b>250 MB</b></p>
            <p class="info">Disk: <b>4304 MB</b></p>
            <p class="info">Temp: <b>41.2'C</b></td>

            <td width="20%"><p class="info">CPU: <b>99.7%</b></p>
            <p class="info">Memory: <b>251 MB</b></p>
            <p class="info">Disk: <b>4368 MB</b></p>
            <p class="info">Temp: <b>40.1'C</b></td>
        </tr>
    </table><br>

    <table width="100%">
        <tr>
            <td width="50%"><h1 class="info">Rosetta@Home Stats</h1>
            <p class="info">Total Earned Credits: <b>58,151.78</b></p>
            <p class="info">Recent Average Credit: <b>368.14</b></p>
            <p class="info">Total Running Time: <b>150 days</b></p></td>

            <td width="50%"><h1 class="info">Einstein@Home Stats</h1>
            <p class="info">Total Earned Credits: <b>152,658.53</b></p>
            <p class="info">Recent Average Credit: <b>442.39</b></p>
            <p class="info">Total Running Time: <b>551 days</b></p></td>
        </tr>
        <tr>
            <td width="50%" class="stats-padding-top"><h1 class="info">Bitcoin Node Stats</h1>
            <p class="info">Bitnodes Link: <b><a href="https://bitnodes.21.co/nodes/89.34.99.41-8333/">https://bitnodes.21.co/nodes/89.34.99.41-8333/</a></b></p>
            <p class="info">Total Running Time: <b>153 days</b></p></td>
        </tr>
    </table><br>
    <p class="info two-mar-left">Stats Update Every 10 Minutes. Last Updated: <b> 5:20:05am GMT</b></p>
</div>

<?php include "footer.php" ?>

</body>

</html>
