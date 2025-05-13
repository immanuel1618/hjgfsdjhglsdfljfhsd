let blockDel = 1;
function sendAjax(id, param) {
  $.ajax({
    url: location.href,
    type: "post",
    data: $("#" + id).serialize() + "&button=" + id + "&param=" + param,
    success: function (response) {
      var jsonData = JSON.parse(response);
      if (!(typeof jsonData.noBalance === "undefined")) {
        noty(
          jsonData.noBalance,
          "error",
          "..//storage/assets/sounds/error.mp3"
        );
        setTimeout(function () {
          window.location.href = domain + "pay";
        }, 3100);
      }
      // Добавление в корзину
      else if (!(typeof jsonData.addProductCart === "undefined")) {
        let priceString = jsonData.addProductCart.price;
        let price = parseFloat(priceString);
        price = Math.ceil(price);

        let newCart =
          '<div class="product product_user_' +
          jsonData.addProductCart.key +
          '">' +
          '<div class="product_leftinfo">' +
          '<div class="product_name">' +
          jsonData.addProductCart.title +
          "</div>" +
          '<div class="product_price">' +
          price +
          " " +
          jsonData.addProductCart.value +
          "</div>" +
          "</div>" +
          '<form id="clean-basket">' +
          "<div class=\"product_delete\" onclick=\"sendAjax('clean-basket', '" +
          jsonData.addProductCart.key +
          '\')"><svg viewBox="0 0 320 512"><path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z" /></svg></div>' +
          "</form>" +
          "</div>";
        $(".product_wrapper_cart").append(newCart);
        $(".circle_basket").text(+$(".circle_basket").text() + 1);
        let splitSumPrice = $(".product_price_sum_number").text().split(" ");
        $(".product_price_sum_number").text(
          parseInt(splitSumPrice[0]) +
            price +
            " " +
            jsonData.addProductCart.value
        );
        
        var shop_server_active = document.querySelector(".shop_server_active");
        if (shop_server_active) {
          var server_name = shop_server_active.textContent.trim();
        } else {
          var server_name = "Unknown";
        }
        $(".server_modal").text(server_name);

        let splitSumPrice_modals = $(".summ_modal").text().split(" ");
        $(".summ_modal").text(
          parseInt(splitSumPrice_modals[0]) +
            price +
            " " +
            jsonData.addProductCart.value
        );

        if (jsonData.addProductCart.cartState == "0") {
          $(".basket_empty").css({
            display: "none",
          });
          $(".container_basket").css({
            display: "block",
          });
          $(".product_wrapper_cart").css({
            display: "flex",
          });
        }
        noty(
          jsonData.addProductCart.translate,
          "success",
          "/app/modules/module_page_store/assets/sound/add.mp3"
        );
      }

      // Удаление товара из корзины
      else if (!(typeof jsonData.clean === "undefined")) {
        if (blockDel) {
          blockDel = 0;

          let price = $(".product_user_" + param)
            .find(".product_price")
            .text()
            .split(" ")[0];
          let splitSumPrice = $(".product_price_sum_number").text().split(" ");
          $(".product_price_sum_number").text(
            splitSumPrice[0] - price + " " + splitSumPrice[1]
          );
          let splitSumPrice_modals = $(".summ_modal").text().split(" ");
          $(".summ_modal").text(
            splitSumPrice_modals[0] - price + " " + splitSumPrice_modals[1]
          );
          $(".product_user_" + param).remove();
          $(".circle_basket").text($(".circle_basket").text() - 1);
          if (!$(".product").length) {
            $(".container_basket").css({
              display: "none",
            });
            $(".basket_empty").css({
              display: "flex",
            });
            $(".product_wrapper_cart").css({
              display: "none",
            });
          }
          setTimeout(function () {
            blockDel = 1;
          }, 500);
        }
      }

      // Подтверждение на изменение товара
      else if (!(typeof jsonData.edit === "undefined")) {
        $(".shop_table_edit_card").attr("data-value", param);
        editTable(jsonData);
      }

      // Подтверждение
      else if (!(typeof jsonData.success === "undefined")) {
        noty(jsonData.success, "success", "..//storage/assets/sounds/pay.mp3");
        setTimeout(function () {
          window.location = window.location.href;
        }, 2000);
      }

      //Ошибка
      else {
        noty(jsonData.error, "error", "..//storage/assets/sounds/error.mp3");
      }
    },
  });
  return false;
}

// Изменение товара
function editTable(data) {
  $("#title_edit_card").val(data.edit.title);
  $("#description_edit_card").val(
    data.edit.description.replace("<br/>", /\n/g)
  );
  $("#image_edit_path").val(data.edit.image);
  $("#price_edit_card").val(data.edit.price);
  $("#value_edit_card").val(data.edit.value);
  $("#time_edit_card").val(data.edit.time);
  $("#group_edit_card").val(data.edit.group_name);
  $("#amount_edit_card").val(data.edit.amount);
  $("#rcon_edit_command").val(data.edit.group_name);
  $("#web_group_" + data.edit.gid).prop("selected", true);
  $("#type_card_" + data.edit.type).prop("selected", true);
  $(".shop_black_screen").fadeIn();
  viewAdminPoints(data.edit.type);
  $(".shop_table_edit_card").fadeIn();
}

function viewAdminPoints(id) {
  $(".view-shop").hide();
  $(".view-shop-" + id).css("display", "block");
}

function showShopTable(id) {
  $(".shop_black_screen").fadeIn();
  $("." + id).fadeIn();
  viewAdminPoints(0);
}

$(document).ready(function () {
  $(".shop_black_screen").click(function () {
    hideShopTable("shop_table");
  });
});

function hideShopTable(id) {
  $("." + id).fadeOut();
  $(".shop_black_screen").fadeOut();
}

function showCatalog(id, elem) {
  $(".shop_row_cards").css({
    display: "none",
  });
  $(".shop_server_id_" + id).css({
    display: "grid",
  });
  $(".shop_server_active").removeClass("shop_server_active");
  $(elem).addClass("shop_server_active");
}

document.addEventListener("DOMContentLoaded", function () {
  const uniqueToggleSwitch = document.querySelector(".unique-toggle-switch");
  const uniqueSlider = document.querySelector(".unique-slider");
  const uniqueToggleInput = document.querySelector(".unique-toggle-input");
  const uniqueToggleInputContainer = document.querySelector(
    ".unique-toggle-input-container"
  );
  const uniqueToggleOptions = document.querySelectorAll(
    ".unique-toggle-option"
  );

  const defaultOption = document.querySelector(
    '.unique-toggle-option[data-value="for-self"]'
  );
  const defaultOffset = defaultOption.offsetLeft;

  uniqueSlider.style.left = defaultOffset + "px";
  uniqueToggleInput.style.opacity = 0;
  uniqueToggleInputContainer.style.height = "0";
  defaultOption.classList.add("active");

  uniqueToggleOptions.forEach((option) => {
    const value = option.getAttribute("data-value");
    option.style.color = option.classList.contains("active")
      ? value === "as-gift"
        ? "var(--money)"
        : "var(--span)"
      : "var(--text-custom)";
  });

  uniqueToggleSwitch.addEventListener("click", function (e) {
    const clickedOption = e.target.closest(".unique-toggle-option");
    if (!clickedOption) return;

    const value = clickedOption.getAttribute("data-value");
    const offset = clickedOption.offsetLeft;

    uniqueSlider.style.left = offset + "px";
    uniqueToggleInput.style.opacity = value === "as-gift" ? 1 : 0;
    uniqueToggleInputContainer.style.height =
      value === "as-gift" ? "auto" : "0";
    uniqueSlider.classList.toggle("as-gift", value === "as-gift");

    localStorage.setItem("selectedOption", value);

    uniqueToggleOptions.forEach((option) => {
      const optionValue = option.getAttribute("data-value");
      option.style.color =
        option === clickedOption
          ? value === "as-gift"
            ? "var(--money)"
            : "var(--span)"
          : "var(--text-custom)";
    });

    uniqueToggleInput.classList.toggle("hidden_gift", value !== "as-gift");
  });
});
