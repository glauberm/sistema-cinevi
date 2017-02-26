// SELECT2
$(".select2-select").select2({
    theme: "bootstrap"
});

// DATETIMEPICKER
$(".datepicker").datetimepicker({
    format: "DD/MM/YYYY"
})
$(".timepicker").datetimepicker({
    format: "HH:mm"
})
$(".date-timepicker").datetimepicker({
    format: "DD/MM/YYYY HH:mm"
})

// AUTOSIZE
autosize($('textarea.form-control'));

// BOOTSTRAP COLLAPSE
(function($, viewport){
    $(document).ready(function() {
        if(viewport.is('<sm')) {
            $('#mainMenu').collapse('hide');
            $('#main-navbar').collapse('hide');
        }
    });
})(jQuery, ResponsiveBootstrapToolkit);

// ASC E DESC
$('.asc').append('<b class="caret caret-inverse"></b>');
$('.desc').append('<b class="caret"></b>');
