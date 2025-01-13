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
// --------------------------------------------------------------------------------------------

class SddmCore
{
	protected $report;

	public function __construct() {}

	/**
	 * Create an UID with random function
	 * @return string
	 */
	public function createUniqueId()
	{
		return random_int(1, 9223372036854775807);
	}

	protected function logToSqlDetails($q, $SQLlogEntry, $timeBegin)
	{
		$bts = BaseToolSet::getInstance();
		$bts->LMObj->increaseSqlQueryNumber();
		$q = $bts->StringFormatObj->shorteningExpression($q, 256);
		$bts->LMObj->logSQLDetails(
			array(
				$timeBegin,
				$bts->LMObj->getSqlQueryNumber(),
				$bts->MapperObj->getWhereWeAreAt(),
				$SQLlogEntry['signal'],
				$q,
				$SQLlogEntry['err_no_expr'],
				$SQLlogEntry['err_msg'],
				$bts->TimeObj->getMicrotime(),
			)
		);

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : " . $bts->StringFormatObj->print_r_debug($SQLlogEntry) . "`."));
	}

	//@formatter:off
	public function getReport()	{ return $this->report;	}
	public function getReportEntry($data) { return $this->report[$data]; }
	public function setReport($report) { $this->report = $report; }
	//@formatter:on

}
