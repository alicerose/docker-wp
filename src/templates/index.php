<?php
get_header();

include_once 'classes/core/DefaultPosts.php';
$Posts = new DefaultPostsClass();

//echo '<pre class="var_dump">';
//var_dump($Posts);
//echo '</pre>';

foreach($Posts->categories as $taxonomy):
    include 'components/term.php';
endforeach;

foreach($Posts->posts as $post):
include 'components/post.php';
endforeach;

$pagination = $Posts->pagination;
include 'modules/Pagination.php';

get_footer();
