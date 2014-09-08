(function($) {
    var $container = $('#masonry');
    $('#page-nav a').click(function() {
        $button = $(this);
        if (typeof $button.data('href') === 'string' && $button.data('href') !== '') {
            var buttonHtml = $button.html();
            $button.attr('disabled', 'disabled');
            $button.html('<i class="icon-spinner icon-spin"></i> ' + trans.msgText);
            $.ajax($button.data('href'))
                .done(function(data, textStatus, jqXHR) {
                    // Set the new page href
                    if (typeof $(data).find('#page-nav a').data('href') === 'undefined'){
                        $button.data('href', '');
                    } else {
                        $button.data('href', $(data).find('#page-nav a').data('href'));
                    }

                    var $newElems = $(data).find('.box').css({
                        opacity: 0
                    });
                    // ensure that images load before adding to masonry layout
                    $newElems.imagesLoaded(function() {
                        // show elems now they're ready
                        $newElems.animate({
                            opacity: 1
                        });
                        $container.prepend($newElems);
                        $container.masonry('appended', $newElems, true);
                    });
                    onAfterLoaded($newElems);
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    $error = $('<div class="alert alert-danger">' + trans.error + '</div>');
                    $error.insertAfter($button);
                    $button.remove();
                    setTimeout(function() {
                        $error.remove()
                    }, 3000);
                })
                .always(function() {
                    $button.html(buttonHtml);
                    $button.removeAttr('disabled');
                });
        } else {
            $finish = $('<div class="alert alert-info">' + trans.finishedMsg + '</div>').hide();
            $finish.insertAfter($button);
            $finish.show(500);
            $button.remove();
            setTimeout(function() {
                $finish.hide(500, function() {
                    $finish.remove()
                });
            }, 3000)
        }

    });
})(jQuery);
