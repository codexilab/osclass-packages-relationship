<?php
/*
 * Copyright 2019 CodexiLab
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

$events = packages_relationship_events(); ?>

<h3><?php _e("Notifications", 'packages_relationship'); ?></h3>

<?php if ($events) : ?>
	<?php foreach ($events as $event) : ?>
	<?php packages_relationship_event_description($event['fk_i_from_user_id'], $event['s_type']); ?> 
	<small><?php echo osc_format_date($event['dt_date'], osc_date_format()); ?> <a href="javascript:packages_relationship_action('delete_event', <?php echo $event['fk_i_from_user_id'] ?>, <?php echo $event['pk_i_id'] ?>);">[x]</a></small><br /><br />
	<?php endforeach; ?>
<?php else : ?>
	<center><small><?php _e("There are not anything", 'packages_relationship');?></small></center><br />
<?php endif; ?>