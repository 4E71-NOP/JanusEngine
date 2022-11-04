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
		'Debug' : this.dbgToolTip,
		'animLength' : 0.5,			// second
		'animHertz' : 50,			//10x / second
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
		
		var dc = this.cfg.DivExt;
		dc.Anim_Progress		= 0;
		dc.Anim_Current			= 0;
		dc.Anim_CurrentOut		= 0;
		dc.Anim_CurrentIn		= 0;
		dc.style.visibility		= 'visible';
		dc.style.display		= 'none';
		dc.style.zIndex			= 99;
		
		// Avoid 
		if ( typeof TooltipConfig.default == 'undefined' ) {
			TooltipConfig.default = { 'State':1, 'X':'256', 'Y':'128' };
		}
	}
		
	/**
	 * Manage the tootip display
	 */
	ToolTip(msg, profile='default') {
		if ( typeof profile == 'undefined') { profile = 'default'; }
		l.Log[this.dbgToolTip]("Profile is set to "+profile);
		l.Log[this.dbgToolTip]("section='"+profile+"'; msg='" + msg +"'");

		var Obj = elm.Gebi(this.cfg.DivContent);
		var dc = this.cfg.DivExt;

		if ( typeof TooltipConfig[profile] != 'undefined' ) {
			l.Log[this.dbgToolTip](TooltipConfig[profile]);
			TabInfoModule.tooltip.main.DimConteneurX = TooltipConfig[profile].X;
			TabInfoModule.tooltip.main.DimConteneurY = TooltipConfig[profile].Y;
			
			let ttp = TabInfoModule.tooltip.main.parent.style;
			ttp.width	= TooltipConfig[profile].X+'px';
			ttp.height	= TooltipConfig[profile].Y+'px';
			dm.UpdateSingleDecoModule(TabInfoModule.tooltip);
		}

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
	
			var windowX = window.innerWidth + window.scrollX;
			var windowY = window.innerHeight + window.scrollY;
	
			let tt = TabInfoModule.tooltip.main;
			if ( ( c.PosX + c.ShiftX ) > ( windowX - tt.DimConteneurX ) ) { c.PosX = (c.PosX - tt.DimConteneurX - c.ShiftX); }
			else { c.PosX = (c.PosX + c.ShiftX); }
			if ( ( c.PosY + c.ShiftY ) > (windowY - tt.DimConteneurY) ) { c.PosY = (c.PosY - tt.DimConteneurY - c.ShiftY); }
			else { c.PosY = (c.PosY + c.ShiftY) }
	
			let ttp = TabInfoModule.tooltip.main.parent.style;
			ttp.left	= c.PosX+"px";
			ttp.top		= c.PosY+"px";

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
	 * Manage fading animation manually. CSS animation always had some trouble.
	 */
	ManageAnimation (Obj) {
		Obj = elm.Gebi(Obj);
		let ps = Obj.parentNode.style;
		switch (Obj.Anim_Direction) {
		case 0 :
			clearTimeout(Obj.Anim_CurrentIn);
			if ( Obj.Anim_Progress > 0 ) {
				Obj.Anim_Progress		= Obj.Anim_Progress - ( 1/(this.cfg.animLength*this.cfg.animHertz) ); 
				Obj.Anim_CurrentOut 	= setTimeout( 't.ManageAnimation (\''+Obj.id+'\');', (1000/this.cfg.animHertz) );
				this.cfg.DivState		= 1;
				Obj.style.zIndex		= 99;
			}
			else {
				clearTimeout( Obj.Anim_CurrentOut );
				ps.left = '0px';
				ps.top = '0px';
				ps.width = '0px';
				ps.height = '0px';
				ps.zIndex = -1;
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
				Obj.Anim_Progress		= Obj.Anim_Progress + ( 1/(this.cfg.animLength*this.cfg.animHertz) ); 
				Obj.Anim_CurrentIn		= setTimeout( 't.ManageAnimation (\''+Obj.id+'\');', (1000/this.cfg.animHertz) ); 
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
	
			// var str = 'AiDyn :\nShiftX=' + this.cfg.ShiftX + ', ShiftY=' + this.cfg.ShiftY +
			// '\n DivSizeX=' + this.cfg.DivSizeX + ', DivSizeY=' + this.cfg.DivSizeY +
			// '\n FirstTime=' + this.cfg.FirstTime + ', DivState=' + this.cfg.DivState +
			// '\n Souris : Mouse X=' + m.mouseData.PosX + ', Mouse Y=' + m.mouseData.PosY +
			// '\n PosX=' + this.cfg.PosX + ', PosY=' + this.cfg.PosY +
			// '\n de.cliEnv.document.width=' + de.cliEnv.document.width + ', de.cliEnv.document.height=' + de.cliEnv.document.height +
			// '\n Direction=' + Obj.Anim_Direction + ', Progression=' +  Obj.Anim_Progress + 
			// '\n fin';

			var str = 'Direction=' + Obj.Anim_Direction + ', Progression=' +  Obj.Anim_Progress;
			l.Log[this.dbgToolTip](str);
		}
	}
	
	/**
	 * Obviously fadind to transparent.
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

