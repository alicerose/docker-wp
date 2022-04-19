<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="<?php bloginfo( 'description' ); ?>">
    <title><?php bloginfo("name"); ?></title>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header>
    <h1>
        <a href="<?= home_url() ?>">
            <?php bloginfo( 'name' ); ?>
        </a>
    </h1>
</header>
