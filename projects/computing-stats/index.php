<?php include "response-headers.php"; content_security_policy();
//The stats ideally should all be stored in a JSON object, but this is quite an old pipeline so it would require a significant change and testing. Validation is performed before and after they reach the server to ensure security and order, so this setup is reliable (and marginally inefficient) for the time being.
function filter_stat($stat) {
    return(substr(filter_var($stat, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH), 0, 14));
}

foreach(array("master", "node1", "node2", "node3", "node4") as $stats) {
    $$stats = array_map("filter_stat", file("computing-stats/stats/" . $stats . ".txt", FILE_USE_INCLUDE_PATH | FILE_IGNORE_NEW_LINES));
}

$now = new DateTime('now'); ?>
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
            <td bgcolor="<?php echo $master[9]; ?>" width="20%"><div class="centertext"><h2>Node 1</h2></div></td>
            <td bgcolor="<?php echo $master[10]; ?>" width="20%"><div class="centertext"><h2>Node 2</h2></div></td>
            <td bgcolor="<?php echo $master[11]; ?>" width="20%"><div class="centertext"><h2>Node 3</h2></div></td>
            <td bgcolor="<?php echo $master[12]; ?>" width="20%"><div class="centertext"><h2>Node 4</h2></div></td>
        </tr>
        <tr>
            <td width="20%"><p class="info">CPU: <b><?php echo $master[0]; ?></b></p>
            <p class="info">Memory: <b><?php echo $master[1]; ?></b></p>
            <p class="info">Disk: <b><?php echo $master[2]; ?></b></p>
            <p class="info">Temp: <b><?php echo $master[3]; ?></b></td>

            <td width="20%"><p class="info">CPU: <b><?php echo $node1[0]; ?></b></p>
            <p class="info">Memory: <b><?php echo $node1[1]; ?> MB</b></p>
            <p class="info">Disk: <b><?php echo $node1[2]; ?></b></p>
            <p class="info">Temp: <b><?php echo $node1[3]; ?></b></td>

            <td width="20%"><p class="info">CPU: <b><?php echo $node2[0]; ?></b></p>
            <p class="info">Memory: <b><?php echo $node2[1]; ?> MB</b></p>
            <p class="info">Disk: <b><?php echo $node2[2]; ?></b></p>
            <p class="info">Temp: <b><?php echo $node2[3]; ?></b></td>

            <td width="20%"><p class="info">CPU: <b><?php echo $node3[0]; ?></b></p>
            <p class="info">Memory: <b><?php echo $node3[1]; ?> MB</b></p>
            <p class="info">Disk: <b><?php echo $node3[2]; ?></b></p>
            <p class="info">Temp: <b><?php echo $node3[3]; ?></b></td>

            <td width="20%"><p class="info">CPU: <b><?php echo $node4[0]; ?></b></p>
            <p class="info">Memory: <b><?php echo $node4[1]; ?> MB</b></p>
            <p class="info">Disk: <b><?php echo $node2[2]; ?></b></p>
            <p class="info">Temp: <b><?php echo $node3[3]; ?></b></td>
        </tr>
    </table><br>
    <p class="info">Stats Update Every 10 Minutes. Last Updated: <b><?php echo $master[8]; ?> GMT</b></p><br>
    <p class="info">System Status Message: <b><?php include "computing-stats-status-message.txt" ?></b></p><br>

    <h1 class="info">Current Project: <span class="currentproject">Einstein@Home</span></h1>
    <p>The cluster is currently running <a href="https://einsteinathome.org/" target="_blank" rel="noopener">Einstein@Home</a>, which is a distributed computing project that searches for gravitational waves using data from the LIGO gravitational wave detector.</p>

    <div class="computing-stats">
        <div class="computing-stats-half-width">
            <h1 class="info">Rosetta@Home Stats</h1>
            <p class="info">Total Earned Credits: <b><?php echo $master[4]; ?></b></p>
            <p class="info">Recent Average Credit: <b><?php echo $master[5]; ?></b></p>
            <p class="info">Total Running Time: <b><?php echo $now->diff(new DateTime('2016-11-07'))->format("%a"); ?> days</b></p>
        </div>
        <div>
            <h1 class="info">Einstein@Home Stats</h1>
            <p class="info">Total Earned Credits: <b><?php echo $master[6]; ?></b></p>
            <p class="info">Recent Average Credit: <b><?php echo $master[7]; ?></b></p>
            <p class="info">Total Running Time: <b><?php echo $now->diff(new DateTime('2015-10-04'))->format("%a"); ?> days</b></p>
        </div>
        <div>
            <h1 class="info">Bitcoin Node Stats</h1>
            <p class="info clearboth">Bitnodes Link: <b><a href="https://bitnodes.earn.com/nodes/212.71.252.184-8333/" target="_blank" rel="noopener">https://bitnodes.earn.com/<wbr>nodes/<wbr>212.71.252.184-8333/</a></b></p>
            <p class="info">Total Running Time: <b><?php echo $now->diff(new DateTime('2016-11-04'))->format("%a"); ?> days</b></p>
        </div>
    </div>
</div>

<?php include "footer.php" ?>

</body>

</html>
