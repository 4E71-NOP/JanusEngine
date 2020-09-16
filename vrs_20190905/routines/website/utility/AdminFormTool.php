<?php
 /*Hydre-licence-debut*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@club-internet.fr
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/

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
		$I18nObj = I18n::getInstance();
		$LMObj = LogManagement::getInstance();
		$RequestDataObj = RequestData::getInstance();

		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		
		$Block = $ThemeDataObj->getThemeName().$infos['block'];
		
		$Content = "";
		if ( $RequestDataObj->getRequestDataSubEntry('formGenericData', 'origin') == 'AdminDashboard'
				&& $RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode') == 'edit'
				&& $RequestDataObj->getRequestDataSubEntry('formGenericData', 'modification') != 'on'
				) {
					$LMObj->InternalLog('AdminDashboard modification checkbox forgotten');
					$Content .= "<p class='".$Block."_erreur ".$Block."_tb3'>".$I18nObj->getI18nEntry('userForgotConfirmation')."</p>\r";
		}
		if ( $RequestDataObj->getRequestDataSubEntry('formGenericData', 'origin') == 'AdminDashboardCreate'
				&& $RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode') == 'edit'
				&& $RequestDataObj->getRequestDataSubEntry('formGenericData', 'creation') != 'on' ) {
					$LMObj->InternalLog('AdminDashboard deletion checkbox forgotten');
					$Content .= "<p class='".$Block."_erreur ".$Block."_tb3'>".$I18nObj->getI18nEntry('userForgotCreation')."</p>\r";
					$RequestDataObj->setRequestDataSubEntry('formGenericData', 'mode', 'create');
					$RequestDataObj->setRequestDataSubEntry('formGenericData', 'modification', '');
		}
		if ( $RequestDataObj->getRequestDataSubEntry('formGenericData', 'origin') == 'AdminDashboard'
				&& $RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode') == 'delete'
				&& $RequestDataObj->getRequestDataSubEntry('formGenericData', 'deletion') != 'on' ) {
					$LMObj->InternalLog('AdminDashboard deletion checkbox forgotten');
					$Content .= "<p class='".$Block."_erreur ".$Block."_tb3'>".$I18nObj->getI18nEntry('userForgotDeletion')."</p>\r";
					$RequestDataObj->setRequestDataSubEntry('formGenericData', 'mode', 'edit');
					$RequestDataObj->setRequestDataSubEntry('formGenericData', 'modification', '');
		}
		return $Content;
	}
	
	//@formatter:off
	//@formatter:on
}

?>