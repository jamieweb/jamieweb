//Define array of domains
var domains = [
  ["Google","google.com"],
  ["Google", "google.co.uk"],
  ["GitHub", "github.com"],
  ["Twitter", "twitter.com"],
  ["Reddit", "reddit.com"],
  ["Microsoft", "microsoft.com"],
  ["Facebook", "facebook.com"],
  ["Instagram", "instagram.com"],
  ["StackOverflow", "stackoverflow.com"],
  ["StackExchange", "stackexchange.com"],
  ["Amazon", "amazon.com"],
  ["Gmail", "gmail.com"],
  ["Yahoo", "yahoo.com"],
  ["YouTube", "youtube.com"],
  ["Wikipedia", "wikipedia.org"],
  ["Outlook", "outlook.com"],
  ["Netflix", "netflix.com"],
  ["Blogspot", "blogspot.com"],
  ["Blogger", "blogger.com"],
  ["Twitter", "twitter.com"],
  ["Apple", "apple.com"],
  ["Wordpress", "wordpress.com"],
  ["Imgur", "imgur.com"],
  ["Dropbox", "dropbox.com"],
  ["LinkedIn", "linkedin.com"],
  ["PayPal", "paypal.com"],
  ["Pinterest", "pinterest.com"],
  ["Booking", "booking.com"],
  ["Samsung", "samsung.com"],
  ["SoundCloud", "soundcloud.com"]
];

//Define array of disallowed permutations
var exceptions = [
  "goole.com",
  "titter.com",
  "witter.com"
]

//Define aray of available permutation functions
var permuteFuncs = [
  noop, noop, noop,
  lookalikeChars,
  swapChars,
  dupeChars,
  delChars
];

//Hide the start screen and show the app
function startApp() {
  if (viewedDisclaimer) {
    //If disclaimer has been viewed already, hide it as well as the start screen, and show main
    elems["disclaimer"].style.display = "none";
    elems["startscreen"].style.display = "none";
    elems["main"].style.display = "block";
  } else {
    //If disclaimer hasn't been viewed yet, hide the start screen and show the disclaimer
    elems["startscreen"].style.display = "none";
    elems["disclaimer"].style.display = "block";
  }
  //Mark disclaimer as read after clicking 'I Understand'
  viewedDisclaimer = 1;
}

//Pick a random domain and display it
function randDomain() {
  //Pick a random domain
  var domain = domains[Math.floor(Math.random() * domains.length)];
  //Pick a random permutation function and run it against the domain
  var permuted = permuteFuncs[Math.floor(Math.random() * permuteFuncs.length)](domain[1]);
  //Check whether the permuted domain matches any exceptions
  if (exceptions.indexOf(permuted) > -1) {
    //If permuted domain matches an exception, scrap the permutations
    permuted = domain[1];
    //It would be better for exceptions to instead cause randDomain to try again, but for the extremely rare case where exceptions are found, it's not worth the extra complexity, and would be non-trivial to implement with the current structure of randDomain
  }
  //Replace dots with a custom span element to prevent accidental hyperlinking
  elems["domain"].innerHTML = permuted.replace(/[.]/g, "<span class=\"fullstop\"></span>");
  //Display site name in answer display
  elems["answer"].innerHTML = "<b>" + domain[0] + "</b>:";
  //Remove colour class from answer display
  elems["answer"].className = "";
  //Check whether the permuted domain is the same as the original (e.g. if there we no permutations applied)
  if (domain[1] == permuted) {
    //If no permutations, correct answer is 'real'
    correctAnswer = "real";
    console.log("Correct answer: " + correctAnswer);
  } else {
    //If there were permutations, correct answer is 'lookalike'
    correctAnswer = "lookalike";
    console.log("Correct answer: " + correctAnswer);
  }
}

//Verify answer
function verifyAnswer(answer) {
  //If submitted answer is equal to the correct answer
  if (answer == correctAnswer) {
    score[0]++;
    console.log("Correct");
    //Show correct in answer display
    showAnswer("Correct");
  //If submitted answer is not equal to correct answer
  } else {
    score[1]++;
    console.log("Incorrect");
    //Show incorrect in answer display
    showAnswer("Incorrect");
  }
  //Update the score display in the top-right
  updateScore();
  //Hide the answer buttons and display the 'next' button
  showNextButton()
}

//Wrapper functions to allow verifyAnswer to be called from the button event handler
function answerReal() { verifyAnswer('real'); }
function answerLookalike() { verifyAnswer('lookalike'); }

function updateScore() {
  elems["score-correct"].innerHTML = score[0];
  elems["score-incorrect"].innerHTML = score[1];
}

function showAnswer(answer) {
  elems["answer"].innerHTML = answer;
  elems["answer"].className = answer;
}

function showAnswerButtons() {
  elems["next-button"].style.display = "none";
  elems["answer-buttons"].style.display = "block";
}

function showNextButton() {
  elems["answer-buttons"].style.display = "none";
  elems["next-button"].style.display = "block";
}

function nextRound() {
  if (roundNo === 9) {
    //Change button text if on the last round
    elems["next-button-input"].value = "Finish";
  }
  if (roundNo >= 10) {
    //End once all rounds have been completed
    endScreen();
  } else {
    //Increment round number
    elems["score-round"].innerHTML = ++roundNo;
  }
  randDomain();
  showAnswerButtons();
}

function endScreen() {
  elems["main"].style.display = "none";
  elems["endscreen"].style.display = "block";
  elems["endscreen-score"].innerHTML = score[0];
}

//Function to reset all variables and HUD elements, then restart the app
function resetApp() {
  elems["score-round"].innerHTML = "1";
  resetVars();
  updateScore();
  showAnswerButtons();
  randDomain();
  elems["endscreen"].style.display = "none";
  startApp();
}

//Permutation functions to apply randomised permutations to the domain and return it as a string

//Permutation function to replace lookalike characters
var lookalikes = [
  ["b", "p"],
  ["l", "I"],
  ["m", "rn"],
  ["m", "n"],
  ["o", "0"],
  ["u", "v"],
  ["v", "u"]
];
function lookalikeChars(str) {
  var lookalike = lookalikes[Math.floor(Math.random() * lookalikes.length)];
  return str.replace(lookalike[0], lookalike[1]);
}

//Permutation function to swap characters
function swapChars(str) {
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
}

//Permutation function to duplicate characters
function dupeChars(str) {
  //Split string into array of chars
  var splitStr = str.split("");
  //Pick a random char number between 0 and the last before the dot
  var randChar = Math.floor(Math.random() * str.split(".")[0].length);
  //Duplicate character at index
  splitStr.splice(randChar, 0, splitStr[randChar]);
  //Join and return the array as a string
  return splitStr.join("");
}

//Permutation function to delete characters
function delChars(str) {
  //Split string into array of chars
  var splitStr = str.split("");
  //Pick a random char number between 0 ad the last before the dot
  var randChar = Math.floor(Math.random() * str.split(".")[0].length);
  //Remove character at index
  splitStr[randChar] = "";
  //Join and return the array as a string
  return splitStr.join("");
}

//Permutation function to do nothing (make no changes to domain)
function noop(str) {
  return(str);
}

//Runtime setup - DOMContentLoaded/load event listeners are not used as this script is included after all required DOM elements and assets are loaded

//Cache getElementById objects that are used multiple times
var elems = [];
var elemsToCache = ["answer", "answer-buttons", "disclaimer", "domain", "endscreen", "endscreen-score", "main", "next-button", "next-button-input", "score-correct", "score-incorrect", "score-round", "startscreen"];
elemsToCache.forEach(cacheElements);
function cacheElements(element) {
  elems[element] = document.getElementById(element);
}

//Add click event listeners (used instead of onclick to be compliant with CSP)
var eventListeners = [
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
}

//Add the starting title (done with JS to allow for the noscript tag to display instead if needed)
document.getElementById("starttext").innerHTML = "Click the button below to begin:";
//Show start button (done with JS to prevent it showing if JS is disabled)
document.getElementById("start-button").style.display = "inline-block";

//Create global variables
var viewedDisclaimer;
var correctAnswer;
var score;
var roundNo;
function resetVars() {
  score = [0, 0];
  roundNo = 1;
  elems["next-button-input"].value = "Next";
}
resetVars();
randDomain();
