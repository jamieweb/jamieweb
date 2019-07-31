<?php include "response-headers.php"; content_security_policy();
include_once "bloglist.php"; bloglist("postTop", null, null, 2019); ?>

<div class="body">
    <h1><?php echo $postInfo->title; ?></h1>
    <hr>
    <p><b><?php echo $postInfo->date; ?></b></p>
    <p><?php echo $postInfo->snippet; ?></p>
    <p>Many cloud providers have their own serverless offering, including AWS Lambda, Google Cloud Functions, Azure Functions, etc. You can also host your own, as many of the serverless implementations are open-source. In this article I am focussing on Cloudflare's serverless offering, as it is very accessible to people who may be new to serverless, however you can achieve similar things using other providers.</p>
    <p>If you're interested in a higher-level overview of serverless, I recommend this article by Serverless Stack: <a href="https://serverless-stack.com/chapters/what-is-serverless.html" target="_blank" rel="noopener">What is Serverless?</a></p>
    <p>If you'd like to learn more about the technical details of Cloudflare's serverless platform specifically, including how the sandboxing works, <a href="https://blog.cloudflare.com/cloud-computing-without-containers/" target="_blank" rel="noopener">Cloud Computing without Containers</a> is a good read.</p>

    <p><b>Skip to Section:</b></p>
    <pre><b><?php echo $postInfo->title ?></b>
&#x2523&#x2501&#x2501 <a href="#prerequisites">Prerequisites</a>
&#x2523&#x2501&#x2501 <a href="#creating-the-worker">Creating the Worker</a>
&#x2523&#x2501&#x2501 <a href="#deploying-the-worker-to-a-route">Deploying the Worker to a Route</a>
&#x2523&#x2501&#x2501 <a href="#testing-the-worker">Testing the Worker</a>
&#x2517&#x2501&#x2501 <a href="#conclusion">Conclusion</a></pre>

    <h2 id="prerequisites">Prerequisites</h2>
    <p>In this article, I will demonstrate how to set up a Cloudflare Serverless Worker to serve a security.txt file for your website that is already fronted by Cloudflare (in orange-cloud mode):</p>
    <img class="radius-8 border-2px-solid" src="dns-orange-cloud.png" width="1000px" alt="A screenshot of the Cloudflare DNS manager, showing some sample DNS records in orange-cloud mode.">
    <p>This configuration will work for any origin server/hosting provider, as long as it is a standard website operating over HTTP(S), for example Wordpress or Joomla. Once complete, all requests to <code>/.well-known/security.txt</code> will be routed by Cloudflare to your Worker, rather than through to your origin server as would usually happen.</p>
    <p>If you don't have a domain name added to Cloudflare and just want to test this configuration, you can claim a subdomain of <code>workers.dev</code> within your Cloudflare dashboard, where you can still use the full feature set of Workers:</p>
    <img class="radius-8 border-2px-solid" src="claim-workers-dev-subdomain.png" width="1000px" alt="A screenshot of the Cloudflare dashboard, prompting you to claim a Workers.dev subdomain.">

    <h2 id="creating-the-worker">Creating the Worker</h2>
    <p>In this example, I am using my non-production test domain <code>jamiescaife.uk</code>. You will need to use your own domain in place of this.</p>
    <p>Firstly, navigate to the Cloudflare Workers app from within your dashboard:</p>
    <img class="radius-8 border-2px-solid" src="workers-app.png" width="1000px" alt="A screenshot of the Cloudflare Workers app within the Cloudflare dashboard.">
    <p>From here, you can create a new Worker by clicking '<b>Launch Editor</b>' followed by '<b>Add script</b>'. Choose a friendly name for your script - in my case I chose <code>securitytxt</code>.</p>
    <p>This will launch the Worker editor, with some placeholder/example code on the left, and a preview of the output on the right:</p>
    <img class="radius-8 border-2px-solid" src="workers-new-script.png" width="1000px" alt="A screenshot of the Cloudflare Workers editor, showing some placeholder/example code on the left, and a preview of the output on the right.">
    <p>In some cases, the preview won't load the first time. You can normally resolve this by clicking the blue '<b>Refresh</b>' button on the right.</p>
    <p>The code below is for a simple 'Hello, World!' Worker, which will serve any text of your choice:</p>
    <pre>addEventListener('fetch', event => {
  event.respondWith(handleRequest(event.request))
})

async function handleRequest(request) {
  return new Response('This is a Worker.', {status: 200})
}</pre>
    <p>When running this as a Worker, it produces a response containing the <code>Content-Length</code> and <code>Content-Type</code> headers, as well as the text that you set:</p>
    <img class="radius-8 border-2px-solid" src="workers-basic-response.png" width="1000px" alt="A screenshot of the Cloudflare Workers editor, showing the sample code and the test output.">
    <p>Next, we can move on to the Worker script to serve your <code>security.txt</code> file.</p>
    <p>It's a very simple script that just serves the <code>security.txt</code> content as plain text, but it also sets the <code>Strict-Transport-Security</code> and <code>Expect-CT</code> headers to help ensure that the file is served over a secure HTTPS connection.</p>
    <div class="message-box message-box-warning-medium">
        <div class="message-box-heading">
            <h3 id="disclaimer"><u>Warning!</u></h3>
        </div>
        <div class="message-box-body">
            <p>The <code class="color-darkslategrey">security.txt</code> worker serves the <code class="color-darkslategrey">Strict-Transport-Security</code> and <code class="color-darkslategrey">Expect-CT</code> headers. The policies in these headers will be applied to the entire origin that they are served from, not just the specific file. Please keep this in mind, particularly if your website doesn't fully support HTTPS with a valid certificate, or if the policies use different values on the rest of your website, as this could result in some visitors seeing certificate warnings or being unable to access your website. Please see the MDN articles for <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Strict-Transport-Security" target="_blank" rel="noopener">Strict-Transport-Security</a> and <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Expect-CT" target="_blank" rel="noopener">Expect-CT</a> for more info.</p>
        </div>
    </div>
    <p>Here's the code:</p>
    <pre>addEventListener('fetch', event => {
  event.respondWith(handleRequest(event.request))
})

let securitytxt = `Contact: mailto:security@example.com
Encryption: https://example.com/pgp.asc
Signature: https://example.com/.well-known/security.txt.sig
Acknowledgement: https://example.com/security/hall-of-fame
Hiring: https://example.com/careers
Canonical: https://example.com/.well-known/security.txt`;

async function handleRequest(request) {
  return new Response(
    securitytxt,
    {
      status: 200,
      headers: {
        'strict-transport-security': "max-age=30",
        'expect-ct': "max-age=30, enforce"
      }
    }
  )
}</pre>
    <p>The <code>securitytxt</code> variable contains a standard example <code>security.txt</code> file. Make sure to update the values to match your own security reporting email addresses, links, etc. You can refer to the specification on the <a href="https://securitytxt.org/" target="_blank" rel="noopener">security.txt</a> website for more information.</p>
    <p>You should also configure the <code>max-age</code> and other directives for the <code>Strict-Transport-Security</code> and <code>Expect-CT</code> headers. If you already have these headers set on the rest of your website, I recommend configuring the Worker to use exactly the same values. Please refer to the documentation on MDN for more information: <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Strict-Transport-Security" target="_blank" rel="noopener">Strict-Transport-Security</a> | <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Expect-CT" target="_blank" rel="noopener">Expect-CT</a></p>
    <p>Finally, update the preview using the '<b>Update Preview</b>' button at the bottom. Your <code>security.txt</code> file should now show in the preview/testing window on the right:</p>
    <img class="radius-8 border-2px-solid" src="workers-securitytxt-testing.png" width="1000px" alt="A screenshot of the testing window for the security.txt worker, showing the example headers and response.">
    <p>If there are any syntax errors in your code, these will be marked in the editor window.</p>

    <h2 id="deploying-the-worker-to-a-route">Deploying the Worker to a Route</h2>
    <p>In order for the Worker to actually run, you'll need to create a route. A route is essentially a URL path that when hit, will cause the request to be routed to your Worker, rather than through to your origin server as would usually happen.</p>
    <p>The standard URL path for <code>security.txt</code> is <code>/.well-known/security.txt</code>. You can create a route for this by saving and exiting the script editor, then switching to the '<b>Routes</b>' tab, followed by clicking '<b>Add route</b>'. Then, specify the URL path, including your domain at the start. Add an asterisk (<code>*</code>) to specify a wildcard, for example to allow the Worker to run for both the root domain and the <code>www</code> subdomain:</p>
    <img class="radius-8 border-2px-solid" src="workers-create-route.png"width="1000px" alt="A screenshot of the configurational modal for the Worker route, showing the URL path for security.txt as well as the securitytxt Worker selected.">

    <h2 id="testing-the-worker">Testing the Worker</h2>
    <p>Now that your Worker has been deployed to the <code>/.well-known/security.txt</code>, you can test it by visiting the URL in a browser, or using <code>cURL</code>:</p>
    <pre>$ curl https://www.jamiescaife.uk/.well-known/security.txt
Contact: mailto:security@example.com
Encryption: https://example.com/pgp.asc
Signature: https://example.com/.well-known/security.txt.sig
Acknowledgement: https://example.com/security/hall-of-fame
Hiring: https://example.com/careers
Canonical: https://example.com/.well-known/security.txt</pre>
    <p>If you don't get a response as expected, check the response headers (using <code>curl -i</code> for any possible indicators, and also double check that you have set the Worker route correctly.</p>

    <h2 id="conclusion">Conclusion</h2>
    <p>Hopefully this usage of Workers will make it easier for <code>security.txt</code> to be served when using certain Content Management Systems or hosting providers.</p>
    <p>This same configuration can of course be used to serve other text files, such as your <code>security.txt.sig</code> signature file, <code>robots.txt</code>, <code>mta-sts.txt</code>, etc.</p>
    <p>If you want to go a bit further, consider serving your CSS stylesheet using serverless, or even some of the key static pages on your website.</p>
    <p>I have no commercial affiliation with Cloudflare.</p>
</div>

<?php include "footer.php" ?>












