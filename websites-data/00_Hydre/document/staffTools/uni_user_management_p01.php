<?php
/*Hydre-licence-begin*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	licence Creative Common licence, CC-by-nc-sa (http://creativecommons.org)
//	Author : Faust MARIA DE AREVALO, mailto:faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/

/*Hydre-IDE-begin*/
// Some definitions in order to ease the IDE work and to provide information about what is already available in this context.
/* @var $bts BaseToolSet                            */
/* @var $CurrentSetObj CurrentSet                   */
/* @var $ClassLoaderObj ClassLoader                 */

/* @var $SqlTableListObj SqlTableList               */
/* @var $UserObj User                               */
/* @var $WebSiteObj WebSite                         */
/* @var $DocumentDataObj DocumentData               */
/* @var $ThemeDataObj ThemeData                     */

/* @var $Content String                             */
/* @var $Block String                               */
/* @var $infos Array                                */
/* @var $l String                                   */
/*Hydre-IDE-end*/

// $LOG_TARGET = $LMObj->getInternalLogTarget();
// $LMObj->setInternalLogTarget("both");

$bts->RequestDataObj->setRequestData('filterForm',
	array(
		'user_status'			=> 1,
		'nbrPerPage'			=> 100,
		'group_id'				=> 0,
	),
);

/*Hydr-Content-Begin*/
$localisation = " / uni_user_management_p01";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_user_management_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_user_management_p01.php");

switch ($l) {
	case "fra":
		$bts->I18nTransObj->apply(array(
		"invite1"		=> "Cette partie va vous permettre de gérer les utilisateur.",
		"col_1_txt"		=> "Id",
		"col_2_txt"		=> "Login",
		"col_3_txt"		=> "Nom",
		"col_4_txt"		=> "Groupe",
		"col_5_txt"		=> "Statut",
		"col_6_txt"		=> "Dernière visite",
		"tabTxt1"		=> "Informations",
		"select1_0"		=> "No groupe",
		"select1_1"		=> "Aucun groupe",
		
		"status0"		=> "Désactivé",
		"status1"		=> "Actif",
		"status2"		=> "Suppprimé",

		"table1_1"		=> "Chercher le login contenant",
		"table1_2"		=> "Du groupe",
		"table1_3"		=> "Statut",
		"table1_41"		=> "Affichage",
		"table1_42"		=> "entrées par pages.",
		"select1_0"		=> "Aucun groupe",
		"select2_0"		=> "Inactif",
		"select2_1"		=> "Actif",
		"select2_2"		=> "Supprimé",
		));
		break;
	case "eng":
		$bts->I18nTransObj->apply(array(
		"invite1"		=> "This part will allow you to manage users.",
		"col_1_txt"		=> "Id",
		"col_2_txt"		=> "Login",
		"col_3_txt"		=> "Name",
		"col_4_txt"		=> "In group",
		"col_5_txt"		=> "Status",
		"col_6_txt"		=> "Last visit",
		"tabTxt1"		=> "Informations",
		"select1_0"		=> "No group",
		"select1_1"		=> "Aucun group",
		
		"status0"		=> "Disabled",
		"status1"		=> "Active",
		"status2"		=> "Deleted",

		"table1_1"		=> "Find login containing",
		"table1_2"		=> "From group",
		"table1_3"		=> "User status",
		"table1_41"		=> "Display",
		"table1_42"		=> "entry per pages.",
		"select1_0"		=> "No group",
		"select2_0"		=> "Disabled",
		"select2_1"		=> "Active",
		"select2_2"		=> "Deleted",
		));
		break;
}
$Content .= $bts->I18nTransObj->getI18nTransEntry('invite1')."<br>\r<br>\r";

// --------------------------------------------------------------------------------------------
$GDU_ = array();

$GDU_['nbr_par_page'] = $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'nbrPerPage');
if ($GDU_['nbr_par_page'] < 1 ) { $GDU_['nbr_par_page'] = 10;}
if ( $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'group_id') == 0 ) { $bts->RequestDataObj->setRequestDataSubEntry('filterForm', 'group_id', null); }

$clause_sql_element = array();
$clause_sql_element['1'] = "WHERE";
$clause_sql_element['2'] = $clause_sql_element['3'] = $clause_sql_element['4'] = $clause_sql_element['5'] = $clause_sql_element['6'] = $clause_sql_element['7'] = $clause_sql_element['8'] = $clause_sql_element['9'] = $clause_sql_element['10'] = "AND";

$clause_sql_element_offset = 1;
$GDU_['clause_like'] = "";
if ( strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like'))>0 )																				{ $GDU_['clause_like'] .= " ".	$clause_sql_element[$clause_sql_element_offset]." usr.user_login LIKE '%" . $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like') . "%' ";	$clause_sql_element_offset++; }
if ( strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'group_id'))>0 && $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'group_id') != 0 )	{ $GDU_['clause_like'] .= " ".	$clause_sql_element[$clause_sql_element_offset]." gr.group_id = '".$bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'group_id')."' ";					$clause_sql_element_offset++; }
if ( strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'user_status'))>0 )																				{ $GDU_['clause_like'] .= " ".	$clause_sql_element[$clause_sql_element_offset]." usr.user_status = '".$bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'user_status')."' ";			$clause_sql_element_offset++; }
$GDU_['clause_like'] .= " ".$clause_sql_element[$clause_sql_element_offset]." gr.group_tag != '0' ";										$clause_sql_element_offset++;
$GDU_['clause_like'] .= " ".$clause_sql_element[$clause_sql_element_offset]." gu.group_user_initial_group = '1' ";							$clause_sql_element_offset++;
$GDU_['clause_like'] .= " ".$clause_sql_element[$clause_sql_element_offset]." sg.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' ";		$clause_sql_element_offset++;
$GDU_['clause_like'] .= " ".$clause_sql_element[$clause_sql_element_offset]." gu.user_id = usr.user_id";									$clause_sql_element_offset++;
$GDU_['clause_like'] .= " ".$clause_sql_element[$clause_sql_element_offset]." sg.group_id = gu.group_id ";									$clause_sql_element_offset++;
$GDU_['clause_like'] .= " ".$clause_sql_element[$clause_sql_element_offset]." gu.group_id = gr.group_id ";									$clause_sql_element_offset++;
$GDU_['clause_like'] .= " ".$clause_sql_element[$clause_sql_element_offset]." usr.user_name != 'HydreBDD'";									$clause_sql_element_offset++;

$dbquery = $bts->SDDMObj->query("
SELECT COUNT(usr.user_id) AS mucount 
FROM ".$SqlTableListObj->getSQLTableName('user')." usr, ".$SqlTableListObj->getSQLTableName('group')." gr, ".$SqlTableListObj->getSQLTableName('group_user')." gu, ".$SqlTableListObj->getSQLTableName('group_website')." sg 
".$GDU_['clause_like'].";");
while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) { $GDU_['login_count'] = $dbp['mucount']; }

// --------------------------------------------------------------------------------------------
if ( $GDU_['login_count'] > $GDU_['nbr_par_page'] ) {
	$GDU_['selection_page'] = "<p style='text-align: center;'>\r --\r";
	$GDU_['nbr_page']  = $GDU_['login_count'] / $GDU_['nbr_par_page'] ;
	$GDU_['reste'] = $GDU_['login_count'] % $GDU_['nbr_par_page'];
	if ( $GDU_['reste'] != 0 ) { $GDU_['nbr_page']++;}
	$GDU_['compteur_page'] = 0;
	for ( $i = 1 ; $i <= $GDU_['nbr_page'] ; $i++) {
		if ( $_REQUEST['M_UTILIS_page'] != $GDU_['compteur_page'] ) {
			$GDU_['selection_page'] .= "
			<a class='" . $Block."_lien' style='display: inline;' href='index.php?
M_UTILIS_page=".$GDU_['compteur_page']."
&amp;nbrPerPage=".$GDU_['nbr_par_page']."
&amp;M_UTILIS_query_like=".$bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like')."
&amp;M_UTILIS_group_id=".$bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'group_id')."
&amp;arti_page=1
".$CurrentSetObj->getDataSubEntry('block_HTML', 'url_sldup')."'
>&nbsp;".$i."&nbsp;</a> ";
		}
		else { $GDU_['selection_page'] .= "<span class='".$Block."_tb3'>&nbsp;[".$i."]&nbsp;</span> "; }
		$GDU_['compteur_page']++;
	}
	$GDU_['selection_page'] .= " --</p>\r";
	$Content .= $GDU_['selection_page'];
}

$dbquery = $bts->SDDMObj->query("
SELECT usr.user_id,usr.user_login,user_name,usr.user_last_visit,gr.group_title,usr.user_status 
FROM ".$SqlTableListObj->getSQLTableName('user')." usr, ".$SqlTableListObj->getSQLTableName('group')." gr, ".$SqlTableListObj->getSQLTableName('group_user')." gu, ".$SqlTableListObj->getSQLTableName('group_website')." sg 
".$GDU_['clause_like']."  
ORDER BY user_id, user_login 
LIMIT ".($GDU_['nbr_par_page'] * $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'M_UTILIS_page')).",".$GDU_['nbr_par_page']." 
;");

$GDU_['nbr_par_page_reel'] = $bts->SDDMObj->num_row_sql ( $dbquery );

$T = array();
$i = 1;
$T['AD']['1'][$i]['1']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_1_txt');
$T['AD']['1'][$i]['2']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_2_txt');
$T['AD']['1'][$i]['3']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_3_txt');
$T['AD']['1'][$i]['4']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_4_txt');
$T['AD']['1'][$i]['5']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_5_txt');
$T['AD']['1'][$i]['6']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_6_txt');
while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) { 
	$i++;
// 	if ( $dbp['user_status'] == 2 ) { $trr['tableau'][$i]['c_2_txt'] .= "style='font-style: italic; text-decoration: line-through; font-weight: lighter;'"; }
	$T['AD']['1'][$i]['link'] = "&HydrLink=1"
	.$CurrentSetObj->getInstanceOfServerInfosObj()->getServerInfosEntry('base_url')
	."index.php?"._HYDRLINKURLTAG_."=1"
	."&arti_slug=".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_slug')
	."&arti_ref=".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_ref')
	."&arti_page=2"
	."&formUserMgmt[user_id]="
	.$dbp['user_id']
	;


	$T['AD']['1'][$i]['1']['cont'] = $dbp['user_id'];
	$T['AD']['1'][$i]['2']['cont'] = $dbp['user_login'];
	$T['AD']['1'][$i]['3']['cont'] = $dbp['user_name'];
	// $T['AD']['1'][$i]['3']['cont'] = 
	// "<a class='".$Block."_lien' href='index.php?"
	// ."sw=".$WebSiteObj->getWebSiteEntry('ws_id')
	// ."&l=".$CurrentSetObj->getDataEntry('language')
	// ."&arti_ref=".$CurrentSetObj->getDataSubEntry('article','arti_ref')
	// ."&arti_page=2"
	// ."&formGenericData[mode]=edit"
	// ."&userForm[selectionId]=".$dbp['user_id']
	// ."'>"
	// .$dbp['user_name']
	// ."</a>\r";
	
	$T['AD']['1'][$i]['4']['cont'] = $dbp['group_title'];
	$T['AD']['1'][$i]['4']['tc'] = 1;
	$T['AD']['1'][$i]['5']['cont'] = $bts->I18nTransObj->getI18nTransEntry('status'.$dbp['user_status']);
	$T['AD']['1'][$i]['5']['tc'] = 1;
	$lastVisit = date ("Y M d - H:i:s",$dbp['user_last_visit']);
	$T['AD']['1'][$i]['6']['cont'] = $lastVisit;
	$T['AD']['1'][$i]['6']['tc'] = 1;
}

// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['tab_infos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 15);
$T['ADC']['onglet'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig($i,6,1),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('Template');
$TemplateObj = Template::getInstance();
$Content .= $TemplateObj->renderAdminCreateButton($infos);

// --------------------------------------------------------------------------------------------
$Content .= "
</form>\r

<form ACTION='index.php?' method='post'>\r".
"<table ".$ThemeDataObj->getThemeDataEntry('tab_std_rules')." width='".$ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne')."'>\r
<tr>\r
<td class='".$Block."_fca'>".$bts->I18nTransObj->getI18nTransEntry('table1_1')."</td>\r
<td class='".$Block."_fca'><input type='text' name='filterForm[query_like]' size='15' value='".$bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like')."' class='".$Block."_t3 ".$Block."_form_1'></td>\r
</tr>\r

<tr>\r
<td class='".$Block."_fca'>".$bts->I18nTransObj->getI18nTransEntry('table1_2')."</td>\r
<td class='".$Block."_fca'>";
// Groupe
$userMenuSelect = $CurrentSetObj->getInstanceOfUserObj()->getMenuOptionArray();
$userMenuSelect['group']['name'] = "filterForm[group_id]";
if ( strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'group_id'))>0 && $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'group_id') != 0 ) {
	$userMenuSelect['group']['defaultSelected'] = $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'group_id');	
}
$Content .= $bts->RenderFormObj->renderMenuSelect($userMenuSelect['group']);
$Content .= "
</td>\r
</tr>\r

<tr>\r
<td class='".$Block."_fca'>".$bts->I18nTransObj->getI18nTransEntry('table1_3')."</td>\r
<td class='".$Block."_fca'>
";
// Status
$userMenuSelect['status']['name'] = "filterForm[user_status]";
if ( strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'user_status'))>0 && $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'user_status') != 0 ) { 
	$userMenuSelect['status']['options'][$bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'user_status')]['s'] = " selected "; 
}
$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : userMenuSelect = " . $bts->StringFormatObj->arrayToString($userMenuSelect)));
$Content .= $bts->RenderFormObj->renderMenuSelect($userMenuSelect['status']);


$Content .= "
</td>\r
</tr>\r

<tr>\r
<td class='".$Block."_fca'>".$bts->I18nTransObj->getI18nTransEntry('table1_41')."</td>\r
<td class='".$Block."_fca'><input type='text' name='filterForm[nbrPerPage]' size='2' value='".$GDU_['nbr_par_page']."' class='".$Block."_t3 ".$Block."_form_1'> 
".$bts->I18nTransObj->getI18nTransEntry('table1_42')."
</td>\r
</tr>\r
</table>\r
<br>\r

<table cellpadding='0' cellspacing='0' style='margin-left: auto; margin-right: 0px; '>
<tr>\r
<td>\r
";

$SB = array(
	"id"				=> "refreshButton",
	"type"				=> "submit",
	"initialStyle"		=> $Block."_t3 ".$Block."_submit_s1_n",
	"hoverStyle"		=> $Block."_t3 ".$Block."_submit_s1_h",
	"onclick"			=> "",
	"message"			=> $bts->I18nTransObj->getI18nTransEntry('btnFilter'),
	"mode"				=> 1,
	"size" 				=> 128,
	"lastSize"			=> 0,
);


$Content .= $bts->InteractiveElementsObj->renderSubmitButton($SB);

$Content .= "
</td>\r
</tr>\r
</table>\r
<br>\r

</form>\r
<br>\r
<br>\r
<br>\r
";
/*Hydr-Content-End*/
?>
