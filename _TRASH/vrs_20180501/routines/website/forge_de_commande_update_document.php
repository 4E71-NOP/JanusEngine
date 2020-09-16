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

// $pv['ac_pd']		Pointeur début
// $pv['ac_pf']		Pointeur fin
// $pv['ril']		Longeur du contenu $_REQUEST['M_DOCUME']['cont']
// $pv['acm_cm']	
// $pv['acm_cs']	


//Transformer le testeur de code PHP en fonction pour une plus grande maleabilité.
$ligne++;

if ( strlen($_REQUEST['M_DOCUME']['fichier']) > 0 )	{ 
	$tampon_commande_buffer[$ligne] .= "insert_content file	\"".$_REQUEST['M_DOCUME']['fichier']."\"	to \"".$_REQUEST['M_DOCUME']['nom']."\" \n";
}
else {
	$tampon_commande_buffer[$ligne] = "update document name \"".$_REQUEST['M_DOCUME']['nom']. "\"	\n";
	if ( isset($_REQUEST['M_DOCUME']['type']) )			{ $tampon_commande_buffer[$ligne] .= "type					\"".$_REQUEST['M_DOCUME']['type']."\"	\n";}
	if ( isset($_REQUEST['M_DOCUME']['modification']) )	{ $tampon_commande_buffer[$ligne] .= "modification			\"".$_REQUEST['M_DOCUME']['modification']."\"	\n";}

	if ( isset($_REQUEST['M_DOCUME']['correction_activation']) )	{ 
		$tampon_commande_buffer[$ligne] .= "checked			\"".$_REQUEST['M_DOCUME']['correction']."\"	\n";
		$tampon_commande_buffer[$ligne] .= "examiner		\"".$user['login_decode']."\"	\n";
	}
	else { $tampon_commande_buffer[$ligne] .= "checked			\"NO\"	\n"; }

	$_REQUEST['M_DOCUME']['cont'] = stripslashes( $_REQUEST['M_DOCUME']['cont'] );
	if ( strlen($_REQUEST['M_DOCUME']['cont']) > 0 ) {
		switch ( $_REQUEST['M_DOCUME']['type'] ) {
			case 0:		/*MWM code*/
				$_REQUEST['M_DOCUME']['cont'] = str_replace("\n","['BR']", $_REQUEST['M_DOCUME']['cont']);
			break;
			case 1:		//NOCODE
			break;
			case 2:		//PHP
				$pv['MD_cont'] = ""; 
				$pv['ril'] = strlen ($_REQUEST['M_DOCUME']['cont']);
				$pv['ac_pd'] = $pv['ac_pf'] = $pv['acm_cs'] = $pv['acm_cm'] = 0;

				while ( $pv['ac_pd'] < $pv['ril'] ) {
					unset ($tab_ri);
					$pv['x'] = strpos ( $_REQUEST['M_DOCUME']['cont'] , "//" , $pv['ac_pf'] );	if ( $pv['x'] === FALSE ) { $tab_ri['9994'] = 4; } else { $tab_ri[$pv['x']] = 4; }
					$pv['x'] = strpos ( $_REQUEST['M_DOCUME']['cont'] , "/*" , $pv['ac_pf'] );	if ( $pv['x'] === FALSE ) { $tab_ri['9993'] = 8; } else { $tab_ri[$pv['x']] = 8; }
					$pv['x'] = strpos ( $_REQUEST['M_DOCUME']['cont'] , "*/" , $pv['ac_pf'] );	if ( $pv['x'] === FALSE ) { $tab_ri['9992'] = 16;} else { $tab_ri[$pv['x']] = 16; }
					$pv['x'] = strpos ( $_REQUEST['M_DOCUME']['cont'] , "\n" , $pv['ac_pf'] );	if ( $pv['x'] === FALSE ) { $tab_ri['9991'] = 32;} else { $tab_ri[$pv['x']] = 32; }
					ksort ($tab_ri);
					reset ($tab_ri);
					$pv['key'] = key($tab_ri);
					if ( $pv['key'] < 9990 ) { $pv['x'] = $tab_ri[$pv['key']]; } else { $pv['x'] = 0; }

					$pv['score'] = ($pv['acm_cm']*2)+$pv['acm_cs']+$pv['x'];
					// echo ("s=$pv['score'] / d=$pv['ac_pd']  f=$pv['ac_pf'] k=$pv['key'] x=$pv['x'] - ");
					switch ($pv['score']) {
					case 0:
					case 1:
					case 2:
						$pv['MD_cont'] .= substr( $_REQUEST['M_DOCUME']['cont'] , $pv['ac_pf'] , ($pv['ril']-$pv['ac_pf']) );
						$pv['ac_pd'] = $pv['ac_pf'] = $pv['ril'];
					break;
					case 4:
						$pv['acm_cs'] = 1;	$pv['ac_pf'] = $pv['key'];
						$pv['MD_cont'] .= substr( $_REQUEST['M_DOCUME']['cont'] , $pv['ac_pd'] , ($pv['ac_pf']-$pv['ac_pd']) );
						$pv['ac_pd'] = $pv['ac_pf'];
					break;
					case 8:
						$pv['acm_cm'] = 1;	$pv['ac_pf'] = $pv['key'];
						$pv['MD_cont'] .= substr( $_REQUEST['M_DOCUME']['cont'] , $pv['ac_pd'] , ($pv['ac_pf']-$pv['ac_pd']) );
						$pv['ac_pd'] = $pv['ac_pf'];
					break;
					case 5:
					case 6:
					case 9:
					case 10:
						if ( $_REQUEST['M_DOCUME']['gardcom'] == "on" ) { $pv['MD_cont'] .= substr( $_REQUEST['M_DOCUME']['cont'] , $pv['ac_pd'] , ($pv['key']-$pv['ac_pd']) ); }
						$pv['ac_pd'] = $pv['key'];
						$pv['ac_pf'] = $pv['key']+2;
					break;
					case 17:
						$pv['ac_pf'] = $pv['key']+2;
						if ( $_REQUEST['M_DOCUME']['gardcom'] == "on" ) { $pv['MD_cont'] .= substr( $_REQUEST['M_DOCUME']['cont'] , $pv['ac_pd'] , ($pv['ac_pf']-$pv['ac_pd']) ); }
						$pv['ac_pd'] = $pv['ac_pf'];
					break;
					case 16:
					case 32:
					case 34:
						$pv['ac_pf'] = $pv['key']+2;
						$pv['MD_cont'] .= substr( $_REQUEST['M_DOCUME']['cont'] , $pv['ac_pd'] , ($pv['ac_pf']-$pv['ac_pd']) );
						$pv['ac_pd'] = $pv['ac_pf'];
					break;
					case 18:
						$pv['acm_cm'] = 0;	$pv['ac_pf'] = $pv['key']+2;
						if ( $_REQUEST['M_DOCUME']['gardcom'] == "on" ) { $pv['MD_cont'] .= substr( $_REQUEST['M_DOCUME']['cont'] , $pv['ac_pd'] , ($pv['ac_pf']-$pv['ac_pd']) ); }
						$pv['ac_pd'] = $pv['ac_pf'];
					break;
					case 33:
						$pv['acm_cs'] = 0;	$pv['ac_pf'] = $pv['key']+2;
						if ( $_REQUEST['M_DOCUME']['gardcom'] == "on" ) { $pv['MD_cont'] .= substr( $_REQUEST['M_DOCUME']['cont'] , $pv['ac_pd'] , ($pv['ac_pf']-$pv['ac_pd']) ); }
						$pv['ac_pd'] = $pv['ac_pf'];
					break;
					}
				}
				$tab_rch = array ("'",		'"');
				$tab_rpl = array ("<*G1*>",	"<*G2*>");
				$_REQUEST['M_DOCUME']['cont'] = str_replace ($tab_rch,$tab_rpl,$pv['MD_cont']);											
			break;
			case 3:		/*mixed : faire une routine d'analyse*/
			break;
		}
	//	$_REQUEST['M_DOCUME']['cont'] = $db->escape( $_REQUEST['M_DOCUME']['cont'] , $escape_wildcards = false );
		$tampon_commande_buffer[$ligne] .= "content			\"".$_REQUEST['M_DOCUME']['cont']."\"	\n";
	}
}
?>
