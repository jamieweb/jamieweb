<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Part 1: Key Terminology and Overview - Introduction to Reverse Engineering with radare2 Cutter</title>
    <meta name="description" content="An overview of some key reverse engineering terminology and details on the various interfaces and tools available in radare2 Cutter.">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/blog/radare2-cutter-part-1-key-terminology-and-overview/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1 class="no-mar-bottom">Introduction to Reverse Engineering with radare2 Cutter</h1>
    <h2 class="subtitle-mar-top">Part 1: Key Terminology and Overview</h2>
    <hr>
    <p><b>Tuesday 23rd October 2018</b></p>
    <div class="display-flex">
        <div>
            <p class="no-mar-top">Cutter is an open-source graphical user interface for the radare2 reverse engineering framework. This article contains an introduction to reverse engineering with Cutter, including key terminology and an overview of the Cutter interface and available tools.</p>
            <p>This is part 1 of a 3 part series on reverse engineering with Cutter:</p>
            <ul class="spaced-list">
                <li><b>Part 1:</b> Key Terminology and Overview (You Are Here)</li>
                <li><a href="/blog/radare2-cutter-part-2-analysing-a-basic-program/" target="_blank"><b>Part 2:</b> Analysing a Basic Program</a></li>
                <li><b>Part 3:</b> Solving a Crackme (Coming Soon)</li>
            </ul>
        </div>
        <div class="display-flex flex-align-center flex-justify-center flex-direction-column">
            <img src="/blog/radare2-cutter-part-1-key-terminology-and-overview/cutter-logo.png" width="250px" title="Cutter Logo" alt="Cutter Logo">
            <p class="no-mar-top centertext"><i>The Cutter logo.</i></p>
        </div>
    </div>
    <p class="no-mar-top">Cutter can be found on GitHub here: <b><a href="https://github.com/radareorg/cutter" target="_blank" rel="noopener">https://github.com/radareorg/cutter</a></b></p>
    <img class="radius-8" src="/blog/radare2-cutter-part-1-key-terminology-and-overview/cutter-interface-overview.png" width="1000px" title="The Cutter Interface" alt="Screenshot of the Cutter Interface">
    <p class="two-no-mar centertext"><i>The main Cutter interface.</i></p>
    <p><b>Skip to Section:</b></p>
    <pre><b>Introduction to Reverse Engineering with radare2 Cutter
Part 1: Key Terminology and Overview</b>
&#x2523&#x2501&#x2501 <a href="#what-are-radare2-and-cutter">What are radare2 and Cutter?</a>
&#x2523&#x2501&#x2501 <a href="#installing-cutter">Installing Cutter</a>
&#x2523&#x2501&#x2501 <a href="#key-terminology">Key Terminology</a>
&#x2503&nbsp;&nbsp;&nbsp;&#x2523&#x2501&#x2501 <a href="#instruction">Instruction</a>
&#x2503&nbsp;&nbsp;&nbsp;&#x2523&#x2501&#x2501 <a href="#register">Register</a>
&#x2503&nbsp;&nbsp;&nbsp;&#x2523&#x2501&#x2501 <a href="#flag">Flag</a>
&#x2503&nbsp;&nbsp;&nbsp;&#x2517&#x2501&#x2501 <a href="#stack">Stack</a>
&#x2523&#x2501&#x2501 <a href="#interface-and-tools">Cutter Interface and Tools</a>
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
&#x2523&#x2501&#x2501 <a href="#types-of-analysis">Types of Analysis</a>
&#x2523&#x2501&#x2501 <a href="#crackme-challenges">Crackme Challenges</a>
&#x2523&#x2501&#x2501 <a href="#sam-crackme">Sam's Crackme</a>
&#x2517&#x2501&#x2501 <a href="#part-2">Part 2</a></pre>

    <h2 id="what-are-radare2-and-cutter">What are radare2 and Cutter?</h2>
    <p>Radare2 is an open-source, command-line based reverse engineering framework for Linux, macOS, Windows and many other platforms. It includes a set of tools for reverse engineering and analysing executable files (compiled programs). Radare2 can be used to perform both static and dynamic analysis.</p>
    <img class="radius-8" src="/blog/radare2-cutter-part-1-key-terminology-and-overview/radare2-interface.png" width="1000px" title="The radare2 Interface Running in the Command-line" alt="A screenshot of the radare2 interface running in the command-line.">
    <p class="two-no-mar centertext"><i>The radare2 command-line interface in disassembly view.</i></p>
    <p>Cutter is the official GUI for radare2, allowing you to make use of all of the features of the command-line version while being able to better organise the information on your screen and make use of additional tools such as the built-in Jupyter notebook.</p>
    <p>Development of Cutter, which was originally named Iaito, started in March 2017. Since then there have been 10 major releases, with the latest version at the time of writing being 1.7.2.</p>

    <h2 id="installing-cutter">Installing Cutter</h2>
    <p>Cutter can be acquired in either source or binary form from the official GitHub repository: <a href="https://github.com/radareorg/cutter" target="_blank" rel="noopener">https://github.com/radareorg/cutter</a></p>
    <img class="radius-8 border-1px-solid" src="/blog/radare2-cutter-part-1-key-terminology-and-overview/radareorg-cutter-github.png" width="1000px" title="The radare2 Cutter project on GitHub" alt="A screenshot of the radare2 Cutter repository on GitHub.">
    <p class="two-no-mar centertext"><i>The radare2 Cutter project on GitHub.</i></p>
    <p>Each release is available as an AppImage (for Linux), DMG (for macOS) and a ZIP containing an EXE (for Windows). The source code is also available if you to wish to compile Cutter yourself.</p>
    <p>Unfortunately it's not easy to verify the integrity of the Cutter releases. I have opened an issue about this <a href="https://github.com/radareorg/cutter/issues/666" target="_blank" rel="noopener">here</a>.</p>

    <h2 id="key-terminology">Key Terminology</h2>
    <p>In order to begin with reverse engineering, there are few key bits of terminology that will come in useful.</p>

    <h3 id="instruction">Instruction</h3>
    <p>Instructions are used to perform very specific low-level tasks on the CPU. These tasks include manipulating memory, 'jumping' to a particular point in a program or performing binary operations.</p>
    <p>Some examples of instructions include <code>mov</code>, <code>call</code> and <code>jmp</code>.</p>
    <p>There are many different sets of instructions available, such as x86 or ARMv7.</p>

    <h3 id="register">Register</h3>
    <p>Registers are small amounts of fast memory present directly on the CPU. There are different amounts, types and sizes of registers depending on the CPU model and type.</p>
    <p>Types of register include General Purpose Registers (of which there are 16 in x84_64), and the status register, which is used to store CPU flags.</p>
    <p>Registers are addressed using names such as <code>rax</code> or <code>rbx</code>.</p>

    <h3 id="flag">Flag</h3>
    <p>Flags are single-bit (i.e. <code>0</code> or <code>1</code>) values that are used to store the current state of the CPU. They are stored in the status register, which is known as <code>RFLAGS</code> in x86_64 CPUs.</p>
    <p>Some examples of flags include <code>ZF</code> (Zero Flag), which is set to <code>1</code> if the result of an arithmetic operation is 0, and <code>CF</code> (Carry Flag), which is used to indicate that an artithmetic operation requires a carry.</p>

    <h3 id="stack">Stack</h3>
    <p>The stack is a part of the allocated memory (RAM) of a program used to store local variables and other key information related to the execution of the program or a function.</p>
    <p>Data is pushed onto the stack in a last-in, first-out (LIFO) fashion.</p>

    <h2 id="interface-and-tools">Cutter Interface and Tools</h2>
    <p>Once you have downloaded Cutter (and installed if required), you can run it and choose a file to analyse.</p>
    <img class="radius-8" src="/blog/radare2-cutter-part-1-key-terminology-and-overview/cutter-open-file.png" width="1000px" title="Choosing a file to open in Cutter" alt="A screenshot of the interface for choosing a file to open in Cutter.">
    <p class="two-no-mar centertext"><i>Choosing a file to open in Cutter.</i></p>
    <p>If you just want to get Cutter working and analyse a file, a good starting choice could be a basic system tool/program such as <code>pwd</code>, <code>true</code> or <code>whoami</code>.</p>
    <p>After selecting a file, Cutter will allow you to specify the analysis settings. In most cases, these can be left as the default.</p>
    <img class="radius-8" src="/blog/radare2-cutter-part-1-key-terminology-and-overview/cutter-analysis-settings.png" width="1000px" title="Choosing the Analysis Settings in Cutter" alt="A screenshot of the interface for choosing the analysis settings in Cutter.">
    <p class="two-no-mar centertext"><i>Choosing the analysis settings in Cutter.</i></p>
    <p>After clicking 'Ok', Cutter will proceed to analyse the file and then the main Cutter interface will appear.</p>
    <img class="radius-8" src="/blog/radare2-cutter-part-1-key-terminology-and-overview/cutter-default-layout.png" width="1000px" title="The Default Cutter Interface Layout" alt="A screenshot of the default interface layout of Cutter.">
    <p class="two-no-mar centertext"><i>The default Cutter interface layout.</i></p>
    <p>At first, this interface looks very daunting and may be overwhelming. There is lots of information being displayed and many menus available, however in most cases only a few sections and tools are actually needed.</p>
    <p>The central panel with the tabs at the bottom is where most of your work will take place. The panels around the edge provide supporting information and other tools.</p>

    <h3 id="dashboard-overview">Dashboard</h3>
    <p>The dashboard tab contains an overview of the file that you are currently analysing, including the file format, size, architechture type and the libraries that it is using.</p>
    <img class="radius-8" src="/blog/radare2-cutter-part-1-key-terminology-and-overview/cutter-dashboard.png" width="1000px" title="The Cutter Dashboard" alt="A screenshot of the Cutter dashboard.">

    <h3 id="disassembly-overview">Disassembly</h3>
    <p>The disassembly panel shows the disassembled machine code of the program. This is known as assembly language, and contains raw instructions such as <code>mov</code>, <code>push</code> and <code>call</code> and the arguments that go along with them.</p>
    <p>You can change the text size in the disassembly view using Ctrl + Shift + "+" (to increase) and Ctrl + "-" (to decrease).</p>
    <img class="radius-8" src="/blog/radare2-cutter-part-1-key-terminology-and-overview/cutter-disassembly.png" width="1000px" title="The Cutter Disassembly View" alt="A screenshot of the Cutter disassembly view.">
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
    <p>You may also notice that there are additional differences between the Intel and AT&T syntaxes, such as the percentage sign in front of the operands and the mnemonic displaying as <code>movq</code> (Move Quadword, since rax and rbx are both full 64-bit registers), rather than just <code>mov</code>. In the case of 32-bit registers, the the <code>movl</code> (Move Doubleword) mnemonic would be shown.</p>
    <p>Assembly language is difficult to read at first, and often there are many seemingly meaningless sections that get in the way of you finding the key part of the program that you are looking for. However, by using the tools available it is often possible to find the important bits quickly.</p>

    <h3 id="graph-overview">Graph</h3>
    <p>The graph view is used to visually display the process flow and execution paths available to the program. It's essentially a flowchart that maps out the program and all of the potential different ways that it can execute.</p>
    <img class="radius-8" src="/blog/radare2-cutter-part-1-key-terminology-and-overview/cutter-graph.png" width="1000px" title="The Cutter Graph View" alt="A screenshot of the Cutter graph view.">
    <p>For example, in the event of a <code>cmp</code> (Compare) followed by one of the various jump instructions (which could be equivalent to an <code>if</code> statement in a higher-level language for simplicity's sake), there would be two arrows coming out and pointing to different parts of the program. One of these parts is what is executed if the <code>if</code> statement returns true, and the other would be for if it returns false.</p>
    <p>The arrows are simply visual representations of the various jump instructions, such as <code>jmp</code>, <code>jne</code> or <code>je</code>. The green arrow shows what happens if the jump takes place, and the orange arrow shows what happens if it doesn't. Grey arrows show a loop.</p>
    <p>The graph view can be moved around by clicking and dragging, and zoomed using Ctrl + Scroll Wheel. Double-clicking on any jump within the graph view will take you to the destination, and double-clicking an address will take you to that address in the disassesmbly view.</p>

    <h3 id="functions-overview">Functions</h3>
    <div class="display-flex">
        <div>
            <img class="radius-8" src="/blog/radare2-cutter-part-1-key-terminology-and-overview/cutter-functions.png" title="The Cutter Functions List" alt="A screenshot of the Cutter functions list.">
        </div>
        <div class="display-flex flex-direction-column">
            <p class="no-mar-top margin-left-24">On the left hand side of the default interface layout, there is the functions list. This shows a list of functions that Cutter has been able to detect in the program.</p>
            <p class="no-mar-top margin-left-24">Most often, the <code>main</code> function is where you will start your analysis, as this is the usually the start of the actual program that you're interested in, rather than the various libraries that are most likely included.</p>
            <p class="no-mar-top margin-left-24">However, when analysing malware, it is important to keep in mind that malware authors often try to hide their code within standard libraries in order to make it more difficult to find using static analysis. It could be that <code>main</code> contains only legitimate/safe code, while the malware is actually hidden in a function from a standard library that you would usually ignore at first.</p>
        </div>
    </div>

    <h3 id="strings-overview">Strings</h3>
    <p>The strings view shows a stringdump of the binary that you are analysing. A stringdump shows text strings that have been found within the binary.</p>
    <img class="radius-8" src="/blog/radare2-cutter-part-1-key-terminology-and-overview/cutter-strings.png" width="1000px" title="The Cutter Strings View" alt="A screenshot of the Cutter strings view.">
    <p>A stringdump will often give you a lot of clues about what the functionality and purpose of the binary is. Stringdump results are often your first lead when starting to analyse a new binary.</p>
    <p>When analysing malware, strings may have been placed in order to throw you off-track, so make sure to keep this in mind.</p>

<!--    <h3 id="sidebar-overview">Sidebar</h3>
    <div class="display-flex">
        <div class="display-flex flex-direction-column">
            <p class="no-mar-top">The sidebar is on the right hand side when using the default Cutter interface layout. It shows additional information about the instruction or section that is currently selected.</p>
            <p class="no-mar-top">However, in most cases all of the information that you need is available directly in the disassembly or graph view.</p>
            <p class="no-mar-top">However, when analysing malware, it is important to keep in mind that malware authors often try to hide their code within standard libraries in order to make it more difficult to find using static analysis. It could be that <code>main</code> contains only legitimate/safe code, while the malware is actually hidden in a function from a standard library that you would usually ignore at first.</p>
        </div>
        <div>
            <img class="radius-8 margin-left-24" src="/blog/radare2-cutter-part-1-key-terminology-and-overview/cutter-sidebar.png" width="298px" title="The Cutter Sidebar" alt="A screenshot of the Cutter sidebar.">
        </div>
    </div>-->

    <h3 id="hexdump-overview">Hexdump</h3>
    <p>The hexdump view shows a copy of the binary you are analysing in hexadecimal (base 16) form.</p>
    <img class="radius-8" src="/blog/radare2-cutter-part-1-key-terminology-and-overview/cutter-hexdump.png" width="1000px" title="The Cutter Hexdump View" alt="A screenshot of the Cutter hexdump view.">
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
    <img class="radius-8" src="/blog/radare2-cutter-part-1-key-terminology-and-overview/cutter-pseudocode.png" width="1000px" title="The Cutter Pseudocode View" alt="A screenshot of the Cutter pseudocode view.">
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
    <p>Even though the pseudocode is not always accurate, this feature is still useful in some cases to help you (a human) understand the assembly code.</p>
    <p>Also, I must mention that this is not a decompiler.</p>

    <h3 id="entrypoints-overview">Entry Points</h3>
    <p>Cutter will detect and display the entry points of the program.</p>
    <img class="radius-8" src="/blog/radare2-cutter-part-1-key-terminology-and-overview/cutter-entrypoints.png" width="1000px" title="The Cutter Entry Points View" alt="A screenshot of the Cutter entry points view.">
    <p>Entry points are where control is passed from the operating system to the program. Essentially it's the location in the binary that will be executed first when it is run.</p>

    <h3 id="imports-overview">Imports</h3>
    <p>The imports view displays a list of libraries that are imported by the binary that you are analysing.</p>
    <img class="radius-8" src="/blog/radare2-cutter-part-1-key-terminology-and-overview/cutter-imports.png" width="1000px" title="The Cutter Imports View" alt="A screenshot of the Cutter imports view.">

    <h3 id="symbols-overview">Symbols</h3>
    <p>The symbols view shows a list of the symbols from the symbol table of the binary that you analysing.</p>
    <img class="radius-8" src="/blog/radare2-cutter-part-1-key-terminology-and-overview/cutter-symbols.png" width="1000px" title="The Cutter Symbols View" alt="A screenshot of the Cutter symbols view.">
    <p>The symbol table contains information on various elements of the program, such as funtion names and entry points.</p>

    <h3 id="jupyter-overview">Jupyter Notebook</h3>
    <p>An additional feature of Cutter is the integrated Juptyer notebook.</p>
    <img class="radius-8" src="/blog/radare2-cutter-part-1-key-terminology-and-overview/cutter-jupyter.png" width="1000px" title="The Cutter Jupyter View" alt="A screenshot of the Cutter Jupyter view.">
    <p>The Juptyer notebook is a server-based notebook application that supports both rich text and computer code. It allows you write and run Python directly in your notebook documents, which could be useful for many reverse engineering tasks.</p>
    <p>I personally have not used the Jupyter notebook feature very much in Cutter, so I'm not aware of all of the features and whether it is useful or not.</p>

    <h2 id="types-of-analysis">Types of Analysis</h2>
    <p>Cutter is able to perform both static and dynamic analysis.</p>
    <p><b>Static analysis</b> is where you observe and analyse static information, such as the instructions, functions and strings present in a program.</b></p>
    <p><b>Dynamic analysis</b> is where the program is actually run and its behaviour is analysed. This could be done using an external debugger, virtual machine or by 'stepping through' the program one instruction at time (which can be done in Cutter).</b></p>

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
    <p>I have already solved it and will be posting a walkthrough in part 3 of this series on my blog, however if you wish to have a go, it is available on GitHub <a href="https://github.com/jamieweb/crackme-challenge" target="_blank" rel="noopener">here</a>.</p>
    <p>It is a beginner difficulty crackme, and most of the knowledge needed to solve it is present in the blog post that you are reading now.</p>
    <p><b>Please note that the <code>source.cpp</code> file is not obfuscated, so looking at it will potentially reveal the solution.</b> For the best experience, compile the code without looking at the source file. Obviously running untrusted code from the internet goes against every security best-practise out there, so either use a dedicated and segregated malware analysis machine, or ask a trusted friend to check the code first.</p>

    <h2 id="part-2">Part 2</h2>
    <p>Part 2 includes analysing a basic compiled C++ program using static analysis, and further technical details on some common instructions.</p>
    <p><b><a href="/blog/radare2-cutter-part-2-analysing-a-basic-program/" target="_blank">Part 2: Analysing a Basic Program</a></b></p>
</div>

<?php include "footer.php" ?>

</body>

</html>











