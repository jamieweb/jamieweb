<?php set_time_limit(1);

session_start();

$siv = 0;
$sessionid = session_id();
if (!preg_match("/[^a-z0-9]/", $sessionid)) {
    $siv++;
    if (strlen($sessionid) == 52) {
        $siv++;
        if ($siv == 2) {
            $allowcharssi = "abcdefghijklmnopqrstuvwxyz0123456789";
            $checksi = str_split($sessionid, 1);
            $sicharverifications = 0;
            $sicurrentchar = 0;
            foreach ($checksi as $checksichar) {
                if (strpos($allowcharssi, $checksichar) > -1) {
                    $sicharverifications++;
                    $finalsia[$sicurrentchar] = $allowcharssi[strpos($allowcharssi, $checksichar)];
                    $sicurrentchar++;
                } else {
                    $sicharverifications = -512;
                }
            }
            if (($sicharverifications == 52) && ($siv == 2)) {
                $finalsi = implode("", $finalsia);
            } else {
                session_regenerate_id();
            }
        } else {
            session_regenerate_id();
        }
    } else {
        session_regenerate_id();
    }
} else {
    session_regenerate_id();
}

$grlv = 0;
$grl = 1;
$grlerror = "Global Rate Limit (Error With Rate Limiter)";
$globalratelimitcount = rtrim(substr(file_get_contents("/notifications/global-rate-limit.txt", FILE_USE_INCLUDE_PATH), 0, 2));
if (!preg_match("/[^0-9]/", $globalratelimitcount)) {
    $grlv++;
    if ((strlen($globalratelimitcount) == 1) || (strlen($globalratelimitcount) == 2)) {
        $grlv++;
        if (!(($globalratelimitcount >= 0) && ($globalratelimitcount <= 20))) {
            $grlerror = "Global Rate Limit Reached - Please Try Again Later";
        } elseif ($grlv == 2) {
            $grl = 0;
            unset($grlerror);
        }
    }
}

$ipv = 0;
$iperror = "Unable To Parse IP Address";
$requestip = rtrim(substr($_SERVER["REMOTE_ADDR"], 0, 45));
if (!preg_match("/[^a-f0-9.:]/", $requestip)) {
    $ipv++;
    if ((strlen($requestip) >= 7) && (strlen($requestip) <= 45)) {
        $ipv++;
        if (filter_var($requestip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE)) {
            $ipv++;
            if ($ipv == 3) {
                $allowcharsip = "abcdef0123456789.:";
                $checkip = str_split($requestip, 1);
                $ipcharverifications = 0;
                $ipcurrentchar = 0;
                foreach ($checkip as $checkipchar) {
                    if (strpos($allowcharsip, $checkipchar) > -1) {
                        $ipcharverifications++;
                        $finalipa[$ipcurrentchar] = $allowcharsip[strpos($allowcharsip, $checkipchar)];
                        $ipcurrentchar++;
                    } else {
                        $ipcharverifications = -512;
                    }
                }
                if (($ipcharverifications >= 7) && ($ipv == 3)) {
                    $finalip = implode("", $finalipa);
                    unset($iperror);
                }
            }
        }
    }
}

$iprl = 1;
$iprlerror = "IP Rate Limit Reached - Please Try Again Later";
if (!(substr_count(file_get_contents("/notifications/ip-rate-limit.txt", FILE_USE_INCLUDE_PATH), "!" . $finalip . "!") >= 5)) {
    $iprl = 0;
    unset($iprlerror);
}

$cv = 0;
$captchasolved = 0;
$captchaerror = "Incorrect Captcha Answer";
$captchaa = random_int(1, 9);
$captchab = random_int(1, 9);
$captchaans = $captchaa + $captchab;
$answer = strtolower(rtrim(substr($_GET["answer"], 0, 2)));
if (!empty($answer)) {
    $cv++;
    if (!preg_match("/[^1-9]/", $answer)) {
        $cv++;
        if ((strlen($answer)) == 1 || (strlen($answer) == 2)) {
            $cv++;
            if ($cv == 3) {
                if ($answer == $_SESSION["captchaans"]) {
                    $captchasolved = 1;
                    unset($captchaerror);
                }
            }
        }
    }
} else {
    $captchaerror = "Please Solve The Captcha";
}
$_SESSION["captchaans"] = $captchaans;

$akv = 0;
$finalak = "0";
$apikey = strtolower(rtrim(substr(file_get_contents("/notifications/api-key.txt", FILE_USE_INCLUDE_PATH), 4, 36)));
if (!preg_match("/[^a-z0-9]/", $apikey)) {
    $akv++;
    if (strlen($apikey) == 32) {
        $akv++;
        if ($akv == 2) {
            $allowcharsak = "abcdefghijklmnopqrstuvwxyz0123456789";
            $checkak = str_split($apikey, 1);
            $akcharverifications = 0;
            $akcurrentchar = 0;
            foreach ($checkak as $checkakchar) {
                if (strpos($allowcharsak, $checkakchar) > -1) {
                    $akcharverifications++;
                    $finalaka[$akcurrentchar] = $allowcharsak[strpos($allowcharsak, $checkakchar)];
                    $akcurrentchar++;
                } else {
                    $akerror = 1;
                    $akcharverifications = -512;
                }
            }
            if ((!isset($akerror)) && ($akcharverifications == 32) && ($akv == 2)) {
                $finalak = implode("", $finalaka);
            }
        }
    }
}

$vcv = 0;
$verify = strtolower(rtrim(substr($_GET["verify"], 0, 64)));
if (!empty($verify)) {
    $vcv++;
    if (!preg_match("/[^a-z0-9]/", $verify)) {
        $vcv++;
        if (strlen($verify) == 8) {
            $vcv++;
            if ($vcv == 3) {
                $allowcharsvc = "abcdefghijklmnopqrstuvwxyz0123456789";
                $checkvc = str_split($verify, 1);
                $vccharverifications = 0;
                $vccurrentchar = 0;
                foreach ($checkvc as $checkvcchar) {
                    if (strpos($allowcharsvc, $checkvcchar) > -1) {
                        $vccharverifications++;
                        $finalvca[$vccurrentchar] = $allowcharsvc[strpos($allowcharsvc, $checkvcchar)];
                        $vccurrentchar++;
                    } else {
                        $vcerror = "Verification Code Contains Invalid Characters";
                        $vccharverifications = -512;
                    }
                }
                if ((!isset($vcerror)) && ($vccharverifications == 8) && ($vcv == 3)) {
                    $finalvc = implode("", $finalvca);
                    if (file_exists("verify/" . $finalvc . "/index.php")) {
                        header("Location: /notifications/verify/" . $finalvc . "/");
                        exit();
                    } else {
                        $vcerror = "Incorrect Verification Code";
                    }
                }
            } else {
                $vcerror = "Verification Code Verification Failed";
            }
        } elseif (strlen($verify) > 8) {
            $vcerror = "Verification Code Too Long";
        } else {
            $vcerror = "Verification Code Too Short";
        }
    } else {
        $vcerror = "Verification Code Contains Invalid Characters";
    }
} else {
    $vcerror = "No Code Entered";
}

$verifications = 0;
$email = strtolower(rtrim(substr($_GET["email"], 0, 96)));
if (!empty($email)) {
    $verifications++;
    if (!preg_match("/[^a-z0-9@._+-]/", $email)) {
        $verifications++;
        $email = filter_var($email, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        $splitemail = explode("@", $email);
        if (count($splitemail) == 2) {
            $verifications++;
            $name = strtolower(rtrim(substr($splitemail[0], 0, 91)));
            $domain = strtolower(rtrim(substr($splitemail[1], 0, 94)));
            if (!preg_match("/[^a-z0-9._+-]/", $name)) {
                $verifications++;
                if (preg_match("/^[a-z0-9].*[a-z0-9]$/", $name)) {
                    $verifications++;
                    if (!preg_match("/[^a-z0-9.-]/", $domain)) {
                        $verifications++;
                        if (preg_match("/^[a-z0-9]..*[a-z]$/", $domain)) {
                            $verifications++;
                            if (filter_var($name . "@" . $domain, FILTER_VALIDATE_EMAIL)) {
                                $verifications++;
                                if ($verifications == 8) {
                                    $allowcharsname = "abcdefghijklmnopqrstuvwxyz0123456789._+-";
                                    $allowcharsdomain = "abcdefghijklmnopqrstuvwxyz0123456789.-";
                                    $checkname = str_split($name, 1);
                                    $checkdomain = str_split($domain, 1);
                                    $charverifications = 0;
                                    $currentchar = 0;
                                    foreach ($checkname as $checknamechar) {
                                        if (strpos($allowcharsname, $checknamechar) > -1) {
                                            $charverifications++;
                                            $finalname[$currentchar] = $allowcharsname[strpos($allowcharsname, $checknamechar)];
                                            $currentchar++;
                                        } else {
                                            $error = "Email Name Contains Invalid Characters";
                                            $charverifications = -512;
                                        }
                                    }
                                    $currentchar = 0;
                                    foreach ($checkdomain as $checkdomainchar) {
                                        if (strpos($allowcharsdomain, $checkdomainchar) > -1) {
                                            $charverifications++;
                                            $finaldomain[$currentchar] = $allowcharsdomain[strpos($allowcharsdomain, $checkdomainchar)];
                                            $currentchar++;
                                        } else {
                                            $error = "Domain Contains Invalid Characters.";
                                            $charverifications = -512;
                                        }
                                    }
                                    if ((!isset($error)) && ($charverifications >= 6) && ($verifications == 8)) {
                                        $finalemail = implode("", $finalname) . "@" . implode("", $finaldomain);
                                    }
                                } else {
                                    $error = "Email Verification Failed";
                                }
                            } else {
                                $error = "Email Validation Failed";
                            }
                        } else {
                            $error = "Invalid Domain";
                        }
                    } else {
                        $error = "Domain Contains Invalid Characters";
                    }
                } else {
                    $error = "Email Name Starts or Ends With Invalid Character";
                }
            } else {
                $error = "Email Name Contains Invalid Characters";
            }
        } elseif (count($splitemail) > 2) {
            $error = "Too Many @ Symbols";
        } else {
            $error = "No @ Symbol";
        }
    } else {
        $error = "Invalid Characters in Email Address";
    }
} ?>

<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Email Notifications</title>
    <meta name="description" content="Subscribe to email notifications for new content on jamieweb.net.">
    <meta name="keywords" content="Jamie, Scaife, jamie scaife, jamiescaife, jamieonubuntu, jamie90437, jamie90437x, jamieweb, jamieweb.net">
    <meta name="author" content="Jamie Scaife">
    <link href="/jamie.css" rel="stylesheet">
    <link href="https://www.jamieweb.net/notifications/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body email-form">
    <h1>Email Notifications</h1>
    <hr>
    <p>Subscribe to receive email notifications when I post new content.</p>
    <p>Feel free to read about how your email address will be treated: <a href="/privacy/">Email Privacy</a></p>
    <!--<p>You can also read my blog post about the email notification system <a href="/blog/email-notification-system/">here</a>.</p>-->
    <p>Alternatively, you can subsribe to the <a href="/rss.xml">RSS feed</a>.</p>
    <!--<p>Before you sign up, you can <a href="/notifications/process/">have a look at the process</a> so that you know what to expect.</p>-->
    <form action="/notifications/" method="get">
        <input class="email-address" name="email" type="text" value="<?php set_time_limit(1); echo htmlspecialchars($email); ?>" placeholder="name@example.com" maxlength="96"><br>
<?php set_time_limit(1); echo "<p class=\"email-question\">" . htmlspecialchars($captchaa) . " <img src=\"/images/plus.png\" width=\"14px\" alt=\"Plus\"> " . htmlspecialchars($captchab) . " <img src=\"/images/equals.png\" width=\"14px\" alt=\"Equals\"><input class=\"email-answerverify\" name=\"answer\" type=\"number\" placeholder=\"Answer\"></p>"; ?>
        <input name="phpsessid" type="hidden" value="<?php set_time_limit(1); echo htmlspecialchars($sessionid); ?>">
        <input class="email-submit" value="Subscribe" type="submit">
    </form>
<?php set_time_limit(5);
if ((isset($finalemail)) && (!isset($error)) && ($charverifications >= 6) && ($verifications == 8)) {
    if (!($grl == 0) || !($iprl == 0) || (isset($grlerror)) || (isset($iprlerror))) {
        if (!($iprl == 0)) {
            echo "<p class=\"email-text\">Error: <span>" . htmlspecialchars($iprlerror) . "</span></p>";
        } elseif (!($grl == 0)) {
            echo "<p class=\"email-text\">Error: <span>" . htmlspecialchars($grlerror) . "</span></p>";
        } else {
            echo "<p class=\"email-text\">Error: <span>Rate Limited (Error With Rate Limiter)</span></p>";
        }
    } elseif (strpos(shell_exec("cat verify/*/email.txt"), "!" . $finalemail . "!") > -1) {
        //usleep(1700000); //Delay to help prevent enumeration of ongoing verifications - not possible currently due to captcha

        echo "<p class=\"email-text\">A verification email has been sent to <b>" . htmlspecialchars($finalemail) . "</b>.<br/>Please enter the verification code from the email in the box below:</p>
        <form action=\"/notifications/\" method=\"get\">
            <input name=\"email\" type=\"hidden\" value=\"" . htmlspecialchars($finalemail) . "\">
            <input class=\"email-answerverify\" name=\"verify\" type=\"text\" placeholder=\"Verification Code\"><br>
            <input class=\"email-submit\" value=\"Verify Code\" type=\"submit\">
        </form>";
        if (isset($vcerror)) {
            echo "<p class=\"email-text\">Error: <span>" . htmlspecialchars($vcerror) . "</span></p>";
        }
    } elseif (($captchasolved == 1) && !(preg_match("/of mailing list List\(notifications@mailgun.jamieweb.net\) not found\"/", shell_exec("./rate-limit.sh add && curl -s --user 'api:key-" . escapeshellcmd($finalak) . "' -X PUT https://api.mailgun.net/v3/lists/notifications@mailgun.jamieweb.net/members/" . escapeshellcmd($finalemail))))) {
        usleep(950000); //Delay to help prevent time-based enumeration of subscribed addresses
        echo "<p class=\"email-text\">A verification email has been sent to <b>" . htmlspecialchars($finalemail) . "</b>.<br/>Please enter the verification code from the email in the box below:</p>
        <form action=\"/notifications/\" method=\"get\">
            <input name=\"email\" type=\"hidden\" value=\"" . htmlspecialchars($finalemail) . "\">
            <input class=\"email-answerverify\" name=\"verify\" type=\"text\" placeholder=\"Verification Code\"><br>
            <input class=\"email-submit\" value=\"Verify Code\" type=\"submit\">
        </form>
        <p class=\"email-text\">Please note that if you are already subscribed, you will not receive a verification code.<br/>To unsubscribe, visit the link at the bottom of a notification email.</p>";
    } elseif ($captchasolved == 1) {
        //shell_exec("./rate-limit.sh add");
        file_put_contents("/notifications/ip-rate-limit.txt", "!" . htmlspecialchars($finalip) . "!\n", FILE_APPEND | LOCK_EX | FILE_USE_INCLUDE_PATH);
        $messagesource = file_get_contents("/notifications/verification-message.txt", FILE_USE_INCLUDE_PATH);
        if (hash("sha256", $messagesource) == "999fb1523146e1d4f54d6eff769957ad5ef92040f3d863e93551768875ccadc4") {
            $verificationcodegenerated = 0;
            while ($verificationcodegenerated == 0) {
                $verificationcodesource = shell_exec("head -n 5 /dev/urandom | egrep -ao [abcdefghijklmnopqrstuvwxyz0-9] | tr -d \"\n\"");
                if (!preg_match("/[^a-z0-9]/", $verificationcodesource)) {
                    if (strlen($verificationcodesource) >= 8) {
                        $verificationcode = substr($verificationcodesource, 0, 8);
                        $verificationcodegenerated = 1;
                    }
                }
            }
            $message = str_replace("ipPlaceholder", htmlspecialchars($finalip), str_replace("verificationCodePlaceholder", htmlspecialchars($verificationcode), str_replace("emailPlaceholder", htmlspecialchars($finalemail), $messagesource)));
            if (preg_match("/\"message\": \"Queued. Thank you.\"/", shell_exec("curl --user 'api:key-" . escapeshellcmd($finalak) . "' https://api.mailgun.net/v3/mailgun.jamieweb.net/messages -F from='JamieWeb <noreply@jamieweb.net>' -F to='" . escapeshellcmd($finalemail) . "' -F subject='jamieweb.net - Please Confirm Your Notifications Subscription' -F o:tag='Verification Email' --form-string html=\"" . $message . "\""))) {
                echo "<p class=\"email-text\">A verification email has been sent to <b>" . htmlspecialchars($finalemail) . "</b>.<br/>Please enter the verification code from the email in the box below:</p>
                <form action=\"/notifications/\" method=\"get\">
                    <input name=\"email\" type=\"hidden\" value=\"" . htmlspecialchars($finalemail) . "\">
                    <input class=\"email-answerverify\" name=\"verify\" type=\"text\" placeholder=\"Verification Code\"><br>
                    <input class=\"email-submit\" value=\"Verify Code\" type=\"submit\">
                </form>
                <p class=\"email-text\">Please note that if you are already subscribed, you will not receive a verification code.<br/>To unsubscribe, visit the link at the bottom of a notification email.</p>";
                if ((strlen($verificationcode) == 8) && ($verificationcodegenerated == 1)) {
                    $verifiedpagesource = file_get_contents("/notifications/verification-page.txt", FILE_USE_INCLUDE_PATH);
                    if (hash("sha256", $verifiedpagesource) == "9b570857261c2965213e2f6a39ae9ee5f05f0056ebffa1e66d48e38356feb1e1") {
                        $verifiedpage = str_replace("ipPlaceholder", htmlspecialchars($finalip), str_replace("emailPlaceholder", htmlspecialchars($finalemail), $verifiedpagesource));
                        if (!preg_match("/[^a-z0-9]/", $verificationcode)) {
                            if (!file_exists("verify/" . $verificationcode)) {
                                usleep(150000);
                                shell_exec("mkdir /notifications/verify/" . escapeshellcmd($verificationcode));
                                usleep(150000);
                                file_put_contents("/notifications/verify/" . $verificationcode . "/index.php", $verifiedpage, FILE_USE_INCLUDE_PATH);
                                usleep(150000);
                                file_put_contents("/notifications/verify/" . $verificationcode . "/email.txt", "!" . htmlspecialchars($finalemail) . "!", FILE_USE_INCLUDE_PATH);
                            } else {
                                $mailerror = "Verification Code Already In Use";
                            }
                        } else {
                            $mailerror = "Unable To Use Verification Code (Invalid Characters)";
                        }
                    } else {
                        $mailerror = "Unable To Generate Verification Page (Hash Mismatch)";
                    }
                } else {
                    $mailerror = "Error While Generating Verification Code";
                }
            } else {
                $mailerror = "Unable To Send Verification Email (Mail Server Error)";
            }
        } else {
            $mailerror = "Unable To Generate Verification Message (Hash Mismatch)";
        }
        if (isset($mailerror)) {
            echo "<p class=\"email-text\">Error: <span>" . htmlspecialchars($mailerror) . "</span></p>";
        }
    } else {
        echo "<p class=\"email-text\">Error: <span>" . htmlspecialchars($captchaerror) . "</span></p>";
    }
} elseif (isset($error)) {
    echo "<p class=\"email-text\">Error: <span>" . htmlspecialchars($error) . "</span></p>";
} ?>
</div>

<?php include "footer.php" ?>

</body>

</html>
