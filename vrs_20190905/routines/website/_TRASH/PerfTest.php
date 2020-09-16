<?php 

set_time_limit(60*3);

class TestClassTable {
	private $Table = array(
		"0"	=> "qsdfgqsdf ",
		"1"	=> "ghklghklgkl ",
		"2"	=> array(
				"0"	=> "qsdfgqsdf ",
				"1"	=> "ghklghklgkl ",
				"2"	=> "ghklghklgkl ",
				"3"	=> "ghklghklgkl ",
				"4"	=> "ghklghklgkl "
				),
		"3"	=> "cvbncxvbn ",
		"4"	=> "azerazer ",
		"5"	=> "sqedrgzserty "
		);
	public function __construct(){
		
	}
	public function getTable() {return $this->Table;}
	public function getTableEntry($a) {return $this->Table[$a];}
	public function getTableSubEntry($a,$b) {return $this->Table[$a][$b];}

	public function setTable($Table) {$this->Table = $Table;}

}

function microtime_chrono() { return microtime(TRUE); }

$tabtime = array();
$NbrTest1 = 1000000;
$NbrTest2 = 5;
$Tc = new TestClassTable ();



// ---------------------------------------------------------------
//
//	A side (Brutality on class)
//
//	
$tabtime[] = microtime_chrono();
for ( $i = 0 ; $i < $NbrTest1; $i++ ) {
	$txt = $Tc->getTableEntry($i);
}
$tabtime[] = microtime_chrono();

// ---------------------------------------------------------------
$txt .= "<br><br>";
$tabtime[] = microtime_chrono();
for($i = 0; $i < $NbrTest1; $i ++) {
	for($j = 0; $j < $NbrTest2; $j ++) {
		$txt = $Tc->getTableSubEntry ( 2, $j );
	}
}
$tabtime[] = microtime_chrono();



// ---------------------------------------------------------------
//	
//	B side (Table grab and use)
//	
//	
$tmp = $Tc->getTable();
$tabtime[] = microtime_chrono();
for ( $i = 0 ; $i < $NbrTest1; $i++ ) {
	$txt = $tmp[$i];
}
$tabtime[] = microtime_chrono();

// ---------------------------------------------------------------
$txt .= "<br><br>";
$tabtime[] = microtime_chrono();
for($i = 0; $i < $NbrTest1; $i ++) {
	for($j = 0; $j < $NbrTest2; $j ++) {
		$txt = $tmp[2][$j];
	}
}
$tabtime[] = microtime_chrono();




// ---------------------------------------------------------------
//
//	Results
//
//

$i = 0;
$tablength = count($tabtime);
for($i = 0; $i < $tablength; $i +=2) {
	echo ( $tabtime[$i+1] ." - ". $tabtime[$i] . " = " .($tabtime[$i+1] - $tabtime[$i]) . "<br>");
}
//echo ("<br>" . $txt);





?>