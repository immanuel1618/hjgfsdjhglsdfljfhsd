<link rel="stylesheet" type="text/css" href="<?= $General->arr_general['site'] ?>app/modules/module_block_main_chat/assets/css/1.css?v=<?= time(); ?>">
<div class="chat_background"></div>
<div id="modal_okno_chat" class="modal_okno_chat">
	<div class="block-chat-back">
		<h2 class="text-center"><?= $chat->Translate('_chat_title'); ?></h2>
		<div class="block-chat-info">
			<svg viewBox="0 0 512 512"><path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336c-13.3 0-24 10.7-24 24s10.7 24 24 24h80c13.3 0 24-10.7 24-24s-10.7-24-24-24h-8V248c0-13.3-10.7-24-24-24H216c-13.3 0-24 10.7-24 24s10.7 24 24 24h24v64H216zm40-144a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/></svg>
			<a><?= $chat->Translate('_chat_info'); ?></a>
		</div>
		<div id="chat_main_content">
			<div class="reload-mess"><?= $chat->Translate('_chat_reload'); ?></div>
		</div>
		<div class="block-chat-online">
			<?php if(!empty($onlines)) { echo '<div class="chat_peoples">' . $onlines . '</div>';  } else { echo '<div></div> '; } ?>  
			<?php if(!empty($_SESSION['steamid'])): ?>
			<div class="margin-bottom-15px">    
				<label for="chat_checkbox_call">
					<?= $chat->Translate('_chat_sound'); ?>
					<input id="chat_checkbox_call" class="chat_checkbox" type="checkbox">
					<span class="toggle-track">
						<span class="toggle-indicator">
							<span class="checkMark">
								<svg viewBox="0 0 24 24" id="ghq-svg-check" role="presentation" aria-hidden="true"><path d="M9.86 18a1 1 0 01-.73-.32l-4.86-5.17a1.001 1.001 0 011.46-1.37l4.12 4.39 8.41-9.2a1 1 0 111.48 1.34l-9.14 10a1 1 0 01-.73.33h-.01z"></path></svg>
							</span>
						</span>
					</span>
				</label>
			</div>    
			<?php endif; ?>
		</div>
		<div class="chat_footer_send">
			<input type="hidden" id="chat_alert" value="<?= $_SESSION['steamid64'] ?>">
			<form id="chat_send_message">
				<textarea type="text" id="msg_input" rows="1" maxlength="500" autocomplete="off" autocomplete="off" spellcheck="true" placeholder="<?= $chat->Translate('_chat_add_msg'); ?>" required></textarea>
			</form>
			<div class="chat_smile_btn">
				<svg id="chat_menu_smile" viewBox="0 0 512 512"><path d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm177.6 62.1C192.8 334.5 218.8 352 256 352s63.2-17.5 78.4-33.9c9-9.7 24.2-10.4 33.9-1.4s10.4 24.2 1.4 33.9c-22 23.8-60 49.4-113.6 49.4s-91.7-25.5-113.6-49.4c-9-9.7-8.4-24.9 1.4-33.9s24.9-8.4 33.9 1.4zM144.4 208a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm192-32a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>
			</div>
			<div class="chat_menu_smile">
				<?php foreach($smileys as $smiley): ?>
					<a class="smiley_js"><?= $smiley ?></a>
				<?php endforeach; ?>
			</div>
			<button type="submit" form="chat_send_message">
				<svg viewBox="0 0 512 512"><path d="M49.9 27.8C15.1 12.7-19.2 50.1-1.2 83.5L68.1 212.2c4.4 8.3 12.6 13.8 21.9 15c0 0 0 0 0 0l176 22c3.4 .4 6 3.3 6 6.7s-2.6 6.3-6 6.7l-176 22s0 0 0 0c-9.3 1.2-17.5 6.8-21.9 15L-1.2 428.5c-18 33.4 16.3 70.8 51.1 55.7L491.8 292.7c32.1-13.9 32.1-59.5 0-73.4L49.9 27.8z"/></svg>
			</button>
		</div>
	</div>
</div>
<button class="chat_open" data-toggle="chat">
	<svg viewBox="0 0 512 512"><path d="M0 64C0 28.7 28.7 0 64 0H448c35.3 0 64 28.7 64 64V352c0 35.3-28.7 64-64 64H309.3L185.6 508.8c-4.8 3.6-11.3 4.2-16.8 1.5s-8.8-8.2-8.8-14.3V416H64c-35.3 0-64-28.7-64-64V64zm152 80c-13.3 0-24 10.7-24 24s10.7 24 24 24H360c13.3 0 24-10.7 24-24s-10.7-24-24-24H152zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24H264c13.3 0 24-10.7 24-24s-10.7-24-24-24H152z"/></svg>
</button>
<script>
	const chat_notified = '<?= $chat->Translate('_chat_notified'); ?>',
		  chat_msg_time = '<?= $chat->Translate('_chat_msg_time'); ?>';
</script>
<script defer src="<?= $General->arr_general['site'] ?>app/modules/module_block_main_chat/assets/js/chat.js?v=<?= time(); ?>"></script>