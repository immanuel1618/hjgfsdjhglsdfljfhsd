<?php

/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

namespace app\ext;

class Graphics
{

    /**
     * @since 0.2.123
     * @var object
     */
    public    $Translate;

    /**
     * @since 0.2
     * @var object
     */
    public    $General;

    /**
     * @since 0.2
     * @var object
     */
    public    $Modules;

    /**
     * @since 0.2
     * @var object
     */
    public    $Db;

    /**
     * @since 0.2
     * @var object
     */
    public    $Auth;

    /**
     * @since 0.2
     * @var object
     */
    public    $Notifications;

    /**
     * @since 0.2
     * @var object
     */
    public    $Router;

    /**
     * Инициализация графической составляющей вэб-интерфейса с подгрузкой модулей.
     * 
     * @param object $Translate
     * @param object $General
     * @param object $Modules
     * @param object $Db
     * @param object $Auth
     * @param object $Notifications
     *
     * @since 0.2
     */
    function __construct($Translate, $General, $Modules, $Db, $Auth, $Notifications, $Router)
    {

        // Проверка на основную константу.
        defined('IN_LR') != true && die();

        // Присвоение глобальных объектов.
        $Graphics            = $this;
        $this->Translate     = $Translate;
        $this->General       = $General;
        $this->Modules       = $Modules;
        $this->Db            = $Db;
        $this->Auth          = $Auth;
        $this->Notifications = $Notifications;
        $this->Router        = $Router;

        // Проверка на авторизованного пользователя
        if (!empty($_SESSION['steamid']) || isset($_POST)) : (empty($Modules->arr_module_init['page'][$Modules->route]) && !isset($_GET['auth'])) && get_iframe("404", "Страница не найдена") && die();

            // Подгрузка данных из модулей которые не относятся к интерфейсу и должны быть получены до начала рендера страницы.
            for ($module_id = 0, $c_mi = sizeof($Modules->arr_module_init['page'][$Modules->route]['data']); $module_id < $c_mi; $module_id++) :
                $file = MODULES . $Modules->arr_module_init['page'][$Modules->route]['data'][$module_id] . '/forward/data.php';
                file_exists($file) && require $file;
            endfor;

            // Дополнительный поток под модули, которые должны задействовать ядро на постоянной основе, а не локально.
            if (!empty($Modules->arr_module_init['data_always'])) :
                for ($module_id = 0, $c_mi = sizeof($Modules->arr_module_init['data_always']); $module_id < $c_mi; $module_id++) :
                    $file = MODULES . $Modules->arr_module_init['data_always'][$module_id] . '/forward/data_always.php';
                    file_exists($file) && require $file;
                endfor;
            endif;

        endif;

        require PAGE . 'head.php';

        //Рендер кастомного head
        (file_exists(TEMPLATES . $General->arr_general['theme'] . '/interface/head.php')) && require TEMPLATES . $General->arr_general['theme'] . '/interface/head.php';

        // Рендер блока - Sidebar
        (file_exists(TEMPLATES . $General->arr_general['theme'] . '/interface/sidebar.php')) && require TEMPLATES . $General->arr_general['theme'] . '/interface/sidebar.php';

        // Рендер блока - Navbar
        (file_exists(TEMPLATES . $General->arr_general['theme'] . '/interface/navbar.php')) && require TEMPLATES . $General->arr_general['theme'] . '/interface/navbar.php';

        (file_exists(TEMPLATES . $General->arr_general['theme'] . '/interface/container.php')) && require TEMPLATES . $General->arr_general['theme'] . '/interface/container.php';

        if (empty($_SESSION['iframe'])) {
            if (!empty($Modules->arr_module_init['interface_always']['afternavbar'])) :
                for ($module_id = 0, $c_mi = sizeof($Modules->arr_module_init['interface_always']['afternavbar']); $module_id < $c_mi; $module_id++) :
                    $file = MODULES . $Modules->arr_module_init['interface_always']['afternavbar'][$module_id]['name'] . '/forward/interface_always.php';
                    file_exists($file) && require $file;
                endfor;
            endif;
    
            if (!empty($Modules->arr_module_init['page'][$Modules->route]['interface']['afternavbar'])) :
                for ($module_id = 0, $c_mi = sizeof($Modules->arr_module_init['page'][$Modules->route]['interface']['afternavbar']); $module_id < $c_mi; $module_id++) :
                    $file = MODULES . $Modules->arr_module_init['page'][$Modules->route]['interface']['afternavbar'][$module_id] . '/forward/interface.php';
                    file_exists($file) && require $file;
                endfor;
            endif;
        } else {
            require PAGE . 'iframe.php';
        }

        // Рендер блока - Footer
        require PAGE . 'footer.php';
    }

    /**
     * Получение и вывод цветовой палитный сайта.
     *
     * @since 0.2
     * 
     * @return string         Цветовая плалитра ( CSS / Style / ROOT )
     */
    public function get_css_color_palette() {
        return ':root' . str_replace( '"', '', str_replace( '",', ';', file_get_contents_fix ( 'app/templates/' . $this->General->arr_general['theme'] . '/colors.json' ) ) ) .  ' ';
    }
}