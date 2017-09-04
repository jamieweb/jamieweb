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
            <td width="20%"><p class="info">CPU: <b>96.3%</b></p>
            <p class="info">Memory: <b>914 MB</b></p>
            <p class="info">Disk: <b>4576 MB</b></p>
            <p class="info">Temp: <b>43.3'C</b></td>

            <td width="20%"><p class="info">CPU: <b>97.2%</b></p>
            <p class="info">Memory: <b>353 MB</b></p>
            <p class="info">Disk: <b>4016 MB</b></p>
            <p class="info">Temp: <b>44.9'C</b></td>

            <td width="20%"><p class="info">CPU: <b>99.7%</b></p>
            <p class="info">Memory: <b>352 MB</b></p>
            <p class="info">Disk: <b>4015 MB</b></p>
            <p class="info">Temp: <b>48.7'C</b></td>

            <td width="20%"><p class="info">CPU: <b>99.7%</b></p>
            <p class="info">Memory: <b>354 MB</b></p>
            <p class="info">Disk: <b>4015 MB</b></p>
            <p class="info">Temp: <b>49.2'C</b></td>

            <td width="20%"><p class="info">CPU: <b>99.7%</b></p>
            <p class="info">Memory: <b>349 MB</b></p>
            <p class="info">Disk: <b>4015 MB</b></p>
            <p class="info">Temp: <b>49.2'C</b></td>
        </tr>
    </table><br>

    <table width="100%">
        <tr>
            <td width="50%"><h1 class="info">Rosetta@Home Stats</h1>
            <p class="info">Total Earned Credits: <b>113,816.08</b></p>
            <p class="info">Recent Average Credit: <b>335.05</b></p>
            <p class="info">Total Running Time: <b>301 days</b></p></td>

            <td width="50%"><h1 class="info">Einstein@Home Stats</h1>
            <p class="info">Total Earned Credits: <b>218,908.53</b></p>
            <p class="info">Recent Average Credit: <b>480.82</b></p>
            <p class="info">Total Running Time: <b>701 days</b></p></td>
        </tr>
        <tr>
            <td width="50%" class="stats-padding-top"><h1 class="info">Bitcoin Node Stats</h1>
            <p class="info">Bitnodes Link: <b><a href="https://bitnodes.21.co/nodes/89.34.99.41-8333/" target="_blank">https://bitnodes.21.co/nodes/89.34.99.41-8333/</a></b></p>
            <p class="info">Total Running Time: <b>304 days</b></p></td>
        </tr>
    </table><br>
    <p class="info two-mar-left">Stats Update Every 10 Minutes. Last Updated: <b> 7:42:15pm GMT+1</b></p>
</div>

<?php include "footer.php" ?>

</body>

</html>
