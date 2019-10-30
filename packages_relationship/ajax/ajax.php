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

define('IS_AJAX', true);

class CPackagesRelationshipAjax extends WebSecBaseModel
{
	//Business Layer...
    public function doModel()
    {
        // Check if user exist...
        $userById   = User::newInstance()->findByPrimaryKey(Params::getParam('id'));
        if ($userById) $userId = $userById['pk_i_id'];

        /**
         * For security it will only continue:
         * - If there are user logged
         * - If $userId exist in db
         * - If $userId is different to user logged id
         */
        if (osc_is_web_user_logged_in() && isset($userId) && $userId != osc_logged_user_id()) {

            $blockedFromUserLogged   = get_blocked_from_user_to_user(osc_logged_user_id(), $userId);
            $blockedFromUserProfile  = get_blocked_from_user_to_user($userId, osc_logged_user_id());

            if (!$blockedFromUserLogged || !$blockedFromUserProfile) :
                $requestFromUserLogged  = packages_relationship_request(osc_logged_user_id(), $userId);
                $requestFromUserProfile = packages_relationship_request($userId, osc_logged_user_id()); 

                $linkFromCompanyLogged  = packages_relationship_link(osc_logged_user_id(), $userId);
                $linkFromCompanyProfile = packages_relationship_link($userId, osc_logged_user_id());
            endif;

            switch (Params::getParam("action_specific")) {

                
                // Actions

                case 'send_request':
                    osc_csrf_check();
                    if ($requestFromUserLogged == null && $requestFromUserProfile == null && $linkFromCompanyLogged == null && $linkFromCompanyProfile == null && packages_relationship_user_requests_config($userId) == true) {
                        PackagesRelationship::newInstance()->createRequest(osc_logged_user_id(), $userId);
                    }
                    break;

                case 'remove_request':
                    osc_csrf_check();
                    if ($requestFromUserLogged || $requestFromUserProfile) {
                        if ($requestFromUserLogged) {
                            $requestId = $requestFromUserLogged['pk_i_id'];
                        } elseif($requestFromUserProfile) {
                            $requestId = $requestFromUserProfile['pk_i_id'];
                        }

                        // Add event if request not come of the same user
                        if ($requestFromUserLogged['fk_i_from_user_id'] != osc_logged_user_id()) {
                            
                            // If a Company rejected request from User
                            if (get_user_type($userId) == 0 && osc_logged_user_type() == 1) {
                                PackagesRelationship::newInstance()->addEvent(osc_logged_user_id(), $userId, 'request_rejected');
                                PackagesRelationship::newInstance()->addEvent($userId, osc_logged_user_id(), 'request_rejected');
                            } else {
                                PackagesRelationship::newInstance()->addEvent(osc_logged_user_id(), $userId, 'invitation_rejected');
                                PackagesRelationship::newInstance()->addEvent($userId, osc_logged_user_id(), 'invitation_rejected');
                            }

                        }

                        PackagesRelationship::newInstance()->deleteRequest($requestId);
                    }
                    break;

                case 'accept_request':
                    osc_csrf_check();
                    if ($requestFromUserProfile) {
                        // If exist invitation from COMPANY PROFILE PAGE to USER LOGGED
                        if (get_user_type($userId) == 1 && osc_logged_user_type() == 0) {
                            $userSon = PackagesRelationship::newInstance()->getLinkByUserSon(osc_logged_user_id());
                            if (!$userSon) {
                                // Accept invitation (user profile is a Company account type)
                                PackagesRelationship::newInstance()->createLink($userId, osc_logged_user_id());
                                PackagesRelationship::newInstance()->addEvent($userId, osc_logged_user_id(), 'request_accepted');
                                PackagesRelationship::newInstance()->addEvent(osc_logged_user_id(), $userId, 'invitation_accepted');
                                PackagesRelationship::newInstance()->deleteRequest($requestFromUserProfile['pk_i_id']);
                            }
                        // If exist request from USER PROFILE PAGE to COMPANY LOGGED
                        } else {
                            $userSon = PackagesRelationship::newInstance()->getLinkByUserSon($userId);
                            if (!$userSon) {
                                // Accept request (user profile is NOT a Company account type)
                                PackagesRelationship::newInstance()->createLink(osc_logged_user_id(), $userId);
                                PackagesRelationship::newInstance()->addEvent(osc_logged_user_id(), $userId, 'invitation_accepted');
                                PackagesRelationship::newInstance()->addEvent($userId, osc_logged_user_id(), 'request_accepted');
                                PackagesRelationship::newInstance()->deleteRequest($requestFromUserProfile['pk_i_id']);
                            }
                        }
                    }
                    break;

                case 'delete_link':
                    osc_csrf_check();
                    if ($linkFromCompanyLogged || $linkFromCompanyProfile) {
                        PackagesRelationship::newInstance()->addEvent(osc_logged_user_id(), $userId, 'link_deleted');

                        // User logged is a Company
                        if ($linkFromCompanyLogged) {
                            PackagesRelationship::newInstance()->deleteLink($linkFromCompanyLogged['pk_i_id']);
                        
                        // User logged is not a Company
                        } elseif ($linkFromCompanyProfile) {
                            PackagesRelationship::newInstance()->deleteLink($linkFromCompanyProfile['pk_i_id']);
                        }
                    }
                    break;

                case 'block_account':
                    osc_csrf_check();
                    // Does not continue if the user logged have already blocked the user
                    if (!$blockedFromUserLogged) {
                        PackagesRelationship::newInstance()->createBlocked(osc_logged_user_id(), $userId);
                        
                        // If exist request from USER LOGGED to USER PROFILE PAGE
                        if ($requestFromUserLogged) {
                            PackagesRelationship::newInstance()->addEvent(osc_logged_user_id(), $userId, 'request_rejected');
                            PackagesRelationship::newInstance()->deleteRequest($requestFromUserLogged['pk_i_id']);   
                        
                        // If exist request from USER PROFILE PAGE to USER LOGGED
                        } elseif ($requestFromUserProfile) {
                            PackagesRelationship::newInstance()->addEvent(osc_logged_user_id(), $userId, 'request_rejected');
                            PackagesRelationship::newInstance()->deleteRequest($requestFromUserProfile['pk_i_id']);
                        }

                    }
                    break;

                case 'unblock_account':
                    osc_csrf_check();
                    if ($blockedFromUserLogged && !$blockedFromUserProfile) {
                        PackagesRelationship::newInstance()->removeBlocked($blockedFromUserLogged['pk_i_id']);
                    }
                    break;

                case 'delete_event':
                    osc_csrf_check();
                    $event = PackagesRelationship::newInstance()->getEventById(Params::getParam('item_id'));
                    if ($event && $event['fk_i_from_user_id'] == $userId && $event['fk_i_to_user_id'] == osc_logged_user_id()) {
                        PackagesRelationship::newInstance()->deleteEvent($event['pk_i_id']);
                    }
                    break;

                case 'inheritance':
                    osc_csrf_check();
                    if ($linkFromCompanyLogged) {
                        $inheritPackage = false;
                        if ($linkFromCompanyLogged['b_inherited'] == 0) {
                            $inheritPackage = true;
                        }
                        PackagesRelationship::newInstance()->inheritPackage($linkFromCompanyLogged['pk_i_id'], $inheritPackage);
                    }
                    break;

                
                // Public profile frames

                case 'public_profile_buttons':
                    $this->doView('user/user-public-profile_buttons.php');
                    break;

                case 'public_profile':
                    $this->doView('user/user-public-profile.php');
                    break;

                
                // Dashboard frames

                case 'company':
                    $this->doView('user/company.php');
                    break;

                case 'notifications':
                    $this->doView('user/notifications.php');
                    break;

                case 'members':
                    $this->doView('user/members.php');
                    break;

                case 'requests':
                    $this->doView('user/requests.php');
                    break;

                case 'blocked':
                    $this->doView('user/blocked.php');
                    break;
            }
        }
    }

    //hopefully generic...
    function doView($file)
    {
        include PACKAGES_RELATIONSHIP_PATH. 'parts/'.$file;
    }
}