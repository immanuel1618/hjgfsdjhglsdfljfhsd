let limit = 20;
const pagepunishment = localStorage.getItem('pagepunishment') || 'bans';

function setupChoosingServers() {
  const options = document.querySelectorAll('input[name="sample"]');
  options.forEach(function (option) {
    option.addEventListener('change', function () {
      let selectedOption = document.querySelector('input[name="sample"]:checked').value;
      localStorage.setItem('pagepunishment', selectedOption);
    });
  });
  document.getElementById(pagepunishment).checked = true;
}

setupChoosingServers();

$(document).ready(function () {
  $(".hide_stats").click(function () {
    $(".punish_stats_list")
      .css({ height: $(".punish_stats_list").height() })
      .animate({ height: 0 }, 100);
    $(".hide_stats").hide();
    $(".show_stats").show();
  });

  $(".show_stats").click(function () {
    $(".punish_stats_list").animate(
      { height: $(".punish_stats_list")[0].scrollHeight },
      100
    );
    $(".hide_stats").show();
    $(".show_stats").hide();
  });

  function moveSelection() {
    $(".segmented-control .option input").each(function (i) {
      if ($(this).is(":checked")) {
        $(".segmented-control .selection").css(
          "transform",
          "translateX(" + $(this).outerWidth() * i + "px)"
        );
      }
    });
  }

  moveSelection();
  $(".segmented-control").on("change", function () {
    moveSelection();
  });

  function checkAndRenderAvatar(check_getavatar, sid) {
    if (check_getavatar === 1) {
      avatar.push(sid);
      RenderingAvatar();
    }
  }

  function loadDataFromDatabase(option, limit) {
    $.ajax({
      type: 'post',
      url: location.href,
      data: { list: true, page: option, limit: limit },
      dataType: 'json',
      success: function (data) {
        $('#search').html('');
        $('#search').append(data['search']);
        $('#punish_content').html('');
        for (let i = 0; i < data['html'].length; i++) {
          $('#punish_content').append(data['html'][i]['html_list']);
        }
        if (data['html'].length >= 20) {
          $('#punish_content').append('<div class="load_container"><div id="load_next">Загрузить еще</div><div class="update_element"><svg class="spinner" viewBox="0 0 50 50"><circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle></svg></div></div>');
        }
      }
    });
  }

  loadDataFromDatabase(pagepunishment, limit);

  $(document).on('click', '#load_next', function () {
    const pagepunishment = localStorage.getItem('pagepunishment') || 'bans';
    limit += 20;
    loadDataFromDatabase(pagepunishment, limit);
  });

  $('input[type="radio"][name="sample"]').change(function () {
    const ListContent = $('#punish_content');
    ListContent.scrollTop(0);
    const pagepunishment = localStorage.getItem('pagepunishment') || 'bans';
    loadDataFromDatabase(pagepunishment, limit);
    const searchBanValue = $('#search_ban').val();
    const searchMuteValue = $('#search_mute').val();
    if (!searchBanValue && !searchMuteValue) {
      $('#punishment_list_search').hide();
      $("#punish_content").show();
    }
    $('#search_ban').val('');
    $('#search_mute').val('');
    $('#punishment_list_search').hide();
    $("#punish_content").show();
  });

  $(document).on('click', '.modal_open', function () {
    const page = $(this).attr('page');
    const id = $(this).attr('id');
    $.ajax({
      type: 'post',
      url: location.href,
      data: { modal: true, id: id, page: page },
      dataType: 'json',
      success: function (data) {
        $('#punishModal').addClass("visible");
        $('#punishModal .punish_body').remove();
        $('#punishModal .popup_modal_content').append(data['html_modal']);
      }
    });
  });

  $(document).on('click', '.btn_unban', function () {
    const idpunish = $(this).attr('idpunish');
    const page = $(this).attr('page');
    const type = $(this).attr('type');
    const sid = $(this).attr('sid');
    $.ajax({
      type: 'post',
      url: location.href,
      data: { btn_unban: true, idpunish: idpunish, page: page, type: type, sid: sid },
      dataType: 'json',
      global: false,
      success: function (data) {
        if (data.status == "success") {
          noty(data.text, data.status)
        } else {
          noty(data.text, data.status)
        }
      },
    });
  });

  function delay(fn, ms) {
    let timer = 0;
    return function (...args) {
      clearTimeout(timer);
      timer = setTimeout(fn.bind(this, ...args), ms || 0);
    }
  }

  $(document).on('keyup', '#search_ban', delay(function (e) {
    let ban = this.value;
    SearchAjax(ban);
  }, 500));

  $(document).on('keyup', '#search_mute', delay(function (e) {
    let mute = this.value;
    SearchAjax("", mute);
  }, 500));

  function SearchAjax(ban = "", mute = "") {
    if (ban.length >= 1 || mute.length >= 1) {
      $.ajax({
        type: "POST",
        url: location.href,
        dataType: "json",
        data: "search_ban=" + ban + "&search_mute=" + mute,
        success: function (res) {
          $('#punishment_list_search').html('');
          try {
            if (res.length > 0) {
              for (i = 0; i < res.length; i++) {
                $('#punishment_list_search').append(res[i].search_html);
                checkAndRenderAvatar(res[i].check_getavatar, res[i].sid);
              }
              $('#punishment_list_search').show();
              $("#punish_content").hide();
            } else {
              $('#punishment_list_search').hide();
              $("#punish_content").hide();
            }
          } catch (e) {
            $('#punishment_list_search').hide();
            $("#punish_content").hide();
          }
        }
      });
      return false;
    } else {
      $('#punishment_list_search').hide();
      $("#punish_content").show();
    }
    return false;
  }
});