<?php include "response-headers.php"; content_security_policy(); ?>
<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Plainsight Demo</title>
    <meta name="description" content="Plainsight Enciphering Demo">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/blog/plainsight-enciphering-demo/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Plainsight Enciphering Demo</h1>
    <hr>
    <p><b>Sunday 4th December 2016</b></p>
    <p>Plainsight is created by user "rw" on GitHub: <a href="https://github.com/rw/plainsight" target="_blank" rel="noopener">github.com/rw/plainsight</a></p>
    <p>Plainsight is a textual steganography tool for Linux, written in Python, that allows you to encipher a message into a plain-text random nonsense format, consisting of dictionary words, using a source text.</p>
    <p>The purpose of Plainsight is to allow users to send secret messages without standing out. Other forms of secret communication, such as PGP encrypted messages, would clearly stand out to an internet censor, firewall, blocking system, etc.</p>
    <p>The easiest way to install Plainsight is using the Python preferred installer program (pip). Many Linux distributions have it pre-installed, but if you don't have it:</p>
    <pre>$ sudo apt-get install python-pip</pre>
    <p>Or use the appropriate command for your Linux distribution.</p>
    <p>Now install Plainsight:</p>
    <pre>$ sudo pip install plainsight</pre>
    <p>The bitstring and progressbar Python modules are also required to run the program. Bitstring allows Python to create and manipulate binary data, and ProgressBar is a visual text-based progress bar. If you are unsure as to whether you already have these or not, simply run the command "plainsight" and it will report on any missing modules.</a>
    <pre>$ sudo pip install bitstring
$ sudo pip install progressbar</pre>
    <p>In order to use Plainsight, you must have a source text. This is what will be used to encipher your message. You can use anything as a source text, but people generally use books/lyrics/poems. However, if you can prearrange a private source text with your intended recipient(s), it would be more secure than using a public text.</p>
    <p>For this example, I am using a random Lipsum text. The main advantage of this is that Lipsum texts are expected to be random, so it would stand out even less should your enciphered message fall into the wrong hands. You can easily generate a random Lipsum text at <a href="http://lipsum.com/feed/html/" target="_blank" rel="noopener">lipsum.com/feed/html</a>. I am unsure of the integrity of the randomness used on this site, so do your own research before using it. Below is the Lipsum text I am using as my source for this demonstration:</p>
    <pre>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi et viverra
est.Integer orci augue, ullamcorper sit amet dui a, volutpat finibus purus.
Curabitur feugiat nisl eget erat blandit, vel hendrerit ex vehicula. Sed
vulputate, augue maximus tempor iaculis, ex ante imperdiet nibh, eu pretium
libero est eget felis. Etiam et vehicula dui. Integer fermentum aliquam
neque, id convallis lectus eleifend et. Aenean suscipit risus eros, quis
tempor sem fringilla non. Pellentesque mauris libero, viverra ac placerat
eget, finibus sed mauris. Aliquam porta nisi risus, sed blandit purus
condimentum sed. Duis tincidunt nunc gravida, pellentesque risus in, dictum
arcu. Donec enim erat, interdum nec commodo vel, eleifend vitae ipsum.
Aliquam suscipit efficitur nulla, suscipit malesuada ex rutrum vitae.
Praesent mollis sapien eu ullamcorper scelerisque. Ut lacinia velit sit
amet sollicitudin convallis.</pre>
    <p>Save your source text into a file. I used lipsum.txt.</p>
    <p>In order to encipher a message, you must pipe it through the Plaintext program. You can do this either by creating a file and using the "cat" command, or simply echoing your text directly into Plainsight.</p>
    <pre>$ echo "The quick brown fox jumps over the lazy dog." > message.txt

$ cat message.txt | plainsight -m encipher -f lipsum.txt > enciphered.txt
Adding models:
Model: lipsum.txt added in 0.00s (context == 2)
input is "<stdin>", output is "<stdout>"

enciphering: 100%|############################|  2.75 kB/s | Time: 0:00:00

$ cat enciphered.txt
empor blandit augue, et tempor Aliquam viverra blandit eleifend consectetur
augue, Donec et Morbi tincidunt ex eget amet tincidunt et nisi ipsum purus.
eleifend sed suscipit nunc et nisi nisi suscipit ex ullamcorper amet Morbi
Donec Morbi condimentum viverra nunc sed suscipit vel vel eget tincidunt
Integer malesuada sed suscipit Morbi et ipsum. tincidunt amet ex ullamcorper
blandit ipsum. vel augue, nisi amet ex eget blandit vel Donec eleifend
Integer ipsum. tempor</pre>
    <p>The 44 character message has been enciphered into 470 characters of randomly arranged words from the Lipsum source text.</p>
    <p>Now to decipher the message:</p>
    <pre>$ cat enciphered.txt | plainsight -m decipher -f lipsum.txt > deciphered.txt
Adding models:
Model: lipsum.txt added in 0.01s (context == 2)
input is "<stdin>", output is "<stdout>"

deciphering: 100%|############################| 367.62 B/s | Time: 0:00:00

$ cat deciphered.txt
The quick brown fox jumps over the lazy dog.</pre>
    <p>As you can see, the message has been deciphered with all formatting and punctuation intact.</p>
    <p>Plainsight also works well with files. I have successfully enciphered and deciphered a PNG file, C file and ZIP file, so it should work fine for any type of file. Plainsight is not really ideal for large files though, since once you start reaching multiple megabytes in size it takes a very long time to encipher/decipher, and the output file is very large in size.</p>
    <p>In order to combat the large output file sizes, I tried using a longer source text. To my surprise, the output file was even larger! I am not sure why this is, as I thought that having a longer word list to encipher with (meaning more possible combinations) would result in a smaller output. Perhaps the Plainsight software creates a ciphertext relative in length to the source text.</p>
    <p>An interesting way that Plainsight could be used is to write messages that are intended for a certain group of people. If a Plainsight message was left somewhere public, many people would just scroll past it, but anybody who recognised the format could try using common source texts to decipher the message.</p>
    <p>Another way that I find Plainsight useful is for creating physical printed paper backups of confidential information. For example if you wanted to create a physical backup of an encryption key. It is not safe to print the key in plain text format, since modern "smart" printers may have some sort of memory that could store a copy of your key, or it could be kept on a print server. Enciphering the key using Plainsight and printing the output would help get around this risk.</p>
    <p>You can easily layer Plainsight with other technologies for extra protection. For example, encrypt your message with PGP and run that through Plainsight. This way, you have the security and privacy of PGP combined with the obscurity of Plainsight.</p>
    <p>Plainsight is probably one of the best ways to send a secret message undetected. Especially if you're using a random Lipsum as your source text, since a Lipsum text is a completely normal thing to find on the internet and shouldn't raise any red flags.</p>
</div>

<?php include "footer.php" ?>

</body>

</html>
