<?php
get_header();
include_once 'classes/core/Posts.php';
$Posts = new PostsClass();
foreach($Posts->posts as $post):
?>
<article>
    <h1>
        <a href="<?= $post->url ?>">
            <?= $post->title; ?>
        </a>
    </h1>
    <p><?= $post->content; ?></p>
    <div>
        <div><?= $post->date; ?></div>
        <div>
            カテゴリ：
            <?php foreach($post->categories as $category): ?>
            <?= $category->name; ?>
            <?php endforeach; ?>
        </div>
        <div>
            タグ：
            <?php foreach($post->tags as $tag): ?>
                <?= $tag->name; ?>
            <?php endforeach; ?>
        </div>
        <div>
            投稿者：
            <?= $post->author->name; ?>
        </div>
    </div>
</article>
<?php
endforeach;
$pagination = $Posts->pagination;
include 'modules/Pagination.php';
get_footer();
