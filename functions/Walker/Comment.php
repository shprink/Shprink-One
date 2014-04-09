<?php

class ShprinkOne_Walker_Comment extends Walker_Comment
{

    /**
     * @see Walker::start_lvl()
     * @since 2.7.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of comment.
     * @param array $args Uses 'style' argument for type of HTML list.
     */
    function start_lvl(&$output, $depth = 0, $args = array())
    {
        $GLOBALS['comment_depth'] = $depth + 1;
    }

    /**
     * @see Walker::end_lvl()
     * @since 2.7.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of comment.
     * @param array $args Will only append content if style argument value is 'ol' or 'ul'.
     */
    function end_lvl(&$output, $depth = 0, $args = array())
    {
        $GLOBALS['comment_depth'] = $depth + 1;
    }

    /**
     * @see Walker::start_el()
     * @since 2.7.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $comment Comment data object.
     * @param int $depth Depth of comment in reference to parents.
     * @param array $args
     */
    function start_el(&$output, $comment, $depth = 0, $args = array(), $id = 0)
    {
        $depth++;
        $GLOBALS['comment_depth'] = $depth;
        $GLOBALS['comment'] = $comment;

        extract($args, EXTR_SKIP);

        ?>
        <div class="media <?php echo join(' ', get_comment_class()); ?>"
             id="comment-<?php comment_ID(); ?>">
            <a class="pull-left" href="#"> <?php echo get_avatar($comment, 40); ?>
            </a>
            <div class="media-body">
                <h4 class="media-heading">
        <?php printf(__('%s <span class="says">says:</span>', 'shprinkone'), sprintf('<cite class="fn">%s</cite>', get_comment_author_link())); ?>
                </h4>
        <?php if ($comment->comment_approved == '0') : ?>
                    <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'shprinkone'); ?>
                    </em> <br />
                            <?php endif; ?>

                <div class="comment-meta commentmetadata">
                    <a
                        href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
                    <?php
                    /* translators: 1: date, 2: time */
                    printf(__('%1$s at %2$s', 'shprinkone'), get_comment_date(), get_comment_time());

                    ?>
                    </a>
        <?php edit_comment_link(__('(Edit)', 'shprinkone'), ' ');

        ?>
                </div>
                <!-- .comment-meta .commentmetadata -->

                <div class="comment-body">
                <?php comment_text(); ?>
                </div>

                <div class="reply">
                <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
                </div>
                <?php
            }

            /**
             * @see Walker::end_el()
             * @since 2.7.0
             *
             * @param string $output Passed by reference. Used to append additional content.
             * @param object $comment
             * @param int $depth Depth of comment.
             * @param array $args
             */
            function end_el(&$output, $comment, $depth = 0, $args = array())
            {
                echo "</div></div>\n";
                if ($depth == 0) echo "\n";
            }
        }
