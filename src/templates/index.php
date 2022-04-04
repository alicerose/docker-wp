<?php
get_header();
echo "<h1>test</h1><pre>";
include_once get_template_directory() . '/classes/core/Posts.php';
$posts = new PostsClass();
var_dump($posts);
echo "</pre>";
get_footer();
