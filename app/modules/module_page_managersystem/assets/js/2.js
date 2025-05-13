// Работа с формами...
function ManagerSystem(formSelect, options) {
	$(formSelect).on("submit", (e) => {
	  e.preventDefault();
	  const data = $(e.currentTarget).serialize() + "&" + options.param;
	  $.ajax({
		type: 'post',
		url: location.href,
		data: data,
		dataType: "json",
		success: function (data) {
		    options.success(data);
		},
		error: function () { return false; }
	  });
	  return false;
	});
}

// Создание таблиц
ManagerSystem("#ms_settings_add_table", {
	param: "ms_settings_add_table",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
	}
});

ManagerSystem("#ms_settings_servers", {
	param: "ms_settings_servers",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
	}
});

ManagerSystem("#ms_settings_servers_vip", {
	param: "ms_settings_servers_vip",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
	}
});

// Сохранение настроек основные
ManagerSystem("#ms_settings_general", {
	param: "ms_settings_general",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
	}
});

// Сохранение настроек дополнительные
ManagerSystem("#ms_settings_general_additional", {
	param: "ms_settings_general_additional",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
	}
});

// Добавление доступа
ManagerSystem("#ms_access_add", {
	param: "ms_access_add",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
	}
});

// Удаление доступа
ManagerSystem("#ms_access_del", {
	param: "ms_access_del",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
	}
});

// Создание группы админов
ManagerSystem("#ms_admin_group_add", {
	param: "ms_admin_group_add",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
	}
});

// Удаление группы
ManagerSystem("#ms_admin_group_del", {
	param: "ms_admin_group_del",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
	}
});

// Создание группы vip
ManagerSystem("#ms_vip_group_add", {
	param: "ms_vip_group_add",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
	}
});

// Удаление группы
ManagerSystem("#ms_vip_group_del", {
	param: "ms_vip_group_del",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
	}
});

// Создание причины бана
ManagerSystem("#ms_reason_ban_add", {
	param: "ms_reason_ban_add",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
	}
});

// Удаление причины
ManagerSystem("#ms_reason_ban_del", {
	param: "ms_reason_ban_del",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
	}
});

// Создание причины мута
ManagerSystem("#ms_reason_mute_add", {
	param: "ms_reason_mute_add",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
	}
});

// Удаление причины
ManagerSystem("#ms_reason_mute_del", {
	param: "ms_reason_mute_del",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
	}
});

// Создание готового времени прив
ManagerSystem("#ms_privileges_time_add", {
	param: "ms_privileges_time_add",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
	}
});

// Удаление причины
ManagerSystem("#ms_privileges_time_del", {
	param: "ms_privileges_time_del",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
	}
});

// Создание готового времени наказ
ManagerSystem("#ms_punishment_time_add", {
	param: "ms_punishment_time_add",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
	}
});

// Удаление причины
ManagerSystem("#ms_punishment_time_del", {
	param: "ms_punishment_time_del",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
	}
});

// Добавление администратора
ManagerSystem("#ms_admins_add", {
	param: "ms_admins_add",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
	}
});

ManagerSystem("#ms_admin_edit", {
	param: "ms_admin_edit",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { window.location.href = '/managersystem/addadmin/'; }, 3000);
	}
});

ManagerSystem("#ms_vip_edit", {
	param: "ms_vip_edit",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { window.location.href = '/managersystem/addvip/'; }, 3000);
	}
});

ManagerSystem("#ms_access_edit", {
	param: "ms_access_edit",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { window.location.href = '/managersystem/access/'; }, 3000);
	}
});

// Удаление администратора
ManagerSystem("#ms_admins_del", {
	param: "ms_admins_del",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
	}
});

ManagerSystem("#ms_ban_add", {
	param: "ms_ban_add",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
	}
});

ManagerSystem("#ms_mute_add", {
	param: "ms_mute_add",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
	}
});

ManagerSystem("#ms_vip_add", {
	param: "ms_vip_add",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
	}
});

ManagerSystem("#ms_warn_add", {
	param: "ms_warn_add",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
	}
});

ManagerSystem("#save_db", {
	param: "save_db",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
	}
});

$(document).on('click', '#ms_expires_del', function () {
	$.ajax({
		type: 'post',
		url: location.href,
		data: { ms_expires_del: true },
		dataType: 'json',
		global: false,
		success: function (data) {
			if (data.status == "success") {
				noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
			} else {
				noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
			}
			if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
		},
	});
});

$(document).on('click', '#ms_ar_moon_del', function () {
	$.ajax({
		type: 'post',
		url: location.href,
		data: { ms_ar_moon_del: true },
		dataType: 'json',
		global: false,
		success: function (data) {
			if (data.status == "success") {
				noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
			} else {
				noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
			}
			if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
		},
	});
});

$(document).on('click', '#ms_access_del', function () {
	let button = $(this);
	const id_del = button.attr('id_del');
	$.ajax({
		type: 'post',
		url: location.href,
		data: { ms_access_del: true, steamid_access: id_del },
		dataType: 'json',
		global: false,
		success: function (data) {
			if (data.status == "success") {
				noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
			} else {
				noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
			}
			if (data.status === 'success') {
				button.closest('.user_card_bg').remove();
			}
		},
	});
});

$(document).on('click', '#ms_admin_del', function () {
	let button = $(this);
	const id_del = button.attr('id_del');
	const id_group = button.attr('id_group');
	const id_server = button.attr('id_server');
	$.ajax({
		type: 'post',
		url: location.href,
		data: { ms_admin_del: true, steamid: id_del, group: id_group, server: id_server },
		dataType: 'json',
		global: false,
		success: function (data) {
			if (data.status == "success") {
				noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
			} else {
				noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
			}
			if (data.status === 'success') {
				button.closest('.user_card_bg').remove();
			}
		},
	});
});

$(document).on('click', '#ms_vip_del', function () {
	let button = $(this);
	const id_del = button.attr('id_del');
	const id_end = button.attr('id_end');
	$.ajax({
		type: 'post',
		url: location.href,
		data: { ms_vip_del: true, steamid: id_del, end: id_end },
		dataType: 'json',
		global: false,
		success: function (data) {
			if (data.status == "success") {
				noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
			} else {
				noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
			}
			if (data.status === 'success') {
				button.closest('.user_card_bg').remove();
			}
		},
	});
});

$(document).on('click', '#ms_ar_del', function () {
	let button = $(this);
	const id_del = button.attr('id_del');
	$.ajax({
		type: 'post',
		url: location.href,
		data: { ms_ar_del: true, steamid: id_del },
		dataType: 'json',
		global: false,
		success: function (data) {
			if (data.status == "success") {
				noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
			} else {
				noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
			}
			if (data.status === 'success') {
				button.closest('.user_card_bg').remove();
			}
		},
	});
});

$(document).on('click', '#ms_vip_group_del', function () {
	let button = $(this);
	const id_del = button.attr('id_del');
	$.ajax({
		type: 'post',
		url: location.href,
		data: { ms_vip_group_del: true, id: id_del },
		dataType: 'json',
		global: false,
		success: function (data) {
			if (data.status == "success") {
				noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
			} else {
				noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
			}
			if (data.status === 'success') {
				button.closest('.table_2_group_list').remove();
			}
		},
	});
});

$(document).on('click', '#ms_admin_group_del', function () {
	let button = $(this);
	const id_del = button.attr('id_del');
	$.ajax({
		type: 'post',
		url: location.href,
		data: { ms_admin_group_del: true, id: id_del },
		dataType: 'json',
		global: false,
		success: function (data) {
			if (data.status == "success") {
				noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
			} else {
				noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
			}
			if (data.status === 'success') {
				button.closest('.table_4_group_list').remove();
			}
		},
	});
});

$(document).on('click', '#ms_reason_ban_del', function () {
	let button = $(this);
	const id_del = button.attr('id_del');
	$.ajax({
		type: 'post',
		url: location.href,
		data: { ms_reason_ban_del: true, id: id_del },
		dataType: 'json',
		global: false,
		success: function (data) {
			if (data.status == "success") {
				noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
			} else {
				noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
			}
			if (data.status === 'success') {
				button.closest('.table_2_group_list').remove();
			}
		},
	});
});

$(document).on('click', '#ms_reason_mute_del', function () {
	let button = $(this);
	const id_del = button.attr('id_del');
	$.ajax({
		type: 'post',
		url: location.href,
		data: { ms_reason_mute_del: true, id: id_del },
		dataType: 'json',
		global: false,
		success: function (data) {
			if (data.status == "success") {
				noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
			} else {
				noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
			}
			if (data.status === 'success') {
				button.closest('.table_2_group_list').remove();
			}
		},
	});
});

$(document).on('click', '#ms_privileges_time_del', function () {
	let button = $(this);
	const id_del = button.attr('id_del');
	$.ajax({
		type: 'post',
		url: location.href,
		data: { ms_privileges_time_del: true, id: id_del },
		dataType: 'json',
		global: false,
		success: function (data) {
			if (data.status == "success") {
				noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
			} else {
				noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
			}
			if (data.status === 'success') {
				button.closest('.table_3_group_list').remove();
			}
		},
	});
});

$(document).on('click', '#ms_punishment_time_del', function () {
	let button = $(this);
	const id_del = button.attr('id_del');
	$.ajax({
		type: 'post',
		url: location.href,
		data: { ms_punishment_time_del: true, id: id_del },
		dataType: 'json',
		global: false,
		success: function (data) {
			if (data.status == "success") {
				noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
			} else {
				noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
			}
			if (data.status === 'success') {
				button.closest('.table_3_group_list').remove();
			}
		},
	});
});

$(document).on('click', '#ms_ban_del', function () {
	let button = $(this);
	const id_del = button.attr('id_del');
	const id_end = button.attr('id_end');
	$.ajax({
		type: 'post',
		url: location.href,
		data: { ms_ban_del: true, steamid: id_del, end: id_end },
		dataType: 'json',
		global: false,
		success: function (data) {
			if (data.status == "success") {
				noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
			} else {
				noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
			}
			if (data.status === 'success') {
				button.closest('.user_card_bg').remove();
			}
		},
	});
});

$(document).on('click', '#ms_ban_unban', function () {
	let button = $(this);
	const id_del = button.attr('id_del');
	const id_end = button.attr('id_end');
	$.ajax({
		type: 'post',
		url: location.href,
		data: { ms_ban_unban: true, steamid: id_del, end: id_end },
		dataType: 'json',
		global: false,
		success: function (data) {
			if (data.status == "success") {
				noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
			} else {
				noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
			}
			if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
		},
	});
});

$(document).on('click', '#ms_mute_del', function () {
	let button = $(this);
	const id_del = button.attr('id_del');
	const id_end = button.attr('id_end');
	$.ajax({
		type: 'post',
		url: location.href,
		data: { ms_mute_del: true, steamid: id_del, end: id_end },
		dataType: 'json',
		global: false,
		success: function (data) {
			if (data.status == "success") {
				noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
			} else {
				noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
			}
			if (data.status === 'success') {
				button.closest('.user_card_bg').remove();
			}
		},
	});
});

$(document).on('click', '#ms_warn_del', function () {
	let button = $(this);
	const id_del = button.attr('id_del');
	const id_end = button.attr('id_end');
	$.ajax({
		type: 'post',
		url: location.href,
		data: { ms_warn_del: true, steamid: id_del, end: id_end },
		dataType: 'json',
		global: false,
		success: function (data) {
			if (data.status == "success") {
				noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
			} else {
				noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
			}
			if (data.status === 'success') {
				button.closest('.user_card_bg').remove();
			}
		},
	});
});

$(document).on('click', '#ms_mute_unban', function () {
	let button = $(this);
	const id_del = button.attr('id_del');
	const id_end = button.attr('id_end');
	$.ajax({
		type: 'post',
		url: location.href,
		data: { ms_mute_unban: true, steamid: id_del, end: id_end },
		dataType: 'json',
		global: false,
		success: function (data) {
			if (data.status == "success") {
				noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
			} else {
				noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
			}
			if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
		},
	});
});

$(document).on('click', '#ms_server_del', function () {
	let button = $(this);
	const id_del = $(this).attr('id_del');
	$.ajax({
		type: 'post',
		url: location.href,
		data: { ms_server_del: true, id: id_del},
		dataType: 'json',
		global: false,
		success: function (data) {
			if (data.status == "success") {
				noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
			} else {
				noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
			}
			if (data.status === 'success') {
				button.closest('.card_server').remove();
			}
		},
	});
});

$(document).on('click', '#ms_server_vip_del', function () {
	let button = $(this);
	const id_del = $(this).attr('id_del');
	$.ajax({
		type: 'post',
		url: location.href,
		data: { ms_server_vip_del: true, id: id_del},
		dataType: 'json',
		global: false,
		success: function (data) {
			if (data.status == "success") {
				noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
			} else {
				noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
			}
			if (data.status === 'success') {
				button.closest('.card_server').remove();
			}
		},
	});
});

function delay(fn, ms) 
{
    let timer = 0
    return function (...args) 
    {
        clearTimeout(timer)
        timer = setTimeout(fn.bind(this, ...args), ms || 0)
    }
}

$('#search_table_admin').keyup(delay(function (e) {
    let admin = this.value;
    SearchAjax(admin);
}, 500));

$('#search_table_vip').keyup(delay(function (e) {
    let vip = this.value;
    SearchAjax("", vip);
}, 500));

$('#search_table_ban').keyup(delay(function (e) {
    let ban = this.value;
    SearchAjax("", "", ban);
}, 500));

$('#search_table_mute').keyup(delay(function (e) {
    let mute = this.value;
    SearchAjax("", "", "", mute);
}, 500));

$('#search_table_ar').keyup(delay(function (e) {
    let ar = this.value;
    SearchAjax("", "", "", "", ar);
}, 500));

function SearchAjax(admin = "", vip = "", ban = "", mute = "", ar = "")
{
    if(admin.length >= 1 || vip.length >= 1 || ban.length >= 1 || mute.length >= 1 || ar.length >= 1) {
        $.ajax({
            type: "POST",
            url: location.href,
            dataType: "html",
            data: "search_admin=" + admin + "&search_vip=" + vip + "&search_ban=" + ban + "&search_mute=" + mute + "&search_ar=" + ar,
            success: function(res) {
            $('#table_result').html('');
            try
            {
                let json = JSON.parse(res);
                    if( json.result.length > 0 )
                    {          
                        for(i = 0; i < json.result.length; i++)
                        {
                            $('#table_result').append(json["result"][i].search_html);
                        }
						$('#table_result').show();
                        $("#table_list_foreach").hide();
                        $(".pagination").hide();
                    }
                    else
                    {
						$('#table_result').hide();
                        $('#table_result_error').html('Поиск не выдал результатов');
                        $("#table_list_foreach").hide();
                        $(".pagination").hide();

                    }
                }
            catch(e)
                {
					$('#table_result').hide();
                    $('#table_result_error').html('Ничего не найдено :(');
                    $("#table_list_foreach").hide();
                    $(".pagination").hide();
                }
            }
        });
        return false;
    }
    else {
		$('#table_result').hide();
        $('#table_result_error').html(false);
        $("#table_list_foreach").show();
        $(".pagination").show();
    }
    return false;
}