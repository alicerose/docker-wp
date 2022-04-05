<?php if(isset($pagination)): ?>
<nav>
    <ul>
        <?php foreach($pagination->pages() as $page): ?>
        <li>
            <?= $page->label ?>
        </li>
        <?php endforeach; ?>
    </ul>
</nav>
<?php endif; ?>
