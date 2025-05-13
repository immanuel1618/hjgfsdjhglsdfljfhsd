<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?= $Modules->get_page_description()?>">
    <meta property="og:description" content="<?= $Modules->get_page_description()?>">
    <link rel="icon" href="<?= $General->arr_general['site'] ?>/favicon.ico" type="image/x-icon">
    <title><?= $Modules->get_page_title() ?></title>
    <meta property="og:title" content="<?= $Modules->get_page_title() ?>">
    <meta property="og:title" content="<?= $Modules->get_page_title()?>">
    <meta property="og:image" content="<?= $Modules->get_page_image()?>">
    <link rel="image_src" href="<?= $Modules->get_page_image()?>">
    <meta name="twitter:image" content="<?= $Modules->get_page_image()?>">
    <link rel="stylesheet" type="text/css" href="/app/templates/neo/assets/css/iziToast.min.css">
    <link rel="stylesheet" type="text/css" href="/app/templates/neo/assets/css/search.css<?php $General->arr_general['css_off_cache'] == 1 && print "?" . time() ?>">
    <link rel="stylesheet" type="text/css" href="/app/templates/neo/assets/css/shift-away.css">
    <link rel="stylesheet" type="text/css" href="/app/modules/module_page_pay/assets/css/pay.css<?php $General->arr_general['css_off_cache'] == 1 && print "?" . time() ?>">
    <?php if ($Modules->route == 'home') : ?>
        <link rel="stylesheet" href="/app/templates/neo/assets/css/swiper-bundle.min.css"/>
    <?php endif; ?>
    <?php for ($style = 0, $style_s = sizeof($Modules->css_library); $style < $style_s; $style++) : ?>
        <link rel="stylesheet" type="text/css" href="/<?= $Modules->css_library[$style] ?><?php $General->arr_general['css_off_cache'] == 1 && print "?" . time() ?>">
    <?php endfor;
    if (!empty($Modules->arr_module_init['page'][$Modules->route]['css'])) :
        for ($css = 0, $css_s = sizeof($Modules->arr_module_init['page'][$Modules->route]['css']); $css < $css_s; $css++) : ?>
            <link rel="stylesheet" type="text/css" href="/app/modules/<?= $Modules->arr_module_init['page'][$Modules->route]['css'][$css]['name'] . '/assets/css/' . $Modules->arr_module_init['page'][$Modules->route]['css'][$css]['type'] . '.css' ?><?php $General->arr_general['css_off_cache'] == 1 && print "?" . time() ?>">
        <?php endfor;
    endif; ?>
    <style id="include">
        <?= $Graphics->get_css_color_palette() ?>
    </style>
    <script>
        var avatar = [];
    </script>
</head>
<body class="sidebar-collapse">