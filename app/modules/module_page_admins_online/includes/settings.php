<?php if (!isset($_SESSION['user_admin'])) {
	header_fix($General->arr_general['site']);
	exit;
} ?>
<div class="row">
	<!-- <div class="col-md-4">
		<div class="card">
			<div class="card-header">
				<div class="badge">Настройки</div>
			</div>
			<div class="card-container">
				<form class="online_settings" id="update_settings_form" action="https://<?= $General->arr_general['site'] ?>admins_online/settings/update-settings/" method="POST">
					<div class="input-form">
						<label class="input_text" for="period">Установите нужный период (в секундах)</label>
						<input id="period" type="text" name="period" placeholder="2629743" value="<?= $settings['period'] ?>">
					</div>
					<div class="input-form">
						<label class="input_text" for="needtime">Установите время, которое необходимо наигрывать за указанный период (в секундах)</label>
						<input id="needtime" name="needtime" type="text" placeholder="25200 (оставьте пустым, если неважно)" value="<?= $settings['required_playtime'] ?>">
					</div>
					<button type="submit" class="secondary_btn w100">Сохранить</button>
				</form>
			</div>
		</div>
	</div> -->
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<div class="badge">Сервера</div>
			</div>
			<div class="card-container">
				<div class="accesses">
					<form class="online_settings" id="addServer" action="https:<?= $General->arr_general['site'] ?>admins_online/settings/add-server/" method="POST">
						<div class="input-form">
							<div class="input_text">Выберите нужный сервер из базы LRWEB</div>
							<select class="custom-select" name="lr_server_id" placeholder="Выберите сервер">
								<?php foreach ($General->server_list as $server) : ?>
									<option value="<?= $server['id'] ?>"><?= htmlentities($server['name_custom']) ?></option>
								<?php endforeach ?>
							</select>
						</div>
						<div class="input-form">
							<label class="input_text" for="idsrviks">ID сервера Iks</label>
							<input id="idsrviks" type="text" name="iks_server_id" placeholder="1" value="1">
						</div>
						<button class="secondary_btn w100" type="submit">Добавить сервер</button>
					</form>
					<hr>
					<div class="badge">Список серверов</div>
					<?php if (count($connectedServers) > 0) : ?>
						<div class="adm_online_servers">
							<?php foreach ($connectedServers as $server) : ?>

								<div class="adm_online_server">
									<div class="srv_left">
										<span>ID: <?= $server['id'] ?> | <?= htmlentities($server['name']) ?></span>
										<span><?= $server['ip'] ?></span>
									</div>
									<div class="srv_right">
										<button server-id="<?= $server['id'] ?>"  id="deleteServer" class="secondary_btn btn_delete">Удалить</button>
									</div>
								</div>

							<?php endforeach ?>
						</div>
					<?php else : ?>
						<div class="havent_servers">Нет серверов</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<div class="badge">Доступ к странице</div>
			</div>
			<div class="card-container">
				<div class="accesses">
					<form class="online_settings" action="https:<?= $General->arr_general['site'] ?>admins_online/settings/update-access/" id="online_settings_form" method="POST">
						<div class="input-form" data-tippy-content="Автоматически добавлять доступ всем админам из админ-системы Iks" data-tippy-placement="bottom">
							<input class="border-checkbox" type="checkbox" id="autoaddiks" name="autoaddiks" <?php if ($settings['all_admin_access'] == 1) : ?> checked <?php endif; ?>>
							<label class="border-checkbox-label" for="autoaddiks">Автоматически выдавать доступ к странице</label>
						</div>
						<button type="submit" class="secondary_btn w100">Сохранить настройки</button>
					</form>
					<hr>
					<form class="online_settings" action="https:<?= $General->arr_general['site'] ?>admins_online/settings/add-access/" id="add_access" method="POST">
						<div class="input-form">
							<label class="input_text" for="addadminonline">Добавить доступ</label>
							<input id="addadminonline" type="text" name="steamid64" placeholder="76562398912346679" value="76562398912346679">
						</div>
						<button type="submit" class="secondary_btn w100">Добавить доступ к странице</button>
					</form>
					<hr>
					<div class="onlineadm_access_list">
						<div class="badge">Пользователи с доступом</div>
						<?php if (!empty($accesses)) : ?>
							<?php foreach ($accesses as $access) : ?>
								<div class="onlineadm_access_admin">
									<div class="admin_details">
										<img src="<?= $General->getAvatar($access['steamid64'], 3) ?>" alt="">
										<div>
											<a href="https:<?= $General->arr_general['site'] ?>profiles/<?= $access['steamid64'] ?>/?search=1" target="_blank"><?= htmlentities($Module->getNicknameBySteam($access['steamid64'])) ?></a>
										</div>
									</div>
									<a href="/"><button userId="<?= $access['id'] ?>" id="deleteAccess" class="secondary_btn btn_delete">Удалить</button></a>
								</div>
							<?php endforeach; ?>
						<?php else : ?>
							<div class="havent_accesses"><?= $Translate->get_translate_module_phrase('module_page_admins_online', '_NOT_ACCESS') ?></div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>