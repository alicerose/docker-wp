<?php if(isset($taxonomy) && $taxonomy): ?>
<ul>
<?php foreach($taxonomy as $term): ?>
<li><a href="<?= '/category/' . $term->slug ?>"><?= $term->name ?></a></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>

