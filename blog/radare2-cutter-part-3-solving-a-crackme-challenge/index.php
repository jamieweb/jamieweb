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
&#x2523&#x2501&#x2501 <a href="#a-crackme-challenge">A Crackme Challenge</a>
&#x2523&#x2501&#x2501 <a href="#initial-observations">Initial Observations</a>
&#x2523&#x2501&#x2501 <a href="#analysing-the-program-in-cutter">Analysing the Program in Cutter</a>
&#x2523&#x2501&#x2501 <a href="#deciphering-the-password">Deciphering the Password</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>

    <h2 id="what-is-a-crackme">A Crackme Challenge</h2>
    <p>Last year, I asked my friend Sam to make a basic crackme challenge for me to solve and then demonstrate in this series.</p>
    <p>He kindly agreed, and put together a simple password-based crackme. It looks like the following when run:</p>
    <pre>malw@re:~$ ./crackme
Enter Password (or q to quit): helloworld
Access Denied
Enter Password (or q to quit): Pa$$w0rd
Access Denied
Enter Password (or q to quit): q</pre>
    <p>In this third and final part, we will solve the crackme using Cutter and some other tools. <b>If you'd like to have a go yourself first,</b> it is available on GitLab <a href="https://gitlab.com/jamieweb/crackme-challenge" target="_blank" rel="noopener">here</a>.</p>
    <p>It is a beginner difficulty crackme, and most of the knowledge needed to solve it is present in the previous two blog posts (<a href="/blog/radare2-cutter-part-1-key-terminology-and-overview/" target="_blank">1</a>, <a href="/blog/radare2-cutter-part-2-analysing-a-basic-program/" target="_blank">2</a>) in the series.</p>
    <p><b>Please note that the <code>source.cpp</code> file is not obfuscated, so looking at it will potentially reveal the solution.</b> For the best experience, compile the code without looking at the source file. Obviously running untrusted code from the internet goes against every security best-practise out there, so either use a dedicated and segregated malware analysis machine, or ask a trusted friend to check the code first.</p>

    <h2 id="initial-observations">Initial Observations</h2>
    <p>Before diving straight in and opening the file in Cutter, it's extremely valuable to try to make some initial high-level observations based entirely on the functionality of the program.</p>
    <p>Like any form of security testing, by manipulating inputs and performing unexected actions, you can gain a pretty deep insight into how the program works and what it is doing. For example, you may be able to spot where there is a loop, or which conditions cause the program to terminate earlier than expected.</p>
    <p>Let's have a go... if you run the program and enter a random password:</p>
    <pre>malw@re:~$ ./crackme
Enter Password (or q to quit): 123456
Access Denied
Enter Password (or q to quit):</pre>
    <p>...you can see that it outputs "Access Denied" with a newline on the end, then prompts for the password again.</p>
    <p>There are multiple different programming constructs that could be causing this behaviour, such as <code>while</code>, <code>if</code>/<code>else</code> with some <code>goto</code>s, <code>try</code>/<code>catch</code>, etc. Ultimately it's probably a combination of multiple.</p>
    <p>However, what happens if you stop giving the program an input? In other words, close stdin. This is usually done by issuing Ctrl+D to your terminal:</p>
    <pre>malw@re:~$ ./crackme
Enter Password (or q to quit): Access Denied
Enter Password (or q to quit): Access Denied
Enter Password (or q to quit): Access Denied
Enter Password (or q to quit): Access Denied
Enter Password (or q to quit): Access Denied
Enter Password (or q to quit): Access Denied
Enter Password (or q to quit): Access Denied</pre>
    <p>...you get the idea - it loops infinitely. This doesn't tell you anything with certainty, but you can tell that there is definitely some sort of loop in there causing it to do this.</p>
    <p>Another area that we can look into is how the program handles the "q to quit" functionality. There are two main ways that this can be done - requiring return (enter) to be pressed (like a normal shell prompt), or actively listening for <code>q</code> on stdin, like <code>less</code> or <code>top</code> does.</p>
    <p>In the case of this program, you are required to press return in order to quit the program. This knowledge gives you further insight into the design of the program, primarily the fact that it only properly reads/processes the input when a newline character is encountered. If the alternate method were in use where pressing return is not required, the internal logic of the program may be more complicated, which would be something to look out for.</p>
    <p>Finally, we can check whether very large inputs cause the program to crash, which could help to indicate which functions are being used in the program to process input:</p>
    <pre>malw@re:~$ printf '%.sa' {1.10000000} | ./crackme</pre>
    <p>This will send 10 Megabytes of <code>a</code> characters to the program. In my case, the program didn't crash - it successfully processed the data and then started looping infinitely as stdin had closed. If you are using a very old compiler or system, your results could differ, but for modern systems they probably won't.</p>

    <h2 id="analysing-the-program-in-cutter">Analysing the Program in Cutter</h2>
    <p></p>

</div>

<?php include "footer.php" ?>

</body>

</html>











