(function($) {
    $('#previous-post').sidr({
        name: 'sidr-previous-post',
        source: function(name) {
            return $('#previous-post-content').clone().html();
        }
    });
    $('#next-post').sidr({
        name: 'sidr-next-post',
        source: function(name) {
            return $('#next-post-content').clone().html();
        },
        side: 'right'
    });

    window.closePreviousSidr = function() {
        $.sidr('close', 'sidr-previous-post')
    }

    window.closeNextSidr = function() {
        $.sidr('close', 'sidr-next-post')
    }
})(jQuery);
