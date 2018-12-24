<?php include "response-headers.php"; content_security_policy(); ?>
<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>x86_64 General Purpose Registers Reference</title>
    <meta name="description" content="A reference of the general purpose registers in the x86_64 instruction set architechture.">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/info/x86_64-general-purpose-registers-reference/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>x86_64 General Purpose Registers Reference</h1>
    <hr>
    <p>The x86_64 instruction set architechture includes 16 general purpose regisers, each of which can be addressed in full, or by the lower 32, 16 and 8 bits.</p>
    <h2 id="general-purpose-registers">General Purpose Registers</h2>
    <table class="width-100-percent padding-6 border-1-4c4c4c border-collapse">
        <tr class="bg-lightgreen">
            <th>64-bit Register</th>
            <th>Lower 32 bits</th>
            <th>Lower 16 bits</th>
            <th>Lower 8 bits</th>
        </tr>
        <tr>
            <td><code>rax</code></td>
            <td><code>eax</code></td>
            <td><code>ax</code></td>
            <td><code>al</code></td>
        </tr>
        <tr>
            <td><code>rbx</code></td>
            <td><code>ebx</code></td>
            <td><code>bx</code></td>
            <td><code>bl</code></td>
        </tr>
        <tr>
            <td><code>rcx</code></td>
            <td><code>ecx</code></td>
            <td><code>cx</code></td>
            <td><code>cl</code></td>
        </tr>
        <tr>
            <td><code>rdx</code></td>
            <td><code>edx</code></td>
            <td><code>dx</code></td>
            <td><code>dl</code></td>
        </tr>
        <tr>
            <td><code>rsi</code></td>
            <td><code>esi</code></td>
            <td><code>si</code></td>
            <td><code>sil</code></td>
        </tr>
        <tr>
            <td><code>rdi</code></td>
            <td><code>edi</code></td>
            <td><code>di</code></td>
            <td><code>dil</code></td>
        </tr>
        <tr>
            <td><code>rbp</code></td>
            <td><code>ebp</code></td>
            <td><code>bp</code></td>
            <td><code>bpl</code></td>
        </tr>
        <tr>
            <td><code>rsp</code></td>
            <td><code>esp</code></td>
            <td><code>sp</code></td>
            <td><code>spl</code></td>
        </tr>
        <tr>
            <td><code>r8</code></td>
            <td><code>r8d</code></td>
            <td><code>r8w</code></td>
            <td><code>r8b</code></td>
        </tr>
        <tr>
            <td><code>r9</code></td>
            <td><code>r9d</code></td>
            <td><code>r9w</code></td>
            <td><code>r9b</code></td>
        </tr>
        <tr>
            <td><code>r10</code></td>
            <td><code>r10d</code></td>
            <td><code>r10w</code></td>
            <td><code>r10b</code></td>
        </tr>
        <tr>
            <td><code>r11</code></td>
            <td><code>r11d</code></td>
            <td><code>r11w</code></td>
            <td><code>r11b</code></td>
        </tr>
        <tr>
            <td><code>r12</code></td>
            <td><code>r12d</code></td>
            <td><code>r12w</code></td>
            <td><code>r12b</code></td>
        </tr>
        <tr>
            <td><code>r13</code></td>
            <td><code>r13d</code></td>
            <td><code>r13w</code></td>
            <td><code>r13b</code></td>
        </tr>
        <tr>
            <td><code>r14</code></td>
            <td><code>r14d</code></td>
            <td><code>r14w</code></td>
            <td><code>r14b</code></td>
        </tr>
        <tr>
            <td><code>r15</code></td>
            <td><code>r15d</code></td>
            <td><code>r15w</code></td>
            <td><code>r15b</code></td>
        </tr>
    </table>
    <h2 id="addressing">Addressing</h2>
    <p>General purpose registers in x86_64 are addressed as follows, using <code>rax</code> as an example:</p>
    <pre>
&#x250F;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;rax&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2513;
&#x2503;                               &#x250F;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;eax&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x252B;
&#x2503;                               &#x2503;               &#x250F;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;ax&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x2501;&#x252B;
&#x2503;                               &#x2503;               &#x2503;       &#x250F;&#x2501;&#x2501;al&#x2501;&#x2501;&#x252B;
0000000000000000000000000000000000000000000000000000000000000000
</div>

<?php include "footer.php" ?>

</body>

</html>








