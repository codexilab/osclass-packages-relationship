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
* Current Inherited Package
*/
class CurrentInheritedPackage extends CurrentPackage
{
	function __construct()
	{
		parent::__construct();
	}

	public function getInfo()
	{
		$freeItems 	= 0;
	    $packageInherited	= PackagesRelationship::newInstance()->getInherited(osc_logged_user_id());
	    $packageId 			= (isset($packageInherited['fk_i_package_id'])) ? $packageInherited['fk_i_package_id'] : 0;
	    $assignmentId 		= (isset($packageInherited['pk_i_id'])) ? $packageInherited['pk_i_id'] : 0;
	    $link 				= PackagesRelationship::newInstance()->getLinkByUserSon(osc_logged_user_id());

	    if ($packageInherited && $link && $link['b_inherited'] == true && $link['b_use_package'] == true) {

	    	$packageName 	= get_package_name($packageId);
	    	$fromDate 		= $packageInherited['dt_from_date'];
	    	$untilDate 		= $packageInherited['dt_to_date'];

	        $packageItems 		= get_package_free_items($packageId);
	        $publishedItems 	= Packages::newInstance()->getTotalItemsByAssignment($assignmentId);
	        $freeItems = $packageItems-$publishedItems; if ($freeItems < 0) $freeItems = 0;

	        /**
	        * Se toma el num de items activos a causa del punto 4 en el issue de taiga #73 (from Ali Moreno):
	        * https://tree.taiga.io/project/r3c4ll-curacao-propertiescom-template/us/73
	        *
	        * $totalActiveItems = Item::newInstance()->countItemTypesByUserID(osc_logged_user_id(), 'active');
	        */

	        $this->currentPackage['id'] 				= (int) $packageId;
	        $this->currentPackage['assignment_id']		= (int) $assignmentId;
			$this->currentPackage['name'] 				= (string) $packageName;
	        $this->currentPackage['free_items'] 		= (int) $freeItems; 		// Descending count, example: 3/5 (from five to three)
	        $this->currentPackage['published_items']	= (int) $publishedItems;	// Ascending count, example: 2/5 (from two to five)
	        $this->currentPackage['package_items'] 		= (int) $packageItems;
	        $this->currentPackage['status'] 			= "inherited";
	        $this->currentPackage['from_date'] 			= $fromDate;
	        $this->currentPackage['until_date'] 		= $untilDate;
	        
	        // true: is defeated | false: is not defeated
	        $this->currentPackage['defeated'] 			= check_date_interval($fromDate, $untilDate);
	    }

	    if ($packageInherited && $link && $link['b_inherited'] == true && $link['b_use_package'] == true && $freeItems == 0) {
	        
	        $this->currentPackage['in_use'] = false;

	    } elseif ($packageInherited && $link && $link['b_inherited'] == true && $link['b_use_package'] == true && $freeItems > 0 && $freeItems <= $packageItems) {
	        
	        $this->currentPackage['in_use'] = true;
	    }

	    return parent::getInfo();
	}
}