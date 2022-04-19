<?php if(isset($post) && $post): ?>
<article>
    <h1>
        <a href="<?= $post->url ?>">
            <?= $post->title; ?>
        </a>
    </h1>
    <p><?= $post->content; ?></p>
    <div>
        <div><?= $post->date; ?></div>
        <?php if(!$post->isPage()): ?>
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
        <?php endif; ?>
        <div>
            投稿者：
            <?= $post->author->name; ?>
        </div>
    </div>
</article>
<?php endif; ?>
