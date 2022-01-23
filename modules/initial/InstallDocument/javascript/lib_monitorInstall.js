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

class LibMonitorInstall {
	
	constructor () { 
		this.dbgMonitorFonction = 0;
		if ( window.XMLHttpRequest ) { 
			l.Log[this.dbgMonitorFonction]( "LibInstall : Modern browser! => window.XMLHttpRequest");
			this.monitorXmlhttp = new XMLHttpRequest(); 
		}		// IE7+, Firefox, Chrome, Opera, Safari
		else { 
			l.Log[this.dbgMonitorFonction]( "LibInstall : Crappy browser! => window.XMLHttpRequest");
			this.monitorXmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); 
		}		// IE6, IE5

		// The anonymous function scope will **NOT** be from this class. It's a standalone.
		this.monitorXmlhttp.onreadystatechange = function () {
			if ( mi.monitorXmlhttp.readyState == 4 && mi.monitorXmlhttp.status == 200 ) {
				var res = JSON.parse(mi.monitorXmlhttp.response);
				mi.monitorUpdateReport(res);
			}
		}
	}

	/**
	 * 
	 * @param {*} data 
	 */
	setUrl(data) {
		this.monitorURL = data;
	}

	/**
	 * startInterval
	 */
	startInterval(){
		l.Log[mi.dbgMonitorFonction]( 'monitorGetReport Monitor URL=: `' +mi.monitorURL+"`" );
		this.monitorSentinel = setInterval(this.monitorGetReport, 1000 );
	}

	/**
	 * monitorGetReport
	 * used as in global scope context
	 */
	monitorGetReport(){
		mi.monitorXmlhttp.open( "GET" , mi.monitorURL , true );
		mi.monitorXmlhttp.send();
	}

	/**
	 * monitorUpdateReport
	 * @param {*} data 
	 */
	monitorUpdateReport(data){
		if ( data.mainAnswer == 'report') {
			let listMonitorField = {
				1: { 'name':"SQL_query_count",	'type':'text'},
				2: { 'name':"command_count",	'type':'text'},
				3: { 'name':"start_date",		'type':'date'},
				4: { 'name':"end_date",			'type':'date'},
			};
			
			if ( data.mainAnswer != 'noDataAvailable' ) {
				elm.Gebi('monitorStatusPending').style.visibility = 'hidden';
				elm.Gebi('monitorStatusPending').style.display = 'none';
				elm.Gebi('monitorStatusRunning').style.visibility = 'visible';
				elm.Gebi('monitorStatusRunning').style.display = 'block';
			}
			
			if (  data.last_activity != 0 ) {
				var last_activity = new Date( data.last_activity * 1000 );
				var thisMoment = Date.now()
				var activityCheck = (thisMoment - last_activity);
				l.Log[this.dbgMonitorFonction]('last_activity='+last_activity+";  thisMoment="+thisMoment+"; activityCheck="+activityCheck );
				if ( activityCheck > 30000 ) {
					elm.Gebi('monitorInactive').style.visibility = 'visible';
					elm.Gebi('monitorInactive').style.display = 'block';
					elm.Gebi('monitorInactiveTime').innerHTML = (activityCheck/1000) + 's';
					elm.Gebi('monitorInactiveTime').style.visibility = 'visible';
					elm.Gebi('monitorInactiveTime').style.display = 'block';
				}
			}

			var str ="";
			for ( let ptr in listMonitorField ) {
				l.Log[this.dbgMonitorFonction]('Processing monitor_'+listMonitorField[ptr].name);
				str = data[listMonitorField[ptr].name];
				if ( listMonitorField[ptr].type == 'date' && str != 0) {
					var date = new Date(str * 1000);
					str = date.toLocaleDateString() + " " + date.toLocaleTimeString();
				}
				elm.Gebi('monitor_'+listMonitorField[ptr].name).innerHTML = str;
			}
		}
		
		if (data.installationFinished == 1 ) {
			elm.Gebi('installStateEnded').style.visibility = 'visible';
			elm.Gebi('installStateEnded').style.display = 'block';

			elm.Gebi('installDuration').innerHTML = (data.end_date - data.start_date)+"s";
			elm.Gebi('installDuration').style.visibility = 'visible';
			elm.Gebi('installDuration').style.display = 'block';

			l.Log[this.dbgMonitorFonction]('installation finished => clearInterval');
			clearInterval(this.monitorSentinel);
		}
		l.Log[this.dbgMonitorFonction]('data.mainAnswer='+data.mainAnswer);
	}

	/**
	 * monitorToggleDisplay
	 */
	 monitorToggleDisplay(){
		elm.Gebi('layout_monitor').style.display = 'block';
		elm.Gebi('layout_monitor').style.visibility = 'visible';
		dm.UpdateAllDecoModule(TabInfoModule);
	}





}