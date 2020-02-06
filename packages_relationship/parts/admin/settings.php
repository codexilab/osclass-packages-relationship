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
 
$htmlStyle = '<style type="text/css">';

// Notifiactions module
if (!osc_get_preference('notifications_module', 'packages_relationship')) {
    $display = 'inline';
} else {
    $display = 'none';
}
$htmlStyle .= '#script-notifications-module {
    display: '.$display.'
}';

// Company module
if (!osc_get_preference('company_module', 'packages_relationship')) {
    $display = 'inline';
} else {
    $display = 'none';
}
$htmlStyle .= '#script-company-module {
    display: '.$display.'
}';

// Requests/Invitations module
if (!osc_get_preference('requests_module', 'packages_relationship')) {
    $display = 'inline';
} else {
    $display = 'none';
}
$htmlStyle .= '#script-requests-module {
    display: '.$display.'
}';

// Members module
if (!osc_get_preference('members_module', 'packages_relationship')) {
    $display = 'inline';
} else {
    $display = 'none';
}
$htmlStyle .= '#script-members-module {
    display: '.$display.'
}';

// Blocked module
if (!osc_get_preference('blocked_module', 'packages_relationship')) {
    $display = 'inline';
} else {
    $display = 'none';
}
$htmlStyle .= '#script-blocked-module {
    display: '.$display.'
}';

$htmlStyle .= '</style>';

echo $htmlStyle;
?>
<br><br>
<h2 class="render-title"><?php _e("Packages relationship (extension)", 'packages_relationship'); ?></h2>

<!-- Notifications module setting -->
<div class="form-row">
    <div class="form-label-checkbox">
        <strong><h3><?php _e("Notifications module", 'packages_relationship') ?></h3></strong>
        <p><label><input id="notifications_module" type="checkbox" <?php echo (osc_get_preference('notifications_module', 'packages_relationship') ? 'checked="true"' : ''); ?> name="notifications_module" value="1"><?php _e("Show from user menu", 'packages_relationship'); ?></label></p>
    </div>
</div>
<div id="script-notifications-module" class="form-row">
    <input type="text" class="xlarge" style="width: 300px;" value="&lt;?php osc_run_hook('packages_relationship_notifications_module'); ?&gt;" disabled><br />
    <?php _e("Use this script for show manually (if you want)", 'packages_relationship'); ?>.
</div>

<!-- Company module setting -->
<div class="form-row">
    <div class="form-label-checkbox">
        <strong><h3><?php _e("Company module", 'packages_relationship') ?></h3></strong>
        <p><label><input id="company_module" type="checkbox" <?php echo (osc_get_preference('company_module', 'packages_relationship') ? 'checked="true"' : ''); ?> name="company_module" value="1"><?php _e("Show from user menu", 'packages_relationship'); ?></label></p>
    </div>
</div>
<div id="script-company-module" class="form-row">
    <input type="text" class="xlarge" style="width: 300px;" value="&lt;?php osc_run_hook('packages_relationship_company_module'); ?&gt;" disabled><br />
    <?php _e("Use this script for show manually (if you want)", 'packages_relationship'); ?>.
</div>

<!-- Requests/Invitations module setting -->
<div class="form-row">
    <div class="form-label-checkbox">
        <strong><h3><?php _e("Requests/Invitations module", 'packages_relationship') ?></h3></strong>
        <p><label><input id="requests_module" type="checkbox" <?php echo (osc_get_preference('requests_module', 'packages_relationship') ? 'checked="true"' : ''); ?> name="requests_module" value="1"><?php _e("Show from user menu", 'packages_relationship'); ?></label></p>
    </div>
</div>
<div id="script-requests-module" class="form-row">
    <input type="text" class="xlarge" style="width: 300px;" value="&lt;?php osc_run_hook('packages_relationship_requests_module'); ?&gt;" disabled><br />
    <?php _e("Use this script for show manually (if you want)", 'packages_relationship'); ?>.
</div>

<!-- Members module setting -->
<div class="form-row">
    <div class="form-label-checkbox">
        <strong><h3><?php _e("Members module", 'packages_relationship') ?></h3></strong>
        <p><label><input id="members_module" type="checkbox" <?php echo (osc_get_preference('members_module', 'packages_relationship') ? 'checked="true"' : ''); ?> name="members_module" value="1"><?php _e("Show from user menu", 'packages_relationship'); ?></label></p>
    </div>
</div>
<div id="script-members-module" class="form-row">
    <input type="text" class="xlarge" style="width: 300px;" value="&lt;?php osc_run_hook('packages_relationship_members_module'); ?&gt;" disabled><br />
    <?php _e('Use this script for show manually (if you want)', 'packages_relationship'); ?>.
</div>

<!-- Blocked module setting -->
<div class="form-row">
    <div class="form-label-checkbox">
        <strong><h3><?php _e("Blocked module", 'packages_relationship') ?></h3></strong>
        <p><label><input id="blocked_module" type="checkbox" <?php echo (osc_get_preference('blocked_module', 'packages_relationship') ? 'checked="true"' : ''); ?> name="blocked_module" value="1"><?php _e("Show from user menu", 'packages_relationship'); ?></label></p>
    </div>
</div>
<div id="script-blocked-module" class="form-row">
    <input type="text" class="xlarge" style="width: 300px;" value="&lt;?php osc_run_hook('packages_relationship_blocked_module'); ?&gt;" disabled><br />
    <?php _e("Use this script for show manually (if you want)", 'packages_relationship'); ?>.
</div>
<script>
    $(document).ready(function () {
        $('input#notifications_module').click(function () {
            if($(this).is(':checked')) {
            	$("#script-notifications-module").hide();
            } else {
                $("#script-notifications-module").show();
            }
        });

        $('input#company_module').click(function () {
            if($(this).is(':checked')) {
                $("#script-company-module").hide();
            } else {
                $("#script-company-module").show();
            }
        });

        $('input#requests_module').click(function () {
            if($(this).is(':checked')) {
                $("#script-requests-module").hide();
            } else {
                $("#script-requests-module").show();
            }
        });

        $('input#members_module').click(function () {
            if($(this).is(':checked')) {
                $("#script-members-module").hide();
            } else {
                $("#script-members-module").show();
            }
        });

        $('input#blocked_module').click(function () {
            if($(this).is(':checked')) {
                $("#script-blocked-module").hide();
            } else {
                $("#script-blocked-module").show();
            }
        });

    });
</script>