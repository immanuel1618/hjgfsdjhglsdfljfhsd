function RenderingAvatar() {
  if (avatar != 0) {
      $.post("/app/includes/js_controller.php", {
          function: 'avatars',
          data: avatar
      }, function (e) {
          if (e.trim() !== "") {
              let jsonData = $.parseJSON(e);
              if (jsonData && Array.isArray(jsonData) && jsonData.length === avatar.length) {
                  for (let i = 0; i < avatar.length; i++) {
                      let elementAvatar = document.querySelector(`[avatarid="${avatar[i]}"]`);
                      let elementFrame = document.querySelector(`[frameid="${avatar[i]}"]`);
                      if (elementAvatar) {
                        elementAvatar.setAttribute("src", jsonData[i]['avatar']);
                      } if (elementFrame) {
                        elementFrame.setAttribute("src", jsonData[i]['frame']);
                      }
                  }
              }
          }
      });
  }
}
RenderingAvatar();

function set_options_data(data_id, change_data) {
  $.post(domain + "/app/includes/js_controller.php", {
    function: "set",
    option: data_id,
    change: change_data,
  });
  noty("Сохранено", "success");
}

function set_options_data_select(name, value) {
  $.post(domain + "/app/includes/js_controller.php", {
    function: "set",
    option: name,
    data: value,
  });
  noty("Сохранено", "success");
}

function SaveInStorage(key, value) {
  if (typeof Storage !== "undefined") {
    sessionStorage.setItem(key, value);
  }
}

function LoadFromStorage(key) {
  if (typeof Storage !== "undefined") {
    return sessionStorage.getItem(key);
  } else {
    return "";
  }
}
//Notifications -->
let notifications = {};
let soundPlayed = false;

function PlaySound(src) {
  let audio = new Audio(src);
  audio.play();
}

function main_notifications_refresh() {
  $.ajax({
    type: "POST",
    url: window.location.href,
    data: { entryid: 1 },
    success: function (result) {
      if (IsJsonString(result)) {
        let data = jQuery.parseJSON(result);
        SaveInStorage("notifications_count", data["count"]);
        let hasUnseenNotifications = false;

        if (data["count"] != 0) {
          $("#main_notifications_badge").html(data["count"]);
          $("#main_notifications_badge").css({
            display: "flex",
            "align-items": "center",
            "justify-content": "center",
          });
          $(".no_notify").remove();
          $("#main_notifications_all_del").css({
            "opacity": 1,
            "pointer-events": "auto"
          });

          data["notifications"].forEach(function (notification) {
            if (!notifications.hasOwnProperty(notification["id"])) {
              $("#main_notifications").prepend(notification["html"]);
              notifications[notification["id"]] = true;
              if (notification["seen"] == 0) {
                hasUnseenNotifications = true;
              }
            }
          });
          if (hasUnseenNotifications && !soundPlayed) {
            PlaySound(domain + "storage/assets/sounds/Knock.mp3");
            soundPlayed = true;
          }
        } else {
          $("#main_notifications").html(data["no_notifications"]);
          $("#main_notifications_badge").html(false);
          $("#main_notifications_badge").hide();
          $("#main_notifications_all_del").css({
            "opacity": 0,
            "pointer-events": "none"
          });
          soundPlayed = false;
        }
      }
    },
  });
}

function main_notifications_load() {
  let count_saved = LoadFromStorage("notifications_count");
  if ($.isNumeric(count_saved)) {
    main_notifications_refresh();
  }
  setInterval(main_notifications_refresh, 30000);
}

$(document).on('click', '#main_notifications_del', function () {
  let button = $(this);
  const id_del = button.attr('id_del');
  $.ajax({
    type: 'post',
    url: location.href,
    data: { main_notifications_del: true, id: id_del },
    dataType: 'json',
    global: false,
    success: function (data) {
      noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2);
      button.closest(".notify_body").remove();
      main_notifications_refresh();
    },
  });
});

$(document).on('click', '#main_notifications_all_del', function () {
  $.ajax({
    type: 'post',
    url: location.href,
    data: { main_notifications_all_del: true },
    dataType: 'json',
    global: false,
    success: function (data) {
      noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2);
      main_notifications_refresh();
    },
  });
});

main_notifications_load();
//<-- Notifications

function IsJsonString(str) {
  try {
    JSON.parse(str);
  } catch (e) {
    return false;
  }
  return true;
}