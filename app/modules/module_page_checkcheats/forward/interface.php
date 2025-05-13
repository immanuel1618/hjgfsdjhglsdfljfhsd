<?php

function get_cache($id)
{
    if (file_exists($id)) {
        $packed_data = file_get_contents($id);
        return json_decode($packed_data, true);
    } else {
        return null;
    }
}

function Settings($text)
{
    $settings = get_cache(MODULES . "module_page_checkcheats/settings.json");
    
    if ($settings && isset($settings[$text])) {
        return $settings[$text];
    } else {
        return null;
    }
}

$allowOnlyAuthorized = Settings('allow_only_authenticated');

if (isset($_GET['action']) && $_GET['action'] == 'download') {

    // Проверка на авторизацию, если включено
    if ($allowOnlyAuthorized == "1" && !isset($_SESSION['steamid64'])) {
        header('Location: ?auth=login');
        exit;
    }

    // Доступные файлы для скачивания
    $files = [
        'file1' => 'WARFAL-CHECKER-Installer.exe',
        'file2' => 'Software-WARFAL-RU.zip',
        'file3' => 'UnrealCheatFinder.exe'
    ];

    if (isset($_GET['file']) && array_key_exists($_GET['file'], $files)) {
        $file = $files[$_GET['file']];
        $filePath = MODULES . "module_page_checkcheats/assets/files/" . $file;

        if (file_exists($filePath)) {

            // Очистка буфера вывода, чтобы избежать вывода лишней информации
            ob_clean();
            flush();

            // Заголовки для скачивания
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            header('Content-Length: ' . filesize($filePath));
            header('Cache-Control: no-cache, no-store, must-revalidate');  // Для предотвращения кэширования

            // Оптимизация: потоковая передача данных для более быстрого скачивания
            $fileStream = fopen($filePath, 'rb');  // Открываем файл для чтения в бинарном режиме
            if ($fileStream) {
                while (!feof($fileStream)) {
                    echo fread($fileStream, 8192);  // Читаем и передаем файл кусками по 8 KB
                    flush();  // Убеждаемся, что данные сразу передаются пользователю
                }
                fclose($fileStream);  // Закрываем файл
            } else {
                die('Ошибка при открытии файла для чтения');
            }

            exit;
        } else {
            die('Файл не найден');
        }
    } else {
        die('Неверный файл для скачивания');
    }
}
?>


<div class="card top-card">
	<div class="soft-banner"> <img src="/app/modules/module_page_checkcheats/assets/img/bg-soft.png">
		<h1 class="soft-title"><?= $Translate->get_translate_module_phrase('module_page_checkcheats', '_ProgramTitle'); ?></h1> </div>
</div>
<div class="card img-card">
	<div class="soft-block">
		<div class="soft-column-1">
			<div class="soft-screens-con">
				<button class="soft-screens-right" onclick="rightScroll()">
					<svg viewBox="0 0 384 512">
						<path d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 278.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"></path>
					</svg>
				</button>
				<div class="soft-screens"> <img src="/app/modules/module_page_checkcheats/assets/img/image1.png"> <img src="/app/modules/module_page_checkcheats/assets/img/image2.png"> <img src="/app/modules/module_page_checkcheats/assets/img/image3.png"> <img src="/app/modules/module_page_checkcheats/assets/img/image4.png"> </div>
				<button class="soft-screens-left" onclick="leftScroll()">
					<svg viewBox="0 0 384 512">
						<path d="M342.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L274.7 256 105.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
					</svg>
				</button>
			</div>
		</div>
	</div>
</div>
<div class="stats-grid-22">
	<div class="outer-support-right1">
		<h1 class="checker-name"><?= $Translate->get_translate_module_phrase('module_page_checkcheats', '_CheckerName'); ?>
</h1>
		<hr>
		<div class="support-right-content1">
			<div class="support-right-content-spisor-outer-item1">
				<div class="support-right-content-spisor-text1">
					<div><b class="dop-text">•</b> <?= $Translate->get_translate_module_phrase('module_page_checkcheats', '_ProgramDescription1'); ?></div>
					<div><b class="dop-text">•</b> <?= $Translate->get_translate_module_phrase('module_page_checkcheats', '_ProgramDescription2'); ?></div>
					<div><b class="dop-text">•</b> <?= $Translate->get_translate_module_phrase('module_page_checkcheats', '_ProgramDescription3'); ?></div>
					<div><b class="dop-text">•</b> <?= $Translate->get_translate_module_phrase('module_page_checkcheats', '_ProgramDescription4'); ?></div>
					<div><b class="dop-text">•</b> <?= $Translate->get_translate_module_phrase('module_page_checkcheats', '_ProgramDescription5'); ?></div>
					<div><b class="dop-text">•</b> <?= $Translate->get_translate_module_phrase('module_page_checkcheats', '_ProgramDescription6'); ?><a target="_blank" href="https://astralzone.space/request/"><?= $Translate->get_translate_module_phrase('module_page_checkcheats', '_ProgramDescription7'); ?></a></div>
				</div>
			</div>
		</div>
	</div>
	<?php if($allowOnlyAuthorized == "1" && !isset($_SESSION['steamid64'])): ?>
    <div class="stats-grid-22-sticky2">
        <div class="block-info-users">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
    			<path d="m 8.074219 0 c -1.203125 -0.0117188 -2.40625 0.285156 -3.492188 0.890625 c -0.480469 0.269531 -0.652343 0.878906 -0.382812 1.359375 c 0.269531 0.484375 0.878906 0.65625 1.359375 0.386719 c 1.550781 -0.867188 3.4375 -0.847657 4.972656 0.050781 c 1.53125 0.898438 2.46875 2.535156 2.46875 4.3125 v 1 c 0 0.550781 0.449219 1 1 1 s 1 -0.449219 1 -1 v -1 c 0 -0.019531 0 -0.039062 -0.003906 -0.054688 c -0.019532 -2.460937 -1.332032 -4.738281 -3.457032 -5.984374 c -1.070312 -0.628907 -2.265624 -0.9492192 -3.46875 -0.960938 z m -5.199219 2.832031 c -0.066406 0 -0.132812 0.007813 -0.195312 0.023438 c -0.257813 0.058593 -0.484376 0.21875 -0.625 0.445312 c -0.6875 1.109375 -1.054688 2.390625 -1.054688 3.699219 v 5.0625 c 0 0.550781 0.449219 1 1 1 s 1 -0.449219 1 -1 v -5.0625 c 0 -0.933594 0.261719 -1.851562 0.753906 -2.644531 c 0.292969 -0.46875 0.148438 -1.082031 -0.320312 -1.375 c -0.167969 -0.105469 -0.363282 -0.15625 -0.558594 -0.148438 z m 5.125 0.167969 c -2.199219 0 -4 1.800781 -4 4 v 1 c 0 0.550781 0.449219 1 1 1 s 1 -0.449219 1 -1 v -1 c 0 -1.117188 0.882812 -2 2 -2 s 2 0.882812 2 2 v 5 s 0.007812 0.441406 0.175781 0.941406 s 0.5 1.148438 1.117188 1.765625 c 0.390625 0.390625 1.023437 0.390625 1.414062 0 s 0.390625 -1.023437 0 -1.414062 c -0.382812 -0.382813 -0.550781 -0.734375 -0.632812 -0.984375 s -0.074219 -0.308594 -0.074219 -0.308594 v -5 c 0 -2.199219 -1.800781 -4 -4 -4 z m 0 3 c -0.550781 0 -1 0.449219 -1 1 v 5 s 0 0.59375 0.144531 1.320312 c 0.144531 0.726563 0.414063 1.652344 1.148438 2.386719 c 0.390625 0.390625 1.023437 0.390625 1.414062 0 s 0.390625 -1.023437 0 -1.414062 c -0.265625 -0.265625 -0.496093 -0.839844 -0.601562 -1.363281 c -0.105469 -0.523438 -0.105469 -0.929688 -0.105469 -0.929688 v -5 c 0 -0.550781 -0.449219 -1 -1 -1 z m -3 4 c -0.550781 0 -1 0.449219 -1 1 v 3 c 0 0.550781 0.449219 1 1 1 s 1 -0.449219 1 -1 v -3 c 0 -0.550781 -0.449219 -1 -1 -1 z m 9 0 c -0.550781 0 -1 0.449219 -1 1 s 0.449219 1 1 1 s 1 -0.449219 1 -1 s -0.449219 -1 -1 -1 z m 0 0" fill="#2e3434"/>
			</svg>
            <h2 class="block-info-users-type">Авторизуйтесь для скачивания</h2>
            <div class="block-info-users-text">Для того чтобы скачать программу, вам нужно пройти авторизацию через Steam.</div>
            <a class="block-info-users-button" href="?auth=login">Войти</a>
        </div>
    </div>
<?php elseif(isset($_SESSION['steamid64']) || $allowOnlyAuthorized == "0"): ?>
    <div class="stats-grid-22-sticky2">
        <div class="block-info-users">
            <svg viewBox="0 0 512 512">
                <path d="M216 0h80c13.3 0 24 10.7 24 24v168h87.7c17.8 0 26.7 21.5 14.1 34.1L269.7 378.3c-7.5 7.5-19.8 7.5-27.3 0L90.1 226.1c-12.6-12.6-3.7-34.1 14.1-34.1H192V24c0-13.3 10.7-24 24-24zm296 376v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h146.7l49 49c20.1 20.1 52.5 20.1 72.6 0l49-49H488c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z"></path>
            </svg>
            <h2 class="block-info-users-type">Скачать программу!</h2>
            <div class="block-info-users-text">Приступите к проверке как можно быстрее!</div>
            <a class="block-info-users-button" name="dfile" href="?action=download&file=file1" download="" data-lineid="1" download="">Программа проверки - ASTRAL CHECKER</a>
            <a class="block-info-users-button" href="https://www.virustotal.com/gui/file-analysis/MTQwNDYzZDNkOTAzMDFhODNlZTJmNzYwYTA5Y2U5NTI6MTczOTcyNjI4Mg==" target="_blank">Проверить на вирусы - VirusTotal</a>
        </div>
    </div>
<?php endif; ?>
</div>
</div>