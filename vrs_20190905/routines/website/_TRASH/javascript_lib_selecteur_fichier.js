// --------------------------------------------------------------------------------------------
//
//	MWM - Multi Web Manager
//	Sous licence Creative common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@multiweb-manager.net
//
// --------------------------------------------------------------------------------------------
var SDFTabRepCourantInitialisation = 0;

function SDFModifieChamp ( FormulaireDemande , ChampAModifier , Val , Div ) {
	document.forms[FormulaireDemande].elements[ChampAModifier].value = Val;
	wpsa[0][cliEnv.browser.support]();
	DisparitionElement ( Div + '_FondNoir');
	DisparitionElement ( Div + '_cadre' );
}

function SDFTabRepCourant ( PointEntree , Racine , CibleHTML ) {
	var ForgeHTML = Racine.elements.TableCorps;
	var IndexStyles = 'StyleA';
	var TrStyle = TdStyle = '';
	var AStyle = ' style="display:block;" '

	if ( SDFTabRepCourantInitialisation == 0 ) {
		Gebi('selecteur_de_fichier_cadre').innerHTML = Racine.elements.TableEntete;
		SDFTabRepCourantInitialisation = 1;
	}

	var ObjF = PointEntree.ls;
	for ( var Elm in ObjF ) {
		var ObjS = Racine.s;
		TrStyle = ' class="'+ObjS[IndexStyles].StyleN+'" onMouseOver="this.className=\''+ObjS[IndexStyles].StyleS+'\';" onMouseOut="this.className=\''+ObjS[IndexStyles].StyleN+'\';" ';
		ForgeHTML += '<tr'+TrStyle+'>';
		switch (ObjF[Elm].score) {
		case '1':	ForgeHTML += '<td class="SdfTdDeco1">		<a '+AStyle+' onClick="SDFModifieChamp(\''+Racine.htmlform.form+'\',\''+Racine.htmlform.champ+'\', \''+ObjF[Elm].r+'\', \'selecteur_de_fichier\' );" class="'+ObjS.classes.lien+'">'	+ObjF[Elm].nom+	'</a>																						</td><td class="SdfTdDeco2">'+ ObjF[Elm].taille +'	</td><td class="SdfTdDeco3">'	+ObjF[Elm].date+	'</td>';	break;
		case '2':	ForgeHTML += '<td class="SdfTdDeco1"><b>	<a '+AStyle+' onClick="SDFTabRepCourant( '+ObjF[Elm].ref+', '+Racine.racine+' ,\''+CibleHTML+'\' );" class="'+ObjS.classes.lien+'">['													+ObjF[Elm].nom+	']</a></b>																					</td><td class="SdfTdDeco2">						</td><td class="SdfTdDeco3">'	+ObjF[Elm].date+	'</td>';	break;
		case '22':
		case '5':	ForgeHTML += '<td class="SdfTdDeco1"><i>'																																															+ObjF[Elm].nom+	'</i> -> <span class="'+ObjS.classes.erreur+'">'		+ ObjF[Elm].cible + '</span>		</td><td class="SdfTdDeco2">						</td><td class="SdfTdDeco3">'	+ObjF[Elm].date+	'</td>';	break;
		case '13':	ForgeHTML += '<td class="SdfTdDeco1">		<a '+AStyle+' onClick="SDFModifieChamp(\''+Racine.htmlform.form+'\',\''+Racine.htmlform.champ+'\', \''+ObjF[Elm].r+'\', \'selecteur_de_fichier\' );" class="'+ObjS.classes.lien+'">'	+ObjF[Elm].nom+	' -> <span class="'+ObjS.classes.ok+'">' 				+ ObjF[Elm].cible + '</span></a>	</td><td class="SdfTdDeco2">						</td><td class="SdfTdDeco3">'	+ObjF[Elm].date+	'</td>';	break;
		case '6':	ForgeHTML += '<td class="SdfTdDeco1"><b><i>['																																														+ObjF[Elm].nom+	']</b></i> -> <span class="'+ObjS.classes.erreur+'">'	+ ObjF[Elm].cible + '</span>		</td><td class="SdfTdDeco2">						</td><td class="SdfTdDeco3">'	+ObjF[Elm].date+	'</td>';	break;
		case '14':	ForgeHTML += '<td class="SdfTdDeco1">		<a '+AStyle+' onClick="SDFTabRepCourant( '+ObjF[Elm].ref+', '+Racine.racine+' ,\''+CibleHTML+'\' );" class="'+ObjS.classes.lien+'"><b>['												+ObjF[Elm].nom+	']</b> -> <span class="'+ObjS.classes.ok+'">' 			+ ObjF[Elm].cible + '</span></a>	</td><td class="SdfTdDeco2">						</td><td class="SdfTdDeco3">'	+ObjF[Elm].date+	'</td>';	break;

		case '18':
		case '30':	ForgeHTML += '<td class="SdfTdDeco1"><b>	<a '+AStyle+' onClick="SDFModifieChamp(\''+Racine.htmlform.form+'\',\''+Racine.htmlform.champ+'\', \''+ObjF[Elm].r+'\', \'selecteur_de_fichier\' );" class="'+ObjS.classes.lien+'">['	+ObjF[Elm].nom+	']</a></b>																					</td><td class="SdfTdDeco2">						</td><td class="SdfTdDeco3">'	+ObjF[Elm].date+	'</td>';	break;

		case '99':	
		if ( ObjF[Elm].n > 0 ) {
			if ( ObjF[Elm].nom == '..' ) { ForgeHTML += '<td class="SdfTdDeco1"><b><a'+AStyle+'onClick="SDFTabRepCourant ( '+ObjF[Elm].p+', '+Racine.racine+' , \''+CibleHTML+'\');">['+ ObjF[Elm].nom +']</a></b></td><td class="SdfTdDeco2"></td><td class="SdfTdDeco3"></td>'; }
			else { ForgeHTML += '<td class="SdfTdDeco1"><b>['+ObjF[Elm].nom+']</b></td><td class="SdfTdDeco2"></td><td class="SdfTdDeco3"></td>'; }
		}
		else { ForgeHTML += '<td class="SdfTdDeco1"><b>['+ObjF[Elm].nom+']</b></td><td class="SdfTdDeco2"></td><td class="SdfTdDeco3"></td>'; }
		break;
		}
		ForgeHTML += '</tr>\r';
		IndexStyles = (IndexStyles == 'StyleA' ? 'StyleB' : 'StyleA');
	}
	Gebi( CibleHTML ).innerHTML = ForgeHTML;
}




