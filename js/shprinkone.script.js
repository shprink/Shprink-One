(function($) {
    // Add Bootstrap class to lists within the sidebar
    $('#sidebar .widget ul').addClass('nav nav-pills nav-stacked');
    $('footer .widget ul').addClass('nav nav-pills nav-stacked');
    $('.widget_recent_comments ul').removeClass('nav nav-tabs nav-pills nav-stacked').addClass('list-unstyled');
    $('[data-toggle=tooltip]').tooltip()
    $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
        // Avoid following the href location when clicking
        event.preventDefault();
        // Avoid having the menu to close when clicking
        event.stopPropagation();
        // If a menu is already open we close it
        $('#header ul.dropdown-menu [data-toggle=dropdown]').parent().removeClass('open');
        // opening the one you clicked on
        $(this).parent().addClass('open');
    });
})(jQuery);
