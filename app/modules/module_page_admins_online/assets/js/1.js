$(document).ready(function () {
  $(".adm_online_general_block").click(function (event) {
    var $ul = $(this).find("ul");
    var $svg = $(this).find("svg");
    if ($ul.is(":visible")) {
      $ul.slideUp(250, function () {
        $ul.css("display", "none");
      });
    } else {
      $ul.slideDown(250, function () {
        $ul.css("display", "flex");
      });
    }
    $svg.toggleClass("svg_rotate");
  });

  $(".adm_online_general_block ul").click(function (event) {
    event.stopPropagation();
  });
});

document.addEventListener("DOMContentLoaded", () => {
  const urlParams = new URLSearchParams(window.location.search);
  const fromTimestamp = urlParams.get('from');
  const toTimestamp = urlParams.get('to');

  let selectedDates = []; 

  if (fromTimestamp && toTimestamp) {
    const fromDate = new Date(fromTimestamp * 1000).toISOString().split('T')[0];
    const toDate = new Date(toTimestamp * 1000).toISOString().split('T')[0];
    selectedDates = [`${fromDate}:${toDate}`];
  }

  const calendar = new VanillaCalendar("#calendar", {
    settings: {
      lang: "ru",
      selection: {
        day: 'multiple-ranged',
      },
      visibility: {
        theme: 'dark',
      },
      selected: {
        dates: selectedDates,
      },
    },
  });

  calendar.init();

  const form = document.getElementById("filter");
  form.addEventListener("submit", (event) => {
    event.preventDefault();

    if (calendar.selectedDates.length > 0) {
      const dates = calendar.selectedDates.map(date => new Date(date).getTime() / 1000);
      const fromDate = Math.min(...dates);
      const toDate = Math.max(...dates);
    
      document.getElementById("fromDate").value = fromDate;
      document.getElementById("toDate").value = toDate;
    }
    form.submit();
  });
});

$(document).ready(function() {
  $('#addServer').on('submit', function(e) {
      e.preventDefault();

      var formData = $(this).serialize();

      $.ajax({
          type: 'POST',
          url: $(this).attr('action'),
          data: formData,
          success: function(response) {
              if (typeof response === 'string') {
                  response = JSON.parse(response); 
              }
              if(response.status === 'success') {
                noty(response.text, response.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
              } else {
                noty(response.text, response.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
              }
          }
      });
  });
});

$(document).ready(function() {
  $('#deleteServer').on('click', function(e) {
      e.preventDefault();

      var serverId = $(this).attr('server-id');

      $.ajax({
          type: 'POST',
          url: '/admins_online/settings/delete-server/',
          data: { server_id: serverId },
          success: function(response) {
              if (typeof response === 'string') {
                  response = JSON.parse(response); 
              }
              if(response.status === 'success') {
                  noty(response.text, response.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
                  $(e.target).closest('.adm_online_server').remove();
              } else {
                  noty(response.text, response.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
              }
          }
      });
  });
});

$(document).ready(function() {
  $('#online_settings_form').on('submit', function(e) {
      e.preventDefault();

      var formData = $(this).serialize();

      $.ajax({
          type: 'POST',
          url: $(this).attr('action'), 
          data: formData,
          success: function(response) {
              if (typeof response === 'string') {
                  response = JSON.parse(response); 
              }
              if (response.status === 'success') {
                  noty(response.text, response.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
              } else {
                  noty(response.text, response.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
              }
          }
      });
  });
});

$(document).ready(function() {
  $('#add_access').on('submit', function(e) {
      e.preventDefault(); 

      var formData = $(this).serialize();

      $.ajax({
          type: 'POST',
          url: $(this).attr('action'),
          data: formData,
          success: function(response) {
              if (typeof response === 'string') {
                response = JSON.parse(response); // Парсим JSON строку, если ответ в формате строки
              }

              if (response.status === 'success') {
                noty(response.text, response.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
              } else {
                noty(response.text, response.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
              }
          }
      });
  });
});

$(document).ready(function() {
  $('#update_settings_form').on('submit', function(e) {
      e.preventDefault();

      var formData = $(this).serialize();

      $.ajax({
          type: 'POST',
          url: $(this).attr('action'),
          data: formData,
          success: function(response) {
              if (typeof response === 'string') {
                response = JSON.parse(response);
              }

              if (response.status === 'success') {
                 noty(response.text, response.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
              } else {
                 noty(response.text, response.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
              }
          }
      });
  });
});

$(document).ready(function() {
  $('#deleteAccess').on('click', function(e) {
      e.preventDefault();

      var userId = $(this).attr('userId');

      $.ajax({
          type: 'POST',
          url: '/admins_online/settings/delete-access/',
          data: { id: userId },
          success: function(response) {
              if (typeof response === 'string') {
                  response = JSON.parse(response); 
              }
              if(response.status === 'success') {
                  noty(response.text, response.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
                  $(e.target).closest('.adm_online_server').remove();
              } else {
                  noty(response.text, response.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
              }
          }
      });
  });
});
