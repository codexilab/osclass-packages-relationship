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

$requests 		= packages_relationship_requests();
$requests_sent 	= packages_relationship_requests_sent(); ?>

<?php if ($requests) : ?>
	<h3>
	<?php // If is an account type User
	if (osc_logged_user_type() == 0) {
		_e("Invitations", 'packages_relationship');
	} else {
		_e("Requests", 'packages_relationship');
	} ?>
	</h3>

	<?php foreach ($requests as $request) : ?>
	<a href="<?php echo osc_user_public_profile_url($request['fk_i_from_user_id']); ?>"><?php echo get_user_name($request['fk_i_from_user_id']); ?></a>
	<small>

		<?php echo osc_format_date($request['dt_date'], osc_date_format()); ?>
	
		<?php // If is an account type User
		if (osc_logged_user_type() == 0) : ?>
		
		
			<?php // If the 'to user' of request, belongs yet to a Company
			if (packages_relationship_link_by_user_son($request['fk_i_to_user_id'])) : ?>
			<a href="#link-notice"><?php _e("Accept invitation", 'packages'); ?></a>
			<div id="link-notice" class="packages-modal-window"><div class="pck-msg-40"><a href="#modal-close" title="Close" class="modal-close">close &times;</a><h2><?php echo _e("Message", 'packages_relationship'); ?></h2><div class="modal-content"><center><?php echo _e("Leave the current company for accept invitation from other company.", 'packages_relationship'); ?></center></div></div></div>
			<?php else : ?>
			<a href="javascript:void(0);" onclick="packages_relationship_action('accept_request', <?php echo $request['fk_i_from_user_id'] ?>);return false;"><?php _e("Accept invitation", 'packages_relationship'); ?></a>
			<?php endif; ?>
		
		<?php else : ?>
			
			<?php // If the 'from user' of request, belongs yet to a Company
			if (packages_relationship_link_by_user_son($request['fk_i_from_user_id'])) : ?>
			<a href="#link-notice"><?php _e("Accept request", 'packages'); ?></a>
			<div id="link-notice" class="packages-modal-window"><div class="pck-msg-40"><a href="#modal-close" title="Close" class="modal-close">close &times;</a><h2><?php echo _e("Message", 'packages_relationship'); ?></h2><div class="modal-content"><center><?php echo _e("This user still belongs to a company. Wait for to the user leave the company for you can accept the request.", 'packages_relationship'); ?></center></div></div></div>
			<?php else : ?>
			<a href="javascript:void(0);" onclick="packages_relationship_action('accept_request', <?php echo $request['fk_i_from_user_id'] ?>);return false;"><?php _e("Accept request", 'packages_relationship'); ?></a>
			<?php endif; ?>
			
		<?php endif; ?>
		 - 
		<a href="javascript:void(0);" onclick="packages_relationship_action('remove_request', <?php echo $request['fk_i_from_user_id'] ?>);return false;"><?php _e("Remove", 'packages_relationship'); ?></a> - 
		<a href="javascript:void(0);" onclick="packages_relationship_action('block_account', <?php echo $request['fk_i_from_user_id'] ?>);return false;"><?php _e("Block account", 'packages_relationship'); ?></a>

	</small><br />
	<?php endforeach; ?>

	<br />
<?php endif; ?>


<?php if ($requests_sent) : ?>
	<h3><?php _e("Request sent", 'packages_relationship'); ?></h3>
	
	<?php foreach ($requests_sent as $request_sent) : ?>
	<a href="<?php echo osc_user_public_profile_url($request_sent['fk_i_to_user_id']); ?>"><?php echo get_user_name($request_sent['fk_i_to_user_id']); ?></a>
	<small>
		<?php echo osc_format_date($request_sent['dt_date'], osc_date_format()); ?>
		<a href="javascript:void(0);" onclick="packages_relationship_action('remove_request', <?php echo $request_sent['fk_i_to_user_id'] ?>);return false;"><?php _e("Remove", 'packages_relationship'); ?></a>
	</small><br />
	<?php endforeach; ?>

	<br />
<?php endif; ?>