<?php // For accounts User type
$link = PackagesRelationship::newInstance()->getLinkByUserSon(osc_logged_user_id()); ?>
<?php if ($link) : ?>

<h3><?php _e("Company", 'packages_relationship'); ?></h3>

<a href="<?php echo osc_user_public_profile_url($link['fk_i_user_id']); ?>">
	<?php echo get_user_name($link['fk_i_user_id']); ?>
</a>
<small>
	<?php echo osc_format_date($link['dt_date'], osc_date_format()); ?> 
	<a href="#delete-link"><?php _e("Leave company", 'packages_relationship'); ?></a>
</small><br /><br />

<!-- modalDialog -->
<div id="delete-link" class="modalDialog">
	<div class="pck-msg-40">
		<a href="#close" title="Close" class="close">X</a>
		<h2><?php _e("Message", 'packages_relationship'); ?></h2>
		<div class="modal-content">
			<center>
				<?php _e("Are you sure you want to leave the company?", 'packages_relationship'); ?><br>
				<a href="javascript:packages_relationship_action('delete_link', <?php echo $link['fk_i_user_id'] ?>);" onclick="location.href='#modal-close';"><?php _e("Leave company", 'packages_relationship'); ?></a>
			</center>
		</div>
	</div>
</div>

<?php endif; ?>
