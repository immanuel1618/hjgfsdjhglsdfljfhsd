<?php

use app\modules\module_page_store\ext\ErrorLog;

if (!isset($_SESSION['user_admin']) || IN_LR != true) {
    header('Location: ' . $General->arr_general['site']);
    exit;
}

$checkTables =  array(
    'lvl_web_shop_table_properties',
    'lvl_web_shop_card_properties',
    'lvl_web_shop_price_options',
    'lvl_web_shop_discounts',
    'lvl_web_shop_products',
    'lvl_web_shop_options',
    'lvl_web_shop_servers',
    'lvl_web_shop_basket',
    'lvl_web_shop_promo',
    'lvl_web_shop_logs',
);

$absentTables = [];
foreach ($checkTables as $table) {
    if (!$Db->mysql_table_search('Core', $Db->db_data['Core'][0]['USER_ID'], $Db->db_data['Core'][0]['DB_num'], $table)) {
        $absentTables[$table] = 1;
    }
}

$queryies = [];
if (!empty($absentTables) || 1) {
    $queryies = [
        "CREATE TABLE IF NOT EXISTS `lvl_web_shop_basket` ( `id` INT(10) NOT NULL AUTO_INCREMENT, `price_id` INT(10) NOT NULL, `steam` TINYTEXT NOT NULL, PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;",

        "CREATE TABLE IF NOT EXISTS `lvl_web_shop_discounts` ( `id` INT(10) NOT NULL AUTO_INCREMENT , `product_id` INT(10) NOT NULL , `value` INT(3) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;",

        "CREATE TABLE IF NOT EXISTS `lvl_web_shop_servers` ( `id` INT(10) NOT NULL AUTO_INCREMENT , `web_server_id` INT(10) NOT NULL , `name` TINYTEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;",

        "CREATE TABLE IF NOT EXISTS `lvl_web_shop_options` ( `id` INT(10) NOT NULL AUTO_INCREMENT , `only_for_admin` BOOLEAN NOT NULL, `use_server_accept` BOOLEAN NOT NULL, `amount_value` TINYTEXT NOT NULL, `discord_webhook` VARCHAR(400) NULL DEFAULT NULL, `hexcolor_wehbook` VARCHAR(400) NULL DEFAULT NULL, `img_webhook` VARCHAR(400) NULL DEFAULT NULL, `column_count` INT(1) NOT NULL,  `extend_cards` BOOLEAN NOT NULL, PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;",

        "CREATE TABLE IF NOT EXISTS `lvl_web_shop_price_options` ( `id` INT(10) NOT NULL AUTO_INCREMENT, `product_id` INT(10) NOT NULL , `price` INT(10) NOT NULL , `options` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;",

        "CREATE TABLE IF NOT EXISTS `lvl_web_shop_promo` ( `id` INT(10) NOT NULL AUTO_INCREMENT , `name` TINYTEXT NOT NULL , `percent` INT(3) NOT NULL , `amount` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;",

        "CREATE TABLE IF NOT EXISTS `lvl_web_shop_card_properties` ( `id` INT(10) NOT NULL AUTO_INCREMENT , `product_id` INT(10) NOT NULL , `title` VARCHAR(300) NULL DEFAULT NULL , `active` BOOLEAN NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;",

        "CREATE TABLE IF NOT EXISTS `lvl_web_shop_table_properties` (`id` INT(10) NOT NULL AUTO_INCREMENT , `product_id` INT(10) NOT NULL , `title` VARCHAR(300) NULL DEFAULT NULL , `active` BOOLEAN NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;",

        "CREATE TABLE IF NOT EXISTS `lvl_web_shop_logs` ( `id` INT(10) NOT NULL AUTO_INCREMENT , `steam` TINYTEXT NOT NULL, `title` VARCHAR(300) NULL DEFAULT NULL , `promo` TINYTEXT NULL, `status` BOOLEAN NOT NULL , `date` DATETIME NOT NULL, PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;",

        "CREATE TABLE IF NOT EXISTS `lvl_web_shop_products`( `id` INT(10) NOT NULL AUTO_INCREMENT , `server_id` INT(10) NOT NULL, `type` TINYTEXT NOT NULL, `title` TINYTEXT NOT NULL, `badge` VARCHAR(300) NULL DEFAULT NULL, `table_status` BOOLEAN NOT NULL DEFAULT TRUE, `img` VARCHAR(300) NULL DEFAULT NULL, `color` TINYTEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;",

        "CREATE TABLE IF NOT EXISTS `lvl_web_shop_category`( `id` INT(10) NOT NULL AUTO_INCREMENT , `name` TINYTEXT NOT NULL ,`sort` INT(3) NOT NULL, PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;",

        "ALTER TABLE `lvl_web_shop_options` 
        ADD UNIQUE INDEX `only_for_admin_UNIQUE` (`only_for_admin` ASC),
        ADD UNIQUE INDEX `use_server_accept_UNIQUE` (`use_server_accept` ASC),
        ADD UNIQUE INDEX `discord_webhook_UNIQUE` (`discord_webhook` ASC);",

        "ALTER TABLE `lvl_web_shop_discounts` 
        ADD UNIQUE INDEX `product_id_UNIQUE` (`product_id` ASC);",

        "ALTER TABLE `lvl_web_shop_servers` ADD `iks_id` VARCHAR(10) NULL AFTER `name`;",

        "ALTER TABLE `lvl_web_shop_options` ADD `vk_apikey` VARCHAR(400) NULL AFTER `img_webhook`;",
        "ALTER TABLE `lvl_web_shop_options` ADD `vk_peer_id` VARCHAR(10) NULL AFTER `vk_apikey`;",

        "ALTER TABLE `lvl_web_shop_products` ADD `title_show` tinyint(1) NOT NULL DEFAULT 1 AFTER `title`;",
        "ALTER TABLE `lvl_web_shop_products` ADD `status` tinyint(1) NOT NULL DEFAULT 1 AFTER `server_id`;",
        "ALTER TABLE `lvl_web_shop_products` ADD `category` VARCHAR(10) NOT NULL DEFAULT 0 AFTER `color`;",
        "ALTER TABLE `lvl_web_shop_products` ADD `sort` INT(3) NOT NULL DEFAULT 0 AFTER `category`;",

        "ALTER TABLE `lvl_web_shop_card_properties` ADD `sort` INT(3) NOT NULL DEFAULT 0 AFTER `active`;",
        "ALTER TABLE `lvl_web_shop_table_properties` ADD `sort` INT(3) NOT NULL DEFAULT 0 AFTER `active`;",

        "ALTER TABLE `lvl_web_shop_logs` ADD `server` VARCHAR(255) NULL AFTER `title`;",

        "ALTER TABLE `lvl_web_shop_logs` ADD `gift` TINYTEXT NULL AFTER `promo`;",

        "INSERT IGNORE INTO `lvl_web_shop_discounts` (`product_id`, `value`) VALUES ('-1', '0');",

        "INSERT IGNORE INTO `lvl_web_shop_options` (`only_for_admin`, `use_server_accept`, `amount_value`, `discord_webhook`, `hexcolor_wehbook`, `img_webhook`, `vk_apikey`, `vk_peer_id`, `column_count`, `extend_cards`) VALUES (0, 0, '₽', '', '#5865F2', 'webhook.png','', '', 3, 0);",
    ];
}
try {
    foreach ($queryies as $query) {
        $Db->query('Core', 0, 0, $query);
    }
} catch (\Exception $e) {
    ErrorLog::add($e);
    exit;
}

header("Location: " . get_url(2));
