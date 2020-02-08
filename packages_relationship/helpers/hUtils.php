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
 
/**
 * Helpers
 * @package Packages relationship
 * @subpackage Helpers
 * @author CodexiLab
 */

function packages_relationship_user_requests_config($userId = null) {
    if ($userId == null) {
        $user = User::newInstance()->findByPrimaryKey(osc_logged_user_id());
        if ($user && isset($user['b_packages_relationship_requests'])) return (bool) $user['b_packages_relationship_requests'];
        return false;
    } else {
        $user = User::newInstance()->findByPrimaryKey($userId);
        if ($user && isset($user['b_packages_relationship_requests'])) return (bool) $user['b_packages_relationship_requests'];
        return false;
    }
}

if (!function_exists('packages_relationship_request')) {
    function packages_relationship_request($fromUserId = null, $toUserId = null) {
        if (View::newInstance()->_exists('request')) {
            return View::newInstance()->_get('request');
        } elseif ($fromUserId != null && $toUserId != null) {
            return PackagesRelationship::newInstance()->getRequest($fromUserId, $toUserId);
        } else {
            return false;
        }
    }
}

/**
 * Get events about an account.
 *
 * @param int $id
 * @return string
 */
if (!function_exists('packages_relationship_request_from_user')) {
    function packages_relationship_request_from_user($fromUserId = null) {
        if (View::newInstance()->_exists('request')) {
            return View::newInstance()->_get('request');
        } elseif ($fromUserId != null) {
            return PackagesRelationship::newInstance()->getRequestByFromUser($fromUserId);
        } elseif($fromUserId == null && osc_is_web_user_logged_in()) {
            return PackagesRelationship::newInstance()->getRequestByFromUser(osc_logged_user_id());
        } else {
            return false;
        }
    }
}

/**
 * Get events about an account.
 *
 * @param int $id
 * @return string
 */
if (!function_exists('packages_relationship_events')) {
    function packages_relationship_events($id = null) {
    	if (View::newInstance()->_exists('events')) {
    		return View::newInstance()->_get("events");
    	} elseif ($id != null) {
    		return PackagesRelationship::newInstance()->getEventsByToUser($id);
    	} elseif($id == null && osc_is_web_user_logged_in()) {
    		return PackagesRelationship::newInstance()->getEventsByToUser(osc_logged_user_id());
    	} else {
            return false;
        }
    }
}

/**
 * Get requests about an account.
 *
 * @param int $id
 * @return string
 */
if (!function_exists('packages_relationship_requests')) {
    function packages_relationship_requests($id = null) {
        if (View::newInstance()->_exists('requests')) {
            return View::newInstance()->_get("requests");
        } elseif ($id != null) {
            return PackagesRelationship::newInstance()->getRequestsByToUser($id);
        } elseif($id == null && osc_is_web_user_logged_in()) {
            return PackagesRelationship::newInstance()->getRequestsByToUser(osc_logged_user_id());
        } else {
            return false;
        }
    }
}

/**
 * Get requests sent about an account.
 *
 * @param int $id
 * @return string
 */
if (!function_exists('packages_relationship_requests_sent')) {
    function packages_relationship_requests_sent($fromUserId = null) {
        if ($fromUserId == null && View::newInstance()->_exists('requests_sent')) {
            return View::newInstance()->_get("requests_sent");
        } elseif ($fromUserId != null) {
            return PackagesRelationship::newInstance()->getRequestsByFromUser($fromUserId);
        } elseif ($fromUserId == null && osc_is_web_user_logged_in()) {
            return PackagesRelationship::newInstance()->getRequestsByFromUser(osc_logged_user_id());
        } else {
            return false;
        }
    }
}




if (!function_exists('packages_relationship_link_by_user_son')) {
    function packages_relationship_link_by_user_son($userSonId = null) {
        if (View::newInstance()->_exists('linkByUserSon')) {
            return View::newInstance()->_get("linkByUserSon");
        } elseif ($userSonId != null) {
            return PackagesRelationship::newInstance()->getLinkByUserSon($userSonId);
        } elseif ($userSonId == null && osc_is_web_user_logged_in()) {
            return PackagesRelationship::newInstance()->getLinkByUserSon(osc_logged_user_id());
        } else {
            return false;
        }
    }
}

if (!function_exists('packages_relationship_link')) {
    function packages_relationship_link($userCompanyId = null, $userSonId = null) {
        if (View::newInstance()->_exists('link')) {
            return View::newInstance()->_get("link");
        } else if ($userCompanyId != null && $userSonId != null) {
            return PackagesRelationship::newInstance()->getLink($userCompanyId, $userSonId);
        } else {
            return false;
        }
    }
}

/**
 * Get links.
 *
 * @param int $id
 * @return string
 */
if (!function_exists('packages_relationship_links')) {
    function packages_relationship_links($id = null) {
        if (View::newInstance()->_exists('links')) {
            return View::newInstance()->_get("links");
        } elseif ($id != null) {
            return PackagesRelationship::newInstance()->getLinksByUserCompany($id);
        } elseif($id == null && osc_is_web_user_logged_in()) {
            return PackagesRelationship::newInstance()->getLinksByUserCompany(osc_logged_user_id());
        } else {
            return false;
        }
    }
}

/**
 * Get blocked users about an account.
 *
 * @param int $id
 * @return string
 */
if (!function_exists('packages_relationship_blocked_users')) {
    function packages_relationship_blocked_users($id = null) {
        if (View::newInstance()->_exists('blocked_users')) {
            return View::newInstance()->_get("blocked_users");
        } elseif ($id != null) {
            return PackagesRelationship::newInstance()->getUsersBlockedFromUser($id);
        } elseif($id == null && osc_is_web_user_logged_in()) {
            return PackagesRelationship::newInstance()->getUsersBlockedFromUser(osc_logged_user_id());
        } else {
            return false;
        }
    }
}

/**
 * Get blocked users about an account.
 *
 * @param int $id
 * @return string
 */
if (!function_exists('get_blocked_from_user_to_user')) {
    function get_blocked_from_user_to_user($fromUserId, $toUserId) {
        return PackagesRelationship::newInstance()->getBlockedFromUserToUser($fromUserId, $toUserId);
    }
}

function packages_relationship_add_event($fromUserId, $toUserId, $type) {
    PackagesRelationship::newInstance()->addEvent($fromUserId, $toUserId, $type);
}

// NOTA: Aplicar aquí el prinft
function packages_relationship_event_description($fromUserId, $type) {
    $userPublicProfileUrl = osc_user_public_profile_url($fromUserId);
    $userName = get_user_name($fromUserId);

    switch ($type) {
        case 'link_deleted':
            // If user logged is not a Company
            if (osc_logged_user_type() == 0) {
                printf(__('Removed from <a href="%s">%s</a>', 'packages_relationship'), $userPublicProfileUrl, $userName);
            } else {
                printf(__('<a href="%s">%s</a> has left the company', 'packages_relationship'), $userPublicProfileUrl, $userName);
            }
            break;

        case 'request_rejected':
            // If user logged is a Company
            if (osc_logged_user_type() == 0) {
                printf(__('Request rejected by <a href="%s">%s</a>', 'packages_relationship'), $userPublicProfileUrl, $userName);
            } else {
                printf(__('Request rejected from <a href="%s">%s</a>', 'packages_relationship'), $userPublicProfileUrl, $userName);
            }
            break;

        case 'invitation_rejected':
            // If user logged is not a Company
            if (osc_logged_user_type() == 1) {
                printf(__('Invitation rejected by <a href="%s">%s</a>', 'packages_relationship'), $userPublicProfileUrl, $userName);
            } else {
                printf(__('Invitation rejected from <a href="%s">%s</a>', 'packages_relationship'), $userPublicProfileUrl, $userName);
            }
            break;

        case 'request_accepted':
            // If user logged is not a Company
            if (osc_logged_user_type() == 0) {
                printf(__('Invitation accepted from <a href="%s">%s</a>', 'packages_relationship'), $userPublicProfileUrl, $userName);
            } else {
                printf(__('Request accepted from <a href="%s">%s</a>', 'packages_relationship'), $userPublicProfileUrl, $userName);
            }
            break;

        case 'invitation_accepted':
            // If user logged is not a Company
            if (osc_logged_user_type() == 1) {
                printf(__('Invitation accepted by <a href="%s">%s</a>', 'packages_relationship'), $userPublicProfileUrl, $userName);
            } else {
                printf(__('Request accepted by <a href="%s">%s</a>', 'packages_relationship'), $userPublicProfileUrl, $userName);
            }
            break;
    }
}