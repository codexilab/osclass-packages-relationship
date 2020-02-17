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

<?php // This sections is only for users logged
if (osc_is_web_user_logged_in()) : ?>

    <?php $receiveRequests  = packages_relationship_user_requests_config(); ?>


    <?php // For accounts type Company
    if (osc_logged_user_type()) : ?>
        <div class="control-group">
            <div class="controls">
                <input type="checkbox" <?php if ($receiveRequests == true) echo 'checked="true"'; ?> name="b_packages_relationship_requests" value="1"> <?php _e("Receive requests?", 'packages_relationship'); ?>
            </div>
        </div>
    <?php endif; ?>


    <?php // For accounts type User
    if (!osc_logged_user_type()) : ?>
        
        <?php $linkByUserSon    = packages_relationship_link_by_user_son(); ?>
        <?php $request          = packages_relationship_request_from_user(); ?>

        <div class="control-group">
            <div class="controls">
                <input type="checkbox" <?php if ($receiveRequests == true) echo 'checked="true"'; ?> name="b_packages_relationship_requests" value="1"> <?php _e("Receive invitations?", 'packages_relationship'); ?>
            </div>
        </div>

        <?php if ($linkByUserSon) : ?>
        <div class="control-group">
        	<label class="control-label"><?php _e("Your company", 'packages_relationship'); ?></label>
            <div class="controls">
            	<a href="<?php echo osc_user_public_profile_url($linkByUserSon['fk_i_user_id']); ?>"><?php echo get_user_name($linkByUserSon['fk_i_user_id']); ?></a>
            	<input type="checkbox" <?php if ($linkByUserSon['b_use_package'] == true || !$linkByUserSon) echo 'checked="true"'; ?> name="b_use_package" value="1"> <?php _e("Use package", 'packages_relationship'); ?>.
            </div>
        </div>
        <?php endif; ?>

        <?php if ($request) : ?>
        <div class="control-group">
        	<label class="control-label"><?php _e("Your company", 'packages_relationship'); ?></label>
        	<div class="controls">
        		<a href="<?php echo osc_user_public_profile_url($request['fk_i_to_user_id']); ?>"><?php echo get_user_name($request['fk_i_to_user_id']); ?></a>
                - <?php _e("Awaiting approval", 'packages_relationship'); ?>.
        	</div>
        </div>
        <?php endif; ?>

    <?php endif; ?>

<?php endif; ?>