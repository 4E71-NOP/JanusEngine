<?php
require_once '../engine/entity/dao/DeadLine.php';

/**
 * DeadLine test case.
 */
// class DeadLineTest extends PHPUnit_Framework_TestCase {
class DeadLineTest {

	/**
	 *
	 * @var DeadLine 
	 */
	private $deadLine;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();

		// TODO Auto-generated DeadLineTest::setUp()

		$this->deadLine = new DeadLine(/* parameters */);
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		// TODO Auto-generated DeadLineTest::tearDown()
		$this->deadLine = null;

		parent::tearDown ();
	}

	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}

	/**
	 * Tests DeadLine->__construct()
	 */
	public function test__construct() {
		// TODO Auto-generated DeadLineTest->test__construct()
		$this->markTestIncomplete ( "__construct test not implemented" );

		$this->deadLine->__construct(/* parameters */);
	}

	/**
	 * Tests DeadLine->getDataFromDB()
	 */
	public function testGetDataFromDB() {
		// TODO Auto-generated DeadLineTest->testGetDataFromDB()
		$this->markTestIncomplete ( "getDataFromDB test not implemented" );

		$this->deadLine->getDataFromDB(/* parameters */);
	}

	/**
	 * Tests DeadLine->sendToDB()
	 */
	public function testSendToDB() {
		// TODO Auto-generated DeadLineTest->testSendToDB()
		$this->markTestIncomplete ( "sendToDB test not implemented" );

		$this->deadLine->sendToDB(/* parameters */);
	}

	/**
	 * Tests DeadLine->existsInDB()
	 */
	public function testExistsInDB() {
		// TODO Auto-generated DeadLineTest->testExistsInDB()
		$this->markTestIncomplete ( "existsInDB test not implemented" );

		$this->deadLine->existsInDB(/* parameters */);
	}

	/**
	 * Tests DeadLine->checkDataConsistency()
	 */
	public function testCheckDataConsistency() {
		// TODO Auto-generated DeadLineTest->testCheckDataConsistency()
		$this->markTestIncomplete ( "checkDataConsistency test not implemented" );

		$this->deadLine->checkDataConsistency(/* parameters */);
	}

	/**
	 * Tests DeadLine->getDefaultValues()
	 */
	public function testGetDefaultValues() {
		// TODO Auto-generated DeadLineTest->testGetDefaultValues()
		$this->markTestIncomplete ( "getDefaultValues test not implemented" );

		$this->deadLine->getDefaultValues(/* parameters */);
	}

	/**
	 * Tests DeadLine->getStatesArray()
	 */
	public function testGetStatesArray() {
		// TODO Auto-generated DeadLineTest->testGetStatesArray()
		$this->markTestIncomplete ( "getStatesArray test not implemented" );

		$this->deadLine->getStatesArray(/* parameters */);
	}

	/**
	 * Tests DeadLine->getDeadLineEntry()
	 */
	public function testGetDeadLineEntry() {
		// TODO Auto-generated DeadLineTest->testGetDeadLineEntry()
		$this->markTestIncomplete ( "getDeadLineEntry test not implemented" );

		$this->deadLine->getDeadLineEntry(/* parameters */);
	}

	/**
	 * Tests DeadLine->getDeadLine()
	 */
	public function testGetDeadLine() {
		// TODO Auto-generated DeadLineTest->testGetDeadLine()
		$this->markTestIncomplete ( "getDeadLine test not implemented" );

		$this->deadLine->getDeadLine(/* parameters */);
	}

	/**
	 * Tests DeadLine->setDeadLineEntry()
	 */
	public function testSetDeadLineEntry() {
		// TODO Auto-generated DeadLineTest->testSetDeadLineEntry()
		$this->markTestIncomplete ( "setDeadLineEntry test not implemented" );

		$this->deadLine->setDeadLineEntry(/* parameters */);
	}

	/**
	 * Tests DeadLine->setDeadLine()
	 */
	public function testSetDeadLine() {
		// TODO Auto-generated DeadLineTest->testSetDeadLine()
		$this->markTestIncomplete ( "setDeadLine test not implemented" );

		$this->deadLine->setDeadLine(/* parameters */);
	}
}

