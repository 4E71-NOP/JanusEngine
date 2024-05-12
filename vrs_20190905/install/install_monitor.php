<?php
/* Hydre-licence-debut */
// --------------------------------------------------------------------------------------------
//
// Hydre - Le petit moteur de web
// Sous licence Creative Common
// Under Creative Common licence CC-by-nc-sa (http://creativecommons.org)
// CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
// (c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/* Hydre-licence-fin */
class HydrInstallMonitor
{
	private static $Instance = null;
	private function __construct()
	{
	}

	/**
	 * Singleton : Will return the instance of this class.
	 *
	 * @return HydrInstall
	 */
	public static function getInstance()
	{
		if (self::$Instance == null) {
			self::$Instance = new HydrInstallMonitor();
		}
		return self::$Instance;
	}

	/**
	 * Renders the whole thing.
	 * The choice of making a main class is to help IDEs to process sources.
	 *
	 * @return string
	 */
	public function render()
	{
		$application = 'monitor';
		include("current/define.php");
		include("current/engine/utility/ClassLoader.php");
		$ClassLoaderObj = ClassLoader::getInstance();
		$ClassLoaderObj->provisionClass('BaseToolSet'); // First of them all as it is used by others.

		$ClassLoaderObj->provisionClass('SqlTableList');
		$ClassLoaderObj->provisionClass('CurrentSet');

		$bts = BaseToolSet::getInstance();
		$form = $bts->RequestDataObj->getRequestDataEntry('form');
		$CurrentSetObj = CurrentSet::getInstance();

		// We have a POST so we set RAM and execution time limit immediately.
		if (isset($form['memoryLimit'])) {
			ini_set('memoryLimit', $form['memoryLimit'] . "M");
			ini_set('max_execution_time', $form['execTimeLimit']);
		}

		// We get the conf from the posted vars		
		$bts->CMObj->InitBasicSettings();

		$bts->CMObj->setConfigurationEntry('type',					$form['selectedDataBaseType']);
		$bts->CMObj->setConfigurationEntry('dal',					$form['dal']);
		$bts->CMObj->setConfigurationEntry('host',					$form['host']);
		$bts->CMObj->setConfigurationEntry('port',					$form['port']);
		$bts->CMObj->setConfigurationEntry('db_user_login',			$form['dataBaseHostingPrefix'] . $form['dataBaseAdminUser']);
		$bts->CMObj->setConfigurationEntry('db_user_password',		$form['dataBaseAdminPassword']);
		$bts->CMObj->setConfigurationEntry('dbprefix',				$form['dbprefix']);
		$bts->CMObj->setConfigurationEntry('tabprefix',				$form['tabprefix']);
		$bts->CMObj->setConfigurationEntry('charset',				"utf8mb4");

		$bts->CMObj->setConfigurationEntry('execution_context',		'installation');

		$CurrentSetObj->setSqlTableListObj(SqlTableList::getInstance());
		$CurrentSetObj->SqlTableListObj->makeSqlTableList($form['dbprefix'], $form['tabprefix']);

		// $DALFacade = DalFacade::getInstance();
		// $DALFacade->createDALInstance();		// It connects too.
		$bts->initSddmObj();

		$SqlTableListObj = $CurrentSetObj->SqlTableListObj;

		$sqlQuery = "SELECT *"
			. " FROM " . $SqlTableListObj->getSQLTableName('installation')
			. ";";
		$data = array();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : query =`" . $sqlQuery . "`."));

		$dbquery = $bts->SDDMObj->query($sqlQuery);

		$queryState = true;
		if ($bts->SDDMObj->getErrno() != 0) {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_WARNING, 'msg' => __METHOD__ . "SQL Error flag : " . $bts->SDDMObj->getErrno()));
			$queryState = false;
		}
		if ($bts->SDDMObj->num_row_sql($dbquery) == 0) {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_WARNING, 'msg' => __METHOD__ . "SQL no rows flag : " . $bts->SDDMObj->num_row_sql($dbquery)));
			$queryState = false;
		}

		if ($queryState == true) {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : query has no error."));

			while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
				$data[$dbp['inst_name']] = $dbp['inst_nbr'];
			}
			if ($data['instalToken'] == $form['instalToken']) {
				$data['mainAnswer'] = "report";
				$Content = json_encode($data);
			} else {
				$Content = json_encode(array('mainAnswer' => 'Invalid token'));
			}
		} else {
			$Content = json_encode(array('mainAnswer' => 'noDataAvailable'));
		}
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Content = `" . $Content . "`."));
		return $Content;
	}
}
