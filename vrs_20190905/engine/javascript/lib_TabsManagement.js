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

// --------------------------------------------------------------------------------------------
//	Tabs management
//
// Mode selection 1 hover 0
var dbgOnglet = 0;

class TabsManagement {
	InitTabs(Table) {
		let te = Table.elements;
		for (let t in te) {
			te[t].down.ida = elm.Gebi(te[t].down.ida)
			te[t].down.idb = elm.Gebi(te[t].down.idb)
			te[t].down.idc = elm.Gebi(te[t].down.idc)
			te[t].up.ida = elm.Gebi(te[t].up.ida)
			te[t].up.idb = elm.Gebi(te[t].up.idb)
			te[t].up.idc = elm.Gebi(te[t].up.idc)
			te[t].hover.ida = elm.Gebi(te[t].hover.ida)
			te[t].hover.idb = elm.Gebi(te[t].hover.idb)
			te[t].hover.idc = elm.Gebi(te[t].hover.idc)
			te[t].sup.idd = elm.Gebi(te[t].sup.idd)
		}
	}

	TabStyleManagement(Mode, EvType, Table, Group, CardName, ChosenTab) {
		l.Log[dbgOnglet](
			'Mode:' + Mode +
			'; EvType:' + EvType +
			'; Group:' + Group +
			'; CardName:' + CardName +
			'; ChosenTab:' + ChosenTab +
			'.'
		);
		let cpt = 1;
		let te = Table.elements;
		let ts = Table.styles;
		for (let t in te) {
			let Score = (Number(Mode) + (Number(te[t].HoverState) * 2) + (Number(te[t].isSelected) * 4) + (Number(EvType) * 16));
			if (cpt == ChosenTab) { Score = Score + 8; }
			switch (Score) {
				case 2:
				case 3:
				case 26:
					te[t].down.ida.className = ts.down.Styla;
					te[t].down.idb.className = ts.down.Stylb;
					te[t].down.idc.className = ts.down.Stylc;
					te[t].HoverState = 0;
					break;
				case 5:
					te[t].down.ida.className = ts.down.Styla;
					te[t].down.idb.className = ts.down.Stylb;
					te[t].down.idc.className = ts.down.Stylc;
					elm.Gebi(Group + '_' + CardName + cpt).style.visibility = 'hidden';
					elm.Gebi(Group + '_' + CardName + cpt).style.display = 'none';
					te[t].isSelected = 0;
					break;
				case 6:
				case 7:
				case 22:
				case 30:
					te[t].HoverState = 0;
					break;
				case 8:
					te[t].up.ida.className = ts.hover.Styla;
					te[t].up.idb.className = ts.hover.Stylb;
					te[t].up.idc.className = ts.hover.Stylc;
					te[t].HoverState = 1;
					break;
				case 9:
				case 11:
					te[t].up.ida.className = ts.up.Styla;
					te[t].up.idb.className = ts.up.Stylb;
					te[t].up.idc.className = ts.up.Stylc;
					elm.Gebi(Group + '_' + CardName + cpt).style.visibility = 'visible';
					elm.Gebi(Group + '_' + CardName + cpt).style.display = 'block';
					te[t].isSelected = 1;
					break;
				case 12:
					te[t].HoverState = 1;
					break;
				default:
					break;
			}
			cpt++;
		}
	}

	TabsResize(Table) {
		let te = Table.elements;
		let h = elm.Gebi(Table.hostDiv);
		let hostSize = Number(h.parentElement.offsetWidth);
		h.style.width = hostSize + 'px';

		let n = Number(Table.tabsNbr);
		let a = Number(Table.size.a);
		let c = Number(Table.size.c);
		let tabFullSize = Math.floor((hostSize / n));
		let b = (tabFullSize - a - c);
		let Compensation = Math.ceil(hostSize - (tabFullSize * n));
		let cpt = 0;
		l.Log[dbgOnglet](
			'hostSize:' + hostSize +
			'; tabFullSize:' + tabFullSize +
			'; tabFullSize*n:' + (tabFullSize * n) +
			'; Table.tabsNbr:' + n +
			'; a:' + a +
			'; b:' + b +
			'; c:' + c +
			'; Compensation:' + Compensation +
			'.'
		);
		for (let t in te) {
			let TabPos = (tabFullSize * cpt);
			if (te[t].down.ida.style) {
				if (cpt == (n - 1)) { b += Compensation; }
				te[t].down.ida.style.left = TabPos + 'px';
				te[t].down.idb.style.left = (TabPos + a) + 'px';
				te[t].down.idb.style.width = b + 'px';
				te[t].down.idc.style.left = (TabPos + a + b) + 'px';
				te[t].sup.idd.style.width = (a + b + c) + 'px';
				te[t].sup.idd.style.left = TabPos + 'px';
				cpt++;
			} else {
				l.Log[dbgOnglet]("Style not found for '" + te[t].cibleDoc + "' (" + (typeof te[t].cibleDoc.typ) + ")");
			}
		}
	}
}	
