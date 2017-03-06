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
    $(".select2-select").select2({
        theme: "bootstrap"
    });
}

// DATETIMEPICKER
function dateTimePickerCaller ()
{
    $(".datepicker").datetimepicker({
        format: "DD/MM/YYYY"
    });
    $(".timepicker").datetimepicker({
        format: "HH:mm"
    });
    $(".date-timepicker").datetimepicker({
        format: "DD/MM/YYYY HH:mm"
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
