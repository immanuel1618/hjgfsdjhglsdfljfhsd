$("#checkbox").click(function () {
  if ($("#checkbox").is(":checked")) {
    $("#paybutton").prop("disabled", false);
    $("#paybutton").removeClass("btn_disabled");
  } else {
    $("#paybutton").prop("disabled", true);
    $("#paybutton").addClass("btn_disabled");
  }
});

let copypromo = new ClipboardJS(".copybtn");
copypromo.on("success", function (e) {
  noty("Промокод скопирован", "success", "/storage/assets/sounds/copy.mp3");
  e.clearSelection();
});

let copyurl = new ClipboardJS(".copyurl");
copyurl.on("success", function (e) {
  noty("URL скопирован", "success", "/storage/assets/sounds/copy.mp3");
  e.clearSelection();
});

document.querySelectorAll(".preset-amount").forEach(function (button) {
  button.addEventListener("click", function () {
    if (!this.classList.contains("delete-amount")) {
      document.querySelectorAll(".preset-amount").forEach(function (btn) {
        btn.classList.remove("active");
      });
      this.classList.add("active");
      document.querySelector('input[name="amount"]').value =
        this.getAttribute("data-amount");
    }
  });
});

document.getElementById("clearButton").onclick = function (e) {
  document.querySelectorAll(".preset-amount").forEach(function (btn) {
    btn.classList.remove("active");
  });
  document.querySelector('input[name="amount"]').value = "";
};

$(document).ready(function () {
  $(".copybtn").on("click", function () {
    let $promocodeInput = $('input[name="promocode"]');
    $promocodeInput.val($(this).attr("data-promocode"));
    $promocodeInput.trigger("input");

    let $this = $(this);
    let originalText = $this.html();

    let appliedText = $(
      '<span style="color: var(--green);">Промокод применен!</span>'
    );

    $this.addClass("hidden");

    setTimeout(function () {
      $this.html(appliedText);
      $this.removeClass("hidden");

      setTimeout(function () {
        $this.addClass("hidden");

        setTimeout(function () {
          $this.html(originalText);
          $this.removeClass("hidden");
        }, 500);
      }, 1000);
    }, 500);
  });

  $("#ClearPromo").on("click", function () {
    let $promocodeInput = $('input[name="promocode"]');
    $promocodeInput.val("");
    $promocodeInput.trigger("input");
  });
});