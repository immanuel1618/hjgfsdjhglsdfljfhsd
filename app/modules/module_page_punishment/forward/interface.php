<div class="row">
	<div class="col-md-12">
		<div class="punish_header_page">
			<select style="display: none" class="custom-select" onchange="window.location.href=this.value" placeholder="<?php if ($Punishment->GetSettings()['punishment_all_servers'] == 0) { $serverFound = false; for ($b = 0, $_c = sizeof($Punishment->GetServerLR()); $b < $_c; $b++) { if ($Punishment->GetServerLR()[$b]['name'] == $Punishment->GetServerLR()[$server_id]['name']) { echo $Punishment->GetServerLR()[$b]['name']; $serverFound = true; } } if ($server_id == 'all' && !$serverFound) { echo $Translate->get_translate_module_phrase('module_page_punishment', '_AllServers'); } } else { echo $Translate->get_translate_module_phrase('module_page_punishment', '_AllServers'); } ?>">
				<option value="<?= $General->arr_general['site'] ?>punishment/all/"><?= $Translate->get_translate_module_phrase('module_page_punishment', '_AllServers'); ?></option>
				<?php if ($Punishment->GetSettings()['punishment_all_servers'] == 0) : for ($b = 0, $_c = sizeof($Punishment->GetServerLR()); $b < $_c; $b++) : ?>
					<option value="<?= $General->arr_general['site'] ?>punishment/<?= $b ?>"><?= $Punishment->GetServerLR()[$b]['name'] ?></option>
				<?php endfor; endif; ?>
			</select>
			<div class="punish_right_head">
				<div class="segmented-control">
					<span class="selection"></span>
					<div class="option">
						<input type="radio" id="bans" name="sample" value="bans" checked>
						<label for="bans"><span><?= $Translate->get_translate_module_phrase('module_page_punishment', '_Bans'); ?></span></label>
					</div>
					<div class="option">
						<input type="radio" id="comms" name="sample" value="comms">
						<label for="comms"><span><?= $Translate->get_translate_module_phrase('module_page_punishment', '_Comms'); ?></span></label>
					</div>
				</div>
				<div id="search"></div>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="card">
			<div class="card-header">
				<div class="badge"><?= $Translate->get_translate_module_phrase('module_page_punishment', '_Info'); ?></div>
			</div>
			<div class="card-container">
				<div class="punish_state">
					<span class="punish_title"><?= $Translate->get_translate_module_phrase('module_page_punishment', '_StatusAcc'); ?></span>
					<?php if (empty($_SESSION['steamid64'])) : ?>
						<div class="not_auth_user">
							<?= $Translate->get_translate_module_phrase('module_page_punishment', '_DataNotAuth'); ?>
						</div>
					<?php else : ?>
						<?php if (empty($Punishment->GetInfoCount()['my_count_bans']) && empty($Punishment->GetInfoCount()['my_count_mutes'])) : ?> 
							<div class="no_user_punish">
								<span><?= $Translate->get_translate_module_phrase('module_page_punishment', '_NoGameBlocks'); ?></span>
								<svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve">
									<g>
										<path fill-rule="evenodd" d="m11.525 1.057-7 1.711A2 2 0 0 0 3 4.711v8.502a8.811 8.811 0 0 0 4.941 7.916l3.62 1.77a1 1 0 0 0 .878 0l3.62-1.77A8.811 8.811 0 0 0 21 13.213V4.711a2 2 0 0 0-1.525-1.943l-7-1.71a2 2 0 0 0-.95 0zm5.182 8.65a1 1 0 0 0-1.414-1.414L11 12.586l-2.293-2.293a1 1 0 1 0-1.414 1.414l3 3a1 1 0 0 0 1.414 0z" clip-rule="evenodd" opacity="1"></path>
									</g>
								</svg>
							</div>
						<?php endif; ?>
						<?php if (!empty($Punishment->GetInfoCount()['my_count_bans'])) : ?>
							<div class="have_ban_user_punish">
								<span><?= $Translate->get_translate_module_phrase('module_page_punishment', '_GameBlocks'); ?> <?= $Punishment->GetInfoCount()['my_count_bans'] ?></span>
								<svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve">
									<g>
										<path d="M6 7.5a5.25 5.25 0 1 1 5.25 5.25A5.26 5.26 0 0 1 6 7.5zM21.92 17a4.68 4.68 0 0 1-1.47 3.42h-.05a4.7 4.7 0 0 1-3.22 1.28 4.73 4.73 0 0 1-3.51-7.92s0-.07.07-.1a4.7 4.7 0 0 1 3.4-1.46A4.75 4.75 0 0 1 21.92 17zm-3.16 2.82-4.41-4.4a3.22 3.22 0 0 0 2.82 4.83 3.18 3.18 0 0 0 1.59-.43zM20.42 17a3.25 3.25 0 0 0-5.06-2.7l4.51 4.51a3.22 3.22 0 0 0 .55-1.81zm-8.37-3.48a.71.71 0 0 0-.57-.27H8.87a6.92 6.92 0 0 0-6.62 5 2.76 2.76 0 0 0 2.65 3.5h7.22a.76.76 0 0 0 .56-.24 1.3 1.3 0 0 0 .1-.15 6.22 6.22 0 0 1-.73-7.84z"></path>
									</g>
								</svg>
							</div>
						<?php endif; if (!empty($Punishment->GetInfoCount()['my_count_mutes'])) : ?>
							<div class="have_comm_user_punish">
								<span><?= $Translate->get_translate_module_phrase('module_page_punishment', '_CommunicateBlocks'); ?> <?= $Punishment->GetInfoCount()['my_count_mutes'] ?></span>
								<svg x="0" y="0" viewBox="0 0 100 100" xml:space="preserve" fill-rule="evenodd">
									<g>
										<path d="m19.665 18.164 56.25 56.25a3.126 3.126 0 0 0 4.42 0 3.127 3.127 0 0 0 0-4.419l-56.25-56.25a3.126 3.126 0 0 0-4.42 0 3.127 3.127 0 0 0 0 4.419zM52.635 87.5v-6.395a33.153 33.153 0 0 0 18.212-7.596l-4.441-4.44A26.932 26.932 0 0 1 49.51 75c-14.931 0-27.053-12.122-27.053-27.053a3.126 3.126 0 0 0-6.25 0c0 17.327 13.261 31.582 30.178 33.158V87.5H35.447a3.126 3.126 0 0 0 0 6.25h28.125a3.126 3.126 0 0 0 0-6.25zm21.4-28.127 4.645 4.645a33.13 33.13 0 0 0 4.133-16.071 3.126 3.126 0 0 0-6.25 0 26.94 26.94 0 0 1-2.528 11.426z"></path>
										<path d="M28.117 30.78v18.64c0 12.073 9.802 21.875 21.875 21.875a21.785 21.785 0 0 0 13.764-4.877zm3.23-14.094 39.464 39.463a21.828 21.828 0 0 0 1.056-6.729V28.125c0-12.073-9.802-21.875-21.875-21.875-7.881 0-14.795 4.177-18.645 10.436z"></path>
									</g>
								</svg>
							</div>
						<?php endif; ?>
					<?php endif; if (empty($_SESSION['steamid64'])) : ?>
						<button class="secondary_btn w100" onclick="location.href='?auth=login'"><?= $Translate->get_translate_module_phrase('module_page_punishment', '_Authorize'); ?></button>
					<?php endif; ?>
					<hr>
					<div class="punish_stats_head">
						<span class="punish_title"><?= $Translate->get_translate_module_phrase('module_page_punishment', '_PunishStats'); ?></span>
						<button class="hide_stats"><?= $Translate->get_translate_module_phrase('module_page_punishment', '_Hide'); ?></button>
						<button class="show_stats"><?= $Translate->get_translate_module_phrase('module_page_punishment', '_Show'); ?></button>
					</div>
					<div class="punish_stats_list">
						<div class="punish_string"><span class="stats_title"><?= $Translate->get_translate_module_phrase('module_page_punishment', '_TotalBans'); ?></span><span class="stats_count"><?= $Punishment->GetInfoCount()['count_bans'] ?></span></div>
						<div class="punish_string"><span class="stats_title"><?= $Translate->get_translate_module_phrase('module_page_punishment', '_ActiveBans'); ?></span><span class="stats_count"><?= $Punishment->GetInfoCount()['count_bans_activ'] ?></span></div>
						<div class="punish_string"><span class="stats_title"><?= $Translate->get_translate_module_phrase('module_page_punishment', '_PermanentBans'); ?></span><span class="stats_count"><?= $Punishment->GetInfoCount()['count_bans_perm'] ?></span></div>
						<div class="punish_string"><span class="stats_title"><?= $Translate->get_translate_module_phrase('module_page_punishment', '_TotalComms'); ?></span><span class="stats_count"><?= $Punishment->GetInfoCount()['count_mutes'] ?></span></div>
						<div class="punish_string"><span class="stats_title"><?= $Translate->get_translate_module_phrase('module_page_punishment', '_TotalGags'); ?></span><span class="stats_count"><?= $Punishment->GetInfoCount()['count_gags'] ?></span></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-9">
		<div class="card">
			<div class="card-header">
				<div class="badge"><?= $Translate->get_translate_module_phrase('module_page_punishment', '_PunishmentList'); ?></div>
			</div>
			<div class="card-container">
				<div class="modern_table">
					<div class="punish_header">
						<li>
							<span><?= $Translate->get_translate_module_phrase('module_page_punishment', '_TypePunish'); ?></span>
							<span class="none_span">
								<svg viewBox="0 0 512 512">
									<path d="M105.4 67.08C118.2 44.81 141.1 31.08 167.7 31.08H344.3C370 31.08 393.8 44.81 406.6 67.08L494.9 219.1C507.8 242.3 507.8 269.7 494.9 291.1L406.6 444.9C393.8 467.2 370 480.9 344.3 480.9H167.7C141.1 480.9 118.2 467.2 105.4 444.9L17.07 291.1C4.206 269.7 4.206 242.3 17.07 219.1L105.4 67.08zM158.3 279.8L107.1 335.9L153.9 416.9C156.7 421.9 161.1 424.9 167.7 424.9H344.3C350 424.9 355.3 421.9 358.1 416.9L413.4 321.2L340.7 233.8C336.2 228.3 329.4 225.1 322.3 225.1C315.2 225.1 308.4 228.3 303.8 233.8L232.2 320L193.3 279.4C188.7 274.6 182.4 271.9 175.7 272C169.1 272.1 162.8 274.9 158.3 279.8V279.8zM192 199.1C214.1 199.1 232 182.1 232 159.1C232 137.9 214.1 119.1 192 119.1C169.9 119.1 152 137.9 152 159.1C152 182.1 169.9 199.1 192 199.1z"></path>
								</svg>
							</span>
							<span><?= $Translate->get_translate_module_phrase('module_page_punishment', '_Player'); ?></span>
							<span><?= $Translate->get_translate_module_phrase('module_page_punishment', '_Reason'); ?></span>
							<span class="none_span"><?= $Translate->get_translate_module_phrase('module_page_punishment', '_Term'); ?></span>
							<span class="none_span"><?= $Translate->get_translate_module_phrase('module_page_punishment', '_Admin'); ?></span>
						</li>
					</div>
					<div class="popup_modal" id="punishModal">
						<div class="popup_modal_content no-close no-scrollbar">
							<div class="popup_modal_head">
								<?= $Translate->get_translate_module_phrase('module_page_punishment', '_DetailsPunishment'); ?>
								<span class="popup_modal_close">
									<svg viewBox="0 0 320 512">
										<path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
									</svg>
								</span>
							</div>
							<hr>
						</div>
					</div>
					<div class="punish_content no-scrollbar" id="punishment_list_search"></div>
					<div class="punish_content no-scrollbar" id="punish_content"></div>
				</div>
			</div>
		</div>
	</div>
</div>