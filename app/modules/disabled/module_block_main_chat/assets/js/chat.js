$(document).ready(function() {
    function chat_handler() {
        let $modalOknoChat = $("#modal_okno_chat"),
            $chatBackground = $(".chat_background"),
            $chatOpen = $(".chat_open"),
            $chatMainContent = $("#chat_main_content");
        if ($modalOknoChat.hasClass("show")) {
            $modalOknoChat.removeClass("show");
            $chatBackground.removeClass("show");
            $chatOpen.show(200);
        } else {
            $modalOknoChat.addClass("show");
            $chatBackground.addClass("show");
            $chatMainContent.animate({
                scrollTop: $chatMainContent.prop("scrollHeight")
            }, 500);
            mentions_handler();
            $chatOpen.hide(200);
        }
    }

    function mentions_handler() {
        let sound = false;
        const chatAlertVal = $("#chat_alert").val();
        const $chatCount = $("#chat_count");
        const localStorageKey = 'sound_';
        const chatSounds = localStorage.getItem('chat_sounds');
        $('a[id_steam="' + chatAlertVal + '"]').each((index, element) => {
            const idTime = $(element).attr("id_time");
            const soundKey = localStorageKey + idTime;
            if (localStorage.getItem(soundKey) === null) {
                localStorage.setItem(soundKey, 1);
                sound = true;
                if ($chatCount.length) {
                    $chatCount.text(Number($chatCount.text()) + 1);
                } else {
                    $(".chat_open").prepend("<span id='chat_count'>1</span>");
                }
            }
        });
        if (sound && chatSounds == 1) {
            const audioPath = '/app/modules/module_block_main_chat/assets/sound/new_msg.mp3';
            if (typeof noty === "function") {
                noty(chat_notified, 'success', '/storage/assets/sounds/success2.mp3', 0.2);
            } else {
                note({ content: chat_notified, type: 'info', time: 30 });
            }
            playAudio(audioPath);
        }
    }

    function playAudio(url) {
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const audioSource = audioContext.createBufferSource();
        const gainNode = audioContext.createGain();
        fetch(url)
        .then(response => response.arrayBuffer())
        .then(buffer => audioContext.decodeAudioData(buffer))
        .then(decodedData => {
            audioSource.buffer = decodedData;
            audioSource.connect(gainNode);
            gainNode.connect(audioContext.destination);
            gainNode.gain.setValueAtTime(0.05, audioContext.currentTime);
            audioSource.start();
        })
        .catch(error => console.error('Ошибка при загрузке и воспроизведении аудио:', error));
    }

    function get_onlines() {
        const $chatPeoples = $(".chat_peoples");
        const firstImgDataMention = $chatPeoples.find("img:first").prop("data-mention");
        const chatPeoplesLength = $chatPeoples.find("img").length;
        $.ajax({
            type: 'post',
            url: location.href,
            data: { get_onlines: 1, get_prev: firstImgDataMention, get_count: chatPeoplesLength },
            dataType: "json",
            success: function(data) {
                if (data.html && data.html !== "") {
                    $chatPeoples.html(data.html);
                    if (typeof Tippy_content === "function") {
                        Tippy_content();
                    }
                }
            }
        });
    }
    setInterval(get_onlines, 15000);

    function startCountdown(countDownSeconds) {
        interval = setInterval(function () {
            countDownSeconds--;
            $(".time_sec_msg").html(countDownSeconds + ' s.');
            if (countDownSeconds === 0) {
                clearInterval(interval);
            }
        }, 1000);
    }

    let isSending = false, interval;
    function send_message(msg) {
        if (isSending || !msg) { return; }
        const now = new Date().getTime();
        const last_msg_time = localStorage.getItem('lastSentTime');
        let last_time_sec = Math.round((last_msg_time - now) / 1000);
        if (last_msg_time && now < last_msg_time) {
            if (interval) {
                clearInterval(interval);
            }
            startCountdown(last_time_sec);
            if (typeof noty === "function") {
                noty(chat_msg_time + ' <a class="time_sec_msg">' + last_time_sec + ' s.</a>', 'error', '/storage/assets/sounds/success2.mp3', 0.2);
            } else {
                note({ content: chat_msg_time + ' <a class="time_sec_msg">' + last_time_sec + ' s.</a>', type: 'error', time: last_time_sec });
            }
            return;
        }
        isSending = true;
        $.post(location.href, { send_message: msg }, (res) => {
            isSending = false;
            if (res.includes('"error"')) {
                const data = JSON.parse(res);
                if (typeof noty === "function") {
                    noty(data.text, data.status, '/storage/assets/sounds/success2.mp3', 0.2);
                } else {
                    note({ content: data.text, type: data.status });
                }
            } else {
                $("#msg_input").val("");
                $("#chat_count").remove();
                get_messages(1, 1);
                requestAnimationFrame(function() {
                    const chatContent = $("#chat_main_content");
                    chatContent.scrollTop(chatContent.prop("scrollHeight"));
                });
                const lastSentTime = now + (10 * 1000);
                localStorage.setItem('lastSentTime', lastSentTime);
            }
        });
    }

    function get_messages(num_messages, new_message) {
        $.ajax({
            type: 'post',
            url: location.href,
            data: { get_messages: 1, num_messages: num_messages, new_message: new_message },
            dataType: "json",
            success: function(data) {
                messages_count = $(".chat_message, .chat_message_my").length;
                if (messages_count == data.count) {
                    return;
                }
                const chatContent = $("#chat_main_content");
                const shouldScrollToBottom = chatContent.prop('scrollHeight') - chatContent.scrollTop() === chatContent.innerHeight();
                const prevScrollHeight = chatContent.prop("scrollHeight");
                chatContent.attr("time-chat", data.timestamp);
                if (num_messages == 0) {
                    chatContent.empty();
                    chatContent.append(data.html);
                } else if(new_message == 1) {
                    chatContent.find(".chat_no_msg").remove();
                    chatContent.append(data.html);
                } else {
                    chatContent.prepend(data.html);
                }
                const newScrollHeight = chatContent.prop("scrollHeight");
                if (shouldScrollToBottom) {
                    chatContent.scrollTop(newScrollHeight);
                } else {
                    chatContent.scrollTop(chatContent.scrollTop() + newScrollHeight - prevScrollHeight);
                }
                mentions_handler();
            }
        });
    }
    get_messages(0, 0);

    let num_null = 0;
    let numMessages = num_null;

    $("#chat_main_content").on("scroll", function () {
        const chatContent = $(this);
        if (chatContent.scrollTop() === 0) { numMessages += 10; get_messages(numMessages, 0); }
    });

    let isActive = true;
    function update_check() {
        if (!isActive) { return; }
        let chatMainContent = document.getElementById("chat_main_content");
        let timeChatValue = chatMainContent.getAttribute("time-chat");
        $.post(location.href, { update_check: timeChatValue }, (res) => {
            try {
                let data = JSON.parse(res);
                if (data === true) { get_messages(0, 0); numMessages = num_null; mentions_handler(); }
            } catch (error) { }
        });
    }
    let timerInterval;
    function handleVisibilityChange() {
        if (document.hidden) {
            clearInterval(timerInterval); isActive = false;
        } else {
            isActive = true; timerInterval = setInterval(update_check, 1000);
        }
    }
    document.addEventListener("visibilitychange", handleVisibilityChange);
    timerInterval = setInterval(update_check, 1000);

    function check_sound() {
        if(localStorage.getItem('chat_sounds') == null) {
            localStorage.setItem('chat_sounds', 1); return;
        }
        if( Number(localStorage.getItem('chat_sounds')) == 0) {
            $("#chat_checkbox_call").prop("checked", true); return;
        }
    } 
    check_sound();
    
    function change_sound() {
        if(!$('#chat_checkbox_call').is(':checked'))
            return localStorage.setItem('chat_sounds', 1);
        return localStorage.setItem('chat_sounds', 0);
    }

    $(".chat_background").click(chat_handler);
    $('[data-toggle="chat"]').click(chat_handler);
    $('#chat_checkbox_call').click((e) => {change_sound()});
    $("#chat_send_message").submit(function (e) { 
        e.preventDefault();
        if ($("#msg_input").val() !== "")
            send_message($("#msg_input").val());
    });

    $(document).on("click", "[data-mention]", (e) => {
        let textarea = $("#msg_input")[0];
        let mention = "@" + $(e.target).data("mention") + ", ";
        textarea.value = textarea.value + mention;
        textarea.focus();
        textarea.setSelectionRange(textarea.value.length, textarea.value.length);
    });

    const button = document.querySelector('#chat_no_login');
    const msgInput = document.querySelector('#msg_input');
    if (button) {
        button.addEventListener('click', function() {
            if (msgInput) {
                msgInput.focus();
            }
        });
    }

    $(document).on('click', '.del_chat', function () {
        const AttrMSG = this.getAttribute('id_del_chat'),
            DelMSG = document.querySelector('.del_chat[id_del_chat="' + AttrMSG + '"]'),
            IdMSG = DelMSG.getAttribute('id_del_chat');
        $.ajax({
            type: 'post',
            url: location.href,
            data: { delete_message: true, id_del_chat: IdMSG },
            dataType: "json",
            success: function(data) {
                if (typeof noty === "function") {
                    noty(data.text, data.status, '/storage/assets/sounds/success2.mp3', 0.2)
                } else {
                    note({ content: data.text, type: data.status });
                }
                get_messages(0, 0);
            },
            error: function () { return false; }
        });
    });

    $("#msg_input").keypress(function (e) {
        if(e.which === 13 && !e.shiftKey) {
            e.preventDefault();
            $(this).closest("form").submit();
        }
    });

    let smileyLinks = document.getElementsByClassName('smiley_js'),
        textarea = document.getElementById('msg_input'),
        chatMenuButton = document.getElementById('chat_menu_smile'),
        chatMenu = document.querySelector('.chat_menu_smile'),
        sendMessageButton = document.getElementById('chat_send_message');
    if (chatMenuButton) {
        chatMenuButton.addEventListener('click', function(event) {
            event.stopPropagation();
            chatMenu.classList.toggle('active');
        });
    }
    if (chatMenu) {
        document.addEventListener('click', function(event) {
            const targetElement = event.target;
            if (!chatMenu.contains(targetElement) && targetElement !== chatMenuButton) {
                chatMenu.classList.remove('active');
            }
        });
    }
    for (let i = 0; i < smileyLinks.length; i++) {
        smileyLinks[i].addEventListener('click', function(event) {
            event.preventDefault();
            let smiley = this.innerText,
            startPos = textarea.selectionStart,
            endPos = textarea.selectionEnd;
            textarea.value = textarea.value.substring(0, startPos) + smiley + textarea.value.substring(endPos, textarea.value.length);
            let newCursorPos = startPos + smiley.length;
            textarea.setSelectionRange(newCursorPos, newCursorPos);
            textarea.focus();
        });
    }
    if (sendMessageButton) {
        sendMessageButton.addEventListener('click', function(event) {
            event.stopPropagation();
        });
    }
});