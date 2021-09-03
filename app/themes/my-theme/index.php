<?php get_header(); ?>
<?php if (have_posts()): ?>
    <?php while (have_posts()):
      the_post(); ?>
        <article>
            <div class="article-meta">
                <div><?php the_date(); ?> <?php the_time(); ?></div>
                <?php the_category(); ?>
            </div>
            <div class="article-title">
                <h2>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h2>
            </div>
            <div class="article-body">
                <?php the_content(); ?>
            </div>
        </article>
    <?php
    endwhile; ?>
<?php else: ?>
    記事が1件も見つからなかったときの処理
<?php endif; ?>
<?php get_footer(); ?>
