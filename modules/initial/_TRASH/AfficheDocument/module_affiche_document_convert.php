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
//	Convertion des codes utilisés en base
//	preg_replace est lent et coute en memoire.
//	A ne reserver que pour des operations complexes sur expressions complexes
// --------------------------------------------------------------------------------------------
function document_convertion ( $document , $site_rep , $repertoire ) {
	global $module_, $user , $theme_tableau, ${$theme_tableau};

	$ptr = 0;
	for ($i = 1 ; $i < 8 ; $i++ ) {
		$html_str = "<span class='" . $theme_tableau . $_REQUEST['bloc']."_";
		$html_str_p = "<p class='" . $theme_tableau . $_REQUEST['bloc']."_p " . $theme_tableau . $_REQUEST['bloc']."_";
		$tab_rch[$ptr] = "[T".$i."]";		$tab_rpl[$ptr] = $html_str . "t".$i."'> ";					$ptr++;
		$tab_rch[$ptr] = "[TB".$i."]";		$tab_rpl[$ptr] = $html_str . "tb".$i."'> ";					$ptr++;

		$tab_rch[$ptr] = "[T".$i."]";		$tab_rpl[$ptr] = $html_str_p . "t".$i."'> ";				$ptr++;
		$tab_rch[$ptr] = "[TB".$i."]";		$tab_rpl[$ptr] = $html_str_p . "tb".$i."'> ";				$ptr++;
		$tab_rch[$ptr] = "[P".$i."]";		$tab_rpl[$ptr] = $html_str_p . "t".$i."'> ";				$ptr++;
		$tab_rch[$ptr] = "[PB".$i."]";		$tab_rpl[$ptr] = $html_str_p . "tb".$i."'> ";				$ptr++;

		$tab_rch[$ptr] = "[P".$i."B]";		$tab_rpl[$ptr] = $html_str_p . "tb".$i."'> ";				$ptr++;
		$tab_rch[$ptr] = "[T".$i."B]";		$tab_rpl[$ptr] = $html_str . "tb".$i."'> ";					$ptr++;
		$tab_rch[$ptr] = "[CODE".$i."]";		$tab_rpl[$ptr] = "<div class='" . $theme_tableau . $_REQUEST['bloc']."_code'><code class='" . $theme_tableau . $_REQUEST['bloc']."_code " . $theme_tableau . $_REQUEST['bloc']."_t".$i."'> ";	$ptr++;

		$html_str = "<td class='" . $theme_tableau . $_REQUEST['bloc']."_";
		$tab_rch[$ptr] = "[TDFC".$i."]";	$tab_rpl[$ptr] = $html_str . "fc " . $theme_tableau . $_REQUEST['bloc']."_t".$i."' ";		$ptr++;
		$tab_rch[$ptr] = "[TDFCT".$i."]";	$tab_rpl[$ptr] = $html_str . "fct " . $theme_tableau . $_REQUEST['bloc']."_tb".$i."' ";	$ptr++;

		$tab_rch[$ptr] = "[TDFCA".$i."]";	$tab_rpl[$ptr] = $html_str . "fca " . $theme_tableau . $_REQUEST['bloc']."_t".$i."' ";	$ptr++;
		$tab_rch[$ptr] = "[TDFCB".$i."]";	$tab_rpl[$ptr] = $html_str . "fcb " . $theme_tableau . $_REQUEST['bloc']."_t".$i."' ";	$ptr++;
		$tab_rch[$ptr] = "[TDFCC".$i."]";	$tab_rpl[$ptr] = $html_str . "fcc " . $theme_tableau . $_REQUEST['bloc']."_t".$i."' ";	$ptr++;
		$tab_rch[$ptr] = "[TDFCD".$i."]";	$tab_rpl[$ptr] = $html_str . "fcd " . $theme_tableau . $_REQUEST['bloc']."_t".$i."' ";	$ptr++;

		$tab_rch[$ptr] = "[TDFCAB".$i."]";	$tab_rpl[$ptr] = $html_str . "fca " . $theme_tableau . $_REQUEST['bloc']."_tb".$i."' ";	$ptr++;
		$tab_rch[$ptr] = "[TDFCBB".$i."]";	$tab_rpl[$ptr] = $html_str . "fcb " . $theme_tableau . $_REQUEST['bloc']."_tb".$i."' ";	$ptr++;
		$tab_rch[$ptr] = "[TDFCCB".$i."]";	$tab_rpl[$ptr] = $html_str . "fcc " . $theme_tableau . $_REQUEST['bloc']."_tb".$i."' ";	$ptr++;
		$tab_rch[$ptr] = "[TDFCDB".$i."]";	$tab_rpl[$ptr] = $html_str . "fcd " . $theme_tableau . $_REQUEST['bloc']."_tb".$i."' ";	$ptr++;

		$tab_rch[$ptr] = "[TDFCTA".$i."]";	$tab_rpl[$ptr] = $html_str . "fcta " . $theme_tableau . $_REQUEST['bloc']."_t".$i."' ";	$ptr++;
		$tab_rch[$ptr] = "[TDFCTB".$i."]";	$tab_rpl[$ptr] = $html_str . "fctb " . $theme_tableau . $_REQUEST['bloc']."_t".$i."' ";	$ptr++;
		$tab_rch[$ptr] = "[TDFCTAB".$i."]";	$tab_rpl[$ptr] = $html_str . "fcta " . $theme_tableau . $_REQUEST['bloc']."_tb".$i."' ";	$ptr++;
		$tab_rch[$ptr] = "[TDFCTBB".$i."]";	$tab_rpl[$ptr] = $html_str . "fctb " . $theme_tableau . $_REQUEST['bloc']."_tb".$i."' ";	$ptr++;

		$tab_rch[$ptr] = "[L".$i."]";
		$tab_rpl[$ptr] = "<a class='" . $theme_tableau . $_REQUEST['bloc']."_lien " . $theme_tableau . $_REQUEST['bloc']."_t".$i."' href='";
		$ptr++;

		$tab_rch[$ptr] = "[H".$i."]";			$tab_rpl[$ptr] = "<h".$i."'> ";								$ptr++;
		$tab_rch[$ptr] = "[/H".$i."]";			$tab_rpl[$ptr] = "</h".$i."'> ";							$ptr++;
	}
	$tab_rch[$ptr] = "[P]";			$tab_rpl[$ptr] = "<p class='" . $theme_tableau . $_REQUEST['bloc']."_p " . $theme_tableau . $_REQUEST['bloc']."_t2";			$ptr++;
	$tab_rch[$ptr] = "[/P]";		$tab_rpl[$ptr] = "</p>\r";								$ptr++;
	$tab_rch[$ptr] = "[TABLE]";		$tab_rpl[$ptr] = "<table>\r";							$ptr++;
	$tab_rch[$ptr] = "[/TABLE]";	$tab_rpl[$ptr] = "</table>\r";							$ptr++;
	$tab_rch[$ptr] = "[TW_MLI]";	$tab_rpl[$ptr] = ${$theme_tableau}['skin_module_largeur_interne'];			$ptr++;
	$tab_rch[$ptr] = "[TAB_STD]";	$tab_rpl[$ptr] = "<table ".${$theme_tableau}['tab_std_rules']." style='text-align: left; vertical-align: top;'width='";			$ptr++;
	$tab_rch[$ptr] = "[/L]";		$tab_rpl[$ptr] = "</a>";								$ptr++;
	$tab_rch[$ptr] = "[TR]";		$tab_rpl[$ptr] = "<tr>";								$ptr++;
	$tab_rch[$ptr] = "[/TR]";		$tab_rpl[$ptr] = "</tr>\r";								$ptr++;
	$tab_rch[$ptr] = "[TD]";		$tab_rpl[$ptr] = "<td>";								$ptr++;
	$tab_rch[$ptr] = "[/TD]";		$tab_rpl[$ptr] = "</td>\r";								$ptr++;
	$tab_rch[$ptr] = "[COLSP]";		$tab_rpl[$ptr] = " colspan='";							$ptr++;
	$tab_rch[$ptr] = "[ROWSP]";		$tab_rpl[$ptr] = " rowspan='";							$ptr++;
	$tab_rch[$ptr] = "[CODE]";		$tab_rpl[$ptr] = "<div class='" . $theme_tableau . $_REQUEST['bloc']."_code'><code class='" . $theme_tableau . $_REQUEST['bloc']."_code'> ";		$ptr++;
	$tab_rch[$ptr] = "[/CODE]";		$tab_rpl[$ptr] = "</div></code>";						$ptr++;
	$tab_rch[$ptr] = "[FE]";		$tab_rpl[$ptr] = "'>";									$ptr++;
	$tab_rch[$ptr] = "[F]";			$tab_rpl[$ptr] = ">";									$ptr++;

	$tab_rch[$ptr] = "[J]";			$tab_rpl[$ptr] = "<p style='text-align: justify;'>\r";	$ptr++;
	$tab_rch[$ptr] = "[/J]";		$tab_rpl[$ptr] = "</p>\r";								$ptr++;
	$tab_rch[$ptr] = "[BR]";		$tab_rpl[$ptr] = "<br>\r";								$ptr++;
	$tab_rch[$ptr] = "[HR]";		$tab_rpl[$ptr] = "<hr>\r";								$ptr++;
	$tab_rch[$ptr] = "[B]";			$tab_rpl[$ptr] = "<span style='font-weight: bold;'>";	$ptr++;
	$tab_rch[$ptr] = "[/B]";		$tab_rpl[$ptr] = "</span>";								$ptr++;
	$tab_rch[$ptr] = "[CENTER]";	$tab_rpl[$ptr] = "<p style='text-align: center;'>";		$ptr++;
	$tab_rch[$ptr] = "[/CENTER]";	$tab_rpl[$ptr] = "</p>\r";								$ptr++;
	$tab_rch[$ptr] = "[TAB]";		$tab_rpl[$ptr] = "&nbsp;&nbsp;&nbsp;&nbsp;";			$ptr++;
	$tab_rch[$ptr] = "[L_T]";		$tab_rpl[$ptr] = "' target='_NEW'>";					$ptr++;

	$tab_rch[$ptr] = "[USER_L]";	$tab_rpl[$ptr] = $user['login'];						$ptr++;
	$tab_rch[$ptr] = "[USER_P]";	$tab_rpl[$ptr] = $user['pass'];							$ptr++;
	$tab_rch[$ptr] = "[USER_LP]";	$tab_rpl[$ptr] = "&user_login=".$user['login']."&user_pass=".$user['pass'];			$ptr++;

	$tab_rch[$ptr] = "[POPIMG_L]";	$tab_rpl[$ptr] = "<a target='_NEW' href='../websites-datas/".$site_rep."/data/documents/".$repertoire."/";			$ptr++;
	$tab_rch[$ptr] = "[/POPIMG_L]";	$tab_rpl[$ptr] = "'>";			$ptr++;

	$tab_rch[$ptr] = "[POPIMG_I]";	$tab_rpl[$ptr] = "<img src='../websites-datas/".$site_rep."/data/documents/".$repertoire."/";			$ptr++;
	$tab_rch[$ptr] = "[POPIMG_S10]";	$tab_rpl[$ptr] = "' alt='Click' width='10%' height='10%' border='0";						$ptr++;
	$tab_rch[$ptr] = "[POPIMG_S20]";	$tab_rpl[$ptr] = "' alt='Click' width='20%' height='20%' border='0";						$ptr++;
	$tab_rch[$ptr] = "[POPIMG_S30]";	$tab_rpl[$ptr] = "' alt='Click' width='30%' height='30%' border='0";						$ptr++;
	$tab_rch[$ptr] = "[POPIMG_S40]";	$tab_rpl[$ptr] = "' alt='Click' width='40%' height='40%' border='0";						$ptr++;
	$tab_rch[$ptr] = "[POPIMG_S50]";	$tab_rpl[$ptr] = "' alt='Click' width='50%' height='50%' border='0";						$ptr++;
	$tab_rch[$ptr] = "[POPIMG_S60]";	$tab_rpl[$ptr] = "' alt='Click' width='60%' height='60%' border='0";						$ptr++;
	$tab_rch[$ptr] = "[POPIMG_S70]";	$tab_rpl[$ptr] = "' alt='Click' width='70%' height='70%' border='0";						$ptr++;
	$tab_rch[$ptr] = "[POPIMG_S80]";	$tab_rpl[$ptr] = "' alt='Click' width='80%' height='80%' border='0";						$ptr++;
	$tab_rch[$ptr] = "[POPIMG_S90]";	$tab_rpl[$ptr] = "' alt='Click' width='90%' height='90%' border='0";						$ptr++;
	$tab_rch[$ptr] = "[POPIMG_S100]";	$tab_rpl[$ptr] = "' alt='Click' width='100%' height='100%' border='0";						$ptr++;
	$tab_rch[$ptr] = "[/POPIMG_I]";	$tab_rpl[$ptr] = "'>";			$ptr++;


	$tab_rch[$ptr] = "[IMGSRC]";	$tab_rpl[$ptr] = "<img src='../websites-datas/".$site_rep."/data/documents/".$repertoire."/";			$ptr++;
	$tab_rch[$ptr] = "[IMGALT]";	$tab_rpl[$ptr] = "' alt='";								$ptr++;
	$tab_rch[$ptr] = "[IMGBRD]";	$tab_rpl[$ptr] = "' border='0'>";						$ptr++;

	$tab_rch[$ptr] = "[FLOAT_L]";	$tab_rpl[$ptr] = "<div style='float: left;'>";			$ptr++;
	$tab_rch[$ptr] = "[FLOAT_R]";	$tab_rpl[$ptr] = "<div style='float: right;'>";			$ptr++;
	$tab_rch[$ptr] = "[/FLOAT]";	$tab_rpl[$ptr] = "</div>";								$ptr++;

	$tab_rch[$ptr] = "[/F]";		$tab_rpl[$ptr] = "</span>";								$ptr++;

	$document = str_replace ($tab_rch,$tab_rpl,$document);

	unset ($tab_rch , $tab_rpl );
	return $document;
}
?>
