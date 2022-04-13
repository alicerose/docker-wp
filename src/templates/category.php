<?php get_header();

$Posts = getPostsByTermSlug();
//echo '<pre class="var_dump">';
//var_dump($Posts);
//echo '</pre>';

foreach($Posts->posts as $post):
    include 'components/post.php';
endforeach;

$pagination = $Posts->pagination;
include 'modules/Pagination.php';

get_footer();
