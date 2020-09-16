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
//	Statistiques de la page
// --------------------------------------------------------------------------------------------
$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = 0;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 6;	$ADC['onglet'][$pv['onglet']]['legende'] = 6;

$memory_['peak'] = ( memory_get_peak_usage() );
$memory_['usage'] = memory_get_usage();

$Tab_unite = array ("b","Kb","MB","GB");
// --------------------------------------------------------------------------------------------
$tl_['eng']['o2l11']	= "Pos";									$tl_['fra']['o2l11']	= "Pos";
$tl_['eng']['o2l12']	= "Checkpoint";								$tl_['fra']['o2l12']	= "Point de contr&ocirc;le";
$tl_['eng']['o2l13']	= "Time";									$tl_['fra']['o2l13']	= "Temps";
$tl_['eng']['o2l14']	= "Memory";									$tl_['fra']['o2l14']	= "M&eacute;moire";
$tl_['eng']['o2l15']	= "Queries";								$tl_['fra']['o2l15']	= "Requ&ecirc;tes";
$tl_['eng']['o2l16']	= "Localisation";							$tl_['fra']['o2l16']	= "Localisation";

$AD[$pv['onglet']]['1']['1']['cont'] = $tl_[$l]['o2l11'];	$AD[$pv['onglet']]['1']['1']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb3";	$AD[$pv['onglet']]['1']['1']['style'] = "text-align: center;";
$AD[$pv['onglet']]['1']['2']['cont'] = $tl_[$l]['o2l12'];	$AD[$pv['onglet']]['1']['2']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb3";
$AD[$pv['onglet']]['1']['3']['cont'] = $tl_[$l]['o2l13'];	$AD[$pv['onglet']]['1']['3']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb3";	$AD[$pv['onglet']]['1']['3']['style'] = "text-align: center;";
$AD[$pv['onglet']]['1']['4']['cont'] = $tl_[$l]['o2l14'];	$AD[$pv['onglet']]['1']['4']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb3";	$AD[$pv['onglet']]['1']['4']['style'] = "text-align: center;";
$AD[$pv['onglet']]['1']['5']['cont'] = $tl_[$l]['o2l15'];	$AD[$pv['onglet']]['1']['5']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb3";	$AD[$pv['onglet']]['1']['5']['style'] = "text-align: center;";
$AD[$pv['onglet']]['1']['6']['cont'] = $tl_[$l]['o2l16'];	$AD[$pv['onglet']]['1']['6']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb3";

// --------------------------------------------------------------------------------------------
$sg['MemoireMax'] = 0;
$sg['MemoireMin'] = 1000;
$sg['TempsMin'] = microtime_chrono();
$sg['TempsMax'] = 0;

$sg['x'] = ${$theme_tableau}['theme_module_largeur_interne'] - 32;
// $sg['x'] = ${$theme_tableau}['theme_module_largeur_interne'] * 4;
$sg['y'] = 320;
$sg['bordH'] = 8;
$sg['bordB'] = 64;
$sg['bordG'] = 64;
$sg['bordD'] = 24;

$TableStats = $LMObj->getStatisticsLog();


reset ( $TableStats );
unset ( $A );
// foreach ( $statistiques_ as &$A ) {
foreach ( $TableStats as &$A ) {
	$A['SgMem'] = round(( $A['memoire'] / 1024 ), 2 );
	if ( $A['SgMem'] > $sg['MemoireMax'] ) { $sg['MemoireMax'] = $A['SgMem']; }
	if ( $A['SgMem'] < $sg['MemoireMin'] ) { $sg['MemoireMin'] = $A['SgMem']; }
	if ( $A['temps'] > $sg['TempsMax'] ) { $sg['TempsMax'] = $A['temps']; }
	if ( $A['temps'] < $sg['TempsMin'] ) { $sg['TempsMin'] = $A['temps']; }
}

$sg['MemoireMax'] = ( $sg['MemoireMax'] * 1.1 );
// $sg['GraphPasX'] = count($statistiques_ );
$sg['GraphPasX'] = count($TableStats);

$sg['NbrGrilleX'] = $sg['GraphPasX']; // L'abscice n'est pas une echelle incrémentée. Ce sont les Checkpoint a différents moment du script.
$sg['NbrGrilleY'] = 4;

$sg['memcoef'] = ($sg['MemoireMax'] - $sg['MemoireMin'] ) / ($sg['y'] - $sg['bordH']- $sg['bordB']);
$sg['tempscoef'] = ($sg['TempsMax'] - $sg['TempsMin'] ) / ($sg['y'] - $sg['bordH']- $sg['bordB']);
$sg['GraphPasX'] = ($sg['x']-$sg['bordD']-$sg['bordD']) / ($sg['GraphPasX']+0.5);
$sg['mime'] = "png";

$sg['img'] = imagecreatetruecolor( $sg['x'] , $sg['y'] );
imageantialias($sg['img'], true);

$sg['C_bg'] = imagecolorallocate( $sg['img'], 255,255, 255);
$sg['C_bg2'] = imagecolorallocate( $sg['img'], 255, 255, 240);
$sg['C_noir'] = imagecolorallocate( $sg['img'], 0, 0, 0);
$sg['C_routine'] = imagecolorallocate( $sg['img'], 128, 128, 255);
$sg['C_gris'] = imagecolorallocate( $sg['img'], 192, 192, 192);
$sg['C_l1'] = imagecolorallocate( $sg['img'], 255, 0, 0);
$sg['C_l2'] = imagecolorallocate( $sg['img'], 208, 208, 255);

$sg['fonte_legende'] = 3;
$sg['fonte_barre'] = 2;
$sg['fonte_barre2'] = $sg['fonte_barre']-1;
$sg['barre_coef'] = 0.75;

reset ( $TableStats );
unset ( $A );
$pv['i'] = 2;
$pv['mem_b4'] = 0;
	
// foreach ( $statistiques_ as &$A ) {
foreach ( $TableStats as &$A ) {
	$A['memX'] = floor (( ($pv['i']-2) * $sg['GraphPasX']) + $sg['bordG'] );
	$A['memY'] = floor (($sg['y']-$sg['bordB']) - (($A['SgMem']-$sg['MemoireMin'])/$sg['memcoef']));

	if ( $pv['i'] == 2 ) { $sg['tempsAV'] = $A['temps']; }
	$A['TempsPerf'] =  round ( ($A['temps'] - $sg['tempsAV']), 4 );
	$A['TempsCheckpoint'] =  round ($A['temps'] - $sg['TempsMin'], 4 );
	$A['tempsX'] = floor ((( ($pv['i']-2) * $sg['GraphPasX']) + $sg['bordG']) - (($sg['GraphPasX']*$sg['barre_coef'])/2) );
	$A['tempsY'] = floor (($sg['y']-$sg['bordB']) - (($A['temps']-$sg['tempsAV'])/$sg['tempscoef'])); 
	$sg['tempsAV'] = $A['temps'];

	$A['MemoireSegment'] = ( $A['memoire'] - $pv['mem_b4'] );
	$pv['mem_b4'] = $A['memoire'];

	$AD[$pv['onglet']][$pv['i']]['1']['cont'] = $A['position'];								$AD[$pv['onglet']][$pv['i']]['1']['tc'] = 1;	$AD[$pv['onglet']][$pv['i']]['1']['style'] = "text-align: center;";
	$AD[$pv['onglet']][$pv['i']]['2']['cont'] = $A['routine'];								$AD[$pv['onglet']][$pv['i']]['2']['tc'] = 1;
	$AD[$pv['onglet']][$pv['i']]['3']['cont'] = $A['TempsPerf'];							$AD[$pv['onglet']][$pv['i']]['3']['tc'] = 1;	$AD[$pv['onglet']][$pv['i']]['3']['style'] = "text-align: center;";
	$AD[$pv['onglet']][$pv['i']]['4']['cont'] = Conversion_taille ( $A['MemoireSegment'] );	$AD[$pv['onglet']][$pv['i']]['4']['tc'] = 1;	$AD[$pv['onglet']][$pv['i']]['4']['style'] = "text-align: center;";
	$AD[$pv['onglet']][$pv['i']]['5']['cont'] = $A['SQL_queries'];							$AD[$pv['onglet']][$pv['i']]['5']['tc'] = 1;	$AD[$pv['onglet']][$pv['i']]['5']['style'] = "text-align: center;";
	$AD[$pv['onglet']][$pv['i']]['6']['cont'] = $A['context'];								$AD[$pv['onglet']][$pv['i']]['6']['tc'] = 1;

	$pv['i']++;
}

reset ( $TableStats );
unset ( $A );
// foreach ( $statistiques_ as $A ) {
foreach ( $TableStats as $A ) {
	$allmem += $A['MemoireSegment'];
	$alltime += $A['TempsPerf'];
	$allqueries += $A['SQL_queries'];
// 	$alltimesimple = round ( $A['temps'] - $statistiques_['0']['temps'] , 3 );
	$B = $LMObj->getStatisticsEntry('0');
	$alltimesimple = round ( $A['temps'] - $B ['temps'] , 3 );
}

$AD[$pv['onglet']][$pv['i']]['2']['cont'] = "=>";										$AD[$pv['onglet']][$pv['i']]['2']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb4";	$AD[$pv['onglet']][$pv['i']]['2']['style'] = "text-align: center;";
$AD[$pv['onglet']][$pv['i']]['3']['cont'] = "~".$alltime."s<br>(".$alltimesimple.")";	$AD[$pv['onglet']][$pv['i']]['3']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb4";	$AD[$pv['onglet']][$pv['i']]['3']['style'] = "text-align: center;";
$AD[$pv['onglet']][$pv['i']]['4']['cont'] = "~".Conversion_taille( $allmem );			$AD[$pv['onglet']][$pv['i']]['4']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb4";	$AD[$pv['onglet']][$pv['i']]['4']['style'] = "text-align: center;";
$AD[$pv['onglet']][$pv['i']]['5']['cont'] = $allqueries;								$AD[$pv['onglet']][$pv['i']]['5']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb4";	$AD[$pv['onglet']][$pv['i']]['5']['style'] = "text-align: center;";

$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = $pv['i'];

/*
$ADC['onglet'][$pv['onglet']]['theadD'] = 1;
$ADC['onglet'][$pv['onglet']]['theadF'] = 1;
$ADC['onglet'][$pv['onglet']]['tbodyD'] = 2;
$ADC['onglet'][$pv['onglet']]['tbodyF'] = $ADC['onglet'][$pv['onglet']]['nbr_ligne']-1;
$ADC['onglet'][$pv['onglet']]['tfootD'] = $ADC['onglet'][$pv['onglet']]['nbr_ligne'];
$ADC['onglet'][$pv['onglet']]['tfootF'] = $ADC['onglet'][$pv['onglet']]['nbr_ligne'];

$ADC['onglet'][$pv['onglet']]['colswidth']['1'] = 0.05;
$ADC['onglet'][$pv['onglet']]['colswidth']['2'] = 0.25;
$ADC['onglet'][$pv['onglet']]['colswidth']['3'] = 0.1;
$ADC['onglet'][$pv['onglet']]['colswidth']['4'] = 0.1;
$ADC['onglet'][$pv['onglet']]['colswidth']['5'] = 0.1;
$ADC['onglet'][$pv['onglet']]['colswidth']['6'] = 0.4;
*/

// --------------------------------------------------------------------------------------------
//statistique_graph

imagefilledrectangle ( $sg['img'], 0, 0, $sg['x'], $sg['y'], $sg['C_bg'] );
imagefilledrectangle ( $sg['img'], $sg['bordG'], $sg['bordH'], ($sg['x']-$sg['bordD']), ($sg['y']-$sg['bordB']), $sg['C_bg2'] );

for ( $sg['cptr'] = 0; $sg['cptr'] <= $sg['NbrGrilleY']; $sg['cptr']++ ) {
	$sg['ligne'] = floor(((($sg['y']-$sg['bordH']-$sg['bordB']) / $sg['NbrGrilleY']) * $sg['cptr'])+$sg['bordH']);
	imageline( $sg['img'], $sg['bordG'], $sg['ligne'] , ($sg['x']-$sg['bordD']), $sg['ligne'], $sg['C_gris'] );
	$sg['echlY'] = (((($sg['MemoireMax']-$sg['MemoireMin'])/$sg['NbrGrilleY'])*($sg['NbrGrilleY']-$sg['cptr']))+$sg['MemoireMin'])*1024;
	$sg['echlY'] = round($sg['echlY']/pow(1024,($pv['i']=floor(log($sg['echlY'],1024)))),2).$Tab_unite[$pv['i']];
//	$sg['echlY'] = round(((($sg['MemoireMax']-$sg['MemoireMin'])/$sg['NbrGrilleY'])*($sg['NbrGrilleY']-$sg['cptr']))+$sg['MemoireMin'],0) . "kb";
	imagestring( $sg['img'], 3, $sg['bordG']-floor(((strlen($sg['echlY'])+2)*6)), $sg['ligne']-6, $sg['echlY'] , $sg['C_noir'] );
}

$sg['tempsX1'] = $sg['bordG'];
$sg['tempsY1'] = $sg['y']-$sg['bordB'];
$sg['memX1'] = $sg['bordG'];
$sg['memY1'] = $sg['y']-$sg['bordB'];

reset ( $TableStats );
unset ( $A );
// foreach ( $statistiques_ as &$A ) {
foreach ( $TableStats as &$A ) {
	imageline( $sg['img'], $A['memX'], $sg['bordH'] , $A['memX'], ($sg['y']-$sg['bordB']), $sg['C_gris'] );
	imagestringup ( $sg['img'], $sg['fonte_legende'], ( $A['memX']- floor ( $sg['fonte_legende']*2.5) ), $sg['y']-$sg['bordB'] + floor((strlen($A['TempsCheckpoint'])+1)*($sg['fonte_legende']*2.5)), $A['TempsCheckpoint']."s" , $sg['C_noir'] );

	imagefilledrectangle ( $sg['img'], $A['tempsX'], $A['tempsY'], floor($A['tempsX']+(($sg['GraphPasX']*$sg['barre_coef']))), $sg['y']-$sg['bordB'], $sg['C_l2']);
	imagestringup ( $sg['img'], $sg['fonte_barre'], ( $A['tempsX']+2 ), $sg['y']-$sg['bordB'] -2, $A['routine'] , $sg['C_routine'] );

	$B = $A['TempsPerf']."s";
	$C = "; ";
	if ( $A['MemoireSegment'] < 0 ) { $C .= "-"; }
	$C .= round(abs($A['MemoireSegment'])/pow(1024,($pv['i']=floor(log(abs($A['MemoireSegment']),1024)))),2).$Tab_unite[$pv['i']];
	$D = "; SQL err:" . $A['SQL_err'] . "/" . $A['SQL_queries'];
	imagestringup ( $sg['img'], $sg['fonte_barre2'], ( $A['memX']+2 ), $sg['y']-$sg['bordB'] -2, $B.$C.$D , $sg['C_routine'] );

	ImageSetThickness ( $sg['img'], 3);
	imageline( $sg['img'], $sg['memX1'], $sg['memY1'], $A['memX'], $A['memY'], $sg['C_l1']);
	ImageSetThickness ( $sg['img'], 1);

	imagefilledellipse ( $sg['img'] , $A['memX'] , $A['memY'] , 6 , 6 , $sg['C_l1'] );

	$sg['memX1'] = $A['memX'];
	$sg['memY1'] = $A['memY'];
	$sg['tempsX1'] = $A['tempsX'];
	$sg['tempsY1'] = $A['tempsY'];
}

imageline( $sg['img'], $sg['bordG'], $sg['bordH'], $sg['bordG'], ($sg['y'] - $sg['bordB'] ) , $sg['C_noir']);
imageline( $sg['img'], $sg['bordG'], ($sg['y']-$sg['bordB']), ($sg['x']-$sg['bordD']), ($sg['y']-$sg['bordB']), $sg['C_noir']);

switch ( $sg['mime'] ) {
	case "gif" : ob_start();	imagegif( $sg['img'] );					$sg['render'] = ob_get_contents();	ob_end_clean();	imagedestroy($sg['img']);	break;
	case "png" : ob_start();	imagepng( $sg['img'] );					$sg['render'] = ob_get_contents();	ob_end_clean();	imagedestroy($sg['img']);	break;
	case "jpg" : ob_start();	imagejpeg( $sg['img'] , NULL , 60 );	$sg['render'] = ob_get_contents();	ob_end_clean();	imagedestroy($sg['img']);	break;
}

$sg['render'] = base64_encode ( $sg['render'] );
echo ('<img src="data:image/'.$sg['mime'].';base64,'. $sg['render'] .'" border="1" alt="Graph" width="'.$sg['x'].'" height="'.$sg['y'].'"><br><br>');
$sg['render'] = "img";
//imagedestroy($sg['img']);

// --------------------------------------------------------------------------------------------
if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') < 10 ) {
unset(
	$A,
	$B,
	$C,
	$D
	);
}

?>
