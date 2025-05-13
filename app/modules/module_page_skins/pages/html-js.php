<div class="block-container">
    <div class="blocks-sort" <?= ($page == "weapons") ? '' : 'style="display:none"'; ?>>
        <button id="sort-skins" id_sort="All">
            <img src="/app/modules/module_page_skins/assets/img/menu/All.png">
            <b><?= $Function->Translate('_all_skins'); ?></b>
        </button>
        <button id="sort-skins" id_sort="Pistol">
            <img src="/app/modules/module_page_skins/assets/img/menu/Pistols.png">
            <b><?= $Function->Translate('_pistol'); ?></b>
        </button>
        <button id="sort-skins" id_sort="SMG">
            <img src="/app/modules/module_page_skins/assets/img/menu/Smgs.png">
            <b><?= $Function->Translate('_smg'); ?></b>
        </button>
        <button id="sort-skins" id_sort="Heavy">
            <img src="/app/modules/module_page_skins/assets/img/menu/Heavy.png">
            <b><?= $Function->Translate('_machine_gun'); ?>/<?= $Function->Translate('_shotgun'); ?></b>
        </button>
        <button id="sort-skins" id_sort="Rifle">
            <img src="/app/modules/module_page_skins/assets/img/menu/Rifles.png">
            <b><?= $Function->Translate('_rifle'); ?></b>
        </button>
        <button id="sort-skins" id_sort="Knife">
            <img src="/app/modules/module_page_skins/assets/img/menu/Knives.png"> 
            <b><?= $Function->Translate('_knife'); ?></b>
        </button>
        <button id="sort-skins" id_sort="Gloves">
            <img src="/app/modules/module_page_skins/assets/img/menu/Gloves.png">   
            <b><?= $Function->Translate('_gloves'); ?></b>
        </button>
        <!-- <button id="sort-skins" id_sort="Cases">
            <img src="/app/modules/module_page_skins/assets/img/menu/Cases.png">
            <b>Cases</b>
        </button> -->
    </div>
    <div class="block-loader">
        <div class="loader-skins"></div>
    </div>
    <div id="html-js" class="blocks-skins"></div>
</div>
<div class="skin-modal">
    <div class="fon-modal">
        <span class="text_modal"><?= $Function->Translate('_text_modal'); ?></span>
        <a class="modal-btn__close">
            <svg viewBox="0 0 320 512">
                <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
            </svg>
        </a>
        <div class="flex_mon_ms">
            <div class="my-info-skin"><?= $Function->Translate('_my_info_skin'); ?>: <a id="my-skin">Загрузка...</a></div>
            <div class="cnopick"></div>
        </div>
        <div id="skin-modal-js"></div>
    </div>
</div><div class="skin-modal-overlay"></div>
<div class="popup_modal popup_modal_collection_create" id="popupAddCollection">
    <div class="popup_modal_content no-close no-scrollbar">
        <div class="popup_modal_head">
            Создание коллекции            
            <span class="popup_modal_close">
                <svg viewBox="0 0 320 512">
                    <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
                </svg>
            </span>
        </div>
        <div class="modal_collection_text">
            Название необходимо для нахождения коллекции в поиске, после ее публикации        
        </div>
        <form id="collection-create-form" method="post">
            <div class="popup_input-form w100 collection_input-form">
                <input type="text" name="add_name_collection" placeholder="Введите название">
            </div>
            <div class="modal_collection_btns w100">
                <div class="modal_collection_btn_cancel w100">Отменить</div>
                <button class="modal_collection_btn_confirm w100" type="submit">Подтвердить</button>
            </div>
        </form>
    </div>
</div>
<div class="popup_modal popup_modal_collection_create" id="popupDelCollection">
    <div class="popup_modal_content no-close no-scrollbar">
        <div class="popup_modal_head">
            Подтвердите действие           
            <span class="popup_modal_close">
                <svg viewBox="0 0 320 512">
                    <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
                </svg>
            </span>
        </div>
        <div class="modal_collection_text"> Вы уверены, что хотите удалить коллекцию? </div>
        <form id="collection-del-form" method="post">
            <div class="modal_collection_btns w100">
                <div class="modal_collection_btn_cancel w100">Отменить</div>
                <button class="modal_collection_btn_confirm w100" type="submit">Подтвердить</button>
            </div>
        </form>
    </div>
</div>
<div class="popup_modal popup_modal_collection_create" id="popupApplyCollection">
    <div class="popup_modal_content no-close no-scrollbar">
        <div class="popup_modal_head">
            Подтвердите действие           
            <span class="popup_modal_close">
                <svg viewBox="0 0 320 512">
                    <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
                </svg>
            </span>
        </div>
        <div class="modal_collection_text"> Ваши текущие установленные скины будут изменены на скины из выбранной коллекции </div>
        <form id="collection-apply-form" method="post">
            <div class="modal_collection_btns w100">
                <div class="modal_collection_btn_cancel w100">Отменить</div>
                <button class="modal_collection_btn_confirm w100" type="submit">Подтвердить</button>
            </div>
        </form>
    </div>
</div>