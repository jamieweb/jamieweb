<?php $bloglist = json_decode(file_get_contents('posts.json', true));
function bloglist($location, $category = null, $post = null, $annum = null) {
    global $bloglist;
    switch($location) {
    case "navbar":
        foreach($bloglist->blog as $year) {
            foreach($year as $post) {
                echo "                        <a href=\"/blog/" . $post->uri . "/\">" . $post->navtitle . "</a>\n";
            }
        }
    break;

    case "postTop":
        global $postInfo;
        $postInfo = $bloglist->blog->{$annum}->{basename(getcwd())};
        echo "<!DOCTYPE html>
<html lang=\"en\">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>" . $postInfo->title . "</title>
    <meta name=\"description\" content=\"" . $postInfo->longdesc . "\">";
        include "head.php";
        echo "    <link href=\"https://www.jamieweb.net/blog/" . $postInfo->uri . "/\" rel=\"canonical\">
</head>

<body>

";
        include "navbar.php";
    break;

    case "home":
        $homeCount = 0;
        foreach($bloglist->blog as $year) {
            foreach($year as $post) {
                $homeCount++;
                echo "<div class=\"recent-post clearboth\">
            <h2 class=\"no-mar-bottom\"><a href=\"/blog/" . $post->uri . "/\">" . $post->title . "</a></h2>
            <p class=\"two-mar-top recents-date\">" . $post->date . "</p>
            <p class=\"snippet\">" . $post->snippet . " <b><u><i><a href=\"/blog/" . $post->uri . "/\"><span class=\"continue-reading\">Continue reading...</span></a></i></u></b></p>";
                bloglist("tags", null, $post);
                echo "        </div>";
                if($homeCount >= 4) {
                    break 2;
                }
                echo "<hr>\n        ";
            }
        }
    break;

    case "tags":
        echo "\n            <p class=\"tags\">\n";
        foreach(explode(",", $post->tags) as $tag) {
            echo "                <b><a href=\"/blog/category/" . str_replace(' ', '-', strtolower($tag)) . "/\"><span class=\"tag-" . str_replace(' ', '-', strtolower($tag)) . "\">" . $tag . "</span></a></b>\n";
        }
        echo "            </p>\n";
    break;

    case "blog":
        $latestYear = 2020; //Temporary year code
        foreach($bloglist->blog as $year) {
            echo "\n    <br><div class=\"blog-group\">
        <div class=\"blog-year\"><h1>" . $latestYear-- . "</h1></div>
        <div class=\"blog-brace1\"></div>
        <div class=\"blog-brace2\"></div>
        <div>
            <div class=\"blog-brace3\"></div>
            <div class=\"blog-brace4\"></div>
            <div class=\"blog-brace5\"></div>
        </div>
        <div class=\"blog-list\">\n";
            foreach($year as $post) {
                echo "            <h3><a href=\"/blog/" . $post->uri . "/\">" . $post->title . "</a></h3>
            <p class=\"two-no-mar\"><b>" . $post->longdesc . "</b></p>
            <p class=\"two-no-mar\">" . $post->date . "</p>";
                bloglist("tags", null, $post);
            }
            echo "        </div>
    </div>\n";
        }
    break;

    case "tag":
        echo "<!DOCTYPE html>
<html lang=\"en\">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Blog</title>
    <meta name=\"description\" content=\"Blog posts in category: '" . $category . "'\">
    ";
    include "head.php";
    echo "<link href=\"https://www.jamieweb.net/blog/category/" . str_replace(' ', '-', strtolower($category)) . "/\" rel=\"canonical\">
</head>

<body>\n\n";
        include "navbar.php";
        echo "\n<div class=\"body\">
    <h1>Category: '" . $category . "'</h1>
    <hr>
    <div class=\"blog-list\">\n";
        foreach($bloglist->blog as $year) {
            foreach($year as $post) {
                $tags = explode(",", $post->tags);
                if(in_array($category, $tags)) {
                    echo "        <h3><a href=\"/blog/" . $post->uri . "/\">" . $post->title . "</a></h3>
        <p class=\"two-no-mar\"><b>" . $post->longdesc . "</b></p>
        <p class=\"two-no-mar\">" . $post->date . "</p>
        <p class=\"tags\">\n";
                    foreach($tags as $tag) {
                        echo "            <b><a href=\"/blog/category/" . str_replace(' ', '-', strtolower($tag)) . "/\"><span class=\"tag-" . str_replace(' ', '-', strtolower($tag)) . "\">" . $tag . "</span></a></b>\n";
                    }
                    echo "        </p>\n";
                }
            }
        }
        echo "    </div>
</div>\n\n";
        include_once "footer.php";
        echo "\n\n</body>

</html>";
    break;
}}
function license_text($license) {
    switch($license) {
        case "CC BY-SA 4.0":
            return("<a href=\"https://creativecommons.org/licenses/by-sa/4.0/\" target=\"_blank\" rel=\"noopener\">Creative Commons Attribution-ShareAlike 4.0 International License</a>");
            break;
        case "CC BY-NC-SA 4.0":
            return("<a href=\"https://creativecommons.org/licenses/by-nc-sa/4.0/\" target=\"_blank\" rel=\"noopener\">Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International License</a>");
            break;
    }
} ?>
