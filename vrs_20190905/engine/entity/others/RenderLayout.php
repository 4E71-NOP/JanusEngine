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

/**
 * This class is considered as an entity as it is responsible for hosting the necessary data for the layout
 * @author faust
 *
 */
class RenderLayout {
	private static $Instance = null;
	private $Layout = array();
	private $ModuleList = array();
	
	private $PL = array();
	private $ms = array();
	private $qd = array();
	private $qs = array();
	
	public function __construct() {}

	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new RenderLayout();
		}
		return self::$Instance;
	}
	/**
	 * Renders the layout that will be used for rendering the modules.
	 */
	public function render(){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		
		$dbquery = $bts->SDDMObj->query("
			SELECT * FROM "
			.$SqlTableListObj->getSQLTableName('module')." m, "
			.$SqlTableListObj->getSQLTableName('module_website')." wm
			WHERE wm.fk_ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."'
			AND m.module_id = wm.fk_module_id
			AND wm.module_state = '1'
			AND m.module_group_allowed_to_see ".$CurrentSetObj->getInstanceOfUserObj()->getUserEntry('clause_in_group')."
			AND m.module_adm_control = '0'
			ORDER BY module_position
			;");
		if ( $bts->SDDMObj->num_row_sql($dbquery) > 0 ) {
			while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
				foreach ( $dbp as $A => $B ) { $this->ModuleList[$dbp['module_name']][$A] = $B; }
			}
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : ModuleList ". $bts->StringFormatObj->arrayToString($this->ModuleList)));
		}
		else { $bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : no SQL rows for layout ")); }
		
		$switch_score = 10;

		$sqlQuery = "
		SELECT
		pr.layout_id as pr_layout_id,pr.layout_name,pr.layout_title,pr.layout_generic_name,
		sp.*
		FROM "
		.$SqlTableListObj->getSQLTableName('layout')." pr, "
		.$SqlTableListObj->getSQLTableName('layout_theme')." sp, "
		.$SqlTableListObj->getSQLTableName('article')." art
		WHERE art.arti_ref = '".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_ref')."'
		AND art.arti_page = '".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_page')."'
		AND art.fk_ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."'
		AND art.layout_generic_name = pr.layout_generic_name
		AND pr.layout_id = sp.fk_layout_id
		AND sp.fk_theme_id = '".$CurrentSetObj->getInstanceOfThemeDescriptorObj()->getThemeDescriptorEntry('theme_id')."'
		;";
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " :  \$switch_score=".$switch_score));

		$dbquery = $bts->SDDMObj->query($sqlQuery);
		while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) { $layout_selection = $dbp['pr_layout_id']; }
		if ( $layout_selection != 0 ) { $switch_score += 1000; }
		
		if ( $CurrentSetObj->getInstanceOfUserObj()->getUserEntry('layout_id') != 0 ) { $switch_score += 100; }
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " :  \$sqlQuery=".$sqlQuery));
		switch ($switch_score) {
			case 1010 :
			case 1110 :
				$this->loadRawData ( $layout_selection );
				break;
				
			case 110 :
				$this->loadRawData ( $CurrentSetObj->getInstanceOfUserObj()->getUserEntry('layout_id') );
				break;
				
			case 10 :
				$dbquery = $bts->SDDMObj->query("
					SELECT fk_layout_id
					FROM ".$SqlTableListObj->getSQLTableName('layout_theme')."
					WHERE fk_theme_id = '".$CurrentSetObj->getInstanceOfThemeDescriptorObj()->getThemeDescriptorEntry('theme_id')."'
					AND default_layout_content = '1'
					;");
				while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) { $this->loadRawData ( $dbp['layout_id'] ); }
				break;
		}

// --------------------------------------------------------------------------------------------
//	Part 2
// --------------------------------------------------------------------------------------------
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : count(\$this->PL)=".count($this->PL)));
		foreach ( $this->PL as $A )  {
			$m = $A['lyoc_module_name'];
			switch ( $A['lyoc_calculation_type'] ) {
				case 0:
					$this->Layout[$m]['lyoc_margin_left']		= $A['lyoc_margin_left'];
					$this->Layout[$m]['lyoc_margin_right']		= $A['lyoc_margin_right'];
					$this->Layout[$m]['lyoc_margin_top']		= $A['lyoc_margin_top'];
					$this->Layout[$m]['lyoc_margin_bottom']		= $A['lyoc_margin_bottom'];
					
					$this->Layout[$m]['px']	= $A['lyoc_position_x']		+ $this->Layout[$m]['lyoc_margin_left'];
					$this->Layout[$m]['py']	= $A['lyoc_position_y']		+ $this->Layout[$m]['lyoc_margin_right'];
					$this->Layout[$m]['dx']	= $A['lyoc_size_x']	- $this->Layout[$m]['lyoc_margin_left'] - $this->Layout[$m]['lyoc_margin_right'];
					$this->Layout[$m]['dy']	= $A['lyoc_size_y']	- $this->Layout[$m]['lyoc_margin_top'] - $this->Layout[$m]['lyoc_margin_bottom'];
					
					$this->Layout[$m]['cpx']	= $A['lyoc_position_x'];
					$this->Layout[$m]['cpy']	= $A['lyoc_position_y'];
					$this->Layout[$m]['cdx']	= $A['lyoc_size_x'];
					$this->Layout[$m]['cdy']	= $A['lyoc_size_y'];
					break;
				case 1:
					$this->Layout[$m]['lyoc_margin_left']	= $A['lyoc_margin_left'];
					$this->Layout[$m]['lyoc_margin_right']	= $A['lyoc_margin_right'];
					$this->Layout[$m]['lyoc_margin_top']		= $A['lyoc_margin_top'];
					$this->Layout[$m]['lyoc_margin_bottom']		= $A['lyoc_margin_bottom'];
					
					$this->Layout[$m]['cdx']	= $A['lyoc_size_x'];
					$this->Layout[$m]['cdy']	= $A['lyoc_size_y'];
					
					$dynamic_['note'] = 0;
					if ( strlen($A['lyoc_module_anchor_e10']) > 0 ) { $dynamic_['note'] += 1; }
					if ( strlen($A['lyoc_module_anchor_e20']) > 0 ) { $dynamic_['note'] += 2; }
					if ( strlen($A['lyoc_module_anchor_e30']) > 0 ) { $dynamic_['note'] += 4; }
					
					switch ( $dynamic_['note'] ) {
						case 0:		break;
						
						case 1:
						case 2:
						case 4:
							$this->OneAnchorCalculationPrepareSourceTable ( $A['lyoc_module_anchor_e10'] , "x" );
							$dynamic_['note_2'] = ( $A['lyoc_anchor_ex10'] - 1 ) + ( ( $A['lyoc_anchor_dx10'] - 1 ) * 3 );
							$this->OneAnchorCalculation ( $dynamic_['note_2'] , $m , "x" );
							
							$this->OneAnchorCalculationPrepareSourceTable ( $A['lyoc_module_anchor_e10'] , "y" );
							$dynamic_['note_2'] = ( $A['lyoc_anchor_ey10'] - 1 ) + ( ( $A['lyoc_anchor_dy10'] - 1 ) * 3 );
							$this->OneAnchorCalculation ( $dynamic_['note_2'] , $m , "y" );
							
							$this->Layout[$m]['px']	= $this->Layout[$m]['cpx'] + $this->Layout[$m]['lyoc_margin_left'];
							$this->Layout[$m]['py']	= $this->Layout[$m]['cpy'] + $this->Layout[$m]['lyoc_margin_top'];
							$this->Layout[$m]['dx']	= $this->Layout[$m]['cdx'] - $this->Layout[$m]['lyoc_margin_left'] - $this->Layout[$m]['lyoc_margin_right'];
							$this->Layout[$m]['dy']	= $this->Layout[$m]['cdy'] - $this->Layout[$m]['lyoc_margin_top'] - $this->Layout[$m]['lyoc_margin_bottom'];

							break;
							
						// --------------------------------------------------------------------------------------------
						//  2 anchors
						case 3:
						case 5:
						case 6:
							if ( strlen($A['lyoc_module_anchor_e10']) > 0 ) {
								$this->findSourceAnchor ( $A['lyoc_module_anchor_e10'] , $A['lyoc_anchor_ex10'] , $A['lyoc_anchor_ey10'] );
								switch ( $A['lyoc_anchor_dx10'] ) {
									case 1:	$this->align_x1x3();	break;
									case 2:	$this->align_x2x4();	break;
								}
								switch ( $A['lyoc_anchor_dy10'] ) {
									case 1:	$this->align_y1y2();	break;
									case 2:	$this->align_y3y4();	break;
								}
							}
							if ( strlen($A['lyoc_module_anchor_e20']) > 0 ) {
								$this->findSourceAnchor ( $A['lyoc_module_anchor_e20'] , $A['lyoc_anchor_ex20'] , $A['lyoc_anchor_ey20'] );
								switch ( $A['lyoc_anchor_dx20'] ) {
									case 1:	$this->align_x1x3();	break;
									case 2:	$this->align_x2x4();	break;
								}
								switch ( $A['lyoc_anchor_dy20'] ) {
									case 1:	$this->align_y1y2();	break;
									case 2:	$this->align_y3y4();	break;
								}
							}
							
							$this->Layout[$m]['cpx']	= $this->qd['x1'];
							$this->Layout[$m]['cpy']	= $this->qd['y1'];
							$this->Layout[$m]['px']	= $this->qd['x1'] + $this->Layout[$m]['lyoc_margin_left'];
							$this->Layout[$m]['py']	= $this->qd['y1'] + $this->Layout[$m]['lyoc_margin_top'];
							
							if ( $this->Layout[$m]['cdx'] > 0 ) { $this->qd['x2'] = $this->qd['x4'] = $this->qd['x1'] + $this->Layout[$m]['cdx']; }
							if ( $this->Layout[$m]['cdy'] > 0 ) { $this->qd['y3'] = $this->qd['y4'] = $this->qd['y1'] + $this->Layout[$m]['cdy']; }
							
							$this->Layout[$m]['cdx']	= $this->qd['x2'] - $this->qd['x1'];
							$this->Layout[$m]['cdy']	= $this->qd['y3'] - $this->qd['y1'];
							$this->Layout[$m]['dx']	= $this->qd['x2'] - $this->qd['x1'] - $this->Layout[$m]['lyoc_margin_left'] - $this->Layout[$m]['lyoc_margin_right'];
							$this->Layout[$m]['dy']	= $this->qd['y3'] - $this->qd['y1'] - $this->Layout[$m]['lyoc_margin_top'] - $this->Layout[$m]['lyoc_margin_bottom'];
							break;
							
							// --------------------------------------------------------------------------------------------
							//  3 anchors
						case 7:
							$this->findSourceAnchor ( $A['lyoc_module_anchor_e10'] , $A['lyoc_anchor_ex10'] , $A['lyoc_anchor_ey10'] );
							switch ( $A['lyoc_anchor_dx10'] ) {
								case 1:	$this->align_x1x3();	break;
								case 2:	$this->align_x2x4();	break;
							}
							switch ( $A['lyoc_anchor_dy10'] ) {
								case 1:	$this->align_y1y2();	break;
								case 2:	$this->align_y3y4();	break;
							}
							$this->findSourceAnchor ( $A['lyoc_module_anchor_e20'] , $A['lyoc_anchor_ex20'] , $A['lyoc_anchor_ey20'] );
							switch ( $A['lyoc_anchor_dx20'] ) {
								case 1:	$this->align_x1x3();	break;
								case 2:	$this->align_x2x4();	break;
							}
							switch ( $A['lyoc_anchor_dy20'] ) {
								case 1:	$this->align_y1y2();	break;
								case 2:	$this->align_y3y4();	break;
							}
							$this->findSourceAnchor ( $A['lyoc_module_anchor_e30'] , $A['lyoc_anchor_ex30'] , $A['lyoc_anchor_ey30'] );
							switch ( $A['lyoc_anchor_dx30'] ) {
								case 1:	$this->align_x1x3();	break;
								case 2:	$this->align_x2x4();	break;
							}
							switch ( $A['lyoc_anchor_dy30'] ) {
								case 1:	$this->align_y1y2();	break;
								case 2:	$this->align_y3y4();	break;
							}
							
							$this->Layout[$m]['cpx']	= $this->qd['x1'];
							$this->Layout[$m]['cpy']	= $this->qd['y1'];
							$this->Layout[$m]['px']	= $this->qd['x1'] + $this->Layout[$m]['lyoc_margin_left'];
							$this->Layout[$m]['py']	= $this->qd['y1'] + $this->Layout[$m]['lyoc_margin_top'];
							
							if ( $this->Layout[$m]['cdx'] > 0 ) { $this->qd['x2'] = $this->qd['x4'] = $this->qd['x1'] + $this->Layout[$m]['cdx']; }
							if ( $this->Layout[$m]['cdy'] > 0 ) { $this->qd['y3'] = $this->qd['y4'] = $this->qd['y1'] + $this->Layout[$m]['cdy']; }
							
							$this->Layout[$m]['cdx']	= $this->qd['x2'] - $this->qd['x1'];
							$this->Layout[$m]['cdy']	= $this->qd['y3'] - $this->qd['y1'];
							$this->Layout[$m]['dx']	= $this->qd['x2'] - $this->qd['x1'] - $this->Layout[$m]['lyoc_margin_left'] - $this->Layout[$m]['lyoc_margin_right'];
							$this->Layout[$m]['dy']	= $this->qd['y3'] - $this->qd['y1'] - $this->Layout[$m]['lyoc_margin_top'] - $this->Layout[$m]['lyoc_margin_bottom'];
							break;
					}
					break;
			}
			
			if ( $this->Layout[$m]['dx'] < $A['lyoc_minimum_x'] ) {
				$this->Layout[$m]['dx'] = $A['lyoc_minimum_x'];
				$this->Layout[$m]['cdx'] = $A['lyoc_minimum_x'] + $this->Layout[$m]['lyoc_margin_left'] + $this->Layout[$m]['lyoc_margin_right'];
			}
			if ( $this->Layout[$m]['dy'] < $A['lyoc_minimum_y'] ) {
				$this->Layout[$m]['dy'] = $A['lyoc_minimum_y'];
				$this->Layout[$m]['cdy'] = $A['lyoc_minimum_y'] + $this->Layout[$m]['lyoc_margin_top'] + $this->Layout[$m]['lyoc_margin_bottom'];
			}
			$this->Layout[$m]['lyoc_module_zindex'] = $A['lyoc_module_zindex'];
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Layout calulation for module '".$m."'. Layout[".$m."]= ". $bts->StringFormatObj->arrayToString($this->Layout[$m])));
		}
		
		
		// 2019 12 29 : remove as it doesn't seems necessary anymore
// 		$_REQUEST['document_dx'] = 100;
// 		$_REQUEST['document_dy'] = 100;
		unset ( $A );
		foreach ( $this->ModuleList as $A ) {
			if ( $A['module_adm_control'] == 0 ) {
				$m = &$this->Layout[$A['module_name']];
				$pv['doc_max_x'] = ( $m['cpx'] + $m['cdx'] );	if ( $pv['doc_max_x'] > $_REQUEST['document_dx'] ) { $_REQUEST['document_dx'] = $pv['doc_max_x']; }
				$pv['doc_max_y'] = ( $m['cpy'] + $m['cdy'] );	if ( $pv['doc_max_y'] > $_REQUEST['document_dy'] ) { $_REQUEST['document_dy'] = $pv['doc_max_y']; }
			}
		}
		
	}

	
	// --------------------------------------------------------------------------------------------
	//	
	//	Private methods used for rendering the layout final dataset 
	//	
	//	
	// --------------------------------------------------------------------------------------------
	private function loadRawData ( $layout_selection ) {
		$bts = BaseToolSet::getInstance();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
			
		$dbquery = $bts->SDDMObj->query("
			SELECT *
			FROM ". $SqlTableListObj->getSQLTableName('layout_content')."
			WHERE fk_layout_id = '".$layout_selection."'
			ORDER BY lyoc_line
			;");
		while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
			$l = $dbp['lyoc_line'];
			foreach ( $dbp as $A => $B ) { $this->PL[$l][$A] = $B; }
			$this->PL[$l]['lyoc_module_anchor_e10']			= "";
			$this->PL[$l]['lyoc_module_anchor_e20']			= "";
			$this->PL[$l]['lyoc_module_anchor_e30']			= "";
		}
		
		// Select a successor if the nominal candidate isn't available.
		unset ($A);
		foreach ( $this->PL as &$A ) {
			if ( strlen($A['lyoc_module_anchor_e1a']) > 0 && $this->ModuleList[$A['lyoc_module_anchor_e1a']]['module_id'] != 0 )		{ $A['lyoc_module_anchor_e10']	=  $A['lyoc_module_anchor_e1a'];	$A['lyoc_anchor_ex10']	=  $A['lyoc_anchor_ex1a'];	$A['lyoc_anchor_ey10']	=  $A['lyoc_anchor_ey1a']; }
			elseif ( strlen($A['lyoc_module_anchor_e1b']) > 0 && $this->ModuleList[$A['lyoc_module_anchor_e1b']]['module_id'] != 0 )	{ $A['lyoc_module_anchor_e10']	=  $A['lyoc_module_anchor_e1b'];	$A['lyoc_anchor_ex10']	=  $A['lyoc_anchor_ex1b'];	$A['lyoc_anchor_ey10']	=  $A['lyoc_anchor_ey1b']; }
			elseif ( strlen($A['lyoc_module_anchor_e1c']) > 0 && $this->ModuleList[$A['lyoc_module_anchor_e1c']]['module_id'] != 0 )	{ $A['lyoc_module_anchor_e10']	=  $A['lyoc_module_anchor_e1c'];	$A['lyoc_anchor_ex10']	=  $A['lyoc_anchor_ex1c'];	$A['lyoc_anchor_ey10']	=  $A['lyoc_anchor_ey1c']; }
			elseif ( strlen($A['lyoc_module_anchor_e1d']) > 0 && $this->ModuleList[$A['lyoc_module_anchor_e1d']]['module_id'] != 0 )	{ $A['lyoc_module_anchor_e10']	=  $A['lyoc_module_anchor_e1d'];	$A['lyoc_anchor_ex10']	=  $A['lyoc_anchor_ex1d'];	$A['lyoc_anchor_ey10']	=  $A['lyoc_anchor_ey1d']; }
			elseif ( strlen($A['lyoc_module_anchor_e1e']) > 0 && $this->ModuleList[$A['lyoc_module_anchor_e1e']]['module_id'] != 0 )	{ $A['lyoc_module_anchor_e10']	=  $A['lyoc_module_anchor_e1e'];	$A['lyoc_anchor_ex10']	=  $A['lyoc_anchor_ex1e'];	$A['lyoc_anchor_ey10']	=  $A['lyoc_anchor_ey1e']; }
			
			if ( strlen($A['lyoc_module_anchor_e2a']) > 0 && $this->ModuleList[$A['lyoc_module_anchor_e2a']]['module_id'] != 0 )		{ $A['lyoc_module_anchor_e20']	=  $A['lyoc_module_anchor_e2a'];	$A['lyoc_anchor_ex20']	=  $A['lyoc_anchor_ex2a'];	$A['lyoc_anchor_ey20']	=  $A['lyoc_anchor_ey2a']; }
			elseif ( strlen($A['lyoc_module_anchor_e2b']) > 0 && $this->ModuleList[$A['lyoc_module_anchor_e2b']]['module_id'] != 0 )	{ $A['lyoc_module_anchor_e20']	=  $A['lyoc_module_anchor_e2b'];	$A['lyoc_anchor_ex20']	=  $A['lyoc_anchor_ex2b'];	$A['lyoc_anchor_ey20']	=  $A['lyoc_anchor_ey2b']; }
			elseif ( strlen($A['lyoc_module_anchor_e2c']) > 0 && $this->ModuleList[$A['lyoc_module_anchor_e2c']]['module_id'] != 0 )	{ $A['lyoc_module_anchor_e20']	=  $A['lyoc_module_anchor_e2c'];	$A['lyoc_anchor_ex20']	=  $A['lyoc_anchor_ex2c'];	$A['lyoc_anchor_ey20']	=  $A['lyoc_anchor_ey2c']; }
			elseif ( strlen($A['lyoc_module_anchor_e2d']) > 0 && $this->ModuleList[$A['lyoc_module_anchor_e2d']]['module_id'] != 0 )	{ $A['lyoc_module_anchor_e20']	=  $A['lyoc_module_anchor_e2d'];	$A['lyoc_anchor_ex20']	=  $A['lyoc_anchor_ex2d'];	$A['lyoc_anchor_ey20']	=  $A['lyoc_anchor_ey2d']; }
			elseif ( strlen($A['lyoc_module_anchor_e2e']) > 0 && $this->ModuleList[$A['lyoc_module_anchor_e2e']]['module_id'] != 0 )	{ $A['lyoc_module_anchor_e20']	=  $A['lyoc_module_anchor_e2e'];	$A['lyoc_anchor_ex20']	=  $A['lyoc_anchor_ex2e'];	$A['lyoc_anchor_ey20']	=  $A['lyoc_anchor_ey2e']; }
			
			if ( strlen($A['lyoc_module_anchor_e3a']) > 0 && $this->ModuleList[$A['lyoc_module_anchor_e3a']]['module_id'] != 0 )		{ $A['lyoc_module_anchor_e30']	=  $A['lyoc_module_anchor_e3a'];	$A['lyoc_anchor_ex30']	=  $A['lyoc_anchor_ex3a'];	$A['lyoc_anchor_ey30']	=  $A['lyoc_anchor_ey3a']; }
			elseif ( strlen($A['lyoc_module_anchor_e3b']) > 0 && $this->ModuleList[$A['lyoc_module_anchor_e3b']]['module_id'] != 0 )	{ $A['lyoc_module_anchor_e30']	=  $A['lyoc_module_anchor_e3b'];	$A['lyoc_anchor_ex30']	=  $A['lyoc_anchor_ex3b'];	$A['lyoc_anchor_ey30']	=  $A['lyoc_anchor_ey3b']; }
			elseif ( strlen($A['lyoc_module_anchor_e3c']) > 0 && $this->ModuleList[$A['lyoc_module_anchor_e3c']]['module_id'] != 0 )	{ $A['lyoc_module_anchor_e30']	=  $A['lyoc_module_anchor_e3c'];	$A['lyoc_anchor_ex30']	=  $A['lyoc_anchor_ex3c'];	$A['lyoc_anchor_ey30']	=  $A['lyoc_anchor_ey3c']; }
			elseif ( strlen($A['lyoc_module_anchor_e3d']) > 0 && $this->ModuleList[$A['lyoc_module_anchor_e3d']]['module_id'] != 0 )	{ $A['lyoc_module_anchor_e30']	=  $A['lyoc_module_anchor_e3d'];	$A['lyoc_anchor_ex30']	=  $A['lyoc_anchor_ex3d'];	$A['lyoc_anchor_ey30']	=  $A['lyoc_anchor_ey3d']; }
			elseif ( strlen($A['lyoc_module_anchor_e3e']) > 0 && $this->ModuleList[$A['lyoc_module_anchor_e3e']]['module_id'] != 0 )	{ $A['lyoc_module_anchor_e30']	=  $A['lyoc_module_anchor_e3e'];	$A['lyoc_anchor_ex30']	=  $A['lyoc_anchor_ex3e'];	$A['lyoc_anchor_ey30']	=  $A['lyoc_anchor_ey3e']; }
		}
	}

	
	// --------------------------------------------------------------------------------------------
	// LEFT	1		RIGHT	2		middle	3	TOP		1		BOTTOM	2		middle	3
	private function OneAnchorCalculationPrepareSourceTable ( $m , $axe ) {
		if ( $axe == "x" ) { $da = "cdx"; $pa = "cpx"; }
		else { $da = "cdy"; $pa = "cpy"; }
		$this->ms['SA']	= $this->Layout[$m][$pa];
		$this->ms['SB']	= $this->Layout[$m][$pa] + ( $this->Layout[$m][$da] / 2 );
		$this->ms['SC']	= $this->Layout[$m][$pa] + $this->Layout[$m][$da];
		$this->ms['D']	= $this->Layout[$m][$da];
	}
	
	// --------------------------------------------------------------------------------------------
	//	0-6-3			0-6-3		0-6-3		  0-6-3		    0-6-3
	//	    0-1-2	  0-1-2			0-1-2		0-1-2		0-1-2
	//		3			6 4			0 7 5		  1 8			2
	// --------------------------------------------------------------------------------------------
	private function OneAnchorCalculation ( $note , $m , $axe ) {
		if ( $axe == "x" ) { $da = "cdx"; $pa = "cpx"; } else { $da = "cdy"; $pa = "cpy"; }
		switch ( $note ) {
			case 3:	$this->Layout[$m][$pa] = $this->ms['SA'] - $this->Layout[$m][$da];			break;
			case 6:
			case 5:	$this->Layout[$m][$pa] = $this->ms['SA'] - ( $this->Layout[$m][$da] / 2 );	break;
			case 0:
			case 8:
			case 4:	$this->Layout[$m][$pa] = $this->ms['SA'];							break;
			case 2:
			case 7:	$this->Layout[$m][$pa] = $this->ms['SB'];							break;
			case 1:	$this->Layout[$m][$pa] = $this->ms['SC'];							break;
		}
	}
	
	// --------------------------------------------------------------------------------------------
	private function findSourceAnchor ( $m , $x , $y ) {
		
		switch ( $x ) {
			case 1: 	$this->qs['x'] = $this->Layout[$m]['cpx'];										break;
			case 3: 	$this->qs['x'] = $this->Layout[$m]['cpx'] + ( $this->Layout[$m]['cdx'] / 2 );	break;
			case 2: 	$this->qs['x'] = $this->Layout[$m]['cpx'] + $this->Layout[$m]['cdx'];			break;
		}
		switch ( $y ) {
			case 1: 	$this->qs['y'] = $this->Layout[$m]['cpy'];										break;
			case 3: 	$this->qs['y'] = $this->Layout[$m]['cpy'] + ( $this->Layout[$m]['cdy'] / 2 );	break;
			case 2: 	$this->qs['y'] = $this->Layout[$m]['cpy'] + $this->Layout[$m]['cdy'];			break;
		}
	}
	
	private function align_x1x3 () { $this->qd['x1'] = $this->qd['x3'] = $this->qs['x']; }
	private function align_x2x4 () { $this->qd['x2'] = $this->qd['x4'] = $this->qs['x']; }
	private function align_y1y2 () { $this->qd['y1'] = $this->qd['y2'] = $this->qs['y']; }
	private function align_y3y4 () { $this->qd['y3'] = $this->qd['y4'] = $this->qs['y']; }
	
	//@formatter:off
	public function getLayoutEntry($data) { return $this->Layout[$data]; }
	public function getLayoutModuleEntry($lvl1 , $lvl2) { return $this->Layout[$lvl1][$lvl2]; }
	public function getLayout() { return $this->Layout; }
	public function getModuleList() { return $this->ModuleList; }
	public function getPL() {return $this->PL;}
	
	public function setLayout($Layout) { $this->Layout = $Layout; }
	public function setLayoutEntry($entry , $data) { $this->Layout[$entry] = $data; }
	public function setModuleList($data) { $this->ModuleList = $data; }
	public function setLayoutModuleEntry($lvl1 , $lvl2 , $data) { $this->Layout[$lvl1][$lvl2] = $data; }
	
	//@formatter:on

}

?>
	