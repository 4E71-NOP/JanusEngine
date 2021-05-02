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

class Router {
	private static $Instance = null;
	
	private function __construct(){}
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return Router
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new Router();
		}
		return self::$Instance;
	}
	
	/**
	 * Process the necessary assets in order to make the navigation 
	 */
	public function manageNavigation () {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		if ($bts->RequestDataObj->getRequestDataEntry ( 'formSubmitted' ) == 1 ) {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : A form has been submitted"));
			$this->buildDataFromForm();
		}
		else {
			$url = $CurrentSetObj->getInstanceOfServerInfosObj()->getServerInfosEntry('request_uri');
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Analyzing requested URI `".$url."`"));
			if ( $this->isCleanUrl($url) === true ) {
				$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : URL is clean. We consider it's a slug thing."));
				$this->buildDataFromURL($url); 
			}
			else {
				// Neither it is a Form or a Slug thing. We process it as a GET method.
				$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Processing with GET method."));
				$this->processHydrData($url);
			}
		}
	}
	
	/**
	 * Returns true if the URL is 'clean'.
	 * @link https://en.wikipedia.org/wiki/Clean_URL 
	 * @return boolean
	 */
	private function isCleanUrl($url){
		$bts = BaseToolSet::getInstance();
		$match = $this->matchRoute("/^(http[s]?:\/\/)?([\w-]+\.)+([\w]+)([\/\w-]+)(\/?)/", $url);
		if (strlen($match['0']) != strlen($url)) { 
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Requested URI isn't clean. \$match=`".$match['0']."`; \$url=`".$url."`"));
			return false; 
		}
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Requested URI is clean."));
		return true;
	}
	
	/**
	 * Updates the session route if the URL contains defined _HYDRLINKURLTAG_. It will also process 'sw'. 
	 * @param String $url
	 * @return boolean
	 */
	private function processHydrData($url) {
		$bts = BaseToolSet::getInstance();
		
		$match = $this->matchRoute("/(\?|&)"._HYDRLINKURLTAG_."=1/", $url);
// 		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : BP01 \$match['0']=" . $match['0'] . ", strlen=". strlen($match['0'])));
		if (strlen($match['0']) > 0) {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Requested URI contains '"._HYDRLINKURLTAG_."' field data. \$match=`".$match['0']."`. From RequestDataEntry "._HYDRLINKURLTAG_."=".$bts->RequestDataObj->getRequestDataEntry ( _HYDRLINKURLTAG_ )));
			
			$tab = array('target'	=> 'home','page'		=> '1' ,);
			if (strlen ($bts->RequestDataObj->getRequestDataEntry('arti_slug')) > 0 ) { $tab['target'] = $bts->RequestDataObj->getRequestDataEntry('arti_slug'); }
			if (strlen ($bts->RequestDataObj->getRequestDataEntry('arti_page')) > 0 ) { $tab['page'] = $bts->RequestDataObj->getRequestDataEntry('arti_page'); }
			
			$bts->SMObj->backupRoute();
			$bts->SMObj->setSessionEntry('currentRoute', $tab);
			$bts->SMObj->syncSuperGlobalSession();
		}
		
		$match = $this->matchRoute("/(\?|&)sw=[0-9]+/", $url);
		if (strlen($match['0']) > 0) {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Requested URI contains 'sw' field data. \$match=`".$match['0']."`. From RequestDataEntry sw=".$bts->RequestDataObj->getRequestDataEntry ( 'sw' )));
			$bts->SMObj->setSessionEntry('sw', $bts->RequestDataObj->getRequestDataEntry ( 'sw' ));
		}
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : End reached on URL processing"));
	}
	
	
	/**
	 * Uptade session with the relevant data from the URL
	 */
	private function buildDataFromURL ($url) {
		$bts = BaseToolSet::getInstance();
		$match = $this->matchRoute("/^(http[s]?:\/\/)?([\w-]+\.)+([\w]+)\//", $url);
		$str = str_replace($match['0'], "", $url);
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : The slug part looks like this. \$str=`".$str."`."));
		if ( strlen($str) > 0) {
			$expl = explode("/", $str);
			$tab = array(
					'target'	=> (strlen($expl['0'])>0 ? $expl['0'] : ''),		// Safety measure. Probably unecessary. On the list of thing to do later.
					'page'		=> (strlen($expl['1'])>0 ? $expl['1'] : '1' ) ,		// if the slug doesn't have a second string whitch should be the page we go back to page 1 
			);
		}
		else {
			$tab = array('target'	=> 'home', 'page'		=> '1' ,);
		}
		$bts->SMObj->backupRoute();
		$bts->SMObj->setSessionEntry('currentRoute', $tab);
		$bts->SMObj->syncSuperGlobalSession();
	}
	
	/**
	 * Uptade session with the relevant data from the posted form
	 */
	private function buildDataFromForm () {
		// A form asked for a arti_ref. We need to 
		$bts = BaseToolSet::getInstance();
		
		// 2021 03 18 : Form arti_ref (or slug) take precedence on URL slug for now.
		// We still compare both slug and arti_ref. In the end only the slug will be considered
		switch ( true ) {
			case (strlen ( $bts->RequestDataObj->getRequestDataSubEntry ( 'newRoute', 'arti_ref' ) ) > 0 ):
				$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : strlen(arti_ref)>0; arti_ref=`".$bts->RequestDataObj->getRequestDataSubEntry ( 'newRoute', 'arti_ref' )."`."));
				$tab = array(
					'target'	=> $bts->RequestDataObj->getRequestDataSubEntry ( 'newRoute', 'arti_ref' ),
					'page'		=> $bts->RequestDataObj->getRequestDataSubEntry ( 'newRoute', 'arti_page' ),
				);
				break;
			case (strlen ( $bts->RequestDataObj->getRequestDataSubEntry ( 'newRoute', 'arti_slug' ) ) > 0 ):
				$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : strlen(arti_slug)>0; arti_slug=`".$bts->RequestDataObj->getRequestDataSubEntry ( 'newRoute', 'arti_slug' )."`."));
				$tab = array(
					'target'	=> $bts->RequestDataObj->getRequestDataSubEntry ( 'newRoute', 'arti_slug' ),
					'page'		=> $bts->RequestDataObj->getRequestDataSubEntry ( 'newRoute', 'arti_page' ),
				);
				break;
			// A form has been submitted but there is no arti_ref or arti_slug. 
			// It's coming from Quickskin and such who doesn't change navigation.
			// so we take the current route
			default :
				$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Nothing found. We take the last save route =`".$bts->SMObj->getSessionSubEntry('currentRoute', 'target')."`."));
				$tab = array(
					'target'	=> $bts->SMObj->getSessionSubEntry('currentRoute', 'target'),
					'page'		=> $bts->SMObj->getSessionSubEntry('currentRoute', 'page'),
				);
				break;
		}
		
		$bts->SMObj->backupRoute();
		$bts->SMObj->setSessionEntry('currentRoute', $tab);
		$bts->SMObj->syncSuperGlobalSession();
		
	}
	
	/**
	 * Matches with regex. Returns 'match' array.
	 * @param String $regex
	 * @param String $url
	 * @return array
	 */
	private function matchRoute ( $regex , $url ) {
		$bts = BaseToolSet::getInstance();
		$match = array();
		preg_match($regex, $url, $match);
		if (strlen($match['0']) > 0) {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Match found in `".$url."`. \$match=`".$match['0']."`" ));
		}
		return $match;
	}


}