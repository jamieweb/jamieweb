<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Introduction to Reverse Engineering with radare2 Cutter</title>
    <meta name="description" content="An introduction to reverse engineering using the radare2 GUI Cutter.">
    <meta name="keywords" content="Jamie, Scaife, jamie scaife, jamiescaife, jamieonubuntu, jamie90437, jamie90437x, jamieweb, jamieweb.net">
    <meta name="author" content="Jamie Scaife">
    <link href="jamie.css" rel="stylesheet">
    <link href="https://www.jamieweb.net/blog/introduction-to-reverse-engineering-with-radare2-cutter/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Introduction to Reverse Engineering with radare2 Cutter</h1>
    <hr>
    <p><b>Saturday 22nd September 2018</b></p>
    <div class="display-flex">
        <div>
            <p class="no-mar-top">Cutter is an open-source graphical user interface for the radare2 reverse engineering framework. This article contains an introduction to reverse engineering with Cutter, including key terminology and an example of performing static analysis on a basic program.</p>
        <p>Cutter can be found on GitHub here: <b><a href="https://github.com/radareorg/cutter" target="_blank" rel="noopener">https://github.com/radareorg/cutter</a></b></p>
        </div>
        <div class="display-flex flex-align-center flex-justify-center flex-direction-column">
            <img src="cutter-logo.png" width="250px" title="Cutter Logo" alt="Cutter Logo">
            <p class="no-mar-top centertext"><i>The Cutter logo.</i></p>
        </div>
    </div>
    <img class="radius-8" src="cutter-interface-overview.png" width="1000px" title="The Cutter Interface" alt="Screenshot of the Cutter Interface">
    <p class="two-no-mar centertext"><i>The main Cutter interface.</i></p>
    <p><b>Skip to Section:</b></p>
    <pre><b>Introduction to Reverse Engineering with radare2 Cutter</b>
&#x2523&#x2501&#x2501 <a href="#what-are">What are radare2 and Cutter?</a>
&#x2523&#x2501&#x2501 <a href="#installing-cutter">Installing Cutter</a>
&#x2523&#x2501&#x2501 <a href="#key-terminology">Key Terminology</a>
&#x2523&#x2501&#x2501 <a href="#interface-and-tools">Interface and Tools</a>
&#x2503&nbsp;&nbsp;&nbsp;&#x2523&#x2501&#x2501 <a href="#dashboard-overview">Dashboard</a>
&#x2503&nbsp;&nbsp;&nbsp;&#x2523&#x2501&#x2501 <a href="#disassembly-overview">Disassembly</a>
&#x2503&nbsp;&nbsp;&nbsp;&#x2523&#x2501&#x2501 <a href="#graph-overview">Graph</a>
&#x2503&nbsp;&nbsp;&nbsp;&#x2523&#x2501&#x2501 <a href="#functions-overview">Functions</a>
&#x2503&nbsp;&nbsp;&nbsp;&#x2523&#x2501&#x2501 <a href="#strings-overview">Strings</a>
&#x2503&nbsp;&nbsp;&nbsp;&#x2523&#x2501&#x2501 <a href="#hexdump-overview">Hexdump</a>
&#x2503&nbsp;&nbsp;&nbsp;&#x2523&#x2501&#x2501 <a href="#pseudocode-overview">Pseudocode</a>
&#x2503&nbsp;&nbsp;&nbsp;&#x2523&#x2501&#x2501 <a href="#entrypoints-overview">Entry Points</a>
&#x2503&nbsp;&nbsp;&nbsp;&#x2523&#x2501&#x2501 <a href="#imports-overview">Imports</a>
&#x2503&nbsp;&nbsp;&nbsp;&#x2523&#x2501&#x2501 <a href="#symbols-overview">Symbols</a>
&#x2503&nbsp;&nbsp;&nbsp;&#x2517&#x2501&#x2501 <a href="#jupyter-overview">Jupyter Notebook</a>
&#x2523&#x2501&#x2501 <a href="#static-analysis">Analysing a Basic Program</a>
&#x2523&#x2501&#x2501 <a href="#dynamic-analysis">Dynamic Analysis</a>
&#x2523&#x2501&#x2501 <a href="#crackme">Crackme Challenges</a>
&#x2523&#x2501&#x2501 <a href="#sam-crackme">Sam's Crackme</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>

    <h2 id="what-are">What are radare2 and Cutter?</h2>
    <p>Radare2 is an open-source, command-line based reverse engineering framework for Linux, macOS, Windows and many other platforms. It includes a set of tools for reverse engineering and analysing binary files, primarily compiled programs (executables). Radare2 can be used to perform both static and dynamic analysis.</p>
    <img class="radius-8" src="radare2-interface.png" width="1000px" title="The radare2 Interface Running in the Command-line" alt="A screenshot of the radare2 interface running in the command-line.">
    <p class="two-no-mar centertext"><i>The radare2 command-line interface in disassembly view.</i></p>
    <p>Cutter is the official GUI for radare2, allowing you to make use of all of the features of the command-line version while being able to better organise the information on your screen and make use of additional tools such as the built-in Jupyter notebook.</p>
    <p>Development of Cutter, which was originally named Iaito, started in March 2017. Since then there have been 9 major releases, with the latest version at the time of writing being 1.7.1.</p>

    <h2 id="installing-cutter">Installing Cutter</h2>
    <p>Cutter can be acquired in either source or binary form from the official GitHub repository: <a href="https://github.com/radareorg/cutter" target="_blank" rel="noopener">https://github.com/radareorg/cutter</a></p>
    <p>Each release is available as an AppImage (for Linux), DMG (for macOS) and a ZIP containing an EXE (for Windows). The source code is also available if you to wish to compile Cutter yourself.</p>
    <p>Unfortunately it's not easy to verify the integrity of the Cutter releases. GPG signatures are not provided, and commits are not reliably signed. Plain hashes are also not available. I have opened an issue about this <a href="https://github.com/radareorg/cutter/issues/666" target="_blank" rel="noopener">here</a>.</p>

    <h2 id="interface-and-tools">Interface and Tools</h2>
    <p>Once you have downloaded Cutter (and installed if required), you can run it and choose a file to analyse.</p>
    <img class="radius-8" src="cutter-open-file.png" width="1000px" title="Choosing a file to open in Cutter" alt="A screenshot of the interface for choosing a file to open in Cutter.">
    <p class="two-no-mar centertext"><i>Choosing a file to open in Cutter.</i></p>
    <p>If you just want to get Cutter working and analyse a file, a good starting choice could be a basic system tool/program such as <code>pwd</code>, <code>true</code> or <code>whoami</code>.</p>
    <p>After selecting a file, Cutter will allow you to specify the analysis settings. In most cases, these can be left as the default.</p>
    <img class="radius-8" src="cutter-analysis-settings.png" width="1000px" title="Choosing the Analysis Settings in Cutter" alt="A screenshot of the interface for choosing the analysis settings in Cutter.">
    <p class="two-no-mar centertext"><i>Choosing the analysis settings in Cutter.</i></p>
    <p>After clicking 'Ok', Cutter will proceed to analyse the file and then the main Cutter interface will appear.</p>
    <img class="radius-8" src="cutter-default-layout.png" width="1000px" title="The Default Cutter Interface Layout" alt="A screenshot of the default interface layout of Cutter.">
    <p class="two-no-mar centertext"><i>The default Cutter interface layout.</i></p>
    <p>At first, this interface looks very daunting and may be overwhelming. There is lots of information being displayed and many menus available, however in most cases only a few sections and tools are actually needed.</p>
    <p>The central panel with the tabs at the bottom is where most of your work will take place. The panels around the edge provide supporting information and other tools.</p>

    <h3 id="dashboard-overview">Dashboard</h3>
    <p>The dashboard tab contains an overview of the file that you are currently analysing, including the file format, size, architechture type and the libraries that it is using.</p>
    <img class="radius-8" src="cutter-dashboard.png" width="1000px" title="The Cutter Dashboard" alt="A screenshot of the Cutter dashboard.">

    <h3 id="disassembly-overview">Disassembly</h3>
    <p>The disassembly panel shows the disassembled machine code of the program. This is known as assembly language, and contains raw instructions such as <code>mov</code>, <code>push</code> and <code>call</code> and the arguments that go along with them.</p>
    <p>You can change the text size in the disassembly view using Ctrl + Shift + "+" (to increase) and Ctrl + "-" (to decrease).</p>
    <img class="radius-8" src="cutter-disassembly.png" width="1000px" title="The Cutter Disassembly View" alt="A screensht of the Cutter disassembly view.">
    <p>In the x86_64 instruction set, there are a large number of unique instructions. The number varies depending on how you define an instruction, but it ranges from almost 1000 to significantly more than 1000. Stefan Heule has <a href="https://stefanheule.com/blog/how-many-x86-64-instructions-are-there-anyway/" target="_blank" rel="noopener"> an interesting article</a> on this if you're interested in how these numbers are calculated.</p>
    <p>In practise though, only a small subset of these instructions are frequently seen. After a short while you will easily pick up the top 20 or 30 instructions, and this is all you will need for most analysis tasks. I have included a list of 'popular' instructions below for reference:</p>
    <ul>
        <li><code>mov</code> <b>(Move)</b> - Move data between registers and RAM.</li>
        <li><code>push</code> <b>(Push)</b> - Push a value onto the stack.</li>
        <li><code>call</code> <b>(Call)</b> - Call a procedure.</li>
        <li><code>ret</code> <b>(Return)</b> - Return from a procedure.</li>
        <li><code>add</code> <b>(Add)</b> - Add two values.</li>
        <li><code>cmp</code> <b>(Compare)</b> - Compare two values.</li>
        <li><code>lea</code> <b>(Load Effective Address)</b> - Load a memory address from source into destination.</li>
        <li><code>jmp</code> <b>(Jump)</b> - Jump to the specified point in the program.</li>
        <li><code>jne</code> <b>(Jump Not Equal)</b> - Jump if the previous test is not equal to zero.</li>
        <li><code>xor</code> <b>(Exclusive OR)</b> - Perform a logical exclusive OR.</li>
        <li><code>hlt</code> <b>(Halt)</b> - Stop instruction execution.</li>
    </ul>
    <p>Most instructions require operands, which are essentially arguments to the instruction that define and modify its behaviour. For example in the <code>mov</code> instruction below, there are two operands, <i>destination</i> and <i>source</i>:</p>
    <pre>mov rbx, rax</pre>
    <p>The order of the operands depends on the syntax being used. In the Intel syntax, the first operand is the destination, and the second operand is the source:</p>
    <pre>mov destination, source</pre>
    <p>However, in the AT&T syntax, this is the other way around:</p>
    <pre>movq %rax, %rbx</pre>
    <p>You may also notice that there are additional differences between the Intel and AT&T syntaxes, such as the percentage sign in front of the operands and the mnemonic displaying as <code>movq</code> (Move Quadword, since rax and rbx are both full 64-bit registers), rather than just <code>mov</code>. In the case of 32-bit registers, the the <code>movl</code> (Move Doubleword) mnemonic will be shown.</p>
    <p>Assembly language is difficult to read at first, and often there are many seemingly meaningless sections that get in the way of you finding the key part of the program that you are looking for. However, by using the tools available it is often possible to find the important bits quickly.</p>

    <h3 id="graph-overview">Graph</h3>
    <p>The graph view is used to visually display the process flow and execution paths available to the program. It's essentially a flowchart that maps out the program and all of the potential different ways that it can execute.</p>
    <img class="radius-8" src="cutter-graph.png" width="1000px" title="The Cutter Graph View" alt="A screenshot of the Cutter graph view.">
    <p>For example, in the event of a <code>cmp</code> followed by a <code>jne</code> (which could be an <code>if</code> statement for simplicity's sake), there would be two arrows coming out and pointing to different parts of the program. One of these parts is what is executed if the <code>if</code> statement returns true, and the other would be for if it returns false.</p>
    <p>The arrows are simply visual representations of various jump instructions, such as <code>jmp</code>, <code>jne</code> or <code>je</code>.</p>
    <p>The graph view can be moved around by clicking and dragging, and zoomed using Ctrl + Scroll Wheel. Double-clicking on any jump within the graph view will take you to the destination, and double-clicking a memory address will take you to that address in the disassesmbly view.</p>

    <h3 id="functions-overview">Functions</h3>
    <div class="display-flex">
        <div>
            <img class="radius-8" src="cutter-functions.png" width="300px" title="The Cutter Functions List" alt="A screenshot of the Cutter functions list.">
        </div>
        <div class="display-flex flex-direction-column">
            <p class="no-mar-top margin-left-24">On the left hand side of the default interface layout, there is the functions list. This shows a list of functions that Cutter has been able to detect in the program.</p>
            <p class="no-mar-top margin-left-24">Most often, the <code>main</code> function is where you will start your analysis, as this is the usually the start of the actual program that you're interested in, rather than the various libraries that are most likely included.</p>
            <p class="no-mar-top margin-left-24">However, when analysing malware, it is important to keep in mind that malware authors often try to hide their code within standard libraries in order to make it more difficult to find using static analysis. It could be that <code>main</code> contains only legitimate/safe code, while the malware is actually hidden in a function from a standard library that you would usually ignore at first.</p>
        </div>
    </div>

    <h3 id="strings-overview">Strings</h3>
    <p>The strings view shows a stringdump of the binary that you are analysing. A stringdump shows text strings that have been found within the binary.</p>
    <img class="radius-8" src="cutter-strings.png" width="1000px" title="The Cutter Strings View" alt="A screenshot of the Cutter strings view.">
    <p>A stringdump will often tell you lots about what the function and purpose of the binary is. Stringdump results are often your first lead when starting to analyse a new binary.</p>
    <p>When analysing malware, strings may have been placed in order to throw you off-track, so make sure to keep this in mind.</p>

<!--    <h3 id="sidebar-overview">Sidebar</h3>
    <div class="display-flex">
        <div class="display-flex flex-direction-column">
            <p class="no-mar-top">The sidebar is on the right hand side when using the default Cutter interface layout. It shows additional information about the instruction or section that is currently selected.</p>
            <p class="no-mar-top">However, in most cases all of the information that you need is available directly in the disassembly or graph view.</p>
            <p class="no-mar-top">However, when analysing malware, it is important to keep in mind that malware authors often try to hide their code within standard libraries in order to make it more difficult to find using static analysis. It could be that <code>main</code> contains only legitimate/safe code, while the malware is actually hidden in a function from a standard library that you would usually ignore at first.</p>
        </div>
        <div>
            <img class="radius-8 margin-left-24" src="cutter-sidebar.png" width="298px" title="The Cutter Sidebar" alt="A screenshot of the Cutter sidebar.">
        </div>
    </div>-->

    <h3 id="hexdump-overview">Hexdump</h3>
    <p>The hexdump view shows a copy of the binary you are analysing in hexadecimal (base 16) form.</p>
    <img class="radius-8" src="cutter-hexdump.png" width="1000px" title="The Cutter Hexdump View" alt="A screenshot of the Cutter hexdump view.">
    <p>The first column is the offset, the second column is the hexadecimal output, and the third is the ASCII representation of the data.</p>
    <p>The hex output is exactly the same as what you will get from the <code>hexdump -vC</code> command:</p>
    <pre>js@box:~$ hexdump -vC example.txt
00000000  54 68 65 20 71 75 69 63  6b 20 62 72 6f 77 6e 20  |The quick brown |
00000010  66 6f 78 20 6a 75 6d 70  73 20 6f 76 65 72 20 74  |fox jumps over t|
00000020  68 65 20 6c 61 7a 79 20  64 6f 67 2e 0a           |he lazy dog..|
0000002d</pre>
    <p>In many cases the raw hexdump view is not that useful in Cutter as the information is provided in better formats elsewhere in the program, however it's there if you need it.</p>

    <h3 id="pseudocode-overview">Pseudocode</h3>
    <p>Cutter will attempt to display a pseudocode representation of the disassembled binary.</p>
    <img class="radius-8" src="cutter-pseudocode.png" width="1000px" title="The Cutter Pseudocode View" alt="A screenshot of the Cutter pseudocode view.">
    <p>The indentation and formatting is often off though, which can make it confusing at first glance. In the example below, the way that the destination of the <code>goto</code> is represented as a <code>do</code> could be misleading at first. Additionally, you could mistake the <code>while</code> loop as being part of the <code>if</code> statement, whereas it really comes after the <code>do</code>:</p>
    <pre>...
r12d = 0
ebx = 0
goto 0x401a63
 do
 {
      loc_0x401a63:

    rax = [local_60h]
    rdi = rax
    sym.std::__cxx11::basic_string_char_std::char_traits_char__std::allocator_char__::_basic_string ()
    var = ebx - 1                 //1
    if (var) goto 0x401a7a        //likely
     } while (?);
return;
...</pre>
    <p>It also seems like the <code>while</code> loop doesn't actually do anything in this case.</p>
    <p>I think that the pseudocode would be better presented like shown below:</p>
    <pre>...
r12d = 0
ebx = 0
goto 0x401a63
  do {                //loc_0x401a63:
    rax = [local_60h]
    rdi = rax
    sym.std::__cxx11::basic_string_char_std::char_traits_char__std::allocator_char__::_basic_string ()
    var = ebx - 1     //1
    if (var) {
      goto 0x401a7a   //likely
    }
  }
return;
...</pre>
    <p>Even though the pseudocode is not always accurate, this feature is still useful in some cases to help you (a human) understand the assesmbly code.</p>
    <p>Also, I must mention that this is not a decompiler.</p>

    <h3 id="entrypoints-overview">Entry Points</h3>
    <p>Cutter will detect and display the entry points of the program.</p>
    <img class="radius-8" src="cutter-entrypoints.png" width="1000px" title="The Cutter Entry Points View" alt="A screenshot of the Cutter entry points view.">
    <p>Entry points are where control is passed from the operating system to the program. Essentially it's the location in the binary that will be executed first when it is run.</p>

    <h3 id="imports-overview">Imports</h3>
    <p>The imports view displays a list of libraries that are imported by the binary that you are analysing.</p>
    <img class="radius-8" src="cutter-imports.png" width="1000px" title="The Cutter Imports View" alt="A screenshot of the Cutter imports view.">

    <h3 id="symbols-overview">Symbols</h3>
    <p>The symbols view shows a list of the symbols from the symbol table of the binary that you analysing.</p>
    <img class="radius-8" src="cutter-symbols.png" width="1000px" title="The Cutter Symbols View" alt="A screenshot of the Cutter symbols view.">
    <p>The symbol table contains information on various elements of the program, such as funtion names and entry points.</p>

    <h3 id="jupyter-overview">Jupyter Notebook</h3>
    <p>An additional feature of Cutter is the integrated Juptyer notebook.</p>
    <img class="radius-8" src="cutter-jupyter.png" width="1000px" title="The Cutter Jupyter View" alt="A screenshot of the Cutter Jupyter view.">
    <p>The Juptyer notebook is a server-based notebook application that supports both rich text and computer code. It allows you write and run Python directly in your notebook documents, which could be useful for many reverse engineering tasks.</p>
    <p>I personally have not used the Jupyter notebook feature very much in Cutter, so I'm not aware of all of the features and whether it is useful or not.</p>

    <h2 id="static-analysis">Analysing a Basic Program</h2>
    <p>I have put together a basic program that takes a number as an input, and outputs whether the number is odd or even.</p>
    <pre>Enter a Number (or q to quit): 2
2 is even.
Enter a Number (or q to quit): 1
1 is odd.
Enter a Number (or q to quit): 25
25 is odd.
Enter a Number (or q to quit): hello
Invalid Input
Enter a Number (or q to quit): q</pre>
    <p>If you wish to compile this yourself so that you can follow along with the analysis, I have included the C++ code below:</p>
    <pre>#include &lt;iostream&gt;
using namespace std;

int main(){
    string input;
    while(true){
        cout&lt;&lt;"Enter a Number (or q to quit): ";
        cin&gt;&gt;input;
        try {
            if (input == "q") {
                return 0;
            } else if (stoi(input) % 2 == 0) {
                cout&lt;&lt;input&lt;&lt;" is even.\n";
            } else {
                cout&lt;&lt;input&lt;&lt;" is odd.\n";
            }
        } catch(...) {
            cout&lt;&lt;"Invalid Input\n";
        }
    }
}</pre>
    <p>Save this to a file, then you can compile it like shown below:</p>
    <pre>$ g++ -std=c++14 -o <i>outputfile</i> <i>inputfile</i></pre>
    <p>After opening the file in Cutter using the default analysis settings, you will see the main interface with the disassembly view selected.</p>
    <img class="radius-8" src="odd-even-default-view.png" width="1000px" title="The Default View When Analysing a New File" alt="A screenshot of the default Cutter interface when analysing a new file.">
    <p>The first thing to do in most analysis tasks is to go to <code>main</code>. This is usually the best starting point for finding the code that you're interested in. For very simple programs (like the one we're looking at), most or all of the code will be in <code>main</code>.</p>
    <p>In Cutter, you can double-click <code>main</code> in the functions list on the left hand side. This will move the disassembler view to the start of <code>main</code>.</p>
    <img class="radius-8" src="odd-even-double-click-main.png" width="1000px" title="Double-clicking Main in the Functions List" alt="A screenshot of the Cutter interface with the main function showing in the disassembly view.">

    <h2 id="dynamic-analysis">Dynamic Analysis</h2>
    <p></p>

    <h2 id="crackme-challenges">Crackme Challenges</h2>
    <p>Possibly the best way to learn reverse engeering is to solve crackme challenges. Crackme challenges, or simply 'crackmes', are binaries that have been created for the purposes of training and testing your reverse engineering skills.</p>
    <p>The most well-known type of crackme is a password crackme, which is a binary that prompts you for a password when run. In order to solve the crackme, you have to use various reverse engineering tools in order to determine what the password is.</p>
    <p>Other types of crackmes include encryption programs where you have to reverse engineer an encryption key or algorithm, as well as programs with outright undefined behaviour, where you have to determine what the program does in order to solve the challenge.</p>
    <p>Sometimes crackmes are run in a capture-the-flag (CTF) format, where you can submit the password or 'flag' that you have found to an online portal in order to receive points.</p>
    <p>There are many places online where you can download crackmes, however always do your due-dilidence before downloading and running any due to the risk of malware, etc. <b>I recommend using a dedicated and segregated malware analysis machine for downloading, running and analysing crackmes.</b></p>

    <h2 id="sam-crackme">Sam's Crackme</h2>
    <p>In order to help with the process of learning Cutter, I asked my friend Sam to make a basic crackme challenge for me.</p>
    <p>He kindly agreed, and put together a simple password-based crackme for me to solve.</p>
    <p>The crackme looks like the following when run:</p>
    <pre>malw@re:~$ ./crackme
Enter Password (or q to quit): helloworld
Access Denied
Enter Password (or q to quit): Pa$$w0rd
Access Denied
Enter Password (or q to quit): q</pre>
    <p>I have already solved this and I'm working on a walkthrough to post on this blog, however if you wish to have a go, it is available on GitHub <a href="https://github.com/jamieweb/crackme-challenge" target="_blank" rel="noopener">here</a>.</p>
    <p>It is a beginner difficulty crackme, and most of the knowledge needed to solve it is present in the blog post that you are reading now.</p>
    <p><b>Please note that the <code>source.cpp</code> file is not obfuscated, so looking at it will potentially reveal the solution. For the best experience, compile the code without looking at the source file.</b> Obviously running untrusted code from the internet goes against every security best-practise out there, so either use a dedicated and segregated malware analysis machine, or get a trusted friend to check the code first.</p>

    <h2 id="conclusion">Conclusion</h2>
    <p></p>
</div>

<?php include "footer.php" ?>

</body>

</html>











