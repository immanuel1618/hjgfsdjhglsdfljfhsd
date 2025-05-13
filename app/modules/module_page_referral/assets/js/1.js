function FormManager(formSelector, options) {
    $(formSelector).on("submit", function(e) {
        e.preventDefault();

        if (options.beforeSubmit && typeof options.beforeSubmit === 'function') {
            if (options.beforeSubmit(this) === false) return;
        }
        
        const data = $(this).serialize() + "&" + options.param;
        
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
    });
}

FormManager("#ref", {
    param: "ref",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
	}
});

FormManager("#referral_settings_form", {
    param: "referral_settings_form",
    success: function(data) {
        if (data.status == "success") {
            noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
        } else {
            noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
        }
        if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
    },
    beforeSubmit: function(form) {
        const types = [];
        $(form).find('input[name="available_withdrawal_types[]"]').each(function() {
            const val = $(this).val().trim();
            if(val !== '') types.push(val);
        });
        $(form).find('#original_withdrawal_types').val(types.join(','));
        return true;
    }
});

FormManager("#referral_settings_lvl_form", {
    param: "referral_settings_lvl_form",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
	}
});

FormManager("#real-withdrawal-form", {
    param: "real-withdrawal-form",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
	}
});

FormManager("#site-withdrawal-form", {
    param: "site-withdrawal-form",
	success: function(data) {
		if (data.status == "success") {
			noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
		} else {
			noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
		}
		if (data.status == "success") setTimeout(function () { location.reload(); }, 3000);
	}
});

$(document).on('click', '#ref-request-delete-btn', function () {
	let button = $(this);
	const id_del = button.attr('id_del');
	$.ajax({
		type: 'post',
		url: location.href,
		data: { ref_request_delete_btn: true, id_del: id_del },
		dataType: 'json',
		global: false,
		success: function (data) {
			if (data.status == "success") {
				noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
			} else {
				noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
			}
			if (data.status === 'success') {
				button.closest('.user_card_bg').remove();
			}
		},
	});
});

$(document).on('click', '#ref-create-table', function () {
	$.ajax({
		type: 'post',
		url: location.href,
		data: { ref_create_table: true },
		dataType: 'json',
		global: false,
		success: function (data) {
			if (data.status == "success") {
				noty(data.text, data.status, domain + '/storage/assets/sounds/success2.mp3', 0.2)
			} else {
				noty(data.text, data.status, domain + '/storage/assets/sounds/error.mp3', 0.2)
			}
		},
	});
});

function selectOption(element) {
    if (element.classList.contains('disabled_ob')) {
        return;
    }

    document.querySelectorAll('.option-box').forEach(box => {
        box.classList.remove('active_ob');
    });
    
    element.classList.add('active_ob');
    
    const withdrawalType = element.getAttribute('data-type');
    const targetFormId = withdrawalType === '1' ? 'real-withdrawal-form' : 'site-withdrawal-form';
    const otherFormId = withdrawalType === '1' ? 'site-withdrawal-form' : 'real-withdrawal-form';
    
    const otherForm = $(`#${otherFormId}`);
    if (otherForm.css('display') !== 'none') {
        otherForm.slideUp(300);
    }
    
    const targetForm = $(`#${targetFormId}`);
    targetForm.slideDown(400);
}

document.querySelectorAll('.option-box').forEach(box => {
    box.addEventListener('click', function() {
        if (!this.classList.contains('disabled_ob')) {
            selectOption(this);
        }
    });
});



let currentRequestId = null;

const viewRequestModal = $('#viewRequestModal');

function loadRequestData(button) {
    const requestId = $(button).data('id');
    currentRequestId = requestId;
    
    $.ajax({
        url: location.href,
        type: 'POST',
        data: {
            get_request_data: true,
            request_id: requestId
        },
        dataType: 'json',
        global: false,
        success: function(response) {
            if (response.status === 'success') {
                viewRequestModal.html(response.html);
            }
        },
        error: function() {
            showErrorState('Ошибка соединения с сервером');
        }
    });
}
function showErrorState(message) {
    $('#modalLoading').html(
        '<div class="alert alert-danger">' +
        '<i class="fa fa-exclamation-circle"></i> ' +
        (message || 'Произошла ошибка при загрузке данных') +
        '</div>'
    );
}

function processRequest(action) {
    if (!currentRequestId) return;
    
    const reason = $('input[name="reason"]').val();
    
    $.ajax({
        url: location.href,
        type: 'POST',
        data: {
            action: action,
            request_id: currentRequestId,
            reason: reason
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                noty(response.text, 'success', domain + '/storage/assets/sounds/success2.mp3', 0.2);
                setTimeout(() => location.reload(), 1500);
            } else {
                noty(response.text, 'error', domain + '/storage/assets/sounds/error.mp3', 0.2);
            }
        },
        error: function() {
            noty('Произошла ошибка при обработке запроса', 'error', domain + '/storage/assets/sounds/error.mp3', 0.2);
        }
    });
}

$(document).ready(function() {
    $('#add-withdrawal-type').click(function() {
        const newItem = `
            <div class="withdrawal-type-item">
                <input type="text" name="available_withdrawal_types[]" placeholder="Введите тип вывода">
                <button type="button" class="remove-type-btn"><svg viewBox="0 0 320 512">
                                        <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"></path>
                                    </svg></button>
            </div>
        `;
        $('#withdrawal-types-container').append(newItem);
    });
    
    $(document).on('click', '.remove-type-btn', function() {
        $(this).closest('.withdrawal-type-item').remove();
    });
    
    function updateHiddenField() {
        const types = [];
        $('input[name="available_withdrawal_types[]"]').each(function() {
            const val = $(this).val().trim();
            if(val !== '') types.push(val);
        });
        $('#original_withdrawal_types').val(types.join(','));
    }

    $(document).on('input', 'input[name="available_withdrawal_types[]"]', updateHiddenField);
    updateHiddenField();
});