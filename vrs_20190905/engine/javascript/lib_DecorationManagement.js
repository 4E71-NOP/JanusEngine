// --------------------------------------------------------------------------------------------
//
//	MWM - Multi Web Manager
//	Sous licence Creative common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.com
//
// --------------------------------------------------------------------------------------------

//Decoration management functions
class DecorationManagement {
	constructor (){
		this.dbgCalcDeco = 0;
	}
	
	UpdateDecoModule ( Table , ModuleName ) {
		var TIM = Table[ModuleName];
		var T = 0; 
		var Obj = elm.Gebi( ModuleName );
		
		if ( TIM ) {
			if ( !TIM.DimConteneurX ) { 
				TIM.DimConteneurX = Number( Obj.style.width.replace( RegExp ('px', 'g') , '' ));
			}
			if ( !TIM.DimConteneurY ) { 
				TIM.DimConteneurY = Number( Obj.style.height.replace( RegExp ('px', 'g') , '' ));
			}
			l.Log[this.dbgCalcDeco]('UpdateDecoModule processing : ' + Table + '/' + ModuleName);
			l.Log[this.dbgCalcDeco](TIM.module_name + '/' + TIM.deco_type);
		
			switch ( TIM.deco_type ) {
			case 'elegance':
			case 40:
				var ListeDivsGebi = ['ex11', 'ex12', 'ex13', 'ex21', 'ex22', 'ex23', 'ex31', 'ex32', 'ex33'];
				for ( var Div in ListeDivsGebi ) {
					T = TIM[ListeDivsGebi[Div]];
					T.DivObj = elm.Gebi( ModuleName + '_' + ListeDivsGebi[Div] );
					T.DimX = Number(T.DivObj.style.width.replace( RegExp ('px', 'g') , '' ));
					T.DimY = Number(T.DivObj.style.height.replace( RegExp ('px', 'g') , '' ));
					T.PosX = 0;
					T.PosY = 0;
				}
		
				var Col1XMax = Math.max ( Number(TIM.ex11.DimX) , Number(TIM.ex21.DimX) , Number(TIM.ex31.DimX) );
				var Col3XMax = Math.max ( Number(TIM.ex13.DimX) , Number(TIM.ex23.DimX) , Number(TIM.ex33.DimX) );
				var Lig1YMax = Math.max ( Number(TIM.ex11.DimY) , Number(TIM.ex12.DimY) , Number(TIM.ex13.DimY) );
				var Lig3YMax = Math.max ( Number(TIM.ex31.DimY) , Number(TIM.ex32.DimY) , Number(TIM.ex33.DimY) );
		
				TIM.ex22.DimX = TIM.DimConteneurX - Col1XMax - Col3XMax;
				TIM.ex22.DimY = TIM.DimConteneurY - Lig1YMax - Lig3YMax;
				TIM.ex22.PosX = Col1XMax;
				TIM.ex22.PosY = Lig1YMax;
				TIM.ex22.PosX2 = Col1XMax + TIM.ex22.DimX;
				TIM.ex22.PosY2 = Lig1YMax + TIM.ex22.DimY;
		
				TIM.ex12.DimX = TIM.ex22.DimX;
				TIM.ex32.DimX = TIM.ex22.DimX;
		
				TIM.ex21.DimY = TIM.ex22.DimY;
				TIM.ex23.DimY = TIM.ex22.DimY;
		
				TIM.ex11.PosX = TIM.ex22.PosX - TIM.ex11.DimX;		TIM.ex12.PosX = TIM.ex22.PosX;		TIM.ex13.PosX = TIM.ex22.PosX2;
				TIM.ex21.PosX = TIM.ex22.PosX - TIM.ex21.DimX;											TIM.ex23.PosX = TIM.ex22.PosX2;
				TIM.ex31.PosX = TIM.ex22.PosX - TIM.ex31.DimX;		TIM.ex32.PosX = TIM.ex22.PosX;		TIM.ex33.PosX = TIM.ex22.PosX2;
		
				TIM.ex11.PosY = TIM.ex22.PosY - TIM.ex11.DimY;		TIM.ex21.PosY = TIM.ex22.PosY;		TIM.ex31.PosY = TIM.ex22.PosY2;
				TIM.ex12.PosY = TIM.ex22.PosY - TIM.ex12.DimY;											TIM.ex32.PosY = TIM.ex22.PosY2;
				TIM.ex13.PosY = TIM.ex22.PosY - TIM.ex13.DimY;		TIM.ex23.PosY = TIM.ex22.PosY;		TIM.ex33.PosY = TIM.ex22.PosY2;
		
				for ( var Div in ListeDivsGebi ) {
					var Obj = elm.Gebi( ModuleName + '_' + ListeDivsGebi[Div] );
					Obj.style.left = TIM[ListeDivsGebi[Div]].PosX + 'px';
					Obj.style.top = TIM[ListeDivsGebi[Div]].PosY + 'px';
					Obj.style.width = TIM[ListeDivsGebi[Div]].DimX + 'px';
					Obj.style.height = TIM[ListeDivsGebi[Div]].DimY + 'px';
				}
			break;
		
			case 'exquise':
			case 'exquisite':
			case 50:
				var ListeDivsGebi = ['ex11', 'ex12', 'ex13', 'ex14', 'ex15', 'ex21', 'ex22', 'ex25', 'ex31', 'ex35', 'ex41', 'ex45', 'ex51', 'ex52', 'ex53', 'ex54', 'ex55'];
				for ( var Div in ListeDivsGebi ) {
					T = TIM[ListeDivsGebi[Div]];
					T.DivObj = elm.Gebi( ModuleName + '_' + ListeDivsGebi[Div] );
					T.DimX = Number(T.DivObj.style.width.replace( RegExp ('px', 'g') , '' ));
					T.DimY = Number(T.DivObj.style.height.replace( RegExp ('px', 'g') , '' ));
					T.PosX = 0;
					T.PosY = 0;
				}
		
				var Col1XMax = Math.max ( Number(TIM.ex11.DimX) , Number(TIM.ex21.DimX) , Number(TIM.ex31.DimX) , Number(TIM.ex41.DimX) , Number(TIM.ex51.DimX) );
				var Col5XMax = Math.max ( Number(TIM.ex15.DimX) , Number(TIM.ex25.DimX) , Number(TIM.ex35.DimX) , Number(TIM.ex45.DimX) , Number(TIM.ex55.DimX) );
				var Lig1YMax = Math.max ( Number(TIM.ex11.DimY) , Number(TIM.ex12.DimY) , Number(TIM.ex13.DimY) , Number(TIM.ex14.DimY) , Number(TIM.ex15.DimY) );
				var Lig5YMax = Math.max ( Number(TIM.ex51.DimY) , Number(TIM.ex52.DimY) , Number(TIM.ex53.DimY) , Number(TIM.ex54.DimY) , Number(TIM.ex55.DimY) );
		
				TIM.ex22.DimX = TIM.DimConteneurX - Col1XMax - Col5XMax;
				TIM.ex22.DimY = TIM.DimConteneurY - Lig1YMax - Lig5YMax;
				TIM.ex22.PosX = Col1XMax;
				TIM.ex22.PosY = Lig1YMax;
				TIM.ex22.PosX1 = Col1XMax;
				TIM.ex22.PosY1 = Lig1YMax;
				TIM.ex22.PosX2 = Col1XMax + TIM.ex22.DimX;
				TIM.ex22.PosY2 = Lig1YMax;
				TIM.ex22.PosX3 = Col1XMax;
				TIM.ex22.PosY3 = Lig1YMax + TIM.ex22.DimY;
				TIM.ex22.PosX4 = Col1XMax + TIM.ex22.DimX;
				TIM.ex22.PosY4 = Lig1YMax + TIM.ex22.DimY;
		
				TIM.ex13.DimX = TIM.ex22.DimX - TIM.ex12.DimX - TIM.ex14.DimX;
				TIM.ex53.DimX = TIM.ex22.DimX - TIM.ex52.DimX - TIM.ex54.DimX;
				TIM.ex31.DimY = TIM.ex22.DimY - TIM.ex21.DimY - TIM.ex41.DimY;
				TIM.ex35.DimY = TIM.ex22.DimY - TIM.ex25.DimY - TIM.ex45.DimY;
		
				TIM.ex11.PosX = TIM.ex22.PosX1 - TIM.ex11.DimX;		TIM.ex12.PosX = TIM.ex22.PosX1;		TIM.ex13.PosX = TIM.ex22.PosX1 + TIM.ex12.DimX;		TIM.ex14.PosX = TIM.ex22.PosX2 - TIM.ex14.DimX;		TIM.ex15.PosX = TIM.ex22.PosX2;
				TIM.ex21.PosX = TIM.ex22.PosX1 - TIM.ex21.DimX;																																					TIM.ex25.PosX = TIM.ex22.PosX2;
				TIM.ex31.PosX = TIM.ex22.PosX1 - TIM.ex31.DimX;																																					TIM.ex35.PosX = TIM.ex22.PosX2;
				TIM.ex41.PosX = TIM.ex22.PosX1 - TIM.ex41.DimX;																																					TIM.ex45.PosX = TIM.ex22.PosX2;
				TIM.ex51.PosX = TIM.ex22.PosX1 - TIM.ex51.DimX;		TIM.ex52.PosX = TIM.ex22.PosX1;		TIM.ex53.PosX = TIM.ex22.PosX1 + TIM.ex52.DimX;		TIM.ex54.PosX = TIM.ex22.PosX2 - TIM.ex54.DimX;		TIM.ex55.PosX = TIM.ex22.PosX2;
		
				TIM.ex11.PosY = TIM.ex22.PosY1 - TIM.ex11.DimY;		TIM.ex12.PosY = TIM.ex22.PosY1 - TIM.ex12.DimY;		TIM.ex13.PosY = TIM.ex22.PosY1 - TIM.ex13.DimY;		TIM.ex14.PosY = TIM.ex22.PosY2 - TIM.ex14.DimY;		TIM.ex15.PosY = TIM.ex22.PosY2 - TIM.ex15.DimY;
				TIM.ex21.PosY = TIM.ex22.PosY1;																																													TIM.ex25.PosY = TIM.ex22.PosY2;
				TIM.ex31.PosY = TIM.ex22.PosY1 + TIM.ex21.DimY;																																									TIM.ex35.PosY = TIM.ex22.PosY2 + TIM.ex25.DimY;
				TIM.ex41.PosY = TIM.ex22.PosY3 - TIM.ex41.DimY;																																									TIM.ex45.PosY = TIM.ex22.PosY3 - TIM.ex45.DimY;
				TIM.ex51.PosY = TIM.ex22.PosY3;						TIM.ex52.PosY = TIM.ex22.PosY3;						TIM.ex53.PosY = TIM.ex22.PosY3;						TIM.ex54.PosY = TIM.ex22.PosY3;						TIM.ex55.PosY = TIM.ex22.PosY3;
		
				for ( var Div in ListeDivsGebi ) {
					var Obj = elm.Gebi( ModuleName + '_' + ListeDivsGebi[Div] );
					Obj.style.left = TIM[ListeDivsGebi[Div]].PosX + 'px';
					Obj.style.top = TIM[ListeDivsGebi[Div]].PosY + 'px';
					Obj.style.width = TIM[ListeDivsGebi[Div]].DimX + 'px';
					Obj.style.height = TIM[ListeDivsGebi[Div]].DimY + 'px';
				}
			break;
		
			case 'elysion':
			case 60:
				var ListeDivsGebi = [
				'ex11', 'ex12', 'ex13', 'ex14', 'ex15', 'ex21', 'ex22', 'ex25', 'ex31', 'ex35', 'ex41', 'ex45', 'ex51', 'ex52', 'ex53', 'ex54', 'ex55',
				'in11', 'in12', 'in13', 'in14', 'in15', 'in21', 'in25', 'in31', 'in35', 'in41', 'in45', 'in51', 'in52', 'in53', 'in54', 'in55'
				];
				for ( var Div in ListeDivsGebi ) {
					T = TIM[ListeDivsGebi[Div]];
					T.DivObj = elm.Gebi( ModuleName + '_' + ListeDivsGebi[Div] );
					if ( T.DivObj ) {
						T.DimX = Number(T.DivObj.style.width.replace( RegExp ('px', 'g') , '' ));
						T.DimY = Number(T.DivObj.style.height.replace( RegExp ('px', 'g') , '' ));
						l.Log[this.dbgCalcDeco]( ModuleName + '_' + ListeDivsGebi[Div] +' is up! ');
					}
					else {
						l.Log[this.dbgCalcDeco]( ModuleName + '_' + ListeDivsGebi[Div] +' is down! ');
						T.Etat = 0
						T.PosX = 0;
						T.PosY = 0;
					}
				}
		
				var Col1XMax = Math.max ( Number(TIM.ex11.DimX) , Number(TIM.ex21.DimX) , Number(TIM.ex31.DimX) , Number(TIM.ex41.DimX) , Number(TIM.ex51.DimX) );
				var Col5XMax = Math.max ( Number(TIM.ex15.DimX) , Number(TIM.ex25.DimX) , Number(TIM.ex35.DimX) , Number(TIM.ex45.DimX) , Number(TIM.ex55.DimX) );
				var Lig1YMax = Math.max ( Number(TIM.ex11.DimY) , Number(TIM.ex12.DimY) , Number(TIM.ex13.DimY) , Number(TIM.ex14.DimY) , Number(TIM.ex15.DimY) );
				var Lig5YMax = Math.max ( Number(TIM.ex51.DimY) , Number(TIM.ex52.DimY) , Number(TIM.ex53.DimY) , Number(TIM.ex54.DimY) , Number(TIM.ex55.DimY) );
		
				TIM.ex22.DimX = TIM.DimConteneurX - Col1XMax - Col5XMax;
				TIM.ex22.DimY = TIM.DimConteneurY - Lig1YMax - Lig5YMax;
				TIM.ex22.PosX = Col1XMax;
				TIM.ex22.PosY = Lig1YMax;
				TIM.ex22.PosX1 = Col1XMax;
				TIM.ex22.PosY1 = Lig1YMax;
				TIM.ex22.PosX2 = Col1XMax + TIM.ex22.DimX;
				TIM.ex22.PosY2 = Lig1YMax;
				TIM.ex22.PosX3 = Col1XMax;
				TIM.ex22.PosY3 = Lig1YMax + TIM.ex22.DimY;
				TIM.ex22.PosX4 = Col1XMax + TIM.ex22.DimX;
				TIM.ex22.PosY4 = Lig1YMax + TIM.ex22.DimY;
		
				TIM.ex13.DimX = TIM.ex22.DimX - TIM.ex12.DimX - TIM.ex14.DimX;
				TIM.ex53.DimX = TIM.ex22.DimX - TIM.ex52.DimX - TIM.ex54.DimX;
				TIM.ex31.DimY = TIM.ex22.DimY - TIM.ex21.DimY - TIM.ex41.DimY;
				TIM.ex35.DimY = TIM.ex22.DimY - TIM.ex25.DimY - TIM.ex45.DimY;
		
				if ( TIM.in13.Etat == 1 ) { TIM.in13.DimX = TIM.ex22.DimX - TIM.in11.DimX - TIM.in12.DimX - TIM.in14.DimX - TIM.in15.DimX; }
				if ( TIM.in53.Etat == 1 ) { TIM.in53.DimX = TIM.ex22.DimX - TIM.in51.DimX - TIM.in52.DimX - TIM.in54.DimX - TIM.in55.DimX; }
				if ( TIM.in31.Etat == 1 ) { TIM.in31.DimY = TIM.ex22.DimY - TIM.in11.DimY - TIM.in21.DimY - TIM.in41.DimY - TIM.in51.DimY; }
				if ( TIM.in35.Etat == 1 ) { TIM.in35.DimY = TIM.ex22.DimY - TIM.in15.DimY - TIM.in25.DimY - TIM.in45.DimY - TIM.in55.DimY; }
		
		
				TIM.ex11.PosX = TIM.ex22.PosX1 - TIM.ex11.DimX;		TIM.ex12.PosX = TIM.ex22.PosX1;		TIM.ex13.PosX = TIM.ex22.PosX1 + TIM.ex12.DimX;		TIM.ex14.PosX = TIM.ex22.PosX2 - TIM.ex14.DimX;		TIM.ex15.PosX = TIM.ex22.PosX2;
				TIM.ex21.PosX = TIM.ex22.PosX1 - TIM.ex21.DimX;																																					TIM.ex25.PosX = TIM.ex22.PosX2;
				TIM.ex31.PosX = TIM.ex22.PosX1 - TIM.ex31.DimX;																																					TIM.ex35.PosX = TIM.ex22.PosX2;
				TIM.ex41.PosX = TIM.ex22.PosX1 - TIM.ex41.DimX;																																					TIM.ex45.PosX = TIM.ex22.PosX2;
				TIM.ex51.PosX = TIM.ex22.PosX1 - TIM.ex51.DimX;		TIM.ex52.PosX = TIM.ex22.PosX1;		TIM.ex53.PosX = TIM.ex22.PosX1 + TIM.ex52.DimX;		TIM.ex54.PosX = TIM.ex22.PosX2 - TIM.ex54.DimX;		TIM.ex55.PosX = TIM.ex22.PosX2;
		
				TIM.ex11.PosY = TIM.ex22.PosY1 - TIM.ex11.DimY;		TIM.ex12.PosY = TIM.ex22.PosY1 - TIM.ex12.DimY;		TIM.ex13.PosY = TIM.ex22.PosY1 - TIM.ex13.DimY;		TIM.ex14.PosY = TIM.ex22.PosY2 - TIM.ex14.DimY;		TIM.ex15.PosY = TIM.ex22.PosY2 - TIM.ex15.DimY;
				TIM.ex21.PosY = TIM.ex22.PosY1;																																													TIM.ex25.PosY = TIM.ex22.PosY2;
				TIM.ex31.PosY = TIM.ex22.PosY1 + TIM.ex21.DimY;																																									TIM.ex35.PosY = TIM.ex22.PosY2 + TIM.ex25.DimY;
				TIM.ex41.PosY = TIM.ex22.PosY3 - TIM.ex41.DimY;																																									TIM.ex45.PosY = TIM.ex22.PosY3 - TIM.ex45.DimY;
				TIM.ex51.PosY = TIM.ex22.PosY3;						TIM.ex52.PosY = TIM.ex22.PosY3;						TIM.ex53.PosY = TIM.ex22.PosY3;						TIM.ex54.PosY = TIM.ex22.PosY3;						TIM.ex55.PosY = TIM.ex22.PosY3;
		
				if ( TIM.in11.Etat == 1 ) { TIM.in11.PosX = TIM.ex22.PosX1;										TIM.in11.PosY = TIM.ex22.PosY1;										}
				if ( TIM.in12.Etat == 1 ) { TIM.in12.PosX = TIM.ex22.PosX1 + TIM.in11.DimX;						TIM.in12.PosY = TIM.ex22.PosY1;										}
				if ( TIM.in13.Etat == 1 ) { TIM.in13.PosX = TIM.ex22.PosX1 + TIM.in11.DimX + TIM.in12.DimX;		TIM.in13.PosY = TIM.ex22.PosY1;										}
				if ( TIM.in14.Etat == 1 ) { TIM.in14.PosX = TIM.ex22.PosX2 - TIM.ex14.DimX - TIM.ex15.DimX;		TIM.in14.PosY = TIM.ex22.PosY1;										}
				if ( TIM.in15.Etat == 1 ) { TIM.in15.PosX = TIM.ex22.PosX2 - TIM.ex15.DimX;						TIM.in15.PosY = TIM.ex22.PosY1;										}
				if ( TIM.in21.Etat == 1 ) { TIM.in21.PosX = TIM.ex22.PosX1;										TIM.in21.PosY = TIM.ex22.PosY1 + TIM.in11.DimY;						}
				if ( TIM.in25.Etat == 1 ) { TIM.in25.PosX = TIM.ex22.PosX2 - TIM.ex25.DimX;						TIM.in25.PosY = TIM.ex22.PosY1 + TIM.ex15.DimY;						}
				if ( TIM.in31.Etat == 1 ) { TIM.in31.PosX = TIM.ex22.PosX1;										TIM.in31.PosY = TIM.ex22.PosY1 + TIM.in11.DimY + TIM.in21.DimY;		}
				if ( TIM.in35.Etat == 1 ) { TIM.in35.PosX = TIM.ex22.PosX2 - TIM.ex35.DimX;						TIM.in35.PosY = TIM.ex22.PosY1 + TIM.ex15.DimY + TIM.ex25.DimY;		}
				if ( TIM.in41.Etat == 1 ) { TIM.in41.PosX = TIM.ex22.PosX1;										TIM.in41.PosY = TIM.ex22.PosY3 - TIM.in41.DimY - TIM.in51.DimY;		}
				if ( TIM.in45.Etat == 1 ) { TIM.in45.PosX = TIM.ex22.PosX2 - TIM.ex45.DimX;						TIM.in45.PosY = TIM.ex22.PosY3 - TIM.ex45.DimY - TIM.ex55.DimY;		}
				if ( TIM.in51.Etat == 1 ) { TIM.in51.PosX = TIM.ex22.PosX1;										TIM.in51.PosY = TIM.ex22.PosY3 - TIM.in51.DimY;						}
				if ( TIM.in52.Etat == 1 ) { TIM.in52.PosX = TIM.ex22.PosX1 + TIM.in51.DimX;						TIM.in52.PosY = TIM.ex22.PosY3 - TIM.ex52.DimY;						}
				if ( TIM.in53.Etat == 1 ) { TIM.in53.PosX = TIM.ex22.PosX1 + TIM.in51.DimX + TIM.in52.DimX;		TIM.in53.PosY = TIM.ex22.PosY3 - TIM.ex53.DimY;						}
				if ( TIM.in54.Etat == 1 ) { TIM.in54.PosX = TIM.ex22.PosX2 - TIM.ex54.DimX - TIM.ex55.DimX;		TIM.in54.PosY = TIM.ex22.PosY3 - TIM.ex54.DimY;						}
				if ( TIM.in55.Etat == 1 ) { TIM.in55.PosX = TIM.ex22.PosX2 - TIM.ex55.DimX;						TIM.in55.PosY = TIM.ex22.PosY3 - TIM.ex55.DimY;						}
		
				for ( var Div in ListeDivsGebi ) {
					if ( TIM[ListeDivsGebi[Div]].Etat == 1 ) {
					var Obj = elm.Gebi( ModuleName + '_' + ListeDivsGebi[Div] );
						Obj.style.left = TIM[ListeDivsGebi[Div]].PosX + 'px';
						Obj.style.top = TIM[ListeDivsGebi[Div]].PosY + 'px';
						Obj.style.width = TIM[ListeDivsGebi[Div]].DimX + 'px';
						Obj.style.height = TIM[ListeDivsGebi[Div]].DimY + 'px';
					}
				}
			break;
			}
			if  ( this.dbgCalcDeco == 1 ) { console.table(TIM); }
		}
		else { l.Log[this.dbgCalcDeco]('UpdateDecoModule could not process : ' + Table + '/' + ModuleName + '. This table does NOT exists'); }
	}
}

