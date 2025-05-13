// izitoast copy
var copyds = new ClipboardJS('.copybtn');
copyds.on('success', function (e) {
    noty('Discord Скопирован', 'success')
    e.clearSelection();
});

var steam = new ClipboardJS('.copybtn2');
steam.on('success', function (e) {
    noty('STEAM Скопирован', 'success')
    e.clearSelection();
});

$(document).on("mouseover", ".back_video", function () {
    $(this).get(0).play();
});
$(document).on("mouseout", ".back_video", function () {
    $(this).get(0).pause();
});

$(function () {
    const update = function () {
        $.ajax({
            type: 'POST',
            url: domain + "app/modules/module_page_profiles/includes/js_controller.php",
            data: ({ online: info }),
            dataType: 'json',
            global: false,
            async: true,
            success: function (data) {
                var last_seen = document.getElementById('online_status');
                var last_seen_link = document.getElementById("connect_link");
                const tippyInstance = last_seen._tippy;
                last_seen.innerHTML = data['online'];
                if (data['ip']) {
                    last_seen_link.setAttribute("href", 'steam://connect/' + data['ip'] + '');
                    last_seen.classList.add("button_playing_server");
                    if (tippyInstance) {
                        tippyInstance.destroy();
                    };
                    last_seen.classList.remove("lastconnect");
                } else {
                    last_seen.classList.remove("button_playing_server");
                    last_seen.classList.add("lastconnect");
                    last_seen_link.removeAttribute("href");
                    if (tippyInstance) {
                        tippyInstance.destroy();
                    };
                }
            }
        });
    };
    setInterval(update, 5000);
    update();
});


$(document).ready(function () {
    $.ajax({
        type: 'POST',
        url: domain + "app/modules/module_page_profiles/includes/js_controller.php",
        data: ({ faceit: faceit }),
        dataType: 'json',
        global: false,
        async: true,
        success: function (data) {
            if (data['faceit_elo'] && document.getElementById("faceit_elo") !== null) {
                var faceit_elo = document.getElementById('faceit_elo').innerHTML;
                document.getElementById('faceit_elo').innerHTML = faceit_elo.replace('0', data['faceit_elo']);
            }
            if (data['faceit_nickname'] && document.getElementById('faceit_nickname') !== null) {
                document.getElementById('faceit_nickname').innerHTML = data['faceit_nickname'];
            }
            if (data['skill_level'] && document.getElementById('skill_level') !== null) {
                document.getElementById('skill_level').src = data['skill_level'];
            }
            document.getElementById('faceit_url').href = data['faceit_url'];
            if (data['faceit_url'] !== undefined) {
                document.getElementById('faceit_url').style.removeProperty("display");
            }
        }
    });
});