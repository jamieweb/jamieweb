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
    <p><b>Saturday 5th January 2019</b></p>
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

    <h2 id="a-crackme-challenge">A Crackme Challenge</h2>
    <p>Last year, I asked my friend <a href="https://github.com/York20" target="_blank" rel="noopener">Sam</a> to write a basic crackme challenge for me to solve and then demonstrate in this series.</p>
    <p>He kindly agreed, and put together a simple password-based crackme. It looks like the following when run:</p>
    <pre>malw@re:~$ ./crackme
Enter Password (or q to quit): helloworld
Access Denied
Enter Password (or q to quit): Pa$$w0rd
Access Denied
Enter Password (or q to quit): q</pre>
    <p>In this third and final part of the series, we will solve the crackme using Cutter and some other tools. <b>If you'd like to have a go yourself first,</b> it is available on GitLab <a href="https://gitlab.com/jamieweb/crackme-challenge" target="_blank" rel="noopener">here</a>.</p>
    <p>It is a beginner difficulty crackme, and most of the knowledge needed to solve it is present in the first two parts of the series (<a href="/blog/radare2-cutter-part-1-key-terminology-and-overview/" target="_blank">1</a>, <a href="/blog/radare2-cutter-part-2-analysing-a-basic-program/" target="_blank">2</a>).</p>
    <p><b>Please note that the <code>source.cpp</code> file is not obfuscated, so looking at it will potentially reveal the solution.</b> For the best experience, compile the code without looking at the source file. Obviously running untrusted code from the internet goes against every security best-practice out there, so either use a dedicated and segregated malware analysis machine, or ask a trusted friend to check the code first.</p>

    <h2 id="initial-observations">Initial Observations</h2>
    <p>Before diving straight in and opening the file in Cutter, it's extremely valuable to try to make some initial high-level observations based entirely on the functionality of the program.</p>
    <p>Like any form of security testing, by manipulating inputs and performing unexpected actions, you can gain a pretty deep insight into how the program works and what it is doing. For example, you may be able to spot where there is a loop, or which conditions cause the program to terminate earlier than expected.</p>
    <p>Firstly we can try using the program without doing anything extreme or unexpected in order to see what the default/intended behaviour is:</p>
    <pre>malw@re:~$ ./crackme
Enter Password (or q to quit): 123456
Access Denied
Enter Password (or q to quit):</pre>
    <p>You can see that the program outputs "Access Denied" with a newline on the end, then prompts for the password again.</p>
    <p>There are multiple different programming constructs that could be causing this behaviour, such as <code>while</code>, <code>if</code>/<code>else</code> with some <code>goto</code>s, <code>try</code>/<code>catch</code>, etc. Ultimately it's probably a combination of multiple.</p>
    <p>However, what happens if you stop giving the program an input? In other words - close stdin. This is usually done by issuing Ctrl+D to your terminal:</p>
    <pre>malw@re:~$ ./crackme
Enter Password (or q to quit): Access Denied
Enter Password (or q to quit): Access Denied
Enter Password (or q to quit): Access Denied
Enter Password (or q to quit): Access Denied
Enter Password (or q to quit): Access Denied
Enter Password (or q to quit): Access Denied
Enter Password (or q to quit): Access Denied</pre>
    <p>...you get the idea - it loops infinitely. This doesn't tell you anything with certainty, but you can tell that there is definitely some sort of loop in there causing it to do this.</p>
    <p>Another area that we can look into is how the program handles the "q to quit" functionality. There are two main ways that this can be done - requiring return (enter) to be pressed (like a normal shell prompt), or actively listening for <code>q</code> on stdin, like the programs <code>less</code> or <code>top</code> do.</p>
    <p>In the case of this program, you are required to press return in order to quit the program. This knowledge gives you further insight into the design of the program, primarily the fact that it only properly reads/processes the input when a newline character is encountered. If the alternate method were in use where pressing return is not required, the internal logic of the program may be more complicated, which would be something to look out for.</p>
    <p>Finally, we can check whether very large inputs cause the program to crash, which could help to indicate which functions are being used in the program to process input. For example, the <a href="https://faq.cprogramming.com/cgi-bin/smartfaq.cgi?answer=1049157810&id=1043284351" target="_blank" rel="noopener">dangerous</a> <code>gets()</code> function could be used to read the inputted password, so sending a large input might help us to identify this.</p>
    <pre>malw@re:~$ printf '%.sa' {1.10000000} | ./crackme</pre>
    <p>This will send 10 Megabytes of <code>a</code> characters to the program. In my case, the program didn't crash - it successfully processed the data and then started looping infinitely as stdin had closed. If you are using a very old compiler or system, your results could differ, but for modern systems they probably won't.</p>

    <h2 id="analysing-the-program-in-cutter">Analysing the Program in Cutter</h2>
    <p>Now that we've gained some initial high-level insight into how the program roughly works, you can open it in Cutter and start having a look around:</p>
    <img class="radius-8" src="cutter-file-opened-disassembly-view-main.png" width="1000px" alt="A screenshot of the Cutter interface after opening the file, showing the disassembly view of the 'main' function.">
    <p>The ultimate goal of analysing the program in Cutter is to either find the password itself, or find how the password is determined or generated. The password could be stored as a raw string, it could be encoded in an arbitrary format or it might instead be derived from the input rather than simply being a comparison against a stored value.</p>
    <p>Before rushing straight into the assembly, we can have a look at the stringdump results, as this may give some initial clues:</p>
    <img class="radius-8" src="cutter-stringdump.png" width="1000px" alt="A screenshot of the stringdump output in Cutter, showing some human-readable English strings related to the crackme challenge program.">
    <p>As you can see, in the stringdump output there are some strings that stand out as particularly interesting or as human-readable English. Two of these we have already seen in the live program:</p>
    <pre>Enter Password (or q to quit): 
Access Denied</pre>
    <p>However there are also two new ones:</p>
    <pre>1568 1872 1632 1632 1616 1824 1776 1888 1616 1824 1632 1728 1776 1904 
Access Granted</pre>
    <p>The <code>Access Granted</code> string is probably what is output if the password is correct. We don't know for certain, but based entirely on context we can make this assumption for now. Some more advanced crackmes may try to throw you off with things like this, but this is only a beginner level challenge so that is unlikely.</p>
    <p>However, what we're <i>really</i> interested in is the long string of numbers...</p>
    <pre>1568 1872 1632 1632 1616 1824 1776 1888 1616 1824 1632 1728 1776 1904 </pre>
    <p>Looking at the string, you can see that the numerals 0 to 9 are included, as well as spaces at the end of each section (including the last one).</p>
    <p>This is our first lead - it could be the encoded password, or it could be something completely unrelated, so investigating further is required in order to help prove this theory either way.</p>
    <p>You can try double-clicking the interesting string in the stringdump view, but this doesn't always take you to a directly useful place in the program where the string is used.</p>
    <p>Instead, let's have a proper look at <code>main</code>:</p>
    <img class="radius-8" src="cutter-disassembly-crypto-function.png" width="1000px" alt="A screenshot of the disassembly view in Cutter, showing the 'main' function and some of the strings discovered earlier from the stringdump.">
    <p>Scrolling down just slightly in the disassembly view reveals some of the strings that we found earlier, most crucially the long list of decimal numbers. Since this is a basic program and we're looking at the strings in-use in <code>main</code>, it's highly likely that this is where the strings are actually used to perform a useful function in the program, rather than just being assigned or moved around at a low-level.</p>
    <p>Taking a look at the graph view also helps us to understand the flow of the program, and where each of these strings are used:</p>
    <img class="radius-8" src="cutter-graph-program-flow-overview.png" width="1000px" alt="A screenshot of the graph view in Cutter, showing the program flow of the 'main' function.">
    <p>If you look closely, you may also notice a <code>call</code> instruction to an interesting function name; <code>crypto_std</code>. This function name stands out because cryptography functions wouldn't normally be used in very basic programs like this, unless they are actually doing something with cryptography.</p>
    <p>In the case of this program, that could be the case. If the password is enciphered, the <code>crypto_std</code> function could well be the function responsible for performing the enciphering and deciphering. Let's take a closer look at it in the disassembly view:</p>
    <img class="radius-8" src="cutter-disassembly-crypto-shl.png" width="1000px" alt="A screenshot of the disassembly view in Cutter, showing the 'crypto' function with an 'shl' instruction highlighted.">
    <p>While looking through the assembly, I noticed an <code>shl</code> instruction with a hard-coded operand of <code>4</code>. By 'hard-coded operand', I am referring to the fact that the second operand of the instruction is not a reference to a register, rather it is a static value that doesn't change throughout the execution of the program. This stood out as it is quite uncommon to see hard-coded operands in basic programs, especially on less-common instructions such as <code>shl</code>.</p>
    <p>The <code>shl</code> instruction is used to perform bitwise shifts, or 'bitshifts' as they are more commonly referred to. The Intel syntax for <code>shl</code> is <code>shl dest, src</code>, where <code>dest</code> is the data to perform the bitshift on, and <code>src</code> is the number of bits to shift the data by.</p>
    <p>For example, <code>shl 01101100, 2</code> will result in <code>00011011</code>.</p>
    <p>This instruction could be related to the password enciphering, so we should investigate it further. In the graph view, you can see that it is part of a loop:</p>
    <img class="radius-8" src="cutter-graph-crypto-shl-loop.png" width="1000px" alt="A screenshot of the graph view in Cutter, showing a loop that's part of the 'crypto' function with an 'shl' instruction highlighted.">
    <p>Scrolling down slightly further reveals the section where the function returns as well:</p>
    <img class="radius-8" src="cutter-graph-crypto-return-condition.png" width="1000px" alt="A screenshot of the graph view in Cutter, showing part of the 'crypto' function including the section where the function returns.">
    <p>When analysing functions in the graph view, a good strategy is to find where the function returns with a <code>ret</code> instruction, and then work backwards in order work out which conditions need to be met for the return to take place.</p>
    <p>Taking a look at the graph view of <code>crypto_std</code>, we can see that at the start of each iteration of the loop, there is a test that takes place (<code>test al, al</code>) in order to determine whether to continue with the loop or return from the function.</p>
    <p>Based on the context of this function, such as where it is called and its high-level behaviour, it is fair to make a guess that the function is iterating over the long decimal string we discovered above, and shifting each character by 4 bits.</p>

    <h2 id="deciphering-the-password">Deciphering the Password</h2>
    <p>Now that we've got a strong lead, we can make an attempt at deciphering the password using the bitshift method.</p>
    <p>You can easily perform bitshifts using <a href="https://wiki.python.org/moin/BitwiseOperators" target="_blank" rel="noopener">Bitwise Operators</a> in Python 3. Let's try with the first section of the string, which is <code>1568</code>:</p>
    <pre>malw@re:~$ python3
Python 3.5.2 (default, Nov 12 2018, 13:43:14) 
[GCC 5.4.0 20160609] on linux
Type "help", "copyright", "credits" or "license" for more information.
>>> print(1568 >> 4)
98</pre>
    <p>This outputs <code>98</code> in decimal. If you want the output in hexadecimal instead, you can use <code>print(hex(1568 >> 4))</code>.</p>
    <p>Now we can compare this against as ASCII table to see whether it matches a character. You can use <code>man ascii</code> in your terminal to view an ASCII table, or find one online (such as <a href="https://ascii.cl/" target="_blank" rel="noopener">here</a>). I have included an excerpt of the relevant section:</p>
    <pre>Oct   Dec   Hex   Char    
──────────────────────────
142   98    62    b</pre>
    <p>As you can see, <code>98</code> or <code>0x62</code> is the letter <code>b</code>. This is promising, as that is a valid character that could be part of the password.</p>
    <p>Instead of checking each section manually, you can create a quick Python 3 loop to do it all for you:</p>
    <pre>for i in "1568 1872 1632 1632 1616 1824 1776 1888 1616 1824 1632 1728 1776 1904".split(" "):
    print(chr(int(i) &gt;&gt; 4))</pre>
    <p>This will split the long decimal string at each space into elements in an array, then iterate through it. Each iteration will convert the current element to an integer (<code>int(i)</code>), bitshift it 4 bits to the right (<code>&gt;&gt;</code>), then convert it into an ASCII character (<code>chr()</code>).</p>
    <p>When executing the program, it produces the following output:</p>
    <pre>malw@re:~$ python3 bitshift.py
b
u
f
f
e
r
o
v
e
r
f
l
o
w</pre>
    <p>And there we go... <code>bufferoverflow</code>!</p>
    <pre>malw@re:~$ ./crackme
Enter Password (or q to quit): bufferoverflow
Access Granted</pre>
    <p>That's it! The challenge is solved!</p>

    <h2 id="conclusion">Conclusion</h2>
    <p>I would like to send a big thanks to <a href="https://github.com/York20" target="_blank" rel="noopener">Sam</a> for creating this crackme challenge. It turned out to be a great beginner crackme!</p>
    <p>Please also check out the other two parts of this series:</p>
    <ul class="spaced-list">
        <li><b>Part 1:</b> <a href="/blog/radare2-cutter-part-1-key-terminology-and-overview/" target="_blank">Key Terminology and Overview</a></li>
        <li><b>Part 2:</b> <a href="/blog/radare2-cutter-part-2-analysing-a-basic-program/" target="_blank">Analysing a Basic Program</a></li>
    </ul>
    <p>Cutter can be found on GitHub at: <a href="https://github.com/radareorg/cutter" target="_blank" rel="noopener">radareorg/cutter</a></p>
    <p>There is an active Cutter group on Telegram which you can join at: <a href="https://t.me/r2cutter" target="_blank" rel="noopener">t.me/r2cutter</a></p>
    <p>You can also follow the Cutter team on Twitter: <a href="https://twitter.com/r2gui" target="_blank" rel="noopener">@r2gui</a></p>
    <p>I personally will be continuing to use Cutter as my go-to tool for reverse engineering - it's been great so far and it's under active development so many more great features and updates are to come!</p>
    <p>Finally, thank you to the radare2 and Cutter developers for creating and maintaining this software and allowing for a vibrant community to exist!</p>
</div>

<?php include "footer.php" ?>

</body>

</html>











