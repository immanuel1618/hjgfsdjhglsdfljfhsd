<script>
	var info = <?= json_encode(array("name" => $Player->get_name(), "lastconnect" => $Player->get_lastconnect())) ?>;
	var faceit = <?= json_encode($Player->get_steam_64()) ?>;
</script>
<?php
function getColorClass($value) {
    if ($value > 30000) { return 'gold-rank'; }
    elseif ($value > 25000) { return 'red-rank'; }
    elseif ($value > 20000) { return 'pink-rank'; }
    elseif ($value > 15000) { return 'purple-rank'; }
    elseif ($value > 10000) { return 'blue-rank'; }
    elseif ($value > 5000) { return 'wblue-rank'; }
    else { return 'gray-rank'; }
}
$colorClass = getColorClass($Player->get_value());
?>
<div class="row">
	<div class="col-md-3">
		<select style="display: none;" class="custom-select" onchange="window.location.href=this.value" placeholder="<?php for ($b = 0, $_c = sizeof($Player->found); $b < $_c; $b++) {
																																																										if (!empty($Player->found_fix[$b])) {
																																																											if (($Player->found_fix[$b]['server_group']) == ($Player->found[$Player->server_group]['server_group'])) {
																																																												echo $Player->found_fix[$b]['name_servers'];
																																																											}
																																																										}
																																																									} ?>">
			<?php for ($b = 0, $_c = sizeof($Player->found); $b < $_c; $b++) {
				if (!empty($Player->found_fix[$b])) { ?>
					<option value="<?= $General->arr_general['site'] ?>profiles/<?= con_steam64($Player->get_steam_64()) ?>/<?= $Player->found_fix[$b]['server_group'] ?>"><?= $Player->found_fix[$b]['name_servers'] ?></option>
			<?php }
			} ?>
		</select>
		<div class="card">
			<div class="profile_user_card">
			<div class="user_back" <?php if ($back['video'] == 0 || !isset($back['video'])) : ?><?php empty($back['url']) ? '' : print print 'style="background: url(' . $General->arr_general['site'] . $back['url'] . ') no-repeat center; background-size: cover;"' ?><?php endif; ?>>
					<?php if ($back['video'] == 1) : ?>
						<video playsinline="" autoplay="" muted="" loop="">
							<source src="<?php echo $General->arr_general['site'] . $back['url'] ?>" type="video/webm">
						</video>
					<?php endif; ?>
					<div class="header_user_info">
						<?php if (isset($_SESSION["steamid64"]) && ($Player->get_steam_64() == $_SESSION['steamid64'])) : ?>
							<a class="user_settings" href="<?= $General->arr_general['site'] . 'profiles/' . $profile . '/settings/' . $server_page ?>/" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_profiles', '_Settings'); ?>" data-tippy-placement="left">
								<svg x="0" y="0" viewBox="0 0 512 512" xml:space="preserve">
									<g>
										<path d="m496.659 312.107-47.061-36.8c.597-5.675 1.109-12.309 1.109-19.328s-.491-13.653-1.109-19.328l47.104-36.821c8.747-6.912 11.136-19.179 5.568-29.397L453.331 85.76c-5.227-9.557-16.683-14.464-28.309-10.176l-55.531 22.293c-10.645-7.68-21.803-14.165-33.344-19.349l-8.448-58.901C326.312 8.448 316.584 0 305.086 0h-98.133c-11.499 0-21.205 8.448-22.571 19.456l-8.469 59.115c-11.179 5.035-22.165 11.435-33.28 19.349l-55.68-22.357c-10.433-4.032-22.913.49-28.097 10.005L9.854 170.347c-5.781 9.771-3.392 22.464 5.547 29.547l47.061 36.8c-.747 7.189-1.109 13.44-1.109 19.307s.363 12.117 1.109 19.328L15.358 312.15c-8.747 6.933-11.115 19.2-5.547 29.397l48.939 84.672c5.227 9.536 16.576 14.485 28.309 10.176l55.531-22.293c10.624 7.659 21.781 14.144 33.323 19.349l8.448 58.88C185.747 503.552 195.454 512 206.974 512h98.133c11.499 0 21.227-8.448 22.592-19.456l8.469-59.093c11.179-5.056 22.144-11.435 33.28-19.371l55.68 22.357a22.924 22.924 0 0 0 8.363 1.579c8.277 0 15.893-4.523 19.733-11.563l49.152-85.12c5.462-9.984 3.072-22.25-5.717-29.226zm-240.64 29.226c-47.061 0-85.333-38.272-85.333-85.333s38.272-85.333 85.333-85.333 85.333 38.272 85.333 85.333-38.272 85.333-85.333 85.333z"></path>
									</g>
								</svg>
							</a>
						<?php endif; ?>
						<div class="user_socials">
						<a class="social_button" id="faceit_url" href="" target="_blank" style="display: none;">
								<svg viewBox="0 0 24 24">
									<path fill="#FA5E00" d="M24 2.213c0-.1-.1-.2-.1-.2-.1 0-.1 0-.2.1-1.999 3.096-4.098 6.191-6.098 9.387H.209c-.2 0-.3.3-.1.399 7.197 2.696 17.693 6.79 23.491 9.087.2.1.4-.1.4-.2V2.213z"></path>
								</svg>
							</a>
							<a class="social_button" href="//steamcommunity.com/profiles/<?= $Player->get_steam_64() ?>/" target="_blank">
								<svg viewBox="0 0 65 65" fill="#fff">
									<use xlink:href="#B" x=".5" y=".5" />
									<defs>
										<linearGradient id="A" x2="50%" x1="50%" y2="100%" y1="0%">
											<stop stop-color="#111d2e" offset="0%" />
											<stop stop-color="#051839" offset="21.2%" />
											<stop stop-color="#0a1b48" offset="40.7%" />
											<stop stop-color="#132e62" offset="58.1%" />
											<stop stop-color="#144b7e" offset="73.8%" />
											<stop stop-color="#136497" offset="87.3%" />
											<stop stop-color="#1387b8" offset="100%" />
										</linearGradient>
									</defs>
									<symbol id="B">
										<g>
											<path d="M1.305 41.202C5.259 54.386 17.488 64 31.959 64c17.673 0 32-14.327 32-32s-14.327-32-32-32C15.001 0 1.124 13.193.028 29.874c2.074 3.477 2.879 5.628 1.275 11.328z" fill="url(#A)" />
											<path d="M30.31 23.985l.003.158-7.83 11.375c-1.268-.058-2.54.165-3.748.662a8.14 8.14 0 0 0-1.498.8L.042 29.893s-.398 6.546 1.26 11.424l12.156 5.016c.6 2.728 2.48 5.12 5.242 6.27a8.88 8.88 0 0 0 11.603-4.782 8.89 8.89 0 0 0 .684-3.656L42.18 36.16l.275.005c6.705 0 12.155-5.466 12.155-12.18s-5.44-12.16-12.155-12.174c-6.702 0-12.155 5.46-12.155 12.174zm-1.88 23.05c-1.454 3.5-5.466 5.147-8.953 3.694a6.84 6.84 0 0 1-3.524-3.362l3.957 1.64a5.04 5.04 0 0 0 6.591-2.719 5.05 5.05 0 0 0-2.715-6.601l-4.1-1.695c1.578-.6 3.372-.62 5.05.077 1.7.703 3 2.027 3.696 3.72s.692 3.56-.01 5.246M42.466 32.1a8.12 8.12 0 0 1-8.098-8.113 8.12 8.12 0 0 1 8.098-8.111 8.12 8.12 0 0 1 8.1 8.111 8.12 8.12 0 0 1-8.1 8.113m-6.068-8.126a6.09 6.09 0 0 1 6.08-6.095c3.355 0 6.084 2.73 6.084 6.095a6.09 6.09 0 0 1-6.084 6.093 6.09 6.09 0 0 1-6.081-6.093z" />
										</g>
									</symbol>
								</svg>
							</a>
							<?php if (!empty($Info['vk'])) : ?>
								<a class="social_button" href="//vk.com/<?= action_text_clear($Info['vk']) ?>" target="_blank">
									<svg viewBox="0 0 48 48" fill="none">
										<path d="M0 23.04C0 12.1788 0 6.74826 3.37413 3.37413C6.74826 0 12.1788 0 23.04 0H24.96C35.8212 0 41.2517 0 44.6259 3.37413C48 6.74826 48 12.1788 48 23.04V24.96C48 35.8212 48 41.2517 44.6259 44.6259C41.2517 48 35.8212 48 24.96 48H23.04C12.1788 48 6.74826 48 3.37413 44.6259C0 41.2517 0 35.8212 0 24.96V23.04Z" fill="#0077FF" />
										<path d="M25.54 34.5801C14.6 34.5801 8.3601 27.0801 8.1001 14.6001H13.5801C13.7601 23.7601 17.8 27.6401 21 28.4401V14.6001H26.1602V22.5001C29.3202 22.1601 32.6398 18.5601 33.7598 14.6001H38.9199C38.0599 19.4801 34.4599 23.0801 31.8999 24.5601C34.4599 25.7601 38.5601 28.9001 40.1201 34.5801H34.4399C33.2199 30.7801 30.1802 27.8401 26.1602 27.4401V34.5801H25.54Z" fill="white" />
									</svg>
								</a>
							<?php endif; ?>
							<?php if (!empty($Info['tg'])) : ?>
								<a class="social_button" href="//t.me/<?= action_text_clear($Info['tg']) ?>" target="_blank">
									<svg viewBox="0 0 240.1 240.1">
										<linearGradient id="Oval_1_" gradientUnits="userSpaceOnUse" x1="-838.041" y1="660.581" x2="-838.041" y2="660.3427" gradientTransform="matrix(1000 0 0 -1000 838161 660581)">
											<stop offset="0" style="stop-color:#2AABEE" />
											<stop offset="1" style="stop-color:#229ED9" />
										</linearGradient>
										<circle fill-rule="evenodd" clip-rule="evenodd" fill="url(#Oval_1_)" cx="120.1" cy="120.1" r="120.1" />
										<path fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M54.3,118.8c35-15.2,58.3-25.3,70-30.2 c33.3-13.9,40.3-16.3,44.8-16.4c1,0,3.2,0.2,4.7,1.4c1.2,1,1.5,2.3,1.7,3.3s0.4,3.1,0.2,4.7c-1.8,19-9.6,65.1-13.6,86.3 c-1.7,9-5,12-8.2,12.3c-7,0.6-12.3-4.6-19-9c-10.6-6.9-16.5-11.2-26.8-18c-11.9-7.8-4.2-12.1,2.6-19.1c1.8-1.8,32.5-29.8,33.1-32.3 c0.1-0.3,0.1-1.5-0.6-2.1c-0.7-0.6-1.7-0.4-2.5-0.2c-1.1,0.2-17.9,11.4-50.6,33.5c-4.8,3.3-9.1,4.9-13,4.8 c-4.3-0.1-12.5-2.4-18.7-4.4c-7.5-2.4-13.5-3.7-13-7.9C45.7,123.3,48.7,121.1,54.3,118.8z" />
									</svg>
								</a>
							<?php endif; ?>
							<?php if (!empty($Info['twitch'])) : ?>
								<a class="social_button" href="//twitch.com/<?= action_text_clear($Info['twitch']) ?>" target="_blank">
									<svg id="Layer_1" x="0px" y="0px" viewBox="0 0 2400 2800" xml:space="preserve">
										<g>
											<polygon fill="#fff" points="2200,1300 1800,1700 1400,1700 1050,2050 1050,1700 600,1700 600,200 2200,200" />
											<g>
												<g id="Layer_1-2">
													<path fill="#9146FF" d="M500,0L0,500v1800h600v500l500-500h400l900-900V0H500z M2200,1300l-400,400h-400l-350,350v-350H600V200h1600
													V1300z" />
													<rect x="1700" y="550" fill="#9146FF" width="200" height="600" />
													<rect x="1150" y="550" fill="#9146FF" width="200" height="600" />
												</g>
											</g>
										</g>
									</svg>
								</a>
							<?php endif; ?>
							<?php if (!empty($Info['discord'])) : ?>
								<div data-clipboard-text="<?= htmlspecialchars($Info['discord']) ?>" class="social_button_dsicord copybtn">
									<svg viewBox="0 0 1024 1024" fill="#000000">
										<g id="SVGRepo_bgCarrier" stroke-width="0"></g>
										<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
										<g id="SVGRepo_iconCarrier">
											<circle cx="512" cy="512" r="512" style="fill:#5865f2"></circle>
											<path d="M689.43 349a422.21 422.21 0 0 0-104.22-32.32 1.58 1.58 0 0 0-1.68.79 294.11 294.11 0 0 0-13 26.66 389.78 389.78 0 0 0-117.05 0 269.75 269.75 0 0 0-13.18-26.66 1.64 1.64 0 0 0-1.68-.79A421 421 0 0 0 334.44 349a1.49 1.49 0 0 0-.69.59c-66.37 99.17-84.55 195.9-75.63 291.41a1.76 1.76 0 0 0 .67 1.2 424.58 424.58 0 0 0 127.85 64.63 1.66 1.66 0 0 0 1.8-.59 303.45 303.45 0 0 0 26.15-42.54 1.62 1.62 0 0 0-.89-2.25 279.6 279.6 0 0 1-39.94-19 1.64 1.64 0 0 1-.16-2.72c2.68-2 5.37-4.1 7.93-6.22a1.58 1.58 0 0 1 1.65-.22c83.79 38.26 174.51 38.26 257.31 0a1.58 1.58 0 0 1 1.68.2c2.56 2.11 5.25 4.23 8 6.24a1.64 1.64 0 0 1-.14 2.72 262.37 262.37 0 0 1-40 19 1.63 1.63 0 0 0-.87 2.28 340.72 340.72 0 0 0 26.13 42.52 1.62 1.62 0 0 0 1.8.61 423.17 423.17 0 0 0 128-64.63 1.64 1.64 0 0 0 .67-1.18c10.68-110.44-17.88-206.38-75.7-291.42a1.3 1.3 0 0 0-.63-.63zM427.09 582.85c-25.23 0-46-23.16-46-51.6s20.38-51.6 46-51.6c25.83 0 46.42 23.36 46 51.6.02 28.44-20.37 51.6-46 51.6zm170.13 0c-25.23 0-46-23.16-46-51.6s20.38-51.6 46-51.6c25.83 0 46.42 23.36 46 51.6.01 28.44-20.17 51.6-46 51.6z" style="fill:#fff"></path>
										</g>
									</svg>
								</div>
							<?php endif; ?>
						</div>
						<?php $General->get_js_relevance_avatar($Player->get_steam_64()) ?>
						<img class="avatar_frame" src="<?= $General->getFrame($Player->get_steam_64())  ?>" id="frame" frameid="<?= $Player->get_steam_64() ?>" alt="">
						<img src="<?= $General->getAvatar($Player->get_steam_64(), 3) ?>" id="avatar" avatarid="<?= $Player->get_steam_64() ?>" alt="" title="">
						<div class="online_pos">
							<div class="user_online_status" style="<?php if ($General->user_online($Player->get_steam_64()) == 1) {
																												echo 'display: block;';
																											} ?>"></div>
						</div>
					</div>
				</div>
				<div class="user_sec_block">
					<?php if (isset($_SESSION["steamid64"]) && ($_SESSION["user_admin"] || ($Player->get_steam_64() == $_SESSION['steamid64']))) : ?>
						<div onclick="location.href='<?= $General->arr_general['site'] ?>pay/'" class="user_balance" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_profiles', '_balance'); ?>" data-tippy-placement="bottom">
							<div class="balance_info">
								<span class="balance_count">
									<?php if (!empty($Player->Db->db_data['lk'])) : ?>
										<?= $Player->get_balance() . ' ' . $Translate->get_translate_module_phrase('module_page_pay', '_AmountCourse'); ?>
									<?php endif; ?>
								</span>
							</div>
							<svg viewBox="0 0 512 512">
								<path d="M232 344V280H168C154.7 280 144 269.3 144 256C144 242.7 154.7 232 168 232H232V168C232 154.7 242.7 144 256 144C269.3 144 280 154.7 280 168V232H344C357.3 232 368 242.7 368 256C368 269.3 357.3 280 344 280H280V344C280 357.3 269.3 368 256 368C242.7 368 232 357.3 232 344zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"></path>
							</svg>
						</div>
					<?php endif; ?>
					<div class="<?= $colorClass ?>"><?= number_format($Player->get_value()) ?></div>
				</div>
				<div class="user_third_block">
					<div>
						<div class="user_nickname copybtn2" data-clipboard-text="<?= $Player->get_steam_64() ?>" viewBox="0 0 512 512" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_profiles', '_steamID64'); ?>" data-tippy-placement="right">
							<?= empty($General->checkName($Player->get_steam_64())) ? action_text_clear($Player->get_name()) : action_text_clear($General->checkName($Player->get_steam_64())) ?>
							<svg viewBox="0 0 496 512">
								<path d="M224 0c-35.3 0-64 28.7-64 64V288c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V64c0-35.3-28.7-64-64-64H224zM64 160c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H288c35.3 0 64-28.7 64-64V384H288v64H64V224h64V160H64z"></path>
							</svg>
						</div>
						<a id="connect_link"><span class="user_status_server" id="online_status"><?= $Player->get_lastconnect() ?></span></a>
					</div>
					<hr>
					<div class="user_status">
						<span class="status_title"><?= $Translate->get_translate_module_phrase('module_page_profiles', '_User_status'); ?></span>
						<span class="status_content"><?php if (empty($Info['status'])) {
																						echo $Translate->get_translate_module_phrase('module_page_profiles', '_Not_specified');
																					} else {
																						echo action_text_clear($Info['status']);
																					} ?></span>
					</div>
					<hr>
					<div class="user_roles">
						<?php if (empty($Player->get_db_Vips()) && (empty($Admins))) : ?>
							<div class="user_badge badge_player">
								<span class="badge_player_circle"></span>
								<?= $Translate->get_translate_module_phrase('module_page_profiles', '_player'); ?>
							</div>
						<?php endif; ?>
						<?php if (!empty($Admins)) : ?>
							<div class="user_badge badge_admin">
								<span class="badge_admin_circle"></span>
								<?php if (!empty($Db->db_data['IksAdmin']) || !empty($Db->db_data['AdminSystem'])) {
									$groupFound = false;
									foreach ($Groups as $key) {
										if ($Admins['group_id'] == -1) {
											echo $Translate->get_translate_module_phrase('module_page_profiles', '_No_Group');
											$groupFound = true;
											break;
										} else {
											if ($Admins['group_id'] == $key['id']) {
												echo $key['name'];
												$groupFound = true;
												break;
											}
										}
									}
									if (!$groupFound) {
										echo $Translate->get_translate_module_phrase('module_page_profiles', '_No_Group');
									}
								} ?>
							</div>
						<?php endif; ?>
						<?php if ($Player->get_db_Vips()) : ?>
							<div class="user_badge badge_vip">
								<span class="badge_vip_circle"></span>
								<?= $Vips['group'] ?>
							</div>
						<?php endif; ?>
						<?php if ($Player->get_top_position() < 4) : ?>
							<div class="user_badge <?= 'badge_top-' . $Player->get_top_position(); ?>">
								<span class="<?= 'badge_top_circle-' . $Player->get_top_position(); ?>"></span>
								TOP <?= $Player->get_top_position() ?>
							</div>
						<?php endif; ?>
						<?php if (!empty($Player->Db->db_data['AdminSystem'])) :
							$ban_check = $Db->query('AdminSystem', $Db->db_data['AdminSystem'][0]['USER_ID'], $Db->db_data['AdminSystem'][0]['DB_num'], "SELECT `created`, `steamid`, `expires`, `unpunish_admin_id` FROM `as_punishments` WHERE `steamid` = '" . $Player->get_steam_64() . "' AND (server_id = '".$Player->lws['server_sb_id']."' OR server_id = '-1') AND `punish_type` = 0 order by `created` desc limit 1");
							!empty($ban_check) && (empty($ban_check['unpunish_admin_id']) && (($ban_check['expires']) == 0 || $ban_check['expires'] >= time())) && (print '<div class="user_badge badge_banned"><span class="badge_banned_circle"></span>Забанен</div>');
						endif; ?>
					</div>
					<hr>
					<div class="user_menu_short">
						<a class="<?php if ($page == 'info') : ?>a_active<?php endif; ?>" href="<?= $General->arr_general['site'] . 'profiles/' . $profile . '/info/' . $server_page ?>/" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_profiles', '_Info'); ?>" data-tippy-placement="top">
							<svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve" fill-rule="evenodd" class="">
								<g>
									<circle cx="11.5" cy="6.744" r="5.5"></circle>
									<path d="M12.925 21.756A6.226 6.226 0 0 1 11.25 17.5c0-1.683.667-3.212 1.751-4.336-.49-.038-.991-.058-1.501-.058-3.322 0-6.263.831-8.089 2.076-1.393.95-2.161 2.157-2.161 3.424v1.45a1.697 1.697 0 0 0 1.7 1.7z"></path>
									<path d="M17.5 12.25c-2.898 0-5.25 2.352-5.25 5.25s2.352 5.25 5.25 5.25 5.25-2.352 5.25-5.25-2.352-5.25-5.25-5.25zm-.75 5.25V20a.75.75 0 0 0 1.5 0v-2.5a.75.75 0 0 0-1.5 0zm.75-3.25a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path>
								</g>
							</svg>
							<?php if (!empty($Admins)) : ?>
								<a class="<?php if ($page == 'admin') : ?>a_active<?php endif; ?>" href="<?= $General->arr_general['site'] . 'profiles/' . $profile . '/admin/' . $server_page ?>/" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_profiles', '_Admin'); ?>" data-tippy-placement="top">
									<svg x="0" y="0" viewBox="0 0 512 512" xml:space="preserve" class="">
										<g>
											<path d="M456.606 79.347 381.653 4.394A15 15 0 0 0 371.047 0H140.953a15 15 0 0 0-10.606 4.394L55.394 79.347A15 15 0 0 0 51 89.953v209.226c0 25.993 6.609 51.777 19.113 74.564 12.504 22.788 30.702 42.212 52.626 56.175l125.203 79.734C250.4 511.217 253.2 512 256 512s5.6-.783 8.058-2.348l125.202-79.734c21.925-13.962 40.123-33.387 52.627-56.175C454.391 350.956 461 325.171 461 299.179V89.953a15 15 0 0 0-4.394-10.606zm-89.569 136.039-41.347 44.926 7.013 60.619a15 15 0 0 1-21.137 15.366L256 310.893l-55.566 25.404a15 15 0 0 1-21.137-15.366l7.013-60.619-41.347-44.926a15 15 0 0 1 8.074-24.862l59.899-12.073 30.001-53.168a15 15 0 0 1 26.128 0l30.001 53.168 59.899 12.073a14.998 14.998 0 0 1 8.072 24.862z"></path>
										</g>
									</svg>
								</a>
							<?php endif; ?>
							<!-- <a class="<?php if ($page == 'stats') : ?>a_active<?php endif; ?>" href="<?= $General->arr_general['site'] . 'profiles/' . $profile . '/stats/' . $server_page ?>/" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_profiles', '_Stats'); ?>" data-tippy-placement="top">
								<svg x="0" y="0" viewBox="0 0 512 512" xml:space="preserve" class="">
									<g>
										<path fill-rule="evenodd" d="m91.777 177.338 67.421-60.798a39.093 39.093 0 0 1-4.371-18.017c0-21.683 17.578-39.261 39.261-39.261s39.261 17.578 39.261 39.261a39.4 39.4 0 0 1-.857 8.183l55.999 28.22c7.193-8.135 17.707-13.266 29.42-13.266a39.07 39.07 0 0 1 21.513 6.417l67.421-60.798a39.093 39.093 0 0 1-4.371-18.017c0-21.683 17.578-39.261 39.261-39.261 21.684 0 39.261 17.578 39.261 39.261s-17.578 39.261-39.261 39.261a39.078 39.078 0 0 1-21.513-6.416l-67.421 60.797a39.081 39.081 0 0 1 4.371 18.018c0 21.683-17.578 39.261-39.261 39.261s-39.261-17.578-39.261-39.261c0-2.807.297-5.544.857-8.183l-55.999-28.22c-7.193 8.135-17.707 13.266-29.42 13.266a39.078 39.078 0 0 1-21.513-6.416l-67.421 60.798a39.08 39.08 0 0 1 4.371 18.017c0 21.683-17.578 39.261-39.261 39.261-21.684 0-39.261-17.578-39.261-39.261s17.578-39.261 39.261-39.261a39.061 39.061 0 0 1 21.513 6.415zm11.272 136.188h-65.57c-5.508 0-10 4.492-10 10V492c0 5.508 4.492 10 10 10h65.57c5.508 0 10-4.492 10-10V323.526c0-5.508-4.492-10-10-10zm371.472-161.018h-65.57c-5.508 0-10 4.492-10 10V492c0 5.508 4.492 10 10 10h65.57c5.508 0 10-4.492 10-10V162.508c0-5.508-4.492-10-10-10zM350.697 267.096h-65.57c-5.508 0-10 4.492-10 10V492c0 5.508 4.492 10 10 10h65.57c5.508 0 10-4.492 10-10V277.095c0-5.507-4.492-9.999-10-9.999zm-123.823-52.123h-65.57c-5.508 0-10 4.492-10 10V492c0 5.508 4.492 10 10 10h65.57c5.508 0 10-4.492 10-10V224.972c-.001-5.508-4.493-9.999-10-9.999z"></path>
									</g>
								</svg>
							</a> -->
							<a class="<?php if ($page == 'block') : ?>a_active<?php endif; ?>" href="<?= $General->arr_general['site'] . 'profiles/' . $profile . '/block/' . $server_page ?>/" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_profiles', '_Block'); ?>" data-tippy-placement="top">
								<svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve" class="">
									<g>
										<path d="M19.75 15.426v-.435a2.747 2.747 0 0 0-2.76-2.74 2.743 2.743 0 0 0-2.74 2.74v.435c-.589.282-1 .879-1 1.574v3c0 .965.785 1.75 1.75 1.75h4c.965 0 1.75-.785 1.75-1.75v-3c0-.695-.411-1.292-1-1.574zM17.5 19a.5.5 0 0 1-1 0v-1a.5.5 0 0 1 1 0zm.75-3.75h-2.5v-.26c0-.684.556-1.24 1.26-1.24.684 0 1.24.557 1.24 1.24zm-5.49-.6c.18-2.18 2.01-3.9 4.23-3.9.26 0 .51.02.76.07V5c0-1.52-1.23-2.75-2.75-2.75H6C4.48 2.25 3.25 3.48 3.25 5v13c0 1.52 1.23 2.75 2.75 2.75h5.84c-.06-.24-.09-.49-.09-.75v-3c0-.89.38-1.74 1.01-2.35zM7 5.25h7a.75.75 0 0 1 0 1.5H7a.75.75 0 0 1 0-1.5zm3 7.5H7a.75.75 0 0 1 0-1.5h3a.75.75 0 0 1 0 1.5zm-3-3a.75.75 0 0 1 0-1.5h7a.75.75 0 0 1 0 1.5z"></path>
									</g>
								</svg>
							</a>
							<a class="<?php if ($page == 'friends') : ?>a_active<?php endif; ?>" href="<?= $General->arr_general['site'] . 'profiles/' . $profile . '/friends/' . $server_page ?>/" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_profiles', '_Friends'); ?>" data-tippy-placement="top">
								<svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve" class="">
									<g>
										<g data-name="Layer 2">
											<circle cx="8" cy="7" r="4.75"></circle>
											<path d="M22.75 18A2.748 2.748 0 0 1 20 20.75h-5.46A3.692 3.692 0 0 0 15.75 18a6.668 6.668 0 0 0-1.62-4.37 4.842 4.842 0 0 1 1.87-.38h2A4.754 4.754 0 0 1 22.75 18z"></path>
											<path d="M9 12.25H7A5.757 5.757 0 0 0 1.25 18 2.752 2.752 0 0 0 4 20.75h8A2.752 2.752 0 0 0 14.75 18 5.757 5.757 0 0 0 9 12.25zM20.75 9a3.746 3.746 0 0 1-7.48.3 5.539 5.539 0 0 0 .47-2.16A3.752 3.752 0 0 1 20.75 9z"></path>
										</g>
									</g>
								</svg>
							</a>
							<?php if (isset($_SESSION["steamid"]) && (($Player->get_steam_32() == $_SESSION['steamid32']) || isset($_SESSION['user_admin']))) : ?>
								<a class="<?php if ($page == 'transaction') : ?>a_active<?php endif; ?>" href="<?= $General->arr_general['site'] . 'profiles/' . $profile . '/transaction/' . $server_page ?>/" data-tippy-content="<?= $Translate->get_translate_module_phrase('module_page_profiles', '_Transaction'); ?>" data-tippy-placement="top">
									<svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve" class="">
										<g>
											<path d="M19.5 3.67c0-.01 0-.02-.02-.03-.22-.28-.51-.43-.85-.43-.53 0-1.17.35-1.86 1.09-.82.88-2.08.81-2.8-.15l-1.01-1.34c-.4-.54-.93-.81-1.46-.81s-1.06.27-1.46.81L9.02 4.16c-.71.95-1.96 1.02-2.78.15l-.01-.01C5.1 3.09 4.09 2.91 3.52 3.64c-.02.01-.02.02-.02.03-.36.77-.5 1.85-.5 3.37v9.92c0 1.52.14 2.6.5 3.37 0 .01.01.03.02.04.58.72 1.58.54 2.71-.67l.01-.01c.82-.87 2.07-.8 2.78.15l1.02 1.35c.4.54.93.81 1.46.81s1.06-.27 1.46-.81l1.01-1.34c.72-.96 1.98-1.03 2.8-.15.69.74 1.33 1.09 1.86 1.09.34 0 .63-.14.85-.42.01-.01.02-.03.02-.04.36-.77.5-1.85.5-3.37V7.04c0-1.52-.14-2.6-.5-3.37zM14 14.5H8c-.41 0-.75-.34-.75-.75S7.59 13 8 13h6c.41 0 .75.34.75.75s-.34.75-.75.75zm2-3.5H8c-.41 0-.75-.34-.75-.75s.34-.75.75-.75h8c.41 0 .75.34.75.75s-.34.75-.75.75z"></path>
										</g>
									</svg>
								</a>
							<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php require_once MODULES . 'module_page_profiles/includes/' . $page . '.php'; ?>
</div>