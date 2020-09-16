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
class ToolTip {
	constructor() {
		this.dbgToolTip = 0;

		this.cfg = {
		'ShiftX' : 16, 'ShiftY' : 4,
		'DivExt' : '', 
		'DivContent' : '',
		'DivSizeX' : 0, 'DivSizeY' : 0,
		'FirstTime' : 1, 'DivState' : 0,
		'PosX' : 0, 'PosY' : 0,
		'Debug' : this.dbgToolTip
		};
	}
	
	
	/**
	 * Initialize the tooltip
	 */
	InitToolTip (CalqueExt, CalqueCont, cdX, cdY) {
		this.cfg.DivContent	= CalqueCont;
		this.cfg.DivExt		= elm.Gebi(CalqueExt);
		this.cfg.DivSizeX	= cdX;
		this.cfg.DivSizeY	= cdY;
		
// 		this.cfg.DivExt = elm.Gebi(CalqueExt);
		// dc = Div Container
		var dc = this.cfg.DivExt;
		dc.Anim_Progress		= 0;
		dc.Anim_Current			= 0;
		dc.Anim_CurrentOut		= 0;
		dc.Anim_CurrentIn		= 0;
		dc.style.visibility		= 'visible';
		dc.style.display		= 'none';
		dc.style.zIndex			= 99;
		
		if ( typeof TooltipByPass != 'undefined' ) {
			TabInfoModule.tooltip.DimConteneurX = TooltipByPass.X;
			TabInfoModule.tooltip.DimConteneurY = TooltipByPass.Y;
			this.cfg.DivSizeX = TooltipByPass.X
			this.cfg.DivSizeY = TooltipByPass.Y;
			dm.UpdateDecoModule (TabInfoModule, 'tooltip');
		}
	}
	
	
	/**
	 * Manage the tootip
	 */
	ToolTip(msg) {
		var str = "msg='" + msg +"'";
		l.Log[this.dbgToolTip](str);

		var Obj = elm.Gebi(this.cfg.DivContent);
		var dc = this.cfg.DivExt;
		if (this.cfg.FirstTime == 1) {
			switch (de.cliEnv.browser.agent) {
				case 'Firefox':			while (Obj.childNodes.length >= 1){ Obj.removeChild(Obj.firstChild); }		break;
			}
			this.cfg.FirstTime = 0;
		}
		if (!msg) {
			this.cfg.DivState = 0;
			dc.Anim_Direction = 0;
			if (dc.Anim_Current == 0) {
				dc.Anim_Current	= 1;
				this.ManageAnimation (dc.id);
			}
		}
		else {
//			if (this.cfg.DivState == 0) { 
				this.cfg.DivState = 1;
				dc.Anim_Direction = 1;
				switch (de.cliEnv.browser.support) {
				case 'MSIE7': if (!e) { var e = window.event; }		Obj.innerHTML = msg;	break;
				case 'DOM': Obj.innerHTML = msg; 											break;
				}
				if (dc.Anim_Current == 0) {
					dc.Anim_Current	= 1;
					this.ManageAnimation (dc.id);
				}
//			}
		}
	}
	
	
	/**
	 * Move the tooltip div.
	 * Is called by the MouseManagement class.
	 */
	MouseEvent(e) {
		var c = this.cfg;
		if ( c.DivState == 1 ) { 
			c.PosX = m.mouseData.PosX;
			c.PosY = m.mouseData.PosY;
	
			var windowX = de.cliEnv.document.width + window.scrollX;
			var windowY = de.cliEnv.document.height + window.scrollY;
	
			if ( ( c.PosX + c.ShiftX ) > ( windowX - c.DivSizeX ) ) { c.PosX = c.PosX - c.DivSizeX - c.ShiftX - elm.DivInitial.px; }
			else { c.PosX = c.PosX + c.ShiftX - elm.DivInitial.px; }
			if ( ( c.PosY + c.ShiftY ) > ( windowY - c.DivSizeY ) ) { c.PosY = c.PosY - c.DivSizeY - c.ShiftY; }
			else { c.PosY = c.PosY + c.ShiftY }
	
			c.DivExt.style.left = c.PosX + 'px';
			c.DivExt.style.top  = c.PosY + 'px';
			l.Log[this.dbgToolTip](
					"windowX=" + windowX + 
					"; windowY=" + windowY + 
					"; window.scrollX=" + window.scrollX +
					"; window.scrollY=" + window.scrollY +
					"; c.PosX=" + c.PosX + 
					"; c.PosY=" + c.PosY );
		}
	}
	
	
	/**
	 * 
	 */
	ManageAnimation (Obj) {
		Obj = elm.Gebi(Obj);
		switch (Obj.Anim_Direction) {
		case 0 :
			clearTimeout(Obj.Anim_CurrentIn);
			if ( Obj.Anim_Progress > 0 ) {
				Obj.Anim_Progress		= Obj.Anim_Progress - ( 1 / 30 ); 
				Obj.Anim_CurrentOut 	= setTimeout( 't.ManageAnimation (\''+Obj.id+'\');', (15) );
				this.cfg.DivState		= 1;
				Obj.style.zIndex		= 99;
			}
			else {
				clearTimeout( Obj.Anim_CurrentOut );	
				Obj.style.visibility	= 'hidden';
				Obj.style.display		= 'none';
				Obj.Anim_Progress 		= 0;
				Obj.Anim_Current 		= 0;
				this.cfg.DivState 		= 0;
				Obj.style.zIndex		= 0;
	
			}
		break;
		case 1 :
			clearTimeout( Obj.Anim_CurrentOut );	
			if ( Obj.Anim_Progress < 1 ) { 
				Obj.Anim_Progress		= Obj.Anim_Progress + ( 1 / 30 ); 
				Obj.Anim_CurrentIn		= setTimeout( 't.ManageAnimation (\''+Obj.id+'\');', (15) ); 
				this.cfg.DivState		= 1;
				Obj.style.zIndex		= 99;
			}		
			else {
				clearTimeout( Obj.Anim_CurrentIn );
				Obj.style.visibility	= 'visible';
				Obj.style.display		= 'block';
				Obj.Anim_Progress		= 1;
				Obj.Anim_Current		= 0;
				this.cfg.DivState		= 1;
			}
		break;
		}
		if ( Obj.Anim_Direction != 0 || Obj.Anim_Direction != 1 )  {
			this.FadeTransparent (Obj.id);
			this.MouseEvent();		//Move the div.
	
//			var str = 'AiDyn :\nShiftX=' + this.cfg.ShiftX + ', ShiftY=' + this.cfg.ShiftY +
//			'\n DivSizeX=' + this.cfg.DivSizeX + ', DivSizeY=' + this.cfg.DivSizeY +
//			'\n FirstTime=' + this.cfg.FirstTime + ', DivState=' + this.cfg.DivState +
//			'\n Souris : Mouse X=' + m.mouseData.PosX + ', Mouse Y=' + m.mouseData.PosY +
//			'\n PosX=' + this.cfg.PosX + ', PosY=' + this.cfg.PosY +
//			'\n de.cliEnv.document.width=' + de.cliEnv.document.width + ', de.cliEnv.document.height=' + de.cliEnv.document.height +
//			'\n initial_div px=' + elm.DivInitial.px + ' py=' + elm.DivInitial.py + ' dx=' + elm.DivInitial.dx + ' dy=' + elm.DivInitial.dy + ' cx=' + elm.DivInitial.cx + ' cy=' + elm.DivInitial.cy + 
//			'\n Direction=' + Obj.Anim_Direction + ', Progression=' +  Obj.Anim_Progress + 
//			'\n fin';

			var str = 'Direction=' + Obj.Anim_Direction + ', Progression=' +  Obj.Anim_Progress;
			l.Log[this.dbgToolTip](str);
		}
	}
	
	/**
	 * 
	 */
	FadeTransparent (Obj) {
		Obj = elm.Gebi(Obj);
		var ProgressionSin = Math.sin(Math.PI * Obj.Anim_Progress / 2 );
		var a = ( Obj.Anim_Direction * 2 );
		if ( de.cliEnv.browser.support == 'MSIE7' ) { a = a + 1 }
		switch (a) {
		case 0 :	Obj.style.opacity =  Obj.style.MozOpacity = ProgressionSin;					break;
		case 1 :	Obj.style.filter = 'alpha(opacity=' + (ProgressionSin * 100) + ')';			break;
		case 2 :	Obj.style.opacity =  Obj.style.MozOpacity = ProgressionSin;					break;
		case 3 :	Obj.style.filter = 'alpha(opacity=' + ( ProgressionSin * 100 ) + ')';		break;
		}
		Obj.style.visibility 	= 'visible';		
		Obj.style.display 		= 'block';
	}
}

