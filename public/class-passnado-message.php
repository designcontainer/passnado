<?php

function passnado_message() {
    echo '
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>Login to view</title>
            <style>
                body {
                    background-color: #F5F5F5;
                    height: 100%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-family: "helvetica", arial, sans-serif;
                    font-size: 20px;
                    margin: 0;
                }
                #wrapper {
                    background-color: white;
                    width: 100%;
                    max-width: 1140px;
                    text-align: center;
                    padding: 50px 20px;
                    margin: 15px;
                }
                svg {
                    fill: #424242;
                }
                .login-link {
                    margin-top: 50px;
                    font-size: 13px;
                    line-height: 18px;
                    color: #777777;
                    display: inline-block;
                }
                .login-link:hover, .login-link:focus {
                    text-decoration: none;
                }
            </style>
        </head>
        <body>
            <div id="wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                ';
                if($title = get_option('passnado_message_title')) {
                    echo '<h1>'.$title.'</h1>';
                } else {
                    echo '<h1>This website is protected</h1>';
                }
                if($text = get_option('passnado_message_text')) {
                    echo '<p>'.$text.'</p>';
                } else {
                    echo '<p>Please login to view this website</p>';
                }
                if (get_option('passnado_login_link_show')) {
                    $loginLinkText = get_option('passnado_login_link_text');
                    if ($loginLinkText===1 || empty($loginLinkText)) {
                        $loginLinkText = 'Login';
                    }
                    global $wp;
                    $currentUrl = home_url( $wp->request );
                    ?>
                        <a href="<?php echo wp_login_url( $currentUrl ); ?>" class="login-link"><?php echo $loginLinkText; ?></a>
                    <?php 
                }
                echo '
            </div>
        </body>
    </html>
    ';
}

