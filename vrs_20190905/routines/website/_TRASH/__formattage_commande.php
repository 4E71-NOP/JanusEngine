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

function cartographie_expression ( $motif , $code, $poserr, &$chaine, &$TAC ) {
	$increment = strlen($motif);
	$ptr = 0;
	while ( $stop == 0 ) {
		$x = strpos( $chaine , $motif , $ptr ); 
		if ( $x  === FALSE ) { 
			$TAC[$poserr] = $code;
			$stop = 1; 
		} 
		else { 
			$TAC[$x] = $code;
			$ptr = $x+$increment;
		}
	}
	$TAC['99990'] = 8;				// Fin de fichier
}

function formattage_commande ( &$carte , &$tampon , &$Dest ) {
	$strRch01 = array ( "\n",	"\r",	"\t",	"  " );
	$strRpl01 = array ( " ",	" ",	" ",	" ");
	$strRch02 = array ( "",		"",		" ",	" " );

//						0	1	2	3	4	5	6	7	8
	$MatriceDeCas = array (
		0 => array (	0,	1,	0,	3,	4,	5,	6,	98,	99	),
		1 => array (	0,	0,	12,	0,	0,	0,	0,	0,	99	),
		2 => array (	0,	0,	0,	0,	24,	0,	0,	0,	99	),
		3 => array (	0,	0,	0,	0,	0,	35,	0,	0,	99	),
		4 => array (	0,	0,	0,	0,	0,	0,	46,	0,	99	),
	);
	$compilation = "";
	$FCMode = $PtrD = 0;
	$fincommande = 1;
	$idx = 0;

	foreach ( $carte as $K => $A ) {
		if ( $K <= 99990 ) {
			$directive = $MatriceDeCas[$FCMode][$A];
			switch ( $directive ) {
			case 1:		$FCMode = 1;	$compilation .= substr($tampon, $PtrD, ($K-$PtrD));		$PtrD = $K;		break;		// passe en mode commentaire 
			case 3:		$FCMode = 2;	$compilation .= substr($tampon, $PtrD, ($K-$PtrD));		$PtrD = $K;		break;		// passe en mode commentaire multiligne
			case 4:		$erreur = 1;																			break;		// erreur , Stocke tableau le msg erreur
			case 5:		$FCMode = 3;	$compilation .= substr($tampon, $PtrD, ($K-$PtrD));		$PtrD = $K;		break;		// passe en mode citation1
			case 6:		$FCMode = 4;	$compilation .= substr($tampon, $PtrD, ($K-$PtrD));		$PtrD = $K;		break;		// passe en mode citation2 
			case 12:	$FCMode = 0;															$PtrD = $K+1;	break;		// passe en mode initial 
			case 24:	$FCMode = 0;															$PtrD = $K+2;	break;		// passe en mode initial
			case 35:
			case 46:	$FCMode = 0;																			break;		// passe en mode initial
			case 98:
				$FCMode = 0;																								// passe en mode initial
				$compilation .= substr($tampon, $PtrD, ($K-$PtrD));															// Copie le dernier segment valide.
				$compilation = str_replace ( $strRch01 , $strRpl01 , $compilation );										//
				$Dest[$idx]['cont'] = $compilation;																			//
				$compilation = "";																							//
				$PtrD = $K+1;																								//aligne les pointeurs
				$idx++;
			break;
			case 99:
				$FCMode = 0;												// Passe en mode initial
				$compilation .= substr($tampon, $PtrD, ($K-$PtrD));			// Copie le dernier segment valide.
				$PtrD = $K+1;												// Aligne les pointeurs
				$EOF = 1;
			break;
			}
		}
	}
	if ( isset($EOF) ) {
		$compilation = str_replace ( $strRch01 , $strRpl02 , $compilation );													//
		if ( $compilation != " " ) { $OEFdechet = 1; }
	}
	if ( strlen($compilation) > 0 ) { 
		$Dest[$idx]['cont'] = $compilation; 
		if ( $OEFdechet == 1 ) { $Dest[$idx]['Ordre'] = 1; }
	}
	$compilation = "";
	if ( $erreur == 1) { $Dest[$idx]['Ordre'] = 1; }
}

?>
