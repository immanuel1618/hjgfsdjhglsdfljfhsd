var url = domain + "app/modules/module_page_request/assets/js/editor/jquery.wysibb.js";
$.getScript(url, function() {
    if (lang) {
        var wbbOpt = {
            lang: lang.toLowerCase()
        }
        $("#editor").wysibb(wbbOpt)
    } else {
        $("#editor").wysibb()
    }
});

$('head').append('<link rel="stylesheet" rel="nofollow" href="' + domain + 'app/modules/module_page_request/assets/js/editor/theme/default/wbbtheme.css" type="text/css" />');

$(document).ready(function() {
    document.addEventListener("click", removeElem("col-md-7", "data-del", "delete"));
});

function SendAjax(form, func, param1, param2, param3) {
    if ($("#editor").html() != undefined) $("#editor").sync();
    $.ajax({
        url: domain + "app/modules/module_page_request/includes/js_controller.php",
        type: "POST",
        data: $(form).serialize() + "&function=" + func + "&param1=" + param1 + "&param2=" + param2 + "&param3=" + param3,
        success: function(response) {
            console.log("response" + response)
            var jsonData = $.parseJSON(response);
            console.log("jsonData" + jsonData)
            if (!(typeof jsonData.success === 'undefined')) {
                noty(jsonData.success, 'success')
                if (jsonData.location) {
                    setTimeout(function() { location.href = jsonData.location;; }, 2500);
                } else {
                    setTimeout(function() { location.href = location.href; }, 2500);
                }
            } else {
                setTimeout(function() { doubleClickedCon = true; }, 1000);
                noty(jsonData.error, 'error')
                PlaySound(domain + 'storage/assets/sounds/error.mp3');
            }
        }
    });
}


function removeElem(delElem, attribute, attributeName) {
    if (!(delElem && attribute && attributeName)) return;
    return function(e) {
        let target = e.target;
        if (!(target.hasAttribute(attribute) ?
                (target.getAttribute(attribute) === attributeName ? true : false) : false)) return;
        removeParam(target.getAttribute('data-get'));
        let elem = target;
        while (target != this) {
            if (target.classList.contains(delElem)) {
                target.remove();
                return;
            }
            target = target.parentNode;
        }
        return;
    };
}

function removeParam(key) {
    var splitUrl = window.location.href.split('?'),
        rtn = splitUrl[0],
        param,
        params_arr = [],
        queryString = (window.location.href.indexOf("?") !== -1) ? splitUrl[1] : '';
    if (queryString !== '') {
        params_arr = queryString.split('&');
        for (var i = params_arr.length - 1; i >= 0; i -= 1) {
            param = params_arr[i].split('=')[0];
            if (param === key) {
                params_arr.splice(i, 1);
            }
        }
        rtn = rtn + '?' + params_arr.join('&');
    }
    window.location.href = rtn;
}

var inputContainers = document.querySelectorAll('.input-container');

inputContainers.forEach(function(container) {
    var span = container.querySelector('span');
    if (span) {
        var width = span.offsetWidth;
        span.style.width = width + 'px';
    }
    var input = container.querySelector('input');
    if (input) {
        input.style.marginLeft = width + 'px';
    }
});

function get_request_data(i) {
    var modal = document.getElementById('request-text-' + i);
    $(modal).addClass('modal_show')
}

function close_modal(i) {
    var modal = document.getElementById('request-text-' + i);
    $(modal).removeClass('modal_show')
}

window.addEventListener("click", (e) => {
    if (event.target === document.querySelector(".modal_show")) {
        $(".modal_show").removeClass("modal_show");
    }
});