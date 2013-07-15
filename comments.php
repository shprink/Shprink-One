<?php
/**
 * The comments template.
 *
 * @package     WordPress
 * @subpackage  shprink_one
 * @since       1.0
 */
?>
<div id="comments">
	<?php if (post_password_required()) : ?>
	<p class="nopassword">
		<?php _e('This post is password protected. Enter the password to view any comments.', 'shprinkone'); ?>
	</p>
</div>
<!-- #comments -->
<?php
/* Stop the rest of comments.php from being processed,
 * but don't kill the script entirely -- we still have
* to fully load the template.
*/
return;
endif;
?>

<?php if (have_comments()) : ?>
<h3 id="comments-title">
	<?php
	if (get_comments_number() > 1) {
			printf(__('%1$s Responses to <i>%2$s</i>', 'shprinkone'), number_format_i18n(get_comments_number()), get_the_title());
		} else {
			printf(__('One Response to <i>%s</i>', 'shprinkone'), get_the_title());
		}
		?>
</h3>

<?php wp_list_comments(array('walker' => new ShprinkOne_Walker_Comment)); ?>

<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // Are there comments to navigate through?   ?>
<div class="navigation">
	<ul class="pager">
		<li><?php previous_comments_link(__('<i class="icon-chevron-left"></i> Older Comments', 'shprinkone')); ?>
		</li>
		<li><?php next_comments_link(__('Newer Comments <i class="icon-chevron-right"></i>', 'shprinkone	')); ?>
		</li>
	</ul>
</div>
<?php endif; // check for comment navigation   ?>

<?php
else : // or, if we don't have comments:

/* If there are no comments and comments are closed,
 * let's leave a little note, shall we?
*/
if (!comments_open() && !is_page()) :
?>
<p class="nocomments">
	<?php _e('Comments are closed.', 'shprinkone'); ?>
</p>
<?php endif; // end ! comments_open() ?>

<?php endif; // end have_comments() ?>

<?php shprinkone_comment_form(); ?>

</div>
<!-- #comments -->
