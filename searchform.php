<?php
/**
 * Template search form
 *
 * @package     WordPress
 * @subpackage  shprink_one
 * @since       1.0
 */
?>
<form class="navbar-search pull-left" method="get"
	action="<?php echo esc_url(home_url('/')); ?>">
	<input type="text" class="search-query" placeholder="Search" name="s"/>
</form>
