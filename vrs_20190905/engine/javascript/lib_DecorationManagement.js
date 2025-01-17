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

//Decoration management functions
class DecorationManagement {
	constructor() {
		this.dbgCalcDeco = 0;
		this.decoLogSize = false;
	}

	UpdateAllDecoModule(t) {
		for (let m in t) {
			this.UpdateSingleDecoModule(t[m]);
		}
	}

	UpdateSingleDecoModule(d) {
		// l.Log[this.dbgCalcDeco](d);
		l.Log[this.dbgCalcDeco]("elm c=" + d.main.container);
		var c = elm.Gebi(d.main.container)
		// Executed if initialization is needed
		if (d.main.container != "" & d.main.isInitialized != true) {
			l.Log[this.dbgCalcDeco]("Init module " + d.main.module_name);
			d.main.parent = c.parentElement; // We want the size of the parent which is from the layer xxx.lyt.html file
			// c.style.width = this.getContentWidth(d.main.parent)+"px";
			// c.style.height = this.getContentHeight(d.main.parent)+"px";

			switch (d.main.deco_type) {
				case '1div':
				case 'one_div':
				case 30:
					var dl = ['one_div'];
					break;
				case 'elegance':
				case 40:
					var dl = ['ex11', 'ex12', 'ex13', 'ex21', 'ex22', 'ex23', 'ex31', 'ex32', 'ex33'];
					break;
				case 'exquise':
				case 'exquisite':
				case 50:
					var dl = ['ex11', 'ex12', 'ex13', 'ex14', 'ex15', 'ex21', 'ex22', 'ex25', 'ex31', 'ex35', 'ex41', 'ex45', 'ex51', 'ex52', 'ex53', 'ex54', 'ex55'];
					break;
				case 'elysion':
				case 60:
					var dl = [
						'ex11', 'ex12', 'ex13', 'ex14', 'ex15', 'ex21', 'ex22', 'ex25', 'ex31', 'ex35', 'ex41', 'ex45', 'ex51', 'ex52', 'ex53', 'ex54', 'ex55',
						'in11', 'in12', 'in13', 'in14', 'in15', 'in21', 'in25', 'in31', 'in35', 'in41', 'in45', 'in51', 'in52', 'in53', 'in54', 'in55'
					];
					break;
			}
			for (var Div in dl) {
				if (d[dl[Div]].isEnabled === true) {
					d[dl[Div]].DivObj = elm.Gebi(d.main.module_name + '_' + dl[Div]);
				}
			}
			d.main.isInitialized = true
		}

		// Executed every window.OnResize event
		if (d.main.container != "") {
			d.main.ContainerSizeX = this.getContentWidth(c.parentElement);
			d.main.ContainerSizeY = this.getContentHeight(c.parentElement);
		}

		switch (d.main.deco_type) {
			case '1div':
			case 'one_div':
			case 30:
				this.UpdateDeco30(d);
				break;
			case 'elegance':
			case 40:
				this.UpdateDeco40(d);
				break;
			case 'exquise':
			case 'exquisite':
			case 50:
				this.UpdateDeco50(d);
				break;
			case 'elysion':
			case 60:
				this.UpdateDeco60(d);
				break;
		}
	}

	getContentWidth(elm) {
		var cs = getComputedStyle(elm);
		return (elm.clientWidth - parseFloat(cs.paddingLeft) - parseFloat(cs.paddingRight));
	}
	getContentHeight(elm) {
		var cs = getComputedStyle(elm);
		return (elm.clientHeight - parseFloat(cs.paddingTop) - parseFloat(cs.paddingBottom));
	}

	UpdateDeco30(d) {
		d.one_div.DimX = d.main.ContainerSizeX;
		d.one_div.DimY = d.main.ContainerSizeY;
		d.one_div.PosX = 0;
		d.one_div.PosY = 0;
		d.one_div.PosX2 = d.one_div.DimX - 128;
		d.one_div.PosY2 = d.one_div.DimY - 128;

		let dl = ['one_div'];
		this.setSizeAndPos(d, dl);
	}

	UpdateDeco40(d) {
		let Col1XMax = Math.max(Number(d.ex11.DimX), Number(d.ex21.DimX), Number(d.ex31.DimX));
		let Col3XMax = Math.max(Number(d.ex13.DimX), Number(d.ex23.DimX), Number(d.ex33.DimX));
		let Lin1YMax = Math.max(Number(d.ex11.DimY), Number(d.ex12.DimY), Number(d.ex13.DimY));
		let Lin3YMax = Math.max(Number(d.ex31.DimY), Number(d.ex32.DimY), Number(d.ex33.DimY));

		d.ex22.DimX = d.main.ContainerSizeX - Col1XMax - Col3XMax;
		d.ex22.DimY = d.main.ContainerSizeY - Lin1YMax - Lin3YMax;
		d.ex22.PosX = Col1XMax;
		d.ex22.PosY = Lin1YMax;
		d.ex22.PosX2 = Col1XMax + d.ex22.DimX;
		d.ex22.PosY2 = Lin1YMax + d.ex22.DimY;

		d.ex12.DimX = d.ex22.DimX;
		d.ex32.DimX = d.ex22.DimX;

		d.ex21.DimY = d.ex22.DimY;
		d.ex23.DimY = d.ex22.DimY;

		d.ex11.PosX = d.ex22.PosX - d.ex11.DimX; d.ex12.PosX = d.ex22.PosX; d.ex13.PosX = d.ex22.PosX2;
		d.ex21.PosX = d.ex22.PosX - d.ex21.DimX; d.ex23.PosX = d.ex22.PosX2;
		d.ex31.PosX = d.ex22.PosX - d.ex31.DimX; d.ex32.PosX = d.ex22.PosX; d.ex33.PosX = d.ex22.PosX2;

		d.ex11.PosY = d.ex22.PosY - d.ex11.DimY; d.ex21.PosY = d.ex22.PosY; d.ex31.PosY = d.ex22.PosY2;
		d.ex12.PosY = d.ex22.PosY - d.ex12.DimY; d.ex32.PosY = d.ex22.PosY2;
		d.ex13.PosY = d.ex22.PosY - d.ex13.DimY; d.ex23.PosY = d.ex22.PosY; d.ex33.PosY = d.ex22.PosY2;

		let dl = ['ex11', 'ex12', 'ex13', 'ex21', 'ex22', 'ex23', 'ex31', 'ex32', 'ex33'];
		this.setSizeAndPos(d, dl);
	}

	UpdateDeco50(d) {
		// l.Log[this.dbgCalcDeco]('UpdateDeco50 processing');
		let Col1XMax = Math.max(Number(d.ex11.DimX), Number(d.ex21.DimX), Number(d.ex31.DimX), Number(d.ex41.DimX), Number(d.ex51.DimX));
		let Col5XMax = Math.max(Number(d.ex15.DimX), Number(d.ex25.DimX), Number(d.ex35.DimX), Number(d.ex45.DimX), Number(d.ex55.DimX));
		let Lin1YMax = Math.max(Number(d.ex11.DimY), Number(d.ex12.DimY), Number(d.ex13.DimY), Number(d.ex14.DimY), Number(d.ex15.DimY));
		let Lin5YMax = Math.max(Number(d.ex51.DimY), Number(d.ex52.DimY), Number(d.ex53.DimY), Number(d.ex54.DimY), Number(d.ex55.DimY));

		d.ex22.DimX = d.main.ContainerSizeX - Col1XMax - Col5XMax;
		d.ex22.DimY = d.main.ContainerSizeY - Lin1YMax - Lin5YMax;
		d.ex22.PosX = Col1XMax;
		d.ex22.PosY = Lin1YMax;
		d.ex22.PosX1 = Col1XMax;
		d.ex22.PosY1 = Lin1YMax;
		d.ex22.PosX2 = Col1XMax + d.ex22.DimX;
		d.ex22.PosY2 = Lin1YMax;
		d.ex22.PosX3 = Col1XMax;
		d.ex22.PosY3 = Lin1YMax + d.ex22.DimY;
		d.ex22.PosX4 = Col1XMax + d.ex22.DimX;
		d.ex22.PosY4 = Lin1YMax + d.ex22.DimY;

		d.ex13.DimX = d.ex22.DimX - d.ex12.DimX - d.ex14.DimX;
		d.ex53.DimX = d.ex22.DimX - d.ex52.DimX - d.ex54.DimX;
		d.ex31.DimY = d.ex22.DimY - d.ex21.DimY - d.ex41.DimY;
		d.ex35.DimY = d.ex22.DimY - d.ex25.DimY - d.ex45.DimY;

		d.ex11.PosX = d.ex22.PosX1 - d.ex11.DimX; d.ex12.PosX = d.ex22.PosX1; d.ex13.PosX = d.ex22.PosX1 + d.ex12.DimX; d.ex14.PosX = d.ex22.PosX2 - d.ex14.DimX; d.ex15.PosX = d.ex22.PosX2;
		d.ex21.PosX = d.ex22.PosX1 - d.ex21.DimX; d.ex25.PosX = d.ex22.PosX2;
		d.ex31.PosX = d.ex22.PosX1 - d.ex31.DimX; d.ex35.PosX = d.ex22.PosX2;
		d.ex41.PosX = d.ex22.PosX1 - d.ex41.DimX; d.ex45.PosX = d.ex22.PosX2;
		d.ex51.PosX = d.ex22.PosX1 - d.ex51.DimX; d.ex52.PosX = d.ex22.PosX1; d.ex53.PosX = d.ex22.PosX1 + d.ex52.DimX; d.ex54.PosX = d.ex22.PosX2 - d.ex54.DimX; d.ex55.PosX = d.ex22.PosX2;

		d.ex11.PosY = d.ex22.PosY1 - d.ex11.DimY; d.ex12.PosY = d.ex22.PosY1 - d.ex12.DimY; d.ex13.PosY = d.ex22.PosY1 - d.ex13.DimY; d.ex14.PosY = d.ex22.PosY2 - d.ex14.DimY; d.ex15.PosY = d.ex22.PosY2 - d.ex15.DimY;
		d.ex21.PosY = d.ex22.PosY1; d.ex25.PosY = d.ex22.PosY2;
		d.ex31.PosY = d.ex22.PosY1 + d.ex21.DimY; d.ex35.PosY = d.ex22.PosY2 + d.ex25.DimY;
		d.ex41.PosY = d.ex22.PosY3 - d.ex41.DimY; d.ex45.PosY = d.ex22.PosY3 - d.ex45.DimY;
		d.ex51.PosY = d.ex22.PosY3; d.ex52.PosY = d.ex22.PosY3; d.ex53.PosY = d.ex22.PosY3; d.ex54.PosY = d.ex22.PosY3; d.ex55.PosY = d.ex22.PosY3;

		let dl = ['ex11', 'ex12', 'ex13', 'ex14', 'ex15', 'ex21', 'ex22', 'ex25', 'ex31', 'ex35', 'ex41', 'ex45', 'ex51', 'ex52', 'ex53', 'ex54', 'ex55'];
		this.setSizeAndPos(d, dl);
	}

	UpdateDeco60(d) {
		// l.Log[this.dbgCalcDeco]('UpdateDeco60 processing');
		let Col1XMax = Math.max(Number(d.ex11.DimX), Number(d.ex21.DimX), Number(d.ex31.DimX), Number(d.ex41.DimX), Number(d.ex51.DimX));
		let Col5XMax = Math.max(Number(d.ex15.DimX), Number(d.ex25.DimX), Number(d.ex35.DimX), Number(d.ex45.DimX), Number(d.ex55.DimX));
		let Lin1YMax = Math.max(Number(d.ex11.DimY), Number(d.ex12.DimY), Number(d.ex13.DimY), Number(d.ex14.DimY), Number(d.ex15.DimY));
		let Lin5YMax = Math.max(Number(d.ex51.DimY), Number(d.ex52.DimY), Number(d.ex53.DimY), Number(d.ex54.DimY), Number(d.ex55.DimY));

		d.ex22.DimX = d.main.ContainerSizeX - Col1XMax - Col5XMax;
		d.ex22.DimY = d.main.ContainerSizeY - Lin1YMax - Lin5YMax;
		d.ex22.PosX = Col1XMax;
		d.ex22.PosY = Lin1YMax;
		d.ex22.PosX1 = Col1XMax;
		d.ex22.PosY1 = Lin1YMax;
		d.ex22.PosX2 = Col1XMax + d.ex22.DimX;
		d.ex22.PosY2 = Lin1YMax;
		d.ex22.PosX3 = Col1XMax;
		d.ex22.PosY3 = Lin1YMax + d.ex22.DimY;
		d.ex22.PosX4 = Col1XMax + d.ex22.DimX;
		d.ex22.PosY4 = Lin1YMax + d.ex22.DimY;

		d.ex13.DimX = d.ex22.DimX - d.ex12.DimX - d.ex14.DimX;
		d.ex53.DimX = d.ex22.DimX - d.ex52.DimX - d.ex54.DimX;
		d.ex31.DimY = d.ex22.DimY - d.ex21.DimY - d.ex41.DimY;
		d.ex35.DimY = d.ex22.DimY - d.ex25.DimY - d.ex45.DimY;

		if (d.in13.isEnabled == true) { d.in13.DimX = d.ex22.DimX - d.in11.DimX - d.in12.DimX - d.in14.DimX - d.in15.DimX; }
		if (d.in53.isEnabled == true) { d.in53.DimX = d.in13.DimX; }
		if (d.in31.isEnabled == true) { d.in31.DimY = d.ex22.DimY - d.in11.DimX - d.in21.DimX - d.in41.DimX - d.in51.DimX; }
		if (d.in35.isEnabled == true) { d.in35.DimY = d.in31.DimY; }

		d.ex11.PosX = d.ex22.PosX1 - d.ex11.DimX; d.ex12.PosX = d.ex22.PosX1; d.ex13.PosX = d.ex22.PosX1 + d.ex12.DimX; d.ex14.PosX = d.ex22.PosX2 - d.ex14.DimX; d.ex15.PosX = d.ex22.PosX2;
		d.ex21.PosX = d.ex22.PosX1 - d.ex21.DimX; d.ex25.PosX = d.ex22.PosX2;
		d.ex31.PosX = d.ex22.PosX1 - d.ex31.DimX; d.ex35.PosX = d.ex22.PosX2;
		d.ex41.PosX = d.ex22.PosX1 - d.ex41.DimX; d.ex45.PosX = d.ex22.PosX2;
		d.ex51.PosX = d.ex22.PosX1 - d.ex51.DimX; d.ex52.PosX = d.ex22.PosX1; d.ex53.PosX = d.ex22.PosX1 + d.ex52.DimX; d.ex54.PosX = d.ex22.PosX2 - d.ex54.DimX; d.ex55.PosX = d.ex22.PosX2;

		d.ex11.PosY = d.ex22.PosY1 - d.ex11.DimY; d.ex12.PosY = d.ex22.PosY1 - d.ex12.DimY; d.ex13.PosY = d.ex22.PosY1 - d.ex13.DimY; d.ex14.PosY = d.ex22.PosY2 - d.ex14.DimY; d.ex15.PosY = d.ex22.PosY2 - d.ex15.DimY;
		d.ex21.PosY = d.ex22.PosY1; d.ex25.PosY = d.ex22.PosY2;
		d.ex31.PosY = d.ex22.PosY1 + d.ex21.DimY; d.ex35.PosY = d.ex22.PosY2 + d.ex25.DimY;
		d.ex41.PosY = d.ex22.PosY3 - d.ex41.DimY; d.ex45.PosY = d.ex22.PosY3 - d.ex45.DimY;
		d.ex51.PosY = d.ex22.PosY3; d.ex52.PosY = d.ex22.PosY3; d.ex53.PosY = d.ex22.PosY3; d.ex54.PosY = d.ex22.PosY3; d.ex55.PosY = d.ex22.PosY3;

		if (d.in11.isEnabled == true) { d.in11.PosX = d.ex22.PosX1; d.in11.PosY = d.ex22.PosY1; }
		if (d.in12.isEnabled == true) { d.in12.PosX = d.ex22.PosX1 + d.in11.DimX; d.in12.PosY = d.ex22.PosY1; }
		if (d.in13.isEnabled == true) { d.in13.PosX = d.ex22.PosX1 + d.in11.DimX + d.in12.DimX; d.in13.PosY = d.ex22.PosY1; }

		if (d.in14.isEnabled == true) { d.in14.PosX = d.in13.PosX + d.in13.DimX; d.in14.PosY = d.ex22.PosY1; }
		if (d.in15.isEnabled == true) { d.in15.PosX = d.in13.PosX + d.in13.DimX + d.in14.DimX; d.in15.PosY = d.ex22.PosY1; }
		// if ( d.in14.isEnabled == true ) { d.in14.PosX = d.ex22.PosX2 - d.ex14.DimX - d.ex15.DimX;		d.in14.PosY = d.ex22.PosY1;									}
		// if ( d.in15.isEnabled == true ) { d.in15.PosX = d.ex22.PosX2 - d.ex15.DimX;						d.in15.PosY = d.ex22.PosY1;									}
		if (d.in21.isEnabled == true) { d.in21.PosX = d.ex22.PosX1; d.in21.PosY = d.ex22.PosY1 + d.in11.DimY; }
		if (d.in25.isEnabled == true) { d.in25.PosX = d.ex22.PosX2 - d.ex25.DimX; d.in25.PosY = d.ex22.PosY1 + d.ex15.DimY; }
		if (d.in31.isEnabled == true) { d.in31.PosX = d.ex22.PosX1; d.in31.PosY = d.ex22.PosY1 + d.in11.DimY + d.in21.DimY; }
		if (d.in35.isEnabled == true) { d.in35.PosX = d.ex22.PosX2 - d.ex35.DimX; d.in35.PosY = d.ex22.PosY1 + d.ex15.DimY + d.ex25.DimY; }
		if (d.in41.isEnabled == true) { d.in41.PosX = d.ex22.PosX1; d.in41.PosY = d.ex22.PosY3 - d.in41.DimY - d.in51.DimY; }
		if (d.in45.isEnabled == true) { d.in45.PosX = d.ex22.PosX2 - d.ex45.DimX; d.in45.PosY = d.ex22.PosY3 - d.ex45.DimY - d.ex55.DimY; }
		if (d.in51.isEnabled == true) { d.in51.PosX = d.ex22.PosX1; d.in51.PosY = d.ex22.PosY3 - d.in51.DimY; }
		if (d.in52.isEnabled == true) { d.in52.PosX = d.ex22.PosX1 + d.in51.DimX; d.in52.PosY = d.ex22.PosY3 - d.ex52.DimY; }
		if (d.in53.isEnabled == true) { d.in53.PosX = d.ex22.PosX1 + d.in51.DimX + d.in52.DimX; d.in53.PosY = d.ex22.PosY3 - d.ex53.DimY; }
		if (d.in54.isEnabled == true) { d.in54.PosX = d.ex22.PosX2 - d.ex54.DimX - d.ex55.DimX; d.in54.PosY = d.ex22.PosY3 - d.ex54.DimY; }
		if (d.in55.isEnabled == true) { d.in55.PosX = d.ex22.PosX2 - d.ex55.DimX; d.in55.PosY = d.ex22.PosY3 - d.ex55.DimY; }

		let dl = [
			'ex11', 'ex12', 'ex13', 'ex14', 'ex15', 'ex21', 'ex22', 'ex25', 'ex31', 'ex35', 'ex41', 'ex45', 'ex51', 'ex52', 'ex53', 'ex54', 'ex55',
			'in11', 'in12', 'in13', 'in14', 'in15', 'in21', 'in25', 'in31', 'in35', 'in41', 'in45', 'in51', 'in52', 'in53', 'in54', 'in55'
		];
		// this.decoLogSize = true;
		this.setSizeAndPos(d, dl);
		// this.decoLogSize = false;
	}

	setSizeAndPos(d, dl) {
		// l.Log[this.dbgCalcDeco]('setSizeAndPos processing : ' +  d.main.module_name);
		for (let dv in dl) {
			let dd = d[dl[dv]];
			if (dd.isEnabled === true) {
				let Obj = dd.DivObj.style;
				Obj.width = dd.DimX + 'px';
				Obj.height = dd.DimY + 'px';
				Obj.left = dd.PosX + 'px';
				Obj.top = dd.PosY + 'px';

				// this.decoLogSize = true;
				if (this.decoLogSize === true) {
					l.Log[this.dbgCalcDeco]('setSizeAndPos processing : ' + dd.DivObj.id + "; PosX=" + dd.PosX + 'px' + "; PosY=" + dd.PosX + 'px' + "; DimX=" + dd.DimX + 'px' + "; DimY=" + dd.DimY + 'px; X2=' + (dd.PosX + dd.DimX) + "; Y2=" + (dd.PosY + dd.DimY));
				}
				// this.decoLogSize = false;
			}
		}
	}
}

