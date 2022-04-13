<?php get_header();

include_once 'functions/index.php';
$post = getPostById();
include 'components/post.php';

get_footer();
