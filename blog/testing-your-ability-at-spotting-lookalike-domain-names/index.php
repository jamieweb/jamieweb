<?php include "response-headers.php"; content_security_policy();
include_once "bloglist.php"; bloglist("postTop", null, null, 2020); ?>

<div class="body">
    <h1><?php echo $postInfo->title; ?></h1>
    <hr>
    <p><b><?php echo $postInfo->date; ?></b></p>
    <p><?php echo $postInfo->snippet; ?></p>
    <p>I have created a web-based JavaScript app/game which allows you test your ability at spotting potential lookalike or phishing domains in real-time.</p>
    <img class="radius-8 exempt" src="lookalike-domains-test-example.png">
    <p class="two-no-mar centertext"><i>A screenshot of the Lookalike Domain Names Test app, showing a lookalike domain for 'example.com'.</i></p>
    <p>The app displays the domain name of a well-known website, with a random set of permutations applied to it. You must then select whether the domain is 'Real' or a 'Lookalike'.</p>
    <p>The permutations used are in-line with some of the techniques used by real scammers to create lookalike domain names. Lookalike domain names are a very effective phishing technique, as they exploit the way that the human brain interprets writing. The brain will automatically make assumptions and fill in gaps when reading, allowing users to be easily fooled if a phishing domain looks almost identical to a legitimate site.</p>
    <p><b>Skip to Section:</b></p>
    <pre><b><?php echo $postInfo->title ?></b>
&#x2523&#x2501&#x2501 <a href="#why-did-i-create-the-app">Why did I create the app?</a>
&#x2523&#x2501&#x2501 <a href="#predictions-and-findings">Predictions and Findings</a>
&#x2523&#x2501&#x2501 <a href="#how-does-the-app-work">How does the app work?</a>
&#x2523&#x2501&#x2501 <a href="#permutation-methods">Permutation Methods</a>
&#x2523&#x2501&#x2501 <a href="#content-security-policy-and-subresource-integrity">Content Security Policy and Subresource Integrity</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>

    <h2 id="why-did-i-create-the-app">Why did I create the app?</h2>
    <p>Ever since I became interested in IT security, one of my primary concerns and interests has been lookalike domains and how they can be used to conduct convincing phishing attacks.</p>
    <p>My first piece of work in this space was my <a href="/projects/#chrome-site-whitelist-extension" target="_blank">Chrome Site Whitelist Extension</a> from March 2017, which is a simple browser extension to help users avoid phishing sites in Google search results by highlighting a user-controlled whitelist of sites in green.</p>
    <div class="centertext">
        <img class="radius-8 max-width-100-percent border-2px-solid" src="/projects/chrome-site-whitelist-extension/example-result-highlighting.png">
    </div>
    <p class="two-no-mar centertext"><i>A screenshot of my Chrome Site Whitelist Extension in action, showing the two whitelisted sites highlighted in green.</i></p>
    <p>I've always wondered about my own ability to quickly identify these lookalike domain names, which is what prompted me to create the Lookalike Domain Names Test. I wanted it to be somewhat fun and interactive, so I opted to gamify it a bit by recording the users' score over 10 rounds and displaying it to them at the end.</p>
    <img class="radius-8" width="1000px" src="lookalike-domain-test-congratulations.png">
    <p class="two-no-mar centertext"><i>A screenshot of the end-screen in the Lookalike Domain Names Test, showing that the user scored 10 out of 10.</i></p>
    <p>This project is also the first time that I have allowed myself to utilise JavaScript on my website. Back in 2016 when I started this version of my site, one of the core design decisions was that the site would be compltely JavaScript-free, in order to improve performance, security, accessibility and readability. As part of this project, I have now decided to relax this decision ever so slightly in order to allow for the creation of JavaScript 'apps' in select areas of the site. Friendliness to non-JavaScript users is still a core value of my site, and JavaScript will only be used for specifc 'apps' that cannot otherwise be created using raw HTML5/CSS3.</p>

    <h2 id="predictions-and-findings">Predictions and Findings</h2>
    <p>My predictions prior to creating and using the app were that it would be challenging to reliably identify lookalike domains that are almost visually identical when only glancing at them (spending around 1 second on each round), and that the accuracy rate would increase significantly if 5 seconds were to be spent per round. This prediction was because this is an inherent trait of the human brain and how it interprets strings of text (as I mentioned in the first section of this article).</p>
    <p>My actual findings after I had created the app show that, within about 1 second, it is easier than expected to identify permutations where characters had been added/removed, or had their order changed. However, permutations involving certain lookalike/substitute characters, for example <code>m</code> and <code>rn</code>, were able to semi-consistently catch the user out. When spending longer than 1 second on each round, the success rate increased significantly, with only almost visually identical permutations still catching the user out.</p>
    <p>This was absolutely not a scientific study, as it used a very small sample size and users were of course expecting there to be permutations and specifically looking for them (thus increasing the success rate). However, it gives a rough indication of the potential results of a much larger scale and more accurate study.</p>

    <h2 id="how-does-the-app-work">How does the app work?</h2>
    <p>The app is written is vanilla/plain JavaScript, and uses click event listeners in order to allow the user to interact with it. The app is entirely client-side and does not send or receive any data, nor does it store any data locally (no cookies, etc).</p>
    <p>The core functionality of the app uses a hard-coded list of well-known domain names, based on the top websites worldwide, in the United Kingdom and in the United States. A random domain name is picked for each round, and then domain name text is run through a randomised permutation function.</p>
    <p>This permutation function may swap characters around, delete characters, substritute visually similar characters, or do nothing at all. The resulting domain name text is then presented to the user, and they must click the answer they believe to be correct. If the domain on the screen matches the one that was originally picked at random, this means that no permutation took place, so the correct answer is 'Real'. If the domain on the screen doesn't match the one that was originally picked, this means that a permutation must have taken place, so the correct answer is 'Lookalike'.</p>
    <p>The users' score is recorded throughout, and is then displayed to them on the end screen once 10 rounds have been completed.</p>

    <h2 id="permutation-methods">Permutation Methods</h2>
    <p>There are several different permutation functions built-in to the app, one of which is picked at random for each round. I've included copies of each of them below for reference:</p>
    <h3><code>noop()</code>:</h3>
    <p>Do nothing (no operation). Used to apply no permutation to a domain.</p>
    <pre>function noop(str) {
  return(str);
}</pre>
    <h3><code>lookalikeChars()</code>:</h3>
    <p>Replace a character with a visually-similar character.</p>
    <pre>var lookalikes = [
  ["b", "p"],
  ["l", "I"],
  ["m", "rn"],
  ["m", "n"],
  ["o", "0"],
  ["u", "v"],
  ["v", "u"]
];
function lookalikeChars(str) {
  #Pick a random pair of lookalike characters
  var lookalike = lookalikes[Math.floor(Math.random() * lookalikes.length)];
  #Replace lookalike character within domain string (if any)
  return str.replace(lookalike[0], lookalike[1]);
}</pre>
    <h3><code>swapChars()</code>:</h3>
    <p>Swap two adjacent characters within the domain.</p>
    <pre>function swapChars(str) {
  //Split string into array of chars
  var splitStr = str.split("");
  //Pick a random char number between 0 and the second-last before the dot
  var randChar = Math.floor(Math.random() * (str.split(".")[0].length - 1));
  //Store the character to swap
  var swapChar = splitStr[randChar + 1];
  //Swap the characters
  splitStr[randChar + 1] = splitStr[randChar];
  splitStr[randChar] = swapChar;
  //Join and return the array as a string
  return splitStr.join("");
}</pre>
    <h3><code>dupeChars()</code>:</h3>
    <p>Duplicate a random character within the domain.</p>
    <pre>function dupeChars(str) {
  //Split string into array of chars
  var splitStr = str.split("");
  //Pick a random char number between 0 and the last before the dot
  var randChar = Math.floor(Math.random() * str.split(".")[0].length);
  //Duplicate character at index
  splitStr.splice(randChar, 0, splitStr[randChar]);
  //Join and return the array as a string
  return splitStr.join("");
}</pre>
    <h3><code>delChars()</code>:</h3>
    <p>Delete a random character within the domain.</p>
    <pre>function delChars(str) {
  //Split string into array of chars
  var splitStr = str.split("");
  //Pick a random char number between 0 ad the last before the dot
  var randChar = Math.floor(Math.random() * str.split(".")[0].length);
  //Remove character at index
  splitStr[randChar] = "";
  //Join and return the array as a string
  return splitStr.join("");
}</pre>

    <h2 id="content-security-policy-and-subresource-integrity">Content Security Policy and Subresource Integrity</h2>
    <p>One of the primary considerations in creating the app was security. Specifically, ensuring that the app is compliant with the <a href="/blog/taking-content-security-policy-to-the-extreme-policies-on-a-per-page-basis/" target="_blank">extremely tight Content Security Policy (CSP) that is present on my site</a>. I used the per-page policy features described in the article linked above to enable JavaScript just for the page that the app runs on, and nowhere else on the site.</p>
    <p>The custom Content Security Policy directives are specified in the PHP code for the app page, resulting in the default site-wide header being built upon to allow JavaScript to run on the app page only:</p>
    <pre>content_security_policy(["script-src" => "'self'", "require-sri-for" => "script"]);</pre>
    <p>All JavaScript code is loaded from my own site (on the same origin), so I do not need to whitelist any third-party sources. JavaScript <a href="https://www.w3schools.com/js/js_htmldom_eventlistener.asp" target="_blank" rel="noopener">event listeners</a> are to used to listen for clicks on interactive elements in the DOM (buttons), instead of using the traditional HTML '<code>onclick=</code>' attribute.</p>
    <pre>var eventListeners = [
  ["answer-button-lookalike", answerLookalike],
  ["answer-button-real", answerReal],
  ["disclaimer-accept-button", startApp],
  ["next-button-input", nextRound],
  ["restart-button", resetApp],
  ["start-button", startApp]
]
eventListeners.forEach(createEventListeners);
function createEventListeners(eventListener) {
  document.getElementById(eventListener[0]).addEventListener("click", eventListener[1]);
}</pre>
    <p>The integrity of the code is also verified using <a href="https://developer.mozilla.org/en-US/docs/Web/Security/Subresource_Integrity" target="_blank" rel="noopener">Subresource Integrity (SRI)</a>, and the <code>require-sri-for</code> CSP directive is used to ensure that script can only run if it has passed an SRI check (<code>require-sri-for</code> is not yet widely supported in modern browsers, but is a draft feature that will be supported in the future).</p>
    <p>The PHP page for the app includes the '<code>integrity=</code>' attribute, as well as a SHA-384 hash (binary hash output encoded in base 64) of the JavaScript source file:</p>
    <pre>&lt;script src="lookalike-domains-test.js" integrity="sha384-PCCWbBnQRkcTkpyxLGiE/cHP59k0eimC5MLmUDujpwdCr3rKjcmnET5QstKOFgA4"&gt;&lt;/script&gt;</pre>
    <p>For reference, hashes for use with SRI can be generated using the following:</p>
    <pre>$ openssl dgst -sha384 -binary <i>file.js</i> | base64</pre>
    <p>Each time the file changes, you'll need to generate a new hash and update the '<code>integrity=</code>' attribute(s).</p>

    <h2 id="conclusion">Conclusion</h2>
    <p></p>
</div>

<?php include "footer.php" ?>
