let limit = 10;
let pattern = new RegExp("^" + location.protocol + domain + "reports/list/.*");
const sortid = localStorage.getItem('sortid') || '2';
function ChoosingSort() {
	const buttons = document.querySelectorAll('.status_button');
	buttons.forEach(button => {
		if (button.getAttribute('sort_id') === sortid) {
			button.classList.add('status_active');
		} else {
			button.classList.remove('status_active');
		}
	});
	buttons.forEach(button => {
		button.addEventListener('click', function () {
			const sortId = this.getAttribute('sort_id');
			localStorage.setItem('sortid', sortId);
			buttons.forEach(btn => btn.classList.remove('status_active'));
			this.classList.add('status_active');
		});
	});
}
ChoosingSort();
$(document).ready(function () {
	function toggleEye(event) {
		event.preventDefault();

		let toggle_eye = document.getElementById("toggle_eye");
		let password_input = document.getElementById("password_input");

		if (password_input.type === "password") {
			password_input.type = "text";
			toggle_eye.innerHTML = `
				<svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="15" height="15">
					<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
				</svg>`;
		} else {
			password_input.type = "password";
			toggle_eye.innerHTML = `
				<svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="15" height="15">
					<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
					<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
				</svg>`;
		}
	}
	function Rs(formSelect, options) {
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
	Rs("#add_connection", {
		param: "add_connection",
		success: function (data) {
			if (data.status == "success") {
				noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
				setTimeout(function () { location.reload(); }, 3000)
			} else {
				noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
			}
		}
	});
	Rs("#add_server", {
		param: "add_server",
		success: function (data) {
			if (data.status == "success") {
				noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
				setTimeout(function () { location.reload(); }, 3000)
			} else {
				noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
			}
		}
	});
	Rs("#save_one", {
		param: "save_one",
		success: function (data) {
			if (data.status == "success") {
				noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
			} else {
				noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
			}
		}
	});
	Rs("#save_two", {
		param: "save_two",
		success: function (data) {
			if (data.status == "success") {
				noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
			} else {
				noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
			}
		}
	});
	Rs("#save_three", {
		param: "save_three",
		success: function (data) {
			if (data.status == "success") {
				noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
			} else {
				noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
			}
		}
	});
	Rs("#save_four", {
		param: "save_four",
		success: function (data) {
			if (data.status == "success") {
				noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
			} else {
				noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
			}
		}
	});
	Rs("#add_vedict", {
		param: "add_vedict",
		success: function (data) {
			if (data.status == "success") {
				noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2);
				setTimeout(function () { location.reload(); }, 3000)
			} else {
				noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
			}
		}
	});
	$(document).on('click', '.del', function () {
		let button = $(this);
		const id_del = button.attr('id_del');
		const sid = button.attr('sid');
		$.ajax({
			type: 'post',
			url: location.href,
			data: { admin_del: true, id_del: id_del, sid: sid },
			dataType: 'json',
			global: false,
			success: function (data) {
				if (data.status == "success") {
					noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2);
					button.closest('.reports_admin_modal_block').remove();
				} else {
					noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
				}
			},
		});
	});
	Rs("#add_admin", {
		param: "add_admin",
		success: function (data) {
			if (data.status == "success") {
				noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2);
				setTimeout(function () { location.reload(); }, 3000);
			} else {
				noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
			}
		}
	});
	function LoadStats() {
		$.ajax({
			type: 'post',
			url: location.href,
			data: { load_stat: true },
			dataType: 'json',
			success: function (data) {
				for (let i = 0; i < data['count']; i++) {
					if (document.getElementById('server_' + i + '_new') && document.getElementById('server_' + i + '_all')) {
						document.getElementById('server_' + i + '_new').innerHTML = '+' + data[i]['new_rep'];
						document.getElementById('server_' + i + '_all').innerHTML = data[i]['all_rep'];
					}
				}
			}
		});
	}
	function RenderList(sort, limit, isAutoUpdate = false) {
		if (!isAutoUpdate) {
			$('#report_list').html('');
			for (let i = 0; i < limit; i++) {
				$('#report_list').append('<div class="loader loader-block"></div>');
			}
		}
		$.ajax({
			type: 'post',
			url: location.href,
			data: { load_list: true, sort: sort, limit: limit },
			dataType: 'json',
			success: function (data) {
				$('#report_list').html('');
				if (data['html'] && data['html'].length > 0) {
					for (let i = 0; i < data['html'].length; i++) {
						$('#report_list').append(data['html'][i]);
					}
					$('#report_list').append(data['pagination']);
				} else {
					$('#report_list').append(data['null']);
				}
				TippyContent();
			}
		});
	}
	function RenderBtnNoty() {
		$.ajax({
			type: 'post',
			url: location.href,
			data: { noty_btn: true },
			dataType: 'json',
			success: function (data) {
				if (data['noty'].length > 0) {
					$('#work_status').html('');
					$('#work_status').append(data['noty']);
					document.getElementById('work_status').style.display = 'block';
				} else {
					document.getElementById('work_status').style.display = 'none';
				}
			}
		});
	}
	$(document).on('click', '.report_notify_btn', function () {
		let button = $(this);
		const btn = button.attr('btn');
		$.ajax({
			type: 'post',
			url: location.href,
			data: { noty_click: true, btn: btn },
			dataType: 'json',
			global: false,
			success: function (data) {
				if (data.status == "success") {
					noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
					RenderBtnNoty();
				} else {
					noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
				}
			},
		});
	});
	if (location.href == location.protocol + domain + 'reports/' || pattern.test(location.href)) {
		RenderBtnNoty();
		LoadStats();
		RenderList(sortid, limit, false);
	}
	$(document).on('click', '.status_button', function () {
		$('html').scrollTop(0);
		limit = 10;
		const sortid = localStorage.getItem('sortid');
		RenderList(sortid, limit, false);
	});
	$(document).on('click', '#load_next', function () {
		const sortid = localStorage.getItem('sortid');
		limit += 10;
		RenderList(sortid, limit, false);
	});
	if (location.href == location.protocol + domain + 'reports/' || pattern.test(location.href)) {
		if (AutoUpdateInfo == 1) {
			setInterval(function () {
				const sortid = localStorage.getItem('sortid');
				RenderList(sortid, limit, true);
				LoadStats();
			}, UpdateTimeJS + '000');
		}
	}
	let copysteam = new ClipboardJS('.copybtn');
	copysteam.on('success', function (e) {
		noty('STEAM Скопирован', 'success', domain + '/storage/assets/sounds/success2.mp3', 0.2)
		e.clearSelection();
	});
	let copyip = new ClipboardJS('.copybtn2');
	copyip.on('success', function (e) {
		noty('IP Скопирован', 'success', domain + '/storage/assets/sounds/success2.mp3', 0.2)
		e.clearSelection();
	});
	function TippyContent() {
		tippy('[data-tippy-content]', {
			animation: 'shift-away',
			theme: 'neo',
			allowHTML: true
		});
	}
	function PutApiReport() {
		$.ajax({
			type: 'post',
			url: domain + '/app/modules/module_page_reports/includes/js_controller.php',
			data: { acc_time: true, steamid: steamid_intruder },
			dataType: 'json',
			success: function (data) {
				$('#created_time').html('');
				$('#created_time').append(data['string']);
				$('#play_time').html('');
				$('#play_time').append(data['string2']);
				if (data['bans'].length > 0) {
					$('#blockdb_block').html('');
					$('#blockdb_block').append(data['bans']);
					document.getElementById('blockdb_block').style.display = 'flex';
				} else {
					document.getElementById('blockdb_block').style.display = 'none';
				}
			}
		});
	}
	function PutStatusReport() {
		$.ajax({
			type: 'post',
			url: location.href,
			data: { put_status: true },
			dataType: 'json',
			success: function (data) {
				$('#status_btn').html('');
				$('#status_btn').append(data['btn']);
				$('#status_report').html('');
				$('#status_report').append(data['html']);
				if (data['form'].length > 0) {
					$('#rep_verdict').html('');
					$('#rep_verdict').append(data['form']);
					document.getElementById('rep_verdict').style.display = 'flex';
				} else {
					document.getElementById('rep_verdict').style.display = 'none';
				}
				if (data['connect'].length > 0) {
					$('#server_connect').html('');
					$('#server_connect').append(data['connect']);
					document.getElementById('server_connect').style.display = 'flex';
				} else {
					document.getElementById('server_connect').style.display = 'none';
				}
			}
		});
	}
	function PutOptionalInfo() {
		$.ajax({
			type: 'post',
			url: location.href,
			data: { option_info: true },
			dataType: 'json',
			success: function (data) {
				$('#warns_block_num').html('');
				$('#warns_block_num').append(data['warns_num']);
				if (data['warns'].length > 0) {
					$('#warns_block').html('');
					$('#warns_block').append(data['warns']);
					document.getElementById('warns_block').style.display = 'flex';
				} else {
					document.getElementById('warns_block').style.display = 'none';
				}
			}
		});
	}
	if (new RegExp("^" + window.location.protocol + domain + "reports/report/.*/.*/$").test(location.href)) {
		PutStatusReport();
		PutOptionalInfo();
		PutApiReport();
	}
	$(document).on('click', '.btn_click', function () {
		let button = $(this);
		const btn = button.attr('btn');
		$.ajax({
			type: 'post',
			url: location.href,
			data: { btn_click: true, btn: btn },
			dataType: 'json',
			global: false,
			success: function (data) {
				if (data.status == "success") {
					noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
					PutStatusReport();
				} else {
					noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
				}
			},
		});
	});
	$(document).on('click', '.verdict_warn', function () {
		$.ajax({
			type: 'post',
			url: location.href,
			data: { warn_btn: true },
			dataType: 'json',
			global: false,
			success: function (data) {
				if (data.status == "success") {
					noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
					PutOptionalInfo();
				} else {
					noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
				}
			},
		});
	});
	let selectverdict = '';
	$(document).on('click', '.verdict_btn', function () {
		$('.verdict_btn').removeClass('verdict_active');
		$(this).addClass('verdict_active');
		selectverdict = $(this).data('verdict');
		$('#verdict').val('');
	});

	$(document).on('input', '#verdict', function () {
		selectverdict = '';
		$('.verdict_btn').removeClass('verdict_active');
	});

	$(document).on('click', '.verdict_do', function () {
		const verdictarea = $('#verdict').val().trim();
		const verdict = selectverdict || verdictarea;
		$.ajax({
			type: 'post',
			url: location.href,
			data: { verdict: verdict },
			dataType: 'json',
			global: false,
			success: function (data) {
				if (data.status == "success") {
					noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2);
					PutStatusReport();
				} else {
					noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2);
				}
			}
		});
	});
	function UpdateReportBan() {
		$.ajax({
			type: 'post',
			url: location.href,
			data: { reload_status: true },
			dataType: 'json'
		});
	}
	function SetUpdateReportBan() {
		$.ajax({
			type: 'post',
			url: location.href,
			data: { set_update_status: true },
			dataType: 'json',
			success: function (data) {
				if (data.status == "success") {
					noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2);
					UpdateReportBan();
				} else {
					noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2);
				}
			}
		});
	}
	if (AutoUpdateStatus == 1) {
		UpdateReportBan();
	}
	$(document).on('click', '#reload_status', function () {
		SetUpdateReportBan();
	});
	function UpdateReportWarn() {
		$.ajax({
			type: 'post',
			url: location.href,
			data: { reload_warn: true },
			dataType: 'json'
		});
	}
	function SetUpdateReportWarn() {
		$.ajax({
			type: 'post',
			url: location.href,
			data: { set_update_warn: true },
			dataType: 'json',
			success: function (data) {
				if (data.status == "success") {
					noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2);
					UpdateReportWarn();
				} else {
					noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2);
				}
			}
		});
	}
	if (AutoUpdateWarn == 1) {
		UpdateReportWarn();
	}
	$(document).on('click', '#reload_warn', function () {
		SetUpdateReportWarn();
	});
	$(document).on('click', '.rp_delete_server', function (event) {
		event.preventDefault();
		let button = $(this);
		const server = button.attr('server');
		$.ajax({
			type: 'post',
			url: location.href,
			data: { server_del: true, server: server },
			dataType: 'json',
			success: function (data) {
				console.log(data);
				if (data.status == "success") {
					noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2);
					button.closest('.rp_server_btn').remove();
				} else {
					noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
				}
			},
		});
    });
	$(document).on('click', '.del_list', function () {
		let button = $(this);
		const del = button.attr('del');
		$.ajax({
			type: 'post',
			url: location.href,
			data: { verdict_del: true, id: del },
			dataType: 'json',
			success: function (data) {
				console.log(data);
				if (data.status == "success") {
					noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2);
					button.closest('.verdict_item').remove();
				} else {
					noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
				}
			},
		});
    });
});