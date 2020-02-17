<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');

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
<?php // This sections is only for admin logged
if (osc_is_admin_user_logged_in()) : ?>

	<h3 class="render-title"><?php _e("Packages relationship (extension)", 'packages_relationship'); ?></h3>

    <?php $userId = Params::getParam('id');
    $receiveRequests  = packages_relationship_user_requests_config($userId); ?>


    <?php // For accounts type Company
    if (get_user_type($userId)) : ?>
    	<div class="form-row">
    		<div class="form-controls">
	    		<div class="form-label-checkbox">
	    			<p><label><input type="checkbox" <?php if ($receiveRequests == true) echo 'checked="true"'; ?> name="b_packages_relationship_requests" value="1"> <?php _e("Receive requests?", 'packages_relationship'); ?></label></p>
	    		</div>
    		</div>
    	</div>
    <?php endif; ?>


    <?php // For accounts type User
    if (!get_user_type($userId)) : ?>
        
        <?php $linkByUserSon    = packages_relationship_link_by_user_son($userId); ?>
        <?php $request          = packages_relationship_request_from_user($userId); ?>

        <div class="form-row">
        	<div class="form-controls">
        		<div class="form-label-checkbox">
        			<p><label><input type="checkbox" <?php if ($receiveRequests == true) echo 'checked="true"'; ?> name="b_packages_relationship_requests" value="1"> <?php _e("Receive invitations?", 'packages_relationship'); ?></label></p>
        		</div>
        	</div>
        </div>

        <?php if ($linkByUserSon) : ?>
        <div class="form-row">
			<div class="form-controls">
				<label><?php _e("Company"); ?>: <a href="<?php echo osc_user_public_profile_url($linkByUserSon['fk_i_user_id']); ?>"><?php echo get_user_name($linkByUserSon['fk_i_user_id']); ?></a></label>
				<label><input type="checkbox" <?php if ($linkByUserSon['b_use_package'] == true || !$linkByUserSon) echo 'checked="true"'; ?> name="b_use_package" value="1"><?php _e("Use package", 'packages_relationship'); ?>.</label>
			</div>
		</div>
        <?php endif; ?>

        <?php if ($request) : ?>
        <div class="form-row">
        	<div class="form-controls">
        		<label><?php _e("Company"); ?>: <a href="<?php echo osc_user_public_profile_url($request['fk_i_to_user_id']); ?>"><?php echo get_user_name($request['fk_i_to_user_id']); ?></a> (<?php _e("Awaiting approval", 'packages_relationship'); ?>).</label>
        	</div>
        </div>
        <?php endif; ?>

    <?php endif; ?>

<?php endif; ?>