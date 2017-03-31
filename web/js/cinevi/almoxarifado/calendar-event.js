function calendarEventAjax (method)
{
    var $date = $('#calendar_event_startDate, #calendar_event_endDate');
    // When date gets selected ...
    $date.on("dp.change", function() {
        // ... retrieve the corresponding form.
        var $form = $(this).closest('form');
        console.log($(this).closest('input[name="_method"]').val());
        // Simulate form data, but only include the selected sport value.
        var data = {};
        data[$('#calendar_event_startDate').attr('name')] = $('#calendar_event_startDate').val();
        data[$('#calendar_event_endDate').attr('name')] = $('#calendar_event_endDate').val();
        // Submit data via AJAX to the form's action path.
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
                // Replace current position field ...
                $('#calendar_event_equipamentos').replaceWith(
                    // ... with the returned one from the AJAX response.
                    $newField = $(html).find('#calendar_event_equipamentos')
                );
                select2Caller();
                // Position field now displays the appropriate positions.
            }
        });
    });
}
