<?php
require_once($_SERVER['DOCUMENT_ROOT']."/router.php");

get('/','/index.html');
get('/home', '/index.html');
get('/about-us', '/about.html');
get('/blog', '/our-blog.php');
get('/blog/$page', '/our-blog.php');
get('/post/$page', '/detail.php');
get('/contact-us', '/contact.html');


get('/admin', '/admin/login.php');
get('/admin/login', '/admin/login.php');
post('/admin/login', '/admin/login.php');
get('/admin/dashboard', '/admin/dashboard.php');
post('/admin/dashboard', '/admin/dashboard.php');
get('/admin/logout', '/admin/logout.php');
get('/admin/create', '/admin/post_page.php');
post('/admin/create', '/admin/create_post.php');


get('/admin/edit/$page', '/admin/edit_post.php');
post('/admin/edit', '/admin/edit_post.php');

get('/admin/account', '/admin/account.php');
post('/admin/account', '/admin/account.php');

any('/404','/404.html');
