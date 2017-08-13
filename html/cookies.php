<?php

    include('PageSegments/Page.php');

    $page = new Page(
        'Set a Cookie',
        'Cookies',
        'Set Cookies',
        "<p>If you don't know what a cookie is, you proably don't need to be on this page. If you <i>do</i>, you're probably wondering what this page is actually for. Well, I'll tell you.</p><p>This site is used as an API endpoint, and that's pretty much it. As such, it doesn't really need to store any cookies. However, I (Caleb) need some way to access the verification pages on here so I can interface with my database. As such, I'd need to make a login system. I'm lazy, and I don't really want to do that. So, I skipped out the middle man of checking a password in a database and sending back a token, and just have myself able to set a token cookie right in my browser. It's dumb, but it works for now while I set up some other functionality on this site.</p><p>To summarise: this page lets you set a cookie in your browser for this site. It also shows you all the cookies you have stored already, though there shouldn't be any set automatically. Any cookies you store here manually expire after 365 days. You can revoke the cookies manually through your browser's storage settings.</p><p>So yeah. Have fun or whatever.</p>"
    );
    $page->output();

?>
