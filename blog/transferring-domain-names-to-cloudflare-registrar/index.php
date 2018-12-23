<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Transferring Domain Names to Cloudflare Registrar</title>
    <meta name="description" content="Documentation on the transfer-in process for Cloudflare Registrar.">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/blog/transferring-domain-names-to-cloudflare-registrar/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Transferring Domain Names to Cloudflare Registrar</h1>
    <hr>
    <p><b>Sunday 23rd December 2018</b></p>
    <p>This week I transferred all of my domain names to the brand new <a href="https://www.cloudflare.com/products/registrar/" target="_blank" rel="noopener">Cloudflare Registrar</a>. I took screenshots throughout the process and have documented them here for anybody else who has not yet done the transfer, and wants to know what to expect before diving in.</p>
    <img class="radius-8" src="cloudflare-registrar-overview.png" width="1000px" title="The Cloudflare Registrar Product Page" alt="A screenshot of the Cloudflare Registrar product page.">
    <p class="two-no-mar centertext"><i>The Cloudflare Registrar Product page at: <a href="https://www.cloudflare.com/products/registrar/" target="_blank" rel="noopener">https://www.cloudflare.com/products/registrar/</a></i></p>
    <p>In my case, I did a bulk transfer of all of my domains except for the most important one at first, then once I could see that everything was going through properly, I transferred jamieweb.net as well.</p> 
    <h2 id="the-transfer-process">The Transfer Process</h2>
    <p>In order to transfer domain names to Cloudflare, they must already be activated in your Cloudflare account and have thier name servers pointing to Cloudflare. Once you have transferred your domain names in, you cannot use external name servers - you are locked to using Cloudflare's own.</p>
    <p>After clicking onto the domain registration area of your Cloudflare dashboard, you will be immediately prompted to verify your email address. You email address is probably already verified for your Cloudflare account, but this extra verification is required in order to be compliant with the ICANN regulations.</p>
    <img class="radius-8" src="cloudflare-domain-transfer-verify-email.png" width="1000px" title="Verifying my Email Address" alt="A screenshot of prompt to verify my email address.">
    <p class="two-no-mar centertext"><i>Cloudflare Registrar prompting me to verify my email address.</i></p>
    <p>Even though my Cloudflare account email address is different to the one used on WHOIS, the verification was still required.</p>
    <p>This sent an email to the address with a link to verify the address. I really dislike it when you are required you visit untrusted links in emails in order to verify things or perform actions. I personally would really like to see more websites that send verification codes that you can easily copy and paste or type in, rather than links. If the code is the right length then this wouldn't be a problem for users who open the email on a different device to where the verification is required.</p>
    <p>I forwarded the email to a disposable sandbox machine where I could safely click the link in order to verify the email address. I clicked the link...</p>
    <img class="radius-8" src="cloudflare-domain-transfer-log-in-to-verify-email.png" width="1000px" title="Verify the Email Address of your Cloudflare Account by Logging In" alt="A screenshot of Cloudflare prompting me to log in with my username and password in order to verify my email address.">
    <p class="two-no-mar centertext"><i>Cloudflare prompting me to log in with my username and password in order to verify my email address.</i></p>
    <p>Unfortunately it required me to log in with my username and password in order to verify the email address. It's poor security practise to provide credentials after clicking a link, especially to Cloudflare which is probably one of the most important accounts people own. Maybe it was a strange ICANN rule requiring the log in?</p>
    <p>I contacted Cloudflare support to raise my concerns over this and ask whether it could be changed to not require logging in. They responded promptly saying that they had asked the relevant team if this could be changed, which is a positive and security-first response.</p>
    <p>In order to get around this limitation temporarily, I signed into Cloudflare using an incognito tab, then copied the path and query strings from the veritication URL and added them to the pre-filled Cloudflare scheme, host and domain name from my bookmark. The result of this is that when visiting the link, the network location is not untrusted, which greatly reduces the risk of the untrusted link.</p>
    <img class="radius-8" src="cloudflare-domain-transfer-email-verification-complete.png" width="1000px" title="Your Email Address Is Now Verified" alt="A screenshot of Cloudflare indicating that my email address is now verified.">
    <p class="two-no-mar centertext"><i>Cloudflare indicating that my email address is now verified.</i></p>
    <p>Next, you need to add a payment method if you haven't already, which is easy enough.</p>
    <img class="radius-8" src="cloudflare-domain-transfer-add-payment-method.png" width="1000px" title="In Order to Transfer Domains, You Must Add a Payment Method" alt="A screenshot of Cloudflare prompting me to add a payment method to continue.">
    <p class="two-no-mar centertext"><i>Cloudflare prompting me to add a payment method to continue.</i></p>
    <p>Once a payment method has been added if required, you can proceed to select the domains you wish to transfer.</p>
    <img class="radius-8" src="cloudflare-domain-transfer-select-domains.png" width="1000px" title="Selecting the Domain Names to Transfer" alt="A screenshot of the domain name selection screen for choosing which domain names to transfer to Cloudflare.">
    <p class="two-no-mar centertext"><i>The domain name selection screen for choosing which domain names to transfer to Cloudflare.</i></p>
    <p>Once you have confirmed your selection, an instructions screen is presented.</p>
    <img class="radius-8" src="cloudflare-domain-transfer-start-transfer.png" width="1000px" title="Instructions on Transferring Your Domain Names to Cloudflare" alt="A screenshot of the domain name transfer instructions screen.">
    <p class="two-no-mar centertext"><i>The domain name transfer instructions screen.</i></p>
    <p>In my case, I logged in to Hover (my previous registrar) and disabled the domain transfer lock.</p>
    <img class="radius-8" src="cloudflare-domain-transfer-hover-dashboard.png" width="1000px" title="The Hover Dashboard for jamieweb.net" alt="A screenshot of the Hover dashboard for jamieweb.net.">
    <p class="two-no-mar centertext"><i>The Hover dashboard for jamieweb.net.</i></p>
    <br>
    <img class="radius-8" src="cloudflare-domain-transfer-hover-disable-transfer-lock.png" width="1000px" title="Disabling Transfer Lock for jamieweb.net in the Hover Dashboard" alt="A screenshot of disabling transfer lock for jamieweb.net in the Hover dashboard.">
    <p class="two-no-mar centertext"><i>Disabling transfer lock for jamieweb.net in the Hover dashboard.</i></p>
    <p>Once you have disabled transfer lock, you can request or generate a transfer authorization code for your domain, then enter it into Cloudflare.</p>
    <img class="radius-8" src="cloudflare-domain-transfer-enter-authorization-code.png" width="1000px" title="A Prompt to Enter the Transfer Authorization Code Into Cloudflare" alt="A screenshot of the prompt to enter the domain name transfer authorization code.">
    <p class="two-no-mar centertext"><i>Entering the transfer authorization code into Cloudflare.</i></p>
    <p>Once the authorization code has been accepted, you can set the domain name contatc information that will be used in WHOIS.</p>
    <img class="radius-8" src="cloudflare-domain-transfer-enter-contact-information.png" width="1000px" title="Entering the Desired WHOIS Contact Information for jamieweb.net" alt="A screenshot of form for entering the desired WHOIS contact information for jamieweb.net.">
    <p class="two-no-mar centertext"><i>Entering the desired WHOIS contact information for jamieweb.net.</i></p>
    <p>Finally, you can finalize and accept the transfer.</p>
    <img class="radius-8" src="cloudflare-domain-transfer-finalize-and-transfer.png" width="1000px" title="Finalize and Transfer" alt="A screenshot the final confirmation button for transferring your domain to Cloudflare.">
    <p class="two-no-mar centertext"><i>The final transfer confirmation button.</i></p>
    <br>
    <img class="radius-8" src="cloudflare-domain-transfer-now-underway.png" width="1000px" title="You Transfers are Now Underway" alt="A screenshot of the final confirmation screen.">
    <p class="two-no-mar centertext"><i>The final confirmation screen.</i></p>
    <p>Once the transfer is underway, the domain name status box in your domain settings on Cloudflare will show that the transfer approval is pending.</p>
    <div class="centertext"><img class="radius-8" src="cloudflare-domain-transfer-pending.png" title="Transfer Pending" alt="A screenshot of the domain name status box showing that the transfer approval is pending."></div>
    <p class="two-no-mar centertext"><i>The domain name status box showing that the transfer approval is pending.</i></p>
    <p>The transfer may take a few days to go through. In my own case, transferring from Hover took around 5 days. Once the transfer is complete, you will receive an email and the domain name status box will show it as well.</p>
    <div class="centertext"><img class="radius-8" src="cloudflare-domain-transfer-complete.png" title="Domain Registration - On Cloudflare" alt="A screenshot of the domain name status box showing that the domain name registration is now with Cloudflare."></div>
    <p class="two-no-mar centertext"><i>The domain name status box showing that the domain name registration is now on Cloudflare.</i></p>
    <h2 id="conclusion">Conclusion</h2>
    <p>The transfer process was extremely straightforward and free of complications. Once I had started the transfer I just let it do it's thing, and I was confident that the transfer would go through without any problems. DNSSEC continued to work after the transfer too, without requiring me to manually update the records.</p>
    <p>I've done domain transfers in the past between other registrars, and often it can be a long and convoluted process involving transfer fees and verification pages that look like phishing websites. This was definitely not the case when transferring between Hover and Cloudflare.</p>
    <p>The restrictions of Cloudflare Registrar are important to note though, such as the fact that you cannot use custom name servers for your domain. I guess that Cloudflare are hoping that you will pay for some of their other services in return for offering the domain names with no markup at wholesale prices.</p>
    <p>I am very happy with Cloudflare Registrar so far, and I will be continuing to use it for my domain names in the future. I also look forward to trying any new features that the service has to offer.</p>
</div>

<?php include "footer.php" ?>

</body>

</html>







