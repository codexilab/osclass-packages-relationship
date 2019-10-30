<?php
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
                if (Params::getParam('packages_profile_info') != osc_get_preference('packages_profile_info', 'packages')) {
                    osc_set_preference('packages_profile_info', Params::getParam('packages_profile_info'), 'packages_relationship', 'BOOLEAN');    
                }
                
                if (Params::getParam('company_module') != osc_get_preference('company_module', 'packages')) {
                    osc_set_preference('company_module', Params::getParam('company_module'), 'packages_relationship', 'BOOLEAN');
                }

                if (Params::getParam('members_module') != osc_get_preference('members_module', 'packages')) {
                    osc_set_preference('members_module', Params::getParam('members_module'), 'packages_relationship', 'BOOLEAN');
                }

                if (Params::getParam('requests_module') != osc_get_preference('requests_module', 'packages')) {
                    osc_set_preference('requests_module', Params::getParam('requests_module'), 'packages_relationship', 'BOOLEAN');
                }

                if (Params::getParam('blocked_module') != osc_get_preference('blocked_module', 'packages')) {
                    osc_set_preference('blocked_module', Params::getParam('blocked_module'), 'packages_relationship', 'BOOLEAN');
                }
                
                break;
        }
    }
    
}