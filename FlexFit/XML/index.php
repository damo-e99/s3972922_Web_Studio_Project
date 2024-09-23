<?php
include('main_sitemap_generator.php');
include('sitemap_generator.php');

//Sitemap for FlexFit Web Page Application
$generate_sitemap = [];
$name = 'FlexFit';
$urls = [
    'https://titan.csit.rmit.edu.au/~s3972922/assignment-3-final-website-team_4_cosc3046_sep23/FlexFit/php/home.php',

    'https://titan.csit.rmit.edu.au/~s3972922/assignment-3-final-website-team_4_cosc3046_sep23/FlexFit/php/shop.php',
    'https://titan.csit.rmit.edu.au/~s3972922/assignment-3-final-website-team_4_cosc3046_sep23/FlexFit/php/product_window.php?product=gorilla-mode',

    'https://titan.csit.rmit.edu.au/~s3972922/assignment-3-final-website-team_4_cosc3046_sep23/FlexFit/php/about.php',

    'https://titan.csit.rmit.edu.au/~s3972922/assignment-3-final-website-team_4_cosc3046_sep23/FlexFit/php/contact.php',

    'https://titan.csit.rmit.edu.au/~s3972922/assignment-3-final-website-team_4_cosc3046_sep23/FlexFit/php/cart.php',
    'https://titan.csit.rmit.edu.au/~s3972922/assignment-3-final-website-team_4_cosc3046_sep23/FlexFit/php/payment.php',

    'https://titan.csit.rmit.edu.au/~s3972922/assignment-3-final-website-team_4_cosc3046_sep23/FlexFit/php/login.php',
    'https://titan.csit.rmit.edu.au/~s3972922/assignment-3-final-website-team_4_cosc3046_sep23/FlexFit/php/account.php',

    'https://titan.csit.rmit.edu.au/~s3972922/assignment-3-final-website-team_4_cosc3046_sep23/FlexFit/php/forum.php',
    'https://titan.csit.rmit.edu.au/~s3972922/assignment-3-final-website-team_4_cosc3046_sep23/FlexFit/php/forum.php'
];

$generate_sitemap[] = sitemap_generator($name, $urls);

main_sitemap_generator($generate_sitemap);
