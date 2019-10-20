<?php include "response-headers.php"; content_security_policy();
include_once "bloglist.php"; bloglist("postTop", null, null, 2019); ?>

<div class="body">
    <h1><?php echo $postInfo->title; ?></h1>
    <hr>
    <p><b><?php echo $postInfo->date; ?></b></p>
    <p><?php echo $postInfo->snippet; ?></p>
    <pre><i>Type bits/keyID            cr. time   exp time   key expir</i>

<b>pub</b> rsa4096/a40ced0a9eaba810f55bb88ca41a7776121ce43c
         Hash=f24c4ff33f09e7da1b0cb2cf72cb2be3

<b>uid</b> <u>Alice &lt;alice@example.com&gt;</u>
sig  sig  a41a7776121ce43c 2019-10-19T21:43:52Z 2020-10-18T21:43:52Z ____________________ [selfsig]
sig  sig  24b1fb13f1b3b06c 2019-10-19T21:51:07Z ____________________ ____________________ 24b1fb13f1b3b06c

<b>uid</b> <u>Alice (Alt Email) &lt;alice@example.com&gt;</u>
sig  sig  a41a7776121ce43c 2019-10-19T21:34:23Z 2020-10-18T21:34:23Z ____________________ [selfsig]
sig  sig  24b1fb13f1b3b06c 2019-10-19T21:51:08Z ____________________ ____________________ 24b1fb13f1b3b06c



<b>sub</b> dsa3072/d7cff40b9c95ede5f8d10b62e91a02198a286d8f 2019-10-19T23:05:19Z
sig sbind a41a7776121ce43c 2019-10-19T23:05:19Z ____________________ 2020-10-18T23:05:19Z []

<b>sub</b> rsa4096/b8d4d1ab55a0f662596c52ab47652ce725cb3e8f 2019-10-19T21:16:21Z
sig sbind a41a7776121ce43c 2019-10-19T21:16:21Z ____________________ 2020-10-18T21:16:21Z []</pre>

    <h2 id="entry-type">Entry type</h2>
    <p>The type of the following entry. Common values are:</p>
    <ul>
        <li><code>pub</code> (Public Key)</li>
        <li><code>uid</code> (User ID)</li>
        <li><code>sig</code> (Signature)</li>
        <li><code>sub</code> (Subkey)</li>
    </ul>
    <p>You may also see the following values when using GPG locally:</p>
    <ul>
        <li><code>sec</code> (Secret Key / Private Key)</li>
        <li><code>ssb</code> (Secret Subkey / Private Subkey)</li>
    </ul>

    <h2 id="key-type">Key type</h2>
    <p>The type of key. Common values are:</p>
    <ul>
        <li><code>rsa</code></li>
        <li><code>dsa</code> (Digital Signature Algorithm)</li>
        <li><code>elg</code> (Elgamel)</li>
    </ul>

    <h2 id="key-size">Key size (bits)</h2>
    <p>The size of the key, in bits. Usually between 1024 and 4096. 2048 is the modern bare-minimum, with 4096 recommended for futureproofing. DSA keys are limited to 3072 bits in GPG.</p>

    <h2 id="key-id">Key ID</h2>
    <p>The ID of the key, or if shown in a signature, the ID of the key that made the signature. Key IDs can be represented in multiple different ways:</p>
    <ul>
        <li><b>Full fingerprint:</b> The full key ID, consisting of 160 bits (40 characters when represented as hex).</li>
        <li><b>Long ID:</b> The lower 64 bits (16 characters) of the full fingerprint.</li>
        <li><b>Short ID:</b> The lower 32 bits (8 characters) of the full fingerprint.</li>
    </ul>
    <p>For example:</p>
    <pre>Fingerprint: a40c ed0a 9eab a810 f55b b88c a41a 7776 121c e43c
Long ID:                                   a41a 7776 121c e43c
Short ID:                                            121c e43c</pre>
    <p>When using GPG locally, you can choose which key ID format to use when listing keys:</p>
    <ul>
        <li>Show full key ID: <code>gpg --fingerprint</code></li>
        <li>Show long key ID: <code>gpg --keyid-format long --list-keys</code></li>
        <li>Show short key ID: <code>gpg --keyid-format short --list-keys</code></li>
    </ul>
    <p>Only fingerprints should be used nowadays, as brute-force techniques can be used to create 'unofficial' keys where the long or short key IDs collide with other 'legitimate' keys. This results in ambiguous trust, as a long or short key ID may match more keys than the one you are expecting.</p>

    <h2 id="key-hash">Key hash</h2>
    <p>An MD5 digest of the key.</p>
    <p>For some reason information about this is very sparse. From what I can gather, it seems to be something to do with SKS, rather than OpenPGP or GPG directly.</p>
    <p>The <a href="https://github.com/hockeypuck/hockeypuck/search?q=%22hash%22&type=Code" target="_blank" rel="noopener">source code for the Hockeypuck key server software</a> provides some clues and confirms that it is definitely MD5. If anyone knows more about this, please <a href="/contact/" target="_blank">get in touch</a>.</p>

    <h2 id="user-id">User ID</h2>
    <p>The user ID of the key or subkey, consisting of a name and email address, and optionally a comment and/or photograph.</p>
    <p>For example:</p>
    <pre>First Last (Comment) &lt;email@example.com&gt;</pre>

    <h2 id="certification-level">Certification level</h2>
    <p>The level of trust asserted by a specific signature. In the OpenPGP specification this is represented by the hex values <code>0x10</code> to <code>0x13</code>, and displayed by GnuPG as <code>sig</code> through <code>sig3</code>:</p>
    <ul>
        <li><code>0x10</code> / <code>sig</code>:  No indication</li>
        <li><code>0x11</code> / <code>sig1</code>: Personal belief but no verification</li>
        <li><code>0x12</code> / <code>sig2</code>: Casual verification</li>
        <li><code>0x13</code> / <code>sig3</code>: Extensive verification</li>
    </ul>
    <p>In addition, <code>sbind</code> is used to represent the creation of the key/record, including the creation time.</p>

    <h2 id="time-stamp">Time stamp</h2>
    <p>A time stamp, represented in ISO8601 format, with the <code>Z</code> meaning 'Zulu', or UTC.</p>
    <p>There are three columns of time stamps:</p>
    <ul>
        <li>Column 1 - '<code>cr. time</code>': Creation time of the key or signature</li>
        <li>Column 2 - '<code>exp time</code>': Expiry time of the signature</li>
        <li>Column 3 - '<code>key expir</code>': Expiry time of the key</li>
    </ul>
    <p>Blank time stamps, represented as 20 underscores (<code>____________________</code>), indicate that a key or signature is set to not expire.</p>


    <h2 id="conclusion">Conclusion</h2>
    <p></p>
</div>

<?php include "footer.php" ?>












