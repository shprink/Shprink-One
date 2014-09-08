(function($) {
    /* Masonry */
    var $container = $('#masonry');

    // Callback on After new masonry boxes load
    window.onAfterLoaded = function(el) {
        el.find('div.post-meta li').popover({
            trigger: 'hover',
            placement: 'top',
            container: 'body'
        });

        // Disqus support
        if (typeof DISQUSWIDGETS !== 'undefined') {
            $.each(el.find('.dsq-postid'), function(i, node) {
                var $node = $(node),
                    $link = $node.parent('a'),
                    url = $link.attr('href').split('#', 1);
                $link.attr('data-disqus-identifier', $node.attr('rel'));
                $link.attr('href', ((url.length === 1) ? url[0] : url[1]) + '#disqus_thread');
            });
            DISQUSWIDGETS.getCount();
        }
    };

    onAfterLoaded($container.find('.box'));

    $container.imagesLoaded(function() {
        $container.masonry({
            itemSelector: '.box'
        });

        $(window).resize(function() {
            $container.masonry('reload');
        });
    });

    $('#slideshow').carousel();
})(jQuery);
