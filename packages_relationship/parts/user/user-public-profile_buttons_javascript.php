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
<script>
function packages_relationship_action(action_specific, user_id = null, item_id = null) {
	if (user_id == null) user_id = <?php echo get_user_id(); ?>;

    var view = '<?php echo (get_current_url() == osc_user_public_profile_url()) ? 'public_profile' : 'dashboard'; ?>';
    
    var url_ajax = "<?php echo osc_base_url().'index.php?page=ajax&action=runhook&hook=packages_relationship_ajax&'.osc_csrf_token_url(); ?>";
    
    var data_ajax = "id="+user_id+"&action_specific="+action_specific;
    if (item_id != null) {
        data_ajax = "id="+user_id+"&action_specific="+action_specific+"&item_id="+item_id;
    }

    $.ajax({
        method: "GET",
        url: url_ajax,
        data: data_ajax,
        dataType: "html"
    }).done(function(data) {

        // Public profile frames

        if (view == "public_profile") {

            refresh_module_frame('public_profile_buttons');
            refresh_module_frame('public_profile');

        } else if('dashboard') {

        // Dashboard frames

            switch (action_specific) {
                case "accept_request":
                    refresh_module_frame('requests');
                    refresh_module_frame('notifications');
                    refresh_module_frame('company');
                    refresh_module_frame('members');
                    break;

                case "remove_request":
                    refresh_module_frame('requests');
                    refresh_module_frame('notifications');
                    break;

                case "delete_link":
                    refresh_module_frame('company');
                    refresh_module_frame('requests');
                    refresh_module_frame('members');
                    refresh_module_frame('notifications');
                    break;

                case "block_account":
                    refresh_module_frame('requests');
                    refresh_module_frame('notifications');
                    refresh_module_frame('blocked');
                    break;

                case "unblock_account":
                    refresh_module_frame('blocked');
                    break;

                case "delete_event":
                    refresh_module_frame('notifications');
                    break;

                case "inheritance":
                    refresh_module_frame('members');
                    break;
            }

        }
    });

    function refresh_module_frame(frame) {
        $.ajax({
            method: "GET",
            url: url_ajax,
            data: "id="+user_id+"&action_specific="+frame,
            dataType: "html"
        }).done(function(data) {
            $('#packages-relationship-'+frame).html(data);
        });
    }
}
</script>