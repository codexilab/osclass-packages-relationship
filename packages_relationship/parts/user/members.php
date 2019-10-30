<?php // Members (module for Company type accounts)
if (osc_logged_user_type() == 1) : ?>
	<?php $links = packages_relationship_links(); ?>

	<h3><?php _e("Members", 'packages_relationship') ?></h3>

	<?php if ($links) : ?>

		<?php foreach ($links as $link) : ?>
		<div id="enable_<?php echo $link['pk_i_id']; ?>">
			<a href="<?php echo osc_user_public_profile_url($link['fk_i_user_son_id']); ?>">
				<?php echo get_user_name($link['fk_i_user_son_id']); ?>
			</a>
			<small>
				<?php echo osc_format_date($link['dt_date'], osc_date_format()); ?>
				
				<a href="javascript:packages_relationship_action('delete_link', <?php echo $link['fk_i_user_son_id'] ?>);">Remove</a>

				<?php if ( get_package_assigned(osc_logged_user_id()) ) : ?>
				 - <a href="javascript:packages_relationship_action('inheritance', <?php echo $link['fk_i_user_son_id']; ?>);"><?php echo ($link['b_inherited'] == true) ? __("Disinherit", 'packages_relationship') : __("Inherit", 'packages_relationship'); ?></a>
				<?php endif; ?>

			</small>
		</div>
		<?php endforeach; ?>

	<?php else : ?>

		<center><small><?php _e("You not have members", 'packages_relationship'); ?></small></center>

	<?php endif; ?>

	<br />

<?php endif; ?>