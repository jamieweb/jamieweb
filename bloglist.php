<?php function bloglist($location, $category = null, $post = null) {
    $bloglist = json_decode(file_get_contents('blog/posts.json', true));
    if($location === "navbar") {
        echo "<h4>\n";
        foreach($bloglist->blog as $year) {
            foreach($year as $post) {
                echo "                        <a href=\"/blog/" . $post->uri . "/\">" . $post->navtitle . "</a>\n";
            }
        }
        echo "                    </h4>\n";
    }
    elseif($location === "home") {
        $homeCount = 0;
        foreach($bloglist->blog as $year) {
            foreach($year as $post) {
                $homeCount++;
                echo "\n        <div class=\"recent-post clearboth\">
            <h2 class=\"no-mar-bottom\"><a href=\"/blog/" . $post->uri . "/\">" . $post->title . "</a></h2>
            <p class=\"two-mar-top recents-date\">" . $post->date . "</p>
            <p class=\"snippet\">" . $post->snippet . " <b><u><i><a href=\"/blog/" . $post->uri . "/\"><span class=\"continue-reading\">Continue reading...</span></a></i></u></b></p>";
                bloglist("tags", null, $post);
                echo "        </div>";
                if($homeCount >= 4) {
                    break 2;
                }
                echo "<hr>";
            }
        }
    }
    elseif($location === "tags") {
        echo "\n            <p class=\"tags\">\n";
        foreach(explode(",", $post->tags) as $tag) {
            echo "                <b><a href=\"/blog/category/" . str_replace(' ', '-', strtolower($tag)) . "/\"><span class=\"tag-" . str_replace(' ', '-', strtolower($tag)) . "\">" . $tag . "</span></a></b>\n";
        }
        echo "            </p>\n";
    }
    elseif($location === "recents") {
        $recentsCount = 0;
        foreach($bloglist->blog as $year) {
            foreach($year as $post) {
                $recentsCount++;
                echo "            <a href=\"/blog/" . $post->uri . "/\">
                <h4 class=\"no-mar-bottom\">" . $post->title . "</h4>
                <h5 class=\"two-no-mar\">" . $post->shortdesc . "</h5>
                <h5 class=\"two-mar-top\">" . $post->date . "</h5>
            </a>\n";
                if($recentsCount >= 4) {
                    break 2;
                }
            }
        }
    }
    elseif($location === "blog") {
        $latestYear = 2018; //Temporary year code
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
    }
    elseif($location === "tag") {
        echo "<!DOCTYPE html>
<html lang=\"en\">

<!--Copyright Jamie Scaife-->
<!--Legal Information at https://www.jamieweb.net/contact-->

<head>
    <title>Blog</title>
    <meta name=\"description\" content=\"Blog posts in category: '" . $category . "'\">
    <meta name=\"keywords\" content=\"Jamie, Scaife, jamie scaife, jamiescaife, jamieonubuntu, jamie90437, jamie90437x, jamieweb, jamieweb.net\">
    <meta name=\"author\" content=\"Jamie Scaife\">
    <link href=\"/jamie.css\" rel=\"stylesheet\">
    <link href=\"https://www.jamieweb.net/blog/category/" . str_replace(' ', '-', strtolower($category)) . "/\" rel=\"canonical\">
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
        echo "    </div>\n";
        include_once "footer.php";
        echo "\n\n</body>

</html>";
    }
}
?>
