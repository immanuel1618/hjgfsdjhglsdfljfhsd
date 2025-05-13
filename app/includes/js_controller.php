<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */
// Получение информации о каком-либо значении по ключу массива в options.php
if( $_POST["function"] == 'options' && isset( $_POST["setup"] ) ):

    $options =  require  '../../storage/cache/sessions/options.php';

    if( $_POST["setup"] == 'web_key' ):
        // Возобновление сессии
        session_start();

        if( isset( $_SESSION['user_admin'] ) ):
            echo json_encode( ( require  '../../storage/cache/sessions/options.php' )[ $_POST["setup"] ] );
            exit;
        else:
            exit;
        endif;
    else:
        echo json_encode( ( require  '../../storage/cache/sessions/options.php' )[ $_POST["setup"] ] );
        exit;
    endif;
endif;

// Присвоение какого-либо значения по ключу массива в options.php
if( $_POST["function"] == 'set' & isset( $_POST["option"] ) ) {
    // Возобновление сессии
    session_start();

    if( isset( $_SESSION['user_admin'] ) ):
        // Подключение основных функций.
        require '../../app/includes/functions.php';

        // Получение текущих настроек.
        $options = require '../../storage/cache/sessions/options.php';

        if ( empty( $_POST["data"] ) || is_numeric( $_POST["data"] ) ):

            // Изменение конкретной опции.
            $options[ $_POST["option"] ] = (int) $options[ $_POST["option"] ] == 0 ? 1 : 0;
        else:
            $options[ $_POST["option"] ] = $_POST["data"];
        endif;

        // Проверка на доп изменения.
        if( ! empty( $_POST["change"] ) ):

            // Если в строке есть 'css' выполнить чистку кэша по CSS
            if ( stristr( $_POST["change"], 'css') !== false ):

                // Проверка папки на пустоту
                $is_empty = sizeof( glob('../../storage/assets/css/generation/*') ) ? true : false;

                // Если папка не пустая, провести очистку
                if( $is_empty == true ):
                    $temp_files = glob( '../../storage/assets/css/generation/*' );
                    foreach( $temp_files as $temp_file ) {
                        if( is_file( $temp_file ) )
                            unlink( $temp_file );
                    }
                endif;
            endif;

            // Если в строке есть 'js' выполнить чистку кэша по JS
            if ( stristr( $_POST["change"], 'js') !== false ):

                // Проверка папки на пустоту
                $is_empty = sizeof( glob('../../storage/assets/js/generation/*') ) ? true : false;

                // Если папка не пустая, провести очистку
                if( $is_empty == true ):
                    $temp_files = glob( '../../storage/assets/js/generation/*' );
                    foreach( $temp_files as $temp_file ) {
                        if( is_file( $temp_file ) )
                            unlink( $temp_file );
                    }
                endif;
            endif;
        endif;

        // Сохранение файла.
        file_put_contents( '../../storage/cache/sessions/options.php', '<?php return ' . var_export_min( $options ) . ';' );
        exit;
    else:
        exit;
    endif;
}

// Присвоение какого-либо значения по ключу массива в options.php
if( $_POST["function"] == 'delete' && ( isset( $_POST["server"] ) || isset( $_POST["table"] ) ) ):
    // Возобновление сессии
    session_start();

    if( isset( $_SESSION['user_admin'] ) ):
        // Подключение основных функций.
        require '../../app/includes/functions.php';

        if( isset( $_POST["table"] ) ):
            $db = require '../../storage/cache/sessions/db.php';

            $del = explode( ";", $_POST["table"] );

            if ( sizeof( $del ) > 1 ):
                if ( sizeof( $db[ $del[0] ] ) == 1 && sizeof( $db[ $del[0] ][ $del[1] ]['DB'] ) == 1 && sizeof( $db[ $del[0] ][ $del[1] ]['DB'][ $del[2] ]['Prefix'] ) == 1 ):
                    unset( $db[ $del[0] ] );
                elseif( sizeof( $db[ $del[0] ][ $del[1] ]['DB'][ $del[2] ]['Prefix'] ) > 1 ):
                    unset( $db[ $del[0] ][ $del[1] ]['DB'][ $del[2] ]['Prefix'][ $del[3] ] );
                    rsort( $db[ $del[0] ][ $del[1] ]['DB'][ $del[2] ]['Prefix'] );
                elseif( sizeof( $db[ $del[0] ][ $del[1] ]['DB'] ) > 1):
                    unset( $db[ $del[0] ][ $del[1] ]['DB'][ $del[2] ] );
                    rsort( $db[ $del[0] ][ $del[1] ]['DB'] );
                elseif( sizeof( $db[ $del[0] ] ) > 1):
                    unset( $db[ $del[0] ][ $del[1] ] );
                    rsort( $db[ $del[0] ] );
                endif;
            else:
                unset( $db[ $del[0] ] );
            endif;

            // Сохранение файла.
            file_put_contents( '../../storage/cache/sessions/db.php', '<?php return ' . var_export_min( $db ) . ';' );
            exit;
        endif;
    else:
        exit;
    endif;
endif;

// Получение данных о текущем состоянии определенной сессии
if( $_POST["function"] == 'sessions' & isset( $_POST["data"] ) ) {
    // Возобновление сессии
    session_start();

    echo (int) $_SESSION[ $_POST["data"] ] ;
    exit;
}

// Работа со скачиванием аватаров посредством Steam API.
if($_POST["function"] == 'avatars' ) {
    // Нахожение в пространстве LR.
    define('IN_LR', true);

    // Ограничение работы стрипта.
    set_time_limit(160);

    // Итоговый результат является массивом.
    $return = [];

    if (isset($_POST['data'])) {
        // Присваивание к переменной полученный массив со списком Steam ID игроков.
        $avatars = $_POST['data'];
        
        $settings = (require '../../storage/cache/sessions/options.php');
        
        // Время кэша аватаров
        $expired = time() - $settings['avatars_cache_time'];
        
        // Не получаем новые аватарки при наличии кэша
        foreach ($avatars as $k => $avatar) {
            // Пути до каждого аватара
            $cache = '../../storage/cache/img/avatars/' . $avatar . '.json';
            
            // Кэш сущетсвует и обновлен менее суток назад - нам эта аватарка не нужна
            if( file_exists( $cache ) && filemtime( $cache ) > $expired && file_exists( $cache ) && filemtime( $cache ) > $expired ) unset($avatars[$k]);
        }
        
        // Генерация запроса к Steam API для получения информации о пользователях.
        $result1 = curl_init('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=' . $settings['web_key'] . '&steamids=' . implode(",", $avatars));
        curl_setopt($result1, CURLOPT_RETURNTRANSFER, 1);
        $url1 = curl_exec($result1);
        curl_close($result1);

        $data1 = json_decode($url1, true)['response']['players'];

        $data1count = is_array($data1) ? sizeof($data1) : 0;

        for ($i = 0; $i < $data1count; $i++) {
            $result2 = curl_init('https://api.steampowered.com/IPlayerService/GetAnimatedAvatar/v1/?key=' . $settings['web_key'] . '&steamid=' . $data1[$i]['steamid']);
            curl_setopt($result2, CURLOPT_RETURNTRANSFER, 1);
            $data2 = json_decode(curl_exec($result2), true);
            curl_close($result2);
    
            $result3 = curl_init('https://api.steampowered.com/IPlayerService/GetAvatarFrame/v1/?key=' . $settings['web_key'] . '&steamid=' . $data1[$i]['steamid']);
            curl_setopt($result3, CURLOPT_RETURNTRANSFER, 1);
            $data3 = json_decode(curl_exec($result3), true);
            curl_close($result3);

            $cacheFile = "../../storage/cache/img/avatars/" . $data1[$i]['steamid'] . ".json";

            $json = [
                'avatar' => $data1[$i]['avatarfull'],
                'name'   => $data1[$i]['personaname'],
                'slim'   => $data1[$i]['avatar'],
                'animated' => isset($data2['response']['avatar']['image_small']) ? 'https://cdn.akamai.steamstatic.com/steamcommunity/public/images/' . $data2['response']['avatar']['image_small'] : '',
                'frame' => isset($data3['response']['avatar_frame']['image_small']) ? 'https://cdn.akamai.steamstatic.com/steamcommunity/public/images/' . $data3['response']['avatar_frame']['image_small'] : ''
            ];

            if(!empty($data1[$i]['avatarfull'])) {
                file_put_contents($cacheFile, json_encode($json));
                $res[] = [
                    'avatar' => isset($data2['response']['avatar']['image_small']) ? 'https://cdn.akamai.steamstatic.com/steamcommunity/public/images/' . $data2['response']['avatar']['image_small'] : $data1[$i]['avatarfull'],
                    'frame' => isset($data3['response']['avatar_frame']['image_small']) ? 'https://cdn.akamai.steamstatic.com/steamcommunity/public/images/' . $data3['response']['avatar_frame']['image_small'] : $settings['site'] . 'storage/cache/img/avatars/1_frame.png'
                ];
            } else {
                $res[] = [
                    'avatar' => $settings['site'] . 'storage/cache/img/avatars/1_avatar.jpg',
                    'frame' => $settings['site'] . 'storage/cache/img/avatars/1_frame.png'
                ];
            }
        }

        echo json_encode($res);
        exit;
    }
}