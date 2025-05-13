<?php /**
    * @author SeverskiY (@severskteam)
**/

if ($page == "adminpanel") {
    require_once MODULES . "module_page_skins/pages/buttons.php";
    require_once MODULES . "module_page_skins/pages/adminpanel.php";
} else if (!empty($Db->db_data['Skins'])) {
    require_once MODULES . "module_page_skins/pages/buttons.php";
    require_once MODULES . "module_page_skins/pages/html-js.php";
} else {
    require_once MODULES . "module_page_skins/pages/install.php";
}

?>
<script>
    let page_php = '<?= $page; ?>'; 
    const selectel_skins = '<?= $Function->Translate('_selectel_skins'); ?>';
    const choose_weapon = '<?= $Function->Translate('_choose_weapon'); ?>';
    const choose_default = '<?= $Function->Translate('_choose_default'); ?>';
</script>