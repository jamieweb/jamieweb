<?php include "response-headers.php"; content_security_policy(); ?>
<!DOCTYPE html>
<html lang="en">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Proof Of Timestamp</title>
    <meta name="description" content="Proof Of Timestamp">
    <?php include "head.php" ?>
    <link href="https://www.jamieweb.net/blog/proof-of-timestamp/" rel="canonical">
</head>

<body>

<?php include "navbar.php" ?>

<div class="body">
    <h1>Proof Of Timestamp</h1>
    <hr>
    <p><b>Thursday 19th January 2017</b></p>
    <p>Signing the hash of a file into the Bitcoin blockchain has been well-known practise for a while now, and cryptographically proves the existence of a particular file at a particular time. The record is permanent, and can be checked at a later date. Once your hash is in the blockchain, it is impossible to change/remove it.</p>
    <p>There are two main ways of doing this. The first method involves broadcasting a deliberately erroneous transaction to the network (known as "provably unspendable"). A provably unspendable transaction has space for a small amount of data to be included in the broadcast, which in this case is used to store the hash of the file. Documentation on this process can be found <a href="https://en.bitcoin.it/wiki/Script#Provably_Unspendable.2FPrunable_Outputs" target="_blank" rel="noopener">on the Bitcoin wiki</a>. Using this method, you will only be required to send the transaction with a high enough fee for it to be confirmed. No Bitcoin output is required.</p>
    <p>The alternate method involves generating a Bitcoin address based on the SHA-256 hash of the file and sending Bitcoin to said address. With this method, you will never know the private key that is associated with the address. This is because a ECDSA key is never generated and hashed, instead you use the hash of the file that you want to sign into the blockchain. Take a look at the <a href="https://en.bitcoin.it/wiki/Technical_background_of_version_1_Bitcoin_addresses" target="_blank" rel="noopener">technical process of generating Bitcoin addresses on the Bitcoin wiki</a>. Contrary to the first method, this does require a Bitcoin output. At the current time this isn't very significant, since you could send just 1 Satoshi (0.00000001 BTC), which is worth &pound;0.0000073148 as of 19/Jan/2017.</p>
    <p>Many transactions created this way and used for the purpose of signing file hashes can be seen on the "<a href="https://blockchain.info/strange-transactions" target="_blank" rel="noopener">Strange Transactions</a>" page at blockchain.info.</p>
    <p>Bitcoin transaction fees are currently around &pound;0.07 for a transaction of this sort. To summarise, this is how much it will "cost" to sign the hash of your file onto the blockchain.</p>
    <p>The problem with this system is that it does not prove when the final version of the file was actually created. I could sign a decade old file into the blockchain and it would only prove that the file was created BEFORE that time. While this type of proof may be useful in some situations, a two-way solution is better.</p>
    <p>The only real way to achieve this is by including some information in the file itself that proves that it was created AFTER a particular time. The first thing that you may think of is to include a current news article, since this information could not have been produced before the reported event actually happened. While this is a good solution that most people will understand, it is better to use a cryptographic proof. By including the most recent Bitcoin blockchain block hash in your file, you can cryptographically prove that the file was created AFTER the current time. For example:</p>
    <ul><li>The most recent block hash as of 19/Jan/2017 19:26 is <a href="https://blockchain.info/block/000000000000000002cd1e527ce7fdbc694fa881ae5c26fa38e95dbd79d06a73" target="_blank" rel="noopener"><span class="word-break-all">000000000000000002cd1e527ce7fdbc694fa881ae5c26fa38e95dbd79d06a73</span></a>.</li></ul>
    <p>Information on recent Bitcoin blocks can be found easily on sites such as <a href="https://blockchain.info/" target="_blank" rel="noopener">blockchain.info</a>:</p>
    <div class="centertext"><img class="max-width-100-percent" src="/blog/proof-of-timestamp/recent-blocks.png"></div>
    <p>Now we have the full solution: by including the hash of the most recent Bitcoin block in the file, and then signing the hash of the file onto the blockchain, you can prove that the final version of the file was created between two timestamps. These being the timestamp of the most recent block hash at the time, and the timestamp of the Bitcoin transaction.</p>
    <p>In order to test the proofs, we can imagine different circumstances:</p>
    <ul><li>If I were to edit the content of the file after I had published it with proofs, the hash of the file would differ from the copy in the blockchain, therefore violating the proofs.</li>
    <li>If I wanted to fake the timestamp of the file in order to make it look like it was created earlier than it actually was, I could easily include the record of an older block hash. But it would be impossible to sign the hash of the file into an older block. There is no way to change the contents of older blocks on a blockchain since every future block directly depends on it. That's why blockchain technology is so revolutionary.</li>
    <li>If I wanted to fake the timestamp of the file in order to make it look like it was created in the future, I would be unable to include a future block hash or sign the hash of the file into a future block on the blockchain since neither of those exist yet.</li>
    <li>If I wanted to verify the timestamp integrity of the file, I would check the timestamp of both the included block hash and the asociated Bitcoin transaction, and make sure that they are within an acceptable time range of each other. This verifies the proofs.</li></ul>
    <p>Signing the hash of a file onto the Bitcoin blockchain can be done manually as outlined above, however there are online services available designed to automate the process:</p>
    <p>Proof of Existence (<a href="https://proofofexistence.com/" target="_blank" rel="noopener">proofofexistence.com</a>) is possibly the most well known service. You simply select a file, it is hashed and an address is presented to which you must pay 0.005 BTC (worth &pound;3.67 as of 19/Jan/2017).</p>
    <div class="centertext"><img class="max-width-100-percent" src="/blog/proof-of-timestamp/proof-of-existence.gif"></div>
    <p>OriginStamp (<a href="https://www.originstamp.org/" target="_blank" rel="noopener">originstamp.org</a>) is much more versatile than Proof of Existence. There are more options as to what you can submit to the site, instead of just uploading a file, and it's also a completely free service!</p>
    <p>I was surprised to see at first that it is a free service, however it works in quite in interesting way. Instead of having a separate Bitcoin transaction for each verified file, all of the hashes for every file submitted to the site each day are aggregated into one master file which is then used as the seed for generating a Bitcoin keypair. This means that there is only one Bitcoin transaction per day that verifies all of the files that were submitted that day. The downside of this is that you may have to wait up to 24 hours from submitting your file for the actual Bitcoin transaction to take place. There is an optional $1 fee to have your transaction be sent instantaneously. OriginStamp provide an online interface to verify your file, however in the event that the site goes down it is still possible as long as you have the master file of hashes for the day that you submitted your file. This can be downloaded from the site at the end of every day when the transaction takes place.</p>
    <div class="centertext"><img class="max-width-100-percent" src="/blog/proof-of-timestamp/origin-stamp.png"></div>
    <p>If you do not wish to sign the hash of your file onto the Bitcoin blockchain, you could use a third-party service. There are many services suited to this kind of use, including <a href="https://archive.org/" target="_blank" rel="noopener">Archive.org</a> and browser caching sites, such as Google Cache. You could also post the file to any social media site that has timestamping, however the integrity of these timestamps may be questionable as there is no cryptographic proof behind them.</p>
    <p>When it comes to including these proofs with your file, the most recent block hash is easy. However, including the hash of the file signed into the blockchain is much more difficult. While it is technically possible for a file to contain its own hash, it is not realistically possible and would require a large amount of time (probably millions of years) and computing power to achieve. The best solution to this would be to predict the block number that your file hash will be signed into and include it in the file before signing. Ideally, this would be the current block number + 1, however if your transaction fee is too low or the network is congested, you might not make it in. If you are using Proof of Existence or a similar service, they provide an interface to search for hashes that have been signed using their service. Even if the service goes offline, you should still be able to find the transaction since the signature of the transaction is prefixed with some custom text in order to make it stand out.</p>
    <p>An example use case for this kind of proof is when renting a house. When you first move in, it would be a good idea to take photographs all around the house clearly showing the current state and any existing damage. Put those photographs in a ZIP file and sign it using the method outlined, then you have cryptographically proven evidence of the state of the house when you first moved in. If any problems arise during your tenancy, you have evidence to back yourself up!</p>
</div>

<?php include "footer.php" ?>

</body>

</html>
