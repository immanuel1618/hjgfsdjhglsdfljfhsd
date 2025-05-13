function delay(fn, ms) 
{
    let timer = 0
    return function (...args) 
    {
        clearTimeout(timer)
        timer = setTimeout(fn.bind(this, ...args), ms || 0)
    }
}

$('input[name="_steam_id"]').on("input", (e) => {
    $(".modal_blocks_content > a").remove();
    let modal = $("#open_search");

    if( $(e.currentTarget).val().trim() == "" )
    {
        modal.removeClass("users_found");
        return modal.removeClass("users_notfound")
    }

    modal.addClass("users_notfound");
    $("#search_header").html('<div class="load"><svg viewBox="0 0 512 512"><path d="M105.1 202.6c7.7-21.8 20.2-42.3 37.8-59.8c62.5-62.5 163.8-62.5 226.3 0L386.3 160H336c-17.7 0-32 14.3-32 32s14.3 32 32 32H463.5c0 0 0 0 0 0h.4c17.7 0 32-14.3 32-32V64c0-17.7-14.3-32-32-32s-32 14.3-32 32v51.2L414.4 97.6c-87.5-87.5-229.3-87.5-316.8 0C73.2 122 55.6 150.7 44.8 181.4c-5.9 16.7 2.9 34.9 19.5 40.8s34.9-2.9 40.8-19.5zM39 289.3c-5 1.5-9.8 4.2-13.7 8.2c-4 4-6.7 8.8-8.1 14c-.3 1.2-.6 2.5-.8 3.8c-.3 1.7-.4 3.4-.4 5.1V448c0 17.7 14.3 32 32 32s32-14.3 32-32V396.9l17.6 17.5 0 0c87.5 87.4 229.3 87.4 316.7 0c24.4-24.4 42.1-53.1 52.9-83.7c5.9-16.7-2.9-34.9-19.5-40.8s-34.9 2.9-40.8 19.5c-7.7 21.8-20.2 42.3-37.8 59.8c-62.5 62.5-163.8 62.5-226.3 0l-.1-.1L125.6 352H176c17.7 0 32-14.3 32-32s-14.3-32-32-32H48.4c-1.6 0-3.2 .1-4.8 .3s-3.1 .5-4.6 1z"/></svg> Ищем игрока...</div>');
})

$('input[name="_steam_id"]').keyup(delay(function (e) {
    searchFromModule(this.value);
}, 500));

function searchFromModule( input = "" )
{
    let modal = $("#open_search");
    modal.addClass("users_notfound");

    $(".modal_blocks_content > a").remove();

    if( input.trim() == "" )
    {
        modal.removeClass("users_found");
        return modal.removeClass("users_notfound")
    }

    (async () => {
        let data = new FormData();
        data.append( "search", input );

        const rawResponse = await fetch(domain+'search/', {
            method: 'POST',
            headers: {
                'Accept': 'application/json'
            },
            body: data
        });

        const json = await rawResponse.json();

        // If backend down
        if( json.result?.error )
        {
            modal.removeClass("users_found");
            $("#search_header").html(`
                <svg viewBox="0 0 320 512">
                    <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"/>
                </svg>`+json.result?.error);

            return;
        }

        if( json.result?.players.length && json.result?.players.length > 0 )
        {
            modal.removeClass("users_notfound");
            modal.addClass("users_found");
            $("#search_header").html(`
                <svg viewBox="0 0 512 512">
                    <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352c79.5 0 144-64.5 144-144s-64.5-144-144-144S64 128.5 64 208s64.5 144 144 144z" />
                </svg>
                Найдено совпадений
                <b>`+json.result?.players.length+`</b>`);

            for( let player of json.result?.players )
            {
                $(".modal_blocks_content").append(`<a href="${domain}profiles/`+player.steam64+`?search=1">
                    <img src="${player.avatar}" alt="">
                    <div class="modal_user_content">
                        <h3>`+player.name+`</h3>
                        <p>`+player.steam64+`</p>
                    </div>
                    <svg x="0" y="0" viewBox="0 0 500.667 500.667" xml:space="preserve"><g><path d="M250.333 0C112.296 0 0 112.308 0 250.333s112.296 250.333 250.333 250.333 250.333-112.308 250.333-250.333S388.371 0 250.333 0zm0 450.6c-110.425 0-200.267-89.841-200.267-200.267S139.908 50.067 250.333 50.067 450.6 139.908 450.6 250.333 360.759 450.6 250.333 450.6zm100.134-275.367v100.133c0 13.837-11.209 25.033-25.033 25.033S300.4 289.203 300.4 275.367v-39.701L192.933 343.133c-4.889 4.889-11.294 7.334-17.699 7.334s-12.81-2.445-17.699-7.334c-9.779-9.779-9.779-25.62 0-35.399l107.467-107.467H225.3c-13.825 0-25.033-11.197-25.033-25.033 0-13.837 11.209-25.033 25.033-25.033h100.133c13.825-.001 25.034 11.196 25.034 25.032z"></path></g></svg>
                </a>`)
            }
        }
        else
        {
            modal.removeClass("users_found");
            $("#search_header").html(`
            <svg viewBox="0 0 320 512"><path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"/></svg>
            Совпадений не найдено :(`);
        }
    })();
}