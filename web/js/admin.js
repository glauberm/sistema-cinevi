ascDescCaller();
select2Caller();
dateTimePickerCaller();
autosizeCaller();

// ASC E DESC
function ascDescCaller ()
{
    $(".asc").append("<b class='caret caret-inverse'></b>");
    $(".desc").append("<b class='caret'></b>");
}

// SELECT2
function select2Caller ()
{
    $(".select2-select").each(function() {

        var placeHolder = $(this).attr("placeholder");

        $(this).select2({
            theme: "bootstrap",
            placeholder: placeHolder,
            language: 'pt-br'
        });
    });
}

// DATETIMEPICKER
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

// AUTOSIZE
function autosizeCaller ()
{
    autosize($("textarea.form-control"));
}

// BOOTSTRAP COLLAPSE
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
