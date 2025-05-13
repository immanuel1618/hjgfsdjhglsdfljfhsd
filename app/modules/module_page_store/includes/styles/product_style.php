<style>
    .shop_product_gradient_background_<?= $product['id']?> {
        background: <?= $product['color']?>;
    }
    .shop_product_gradient_<?= $product['id']?> {
        background: <?= $product['color']?>;
        -webkit-background-clip: text;
    }
    .shop_product_gradient_<?= $product['id']?> svg{
        fill: <?= $product['color']?>;
    }
    .shop_product_color_value_<?= $product['id']?> {
        color: <?= $product['color']?>;
    }
    .shop_product_color_background_<?= $product['id']?> {
        background: <?= $product['color']?>;
    }

    <?php if(!isset($_SESSION['user_admin'])):?>
        .shop_edit_server, 
        .shop_product_table_property_icon_edit, 
        .shop_product_table_property_icon_delete, 
        .shop_table_create_button, 
        .shop_property_checkbox, 
        .shop_property_input, 
        .shop_sort_property
        {
            display: none !important;
        }
    <?php endif;?>
</style>