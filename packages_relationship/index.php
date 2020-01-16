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
 
/*
Plugin Name: Packages relationship (extension)
Plugin URI: https://github.com/codexilab/osclass-packages-relationship
Description: Users hierarchy system between Company and Users (extension for Promotional packages system).
Version: 1.0.0
Author: CodexiLab
Author URI: https://github.com/codexilab
Short Name: packages-relationship-extension
Plugin update URI: https://github.com/codexilab/osclass-packages-relationship
*/

	// Paths
	define('PACKAGES_RELATIONSHIP_FOLDER', 'packages_relationship/');
	define('PACKAGES_RELATIONSHIP_PATH', osc_plugins_path().PACKAGES_RELATIONSHIP_FOLDER);

	// Model
	require_once PACKAGES_RELATIONSHIP_PATH . 'model/PackagesRelationship.php';
	
	/**
	* If the plugin Promotional packages system is enabled for run extension
	*/
	if (osc_plugin_is_enabled('packages/index.php')) :

		// controllers and helpers
		require_once PACKAGES_RELATIONSHIP_PATH . 'oc-load.php';

		// Custom settings controller
		function custom_actions_packages_admin_settings() {
			$do = new CCustomAdminPackagesSettings();
		    $do->doModel();
		}
		osc_add_hook('admin_packages_settings_done', 'custom_actions_packages_admin_settings');

		// Add part to into form of Promotional packages settings
	    function packages_relationship_settings() {
	    	include PACKAGES_RELATIONSHIP_PATH . 'parts/admin/settings.php';
	    }
	   	osc_add_hook('packages_into_form_settings', 'packages_relationship_settings');


	   	// For detect inherited package
	   	function package_info_current($current_packages) {
	   		$packageInherited 	= PackagesRelationship::newInstance()->getInherited(osc_logged_user_id());
		    $link 				= PackagesRelationship::newInstance()->getLinkByUserSon(osc_logged_user_id());

		    if ($packageInherited && $link && $link['b_inherited'] == true && $link['b_use_package'] == true) {
		    	
		    	$current_packages = array();
		    	require_once PACKAGES_RELATIONSHIP_PATH . 'classes/CurrentInheritedPackage.php';
			    $currentPackage = new CurrentInheritedPackage();
			    $current_packages[] = $currentPackage->getInfo();

		    }
		    
		    return $current_packages;
		}
		osc_add_filter('package_info_current_filter', 'package_info_current');

		
		// Hook to show modal to choose a company from user profile
		function packages_relationship_user_profile() {
			include PACKAGES_RELATIONSHIP_PATH . 'parts/user/user-profile.php';
		}
		osc_add_hook('user_profile_form', 'packages_relationship_user_profile');

		/**
	     * If user logged is a Company and when the field 'b_company' (selected) change to 0 (User), 
	     * will delete links before do make update in user-public-profile.php
	     */
		function packages_relationship_before_update_profile() {
	        if (osc_logged_user_type()) {
	            if (Params::getParam('b_company') == 0) {
	                // Delete all data
	                PackagesRelationship::newInstance()->deleteLinksUserCompany(osc_logged_user_id());
	                PackagesRelationship::newInstance()->deleteAllRequests(osc_logged_user_id());
	                PackagesRelationship::newInstance()->removeBlockedFromUser(osc_logged_user_id());
	                PackagesRelationship::newInstance()->deleteAllEventsByToUser(osc_logged_user_id());
	            }
	        } else {
	            if (Params::getParam('b_company') == 1) {
	                // Delete all data
	                PackagesRelationship::newInstance()->deleteLinkByUserSon(osc_logged_user_id());
	                PackagesRelationship::newInstance()->deleteAllRequests(osc_logged_user_id());
	                PackagesRelationship::newInstance()->removeBlockedFromUser(osc_logged_user_id());
	                PackagesRelationship::newInstance()->deleteAllEventsByToUser(osc_logged_user_id());
	            }
	        }

	        // Packages relationship options (user-profile.php):

	        $receiveRequests = null;
			if (Params::getParam('b_packages_relationship_requests') === "1") $receiveRequests = 1;
			if (!Params::getParam('b_packages_relationship_requests')) $receiveRequests = 0;
			if ($receiveRequests != packages_relationship_user_requests_config()) {
				PackagesRelationship::newInstance()->receiveRequest($receiveRequests, osc_logged_user_id());	
			}

	        $link = PackagesRelationship::newInstance()->getLinkByUserSon(osc_logged_user_id());
	        if (osc_is_web_user_logged_in() && $link && osc_logged_user_type() == 0) {
	            PackagesRelationship::newInstance()->usePackage($link['pk_i_id'], Params::getParam('b_use_package'));
	        }

	    }
	    osc_add_hook('pre_user_post', 'packages_relationship_before_update_profile');


	    // Package's Company info
	    function packages_relationship_profile_info() {
			echo '<div id="packages-relationship-user-profile_info">';
			include PACKAGES_RELATIONSHIP_PATH . 'parts/user/user-profile_info.php';
			echo '</div>';
	    }
	    osc_add_hook('before_packages_profile_info', 'packages_relationship_profile_info');


	    /**
		* The content of this function it will show by ajax request on this url:
		* echo osc_base_url().'index.php?page=ajax&action=runhook&hook=packages_relationship_ajax';
		*/
		function packages_relationship_ajax() {
			$do = new CPackagesRelationshipAjax();
		    $do->doModel();
		}
		osc_add_hook('ajax_packages_relationship_ajax', 'packages_relationship_ajax');

		// Public profile frames
		function packages_relationship_public_profile() {
	    	if (get_current_url() == osc_user_public_profile_url()) {
	    		echo '<div id="packages-relationship-public_profile_buttons">';
	    		include PACKAGES_RELATIONSHIP_PATH . 'parts/user/user-public-profile_buttons.php';
	    		echo '</div>';

	    		echo '<div id="packages-relationship-public_profile">';
	    		include PACKAGES_RELATIONSHIP_PATH . 'parts/user/user-public-profile.php';
	    		echo '</div>';
	    	}
	    }
	    osc_add_hook('after-main','packages_relationship_public_profile');

		/**
		 * Dashboard modules (frames)
		 *
		 * [0] Company
		 * [1] Notifications
		 * [2] Requests/Invitations
		 * [3] Members
		 * [4] Blocked
		 */

		// [0] Company (modle for User type accounts)
		function packages_relationship_company_module($modules = null) {
			$return = printf('<div id="packages-relationship-company">');
			include PACKAGES_RELATIONSHIP_PATH . 'parts/user/company.php';
			$return .= printf('</div>');

			if (osc_get_preference('company_module', 'packages_relationship')) {
				array_unshift($modules, $return);
				return $modules;
			} else {
				$return;
			}
		}
		if (osc_get_preference('company_module', 'packages_relationship')) {
			osc_add_filter('packages_modules_filter', 'packages_relationship_company_module');
		} else {
			osc_add_hook('packages_relationship_company_module', 'packages_relationship_company_module');
		}

		// [1] Notificacions (module for both types of accounts)
		function packages_relationship_notifications_module($modules = null) {
			$return = printf('<div id="packages-relationship-notifications">');
			include PACKAGES_RELATIONSHIP_PATH . 'parts/user/notifications.php';
			$return .= printf('</div>');

			if (osc_get_preference('notifications_module', 'packages_relationship')) {
				array_unshift($modules, $return);
				return $modules;
			} else {
				$return;
			}
		}
		if (osc_get_preference('notifications_module', 'packages_relationship')) {
			osc_add_filter('packages_modules_filter', 'packages_relationship_notifications_module');
		} else {
			osc_add_hook('packages_relationship_notifications_module', 'packages_relationship_notifications_module');
		}

		// [2] Requests/Invitations (module for both types of accounts)
		function packages_relationship_requests_module($modules = null) {
			$return = printf('<div id="packages-relationship-requests">');
			include PACKAGES_RELATIONSHIP_PATH . 'parts/user/requests.php';
			$return = printf('</div>');

			if (osc_get_preference('requests_module', 'packages_relationship')) {
				array_unshift($modules, $return);
				return $modules;
			} else {
				$return;
			}
		}
		if (osc_get_preference('requests_module', 'packages_relationship')) {
			osc_add_filter('packages_modules_filter', 'packages_relationship_requests_module');
		} else {
			osc_add_hook('packages_relationship_requests_module', 'packages_relationship_requests_module');
		}

		// [3] Members (module for Company type accounts)
		function packages_relationship_members_module($modules = null) {
			$return = printf('<div id="packages-relationship-members">');
			include PACKAGES_RELATIONSHIP_PATH . 'parts/user/members.php';
			$return = printf('</div>');

			if (osc_get_preference('members_module', 'packages_relationship')) {
				array_unshift($modules, $return);
				return $modules;
			} else {
				$return;
			}
		}
		if (osc_get_preference('members_module', 'packages_relationship')) {
			osc_add_filter('packages_modules_filter', 'packages_relationship_members_module');
		} else {
			osc_add_hook('packages_relationship_members_module', 'packages_relationship_members_module');
		}

		// [4] Blocked (module for both types of accounts)
		function packages_relationship_blocked_module($modules = null) {
			$return = printf('<div id="packages-relationship-blocked">');
			include PACKAGES_RELATIONSHIP_PATH . 'parts/user/blocked.php';
			$return .= printf('</div>');

			if (osc_get_preference('blocked_module', 'packages_relationship')) {
				array_unshift($modules, $return);
				return $modules;
			} else {
				$return;
			}
		}
		if (osc_get_preference('blocked_module', 'packages_relationship')) {
			osc_add_filter('packages_modules_filter', 'packages_relationship_blocked_module');
		} else {
			osc_add_hook('packages_relationship_blocked_module', 'packages_relationship_blocked_module');
		}

		// JavaScript for all frames (for all modules)
	    function packages_relationship_public_profile_javascript() {
	    	include PACKAGES_RELATIONSHIP_PATH . 'parts/user/user-public-profile_buttons_javascript.php';
	    }
	    osc_add_hook('footer','packages_relationship_public_profile_javascript');

		function packages_relationship_profile_message() {
	    	if (!pay_per_post() && get_current_url() == osc_user_list_items_url()
	    		|| get_current_url() == osc_user_list_items_url()) {

	    		$package = get_package_info_current();

	            /**
	            * Package inherited:
	            */
	            // If the package is empty
	            if ($package && $package['status'] == 'inherited' && $package['defeated'] == true) {
	                
	                osc_add_flash_error_message(__("The package of your company is defeated, contact your company", 'packages_relationship'));
	            
	            }

	            // If the package is not expired but is defeated
	            if ($package && $package['defeated'] == false && $package['status'] == 'inherited' && $package['in_use'] == false) {
	                
	                osc_add_flash_error_message(__("You have used all the package you have been assigned, contact your company for an upgrade", 'packages_relationship'));
	            
	            }

	    	}
	    }
	    osc_add_hook('header', 'packages_relationship_profile_message');    


	    // When delete a user
	    function packages_relationship_when_delete_user($id) {
	        // Delete requests
	        PackagesRelationship::newInstance()->deleteAllRequests($id);
	        PackagesRelationship::newInstance()->deleteAllRequestsByToUser($id);

	        // Delete links
	        if (get_user_type($id)) {
	            PackagesRelationship::newInstance()->deleteLinksUserCompany($id);
	        } else {
	            PackagesRelationship::newInstance()->deleteLinkByUserSon($id);
	        }

	        // Delete blocked accounts
	        PackagesRelationship::newInstance()->removeBlockedFromUser($id);
	        PackagesRelationship::newInstance()->removeBlockedToUser($id);

	        // Delete events (notifications)
	        PackagesRelationship::newInstance()->deleteAllEventsByFromUser($id);
	        PackagesRelationship::newInstance()->deleteAllEventsByToUser($id);
	    }
	    osc_add_hook('delete_user', 'packages_relationship_when_delete_user');

	endif; // from [if] in line #23


	/**
	* Call uninstallation method from model (model/PackagesRelationship.php)
	*/
	function packages_relationship_uninstall() {
		PackagesRelationship::newInstance()->uninstall();
	}

	// Show an Uninstall link at plugins table
	osc_add_hook(osc_plugin_path(__FILE__) . '_uninstall', 'packages_relationship_uninstall');


	/**
	* Call the process of installation method 
	*/
	function packages_relationship_install() {
		PackagesRelationship::newInstance()->install();
	}

	// Register plugin's installation
	osc_register_plugin(osc_plugin_path(__FILE__), 'packages_relationship_install');
