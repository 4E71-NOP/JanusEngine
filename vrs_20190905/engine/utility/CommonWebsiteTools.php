<?php
/*JanusEngine-license-start*/
// --------------------------------------------------------------------------------------------
//
//	Janus Engine - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*JanusEngine-license-end*/

class CommonWebsiteTools
{
	private static $Instance = null;

	public function __construct() {}

	/**
	 * Singleton : Will return the instance of this class.
	 * @return CommonWebsiteTools
	 */
	public static function getInstance()
	{
		if (self::$Instance == null) {
			self::$Instance = new CommonWebsiteTools();
		}
		return self::$Instance;
	}


	/**
	 * Sets the language for the page. It chooses by priority.
	 * 
	 */
	public function languageSelection()
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance();
		$UserObj = $CurrentSetObj->UserObj;
		$WebSiteObj = $CurrentSetObj->WebSiteObj;

		$bts->mapSegmentLocation(__METHOD__, "languageSelection");

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Language selection start"));
		$scoreLang = 0;

		if (strlen($bts->RequestDataObj->getRequestDataEntry('l') ?? '') != 0 && $bts->RequestDataObj->getRequestDataEntry('l') != 0) {
			$scoreLang += 4;
		}
		if (is_numeric($UserObj->getUserEntry('user_lang')) && $UserObj->getUserEntry('user_lang') != 0) {
			$scoreLang += 2;
		}
		if (strlen($WebSiteObj->getWebSiteEntry('fk_lang_id') ?? '') != 0 && $WebSiteObj->getWebSiteEntry('fk_lang_id') != 0) {
			$scoreLang += 1;
		}

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Website fk_lang_id='" . $WebSiteObj->getWebSiteEntry('fk_lang_id') . "'"));

		switch ($scoreLang) {
			case 0:
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Language selection Error. Something wrong happened (most likely no data for language in website table). In the mean time back to English as website language."));
				$CurrentSetObj->setDataEntry('language', 'eng');
				$CurrentSetObj->setDataEntry('language_id', '38');
				break;
			case 1:
				$tmp = $bts->CMObj->getLanguageListSubEntry($WebSiteObj->getWebSiteEntry('fk_lang_id'), 'lang_639_3');
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Language selection says Website priority (Case=" . $scoreLang . "; " . $WebSiteObj->getWebSiteEntry('fk_lang_id') . "->" . $tmp . ")"));
				$CurrentSetObj->setDataEntry('language', $tmp);
				$CurrentSetObj->setDataEntry('language_id', $bts->CMObj->getLanguageListSubEntry($WebSiteObj->getWebSiteEntry('fk_lang_id'), 'lang_id'));
				break;
			case 2:
			case 3:
				$tmp = $bts->CMObj->getLanguageListSubEntry($UserObj->getUserEntry('user_lang'), 'lang_639_3');
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Language selection says User priority (Case=" . $scoreLang . "; " . $UserObj->getUserEntry('user_lang') . "->" . $tmp . ")"));
				$CurrentSetObj->setDataEntry('language', $tmp);
				$CurrentSetObj->setDataEntry('language_id', $bts->CMObj->getLanguageListSubEntry($UserObj->getUserEntry('user_lang'), 'lang_id'));
				break;
			case 4:
			case 5:
			case 6:
			case 7:
				$tmp = strtolower($bts->RequestDataObj->getRequestDataEntry('l'));
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Language selection says URL priority (Case=" . $scoreLang . "; " . $bts->RequestDataObj->getRequestDataEntry('l') . "->" . $tmp . ")"));
				$CurrentSetObj->setDataEntry('language', $tmp); // URl/form asked, the king must be served!
				$CurrentSetObj->setDataEntry('language_id', strtolower($bts->RequestDataObj->getRequestDataEntry('l')));
				break;
		}

		$ClassLoaderObj->provisionClass('I18nTrans');
		$I18nObj = I18nTrans::getInstance();
		$I18nObj->getI18nTransFromDB();

		$bts->segmentEnding(__METHOD__);
		return (true);
	}
}
