if ($("#nestable").length > 0) {
  !(function (d, h, p, l) {
    var a = "ontouchstart" in p,
      c = (function () {
        var t = p.createElement("div"),
          e = p.documentElement;
        if (!("pointerEvents" in t.style)) return !1;
        (t.style.pointerEvents = "auto"),
          (t.style.pointerEvents = "x"),
          e.appendChild(t);
        var s =
          h.getComputedStyle &&
          "auto" === h.getComputedStyle(t, "").pointerEvents;
        return e.removeChild(t), !!s;
      })(),
      s = {
        listNodeName: "ol",
        itemNodeName: "li",
        rootClass: "dd",
        listClass: "dd-list",
        itemClass: "dd-item",
        dragClass: "dd-dragel",
        handleClass: "dd-handle",
        placeClass: "dd-placeholder",
        noDragClass: "dd-nodrag",
        emptyClass: "dd-empty",
        group: 0,
        maxDepth: 5,
        threshold: 20,
      };

    function i(t, e) {
      (this.w = d(p)),
        (this.el = d(t)),
        (this.options = d.extend({}, s, e)),
        this.init();
    }

    (i.prototype = {
      init: function () {
        var s = this;
        s.reset(),
          s.el.data("nestable-group", this.options.group),
          (s.placeEl = d('<div class="' + s.options.placeClass + '"/>')),
          d.each(this.el.find(s.options.itemNodeName), function (t, e) {
            s.setParent(d(e));
          }),
          s.el.on("click", "button", function (t) {
            if (!s.dragEl) {
              var e = d(t.currentTarget);
              e.data("action"), e.parent(s.options.itemNodeName);
            }
          });
        var t = function (t) {
          var e = d(t.target);
          if (!e.hasClass(s.options.handleClass)) {
            if (e.closest("." + s.options.noDragClass).length) return;
            e = e.closest("." + s.options.handleClass);
          }
          e.length &&
            !s.dragEl &&
            ((s.isTouch = /^touch/.test(t.type)),
              (s.isTouch && 1 !== t.touches.length) ||
              (t.preventDefault(),
                s.dragStart(t.touches ? t.touches[0] : t)));
        },
          e = function (t) {
            s.dragEl && s.dragMove(t.touches ? t.touches[0] : t);
          },
          i = function (t) {
            s.dragEl &&
              (t.preventDefault(), s.dragStop(t.touches ? t.touches[0] : t));
          };
        a &&
          (s.el[0].addEventListener("touchstart", t, !1),
            h.addEventListener("touchmove", e, !1),
            h.addEventListener("touchend", i, !1),
            h.addEventListener("touchcancel", i, !1)),
          s.el.on("mousedown", t),
          s.w.on("mousemove", e),
          s.w.on("mouseup", i);
      },
      serialize: function () {
        var i = this;
        return (
          (step = function (t, e) {
            var s = [];
            return (
              t.children(i.options.itemNodeName).each(function () {
                var t = d(this),
                  e = d.extend({}, t.data());
                t.children(i.options.listNodeName);
                s.push(e);
              }),
              s
            );
          }),
          step(i.el.find(i.options.listNodeName).first(), 0)
        );
      },
      serialise: function () {
        return this.serialize();
      },
      reset: function () {
        (this.mouse = {
          offsetX: 0,
          offsetY: 0,
          startX: 0,
          startY: 0,
          lastX: 0,
          lastY: 0,
          nowX: 0,
          nowY: 0,
          distX: 0,
          distY: 0,
          dirAx: 0,
          dirX: 0,
          dirY: 0,
          lastDirX: 0,
          lastDirY: 0,
          distAxX: 0,
          distAxY: 0,
        }),
          (this.isTouch = !1),
          (this.moving = !1),
          (this.dragEl = null),
          (this.dragRootEl = null),
          (this.dragDepth = 0),
          (this.hasNewRoot = !1),
          (this.pointEl = null);
      },
      expandAll: function () {
        var t = this;
        t.el.find(t.options.itemNodeName).each(function () {
          t.expandItem(d(this));
        });
      },
      setParent: function (t) { },
      unsetParent: function (t) { },
      dragStart: function (t) {
        var e = this.mouse,
          s = d(t.target),
          i = s.closest(this.options.itemNodeName);
        this.placeEl.css("height", i.height()),
          (e.offsetX = t.offsetX !== l ? t.offsetX : t.pageX - s.offset().left),
          (e.offsetY = t.offsetY !== l ? t.offsetY : t.pageY - s.offset().top),
          (e.startX = e.lastX = t.pageX),
          (e.startY = e.lastY = t.pageY),
          (this.dragRootEl = this.el),
          (this.dragEl = d(p.createElement(this.options.listNodeName)).addClass(
            this.options.listClass + " " + this.options.dragClass
          )),
          this.dragEl.css("width", i.width()),
          i.after(this.placeEl),
          i[0].parentNode.removeChild(i[0]),
          i.appendTo(this.dragEl),
          d(p.body).append(this.dragEl),
          this.dragEl.css({
            left: t.pageX - e.offsetX,
            top: t.pageY - e.offsetY,
          });
        var a,
          o,
          n = this.dragEl.find(this.options.itemNodeName);
        for (a = 0; a < n.length; a++)
          (o = d(n[a]).parents(this.options.listNodeName).length) >
            this.dragDepth && (this.dragDepth = o);
      },
      dragStop: function (t) {
        var e = this.dragEl.children(this.options.itemNodeName).first();
        e[0].parentNode.removeChild(e[0]),
          this.placeEl.replaceWith(e),
          this.dragEl.remove(),
          this.el.trigger("change"),
          this.hasNewRoot && this.dragRootEl.trigger("change"),
          this.reset();
      },
      dragMove: function (t) {
        var e,
          s = this.options,
          i = this.mouse;
        this.dragEl.css({
          left: t.pageX - i.offsetX,
          top: t.pageY - i.offsetY,
        }),
          (i.lastX = i.nowX),
          (i.lastY = i.nowY),
          (i.nowX = t.pageX),
          (i.nowY = t.pageY),
          (i.distX = i.nowX - i.lastX),
          (i.distY = i.nowY - i.lastY),
          (i.lastDirX = i.dirX),
          (i.lastDirY = i.dirY),
          (i.dirX = 0 === i.distX ? 0 : 0 < i.distX ? 1 : -1),
          (i.dirY = 0 === i.distY ? 0 : 0 < i.distY ? 1 : -1);
        var a = Math.abs(i.distX) > Math.abs(i.distY) ? 1 : 0;
        if (!i.moving) return (i.dirAx = a), void (i.moving = !0);
        i.dirAx !== a
          ? ((i.distAxX = 0), (i.distAxY = 0))
          : ((i.distAxX += Math.abs(i.distX)),
            0 !== i.dirX && i.dirX !== i.lastDirX && (i.distAxX = 0),
            (i.distAxY += Math.abs(i.distY)),
            0 !== i.dirY && i.dirY !== i.lastDirY && (i.distAxY = 0)),
          (i.dirAx = a);
        var o = !1;
        if (
          (c || (this.dragEl[0].style.visibility = "hidden"),
            (this.pointEl = d(
              p.elementFromPoint(
                t.pageX - p.body.scrollLeft,
                t.pageY - (h.pageYOffset || p.documentElement.scrollTop)
              )
            )),
            c || (this.dragEl[0].style.visibility = "visible"),
            this.pointEl.hasClass(s.handleClass) &&
            (this.pointEl = this.pointEl.parent(s.itemNodeName)),
            this.pointEl.hasClass(s.emptyClass))
        )
          o = !0;
        else if (!this.pointEl.length || !this.pointEl.hasClass(s.itemClass))
          return;
        var n = this.pointEl.closest("." + s.rootClass),
          l = this.dragRootEl.data("nestable-id") !== n.data("nestable-id");
        if (!i.dirAx || l || o) {
          if (l && s.group !== n.data("nestable-group")) return;
          if (
            this.dragDepth - 1 + this.pointEl.parents(s.listNodeName).length >
            s.maxDepth
          )
            return;
          var r =
            t.pageY < this.pointEl.offset().top + this.pointEl.height() / 2;
          this.placeEl.parent(),
            o
              ? ((e = d(p.createElement(s.listNodeName)).addClass(
                s.listClass
              )).append(this.placeEl),
                this.pointEl.replaceWith(e))
              : r
                ? this.pointEl.before(this.placeEl)
                : this.pointEl.after(this.placeEl),
            this.dragRootEl.find(s.itemNodeName).length ||
            this.dragRootEl.append('<div class="' + s.emptyClass + '"/>'),
            l &&
            ((this.dragRootEl = n),
              (this.hasNewRoot = this.el[0] !== this.dragRootEl[0]));
        }
      },
    }),
      (d.fn.nestable = function (e) {
        var s = this;
        return (
          this.each(function () {
            var t = d(this).data("nestable");
            t
              ? "string" == typeof e &&
              "function" == typeof t[e] &&
              (s = t[e]())
              : (d(this).data("nestable", new i(this, e)),
                d(this).data("nestable-id", new Date().getTime()));
          }),
          s || this
        );
      });
  })(window.jQuery || window.Zepto, window, document),
    $(document).ready(function () {
      var t = function (t) {
        var e = t.length ? t : $(t.target),
          s = e.data("output");
        window.JSON
          ? s.val(window.JSON.stringify(e.nestable("serialize")))
          : s.val("JSON browser support required for this demo.");
      };
      $("#nestable").nestable({ group: 1 }).on("change", t),
        t($("#nestable").data("output", $("#nestable-output")));
    }),
    $(document).ready(function () {
      $("#load").hide(),
        $(".dd").on("change", function () {
          $("#load").show();
          var t = { data: $("#nestable-output").val() };
          $.ajax({
            type: "POST",
            url: window.location.href,
            data: t,
            cache: !1,
            success: function (t) {
              $("#load").hide();
            },
            error: function (t, e, s) { },
          });
        });
    });
}

function delete_server(element) {
  $.post(window.location.href, { del_server: element.closest("li").id });
  noty("Сервер удалён", "success");
  element.closest("li").remove();
}

function action_db_delete_table(id, element) {
  $.post(window.location.href, { function: "delete", table: element });
  noty("Таблица удалена", "success");
  id.closest("li").remove();
  $("li." + element).remove();
}

function action_db_delete_mod(id, element) {
  $.post(window.location.href, { function: "delete", table: element });
  noty("Мод удален", "success");
  id.closest("div").remove();
  $("div." + element).remove();
}

let doubleClickedCon = true;
function addConection() {
  if (doubleClickedCon) {
    doubleClickedCon = false;
    $.ajax({
      url: window.location.href,
      type: "post",
      data: $("#form-add-conection").serialize() + "&function=add_conection",
      success: function (response) {
        var jsonData = JSON.parse(response);
        if (!(typeof jsonData.success === "undefined")) {
          noty(jsonData.success, "success");
          setTimeout(function () {
            window.location = window.location.href.replace(
              window.location.hash,
              "#"
            );
            location.reload(true);
          }, 2000);
        } else {
          setTimeout(function () {
            doubleClickedCon = true;
          }, 1000);
          noty(jsonData.error, "error");
        }
      },
    });
  }
}

Admin("#form-edit-conection", {
  param: "form-edit-conection",
  success: function (data) {
    if (typeof noty === "function") {
      if (data.status == "success") {
        noty(
          data.text,
          data.status,
          domain + "/storage/assets/sounds/success2.mp3",
          0.2
        );
      } else {
        noty(
          data.text,
          data.status,
          domain + "/storage/assets/sounds/error.mp3",
          0.2
        );
      }
    } else {
      note({ content: data.text, type: data.status, time: 3 });
    }
    if (data.status == "success")
      setTimeout(function () {
        window.location.href = "/adminpanel/?section=db";
      }, 3000);
  },
});

function changeConnection(mod) {
  document.getElementById("con_mod_name").innerHTML = "Мод: " + mod;
  document.getElementById("con_mod_id").value = mod;
  document
    .getElementById("add_conection_button")
    .setAttribute("href", "#add_connect");
  document
    .getElementById("custom_mod_wrapper")
    .setAttribute("style", "display: none;");
  document.getElementById("con_table_name").value = "";
  document
    .getElementById("rank_pack_connection")
    .setAttribute("style", "display: none;");

  if (mod == "custom") {
    document
      .getElementById("custom_mod_wrapper")
      .setAttribute("style", "display: block;");
  }
  let db_hide = document.querySelectorAll(".con_active");
  for (let i = 0; i < db_hide.length; i++) {
    db_hide[i].classList.remove("con_active");
  }
  let db_show = document.querySelectorAll(".con_" + mod);
  for (let i = 0; i < db_show.length; i++) {
    db_show[i].classList.add("con_active");
  }
  if (mod == "LevelsRanks") {
    document.getElementById("con_table_name").value = "lvl_base";
    document
      .getElementById("rank_pack_connection")
      .setAttribute("style", "display: block;");
  } else if (mod == "Vips") {
    document.getElementById("con_table_name").value = "vip_";
  } else if (mod == "IksAdmin") {
    document.getElementById("con_table_name").value = "iks_";
  } else if (mod == "AdminSystem") {
    document.getElementById("con_table_name").value = "as_";
  } else if (mod == "lk") {
    document.getElementById("con_table_name").value = "lk";
  } else if (mod == "Reports") {
    document.getElementById("con_table_name").value = "rs_";
  }
}

function changeNameModule() {
  let val = document.getElementById("mods").value;
  let db_show = document.querySelectorAll(
    ".con_" + document.getElementById("custom_mod_name").value
  );
  for (let i = 0; i < db_show.length; i++) {
    db_show[i].classList.add("con_active");
  }
  if (val == "custom") {
    document.getElementById("con_mod_name").innerHTML =
      "Mod: " + document.getElementById("custom_mod_name").value;
    document.getElementById("con_mod_id").value =
      document.getElementById("custom_mod_name").value;
  }
}
function show_hide_password(target) {
  var input = document.getElementById("con_password");
  if (input.getAttribute("type") == "password") {
    target.classList.add("view");
    input.setAttribute("type", "text");
  } else {
    target.classList.remove("view");
    input.setAttribute("type", "password");
  }
  return false;
}

function show_hide_password_edit(target) {
  var input = document.getElementById("con_password_edit");
  if (input.getAttribute("type") == "password") {
    target.classList.add("view");
    input.setAttribute("type", "text");
  } else {
    target.classList.remove("view");
    input.setAttribute("type", "password");
  }
  return false;
}

function Admin(formSelect, options) {
  $(formSelect).on("submit", (e) => {
    e.preventDefault();
    const formData = new FormData($(e.currentTarget)[0]);
    formData.append(options.param, "settings_modules");
    $.ajax({
      type: "post",
      url: location.href,
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (data) {
        options.success(data);
      },
      error: function () {
        return false;
      },
    });
    return false;
  });
}

Admin("#options_one", {
  param: "options_one",
  success: function (data) {
    if (data.status == "success") {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/success2.mp3",
        0.2
      );
    } else {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/error.mp3",
        0.2
      );
    }
  },
});

Admin("#add_point", {
  param: "add_point",
  success: function (data) {
    if (data.status == "success") {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/success2.mp3",
        0.2
      );
      setTimeout(function () {
        location.reload();
      }, 3000);
    } else {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/error.mp3",
        0.2
      );
    }
  },
});

Admin("#settings_modules", {
  param: "settings_modules",
  success: function (data) {
    if (data.status == "success") {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/success2.mp3",
        0.2
      );
    } else {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/error.mp3",
        0.2
      );
    }
  },
});

Admin("#edit_point", {
  param: "edit_point",
  success: function (data) {
    if (data.status == "success") {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/success2.mp3",
        0.2
      );
      setTimeout(function () {
        window.location.href = "/adminpanel/?section=template";
      }, 3000);
    } else {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/error.mp3",
        0.2
      );
    }
  },
});

Admin("#add_info", {
  param: "add_info",
  success: function (data) {
    if (data.status == "success") {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/success2.mp3",
        0.2
      );
      setTimeout(function () {
        window.location.href = "/adminpanel/?section=template";
      }, 3000);
    } else {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/error.mp3",
        0.2
      );
    }
  },
});

$(document).on("click", "#point_del", function () {
  let button = $(this);
  const id_del = button.attr("id_del");
  $.ajax({
    type: "post",
    url: location.href,
    data: { point_del: true, id_del: id_del },
    dataType: "json",
    global: false,
    success: function (data) {
      if (data.status == "success") {
        noty(
          data.text,
          data.status,
          domain + "/storage/assets/sounds/success2.mp3",
          0.2
        );
        button.closest(".adm_nav_cat_point").remove();
        button.closest(".adm_nav_point").remove();
      } else {
        noty(
          data.text,
          data.status,
          domain + "/storage/assets/sounds/error.mp3",
          0.2
        );
      }
    },
  });
});

$(document).on("click", "#category_del", function () {
  let button = $(this);
  const id_del = button.attr("id_del");
  $.ajax({
    type: "post",
    url: location.href,
    data: { category_del: true, id_del: id_del },
    dataType: "json",
    global: false,
    success: function (data) {
      if (data.status == "success") {
        noty(
          data.text,
          data.status,
          domain + "/storage/assets/sounds/success2.mp3",
          0.2
        );
        button.closest(".adm_nav_cat_point").remove();
      } else {
        noty(
          data.text,
          data.status,
          domain + "/storage/assets/sounds/error.mp3",
          0.2
        );
      }
    },
  });
});


$(document).on("click", "#baner_del", function () {
  let button = $(this);
  const id_del = button.attr("id_del");
  $.ajax({
    type: "post",
    url: location.href,
    data: { baner_del: true, id_del: id_del },
    dataType: "json",
    global: false,
    success: function (data) {
      if (data.status == "success") {
        noty(
          data.text,
          data.status,
          domain + "/storage/assets/sounds/success2.mp3",
          0.2
        );
        button.closest(".banner_content").remove();
      } else {
        noty(
          data.text,
          data.status,
          domain + "/storage/assets/sounds/error.mp3",
          0.2
        );
      }
    },
  });
});

Admin("#create_table", {
  param: "create_table",
  success: function (data) {
    if (data.status == "success") {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/success2.mp3",
        0.2
      );
    } else {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/error.mp3",
        0.2
      );
    }
    if (data.status == "success")
      setTimeout(function () {
        window.location.href = mess.location;
      }, 3000);
  },
});

Admin("#create_table_noty", {
  param: "create_table_noty",
  success: function (data) {
    if (data.status == "success") {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/success2.mp3",
        0.2
      );
      $('.w100').closest(".w100").remove();
    } else {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/error.mp3",
        0.2
      );
    }
  },
});

Admin("#hide_filter_form", {
  param: "hide_filter_form",
  success: function (data) {
    if (data.status == "success") {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/success2.mp3",
        0.2
      );
    } else {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/error.mp3",
        0.2
      );
    }
  },
});

Admin("#stretch_filter_form", {
  param: "stretch_filter_form",
  success: function (data) {
    if (data.status == "success") {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/success2.mp3",
        0.2
      );
    } else {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/error.mp3",
        0.2
      );
    }
  },
});

Admin("#hide_city_form", {
  param: "hide_city_form",
  success: function (data) {
    if (data.status == "success") {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/success2.mp3",
        0.2
      );
    } else {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/error.mp3",
        0.2
      );
    }
  },
});

Admin("#hide_country_form", {
  param: "hide_country_form",
  success: function (data) {
    if (data.status == "success") {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/success2.mp3",
        0.2
      );
    } else {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/error.mp3",
        0.2
      );
    }
  },
});

$(document).ready(function () {
  $("#stretch_filter").change(function () {
    $("#stretch_filter_form").submit();
  });
  $("#hide_filter").change(function () {
    $("#hide_filter_form").submit();
  });
  $("#hide_city").change(function () {
    $("#hide_city_form").submit();
  });
  $("#hide_country").change(function () {
    $("#hide_country_form").submit();
  });
  const fileInput = $('#file-input');
  const fileInfo = $('#file-info');

  fileInput.on('change', function (event) {
    const file = event.target.files[0];
    if (file) {
      fileInfo.text(`${file.name}`).show();
    }
  });
});

var copyip = new ClipboardJS(".copyuserip");
copyip.on("success", function (e) {
  noty(
    "IP скопирован в буфер обмена",
    "success",
    "/storage/assets/sounds/copy.mp3",
    0.2
  );
  e.clearSelection();
});

var copyip = new ClipboardJS(".copy_log");
copyip.on("success", function (e) {
  noty(
    "Лог скопирован в буфер обмена",
    "success",
    "/storage/assets/sounds/copy.mp3",
    0.2
  );
  e.clearSelection();
});

Admin("#all_del_logs", {
  param: "all_del_logs",
  success: function (data) {
    if (data.status == "success") {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/success2.mp3",
        0.2
      );
      $('.btn_delete').closest(".btn_delete").remove();
      $('.lk_logs_wrap').closest(".lk_logs_wrap").remove();
    } else {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/error.mp3",
        0.2
      );
    }
  }
});

Admin("#all_del_logs_ref", {
  param: "all_del_logs_ref",
  success: function (data) {
    if (data.status == "success") {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/success2.mp3",
        0.2
      );
      $('.btn_delete').closest(".btn_delete").remove();
      $('.lk_logs_wrap').closest(".lk_logs_wrap").remove();
    } else {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/error.mp3",
        0.2
      );
    }
  }
});

Admin("#all_del_logs_lk", {
  param: "all_del_logs_lk",
  success: function (data) {
    if (data.status == "success") {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/success2.mp3",
        0.2
      );
      $('.btn_delete').closest(".btn_delete").remove();
      $('.lk_logs_wrap').closest(".lk_logs_wrap").remove();
    } else {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/error.mp3",
        0.2
      );
    }
  }
});

Admin("#settings_modules_core", {
  param: "settings_modules_core",
  success: function (data) {
    if (data.status == "success") {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/success2.mp3",
        0.2
      );
    } else {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/error.mp3",
        0.2
      );
    }
  },
});

Admin("#clear_modules_initialization", {
  param: "clear_modules_initialization",
  success: function (data) {
    if (data.status == "success") {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/success2.mp3",
        0.2
      );
    } else {
      noty(
        data.text,
        data.status,
        domain + "/storage/assets/sounds/error.mp3",
        0.2
      );
    }
  },
});

$(document).on("click", "#log_del_lk", function () {
  let button = $(this);
  const id_del = button.attr("id_del");
  $.ajax({
    type: "post",
    url: location.href,
    data: { log_del_lk: true, id: id_del },
    dataType: "json",
    global: false,
    success: function (data) {
      if (data.status == "success") {
        noty(
          data.text,
          data.status,
          domain + "/storage/assets/sounds/success2.mp3",
          0.2
        );
      } else {
        noty(
          data.text,
          data.status,
          domain + "/storage/assets/sounds/error.mp3",
          0.2
        );
      }
      if (data.status === "success") {
        button.closest("div").remove();
      }
    },
  });
});

$(document).on("click", "#log_del", function () {
  let button = $(this);
  const id_del = button.attr("id_del");
  $.ajax({
    type: "post",
    url: location.href,
    data: { log_del: true, id: id_del },
    dataType: "json",
    global: false,
    success: function (data) {
      if (data.status == "success") {
        noty(
          data.text,
          data.status,
          domain + "/storage/assets/sounds/success2.mp3",
          0.2
        );
      } else {
        noty(
          data.text,
          data.status,
          domain + "/storage/assets/sounds/error.mp3",
          0.2
        );
      }
      if (data.status === "success") {
        button.closest("div").remove();
      }
    },
  });
});

$(document).on("click", "#log_del_ref", function () {
  let button = $(this);
  const id_del = button.attr("id_del");
  $.ajax({
    type: "post",
    url: location.href,
    data: { log_del_ref: true, id: id_del },
    dataType: "json",
    global: false,
    success: function (data) {
      if (data.status == "success") {
        noty(
          data.text,
          data.status,
          domain + "/storage/assets/sounds/success2.mp3",
          0.2
        );
      } else {
        noty(
          data.text,
          data.status,
          domain + "/storage/assets/sounds/error.mp3",
          0.2
        );
      }
      if (data.status === "success") {
        button.closest("div").remove();
      }
    },
  });
});
$('#categorySelect').on('change', function() {
  if ($(this).val()) {
      $('#sortDiv').hide();
      $('#descriptionDiv').show();
      $('#sortCategoryDiv').show();
  } else {
      $('#sortDiv').show();
      $('#descriptionDiv').hide();
      $('#sortCategoryDiv').hide();
  }
});
if ($('#categorySelect').val()) {
  $('#sortDiv').hide();
  $('#descriptionDiv').show();
  $('#sortCategoryDiv').show();
} else {
  $('#sortDiv').show();
  $('#descriptionDiv').hide();
  $('#sortCategoryDiv').hide();
}