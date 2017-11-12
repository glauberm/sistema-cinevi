function calendarEventAjax (method)
{
    var $date = $('#calendar_event_startDate, #calendar_event_endDate');

    $date.on("dp.change", function() {
        var $form = $(this).closest('form');

        var data = {};
        data[$('#calendar_event_startDate').attr('name')] = $('#calendar_event_startDate').val();
        data[$('#calendar_event_endDate').attr('name')] = $('#calendar_event_endDate').val();

        $.ajax({
            url : $form.attr('action'),
            type: method,
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
