<div class="col-md-12">
	<select style="display: none;" class="custom-select" onchange="window.location.href=this.value" placeholder="<?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Logs_ref'); ?>">
		<option value="<?= $General->arr_general['site'] ?>adminpanel/?section=logsweb"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Logs_engine'); ?></option>
		<?php if (file_exists(MODULES . 'module_page_pay/description.json')) : ?>
			<option value="<?= $General->arr_general['site'] ?>adminpanel/?section=logslk"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Logs_pay'); ?></option>
		<?php endif; ?>
		<?php if (file_exists(MODULES . 'module_page_store/description.json')) : ?>
			<option value="<?= $General->arr_general['site'] ?>adminpanel/?section=logsshop"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Logs_shop'); ?></option>
		<?php endif; ?>
        <option value="<?= $General->arr_general['site'] ?>adminpanel/?section=logsref"><?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Logs_ref'); ?></option>
	</select>
</div>
<div class="col-md-3">
	<div class="card">
		<div class="card-header no_pdb">
			<h5 class="badge"><?= $Translate->get_translate_module_phrase('module_page_pay', '_LogList'); ?></h5>
			<?php 
			$logDir = __DIR__ . '/../../../logs/referral/';
			$hasLogs = false;
			foreach (scandir($logDir) as $key) : 
				if ($key != '.' && $key != '..') : 
					if (is_file($logDir . $key)) : 
						$hasLogs = true;
					endif;
				endif;
			endforeach;
			if ($hasLogs) : ?>
				<form id="all_del_logs_ref">
					<button class="secondary_btn btn_delete w100">
						<?= $Translate->get_translate_module_phrase('module_page_pay', '_Clear'); ?>
					</button>
				</form>
			<?php endif; ?>
		</div>
		<div class="card-container">
			<div class="lk_logs_wrap scroll no-scrollbar">
			<?php 
			$files = scandir($logDir); 
			$files = array_diff($files, array('.', '..')); 
			$files = array_reverse($files);
                foreach ($files as $key) : if (is_file($logDir . $key)) : ?>
							<div style="display: flex; justify-content: space-between; gap: 3px">
								<a href="<?= set_url_section(get_url(2), 'log', urlencode($key)) ?>">
									<?= $key ?>
								</a>
								<button id="log_del_ref" id_del="<?= $key ?>">
									<svg viewBox="0 0 20 20">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M8.188 3.322c.523-.21 1.1-.266 1.656-.158a2.894 2.894 0 0 1 1.468.762l.908.877 2.994-2.909c.237-.222.554-.344.883-.342.329.003.644.131.876.357.233.226.365.531.368.85a1.2 1.2 0 0 1-.352.858l-2.997 2.906.906.877c.4.39.673.886.784 1.426.11.54.053 1.1-.164 1.608l-.652 1.53-8.252-8.009 1.574-.633ZM4.943 4.63l9.227 8.959-1.448 3.391c-.07.163-.18.307-.32.419a1.12 1.12 0 0 1-1.021.196 1.11 1.11 0 0 1-.46-.269L1.093 7.783a1.042 1.042 0 0 1-.073-1.436c.115-.137.262-.243.43-.311L4.942 4.63ZM17.49 17.243c0 .673.562 1.219 1.255 1.219.693 0 1.255-.546 1.255-1.219 0-.672-.562-1.218-1.255-1.218-.693 0-1.255.546-1.255 1.218Zm-1.673-.407a.824.824 0 0 1-.836-.81c0-.449.374-.812.836-.812.461 0 .835.363.835.811a.824.824 0 0 1-.835.811Zm1.674-3.247c0 .448.374.811.835.811a.824.824 0 0 0 .836-.811.824.824 0 0 0-.836-.812.824.824 0 0 0-.835.812Z"></path>
									</svg>
								</button>
							</div>
							<?php endif; endforeach; ?>
			</div>
		</div>
	</div>
</div>
<?php if (!empty($_GET['log'])) : ?>
	<div class="col-md-9">
		<div class="card">
			<div class="card-header">
				<h5 class="badge"><?= $Translate->get_translate_module_phrase('module_page_pay', '_LogContent'); ?>
					<div class="copy_log" data-clipboard-text="<?= file_get_contents($logDir . $_GET['log']) ?>">
						<svg viewBox="0 0 512 512">
							<path d="M224 0c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224zM64 160c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H288v64H64V224h64V160H64z"></path>
						</svg>
						<?= $Translate->get_translate_module_phrase('module_page_adminpanel', '_Logs_copylog'); ?>
					</div>
				</h5>
			</div>
			<div class="card-container no-scrollbar" style="max-height: 48vh; overflow: hidden; overflow-y: scroll;">
				<div class="log_text">
					<?php if (file_exists($logDir . $_GET['log'])) : ?>
						<p class="code"><?= file_get_contents($logDir . $_GET['log']) ?></p>
					<?php else : echo 'Файл не найден.';
					endif; ?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>