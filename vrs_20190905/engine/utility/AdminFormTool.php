<?php
 // // @JanusEngine:license-start
// --------------------------------------------------------------------------------------------
// Janus Engine 
//
// This file file is part of the Janus-Engine project.
// @see       : https://github.com/4E71-NOP/JanusEngine
//
// @license   : Creative Commons licence CC-by-nc-sa (https://creativecommons.org/licenses/by-nc-sa/4.0/)
// @author    : Faust MARIA DE AREVALO (original founder) <faust@rootwave.com>
// @copyright : 2005 - ∞ Faust MARIA DE AREVALO
//
// @note      : This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY; 
//              without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
//
// Check README.md for more details
// --------------------------------------------------------------------------------------------
// @JanusEngine:license-end



class AdminFormTool {
	private static $Instance = null;
	
	private function __construct(){}
	
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new AdminFormTool();
		}
		return self::$Instance;
	}
	
	public function checkAdminDashboardForm (&$infos) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->ThemeDataObj;
		
		$Block = $ThemeDataObj->getThemeName().$infos['block'];
		
		$Content = "";
		if ( $bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'origin') == 'AdminDashboard'
				&& $bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode') == 'edit'
				&& $bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'modification') != 'on'
				) {
					$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . ' : modification checkbox forgotten'));
					$Content .= "<p class='".$Block."_error'>".$bts->I18nTransObj->getI18nTransEntry('userForgotConfirmation')."</p>\r";
		}
		if ( $bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'origin') == 'AdminDashboard'
				&& $bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode') == 'create'
				&& $bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'creation') != 'on' ) {
					$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . ' : deletion checkbox forgotten'));
					$Content .= "<p class='".$Block."_erreur'>".$bts->I18nTransObj->getI18nTransEntry('userForgotCreation')."</p>\r";
					$bts->RequestDataObj->setRequestDataSubEntry('formGenericData', 'mode', 'create');
					$bts->RequestDataObj->setRequestDataSubEntry('formGenericData', 'modification', '');
		}
		if ( $bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'origin') == 'AdminDashboard'
				&& $bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode') == 'delete'
				&& $bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'deletion') != 'on' ) {
					$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . ' : deletion checkbox forgotten'));
					$Content .= "<p class='".$Block."_erreur'>".$bts->I18nTransObj->getI18nTransEntry('userForgotDeletion')."</p>\r";
					$bts->RequestDataObj->setRequestDataSubEntry('formGenericData', 'mode', 'edit');
					$bts->RequestDataObj->setRequestDataSubEntry('formGenericData', 'modification', '');
		}
		return $Content;
	}
	
	//@formatter:off
	//@formatter:on
}

?>