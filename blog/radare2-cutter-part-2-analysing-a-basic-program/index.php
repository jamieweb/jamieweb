<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Part 2: Analysing a Basic Program - Introduction to Reverse Engineering with radare2 Cutter</title>
    <meta name="description" content="Reverse engineering a basic program using static and dynamic analysis in radare2 Cutter.">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/blog/radare2-cutter-part-2-analysing-a-basic-program/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1 class="no-mar-bottom">Introduction to Reverse Engineering with radare2 Cutter</h1>
    <h2 class="subtitle-mar-top">Part 2: Analysing a Basic Program</h2>
    <hr>
    <p><b>Saturday 17th November 2018</b></p>
    <div class="display-flex flex-justify-space-between">
        <div>
            <p class="no-mar-top">This is part 2 of a 3 part series on reverse engineering with Cutter:</p>
            <ul class="spaced-list">
                <li><a href="/blog/radare2-cutter-part-1-key-terminology-and-overview" target="_blank"><b>Part 1:</b> Key Terminology and Overview</a></li>
                <li><b>Part 2:</b> Analysing a Basic Program (You Are Here)</li>
                <li><b>Part 3:</b> Solving a Crackme (Coming Soon)</li>
            </ul>
        </div>
        <div class="display-flex flex-align-center flex-justify-center flex-direction-column">
            <img src="/blog/radare2-cutter-part-1-key-terminology-and-overview/cutter-logo.png" width="135px" title="Cutter Logo" alt="Cutter Logo">
            <p class="no-mar-top centertext"><i>The Cutter logo.</i></p>
        </div>
    </div>
    <p class="no-mar-top">Cutter can be found on GitHub here: <b><a href="https://github.com/radareorg/cutter" target="_blank" rel="noopener">https://github.com/radareorg/cutter</a></b></p>
    <p><b>Skip to Section:</b></p>
    <pre><b>Introduction to Reverse Engineering with radare2 Cutter
Part 2: Analysing a Basic Program</b>
&#x2523&#x2501&#x2501 <a href="#cpp-odd-even">Creating a Program to Analyse</a>
&#x2523&#x2501&#x2501 <a href="#static-analysis">Static Analysis</a>
&#x2517&#x2501&#x2501 <a href="#part-3">Part 3</a></pre>

    <h2 id="cpp-odd-even">Creating a Program to Analyse</h2>
    <p>I've put together a basic program that takes a number as an input, and outputs whether the number is odd or even.</p>
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

    <h2 id="static-analysis">Static Analysis</h2>
    <p>After opening the file in Cutter using the default analysis settings, you will see the main interface with the disassembly view selected.</p>
    <img class="radius-8" src="/blog/radare2-cutter-part-2-analysing-a-basic-program/odd-even-default-view.png" width="1000px" title="The Default View When Analysing a New File" alt="A screenshot of the default Cutter interface when analysing a new file.">
    <p>The first thing to do in most analysis tasks is to go to <code>main</code>. This is usually the best starting point for finding the code that you're interested in. For very simple programs (like the one we're looking at), most or all of the noteworthy code will be in <code>main</code>.</p>
    <p>In Cutter, you can double-click <code>main</code> in the functions list on the left hand side. This will move the disassembler view to the start of <code>main</code>.</p>
    <img class="radius-8" src="/blog/radare2-cutter-part-2-analysing-a-basic-program/odd-even-double-click-main.png" width="1000px" title="Double-clicking Main in the Functions List" alt="A screenshot of the Cutter interface with the main function showing in the disassembly view.">
    <p>Immediately you can see the string for "Enter a number (or q to quit)". If you scroll down further, you will see the other key strings in the program too. This is a good indication that you've found something worth investigating further.</p>
    <p>Next, you can click onto the graph view in order to see the execution flow of the program. Zoom out a bit so that you can see it all.</p>
    <img class="radius-8" src="/blog/radare2-cutter-part-2-analysing-a-basic-program/odd-even-graph-overview.png" width="1000px" title="An Overview of the Graph View" alt="A screenshot of the Cutter interface with the graph view showing an overview of the entire program.">
    <p>This is too small to read, but it gives you a basic idea of the various execution paths that the program can take, as well as showing the various loops.</p>
    <p>If you zoom in on the second code block, you will see a clear human-readable string. Where possible, Cutter will automatically pick out the string values within functions and display them.</p>
    <p>Immediately after the string, there is a reference to <code>obj.std::cout</code>, which is the standard output stream. This is a strong indication that something (probably the visible string) is been printed here.</p>
    <img class="radius-8" src="/blog/radare2-cutter-part-2-analysing-a-basic-program/odd-even-take-input.png" width="1000px" title="Cutter Showing the Assembly Code Responsible for Prompting for User Input" alt="A screenshot of the Cutter interface with the assembly code for prompting for user input showing.">
    <p id="user-input">Next, there is a reference to <code>obj.std::cin</code>, which indicates that the program is reading from standard input. This is where you enter the number into the program.</p>
    <p>This data is stored in a local variable on the stack which radare2/Cutter refers to as <code>local_40h</code>.</p>
    <p>The memory address of this local variable is moved into <code>rax</code> using the <code>lea</code> (Load Effective Address) instruction, which is used to put a memory address from a source into the destination.</p>
    <pre>lea rax, [local_40h]</pre>
    <p>Since we're using the Intel syntax, <code>rax</code> is the destination and <code>[local_40h]</code> is the source.</p>
    <p>In order to fully understand the instruction, you need to see the opcode, which you can find in the sidebar. In this case the opcode is <code>lea rax, [rbp - 0x40]</code>. There are two important things to note about this opcode:</p>
    <ul class="spaced-list">
        <li><b>Square brackets:</b> The second operand (source) is surrounded by square brackets. This is used to refer to the contents of the memory address stored in the register, rather than the memory address itself.</li>
        <li><b>Minus sign:</b> The second operand also contains a mathematical operator and a hexadecimal value (in this example, <code>- 0x40</code>). This is used to subtract a number of bytes from the memory address at the specified register, resulting in a new memory address. In this case, 0x40 in hex is 64 in decimal. The plus sign (+) can also be used.</li>
    </ul>
    <p>Moving on, there is a <code>test</code> against the <code>al</code> register, followed by a <code>je</code> (Jump If Equal). If the jump does not take place, the program moves on to the error handling code which is part of the try/catch</code> that is used.</p>
    <img class="radius-8" src="/blog/radare2-cutter-part-2-analysing-a-basic-program/odd-even-catch.png" width="1000px" title="The Cutter Disassembly View Showing the Assembly for a Catch" alt="A screenshot of the Cutter interface with the assembly code for a catch showing.">
    <p>While you wouldn't normally have the knowledge that a try/catch is used in a particular place, it is usually possible to make an educated guess based on the behaviour of the program. I'm going to cover more about this in my walkthrough for <a href="/blog/radare2-cutter-part-1-key-terminology-and-overview#sams-crackme" target="_blank" rel="noopener">Sam's Crackme</a>.</p>
    <p>If the jump does take place (i.e. it hasn't caught yet), the program moves onto the next section. This is where it actually checks whether the inputted number is odd or even.</p>
    <img class="radius-8" src="/blog/radare2-cutter-part-2-analysing-a-basic-program/odd-even-number-check.png" width="1000px" title="Cutter Showing the Assembly Code Responsible for Determining Whether a Number is Odd or Even" alt="A screenshot of the Cutter interface with the assembly code for determining whether the user inputted number is odd or even.">
    <p>Firstly, the memory address of the user input stored in the stack is moved into <code>rax</code> again (as previously shown <a href="#user-input">above</a>).</p>
    <pre>lea rax, [local_40h]</pre>
    <p>The next important part is the call to <code>stoi_std</code>. <code>stoi()</code> is a C++ function to convert a string to an integer. Cutter has been able to detect that this function was used in the program and name it accordingly.</p>
    <p>After that, the actual odd/even check takes place in the form of <code>and eax, 1</code>. <code>eax</code> is the lower 32 bits of the <code>rax</code> register, and <code>1</code> is the value to perform the bitwise <code>AND</code> operation against. The result of the <code>AND</code> will be stored in <code>eax</code>.</p>
    <p>The use of the <code>and</code> instruction here may be unclear at first, however it is simply used to check whether the least significant bit of <code>eax</code> is a 1 or a 0. If it's a 1, then the number is odd, and if it's a 0, the number is even.</p>
    <p>The traditional usage of <code>and</code> is to perform bitwise <code>AND</code> operations, for example:</p>
    <pre>0 AND 0 = 0
1 AND 0 = 0
0 AND 1 = 0
1 AND 1 = 1</pre>
    <p>...or with larger numbers:</p>
    <pre>    1101001101011101
AND 0101101010110001
    &#x2501&#x2501&#x2501&#x2501&#x2501&#x2501&#x2501&#x2501&#x2501&#x2501&#x2501&#x2501&#x2501&#x2501&#x2501&#x2501
    0101001000010001</pre>
    <p>However in this case, the <code>and</code> instruction is used to perform a modulo operation (finding the remainder after a division).</p>
    <p>Binary numbers ending in a 1 are <b>always</b> odd when converted to decimal. This fact can be exploited by <code>and</code> in order to quickly identify the parity of numbers without having to actually divide them by two and check the remainder.</p>
    <p>All you have to do is <code>AND</code> the number against <code>1</code>, which will perform a bitwise <code>AND</code> on the least significant bit. The output of the <code>AND</code> will be the parity of the number (1 for odd, 0 for even). For example:</p>
    <pre>    1001 (9 in Decimal)
AND    1 (Only Checking LSB)
    &#x2501&#x2501&#x2501&#x2501
       1 (Odd)

    1110 (14 in Decimal)
AND    1 (Only Checking LSB)
    &#x2501&#x2501&#x2501&#x2501
       0 (Even)</pre>
    <p>Going back to the analysis, you can apply this logic to the <code>and eax, 1</code> instruction and see that <code>eax</code> will be <code>0</code> if the inputted number is even, and <code>1</code> if the inputted number is odd.</p>
    <p>Moving on, the next few instructions are used to determine which output to show based on the result of the parity check (i.e. print number is odd, or print number is even).</p>
    <img class="radius-8" src="/blog/radare2-cutter-part-2-analysing-a-basic-program/odd-even-determine-result-to-print.png" width="1000px" title="Cutter Showing the Assembly Code Responsible for Determining Which Result to Print" alt="A screenshot of the Cutter interface with the assembly code for determining whether to print that the inputted number was odd or to print that it was even.">
    <p>After the <code>and eax, 1</code> that I explained above, a <code>test</code> is performed on <code>eax</code> in the form of <code>test eax, eax</code>. This will perform a bitwise <code>AND</code> on <code>eax</code> against itself, and set the <code>ZF</code>, <code>SF</code> and <code>PF</code> flags accordingly.</p>
    <p><code>test</code> is identical to the <code>and</code> instruction, however instead of storing the result in the first operand like <code>and</code> does, <code>test</code> sets the appropriate flags and discards the result. In other words, it is a non-destructive <code>and</code>.</p>
    <p>In the case of our analysis, <code>eax</code> can only be either <code>0</code> or <code>1</code>.</p>
    <ul class="spaced-list">
        <li><b>If <code>eax</code> is <code>0</code>,</b> <code>test eax, eax</code> results in <code>0</code>, so <code>ZF</code> is set.</li>
        <li><b>If <code>eax</code> is <code>1</code>,</b> <code>test eax, eax</code> results in <code>1</code>, so <code>ZF</code> is cleared.</li>
    </ul>
    <p>The next instruction is <code>sete al</code>. This sets the specified byte to <code>1</code> if <code>ZF</code> is set, and to <code>0</code> if <code>ZF</code> is not set.</p>
    <p><code>al</code> is the lower 8 bits of <code>rax</code>. In this section of the analysis, <code>eax</code> (which is the lower 32 bits of <code>rax</code>), is still set to either <code>0</code> or <code>1</code>. This means that <code>al</code> is also either <code>0</code> or <code>1</code>.</p>
    <ul class="spaced-list">
        <li><b>If <code>ZF</code> is set (which means that <code>eax</code> was <code>0</code> in the previous <code>test</code>),</b> <code>sete al</code> results in <code>al</code> being set to <code>1</code>.</li>
        <li><b>If <code>ZF</code> is not set (which means that <code>eax</code> was <code>1</code> in the previous <code>test</code>),</b> <code>sete al</code> results in <code>al</code> being set to <code>0</code>.</li>
    </ul>
    <p>The effect that this has is flipping the least significant bit of <code>eax</code>/<code>al</code>. In other words, it's a bitwise <code>NOT</code> operation on the least significant bit. The reason that the <code>not</code> instruction is not used is that <code>not</code> performs a bitwise <code>NOT</code> on <b>all</b> of the bits, which is not the desired behaviour here.</p>
    <p>The next instruction is another test: <code>test al, al</code>. As explained above, this performs a bitwise <code>AND</code> on the operands and sets the <code>ZF</code>, <code>SF</code> and <code>PF</code> flags accordingly.</p>
    <p>In this section of the analysis, <code>al</code> is either <code>0</code> or <code>1</code>
    <ul class="spaced-list">
        <li><b>If <code>al</code> is <code>0</code>,</b> <code>test al, al</code> results in <code>ZF</code> being set.</li>
        <li><b>If <code>al</code> is <code>1</code>,</b> <code>test al, al</code> results in <code>ZF</code> being cleared.</li>
    </ul>
    <p>Finally, there is a <code>je</code> instruction. This is what ultimately points the execution in the direction of printing <code>$number is odd.</code> or <code>$number is even.</code>.</p>
    <p>The <code>je</code> (Jump If Equal) instruction jumps to the location specified in the first operand if <code>ZF</code> is set. The opposite of this is <code>jne</code> (Jump If Not Equal), which jumps if <code>ZF</code> is not set. <code>je</code> and <code>jne</code> are usually used after a <code>test</code> or <code>cmp</code> (Compare), so the "If (Not) Equal" wording is referring to whether the result of the <code>test</code> or <code>cmp</code> was equal to zero, which is indicated by the status of <code>ZF</code>.</p>
    <p>In the analysis, the location specified in the first operand is <code>0x400f1a</code>, which is the offset for the section that prints <code>$number is odd.</code>. If the jump does not take place, execution continues on to print <code>$number is even.</code>.</p>
    <img class="radius-8" src="/blog/radare2-cutter-part-2-analysing-a-basic-program/odd-even-print-result.png" width="1000px" title="Cutter Showing the Assembly Code Responsible for Determining and Printing the Result" alt="A screenshot of the Cutter interface with the assembly code for determining and printing whether the inputted number was odd or even.">
    <p>After the result is printed, there is a <code>jmp</code> (Unconditional Jump) to <code>0x400eba</code>, which is the start of the loop - in other words it takes you back to the start and asks for another number.</p>
    <p>The key section of this program is the part that determines whether the number is odd or even, and jumps accordingly. Just for reference, I have annotated an example execution below, with the inputted number being <code>1101</code> (13 in decimal, odd).</p>
    <pre>and eax, 1      //eax = 1101
test eax, eax   //1101 AND 1101 = 1101, 1101 != 0 so ZF is cleared
sete al         //ZF is not set, so al = 0
test al, al     //0 AND 0 = 0, 0 = 0 so ZF is set
je 0x400f1a     //ZF is set, so jump to 0x400f1a (print $number is Odd)</pre>
    <p>At this point, all of the noteworthy logic of the program has been successfully understood. With this knowledge, it would be possible to recreate the function of the program relatively accurately, which is often one of the main goals of reverse engineering.</p>

    <h2 id="part-3">Part 3</h2>
    <p>In part 3, we will solve a beginner level crackme challenge using Cutter and various other tools. If you'd like to get a head start, you can have a go at <a href="/blog/radare2-cutter-part-1-key-terminology-and-overview#sam-crackme" target="_blank" rel="noopener">Sam's Crackme</a>, which is the crackme that we'll be solving.</p>
    <p><b>Part 3 is currently a work in progress, and is coming soon!</b></p>
</div>

<?php include "footer.php" ?>

</body>

</html>











