<div class="properties_table" id="properties_table" data-value="0" style="display: none">

    <div class="shop_product_description">
        <?= $Translate->get_translate_module_phrase('module_page_store', '_productAdvantages') ?>
    </div>
    <div class="props no-scrollbar" id="props">
        <div class="shop_table_fix"></div>
        <div class="shop_table_create_button" onclick="createPropertyFields($('#properties_table').attr('data-value'), 'table')">
            <?= $Translate->get_translate_module_phrase('module_page_store', '_shopAddadvantage') ?>
        </div>
        <div class="secondary_btn close_properties_table" onclick="closePropertyTable()">
            <?= $Translate->get_translate_module_phrase('module_page_store', '_shopOkayLetsGo') ?>
        </div>
    </div>

</div>