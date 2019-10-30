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

$blocked_users = packages_relationship_blocked_users(); ?>

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