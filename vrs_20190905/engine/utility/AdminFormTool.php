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
		$cs = CommonSystem::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		
		$Block = $ThemeDataObj->getThemeName().$infos['block'];
		
		$Content = "";
		if ( $cs->RequestDataObj->getRequestDataSubEntry('formGenericData', 'origin') == 'AdminDashboard'
				&& $cs->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode') == 'edit'
				&& $cs->RequestDataObj->getRequestDataSubEntry('formGenericData', 'modification') != 'on'
				) {
					$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => 'AdminDashboard modification checkbox forgotten'));
					$Content .= "<p class='".$Block."_erreur ".$Block."_tb3'>".$cs->I18nObj->getI18nEntry('userForgotConfirmation')."</p>\r";
		}
		if ( $cs->RequestDataObj->getRequestDataSubEntry('formGenericData', 'origin') == 'AdminDashboardCreate'
				&& $cs->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode') == 'edit'
				&& $cs->RequestDataObj->getRequestDataSubEntry('formGenericData', 'creation') != 'on' ) {
					$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => 'AdminDashboard deletion checkbox forgotten'));
					$Content .= "<p class='".$Block."_erreur ".$Block."_tb3'>".$cs->I18nObj->getI18nEntry('userForgotCreation')."</p>\r";
					$cs->RequestDataObj->setRequestDataSubEntry('formGenericData', 'mode', 'create');
					$cs->RequestDataObj->setRequestDataSubEntry('formGenericData', 'modification', '');
		}
		if ( $cs->RequestDataObj->getRequestDataSubEntry('formGenericData', 'origin') == 'AdminDashboard'
				&& $cs->RequestDataObj->getRequestDataSubEntry('formGenericData', 'mode') == 'delete'
				&& $cs->RequestDataObj->getRequestDataSubEntry('formGenericData', 'deletion') != 'on' ) {
					$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => 'AdminDashboard deletion checkbox forgotten'));
					$Content .= "<p class='".$Block."_erreur ".$Block."_tb3'>".$cs->I18nObj->getI18nEntry('userForgotDeletion')."</p>\r";
					$cs->RequestDataObj->setRequestDataSubEntry('formGenericData', 'mode', 'edit');
					$cs->RequestDataObj->setRequestDataSubEntry('formGenericData', 'modification', '');
		}
		return $Content;
	}
	
	//@formatter:off
	//@formatter:on
}

?>