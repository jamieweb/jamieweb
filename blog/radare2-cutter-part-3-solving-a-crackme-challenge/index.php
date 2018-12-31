<?php include "response-headers.php"; content_security_policy(); ?>
<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Part 3: Solving a Crackme Challenge - Introduction to Reverse Engineering with radare2 Cutter</title>
    <meta name="description" content="Solving a beginner crackme challenge using using radare2 Cutter.">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/blog/radare2-cutter-part-3-solving-a-crackme-challenge/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1 class="no-mar-bottom">Introduction to Reverse Engineering with radare2 Cutter</h1>
    <h2 class="subtitle-mar-top">Part 3: Solving a Crackme Challenge</h2>
    <hr>
    <p><b>Thursday 3rd January 2019</b></p>
    <div class="display-flex flex-justify-space-between">
        <div>
            <p class="no-mar-top">This is part 3 of a 3 part series on reverse engineering with Cutter:</p>
            <ul class="spaced-list">
                <li><b>Part 1:</b> <a href="/blog/radare2-cutter-part-1-key-terminology-and-overview" target="_blank">Key Terminology and Overview</a></li>
                <li><b>Part 2:</b> <a href="/blog/radare2-cutter-part-2-analysing-a-basic-program" target="_blank">Analysing a Basic Program</a></li>
                <li><b>Part 3:</b> Solving a Crackme Challenge (You Are Here)</li>
            </ul>
        </div>
        <div class="display-flex flex-align-center flex-justify-center flex-direction-column">
            <img class="max-width-35-vw" src="/blog/radare2-cutter-part-1-key-terminology-and-overview/cutter-logo.png" width="135px" title="Cutter Logo" alt="Cutter Logo">
            <p class="no-mar-top centertext"><i>The Cutter logo.</i></p>
        </div>
    </div>
    <p class="no-mar-top">Cutter can be found on GitHub here: <b><a href="https://github.com/radareorg/cutter" target="_blank" rel="noopener">https://github.com/<wbr>radareorg/cutter</a></b></p>
    <p><b>Skip to Section:</b></p>
    <pre><b>Introduction to Reverse Engineering with radare2 Cutter
Part 3: Solving a Crackme Challenge</b>
&#x2523&#x2501&#x2501 <a href="#what-is-a-crackme">What is a crackme?</a>
&#x2523&#x2501&#x2501 <a href="#sam-crackme">Sam's Crackme</a>
&#x2523&#x2501&#x2501 <a href="#initial-observations">Initial Observations</a>
&#x2523&#x2501&#x2501 <a href="#analysing-the-binary-in-cutter">Analysing the Program in Cutter</a>
&#x2523&#x2501&#x2501 <a href="#deciphering-the-password">Deciphering the Password</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>

    <h2 id="what-is-a-crackme">What is a crackme?</h2>

</div>

<?php include "footer.php" ?>

</body>

</html>











