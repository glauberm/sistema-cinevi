$(function () {
    $('#calendar-holder').fullCalendar({
        header: {
            left: 'prev, next',
            center: 'title',
            right: 'month, basicWeek, basicDay,'
        },
        defaultView: 'basicDay',
        lang: 'pt-br',
        lazyFetching: true,
        eventLimit: false, // allow "more" link when too many events
        eventSources: [
            {
                url: '/full-calendar/load',
                type: 'POST',
                data: {},
                error: function () {}
            }
        ],
        selectable: true,
    });
});

// BOOTSTRAP COLLAPSE
(function($, viewport){
    $(document).ready(function() {
        if(viewport.is('>=sm')) {
            $('#calendar-holder').fullCalendar( 'changeView', 'month' );
        }
    });
})(jQuery, ResponsiveBootstrapToolkit);
