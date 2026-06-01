<?php
// @JanusEngine:license-start
// --------------------------------------------------------------------------------------------
// Janus Engine 
//
// This file file is part of the Janus-Engine project.
// @see       : https://github.com/4E71-NOP/JanusEngine
//
// @license   : Creative Commons licence CC-by-nc-sa (https://creativecommons.org/licenses/by-nc-sa/4.0/)
// @author    : Faust MARIA DE AREVALO (original founder) <faust@rootwave.com>
// @copyright : 2005 - ∞ Faust MARIA DE AREVALO
//
// @note      : This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY; 
//              without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
//
// Check README.md for more details
// --------------------------------------------------------------------------------------------
// @JanusEngine:license-end

$bts->I18nTransObj->apply(
	array(
		"type" => "array",
		"eng" => array(
			"inviteErr"		=>	"This website does not allow the use of command console.'",
			"tabTxt1"		=> "Command",
			"tabTxt2"		=> "Logs",
			"tabTxt3"		=> "Help",
			"col_1_txt"		=> "Name",
			"col_2_txt"		=> "Status",
			"col_3_txt"		=> "Date",
			"raf1"			=> "Nothing to display",
			"btnCopy"		=> "Copy command",
			"btnCmd"		=> "Submit command",
			"btnFile"		=> "Submit file",
			"cmd_l1"		=> "Last buffer",
			"cmd_result"	=> "Result from last command",
			"cmd_CmdToExec"	=> "Commande à exécuter",
			"file_select"	=> "Select a file",
			"file_info"		=> "If a file is selected, it will take over the console box. Only the file content will be executed.",
			"help01"		=> "Use '<b>;</b>' as separator.<br>\r
			<br>\r
			Entities are as follow : website, user, group, deadline, document, article, menu, module, decoration, keyword.<br>\r
			<br>\r
			<span style='text-decoration: underline;'>Basic command list:</span>
			<ul>
			<li>show &lt;<i>ENTITIES</i>&gt;; Display the entity list.</li>
			<li>show &lt;<i>ENTITY</i>&gt; name '<i>myEntity</i>'; Display details about this entity.</li>
			</ul>
			",
			"Logs_c1"			=> "N",
			"Logs_c2"			=> "Date",
			"Logs_c3"			=> "Initiator",
			"Logs_c4"			=> "Action",
			"Logs_c5"			=> "Signal",
			"Logs_c6"			=> "Message ID",
			"Logs_c7"			=> "Message",
		),
	)
);
?>