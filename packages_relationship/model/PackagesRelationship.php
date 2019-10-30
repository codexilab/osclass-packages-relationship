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
 
/**
 * Doc PackagesRelationship Model.
 * 
 * Data model of Packages plugin which inherits functions to manage data
 * of the DAO mother class, developed by Osclass for SQL querys.
 * 
 * @package DAO.PackagesRelationship
 */

class PackagesRelationship extends DAO
{
	
	private static $instance;

    /**
     * Singleton Pattern
     * 
     * @package DAO.Packages
     * @access public 
     */
	public static function newInstance()
	{
		if (!self::$instance instanceof self) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	function __construct()
	{
		parent::__construct();
	}

	/**
     * SQL Plugin's table
     *
     * Return only the table names
     * 
     * @package DAO.PackagesRelationship
     * @access public 
     * @return string Full table name
     */
	public function getTable_packages_relationship_link()
	{
        return DB_TABLE_PREFIX.'t_packages_relationship_link';
    }

    public function getTable_packages_relationship_blocked()
    {
        return DB_TABLE_PREFIX.'t_packages_relationship_blocked';
    }

    public function getTable_packages_relationship_request()
    {
        return DB_TABLE_PREFIX.'t_packages_relationship_request';
    }

    public function getTable_packages_relationship_event()
    {
        return DB_TABLE_PREFIX.'t_packages_relationship_event';
    }

    public function import($file)
    {
        $sql  = file_get_contents($file);

        if(!$this->dao->importSQL($sql)) {
            throw new Exception("Error importSQL::PackagesRelationship<br>".$file);
        }
	}

	/**
     * Install all data of plugin to db.
     *
     * This function thogether with prevously function "import($file)" import the content from sql file
     * to the db, so it save the data t_preference table of Osclass which is using the plugin:
     * - Information about plugin version.
     * - Configuration of habilitation of all Package plugin.
     * - Configuration of Default package in the user register.
     *
     * @package DAO.PackagesRelationship
     * @access public 
     */
	public function install()
	{
		$this->import(PACKAGES_RELATIONSHIP_PATH . 'struct.sql');
		osc_set_preference('version', '1.0.0', 'packages_relationship', 'STRING');

        osc_set_preference('notifications_module', 1, 'packages_relationship', 'BOOLEAN');
        osc_set_preference('company_module', 1, 'packages_relationship', 'BOOLEAN');
        osc_set_preference('members_module', 1, 'packages_relationship', 'BOOLEAN');
        osc_set_preference('requests_module', 1, 'packages_relationship', 'BOOLEAN');
        osc_set_preference('blocked_module', 1, 'packages_relationship', 'BOOLEAN');
        
		osc_run_hook('packages_relationship_install');
	}

	/**
     * Removal about of data related with Packages Relationship extension from db.
     *
     * Is based from DAO class to make DROP TABLE queries for each one of tables,
     * therefore delete completly the tables said previously.
     * So delete the added information in t_preference.
     *
     * @package DAO.PackagesRelationship
     * @access public 
     */
	public function uninstall()
	{
        $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_packages_relationship_link()));
        $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_packages_relationship_blocked()));
        $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_packages_relationship_request()));
        $this->dao->query(sprintf('DROP TABLE %s', $this->getTable_packages_relationship_event()));
        $this->dao->query('ALTER TABLE '.DB_TABLE_PREFIX.'t_user DROP b_packages_relationship_requests');

        Preference::newInstance()->delete(array('s_section' => 'packages_relationship'));
        osc_run_hook('packages_relationship_uninstall');
	}

    public function getRequest($fromUserId, $toUserId)
    {
        $this->dao->select('*');
        $this->dao->from($this->getTable_packages_relationship_request());
        $this->dao->where('fk_i_from_user_id', $fromUserId);
        $this->dao->where('fk_i_to_user_id', $toUserId);
        $result = $this->dao->get();
        if($result) {
            return $result->row();
        }
        return false;
    }

    public function getRequests() {
        $this->dao->select('*');
        $this->dao->from($this->getTable_packages_relationship_request());
        $this->dao->orderBy('dt_date', 'DESC');
        $result = $this->dao->get();
        if($result) {
            return $result->result();
        }
        return array();
    }

    // NOTE: Change name to 'getRequestByIdFrom'
    public function getRequestByFromUser($fromUserId)
    {
        $this->dao->select('*');
        $this->dao->from($this->getTable_packages_relationship_request());
        $this->dao->where('fk_i_from_user_id', $fromUserId);
        $result = $this->dao->get();
        if($result) {
            return $result->row();
        }
        return false;
    }

    public function getLinkByUserSon($userSonId)
    {
        $this->dao->select('*') ;
        $this->dao->from($this->getTable_packages_relationship_link());
        $this->dao->where('fk_i_user_son_id', $userSonId);
        $result = $this->dao->get();
        if($result) {
            return $result->row();
        }
        return false;
    }

    // Anteriormente como 'getLastRequestByIdFrom'
    public function getLastRequestByFromUser($fromUserId)
    {
        $this->dao->select('*');
        $this->dao->from($this->getTable_packages_relationship_request());
        $this->dao->where("fk_i_from_user_id", $fromUserId);
        $this->dao->orderBy('dt_date', 'DESC');
        $result = $this->dao->get();
        if($result) {
            return $result->row();
        }
        return false;
    }

    // Anteriormente como 'getRequestsByIdTo'
    public function getRequestsByToUser($toUserId)
    {
        $this->dao->select('*');
        $this->dao->from($this->getTable_packages_relationship_request());
        $this->dao->where("fk_i_to_user_id", $toUserId);
        $result = $this->dao->get();
        if($result) {
            return $result->result();
        }
        return array();
    }

    // Anteriormente como 'getRequestsByIdFrom'
    public function getRequestsByFromUser($fromUserId)
    {
        $this->dao->select('*');
        $this->dao->from($this->getTable_packages_relationship_request());
        $this->dao->where("fk_i_from_user_id", $fromUserId);
        $result = $this->dao->get();
        if($result) {
            return $result->result();
        }
        return array();
    }

    public function createRequest($fromUserId, $toUserId)
    {
        $sendRequest = array('fk_i_from_user_id' => $fromUserId, 'fk_i_to_user_id' => $toUserId, 'dt_date' => date('Y-m-d H:i:s'));
        return $this->dao->insert($this->getTable_packages_relationship_request(), $sendRequest);
    }

    public function deleteRequest($id)
    {
        return $this->dao->delete($this->getTable_packages_relationship_request(), array('pk_i_id' => $id));
    }

    public function deleteAllRequests($userId)
    {
        $requests = $this->getRequestsByFromUser($userId);
        foreach ($requests as $request) {
            $this->deleteRequest($request['pk_i_id']);
        }
    }

    // Anteriormente como 'deleteAllRequestsByUserTo'
    public function deleteAllRequestsByToUser($userId)
    {
        $requests = $this->getRequestsByToUser($userId);
        foreach ($requests as $request) {
            $this->deleteRequest($request['pk_i_id']);
        }
    }

    public function getLink($userCompanyId, $userSonId)
    {
        $this->dao->select('*');
        $this->dao->from($this->getTable_packages_relationship_link());
        $this->dao->where('fk_i_user_id', $userCompanyId);
        $this->dao->where('fk_i_user_son_id', $userSonId);
        $result = $this->dao->get();
        if($result) {
            return $result->row();
        }
        return false;
    }

    public function getLinkById($linkId)
    {
        $this->dao->select('*');
        $this->dao->from($this->getTable_packages_relationship_link());
        $this->dao->where('pk_i_id', $linkId);
        $result = $this->dao->get();
        if($result) {
            return $result->row();
        }
        return false;
    }

    public function getLinks()
    {
        $this->dao->select('*');
        $this->dao->from($this->getTable_packages_relationship_link());
        $result = $this->dao->get();
        if($result) {
            return $result->result();
        }
        return array();
    }

    public function createLink($userCompanyId, $userSonId)
    {
        $createLink = array('fk_i_user_id' => $userCompanyId, 'fk_i_user_son_id' => $userSonId, 'dt_date' => date('Y-m-d H:i:s'));
        return $this->dao->insert($this->getTable_packages_relationship_link(), $createLink);        
    }

    public function getLinksByUserCompany($userCompanyId)
    {
        $this->dao->select('*');
        $this->dao->from($this->getTable_packages_relationship_link());
        $this->dao->where("fk_i_user_id", $userCompanyId);
        $result = $this->dao->get();
        if($result) {
            return $result->result();
        }
        return array();
    }

    // Anteriormente como 'enablePackage'
    public function inheritPackage($linkId, $value)
    {
        return $this->dao->update($this->getTable_packages_relationship_link(), array('b_inherited' => $value), array('pk_i_id' => $linkId));
    }

    public function usePackage($linkId, $value)
    {
        return $this->dao->update($this->getTable_packages_relationship_link(), array('b_use_package' => $value), array('pk_i_id' => $linkId));
    }

    public function deleteLink($linkId)
    {
        return $this->dao->delete($this->getTable_packages_relationship_link(), array('pk_i_id' => $linkId));
    }

    public function deleteLinksUserCompany($userCompanyId)
    {
        $links = $this->getLinksByUserCompany($userCompanyId);
        if ($links) {
            foreach ($links as $link) {
                $this->deleteLink($link['pk_i_id']);
            }
        }
    }

    public function receiveRequest($value, $id)
    {
        $sql = 'UPDATE '.DB_TABLE_PREFIX.'t_user SET b_packages_relationship_requests = '.$value.' WHERE '.DB_TABLE_PREFIX.'t_user.pk_i_id = '.$id;
        return $this->dao->query($sql);
    }

    // Anteriormente como 'deleteLinkUserSon'
    public function deleteLinkByUserSon($userSonId)
    {
        $link = $this->getLinkByUserSon($userSonId);
        $this->deleteLink($link['pk_i_id']);
    }

    // Anteriormente como 'createLock'
    public function createBlocked($fromUserId, $toUserId)
    {
        $createBlocked = array('fk_i_from_user_id' => $fromUserId, 'fk_i_to_user_id' => $toUserId, 'dt_date' => date('Y-m-d H:i:s'));
        return $this->dao->insert($this->getTable_packages_relationship_blocked(), $createBlocked);
    }

    // Anteriormente como 'getLock'
    public function getBlockedFromUserToUser($fromUserId, $toUserId)
    {
        $this->dao->select('*');
        $this->dao->from($this->getTable_packages_relationship_blocked());
        $this->dao->where('fk_i_from_user_id', $fromUserId);
        $this->dao->where('fk_i_to_user_id', $toUserId);
        $result = $this->dao->get();
        if($result) {
            return $result->row();
        }
        return false;
    }

    // Anteriormente como 'getLocks'
    public function getUsersBlocked()
    {
        $this->dao->select('*');
        $this->dao->from($this->getTable_packages_relationship_blocked());
        $this->dao->orderBy('dt_date', 'DESC');
        $result = $this->dao->get();
        if($result) {
            return $result->result();
        }
        return array();
    }

    // Anteriormente como 'getBlocked'
    public function getUsersBlockedFromUser($fromUserId)
    {
        $this->dao->select('*');
        $this->dao->from($this->getTable_packages_relationship_blocked());
        $this->dao->where("fk_i_from_user_id", $fromUserId);
        $result = $this->dao->get();
        if($result) {
            return $result->result();
        }
        return array();
    }

    // Anteriormente como 'getLocksToUser'
    public function getUsersBlockedToUser($toUserId)
    {
        $this->dao->select('*');
        $this->dao->from($this->getTable_packages_relationship_blocked());
        $this->dao->where("fk_i_to_user_id", $toUserId);
        $result = $this->dao->get();
        if($result) {
            return $result->result();
        }
        return array();
    }

    // Anteriormente como 'deleteLock'
    public function removeBlocked($blockedId)
    {
        return $this->dao->delete($this->getTable_packages_relationship_blocked(), array('pk_i_id' => $blockedId));
    }

    // Anteriormente como 'deleteLocksFromUser'
    public function removeBlockedFromUser($fromUserId)
    {
        $usersBlocked = $this->getUsersBlockedFromUser($fromUserId);
        if ($usersBlocked) {
            foreach ($usersBlocked as $userBlocked) {
                $this->removeBlocked($userBlocked['pk_i_id']);
            }
        }
    }

    // Ateriormente como 'deleteLocksToUser'
    public function removeBlockedToUser($toUserId)
    {
        $usersBlocked = $this->getUsersBlockedToUser($toUserId);
        if ($usersBlocked) {
            foreach ($usersBlocked as $userBlocked) {
                $this->removeBlocked($userBlocked['pk_i_id']);
            }
        }
    }

    public function addEvent($fromUserId, $toUserId, $type, $date = null)
    {
        if ($date == null) $date = date("Y-m-d H:i:s");

        $addEvt = array('fk_i_from_user_id' => $fromUserId, 'fk_i_to_user_id' => $toUserId, 'dt_date' => $date, 's_type' => $type);
        return $this->dao->insert($this->getTable_packages_relationship_event(), $addEvt);
    }

    public function getEventsByFromUser($fromUserId)
    {
        $this->dao->select('*');
        $this->dao->from($this->getTable_packages_relationship_event());
        $this->dao->where("fk_i_from_user_id", $fromUserId);
        $this->dao->orderBy('dt_date', 'DESC');
        $result = $this->dao->get();
        if($result) {
            return $result->result();
        }
        return array();
    }

    // Anteriormente como 'getEventsByToUser'
    public function getEventsByToUser($toUserId)
    {
        $this->dao->select('*');
        $this->dao->from($this->getTable_packages_relationship_event());
        $this->dao->where("fk_i_to_user_id", $toUserId);
        $this->dao->orderBy('dt_date', 'DESC');
        $result = $this->dao->get();
        if($result) {
            return $result->result();
        }
        return array();
    }

    public function getEvent($fromUserId, $toUserId)
    {
        $this->dao->select('*');
        $this->dao->from($this->getTable_packages_relationship_event());
        $this->dao->where('fk_i_from_user_id', $fromUserId);
        $this->dao->where('fk_i_to_user_id', $toUserId);
        $result = $this->dao->get();
        if($result) {
            return $result->row();
        }
        return false;
    }

    public function getEventById($eventId)
    {
        $this->dao->select('*');
        $this->dao->from($this->getTable_packages_relationship_event());
        $this->dao->where('pk_i_id', $eventId);
        $result = $this->dao->get();
        if($result) {
            return $result->row();
        }
        return false;
    }

    public function deleteEvent($id)
    {
        return $this->dao->delete($this->getTable_packages_relationship_event(), array('pk_i_id' => $id));
    }

    // Anteriormente como 'deleteAllEventsByUserTo'
    public function deleteAllEventsByToUser($toUserId)
    {
        $events = $this->getEventsByToUser($toUserId);
        if ($events) {
            foreach ($events as $event) {
                $this->deleteEvent($event['pk_i_id']);
            }
        }
    }

    // Anteriormente como 'deleteAllEventsByUserFrom'
    public function deleteAllEventsByFromUser($fromUserId)
    {
        $events = $this->getEventsByFromUser($fromUserId);
        if ($events) {
            foreach ($events as $event) {
                $this->deleteEvent($event['pk_i_id']);
            }
        }
    }

    /**
     * Return user data father passing like parametre the Id if the user son
     * without before having checked that exist the conexion.
     *
     * @package DAO.PackagesRelationship
     * @access public 
     * @param string $userSonId
     * @return string $result Return data of user company (father)
     * @return boolean
     */
    public function getInherited($userSonId)
    {
        if (class_exists('Packages')) {
            $link = $this->getLinkByUserSon($userSonId);
            $result = array();

            // If exist the link or conexion
            if ($link) {

                // Id from company
                $result = Packages::newInstance()->getAssigned($link['fk_i_user_id']);
                return $result;
            }
        }
        return false;
    }
}