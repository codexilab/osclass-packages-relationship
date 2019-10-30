<?php // For accounts type User
if (get_user_type(get_user_id()) == 0) : ?>
	<?php $link = packages_relationship_link_by_user_son(get_user_id()); ?>

	<?php if ($link) : ?>
	<h3><?php _e("Company", 'packages'); ?></h3>

	<a href="<?php echo osc_user_public_profile_url($link['fk_i_user_id']); ?>"><?php echo get_user_name($link['fk_i_user_id']) ?></a>
	<?php endif; ?>
<?php endif; ?>

<?php // For accounts type Company
if (get_user_type(get_user_id()) == 1) : ?>
	<?php $links = packages_relationship_links(get_user_id()); ?>

	<?php if ($links) : ?>
		<h3><?php _e("Members", 'packages'); ?></h3>

		<?php foreach ($links as $link) : ?>
		<a href="<?php echo osc_user_public_profile_url($link['fk_i_user_son_id']); ?>">
			<?php echo get_user_name($link['fk_i_user_son_id']); ?>
		</a>
		<?php endforeach; ?>
	<?php endif; ?>
<?php endif; ?>