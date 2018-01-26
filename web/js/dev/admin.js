$(document).ready(function()
{
    ascDescCaller();
    select2Caller();
    dateTimePickerCaller();
    autosizeCaller();
    masks();
    calendarEventAjax();
    equipe();
});

function equipe()
{
    var $addEquipeLink = $('<a href="#" class="btn btn-primary">Adicionar Equipe</a>');
    var $newLinkLiEquipe = $('<div class="to-many-wrap"></div>').append($addEquipeLink);

    $collectionHolderEquipe = $('div#equipes');
    $collectionHolderEquipe.append($newLinkLiEquipe);
    $collectionHolderEquipe.data('index', $collectionHolderEquipe.find(':input').length);
    $addEquipeLink.on('click', function(e)
    {
        e.preventDefault();
        addForm($collectionHolderEquipe, $newLinkLiEquipe);
    });
}

function calendarEventAjax()
{
    var $date = $('#calendar_event_startDate, #calendar_event_endDate');

    $date.on("dp.change", function() {
        var $form = $(this).closest('form');

        var data = {};
        data[$('#calendar_event_startDate').attr('name')] = $('#calendar_event_startDate').val();
        data[$('#calendar_event_endDate').attr('name')] = $('#calendar_event_endDate').val();

        $.ajax({
            url : $form.attr('action'),
            type: 'POST',
            data : data,
            beforeSend: function() {
                $("body").append("<div id='overlay-alert' class='overlay-alert'><span class='label label-danger'>Carregando...</span></div>");
            },
            complete: function(){
                $("#overlay-alert").remove();
            },
            success: function(html) {
                $('#calendar_event_equipamentos').select2("destroy");
                $('#calendar_event_equipamentos').replaceWith(
                    $newField = $(html).find('#calendar_event_equipamentos')
                );
                select2Caller();
            }
        });
    });
}

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

function masks()
{
    var maskBehavior = function (val) {
      return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    options = {onKeyPress: function(val, e, field, options) {
            field.mask(maskBehavior.apply({}, arguments), options);
        }
    };

    $('.input-tel').mask(maskBehavior, options);
    $('.input-money').mask("#.##0,00", {reverse: true});

    $("input[type='number']").siblings("label").after("<small class='text-muted'> (somente números)</small>")
    $("input[type='number']").on("input paste", function() {
            this.value = this.value.replace(/[^\d\.\-]/g,'');
        }
    );
}

function addForm($collectionHolder, $newLinkLi)
{
	var prototype = $collectionHolder.data('prototype');
	var index = $collectionHolder.data('index');
	var newForm = prototype.replace(/__name__/g, index);

	$collectionHolder.data('index', index + 1);

	var $newFormLi = $('<div class="to-many-adicionar"></div>').append(newForm);
	$newLinkLi.before( $newFormLi.fadeIn(300) );

	select2Caller();
    dateTimePickerCaller();
    autosizeCaller();

	addFormDeleteLink($newFormLi);
}

function addFormDeleteLink($formLi)
{
	var $removeForm = $('<div class="pull-right"><div class="inline-block"><a class="to-many-remover btn btn-danger btn-sm" href="#">Remover</a></div></div>');
	$formLi.append($removeForm);

	$removeForm.on('click', function(e) {
		e.preventDefault();
		$formLi.fadeOut(300, function() { $formLi.remove() });
	});
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
