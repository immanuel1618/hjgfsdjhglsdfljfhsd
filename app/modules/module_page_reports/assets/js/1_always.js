$(document).ready(function () {
    function CheckNewReports() {
        $.ajax({
            type: 'post',
            url: domain + 'reports/',
            data: { new_report: true },
            dataType: 'json',
            success: function (data) {
                if (data['noty'].length > 0) {
                    NotifyNewReports(data['noty'][0]['id'], data['noty'][0]['sid'], data['noty'][0]['iname'], data['noty'][0]['sname'], data['noty'][0]['reason']);
                }
            }
        });
    }

    function NotifyNewReports(newid, newsid, iname, sname, reason) {
        $.ajax({
            type: 'post',
            url: domain + 'reports/',
            data: { noty_report: true, id: newid, sid: newsid, iname: iname, sname: sname, reason: reason },
            dataType: 'json'
        });
    }

    function UpdateAdminUser() {
		$.ajax({
			type: 'post',
			url: domain + 'reports/',
			data: { reload_admins: true },
			dataType: 'json'
		});
	}

    function SetUpdate() {
		$.ajax({
			type: 'post',
			url: domain + 'reports/',
			data: { set_update: true },
			dataType: 'json',
			success: function (data) {
				if (data.status == "success") {
					noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
					UpdateAdminUser();
				} else {
					noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
				}
			},
		});
	}

    if (window.location.href == 'https:' + domain + 'reports/settings/') {
        $(document).on('click', '#reload_admin', function () {
            SetUpdate();
        });    
    }

    if (AutoUpdateAdmin == 1) {
		UpdateAdminUser();
	}

    if (AutoCheckReport == 1) {
        setInterval(function () {
            CheckNewReports();
        }, UpdateTimeJS + '000');
    }
});
