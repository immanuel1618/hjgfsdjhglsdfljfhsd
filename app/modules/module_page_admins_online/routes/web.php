<?php
switch ($page) 
{ 
    case 'install':
        require_once MODULES . 'module_page_admins_online/includes/install.php';
        header_fix($General->arr_general['site'] . 'admins_online/'); 
        break;  
    case 'settings':
        require_once MODULES . 'module_page_admins_online/includes/settings.php';
        break; 
    default:
        header_fix($General->arr_general['site'] . 'admins_online/'); 
}
