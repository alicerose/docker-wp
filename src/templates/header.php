<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        <?php bloginfo("name"); ?>
    </title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header>
    <h1>
        <?php bloginfo( 'name' ); ?>
    </h1>
    <p>
        <?php bloginfo( 'description' ); ?>
    </p>
</header>
