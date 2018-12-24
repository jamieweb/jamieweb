<?php include "response-headers.php"; content_security_policy(); ?>
<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>iPhone System Clock</title>
    <meta name="description" content="iPhone 4 Behaving Strangely Because of an Incorrect System Clock">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/blog/iphone-strange-clock/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>iPhone 4 behaving strangely because of an incorrect system clock.</h1>
    <hr>
    <p><b>Saturday 3rd December 2016</b></p>
    <p>I recently encountered a very strange bug while using an iPhone 4 running iOS 7.1.2 (the latest that it supports). The phone had been acting strangely for a long time, with many little quirks, bizarre behaviour and some features simply not working.</p>
    <p>The first thing that I noticed was that the alarm clock was very intermittent, sometimes sounding at the expected time (from the phone's perspective) and sometimes not at all. Also, the notification center was not showing my scheduled alarms like it is supposed to. Next, I noticed that the phone had no signal, but it actually did. The signal bar at the top left of the phone was not displaying an accurate status. It would say "No Service" most of the time, but the phone was sometimes still able to receive calls and text messages.</p>
    <p>The system clock was running roughly 3 minutes behind the real time, possibly caused by the phone having not been connected to the internet for well over a year. I connected to the internet and toggled the "Set Time Automatically" option on and off in order to trigger a time synchronization. The clock set itself correctly and the phone started working completely normally. All issues were fixed.</p>
    <p><b>All strange behaviour that I experienced:</b></p>
    <ul><li>Intermittent alarm clock. It would rarely go off when it was supposed to (even at the correct time from the phone's perspective).</li><br>
    <li>Schedulded alarm clock not showing up in notification center. When you have at least one alarm set, it's supposed to say: "You have an alarm set for XX:XX am/pm."</li><br>
    <li>Signal bar/indicator inaccurate, showing "No Service" most of the time even though the phone did have signal and could sometimes receive calls/texts. Also, when disabling airplane mode, the signal indicator instantly goes back to its state before airplane mode was enabled. It would normally display "Searching..." for a few seconds.</li><br>
    <li>When sending a text message, the green bubble containing the message pops up as usual, but instantly disappears. The message does send though.</li><br>
    <li>When calling someone, it will never connect and ring infinitely. Pressing the end call button causes the Phone app to freeze for a good few minutes. Even if you manage to exit the app and kill it from the multitasking interface, it remains frozen when reopened.</li><br>
    <li>When receiving a call, the phone does not ring. When the other person hangs up, a missed call notification appears.</li></ul>
    <p>I have tried reproducing these issues by disabling the "Set Time Automatically" option and deliberately setting the system clock incorrectly, but the phone continued working as normal. Perhaps this behaviour was a result of a prolonged time with the system clock set incorrectly. At least now I have documented this, and it may be useful to someone else in the future.</p>
</div>

<?php include "footer.php" ?>

</body>

</html>
