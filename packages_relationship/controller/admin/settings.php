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
 
/**
* Controller Settings Packages system plugin
*/
class CCustomAdminPackagesSettings extends AdminSecBaseModel
{

    //Business Layer...
    public function doModel()
    {

        switch (Params::getParam('plugin_action')) {
            case 'done':
                if (Params::getParam('packages_profile_info') != osc_get_preference('packages_profile_info', 'packages_relationship')) {
                    osc_set_preference('packages_profile_info', Params::getParam('packages_profile_info'), 'packages_relationship', 'BOOLEAN');    
                }
                
                if (Params::getParam('company_module') != osc_get_preference('company_module', 'packages_relationship')) {
                    osc_set_preference('company_module', Params::getParam('company_module'), 'packages_relationship', 'BOOLEAN');
                }

                if (Params::getParam('members_module') != osc_get_preference('members_module', 'packages_relationship')) {
                    osc_set_preference('members_module', Params::getParam('members_module'), 'packages_relationship', 'BOOLEAN');
                }

                if (Params::getParam('requests_module') != osc_get_preference('requests_module', 'packages_relationship')) {
                    osc_set_preference('requests_module', Params::getParam('requests_module'), 'packages_relationship', 'BOOLEAN');
                }

                if (Params::getParam('blocked_module') != osc_get_preference('blocked_module', 'packages_relationship')) {
                    osc_set_preference('blocked_module', Params::getParam('blocked_module'), 'packages_relationship', 'BOOLEAN');
                }
                
                break;
        }
    }
    
}