<?php $events = packages_relationship_events(); ?>

<h3><?php _e("Notifications", 'packages_relationship'); ?></h3>

<?php if ($events) : ?>
	<?php foreach ($events as $event) : ?>
	<?php packages_relationship_event_description($event['fk_i_from_user_id'], $event['s_type']); ?> 
	<small><?php echo osc_format_date($event['dt_date'], osc_date_format()); ?> <a href="javascript:packages_relationship_action('delete_event', <?php echo $event['fk_i_from_user_id'] ?>, <?php echo $event['pk_i_id'] ?>);">[x]</a></small><br /><br />
	<?php endforeach; ?>
<?php else : ?>
	<center><small><?php _e("There are not anything", 'packages_relationship');?></small></center><br />
<?php endif; ?>