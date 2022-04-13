<?php
get_header();

include_once 'classes/core/DefaultPosts.php';
$Posts = new DefaultPostsClass();
foreach($Posts->posts as $post):
    include 'components/post.php';
endforeach;

$pagination = $Posts->pagination;
include 'components/Pagination.php';

get_footer();
