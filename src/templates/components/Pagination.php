<?php if(isset($pagination)): ?>
<nav class="pagination">
    <ul class="pager__wrapper">
        <?php foreach($pagination->pages as $page): ?>
        <li class="pager__container">
            <a
                href="<?= $page->path ?>"
                class="pager__link"
                <?= $page->status ?>
                <?= $page->current ?>
            ><?= $page->label ?></a>
        </li>
        <?php endforeach; ?>
    </ul>
</nav>
<?php endif; ?>
