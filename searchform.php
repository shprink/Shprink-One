<?php
/**
 * Template search form
 *
 * @package     WordPress
 * @subpackage  shprink_one
 * @since       1.0
 */
?>
<form class="navbar-search navbar-form" method="get"
	action="<?php echo esc_url(home_url('/')); ?>">
	<input type="text" class="form-control" placeholder="Search" name="s"/>
</form>
