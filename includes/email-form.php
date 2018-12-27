<?php function emailForm($location) {
    echo "    <div class=\"email-form\">
        <form action=\"https://www.getrevue.co/profile/jamieweb/add_subscriber\" method=\"post\" target=\"_blank\">
            <input class=\"form-input\" type=\"email\" name=\"member[email]\" placeholder=\"Your email address...\">
            <input class=\"form-submit\" type=\"submit\" name=\"member[subscribe]\" value=\"Subscribe!\">
        </form>
    </div>";
}
