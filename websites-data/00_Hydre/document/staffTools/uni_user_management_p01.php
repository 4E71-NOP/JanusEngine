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
		'nbrPerPage'			=> 5,
		'group_id'				=> 0,
	),
);

/*Hydr-Content-Begin*/
$localisation = " / uni_user_management_p01";
$bts->MapperObj->AddAnotherLevel($localisation );
$bts->LMObj->logCheckpoint("uni_user_management_p01.php");
$bts->MapperObj->RemoveThisLevel($localisation );
$bts->MapperObj->setSqlApplicant("uni_user_management_p01.php");

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"fra" => array(
			"invite1"		=> "Cette partie va vous permettre de gérer les utilisateurs.",
			"col_1_txt"		=> "Login",
			"col_2_txt"		=> "Nom",
			"col_3_txt"		=> "Groupe",
			"col_4_txt"		=> "Statut",
			"col_5_txt"		=> "Dernière visite",
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
		),
		"eng" => array(
			"invite1"		=> "This part will allow you to manage users.",
			"col_1_txt"		=> "Login",
			"col_2_txt"		=> "Name",
			"col_3_txt"		=> "In group",
			"col_4_txt"		=> "Status",
			"col_5_txt"		=> "Last visit",
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
		)
	)
);

$Content .= $bts->I18nTransObj->getI18nTransEntry('invite1')."<br>\r<br>\r";

// --------------------------------------------------------------------------------------------
$GDU_ = array();

$GDU_['nbrPerPage'] = $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'nbrPerPage');
if ($GDU_['nbrPerPage'] < 1 ) { $GDU_['nbrPerPage'] = 10;}
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
$GDU_['clause_like'] .= " ".$clause_sql_element[$clause_sql_element_offset]." gw.fk_ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."' ";	$clause_sql_element_offset++;
$GDU_['clause_like'] .= " ".$clause_sql_element[$clause_sql_element_offset]." gu.fk_user_id = usr.user_id";									$clause_sql_element_offset++;
$GDU_['clause_like'] .= " ".$clause_sql_element[$clause_sql_element_offset]." gw.fk_group_id = gu.fk_group_id ";							$clause_sql_element_offset++;
$GDU_['clause_like'] .= " ".$clause_sql_element[$clause_sql_element_offset]." gu.fk_group_id = gr.group_id ";								$clause_sql_element_offset++;
$GDU_['clause_like'] .= " ".$clause_sql_element[$clause_sql_element_offset]." usr.user_name != 'HydreBDD'";									$clause_sql_element_offset++;


$dbquery = $bts->SDDMObj->query("
SELECT COUNT(usr.user_id) AS mucount 
FROM ".$SqlTableListObj->getSQLTableName('user')." usr, "
.$SqlTableListObj->getSQLTableName('group')." gr, "
.$SqlTableListObj->getSQLTableName('group_user')." gu, "
.$SqlTableListObj->getSQLTableName('group_website')." gw 
".$GDU_['clause_like'].";");
while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) { $GDU_['ItemsCount'] = $dbp['mucount']; }

// --------------------------------------------------------------------------------------------
if ( $GDU_['ItemsCount'] > $GDU_['nbrPerPage'] ) {

	if ( strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like'))>0 )	{$strQuryLike	= "&filterForm[query_like]="	.$bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like');}
	if ( strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'group_id'))>0 ) 	{$strGroupId	= "&filterForm[group_id]="		.$bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'group_id');}
	if ( strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'user_status'))>0 )	{$strUserStatus	= "&filterForm[user_status]="	.$bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'user_status');}
	if ( strlen($bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'nbrPerPage'))>0 )	{$strNbrPerPage	= "&filterForm[nbrPerPage]="	.$bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'nbrPerPage');}

	$ClassLoaderObj->provisionClass('Template');
	$TemplateObj = Template::getInstance();
	$GDU_['link'] = $strQuryLike . $strGroupId . $strUserStatus . $strNbrPerPage;
	$GDU_['elmIn'] = "<div style='display:inline-block; background-color:#00000030; border-radius:0.1cm; border:solid 1px #00000040; padding:0.2cm 0.35cm; margin:0.1cm;'>";
	$GDU_['elmInHighlight'] = "<div style='display:inline-block; background-color:#FFFFFF80; border-radius:0.1cm; border:solid 1px #00000040; padding:0.2cm 0.35cm; margin:0.1cm;'>";
	$GDU_['elmOut'] = "</div>";
	$GDU_['block'] = $Block;
	$GDU_['selectionOffset'] = "".$bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'selectionOffset');
	$Content .= $TemplateObj->renderPageSelector($GDU_);
}

$dbquery = $bts->SDDMObj->query("
SELECT usr.user_id,usr.user_login,user_name,usr.user_last_visit,gr.group_title,usr.user_status 
FROM ".$SqlTableListObj->getSQLTableName('user')." usr, "
.$SqlTableListObj->getSQLTableName('group')." gr, "
.$SqlTableListObj->getSQLTableName('group_user')." gu, "
.$SqlTableListObj->getSQLTableName('group_website')." gw 
".$GDU_['clause_like']."  
ORDER BY user_name, user_login  
LIMIT ".($GDU_['nbrPerPage'] * $bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'selectionOffset')).",".$GDU_['nbrPerPage']." 
;");

$GDU_['realNbrPerPage'] = $bts->SDDMObj->num_row_sql ( $dbquery );

$T = array();
$i = 1;
$T['Content']['1'][$i]['1']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_1_txt');
$T['Content']['1'][$i]['2']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_2_txt');
$T['Content']['1'][$i]['3']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_3_txt');
$T['Content']['1'][$i]['4']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_4_txt');
$T['Content']['1'][$i]['5']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_5_txt');
$T['Content']['1'][$i]['6']['cont']	= $bts->I18nTransObj->getI18nTransEntry('col_6_txt');
while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) { 
	$i++;
// 	if ( $dbp['user_status'] == 2 ) { $trr['tableau'][$i]['c_2_txt'] .= "style='font-style: italic; text-decoration: line-through; font-weight: lighter;'"; }
	$T['Content']['1'][$i]['link'] = "&HydrLink=1"
	.$CurrentSetObj->getInstanceOfServerInfosObj()->getServerInfosEntry('base_url')
	."index.php?"._HYDRLINKURLTAG_."=1"
	."&arti_slug=".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_slug')
	."&arti_ref=".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_ref')
	."&arti_page=2"
	."&formUserMgmt[user_id]="
	.$dbp['user_id']
	;


	$T['Content']['1'][$i]['1']['cont'] = $dbp['user_login'];
	$T['Content']['1'][$i]['2']['cont'] = $dbp['user_name'];
	$T['Content']['1'][$i]['3']['cont'] = $dbp['group_title'];
	$T['Content']['1'][$i]['4']['cont'] = $bts->I18nTransObj->getI18nTransEntry('status'.$dbp['user_status']);
	$lastVisit = ( $dbp['user_last_visit'] != 0 ) ? date ("Y M d - H:i:s",$dbp['user_last_visit']) : "";
	$T['Content']['1'][$i]['5']['cont'] = $lastVisit;
}

// --------------------------------------------------------------------------------------------
//
//	Display
//
//
// --------------------------------------------------------------------------------------------
$T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 15);
$T['ContentCfg']['tabs'] = array(
		1	=>	$bts->RenderTablesObj->getDefaultTableConfig($i,6,1),
);
$Content .= $bts->RenderTablesObj->render($infos, $T);

// --------------------------------------------------------------------------------------------
$Content .= "<br>\r".$TemplateObj->renderAdminCreateButton($infos);

// --------------------------------------------------------------------------------------------
$Content .= "
</form>\r

<form ACTION='index.php?' method='post'>\r".
"<table ".$ThemeDataObj->getThemeDataEntry('tab_std_rules')." style='width:100%'>\r
<tr>\r
<td class='".$Block."_fca'>".$bts->I18nTransObj->getI18nTransEntry('table1_1')."</td>\r
<td class='".$Block."_fca'><input type='text' name='filterForm[query_like]' size='15' value='".$bts->RequestDataObj->getRequestDataSubEntry('filterForm', 'query_like')."' class='".$Block."_t3 ".$Block."_form_1'></td>\r
</tr>\r

<tr>\r
<td class='".$Block."_fca'>".$bts->I18nTransObj->getI18nTransEntry('table1_2')."</td>\r
<td class='".$Block."_fca'>";
// Group
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
<td class='".$Block."_fca'><input type='text' name='filterForm[nbrPerPage]' size='2' value='".$GDU_['nbrPerPage']."' class='".$Block."_t3 ".$Block."_form_1'> 
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
