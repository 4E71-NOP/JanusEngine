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
// This class is considered as an entity as it is responsible for hosting the necessary data for the layout
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
	 * @param User $UserObj
	 * @param WebSite $WebSiteObj
	 * @param ThemeDescriptor $ThemeDescriptorObj
	 */
	public function render( User $UserObj, WebSite $WebSiteObj, ThemeDescriptor $ThemeDescriptorObj){
		$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		$LMObj = LogManagement::getInstance();
	
// 		$CurrentSet = CurrentSet::getInstance();
// 		$WebSiteObj = $CurrentSet->getInstanceOfWebSiteObj();
// 		$UserObj = $CurrentSet->getInstanceOfUserObj();
// 		$ThemeDataObj = $CurrentSet->getInstanceOfThemeDataObj();
// 		$GeneratedJavaScriptObj = $CurrentSet->getInstanceOfGeneratedJavaScriptObj();
// 		$ServerInfosObj = $CurrentSet->getInstanceOfServerInfosObj();
		
		$dbquery = $SDDMObj->query("
			SELECT *
			FROM ".$SqlTableListObj->getSQLTableName('module')." m, ".$SqlTableListObj->getSQLTableName('site_module')." sm
			WHERE sm.site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."'
			AND m.module_id = sm.module_id
			AND sm.module_etat = '1'
			AND m.module_groupe_pour_voir ".$UserObj->getUserEntry('clause_in_groupe')."
			AND m.module_adm_control = '0'
			ORDER BY module_position
			;");
		
		while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) {
			foreach ( $dbp as $A => $B ) { $this->ModuleList[$dbp['module_nom']][$A] = $B; }
		}
		
		$switch_score = 10;
		if ( isset($_REQUEST['arti_ref']) ) {
			$dbquery = $SDDMObj->query("
				SELECT
				pr.pres_id as pr_pres_id,pr.pres_nom,pr.pres_titre,pr.pres_nom_generique,
				sp.*
				FROM ".$SqlTableListObj->getSQLTableName('presentation')." pr, ".$SqlTableListObj->getSQLTableName('theme_presentation')." sp, ".$SqlTableListObj->getSQLTableName('article')." art
				WHERE art.arti_ref = '".$_REQUEST['arti_ref']."'
				AND art.arti_page = '".$_REQUEST['arti_page']."'
				AND art.site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."'
				AND art.pres_nom_generique = pr.pres_nom_generique
				AND pr.pres_id = sp.pres_id
				AND sp.theme_id = '".$ThemeDescriptorObj->getThemeDescriptorEntry('theme_id')."'
				;");
			while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) { $presentation_selection = $dbp['pres_id']; }
			if ( $presentation_selection != 0 ) { $switch_score += 1000; }
		}
// 		$LMObj->logDebug($UserObj->getUserEntry('pres_id') , "\$UserObj->getUserEntry('pres_id')");
		if ( $UserObj->getUserEntry('pres_id') != 0 ) { $switch_score += 100; }
// 		echo ("switch_score=".$switch_score . "<br>\r");
		switch ($switch_score) {
			case 1010 :
			case 1110 :
				$this->loadRawData ( $presentation_selection );
				break;
				
			case 110 :
				$this->loadRawData ( $UserObj->getUserEntry('pres_id') );
				break;
				
			case 10 :
				$dbquery = $SDDMObj->query("
					SELECT pres_id
					FROM ".$SqlTableListObj->getSQLTableName('theme_presentation')."
					WHERE theme_id = '".$ThemeDescriptorObj->getThemeDescriptorEntry('theme_id')."'
					AND pres_defaut = '1'
					;");
				while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) { $this->loadRawData ( $dbp['pres_id'] ); }
				break;
		}

// --------------------------------------------------------------------------------------------
//	Part 2
// --------------------------------------------------------------------------------------------
		foreach ( $this->PL as $A )  {
			$m = $A['pres_module_nom'];
			switch ( $A['pres_type_calcul'] ) {
				case 0:
					$this->Layout[$m]['pres_espacement_bord_gauche']	= $A['pres_espacement_bord_gauche'];
					$this->Layout[$m]['pres_espacement_bord_droite']	= $A['pres_espacement_bord_droite'];
					$this->Layout[$m]['pres_espacement_bord_haut']		= $A['pres_espacement_bord_haut'];
					$this->Layout[$m]['pres_espacement_bord_bas']		= $A['pres_espacement_bord_bas'];
					
					$this->Layout[$m]['px']	= $A['pres_position_x']		+ $this->Layout[$m]['pres_espacement_bord_gauche'];
					$this->Layout[$m]['py']	= $A['pres_position_y']		+ $this->Layout[$m]['pres_espacement_bord_droite'];
					$this->Layout[$m]['dx']	= $A['pres_dimenssion_x']	- $this->Layout[$m]['pres_espacement_bord_gauche'] - $this->Layout[$m]['pres_espacement_bord_droite'];
					$this->Layout[$m]['dy']	= $A['pres_dimenssion_y']	- $this->Layout[$m]['pres_espacement_bord_haut'] - $this->Layout[$m]['pres_espacement_bord_bas'];
					
					$this->Layout[$m]['cpx']	= $A['pres_position_x'];
					$this->Layout[$m]['cpy']	= $A['pres_position_y'];
					$this->Layout[$m]['cdx']	= $A['pres_dimenssion_x'];
					$this->Layout[$m]['cdy']	= $A['pres_dimenssion_y'];
					break;
					
				case 1:
					$this->Layout[$m]['pres_espacement_bord_gauche']	= $A['pres_espacement_bord_gauche'];
					$this->Layout[$m]['pres_espacement_bord_droite']	= $A['pres_espacement_bord_droite'];
					$this->Layout[$m]['pres_espacement_bord_haut']		= $A['pres_espacement_bord_haut'];
					$this->Layout[$m]['pres_espacement_bord_bas']		= $A['pres_espacement_bord_bas'];
					
					$this->Layout[$m]['cdx']	= $A['pres_dimenssion_x'];
					$this->Layout[$m]['cdy']	= $A['pres_dimenssion_y'];
					
					$dynamic_['note'] = 0;
					if ( strlen($A['pres_module_ancre_e10']) > 0 ) { $dynamic_['note'] += 1; }
					if ( strlen($A['pres_module_ancre_e20']) > 0 ) { $dynamic_['note'] += 2; }
					if ( strlen($A['pres_module_ancre_e30']) > 0 ) { $dynamic_['note'] += 4; }
					
// 					echo ("note=".$dynamic_['note']."<br>\r");
					switch ( $dynamic_['note'] ) {
						case 0:		break;
						
						case 1:
						case 2:
						case 4:
							$this->OneAnchorCalculationPrepareSourceTable ( $A['pres_module_ancre_e10'] , "x" );
							$dynamic_['note_2'] = ( $A['pres_ancre_ex10'] - 1 ) + ( ( $A['pres_ancre_dx10'] - 1 ) * 3 );
							$this->OneAnchorCalculation ( $dynamic_['note_2'] , $m , "x" );
							
							$this->OneAnchorCalculationPrepareSourceTable ( $A['pres_module_ancre_e10'] , "y" );
							$dynamic_['note_2'] = ( $A['pres_ancre_ey10'] - 1 ) + ( ( $A['pres_ancre_dy10'] - 1 ) * 3 );
							$this->OneAnchorCalculation ( $dynamic_['note_2'] , $m , "y" );
// 							echo (
// 									"module=" .$m."; ".
// 									"module_ancre_e10=".$A['pres_module_ancre_e10']."; ".
// 									"ancre_ex10=".$A['pres_ancre_ex10']."; ".
// 									"ancre_dx10=".$A['pres_ancre_dx10']."; ".
// 									"note2=".$dynamic_['note_2']."<br>\r"
// 									);
							
							$this->Layout[$m]['px']	= $this->Layout[$m]['cpx'] + $this->Layout[$m]['pres_espacement_bord_gauche'];
							$this->Layout[$m]['py']	= $this->Layout[$m]['cpy'] + $this->Layout[$m]['pres_espacement_bord_haut'];
							$this->Layout[$m]['dx']	= $this->Layout[$m]['cdx'] - $this->Layout[$m]['pres_espacement_bord_gauche'] - $this->Layout[$m]['pres_espacement_bord_droite'];
							$this->Layout[$m]['dy']	= $this->Layout[$m]['cdy'] - $this->Layout[$m]['pres_espacement_bord_haut'] - $this->Layout[$m]['pres_espacement_bord_bas'];
							break;
							
						// --------------------------------------------------------------------------------------------
						//  2 anchors
						case 3:
						case 5:
						case 6:
							if ( strlen($A['pres_module_ancre_e10']) > 0 ) {
								$this->findSourceAnchor ( $A['pres_module_ancre_e10'] , $A['pres_ancre_ex10'] , $A['pres_ancre_ey10'] );
								switch ( $A['pres_ancre_dx10'] ) {
									case 1:	$this->align_x1x3();	break;
									case 2:	$this->align_x2x4();	break;
								}
								switch ( $A['pres_ancre_dy10'] ) {
									case 1:	$this->align_y1y2();	break;
									case 2:	$this->align_y3y4();	break;
								}
							}
							if ( strlen($A['pres_module_ancre_e20']) > 0 ) {
								$this->findSourceAnchor ( $A['pres_module_ancre_e20'] , $A['pres_ancre_ex20'] , $A['pres_ancre_ey20'] );
								switch ( $A['pres_ancre_dx20'] ) {
									case 1:	$this->align_x1x3();	break;
									case 2:	$this->align_x2x4();	break;
								}
								switch ( $A['pres_ancre_dy20'] ) {
									case 1:	$this->align_y1y2();	break;
									case 2:	$this->align_y3y4();	break;
								}
							}
							
							$this->Layout[$m]['cpx']	= $this->qd['x1'];
							$this->Layout[$m]['cpy']	= $this->qd['y1'];
							$this->Layout[$m]['px']	= $this->qd['x1'] + $this->Layout[$m]['pres_espacement_bord_gauche'];
							$this->Layout[$m]['py']	= $this->qd['y1'] + $this->Layout[$m]['pres_espacement_bord_haut'];
							
							if ( $this->Layout[$m]['cdx'] > 0 ) { $this->qd['x2'] = $this->qd['x4'] = $this->qd['x1'] + $this->Layout[$m]['cdx']; }
							if ( $this->Layout[$m]['cdy'] > 0 ) { $this->qd['y3'] = $this->qd['y4'] = $this->qd['y1'] + $this->Layout[$m]['cdy']; }
							
							$this->Layout[$m]['cdx']	= $this->qd['x2'] - $this->qd['x1'];
							$this->Layout[$m]['cdy']	= $this->qd['y3'] - $this->qd['y1'];
							$this->Layout[$m]['dx']	= $this->qd['x2'] - $this->qd['x1'] - $this->Layout[$m]['pres_espacement_bord_gauche'] - $this->Layout[$m]['pres_espacement_bord_droite'];
							$this->Layout[$m]['dy']	= $this->qd['y3'] - $this->qd['y1'] - $this->Layout[$m]['pres_espacement_bord_haut'] - $this->Layout[$m]['pres_espacement_bord_bas'];
							break;
							
							// --------------------------------------------------------------------------------------------
							//  3 anchors
						case 7:
							$this->findSourceAnchor ( $A['pres_module_ancre_e10'] , $A['pres_ancre_ex10'] , $A['pres_ancre_ey10'] );
							switch ( $A['pres_ancre_dx10'] ) {
								case 1:	$this->align_x1x3();	break;
								case 2:	$this->align_x2x4();	break;
							}
							switch ( $A['pres_ancre_dy10'] ) {
								case 1:	$this->align_y1y2();	break;
								case 2:	$this->align_y3y4();	break;
							}
							$this->findSourceAnchor ( $A['pres_module_ancre_e20'] , $A['pres_ancre_ex20'] , $A['pres_ancre_ey20'] );
							switch ( $A['pres_ancre_dx20'] ) {
								case 1:	$this->align_x1x3();	break;
								case 2:	$this->align_x2x4();	break;
							}
							switch ( $A['pres_ancre_dy20'] ) {
								case 1:	$this->align_y1y2();	break;
								case 2:	$this->align_y3y4();	break;
							}
							$this->findSourceAnchor ( $A['pres_module_ancre_e30'] , $A['pres_ancre_ex30'] , $A['pres_ancre_ey30'] );
							switch ( $A['pres_ancre_dx30'] ) {
								case 1:	$this->align_x1x3();	break;
								case 2:	$this->align_x2x4();	break;
							}
							switch ( $A['pres_ancre_dy30'] ) {
								case 1:	$this->align_y1y2();	break;
								case 2:	$this->align_y3y4();	break;
							}
							
							$this->Layout[$m]['cpx']	= $this->qd['x1'];
							$this->Layout[$m]['cpy']	= $this->qd['y1'];
							$this->Layout[$m]['px']	= $this->qd['x1'] + $this->Layout[$m]['pres_espacement_bord_gauche'];
							$this->Layout[$m]['py']	= $this->qd['y1'] + $this->Layout[$m]['pres_espacement_bord_haut'];
							
							if ( $this->Layout[$m]['cdx'] > 0 ) { $this->qd['x2'] = $this->qd['x4'] = $this->qd['x1'] + $this->Layout[$m]['cdx']; }
							if ( $this->Layout[$m]['cdy'] > 0 ) { $this->qd['y3'] = $this->qd['y4'] = $this->qd['y1'] + $this->Layout[$m]['cdy']; }
							
							$this->Layout[$m]['cdx']	= $this->qd['x2'] - $this->qd['x1'];
							$this->Layout[$m]['cdy']	= $this->qd['y3'] - $this->qd['y1'];
							$this->Layout[$m]['dx']	= $this->qd['x2'] - $this->qd['x1'] - $this->Layout[$m]['pres_espacement_bord_gauche'] - $this->Layout[$m]['pres_espacement_bord_droite'];
							$this->Layout[$m]['dy']	= $this->qd['y3'] - $this->qd['y1'] - $this->Layout[$m]['pres_espacement_bord_haut'] - $this->Layout[$m]['pres_espacement_bord_bas'];
							break;
					}
					break;
			}
			
			if ( $this->Layout[$m]['dx'] < $A['pres_minimum_x'] ) {
				$this->Layout[$m]['dx'] = $A['pres_minimum_x'];
				$this->Layout[$m]['cdx'] = $A['pres_minimum_x'] + $this->Layout[$m]['pres_espacement_bord_gauche'] + $this->Layout[$m]['pres_espacement_bord_droite'];
			}
			if ( $this->Layout[$m]['dy'] < $A['pres_minimum_y'] ) {
				$this->Layout[$m]['dy'] = $A['pres_minimum_y'];
				$this->Layout[$m]['cdy'] = $A['pres_minimum_y'] + $this->Layout[$m]['pres_espacement_bord_haut'] + $this->Layout[$m]['pres_espacement_bord_bas'];
			}
			$this->Layout[$m]['pres_module_zindex'] = $A['pres_module_zindex'];
		}
		
		
		// 2019 12 29 : remove as it doesn't seems necessary anymore
		$_REQUEST['document_dx'] = 100;
		$_REQUEST['document_dy'] = 100;
		unset ( $A );
		foreach ( $this->ModuleList as $A ) {
			if ( $A['module_adm_control'] == 0 ) {
				$m = &$this->Layout[$A['module_nom']];
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
	private function loadRawData ( $presentation_selection ) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		$LMObj = LogManagement::getInstance();
			
		$dbquery = $SDDMObj->query("
			SELECT *
			FROM ". $SqlTableListObj->getSQLTableName('presentation_contenu')."
			WHERE pres_id = '".$presentation_selection."'
			ORDER BY pres_ligne
			;");
// 		echo ("
// 			SELECT *
// 			FROM ". $SqlTableListObj->getSQLTableName('presentation_contenu')."
// 			WHERE pres_id = '".$presentation_selection."'
// 			ORDER BY pres_ligne
// 			;<br>\r");
		while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) {
			$l = $dbp['pres_ligne'];
			foreach ( $dbp as $A => $B ) { $this->PL[$l][$A] = $B; }
			$this->PL[$l]['pres_module_ancre_e10']			= "";
			$this->PL[$l]['pres_module_ancre_e20']			= "";
			$this->PL[$l]['pres_module_ancre_e30']			= "";
		}
		
		// Select a successor if the nominal candidate isn't available.
		unset ($A);
		foreach ( $this->PL as &$A ) {
			if ( strlen($A['pres_module_ancre_e1a']) > 0 && $this->ModuleList[$A['pres_module_ancre_e1a']]['module_id'] != 0 )		{ $A['pres_module_ancre_e10']	=  $A['pres_module_ancre_e1a'];	$A['pres_ancre_ex10']	=  $A['pres_ancre_ex1a'];	$A['pres_ancre_ey10']	=  $A['pres_ancre_ey1a']; }
			elseif ( strlen($A['pres_module_ancre_e1b']) > 0 && $this->ModuleList[$A['pres_module_ancre_e1b']]['module_id'] != 0 )	{ $A['pres_module_ancre_e10']	=  $A['pres_module_ancre_e1b'];	$A['pres_ancre_ex10']	=  $A['pres_ancre_ex1b'];	$A['pres_ancre_ey10']	=  $A['pres_ancre_ey1b']; }
			elseif ( strlen($A['pres_module_ancre_e1c']) > 0 && $this->ModuleList[$A['pres_module_ancre_e1c']]['module_id'] != 0 )	{ $A['pres_module_ancre_e10']	=  $A['pres_module_ancre_e1c'];	$A['pres_ancre_ex10']	=  $A['pres_ancre_ex1c'];	$A['pres_ancre_ey10']	=  $A['pres_ancre_ey1c']; }
			elseif ( strlen($A['pres_module_ancre_e1d']) > 0 && $this->ModuleList[$A['pres_module_ancre_e1d']]['module_id'] != 0 )	{ $A['pres_module_ancre_e10']	=  $A['pres_module_ancre_e1d'];	$A['pres_ancre_ex10']	=  $A['pres_ancre_ex1d'];	$A['pres_ancre_ey10']	=  $A['pres_ancre_ey1d']; }
			elseif ( strlen($A['pres_module_ancre_e1e']) > 0 && $this->ModuleList[$A['pres_module_ancre_e1e']]['module_id'] != 0 )	{ $A['pres_module_ancre_e10']	=  $A['pres_module_ancre_e1e'];	$A['pres_ancre_ex10']	=  $A['pres_ancre_ex1e'];	$A['pres_ancre_ey10']	=  $A['pres_ancre_ey1e']; }
			
			if ( strlen($A['pres_module_ancre_e2a']) > 0 && $this->ModuleList[$A['pres_module_ancre_e2a']]['module_id'] != 0 )		{ $A['pres_module_ancre_e20']	=  $A['pres_module_ancre_e2a'];	$A['pres_ancre_ex20']	=  $A['pres_ancre_ex2a'];	$A['pres_ancre_ey20']	=  $A['pres_ancre_ey2a']; }
			elseif ( strlen($A['pres_module_ancre_e2b']) > 0 && $this->ModuleList[$A['pres_module_ancre_e2b']]['module_id'] != 0 )	{ $A['pres_module_ancre_e20']	=  $A['pres_module_ancre_e2b'];	$A['pres_ancre_ex20']	=  $A['pres_ancre_ex2b'];	$A['pres_ancre_ey20']	=  $A['pres_ancre_ey2b']; }
			elseif ( strlen($A['pres_module_ancre_e2c']) > 0 && $this->ModuleList[$A['pres_module_ancre_e2c']]['module_id'] != 0 )	{ $A['pres_module_ancre_e20']	=  $A['pres_module_ancre_e2c'];	$A['pres_ancre_ex20']	=  $A['pres_ancre_ex2c'];	$A['pres_ancre_ey20']	=  $A['pres_ancre_ey2c']; }
			elseif ( strlen($A['pres_module_ancre_e2d']) > 0 && $this->ModuleList[$A['pres_module_ancre_e2d']]['module_id'] != 0 )	{ $A['pres_module_ancre_e20']	=  $A['pres_module_ancre_e2d'];	$A['pres_ancre_ex20']	=  $A['pres_ancre_ex2d'];	$A['pres_ancre_ey20']	=  $A['pres_ancre_ey2d']; }
			elseif ( strlen($A['pres_module_ancre_e2e']) > 0 && $this->ModuleList[$A['pres_module_ancre_e2e']]['module_id'] != 0 )	{ $A['pres_module_ancre_e20']	=  $A['pres_module_ancre_e2e'];	$A['pres_ancre_ex20']	=  $A['pres_ancre_ex2e'];	$A['pres_ancre_ey20']	=  $A['pres_ancre_ey2e']; }
			
			if ( strlen($A['pres_module_ancre_e3a']) > 0 && $this->ModuleList[$A['pres_module_ancre_e3a']]['module_id'] != 0 )		{ $A['pres_module_ancre_e30']	=  $A['pres_module_ancre_e3a'];	$A['pres_ancre_ex30']	=  $A['pres_ancre_ex3a'];	$A['pres_ancre_ey30']	=  $A['pres_ancre_ey3a']; }
			elseif ( strlen($A['pres_module_ancre_e3b']) > 0 && $this->ModuleList[$A['pres_module_ancre_e3b']]['module_id'] != 0 )	{ $A['pres_module_ancre_e30']	=  $A['pres_module_ancre_e3b'];	$A['pres_ancre_ex30']	=  $A['pres_ancre_ex3b'];	$A['pres_ancre_ey30']	=  $A['pres_ancre_ey3b']; }
			elseif ( strlen($A['pres_module_ancre_e3c']) > 0 && $this->ModuleList[$A['pres_module_ancre_e3c']]['module_id'] != 0 )	{ $A['pres_module_ancre_e30']	=  $A['pres_module_ancre_e3c'];	$A['pres_ancre_ex30']	=  $A['pres_ancre_ex3c'];	$A['pres_ancre_ey30']	=  $A['pres_ancre_ey3c']; }
			elseif ( strlen($A['pres_module_ancre_e3d']) > 0 && $this->ModuleList[$A['pres_module_ancre_e3d']]['module_id'] != 0 )	{ $A['pres_module_ancre_e30']	=  $A['pres_module_ancre_e3d'];	$A['pres_ancre_ex30']	=  $A['pres_ancre_ex3d'];	$A['pres_ancre_ey30']	=  $A['pres_ancre_ey3d']; }
			elseif ( strlen($A['pres_module_ancre_e3e']) > 0 && $this->ModuleList[$A['pres_module_ancre_e3e']]['module_id'] != 0 )	{ $A['pres_module_ancre_e30']	=  $A['pres_module_ancre_e3e'];	$A['pres_ancre_ex30']	=  $A['pres_ancre_ex3e'];	$A['pres_ancre_ey30']	=  $A['pres_ancre_ey3e']; }
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
	