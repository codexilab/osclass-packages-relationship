<?php $blocked_users = packages_relationship_blocked_users(); ?>

<?php if ($blocked_users) : ?>
	<h3><?php _e("Black list", 'packages_relationship') ?></h3>

	<?php foreach ($blocked_users as $blocked_user) : ?>
	<a href="<?php echo osc_user_public_profile_url($blocked_user['fk_i_to_user_id']); ?>"><?php echo get_user_name($blocked_user['fk_i_to_user_id']); ?></a>
	<small>
		<?php echo osc_format_date($blocked_user['dt_date'], osc_date_format()); ?>
		<a href="javascript:packages_relationship_action('unblock_account', <?php echo $blocked_user['fk_i_to_user_id'] ?>);"><?php echo _e("Unblock account", 'packages_relationship'); ?></a>
	</small><br />
	<?php endforeach; ?>
	<br />
<?php endif; ?>