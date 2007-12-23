<?php
// $Id$
// ------------------------------------------------------------------------ //
// 				 XOOPS - PHP Content Management System                      //
//					 Copyright (c) 2000 XOOPS.org                           //
// 						<http://www.xoops.org/>                             //
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License, or        //
// (at your option) any later version.                                      //

// You may not change or alter any portion of this comment or credits       //
// of supporting developers from this source code or any supporting         //
// source code which is considered copyrighted (c) material of the          //
// original comment or credit authors.                                      //
// This program is distributed in the hope that it will be useful,          //
// but WITHOUT ANY WARRANTY; without even the implied warranty of           //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
// GNU General Public License for more details.                             //

// You should have received a copy of the GNU General Public License        //
// along with this program; if not, write to the Free Software              //
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------ //
// URL: http://www.xoops.org/												//
// Project: The XOOPS Project                                               //
// -------------------------------------------------------------------------//

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}
include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobject.php";
class SmartbillingProject extends SmartObject {

    function SmartbillingProject() {
        $this->quickInitVar('projectid', XOBJ_DTYPE_INT, true);
        $this->quickInitVar('project_name', XOBJ_DTYPE_TXTBOX, true, _CO_SBILLING_PROJECT_NAME, _CO_SBILLING_PROJECT_NAME_DSC);
        $this->quickInitVar('project_description', XOBJ_DTYPE_TXTAREA, false, _CO_SBILLING_PROJECT_DESCRIPTION, _CO_SBILLING_PROJECT_DESCRIPTION_DSC);
    }

    function getVar($key, $format = 's') {
        if ($format == 's' && in_array($key, array())) {
            return call_user_func(array($this,$key));
        }
        return parent::getVar($key, $format);
    }
}
class SmartbillingProjectHandler extends SmartPersistableObjectHandler {
    function SmartbillingProjectHandler($db) {
        $this->SmartPersistableObjectHandler($db, 'project', 'projectid', 'project_name', 'project_description', 'smartbilling');
    }

    function beforeDelete(&$obj) {
		$smartbilling_activity_project_handler = xoops_getModuleHandler('activity_project', 'smartbilling');
		$projectid = $obj->getVar('projectid', 'e');
		return $smartbilling_activity_project_handler->getActivitiesCountFrom($projectid);
    }

    function getProjectsList() {
    	$aProjects = $this->getList();
    	$ret = array(0=>'---');
    	foreach($aProjects as $projectid=>$title) {
    		$ret[$projectid] = $title;
    	}
    	return $ret;

    }
}
?>