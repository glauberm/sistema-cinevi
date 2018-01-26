$(document).ready(function()
{
    ascDescCaller();
    select2Caller();
    dateTimePickerCaller();
    autosizeCaller();
});

function buildEmbed(tipo, id, senha)
{
    var embed = '<div class="embed-responsive embed-responsive-16by9">';

    switch(tipo) {
        case 'vimeo':
            embed += '<iframe src="https://player.vimeo.com/video/' + id + '" width="640" height="293" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
        break;
        case 'youtube':
            embed += '<iframe width="560" height="315" src="https://www.youtube.com/embed/' + id + '" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
        break;
    }

    embed += '</div>';

    if (senha && senha.length > 0) {
        embed += '<span class="senha-video"><strong>Senha do vídeo:</strong> <code>' + senha + '</code></span>'
    }

    embed += '<br/>'

    return embed;
}

function parseVideo(url)
{
    url.match(/(http:\/\/|https:\/\/|)(player.|www.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com))\/(video\/|embed\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/);

    var type = null;
    if (RegExp.$3.indexOf('youtu') > -1) {
        type = 'youtube';
    } else if (RegExp.$3.indexOf('vimeo') > -1) {
        type = 'vimeo';
    }

    return {
        type: type,
        id: RegExp.$6
    };
}

function ascDescCaller ()
{
    $(".asc").append("<b class='caret caret-inverse'></b>");
    $(".desc").append("<b class='caret'></b>");
}

function select2Caller ()
{
    $(".select2-select").each(function() {

        var placeHolder = $(this).attr("placeholder");

        $(this).select2({
            theme: "bootstrap",
            placeholder: placeHolder,
            language: "pt-BR"
        });
    });
}

function dateTimePickerCaller ()
{
    $(".datepicker").datetimepicker({
        format: "DD/MM/YYYY",
        icons: {
            previous: 'datepicker-left',
            next: 'datepicker-right',
        }
    });
}

function autosizeCaller ()
{
    autosize($("textarea.form-control"));
}

(function($, viewport) {
    $(document).ready(function() {
        if(viewport.is("<sm")) {
            $("#admin-menu").collapse("hide");
            $("#almoxarifado-menu").collapse("hide");
            $("#realizacao-menu").collapse("hide");
            $("#main-navbar").collapse("hide");
        }
    });
})(jQuery, ResponsiveBootstrapToolkit);
