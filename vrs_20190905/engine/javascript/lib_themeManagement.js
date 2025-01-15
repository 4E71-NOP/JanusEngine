// --------------------------------------------------------------------------------------------
//
//	JnsEng - Janus Engine
//	Sous licence Creative common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.com
//
// --------------------------------------------------------------------------------------------
// Theme managment

function gradientUpdate(Groupe, ColDeb, ColMil, ColFin, NbrCellules) {
	var tab = {}

	tab.RedStart = sf.H2d(ColDeb[0] + ColDeb[1]);
	tab.GreenStart = sf.H2d(ColDeb[2] + ColDeb[3]);
	tab.BlueStart = sf.H2d(ColDeb[4] + ColDeb[5]);

	tab.RedMiddle = sf.H2d(ColMil[0] + ColMil[1]);
	tab.GreenMiddle = sf.H2d(ColMil[2] + ColMil[3]);
	tab.BlueMiddle = sf.H2d(ColMil[4] + ColMil[5]);

	tab.RedEnd = sf.H2d(ColFin[0] + ColFin[1]);
	tab.GreenEnd = sf.H2d(ColFin[2] + ColFin[3]);
	tab.BlueEnd = sf.H2d(ColFin[4] + ColFin[5]);

	for (valtab in tab) { if (isNaN(tab[valtab])) { tab[valtab] = '00'; } }

	var RedCoefA = (tab.RedMiddle - tab.RedStart) / (Math.floor(NbrCellules / 2));
	var GreenCoefA = (tab.GreenMiddle - tab.GreenStart) / (Math.floor(NbrCellules / 2));
	var BlueCoefA = (tab.BlueMiddle - tab.BlueStart) / (Math.floor(NbrCellules / 2));

	var RedCoefB = (tab.RedEnd - tab.RedMiddle) / (Math.floor(NbrCellules / 2));
	var GreenCoefB = (tab.GreenEnd - tab.GreenMiddle) / (Math.floor(NbrCellules / 2));
	var BlueCoefB = (tab.BlueEnd - tab.BlueMiddle) / (Math.floor(NbrCellules / 2));

	var Dividx = 1;
	for (var x = 1; x <= Math.floor(NbrCellules / 2); x++) {
		var RedX = tab.RedStart + (RedCoefA * x);
		var GreenX = tab.GreenStart + (GreenCoefA * x);
		var BlueX = tab.BlueStart + (BlueCoefA * x);
		elm.Gebi(Groupe + Dividx).style.backgroundColor = '#' + sf.D2h(parseInt(RedX)) + sf.D2h(parseInt(GreenX)) + sf.D2h(parseInt(BlueX));
		Dividx++;
	}

	for (var x = 1; x <= Math.floor(NbrCellules / 2); x++) {
		var RedX = tab.RedMiddle + (RedCoefB * x);
		var GreenX = tab.GreenMiddle + (GreenCoefB * x);
		var BlueX = tab.BlueMiddle + (BlueCoefB * x);
		elm.Gebi(Groupe + Dividx).style.backgroundColor = '#' + sf.D2h(parseInt(RedX)) + sf.D2h(parseInt(GreenX)) + sf.D2h(parseInt(BlueX));
		Dividx++;
	}
}

function ThemeGradientMgmt() {
	var Deb = document.themeForm.TM_gradient_color_start.value.replace('#', '');
	var Mil = document.themeForm.TM_gradient_color_middle.value.replace('#', '');
	var Fin = document.themeForm.TM_gradient_color_end.value.replace('#', '');
	gradientUpdate('gfx_gradient_', Deb, Mil, Fin, 30);
}

