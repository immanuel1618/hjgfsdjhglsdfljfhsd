<?php

use app\modules\module_block_main_chat\ext\ChatEngine;

$chat = new ChatEngine($General, $Translate);

if (isset($_POST['get_messages'])) {
    exit($chat->get_html_msgs($_POST['num_messages'], $_POST['new_message']));
}

switch(true):
    case($_POST['send_message']):
        exit($chat->send_msg($_POST['send_message']));
        break;
    case($_POST['delete_message']):
        exit($chat->delete_msg($_POST['id_del_chat']));
        break;
    case($_POST['get_onlines']):
        $getPrev = intval($_POST['get_prev']);
        $getCount = intval($_POST['get_count']);
        exit($chat->get_onlines(["prev" => $getPrev, "count" => $getCount]));
        break;
    case($_POST['update_check']):
        exit($chat->update_check($_POST['update_check']));
        break;
endswitch;

$smileys = ['😀', '😁', '😂', '😃', '😄', '😅', '😆', '😇', '😈',
            '😉', '😊', '😋', '😌', '😍', '😎', '😏', '😐', '😑',
            '😒', '😓', '😔', '😕', '😖', '😗', '😘', '😙', '😚',
            '😛', '😜', '😝', '😞', '😟', '😠', '😡', '🤡', '😢',
			'😣', '😤', '😥', '😦', '😧', '😨', '😩', '😪', '😫',
			'😬', '😭', '😮', '😯', '😰', '😱', '😲', '😳', '😴',
			'😵', '😶', '😷', '😸', '😹', '😺', '😻', '😼', '😽',
			'😾', '😿', '🙀', '💩', '☠', '✌', '👌', '👍', '👎',
			'🖕', '🙈', '🙉', '🙊', '📢', '📣' , '🔔', '🔕', '💙'];


$onlines = $chat->get_onlines();