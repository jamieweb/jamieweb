<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Computing Stats</title>
    <meta name="description" content="Raspberry Pi Cluster + BOINC Stats">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/projects/computing-stats/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1 class="two-mar-bottom">Raspberry Pi Cluster Stats</h1>
    <table width="100%">
        <tr>
            <!-- Note to self: Fix the ridiculous number of classes here. -->
            <td bgcolor="limegreen" width="20%"><div class="centertext"><h2>Master</h2></div></td>
            <td bgcolor="var-node1colour" width="20%"><div class="centertext"><h2>Node 1</h2></div></td>
            <td bgcolor="var-node2colour" width="20%"><div class="centertext"><h2>Node 2</h2></div></td>
            <td bgcolor="var-node3colour" width="20%"><div class="centertext"><h2>Node 3</h2></div></td>
            <td bgcolor="var-node4colour" width="20%"><div class="centertext"><h2>Node 4</h2></div></td>
        </tr>
        <tr>
            <td width="20%"><p class="info">CPU: <b>var-mastercpu</b></p>
            <p class="info">Memory: <b>var-masterram MB</b></p>
            <p class="info">Disk: <b>var-masterdisk</b></p>
            <p class="info">Temp: <b>var-mastertemp</b></td>

            <td width="20%"><p class="info">CPU: <b>var-node1cpu</b></p>
            <p class="info">Memory: <b>var-node1ram MB</b></p>
            <p class="info">Disk: <b>var-node1disk</b></p>
            <p class="info">Temp: <b>var-node1temp</b></td>

            <td width="20%"><p class="info">CPU: <b>var-node2cpu</b></p>
            <p class="info">Memory: <b>var-node2ram MB</b></p>
            <p class="info">Disk: <b>var-node2disk</b></p>
            <p class="info">Temp: <b>var-node2temp</b></td>

            <td width="20%"><p class="info">CPU: <b>var-node3cpu</b></p>
            <p class="info">Memory: <b>var-node3ram MB</b></p>
            <p class="info">Disk: <b>var-node3disk</b></p>
            <p class="info">Temp: <b>var-node3temp</b></td>

            <td width="20%"><p class="info">CPU: <b>var-node4cpu</b></p>
            <p class="info">Memory: <b>var-node4ram MB</b></p>
            <p class="info">Disk: <b>var-node4disk</b></p>
            <p class="info">Temp: <b>var-node4temp</b></td>
        </tr>
    </table><br>
    <p class="info">Stats Update Every 10 Minutes. Last Updated: <b>var-lastupdated GMT</b></p><br>
    <p class="info">System Status Message: <b><?php include "computing-stats-status-message.txt" ?></b></p><br>

    <h1 class="info">Current Project: <span class="currentproject">Einstein@Home</span></h1>
    <p>The cluster is currently running <a href="https://einsteinathome.org/" target="_blank" rel="noopener">Einstein@Home</a>, which is a distributed computing project that searches for gravitational waves using data from the LIGO gravitational wave detector.</p>

    <div class="computing-stats">
        <div class="computing-stats-half-width">
            <h1 class="info">Rosetta@Home Stats</h1>
            <p class="info">Total Earned Credits: <b>var-rosettacredit</b></p>
            <p class="info">Recent Average Credit: <b>var-rosettarecent</b></p>
            <p class="info">Total Running Time: <b>var-rosettaruntime days</b></p>
        </div>
        <div>
            <h1 class="info">Einstein@Home Stats</h1>
            <p class="info">Total Earned Credits: <b>var-einsteincredit</b></p>
            <p class="info">Recent Average Credit: <b>var-einsteinrecent</b></p>
            <p class="info">Total Running Time: <b>var-einsteinruntime days</b></p>
        </div>
        <div>
            <h1 class="info">Bitcoin Node Stats</h1>
            <p class="info clearboth">Bitnodes Link: <b><a href="https://bitnodes.earn.com/nodes/212.71.252.184-8333/" target="_blank" rel="noopener">https://bitnodes.earn.com/<wbr>nodes/<wbr>212.71.252.184-8333/</a></b></p>
            <p class="info">Total Running Time: <b>var-bitcoinnoderuntime days</b></p>
        </div>
    </div>
</div>

<?php include "footer.php" ?>

</body>

</html>
