<?php 
function upload_file($file, $allowed_types= array('image/png','image/x-png','image/jpeg','image/webp','image/gif')){
    $filename = $file['name'];
    $upload_dir = realpath(dirname(__FILE__)) . '/cacheimg/';
    $blacklist = array(".php", ".phtml", ".php3", ".php4");
    $ext = substr($filename, strrpos($filename,'.'), strlen($filename)-1); 
    if(in_array($ext,$blacklist )){
      return ['error' => 'Запрещено загружать исполняемые файлы'];
    }
    $max_filesize = 8388608;
    $prefix = date('Ymd-is_');
    if(!in_array($file['type'], $allowed_types))
      return ['error' => 'Данный тип файла не поддерживается.'];
    if(filesize($file['tmp_name']) > $max_filesize)
      return ['error' => 'Файл слишком большой. максимальный размер ' . intval($max_filesize / (1024 * 1024)) . 'мб'];
    if(!move_uploaded_file($file['tmp_name'],$upload_dir.$prefix.$filename))
      return ['error' => 'При загрузке возникли ошибки. Попробуйте ещё раз.'];
    return ['status' => 1, 'image_link' => 'app/modules/module_page_request/ext/cacheimg/'.$prefix.$filename];
}
echo json_encode(upload_file($_FILES['img']), true); ?>