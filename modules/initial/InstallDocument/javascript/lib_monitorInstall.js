/*Hydre-licence-debut*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/

class LibMonitorInstall {

	constructor() {
		this.monitorSentinel = null;
		this.monitorXmlhttp = null;
		this.monitorXmlhttpBusyState = false;
		this.dbgMonitorFonction = 0;
		this.intervalDelay = 500

		if (window.XMLHttpRequest) {
			l.Log[this.dbgMonitorFonction]("LibInstall : Modern browser! => window.XMLHttpRequest");
			this.monitorXmlhttp = new XMLHttpRequest();
		}		// IE7+, Firefox, Chrome, Opera, Safari
		else {
			l.Log[this.dbgMonitorFonction]("LibInstall : Crappy browser! => window.XMLHttpRequest");
			this.monitorXmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}		// IE6, IE5

		// The anonymous function scope will **NOT** be from this class. It's a standalone. So no log faiclity, etc.
		this.monitorXmlhttp.onreadystatechange = function () {
			if (mi.monitorXmlhttp.readyState == 4 && mi.monitorXmlhttp.status == 200) {
				var res = JSON.parse(mi.monitorXmlhttp.response);

				// console.log("Installation answered... parsing answer:");
				// console.table(res);

				mi.monitorUpdateReport(res);
			} else {
				// console.log("monitorXmlhttp.onreadystatechange triggered but it's not there yet."
				// 	+ " mi.monitorXmlhttp.readyState = '" + mi.monitorXmlhttp.readyState + "'."
				// 	+ " mi.monitorXmlhttp.status = '" + mi.monitorXmlhttp.status + "' "
				// );
			}
			this.monitorXmlhttpBusyState = false;
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
	startInterval() {
		l.Log[mi.dbgMonitorFonction]("Setting up interval for 'monitorGetReport'");
		this.monitorSentinel = setInterval(this.monitorGetReport, this.intervalDelay);
	}

	/**
	 * monitorGetReport
	 * used as in global scope context
	*/
	monitorGetReport() {
		let str = "";
		// l.Log[mi.dbgMonitorFonction]('monitorGetReport Monitor URL=: `' + mi.monitorURL + "`");
		if (!this.monitorXmlhttpBusyState) {
			str = "Calling..."
			this.monitorXmlhttpBusyState = true;
			mi.monitorXmlhttp.timeout = this.intervalDelay;
			mi.monitorXmlhttp.open("GET", mi.monitorURL, true);
			mi.monitorXmlhttp.send();
		} else {
			str = "monitorXmlhttpBusyState is true";
		}
		l.Log[mi.dbgMonitorFonction]("monitorGetReport heartbeat : " + str);
	}

	/**
	 * monitorUpdateReport
	 * @param {*} data 
	 */
	monitorUpdateReport(data) {
		if (data.mainAnswer == 'report') {
			let listMonitorField = {
				1: { 'name': "SQL_query_count", 'type': 'text' },
				2: { 'name': "command_count", 'type': 'text' },
				3: { 'name': "start_date", 'type': 'date' },
				4: { 'name': "end_date", 'type': 'date' },
			};

			if (data.mainAnswer != 'noDataAvailable') {
				elm.Gebi('monitorStatusPending').style.visibility = 'hidden';
				elm.Gebi('monitorStatusPending').style.display = 'none';
				elm.Gebi('monitorStatusRunning').style.visibility = 'visible';
				elm.Gebi('monitorStatusRunning').style.display = 'block';
			}

			if (data.last_activity != 0) {
				var last_activity = new Date(data.last_activity * 1000);
				var thisMoment = Date.now()
				var activityCheck = (thisMoment - last_activity);
				l.Log[this.dbgMonitorFonction]('last_activity=' + last_activity + ";  thisMoment=" + thisMoment + "; activityCheck=" + activityCheck);
				if (activityCheck > 30000) {
					elm.Gebi('monitorInactive').style.visibility = 'visible';
					elm.Gebi('monitorInactive').style.display = 'block';
					elm.Gebi('monitorInactiveTime').innerHTML = (activityCheck / 1000) + 's';
					elm.Gebi('monitorInactiveTime').style.visibility = 'visible';
					elm.Gebi('monitorInactiveTime').style.display = 'block';
				}
			}

			var str = "";
			for (let ptr in listMonitorField) {
				l.Log[this.dbgMonitorFonction]('Processing monitor_' + listMonitorField[ptr].name);
				str = data[listMonitorField[ptr].name];
				if (listMonitorField[ptr].type == 'date' && str != 0) {
					var date = new Date(str * 1000);
					str = date.toLocaleDateString() + " " + date.toLocaleTimeString();
				}
				elm.Gebi('monitor_' + listMonitorField[ptr].name).innerHTML = str;
			}
		}

		if (data.installationFinished == 1) {
			elm.Gebi('installStateEnded').style.visibility = 'visible';
			elm.Gebi('installStateEnded').style.display = 'block';

			elm.Gebi('installDuration').innerHTML = (data.end_date - data.start_date) + "s";
			elm.Gebi('installDuration').style.visibility = 'visible';
			elm.Gebi('installDuration').style.display = 'block';

			elm.Gebi('btnInstallReport').style.visibility = 'visible';


			l.Log[this.dbgMonitorFonction]('installation finished => clearInterval');
			clearInterval(this.monitorSentinel);
		}
		l.Log[this.dbgMonitorFonction]('data.mainAnswer=' + data.mainAnswer);
	}

	/**
	 * monitorToggleDisplay
	 */
	monitorToggleDisplay() {
		l.Log[this.dbgMonitorFonction]('monitorToggleDisplay has been called');
		elm.Gebi('layout_monitor').style.display = 'block';
		elm.Gebi('layout_monitor').style.visibility = 'visible';
		dm.UpdateAllDecoModule(TabInfoModule);
	}





}