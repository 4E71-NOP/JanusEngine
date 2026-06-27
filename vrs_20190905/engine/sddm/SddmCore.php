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


// --------------------------------------------------------------------------------------------

class SddmCore
{
	protected $report;

	public function __construct() {}

	/**
	 * Create an UID with random function
	 * 
	 * The auto incremental solutions aren't implemnted the same in every DB systems.
	 * So, this manual method has been chosen in order to be able to have the same data compatible with several databases systems.
	 * This enables flexibility so the admin can choose his DB solution more freely.
	 * 
	 * 
	 * @return string
	 */
	public function createUniqueId()
	{
		$idMethod = _ID_METHOD_;
		switch ($idMethod) {
			case 'maxLengthInt':
				return $this->createRandomInt();
				break;
			case 'uuidv7':
				return $this->createUuidv7();
				break;
		}
	}

	/**
	 * Returns a simple random big integer<br>
	 * <br>
	 * As it is completely random, it's not duplicate proof by design. 
	 * Even though in reality, there is 1 chance in a <i>Gazillion</i> that a duplicate can happen. 
	 * This method is kept for the sake of smiplicity or compensate for lack of type binary(16) in some DB solution. 
	 * 
	 * @return int
	 */
	protected function createRandomInt()
	{
		return random_int(1, 9223372036854775807);
	}

	/**
	 * Summary of createUuidv7
	 * @return string
	 */
	protected function createUuidv7()
	{
		$bts = BaseToolSet::getInstance();
		$timestamp = (int)(microtime(true) * 1000);

		switch ($bts->CMObj->getConfigurationSubEntry('db', 'type')) {
			case "mysql":
			default:
				return "0x" . sprintf(
					'%08x%04x%04x%04x%012x',
					($timestamp >> 16) & 0xFFFFFFFF,
					$timestamp & 0xFFFF,
					random_int(0, 0x0FFF) | 0x7000,     // version 7
					random_int(0, 0x3FFF) | 0x8000,     // variant 10xx
					random_int(0, 0xFFFFFFFFFFFF)       // 48 random bits
				);
				break;
			case "pgsql":
				return "'\x" . sprintf(
					'%08x%04x%04x%04x%012x',
					($timestamp >> 16) & 0xFFFFFFFF,
					$timestamp & 0xFFFF,
					random_int(0, 0x0FFF) | 0x7000,     // version 7
					random_int(0, 0x3FFF) | 0x8000,     // variant 10xx
					random_int(0, 0xFFFFFFFFFFFF)       // 48 random bits
				)
					. "'";
				break;
		}
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

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_DEBUG_LVL0, 'msg' => __METHOD__ . " : " . $bts->StringFormatObj->print_r_debug($SQLlogEntry) . "`."));
	}

	//@formatter:off
	public function getReport()	{ return $this->report;	}
	public function getReportEntry($data) { return $this->report[$data]; }
	public function setReport($report) { $this->report = $report; }
	//@formatter:on

}
