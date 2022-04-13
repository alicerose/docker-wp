<?php get_header();

$Posts = getPostsByTermSlug();

foreach($Posts->posts as $post):
    include 'components/post.php';
endforeach;

$pagination = $Posts->pagination;
include 'components/Pagination.php';

get_footer();
