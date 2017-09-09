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
            <td width="20%"><p class="info">CPU: <b>96.8%</b></p>
            <p class="info">Memory: <b>912 MB</b></p>
            <p class="info">Disk: <b>4534 MB</b></p>
            <p class="info">Temp: <b>41.2'C</b></td>

            <td width="20%"><p class="info">CPU: <b>99.8%</b></p>
            <p class="info">Memory: <b>347 MB</b></p>
            <p class="info">Disk: <b>3953 MB</b></p>
            <p class="info">Temp: <b>42.8'C</b></td>

            <td width="20%"><p class="info">CPU: <b>99.7%</b></p>
            <p class="info">Memory: <b>343 MB</b></p>
            <p class="info">Disk: <b>3952 MB</b></p>
            <p class="info">Temp: <b>47.1'C</b></td>

            <td width="20%"><p class="info">CPU: <b>99.8%</b></p>
            <p class="info">Memory: <b>343 MB</b></p>
            <p class="info">Disk: <b>3952 MB</b></p>
            <p class="info">Temp: <b>47.6'C</b></td>

            <td width="20%"><p class="info">CPU: <b>99.7%</b></p>
            <p class="info">Memory: <b>345 MB</b></p>
            <p class="info">Disk: <b>3954 MB</b></p>
            <p class="info">Temp: <b>47.1'C</b></td>
        </tr>
    </table><br>

    <table width="100%">
        <tr>
            <td width="50%"><h1 class="info">Rosetta@Home Stats</h1>
            <p class="info">Total Earned Credits: <b>115,381.67</b></p>
            <p class="info">Recent Average Credit: <b>334.50</b></p>
            <p class="info">Total Running Time: <b>306 days</b></p></td>

            <td width="50%"><h1 class="info">Einstein@Home Stats</h1>
            <p class="info">Total Earned Credits: <b>221,096.03</b></p>
            <p class="info">Recent Average Credit: <b>437.80</b></p>
            <p class="info">Total Running Time: <b>706 days</b></p></td>
        </tr>
        <tr>
            <td width="50%" class="stats-padding-top"><h1 class="info">Bitcoin Node Stats</h1>
            <p class="info clearboth">Bitnodes Link: <b><a href="https://bitnodes.21.co/nodes/89.34.99.41-8333/" target="_blank">https://bitnodes.21.co/nodes/89.34.99.41-8333/</a></b></p>
            <p class="info">Total Running Time: <b>309 days</b></p></td>
        </tr>
    </table><br>
    <p class="info two-mar-left">Stats Update Every 10 Minutes. Last Updated: <b> 3:40:05pm GMT+1</b></p>
</div>

<?php include "footer.php" ?>

</body>

</html>
