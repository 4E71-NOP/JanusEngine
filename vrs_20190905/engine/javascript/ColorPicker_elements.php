<?php
 /*Hydre-licence-debut*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/

// Element creation on page demand
// those who use ColorPicker must use this part and call it.
// Known users
//		uni_gestion_des_themes_p02.php (top)

echo ("
<div id='MWM_CP_Palette_Rapide' style='position: absolute; visibility: hidden; display: block;
width: 428px; height: 64px; background-color: #D0D0D0; 
border-color: #000000; border: 1px; border-style: solid;
z-index: 90;
'>
<table border='0' cellspacing='0' cellpadding='0'>\r
<tr>\r
<td><div id='MWM_CP_PR_col_1' style='width: 64px; height: 64px;'></div></td>\r
<td><div id='MWM_CP_PR_PR' style='width: 300px; height: 64px; background-image: url(../media/img/universal/palette_rapide.png);'></div></td>\r
<td><div id='MWM_CP_PR_icone_mode' style='width: 64px; height: 64px; background-image: url(../media/img/universal/icone_switch_colorpicker.png); background-color: #A0A0A0; background-repeat: no-repeat; background-position: center;'></div></td>\r
</tr>\r
</table>\r
</div>\r
");

$cpo['tx'] = 22;			$cpo['ty'] = 22;
$cpe['tx'] = 4;				$cpe['ty'] = 4;

$cpd_deg['tx'] = 256+2;		$cpd_deg['ty'] = 256+2;
$cpd_hue['tx'] = 32+2+12;	$cpd_hue['ty'] = 252+2;
$cpd_ctl['tx'] = 64+2;		$cpd_ctl['ty'] = 64+2;
$cpd_inr['tx'] = 64+2;		$cpd_inr['ty'] = 28;
$cpd_ing['tx'] = 64+2;		$cpd_ing['ty'] = 28;
$cpd_inb['tx'] = 64+2;		$cpd_inb['ty'] = 28;
$cpd_btr['tx'] = 64+2;		$cpd_btr['ty'] = 28;
$cpd_bok['tx'] = 64+2;		$cpd_bok['ty'] = 28;
$cpd_bcl['tx'] = 64+2;		$cpd_bcl['ty'] = 28;
$cpd_swm['tx'] = 16;		$cpd_swm['ty'] = 16;

$cpd_deg['x'] = $cpo['tx'];										$cpd_deg['y'] = $cpo['ty'];
$cpd_hue['x'] = $cpd_deg['x']+$cpd_deg['tx']+$cpe['tx']+6;		$cpd_hue['y'] = $cpo['ty']+2;
$cpd_ctl['x'] = $cpd_hue['x']+$cpd_hue['tx']+$cpe['tx'];		$cpd_ctl['y'] = $cpo['ty'];

$cpd_inr['x'] = $cpd_ctl['x'];									$cpd_inr['y'] = $cpo['tx']+$cpd_ctl['ty']+$cpe['ty'];
$cpd_ing['x'] = $cpd_ctl['x'];									$cpd_ing['y'] = $cpd_inr['y']+$cpd_inr['ty']+$cpe['ty'];
$cpd_inb['x'] = $cpd_ctl['x'];									$cpd_inb['y'] = $cpd_ing['y']+$cpd_ing['ty']+$cpe['ty'];

$cpd_btr['x'] = $cpd_ctl['x'];									$cpd_btr['y'] = $cpd_inb['y']+$cpd_inb['ty']+$cpe['ty'];
$cpd_bok['x'] = $cpd_ctl['x'];									$cpd_bok['y'] = $cpd_btr['y']+$cpd_inb['ty']+$cpe['ty'];
$cpd_bcl['x'] = $cpd_ctl['x'];									$cpd_bcl['y'] = $cpd_bok['y']+$cpd_bok['ty']+$cpe['ty'];

$cpd_pc['tx'] = $cpd_ctl['x']+$cpd_ctl['tx']+$cpo['tx'];		$cpd_pc['ty'] = $cpd_deg['y']+$cpd_deg['ty']+$cpo['tx'];

$cpd_swm['x'] = $cpd_ctl['x'] + $cpd_ctl['tx'] + 3;				$cpd_swm['y'] = 3;


echo ("
<div id='MWM_CP_Palette_complete' style='position: absolute; left: 0px; top: 0px; visibility: hidden; display: block;
width: ".$cpd_pc['tx']."px; height: ".$cpd_pc['ty']."px; background-color: #D0D0D0; 
border-color: #000000; border: 1px; border-style: solid;
z-index: 90;'>

<div id='MWM_CP_PC_degrade' style='position: absolute; left: ".$cpd_deg['x']."px; top: ".$cpd_deg['y']."px; width: 256px; height: 256px; 
background-image: url(../media/img/universal/colorpicker_degrade_alpha.png); background-color: #FF0000; border-color: #000000; border: 1px; border-style: solid;'></div>

<div id='MWM_CP_PC_hue_curseur' style='position: absolute; left: ".($cpd_hue['x']-6)."px; top: ".($cpd_hue['y']-2)."px; width: 46px; height: 6px; 
background-image: url(../media/img/universal/HUE_curseur_001.png);'></div>
<div id='MWM_CP_PC_hue' style='position: absolute; left: ".$cpd_hue['x']."px; top: ".$cpd_hue['y']."px; width: 32px; height: 252px; 
background-image: url(../media/img/universal/hue.png); border-color: #000000; border: 1px; border-style: solid;'></div>


<div id='MWM_CP_PC_col_11' style='position: absolute; left: ".($cpd_ctl['x']+1)."px; top: ".($cpd_ctl['y']+1)."px; width: 64px; height: 32px; 
background-color: #000000; '></div>
<div id='MWM_CP_PC_col_12' style='position: absolute; left: ".($cpd_ctl['x']+1)."px; top: ".( $cpd_ctl['y'] + 33)."px; width: 64px; height: 32px; 
background-color: #000000; '></div>
<div id='MWM_CP_PC_col_10' style='position: absolute; left: ".$cpd_ctl['x']."px; top: ".$cpd_ctl['y']."px; width: 64px; height: 64px; 
border-color: #000000; border: 1px; border-style: solid;'></div>


<div id='MWM_CP_PC_col_r' style='position: absolute; left: ".$cpd_inr['x']."px; top: ".$cpd_inr['y']."px; width: ".$cpd_inr['tx']."px; height: ".$cpd_inr['ty']."px;'>
R:<input type='text' size='2' value='00' id='MWM_CP_PC_col_r_input'></div>
<div id='MWM_CP_PC_col_g' style='position: absolute; left: ".$cpd_ing['x']."px; top: ".$cpd_ing['y']."px; width: ".$cpd_ing['tx']."px; height: ".$cpd_ing['ty']."px;'>
G:<input type='text' size='2' value='00' id='MWM_CP_PC_col_g_input'></div>
<div id='MWM_CP_PC_col_b' style='position: absolute; left: ".$cpd_inb['x']."px; top: ".$cpd_inb['y']."px; width: ".$cpd_inb['tx']."px; height: ".$cpd_inb['ty']."px;'>
B:<input type='text' size='2' value='00' id='MWM_CP_PC_col_b_input'></div>

<button id='MWM_CP_PC_btr' style='position: absolute; left: ".$cpd_btr['x']."px; top: ".$cpd_btr['y']."px; width: ".$cpd_btr['tx']."px; height: ".$cpd_btr['ty']."px;'>Transp</button>
<button id='MWM_CP_PC_bok' style='position: absolute; left: ".$cpd_bok['x']."px; top: ".$cpd_bok['y']."px; width: ".$cpd_bok['tx']."px; height: ".$cpd_bok['ty']."px;'>OK</button>
<button id='MWM_CP_PC_ban' style='position: absolute; left: ".$cpd_bcl['x']."px; top: ".$cpd_bcl['y']."px; width: ".$cpd_bcl['tx']."px; height: ".$cpd_bcl['ty']."px;'>Cancel</button>


<div id='MWM_CP_PC_icone_mode' style='position: absolute; left: ".$cpd_swm['x']."px; top: ".$cpd_swm['y']."px;	width: 16px; height: 16px; background-image: url(../media/img/universal/icone_switch_colorpicker.png); background-repeat: no-repeat; background-position: center;'>
</div>\r
");
