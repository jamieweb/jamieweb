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
            <td width="20%"><p class="info">CPU: <b>99.2%</b></p>
            <p class="info">Memory: <b>580 MB</b></p>
            <p class="info">Disk: <b>4583 MB</b></p>
            <p class="info">Temp: <b>37.4'C</b></td>

            <td width="20%"><p class="info">CPU: <b>99.7%</b></p>
            <p class="info">Memory: <b>352 MB</b></p>
            <p class="info">Disk: <b>4026 MB</b></p>
            <p class="info">Temp: <b>39.0'C</b></td>

            <td width="20%"><p class="info">CPU: <b>99.6%</b></p>
            <p class="info">Memory: <b>352 MB</b></p>
            <p class="info">Disk: <b>4027 MB</b></p>
            <p class="info">Temp: <b>41.2'C</b></td>

            <td width="20%"><p class="info">CPU: <b>99.7%</b></p>
            <p class="info">Memory: <b>408 MB</b></p>
            <p class="info">Disk: <b>4026 MB</b></p>
            <p class="info">Temp: <b>42.2'C</b></td>

            <td width="20%"><p class="info">CPU: <b>98.9%</b></p>
            <p class="info">Memory: <b>352 MB</b></p>
            <p class="info">Disk: <b>4027 MB</b></p>
            <p class="info">Temp: <b>42.2'C</b></td>
        </tr>
    </table><br>

    <table width="100%">
        <tr>
            <td width="50%"><h1 class="info">Rosetta@Home Stats</h1>
            <p class="info">Total Earned Credits: <b>129,268.55</b></p>
            <p class="info">Recent Average Credit: <b>187.38</b></p>
            <p class="info">Total Running Time: <b>355 days</b></p></td>

            <td width="50%"><h1 class="info">Einstein@Home Stats</h1>
            <p class="info">Total Earned Credits: <b>242,408.53</b></p>
            <p class="info">Recent Average Credit: <b>473.03</b></p>
            <p class="info">Total Running Time: <b>756 days</b></p></td>
        </tr>
        <tr>
            <td width="50%" class="stats-padding-top"><h1 class="info">Bitcoin Node Stats</h1>
            <p class="info clearboth">Bitnodes Link: <b><a href="https://bitnodes.21.co/nodes/89.34.99.41-8333/" target="_blank">https://bitnodes.21.co/nodes/89.34.99.41-8333/</a></b></p>
            <p class="info">Total Running Time: <b>358 days</b></p></td>
        </tr>
    </table><br>
    <p class="info two-mar-left">Stats Update Every 10 Minutes. Last Updated: <b>12:10:08am GMT</b></p>
</div>

<?php include "footer.php" ?>

</body>

</html>
