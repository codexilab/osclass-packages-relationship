<?php 
/*
 * Copyright 2019 - 2020 CodexiLab
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
?>

<?php // For account type user
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