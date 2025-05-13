<?php if (isset($_SESSION["steamid64"]) && ($Player->get_steam_64() == $_SESSION['steamid64'])) : ?>
	<div class="col-md-9" style="overflow: hidden;height: 650px;">
		<div class="card">
			<div class="card-header">
				<div class="badge"><?= $Translate->get_translate_module_phrase('module_page_profiles', '_Settings_profile'); ?></div>
			</div>
			<div class="card-container">
				<form id="options_one" enctype="multipart/form-data" method="post">
					<div class="settings_container">
						<div class="settings_inp_inf">
							<div class="input-form">
								<label for="vk" class="input_text"><?= $Translate->get_translate_module_phrase('module_page_profiles', '_Vkontakte'); ?></label>
								<input placeholder="<?= $Translate->get_translate_module_phrase('module_page_profiles', '_Vk_id'); ?>" name="vk" value="<?= htmlspecialchars($Info['vk']) ?? '' ?>">
							</div>

							<div class="input-form">
								<label for="discord" class="input_text">Discord</label>
								<?php if ($discordUserId): ?>
									<div type="button" class="secondary_btn" disabled>Discord уже привязан</div>
								<?php else: ?>
									<a href="https://discord.com/oauth2/authorize?client_id=1363616922809274418&response_type=code&redirect_uri=https%3A%2F%2Fastralzone.space%2Fprofiles%2F&scope=identify" class="secondary_btn">Связать свой Discord аккаунт</a>
								<?php endif; ?>
							</div>
							<?php if ($discordUserId): ?>
								<div class="input-form">
									<label for="update_roles" class="input_text">Обновить роли Discord</label>
									<button type="submit" name="update_roles" id="updateRolesButton" class="secondary_btn w100">Обновить роли</button>
								</div>
							<?php endif; ?>

							<div class="input-form">
								<label for="telegram" class="input_text">Telegram</label>
								<input placeholder="<?= $Translate->get_translate_module_phrase('module_page_profiles', '_TG_nickname'); ?>" name="telegram" value="<?= htmlspecialchars($Info['tg']) ?? '' ?>">
							</div>
							<div class="input-form">
								<label for="twitch" class="input_text">Twitch</label>
								<input placeholder="<?= $Translate->get_translate_module_phrase('module_page_profiles', '_twitch_nickname'); ?>" name="twitch" value="<?= htmlspecialchars($Info['twitch']) ?? '' ?>">
							</div>
							<div class="input-form">
								<label for="twitch" class="input_text">Статус</label>
								<input placeholder="Напишите немного о себе" name="status" value="<?= htmlspecialchars($Info['status']) ?? '' ?>">
							</div>
							<input class='secondary_btn w100' name="edit_info" type="submit" form="options_one" value="<?php echo $Translate->get_translate_module_phrase('module_page_adminpanel', '_Save') ?>">
						</div>
						<div class="profile_settings_backs">
							<div class="input-form">
								<label for="back" class="input_text">
									<svg viewBox="0 0 512 512">
										<path d="M0 96C0 60.7 28.7 32 64 32H448c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96zM323.8 202.5c-4.5-6.6-11.9-10.5-19.8-10.5s-15.4 3.9-19.8 10.5l-87 127.6L170.7 297c-4.6-5.7-11.5-9-18.7-9s-14.2 3.3-18.7 9l-64 80c-5.8 7.2-6.9 17.1-2.9 25.4s12.4 13.6 21.6 13.6h96 32H424c8.9 0 17.1-4.9 21.2-12.8s3.6-17.4-1.4-24.7l-120-176zM112 192c26.5 0 48-21.5 48-48s-21.5-48-48-48s-48 21.5-48 48s21.5 48 48 48z" />
									</svg>
									<?= $Translate->get_translate_module_phrase('module_page_profiles', '_Profile_background'); ?>
								</label>
							</div>
							<ul class="profile_settings_backs_list no-scrollbar" id="profile_settings">
								<?php if (!empty($Settings['backs'])) : foreach ($Settings['backs'] as $key => $backsettings) : ?>
										<li>
											<input id="<?php echo $key ?>" type="radio" name="background" value="<?php echo $key ?>" class="background" <?php if ($key == $Info['background']) echo 'checked'; ?> />
											<?php if ($backsettings['video'] == 0) : ?>
												<label class="back_content" style="background: url(<?php echo $Player->General->arr_general['site'] . $backsettings['url'] ?>);" for="<?php echo $key ?>"></label>
											<?php else : ?>
												<label class="back_content" for="<?php echo $key ?>">
													<video preload="auto" class="back_video" id="back<?php echo $key ?>" playsinline="" muted="" loop="">
														<source src="<?php echo $Player->General->arr_general['site'] . $backsettings['url'] ?>" type="video/webm">
													</video>
												</label>
											<?php endif; ?>
										</li>
								<?php endforeach;
								endif; ?>
							</ul>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php endif; ?>